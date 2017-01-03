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
/*
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
*/
	'__pattern__'     => array(
		'name' => '\w+',
	),

	'/'               		=> 'index/index/index', // 首页访问路由

	'login'           		=> ['index/login/login',['method' => 'get']],
	'register'        		=> 'index/login/register',
	'putsms'				=> ['index/api/putsms',['method' => 'post']],//发送短信验证码
	'logout'          		=> ['index/login/logout',['method' => 'get']],
	'tologin'				=> ['index/login/tologin',['method' => 'post']],
	'retrieve'				=> 'index/login/retrieve',//忘记密码
	'changepwd'				=>	'index/login/changepwd',//更新密码
	//业务模块
	'cindex'				=>	'index/crm/index',
	'cadd'					=>	'index/crm/add',
	'adcon'					=>	'index/crm/add_contact',
];
