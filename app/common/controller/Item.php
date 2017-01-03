<?php
// +----------------------------------------------------------------------
// | LubRDF 商户管理通用入口
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\common\controller;
use lubrdf\common\controller\LubRDF;
use think\Request;
class Item extends LubRDF
{
	public function _initialize() {
		parent::_initialize();
		//动态绑定属性
		$uinfo = is_login();
        Request::instance()->bind('uinfo',array2object($uinfo));
		//判断登录
		if(!$uinfo['uid'] && !in_array($this->url, array('index/login/login', 'index/login/tologin', 'index/login/logout', 'index/login/register','index/login/retrieve'))){
			$this->redirect('index/login/login');
		}
		if($uinfo['uid'] && in_array($this->url, array('index/login/login', 'index/login/tologin', 'index/login/register'))){
			$this->redirect('index/crm/index');
		}
		$this->assign('uinfo',$uinfo);
	}
	/**
	 * 商户管理目录配置信息初始化
	 */
	function itemInit(){
		//验证登录
		//获取当前用户对应配置信息
		//切换数据库
		Config::set([
		    // 数据库类型
		    'type'           => 'mysql',
		    // 服务器地址
		    'hostname'       => 'localhost',
		    // 数据库名
		    'database'       => 'tp5',
		    // 用户名
		    'username'       => 'root',
		    // 密码
		    'password'       => 'youban.ren',
		    // 端口
		    'hostport'       => '3306',
		]);
	}
	
}