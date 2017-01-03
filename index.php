<?php
// +----------------------------------------------------------------------
// | LubRDF 入口文件
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	header("Content-type: text/html; charset=utf-8");
    die('PHP环境不支持，使用本系统需要 PHP > 5.4.0 版本才可以~ !');
}

// 定义应用目录
//define('APP_PATH', __DIR__ . '/application/');
define('APP_PATH', __DIR__ . '/app/');
//开启自动创建
//define('APP_AUTO_BUILD',true);
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
