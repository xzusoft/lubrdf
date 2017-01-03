<?php

// +----------------------------------------------------------------------
// | LubTMP
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
// +----------------------------------------------------------------------

namespace Common\Behavior;

use Libs\System\Cache;

defined('THINK_PATH') or exit();

class AppInitBehavior {

    //执行入口
    public function run(&$param) {
        // 注册AUTOLOAD方法
      //  spl_autoload_register('Common\Behavior\AppInitBehavior::autoload');
        //检查是否安装
        $this->richterInstall();
        /* if ($this->richterInstall() == false) {
            redirect('./install.php');
            return false;
        }*/
        //站点初始化
        $this->initialization();
    }

    /**
     * 是否安装检测
     */
    private function richterInstall() {
        //日志目录
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH);
        }
        //TODO 检测是否已授权
        /*$dbHost = C('DB_HOST');
        if (empty($dbHost) && !defined('INSTALL')) {
            return false;
        }*/
        return true;
    }

    //初始化
    private function initialization() {
        /*if (!C('DB_PWD')) {
            return true;
        }*/
        //产品版本号
        define("LUB_VERSION", C("LUB_VERSION"));
        //产品流水号
        define("LUB_BUILD", C("LUB_BUILD"));
        //产品名称
        define("LUB_APPNAME", C("LUB_APPNAME"));
        //MODULE_ALLOW_LIST配置
       // $moduleList = cache('Module');
        $moduleAllowList = array('Manage','Item','Api', 'Order', 'Crm', 'Cron');
        /*
        foreach ($moduleList as $rs) {
            if ($rs['disabled']) {
                $moduleAllowList[] = $rs['module'];
            }
        }*///dump($moduleAllowList);
        C('MODULE_ALLOW_LIST', $moduleAllowList);
    }

    /**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
    static public function autoload($class) {
        //内容模型content_xx.class.php类自动加载
        /*if (in_array($class, array('content_form', 'content_input', 'content_output', 'content_update', 'content_delete'))) {
            D('Content/Content')->model_content_cache();
            $class = RUNTIME_PATH . "{$class}.class.php";
            include $class;
            return;
        }*/
        return;
    }
}