<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php', 'config.php', 'database.php','version.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'base'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model',],
        'controller' => ['Index', 'Public'],
        'model'      => ['User'],
    ],
    'manage'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'service', 'view'],
        'controller' => ['Index', 'Public','Menu','Auth','AuthGroup','Product','Item'],
        'model'      => ['User','Menu','Auth','Product'],
        'service'    => ['Login'],
        'view'       => ['index/index','public/login', 'public/register','public/changepwd','menu/index','auth/index'],
    ],
    'crm'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index', 'Member'],
        'model'      => ['Member'],
        'view'       => ['index/index','member/index'],
    ],
    // 其他更多的模块定义
];
