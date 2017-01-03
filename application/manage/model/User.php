<?php
namespace lubrdf\manage\model;
use think\Model;
class User extends Model
{	
	protected function initialize(){
		parent::initialize();
	}
	function login($username = '', $password = '', $type = '1')
	{	
		$map = array();
		if (\think\Validate::is($username,'email')) {
			$type = 2;
		}elseif (preg_match("/^1[34578]{1}\d{9}$/",$username)) {
			$type = 3;
		}
		switch ($type) {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['phone'] = $username;
				break;
			case 4:
				$map['uid'] = $username;
				break;
			default:
				return 0; //参数错误
		}
		$map['status'] = '1';
		$uinfo = $this->db()->where($map)->field('id,username,item_id,type,nickname,password,scene,verify,status')->find()->toArray();
		if(is_array($uinfo) && $uinfo['status']){
			/* 验证用户密码 */
			if($this->hashPassword($password,$uinfo['verify']) === $uinfo['password']){
				$this->autoLogin($uinfo); //更新用户登录信息
				return $uinfo['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
		return empty($uinfo) ? '400' : $uinfo;
	}
	/**
	 * 自动登录用户
	 * 登录后要缓存的信息
	 * 1、用户名、账号
	 * 2、所属的商户信息 及商户权限 商户独立数据库
	 * 3、产品信息
	 * 4、顶级菜单
	 * 5、
	 * @param  integer $user 用户信息数组
	 */
	private function autoLogin($uinfo){
		$last_login_time = time();
		/* 更新登录信息 */
		$data = array(
			'id'              => $uinfo['id'],
			'login'           => array('exp', '`login`+1'),
			'last_login_time' => $last_login_time,
			'last_login_ip'   => get_client_ip(1),
		);
		$this->where(array('id'=>$uinfo['id']))->update($data);
		/* 记录登录SESSION和COOKIES */
		$user = array(
			'uid'             => $uinfo['id'],
			'username'        => $uinfo['username'],
			'last_login_time' => $last_login_time,
			'type'			  => $uinfo['type'],
		);
		$auth = array_merge($user,$this->userType($uinfo));
		$token = get_token($uinfo['id'],genRandomString());
		//生成用户token
		\think\Cookie::set('uid',$token);
		\think\Cache::store('redis')->set($token,$auth);
	}
	/**
	 * 获取用户多维信息
	 */
	private function userType($uinfo){
		/*
		1、判断当前用户类型
		2、根据不同类型用户加载不同必要数据
		1、管理账户2、资源商户3、分销商户4、个人客户
		 */
		switch ($uinfo['type']) {
			case '1':
				$return = array(
					'db' => '',
					);
				break;
			case '2':
				//商户信息
				$item_product = model('Item')->get_item($uinfo['item_id']);
				//产品信息
				$return = array(
					'db' 	=> '',
					'info'	=>	$item_product,
				);
				break;
			case '3':

				//商户信息
				$return = array(
					'info'	=>	$item_product,
				);
				break;
			case '4':
				//个人信息中心
				$return = array(
					'info'	=>	$item_product,
				);
				break;
			default:
				$return = array(
					'info'	=>	'Error type',
				);
				break;
		}
		return $return;
	}
	
	//用户登出
	public function logout(){
		//销毁登录标识
		
		\think\Cache::store('redis')->rm(\think\Cookie::get('uid'));
		\think\Cookie::delete('uid');
	}

	//获取当前用户有权限的顶级菜单
	function get_menu($uinfo){
		//根据用户id获取权限组以及
		
	}
	/**
     * 对明文密码，进行加密，返回加密后的密文密码
     * @param string $password 明文密码
     * @param string $verify 认证码
     * @return string 密文密码
     */
    public function hashPassword($password, $verify = "") {
        return md5($password . md5($verify));
    }
}