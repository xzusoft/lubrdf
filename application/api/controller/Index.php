<?php
namespace lubrdf\api\controller;
use lubrdf\common\controller\Api;
class Index extends Api
{
	public function _initialize() {
		parent::_initialize();
        //验证登录
	}
    public function index()
    {
        return ['LUBRDF'];
    }
    //产品列表
    function lists(){

    }
}
