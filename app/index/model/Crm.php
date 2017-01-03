<?php
// +----------------------------------------------------------------------
// | LubRDF 客户关系管理系统 客户模型
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\model;
use think\Model;

class Crm extends Model
{	
	protected function initialize(){
		parent::initialize();
	}
	//用户注册时
	protected $insert = ['status' => 1]; 

}
    