<?php
// +----------------------------------------------------------------------
// | LubRDF 客户关系管理  验证器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\validate;

use think\Validate;

class Crm extends Validate
{
    protected $rule = [
        'title'  	=>  'require|unique:crm',
        'type'		=>	'require|in:1,2,3',
        'business'	=>	'require|in:1,2,3',
        'category'	=>	'require|in:1,2,3,4,5',

    ];
	protected $message  =   [
        'title.require' => '名称必须',
        'title.unique'  => '客户已存在,请勿重复添加',
        'type.require'	=> '请选择客户属性',
        'business.require'=>'请选择经营属性',
        'category.require'=>'请选择景区类别属性',
        'type.in'	=> '非法请求',
        'business.in'=>'非法请求',
        'category.in'=>'非法请求',
    ];
}
