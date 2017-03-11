<?php
namespace lubrdf\index\model;
use think\Model;
class User extends Model
{	
	protected function initialize(){
		parent::initialize();
	}
	//用户注册时
	protected $insert = ['status' => 1]; 
    
    protected static function init()
    {	
    	//afterInsert 新增前
        User::beforeInsert(function ($user) {

        	$status = User::get(['phone'=>$user->phone]);
        	if(!empty($status)){
        		return false;
        	}
        });
    }
	function login($phone = '', $password = '', $type = '1')
	{	
		$map = array();
		$lubpass = new \lubrdf\common\service\LubPass;
		$phone = $lubpass->authcode($phone,'ENCODE');
		$uinfo = User::get(['phone'=>$phone,'status'=>['in','1']])->toArray();
		/*
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
		$uinfo = $this->db()->where($map)->field('id,username,phone,type,nickname,password,scene,verify,status')->find();*/
		if(is_array($uinfo) && $uinfo['status']){
			/* 验证用户密码 */
			if(hashPassword($password,$uinfo['verify']) === $uinfo['password']){
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
		$lubpass = new \lubrdf\common\service\LubPass;
		/* 记录登录SESSION和COOKIES */
		$user = array(
			'uid'             => $uinfo['id'],
			'phone'			  => $lubpass->authcode($uinfo['phone'],'DECODE'),
			'nickname'        => $uinfo['nickname'],
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
	 *注册
	 */
	function register($name,$phone,$password){
		$verify = genRandomString();
		$lubpass = new \lubrdf\common\service\LubPass;
		//构造写入数组
		$this->data = array(
			'username'  => $verify,
			'nickname'  => $name,
			'phone'		=> $lubpass->authcode($phone,'ENCODE'),
			'email'		=> $phone.'@alizhiyou.com',
			'password'	=> hashPassword($password,$verify),
			'verify'	=> $verify,
			'scene'		=> '6',//非管理场景
			'type'		=> '4',
		);
		return $this->save();
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
				$item_product = array();
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
}