<?php
// +----------------------------------------------------------------------
// | LubTMP 商户控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Manage\Controller;

use Common\Controller\ManageBase;
class ItemController extends ManageBase {

    protected function _initialize() {
        parent::_initialize();
    }

    //新增商户
    //编辑商户
    //停用商户 删除商户
    //审核商户
    //服务记录
    //商户列表
	function index(){
		$this->basePage('Item','','id DESC');
		$this->display();
	}
	/**
	 * 添加商户
	 */
	function add(){
		if(IS_POST) {
			if(Operate::do_add('Item')){
				$this->srun("添加成功！", array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
			}else{
				$this->erun("添加失败！");
			}
		} else {
			$info = Operate::do_read('Place',1,array('status'=>1));
			$this->assign('place',$info);
			$this->display();
		}	
	}
	/**
	 * 编辑商户
	 */
	function edit(){
		if(IS_POST) {
			if(Operate::do_up('Item')){
				$this->srun("添加成功！", U("Item/index"));
			}else{
				$this->error("添加失败！");
			}
		}else{ echo "ssa";
			$id = I('get.id',0,intval);dump($id);
			if(!empty($id)){
				$data = Operte::do_read('Item',0,array('id'=>$id));
				$this->assign('data',$data);
				$this->display();
			}else{
				$this->error('参数错误');
			}
		}	
	}
	/**
	 * 删除商户
	 */
	function del(){
		$id = I('get.id',0,intval);
		$status = Operate::do_read('Product','0',array('item_id'=>$id));
		if($status){
			$this->error("存在产品，不能直接删除!");
		}
		if(Operate::do_del('Item',array('id'=>$id))){
			$this->srun("删除成功！", array('tabid'=>$this->menuid.MODULE_NAME));
		}else{
			$this->error("删除失败！");
		}
	}
}