<?php
// +----------------------------------------------------------------------
// | LubRDF 公共控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\manage\controller;
use lubrdf\common\controller\LubRDF;
class Login extends LubRDF
{
	public function _initialize() {
		parent::_initialize();
	}
	function index(){
		return $this->fetch();
	}
	/**
     * 用户登录
     */
    public function login(){
        //判断是否已经登录 获取Cookice
        if(is_login()){
            $this->redirect(url('index/degree'));
        }
        return $this->fetch();
    }
    /**
     * 验证登录
     * @return [type] [description]
     */
    public function tologin($username = '', $password = '', $verify = ''){
    	//获取数据 post  数据
    	if(IS_POST){
			if (!$username || !$password) {
				return $this->error('用户名或者密码不能为空！', '');
			}
			//验证码验证
			$this->checkVerify($verify);
			$user = model('User');
			$uid  = $user->login($username, $password);
			if ($uid > 0) {
				return $this->success('登录成功！', url('index/degree'));
			} else {
				switch ($uid) {
				case -1:$error = '用户不存在或被禁用！';
					break; //系统级别禁用
				case -2:$error = '密码错误！';
					break;
				default:$error = '未知错误！';
					break; // 0-接口参数错误（调试阶段使用）
				}
				return $this->error($error, '');
			}
    	}
    }
    /**
     * 用户注册
     * 注册用户分为个人客户和企业客户
     * 1、注册完成后默认为普通客户（普通会员消费）
     * 2、身份认证完毕之后升级为认证客户(身份证+手持身份证照片)
     * 3、企业客户需要上传企业营业执照和统一社会信用代码
     * @return [type] [description]
     */
    public function register()
    {	
        if(IS_POST){
            
        
        }else{
           return $this->fetch(); 
        }
    }
    /**
     * 退出登录
     */
    public function logout(){
        $user = model('User');
        $user->logout();
        $this->redirect('login/login');
    }

}