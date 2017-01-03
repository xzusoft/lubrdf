<?php
// +----------------------------------------------------------------------
// | LubTMP 系统Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Common\Controller;

use Manage\Service\User;
use Manage\Service\RBAC;
use Libs\Util\Page;
//定义是系统后台
define('IN_MANAGE', true);

class ManageBase extends LubTMP {

    //初始化
    protected function _initialize() {
        //dump($_SESSION);
        C(array(
            "USER_AUTH_ON" => true, //是否开启权限认证
            "USER_AUTH_TYPE" => 1, //默认认证类型 1 登录认证 2 实时认证
            "REQUIRE_AUTH_MODULE" => "", //需要认证模块
            "NOT_AUTH_MODULE" => "Public", //无需认证模块
            "USER_AUTH_GATEWAY" => U("Manage/Public/login"), //登录地址
        ));//dump(MODULE_NAME);
        if (false == RBAC::AccessDecision(MODULE_NAME)) {
            //检查是否登录
            if (false === RBAC::checkLogin()) {
                //跳转到登录界面
                redirect(C('USER_AUTH_GATEWAY'));
            }
            //没有操作权限
            $this->erun('您没有操作此项的权限11！');
        }
        parent::_initialize();
        //验证登录
        $this->competence();
        //取得所有产品信息
        $this->products = cache('Product');
        
        //设置产品配置信息
        $this->procof = cache('ProConfig');
        //所属公司及当前产品设置
        $this->pid = \Libs\Util\Encrypt::authcode($_SESSION['lub_proId'], 'DECODE');
        $this->itemid = \Libs\Util\Encrypt::authcode($_SESSION['lub_imid'], 'DECODE');
        //取得当前产品信息
        $this->product = $this->products[$this->pid];
        

        //dump($this->product);
        //绑定URl参数
        $this->menuid = I('request.menuid');
        $this->assign('menuid',$this->menuid);
        $this->assign('product',$this->product);
        $this->assign('USER_INFO', json_encode(senuInfo(User::getInstance()->getInfo())));
        $this->assign('PRODUCT_CONF',json_encode($this->procof));
    }

    /**
     * 验证登录
     * @return boolean
     */
    private function competence() {
        //检查是否登录
        $uid = (int) User::getInstance()->isLogin();
        if (empty($uid)) {
            return false;
        }
        //获取当前登录用户信息
        $userInfo = User::getInstance()->getInfo();
        if (empty($userInfo)) {
            User::getInstance()->logout();
            return false;
        }
        //是否锁定
        if (!$userInfo['status']) {
            User::getInstance()->logout();
            $this->erun('您的帐号已经被锁定！');
            return false;
        }
        return $userInfo;
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    final public function error($message = '', $jumpUrl = '', $ajax = false) {
        D('Manage/Operationlog')->record($message, 0);
        parent::error($message, $jumpUrl, $ajax);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    final public function success($message = '', $jumpUrl = '', $ajax = false) {
        D('Manage/Operationlog')->record($message, 1);
        parent::success($message, $jumpUrl, $ajax);
    }
   
}