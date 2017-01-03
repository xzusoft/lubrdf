<?php
// +----------------------------------------------------------------------
// | LubRDF 公共接口控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\base\controller;
use lubrdf\common\controller\LubRDF;
class Sns extends LubRDF{
	public function _initialize() {
		parent::_initialize();
		//获取商户参数、必须参数
		$param = IdCode(input('get.wd'),'decode');
	}
	//读取话题列表
	function lists(){
		
	}
}