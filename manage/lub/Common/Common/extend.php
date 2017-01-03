<?php
// +----------------------------------------------------------------------
// | LubDSS 系统扩展函数
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
    
/**
 * 获取操作员名称  窗口售票
 * @param $param int 操作员ID
 */
function userName($param,$type=NULL){
    if(!empty($param)){
         $name = M('User')->where(array('id'=>$param))->getField('nickname');
         if($type){
            return $name ? $name : "未知";
         }else{
            echo $name;
         }
    }else{
        echo "未知";
    }
}
/**
 * 获取角色名称
 *  @param $param int 角色ID
 */
function roleName($param){
    if(!empty($param)){
        echo M('Role')->where(array('id'=>$param))->getField('name');
    }else{
        echo "角色未知";
    }
}
/**
 * 汉化星期
 */
function get_chinese_weekday($datetime){
    $weekday  = date('w', $datetime);
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    return '星期' . $weeklist[$weekday];
}
/****================================状态=======================================*******/
/*状态码
 * 产品状态（0,1）、计划状态(1，2)、订单状态(0,2,3,4,5,6)
 * 0 禁用    作废
 * 1 可用  未授权
 * 2 售票中 未出票 
 * 3 已出票
 * 4 已过期 
 */
function status($param,$type = null){
    switch ($param) {
        case 0:
            $return = "<span class='label label-danger'>已作废</span>";
            break;
        case 1:
            $return = "<span class='label label-success'>正常</span>";
            break;
        case 9:
            $return = "<span class='label label-default'>完成</span>";
            break;
    }
    if($type){
        return $return;
    }else{
        echo $return;
    }
}

/**==========================================================用于系统内部回调==========================================================================****/
/*####################################报表*/
/*返回当前登录用户*/
function get_user_id(){
    $userid = \Libs\Util\Encrypt::authcode($_SESSION['lub_userid'], 'DECODE');
    return $userid;
}

/*列表时间格式化
@param $param 待处理数据
@param $type 1 时间戳转日期 2日期转时间戳
*/
function datetime($param,$type = '1'){
    if($type == '1'){
        echo date('Y-m-d H:i:s',$param);
    }else{
        return strtotime($param);
    }
}
/**
 * 根据分组ID获取票型分组名称
 */
function groupName($param){
    echo M('UserGroup')->where(array('id'=>$param))->getField('name');
}