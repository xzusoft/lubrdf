<?php
// +----------------------------------------------------------------------
// | LubRDF 前台控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\controller;
use lubrdf\common\controller\LubRDF;
class Index extends LubRDF
{
	public function _initialize() {
		parent::_initialize();
	}
    public function index()
    {   
        $this->assign('today',time());
    	return $this->fetch();
    }
    //注销
    function logout(){
    	$user = model('User');
        $user->logout();
        $this->redirect('index/login/login');
    }
    //
    function team(){

    }
}
