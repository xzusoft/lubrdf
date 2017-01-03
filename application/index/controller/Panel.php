<?php
// +----------------------------------------------------------------------
// | LubRDF 用户面板
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\controller;
use lubrdf\common\controller\Item;
use think\Request;
use lubrdf\index\model\ConfigWechat;
class Panel extends Item{
	public function _initialize() {
		parent::_initialize();
	}
	//用户面板
	function index(Request $request){
		//获取当前用户所有公众账号
		//$config = M('ConfigWechat')->field('token,appid,appsecret,encodingaeskey,mch_id,partnerkey,ssl_cer,ssl_key,qrc_img')->find();
		$uid = $request->uinfo->uid;
		$list = ConfigWechat::all();
		return $this->fetch();
	}
	//账号授权
	function create_account(){
		if(IS_POST){

		}else{
			//获取参数
			$type = input('get.type');//dump($type);
			$this->assign('type',$type);
			return $this->fetch($type);
		}
	}
	//普通授权信息
	function wechat(Request $request)
	{
		if(IS_POST){
			$param = $request->param();

			dump($param);		
		}else{
			$param = IdCode('1','encode');
			$url = url('Index/Api/api_wechat',['wd'=>$param],'html',true);
			$this->assign('url',$url);
			return $this->fetch();
		}
	}
}
