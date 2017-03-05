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
	'logout'          		=> ['index/login/logout',['method' => 'get']],
	'tologin'				=> ['index/login/tologin',['method' => 'post']],
	'retrieve'				=> 'index/login/retrieve',//忘记密码
	'putsms'				=> ['index/api/putsms',['method' => 'post']],//发送短信验证码
	'panel'					=> 'index/panel/index',//用户面板
	'create_account'		=> 'index/panel/create_account',//新增公众账号
	'wechat'				=>	'index/panel/wechat',//普通新增公众号
	'check_account'			=> ['index/api/check_account',['method' => 'post']],//可用性验证

	'api_wechat/[:wd]'		=>	'index/api/api_wechat',//api 微信认证 必须传递微信id

	'manage/index/degree' 	=> 'degree',//商户跳转页面
	'manage/index/index'	=> 'manage/index'
	//业务模块
];
