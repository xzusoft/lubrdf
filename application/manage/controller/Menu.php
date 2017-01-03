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
class Menu extends Manage
{
	public function _initialize() {
		parent::_initialize();
        //验证登录
	}
	/**
	 * 菜单列表
	 * @return [type] [description]
	 */
	function index(){
		$data = ['name' => 'thinkphp', 'status' => '1'];
        return json($data, 201, ['Cache-control' => 'no-cache,must-revalidate']);
	}
	
}