<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 对明文密码，进行加密，返回加密后的密文密码
 * @param string $password 明文密码
 * @param string $verify 认证码
 * @return string 密文密码
 */
function hashPassword($password, $verify = "") {
    return md5($password . md5($verify));
}
//数组转对象
function array2object($array) {
  if (is_array($array)) {
    $obj = new StdClass();
    foreach ($array as $key => $val){
      $obj->$key = $val;
    }
  }
  else { $obj = $array; }
  return $obj;
}
//对象转数组
function object2array($object) {
  if (is_object($object)) {
    foreach ($object as $key => $value) {
      $array[$key] = $value;
    }
  }
  else {
    $array = $object;
  }
  return $array;
}
/**
 * ID加密与解密
 * @param $param 参数
 * @param $type encode 加密  其他为解密
 */
function IdCode($param,$type = ''){
    $xcode = new \Libs\Util\XDeode();
    if($type){
        $return = $xcode->decode($param);
    }else{
        $return = $xcode->encode($param);
    }
    return $return;
}
//通用微信配置读取
function getWechat($wechat_id = null)
{	
	if(empty($wechat_id)){
		return false;
	}
	$info = \lubrdf\index\model\ConfigWechat::get(['id'=>$wechat_id]);
	if(empty($info)){
		return false;
	}
	return $info;
	/*
	$options = array(
	    'token'             =>  '', // 填写你设定的key
	    'appid'             =>  '', // 填写高级调用功能的app id, 请在微信开发模式后台查询
	    'appsecret'         =>  '', // 填写高级调用功能的密钥
	    'encodingaeskey'    =>  '', // 填写加密用的EncodingAESKey（可选，接口传输选择加密时必需）
	    'mch_id'            =>  '', // 微信支付，商户ID（可选）
	    'partnerkey'        =>  '', // 微信支付，密钥（可选）
	    'ssl_cer'           =>  '', // 微信支付，证书cert的路径（可选，操作退款或打款时必需）
	    'ssl_key'           =>  '', // 微信支付，证书key的路径（可选，操作退款或打款时必需）
	    'cachepath'         =>  '', // 设置SDK缓存目录（可选，默认位置在./src/Cache下，请保证写权限）
	);*/
}