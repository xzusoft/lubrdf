<?php
namespace lubrdf\base\service;

class Login
{
	//验证登录
	public function check_login($username = '', $password = '')
	{
		//根据用户名检索用户
		$uinfo = model('user')->login($username,$password);
		//校验密码
		if($uinfo != '400'){
			//判断用户类型 1 系统管理员 2、商户员工 3、渠道员工 4、普通会员
			switch ($uinfo['type']) {
				case '1':
					# code...
					break;
				case '2':
					//商户员工  加载商户信息
					break;
				default:
					# code...
					break;
			}
		}else{
			return '4010001';
		}
	}
	
	/**
	 * 生成登录token
	 * @param  int $user_id  用户id
	 * @param  string $password 密码
	 * @return string 
	 */
	function get_token($user_id = '',$password){
		if(empty($user_id) || empty($password)){
			return '4010001';
		}
		$string = uniqid().$user_id.rand().$password;
		$token = md5($string);
		//验证token唯一性
		if(empty(Cache::get($token))){
			Cache::store('redis')->set($token,$user_id);
		}else{
			get_token($user_id,$password);
		}
	}
}