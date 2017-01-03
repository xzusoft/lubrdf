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
use think\Loader;
class Crm extends Item{

	public function _initialize() {
		parent::_initialize();
	}
    public function index()
    {   
    	return $this->fetch();
    }
    //新增客户资料
    function add(Request $request)
    {
    	if(IS_POST){
            $param = $request->param();
            $model = model('Crm');
            if(empty($param['id'])){
                $validate = Loader::validate('Crm');
                if(!$validate->check($param)){
                    $this->error($validate->getError());
                }else{
                    $model->validate(true)->allowField(true)->save($param);
                    if($model->id){
                        $this->success('新增成功!', url('index/crm/add_contact',['cid'=>IdCode($model->id)]));
                    }else{

                    }
                }
            }
            if(!empty($param['id'])){

            }
            dump($param);
    	}else{
            return $this->fetch();
    	}
    }
    //新增维护记录
    function add_contact(Request $request)
    {
        if(IS_POST){

        }else{
            $this->assign('crm_id',$request->id);
            return $this->fetch(); 
       }
    }
}