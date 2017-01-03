<?php
// +----------------------------------------------------------------------
// | LubRDF 用户登录操作
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\controller;
use lubrdf\common\controller\Item;
class Login extends Item{
	public function _initialize() {
		parent::_initialize();
	}
	    //注册
	function register($name = '', $phone = '', $password = '', $verify = ''){
		if(IS_POST){
			//验证验证码
			$verify = session('code');
			if($verify == $verify){
				session('code',null);
			}else{
				return $this->error("验证码错误...");
			}
			$user = model('User');
			if ($user->register($name, $phone, $password)) {
				return $this->success('注册成功!', url('index/login'));
			} else {
				return $this->error('用户已经存在!');
			}
    	}else{
    		return $this->fetch();
    	}
	}
	//登录
	function login(){
		return $this->fetch();
	}
	//验证登录
	public function tologin($phone = '', $password = '', $code = ''){
    	//获取数据 post  数据
    	if(IS_POST){
			if (!$phone || !$password) {
				return $this->error('用户名或者密码不能为空！');
			}
			//验证码验证
			$this->checkVerify($code);
			$user = model('User');
			$uid  = $user->login($phone, $password);
			if ($uid > 0) {
				$this->success('登录成功','index/panel/index');
				//return ['data'=>'','code'=>1,'msg'=>'登录成功','url'=>url('index/index/register')];
			} else {
				switch ($uid) {
					case -1:$error = '用户不存在或被禁用！';
						break; //系统级别禁用
					case -2:$error = '密码错误！';
						break;
					default:$error = '未知错误！';
						break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error, '');
			}
    	}
    }
    //忘记密码
    public function retrieve($phone = '', $password = '', $code = ''){
    	if(IS_POST){

    	}else{
    		return $this->fetch();
    	}
    }

}