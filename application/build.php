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
  

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'api'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['controller', 'model', 'service'],
        'controller' => ['Index', 'Public'],
        'model'      => ['Product','Order','User'],
        'service'    => ['Product','Order','User'],
    ],
    // 其他更多的模块定义
];
