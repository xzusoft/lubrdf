<?php
// +----------------------------------------------------------------------
// | LubTMP 缓存队列
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Manage\Controller;

use Common\Controller\ManageBase;
use Libs\Service\Operate;

class CacheController extends ManageBase{
	function _initialize(){
		parent::_initialize();
	}
 	//缓存更新队列
    function cache(){
    	$this->basePage(Cache,'','id DESC');
    	$this->display();
    }
	//添加
	function add(){
		if(IS_POST){
			$data=I('post.');
			$status=D('Common/Cache')->addCache($data);
			if($status){
				$this->srun('添加成功!', array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
			}
		}else{
			$this->display();	
		}
	}
	//编辑
	function edit(){
		if(IS_POST){
			$data=I('post.');
			if(D('Common/Cache')->save($data) !== false){
				$this->srun('更新成功!', array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
			}else{
				$this->erun('更新失败!');
			}
		}else{
			$id=I('get.id',intval,0);
			$info=M('Cache')->where(array('id'=>$id))->find();
			$this->assign('data',$info);
			$this->display();
		}
	}
	//删除
	function delete(){
		$id=I('get.id');
		if(!empty($id)){
			$is_system = M('Cache')->where(array('id'=>$id))->getField('system');
			if($is_system == '1'){
				$this->erun('系统缓存队列不能删除!');
			}else{
				if(M('Cache')->where(array('id'=>$id,'system'=>0))->delete() !== false){
					$this->srun('删除成功!', array('tabid'=>$this->menuid.MODULE_NAME));
				}else {
					$this->erun('删除失败!');
				}
			}
		}
	}
}
?>