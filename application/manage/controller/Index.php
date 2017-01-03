<?php
// +----------------------------------------------------------------------
// | LubRDF 公共控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\manage\controller;
use lubrdf\common\controller\Manage;
class Index extends Manage
{
	public function _initialize() {
		parent::_initialize();
        //验证登录
	}

    public function index(){
        /**/
    	$url['login'] = url('manage/login/login','','','www.alizhiyou.com');
        $url['register'] = url('manage/login/register','','','www.alizhiyou.com');
        $url['logout'] = url('manage/login/logout','','','www.alizhiyou.com');
    	$this->assign('url',$url);
        return $this->fetch();
    }
    /**
     * 页面过渡
     */
    public function degree(){
        //判断传递过来的密钥  
        //获取用户类型
        //根据用户加载配置文件
        $this->assign('url',url('manage/index/index'));
        return $this->fetch();
    }
    /**
     * 用户信息维护
     * @return 
     */
    function checkSign(){}
}