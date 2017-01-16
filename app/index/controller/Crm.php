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
    public function crm_list(){
        $rows = array(

            );
        $data = array(
            'total' => '300',
            'rows'  =>  $rows,
        );
        return $data;
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
    //操作日志记录
    function actionLog(){
        //谁什么时间操作了什么
    }
    //分日期按场次分渠道商(开启代理商制度统一汇总到所属一级渠道商)按票型汇总
    function today_plan_channel_summary(){
        1、拆分订单
        2、按日期查询汇总归类
        3、写入汇总表

    }
    /**
     * 清道夫 运行在乐游宝平台上，由阿里智游平台按计划执行
     * 1、清理过期作废订单
     * 2、清理过期提醒
     * 3、清理过期的座位表
     * 4、清理过期操作日志
     * 4、递归清理
     * @return [type] [description]
     */
    function sweeper(){
        //清理过期作废的订单 1、待支付的订单 
        //2、
    }
    /**
     * 
     */
}