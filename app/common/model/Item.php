<?php
namespace lubrdf\common\model;


class Item extends LubRDF
{
	//获取商户信息
	function get_item($map = null,$type = null){
		if(empty($map)){
			return false;
		}
		$info = $this->where($map)->find();
		return $info;
	}
}