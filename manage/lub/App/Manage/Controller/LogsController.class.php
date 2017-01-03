<?php
// +----------------------------------------------------------------------
// | LubTMP 系统日志管理
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Manage\Controller;

use Common\Controller\ManageBase;

class LogsController extends ManageBase {
	//删除一个月前的登陆日志
    public function deleteitemlog() {
        if (D("Manage/Log")->deleteIMonthago()) {
            $this->success("删除操作日志成功！");
        } else {
            $this->error("删除操作日志失败！");
        }
    }
	//登陆日志
    public function loginlog() {
        $where = array();
        $username = I('username');
        $start_time = I('starttime');
        $end_time = I('endtime');
        $loginip = I('loginip');
        $status = I('status');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($username)) {
            $where['username'] = array('like', '%' . $username . '%');
        }
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['logintime'] = array(array('GT', $start_time), array('LT', $end_time), 'AND');
        }
        if (!empty($loginip)) {
            $where['loginip '] = array('like', "%{$loginip}%");
        }
        if ($status != '') {
            $where['status'] = $status;
        }
        $this->basePage('Manage/Loginlog',$where,array("id" => "desc"));
        $this->assign('where', $where)
                ->display();
    }

    //删除一个月前的登陆日志
    public function deleteloginlog() {
        if (D("Manage/Loginlog")->deleteAMonthago()) {
            $this->success("删除登陆日志成功！");
        } else {
            $this->error("删除登陆日志失败！");
        }
    }

    //操作日志查看
    public function index() {
        $uid = I('uid');
        $start_time = I('starttime');
        $end_time = I('endtime');
        $ip = I('ip');
        $status = I('status');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        $where = array();
        if (!empty($uid)) {
            $where['uid'] = array('eq', $uid);
        }
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['time'] = array(array('GT', $start_time), array('LT', $end_time), 'AND');
        }
        if (!empty($ip)) {
            $where['ip '] = array('like', "%{$ip}%");
        }
        if ($status != '') {
            $where['status'] = (int) $status;
        }
        $this->basePage('Manage/Operationlog',$where,array("id" => "desc"));
        $this->assign('where', $where)
                ->display();
    }

    //删除一个月前的操作日志
    public function deletelog() {
        if (D("Manage/Operationlog")->deleteAMonthago()) {
            $this->success("删除操作日志成功！");
        } else {
            $this->error("删除操作日志失败！");
        }
    }
    /*
    *门票打印日志
    */
    function print_log(){
        $where = array();
        $start_time = I('starttime');
        $end_time = I('endtime');
        $type = I('type');
        $user_id = I('user_id');
        $sn = I('sn');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['createtime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if ($type != '') {
            $where['type'] = array('eq', $type);
        }
        if($user_id != ''){
            $where['uid'] = array('in',$user_id);
        }
        if($sn != ''){
            $where['order_sn'] = $sn;
        }       
        $user = M('User')->where(array('status'=>1,'is_scene'=>2))->field('id,nickname')->select();
        $this->basePage('PrintLog',$where,array("id" => "desc"));
        $this->assign('user',$user)
            ->assign('type',$type)
            ->display();
    }
    /**
     * 退票日志
     */
    public function refundlog(){
        $where = array();
        $username = I('username');
        $start_time = I('starttime');
        $end_time = I('endtime');
        $loginip = I('loginip');
        $status = I('status');
        $sn = I('sn');
        if (!empty($username)) {
            $where['username'] = array('like', '%' . $username . '%');
        }
        if(!empty($sn)){
            $where['order_sn'] = $sn;
        }
        $type = I('type');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['createtime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if ($status != '') {
            $where['status'] = array('eq', $status);
        }
        $where['is_scene'] = array('eq', 2);
        
        $this->basePage('Item/TicketRefund',$where,array("id" => "desc"));
        $this->assign('where', $where)->display();
    }
    /*
    * 网银支付日志
    */
    function pay_log(){
        $where = array();
        $start_time = I('starttime');
        $end_time = I('endtime');
        $status = I('status');
        $sn = I('sn');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $where['_string'] = " `create_time` >'$start_time' AND  `create_time`<'$end_time' ";
        }
        if ($status != '') {
            $where['status'] = array('eq', $status);
        }
        if ($sn != '') {
            $where['sn'] = array('eq', $sn);
        }
        $this->basePage('Pay',$where,array("id" => "desc"));
        $this->assign('type',$type)->assign('where', $where)->display();
    }
    /*计划任务执行日志*/
    public function cronlog(){
        $where = array();
        $start_time = I('starttime');
        $end_time = I('endtime');
        $status = I('status');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['performtime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if ($status != '') {
            $where['status'] = array('eq', $status);
        }
        $this->basePage('Cronlog',$where,array("id" => "desc"));
        $this->assign('status',$status)->assign('where', $where)->display();
    }
    /*检票日志*/
    function check_log(){
        $where = array();
        $start_time = I('starttime');
        $end_time = I('endtime');
        $status = I('status');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['datetime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if ($status != '') {
            $where['status'] = array('eq', $status);
        }
        $this->basePage('Checklog',$where,array("id" => "desc"));
        $this->assign('status',$status)->assign('where', $where)->display();
    }
    /*API访问日志*/
    function api_log(){
        $where = array();
        $start_time = I('starttime');
        $end_time = I('endtime');
        $type = I('type');
        $this->assign('starttime',$start_time)->assign('endtime',$end_time);
        if (!empty($start_time) && !empty($end_time)) {
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time) + 86399;
            $where['datetime'] = array(array('EGT', $start_time), array('ELT', $end_time), 'AND');
        }
        if ($type != '') {
            $where['type'] = array('eq', $type);
        }
        $this->basePage('Checklog',$where,array("id" => "desc"));
        $this->assign('type',$type)->assign('where', $where)->display();
    }
}