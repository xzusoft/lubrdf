<?php
// +----------------------------------------------------------------------
// | LubTMP  系统扩展函数
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

/*父级会员的层数*/
function f_layer($param){
	$layer = M('User')->where(array('id'=>$param))->getField('layer');
	return $layer;
}

/*
 * 递归遍历 统计下级会员人数 
 * @param $data array
 * @param $id int
 * return array
 * */
function recursion($data, $id=0) {
    $list = array();
    foreach($data as $v) {
        if($v['fid'] == $id) {
            if($v['fid'] <> '0'){
                //读取上级的层数
                $info = M('User')->where(array('id'=>$v['fid']))->getField('layer');
                //写入当前用户的层数
                M('User')->where(array('id'=>$v['id']))->setField('layer',$info+1);
            }
            
        $v['son'] = $this->recursion($data, $v['id']);
        if(empty($v['son'])) {
        unset($v['son']);
        }
        array_push($list, $v);
        }
    }
    return $list;
}
//获取分组
function get_group(){
    $map['status'] = '1';
    $uinfo = \Manage\Service\User::getInstance()->getInfo();
    if($uinfo['id'] <> '1'){
        $map['id'] = array('in',$uinfo['group']);
    }
    $list = M('UserGroup')->where($map)->order('id ASC')->field('id,name')->select();
    return $list;
}

?>