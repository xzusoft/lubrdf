<?php
// +----------------------------------------------------------------------
// | LubTMP ajax 检测
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Manage\Controller;
use Common\Controller\ManageBase;
class CheckController extends ManageBase{
	protected function _initialize() {//dump($_SESSION);
	 	parent::_initialize();
	 }
	/**
	 * 检测名称是否存在
	 * tb 表名称
	 * mp 条件
	 * na 名称
	 */
	function public_check_name(){
		$ginfo = I('get.');
		if(empty($ginfo['ta'])){
			return false;
		}
		switch ($ginfo['ta']){
			case 11:
				$map = array('nickname'=>$ginfo['nickname']);
				$return = $this->check_name2('User',$map);
				break;
			case 18:
				$map = array('username'=>$ginfo['username']);
				$return = $this->check_name2('User',$map);
				break;
			case 17:
				$map = array('phone'=>$ginfo['phone']);
				$return = $this->check_name2('User',$map);
				$msg = "";
				break;
		}
		if($return == false){
			$this->ajaxReturn(array('ok'=>'ok','state'=>'ok'),json);
		}else{
			$this->ajaxReturn(array('error'=>'系统中存在重复','state'=>'error'),json);
		}
	}
	private function check_name2($table,$map){
		$db = D("$table");
		$status = $db->where($map)->find();
		return $status;
	}
}