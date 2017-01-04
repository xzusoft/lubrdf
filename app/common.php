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
  }else { $obj = $array; }
  return $obj;
}
//对象转数组
function object2array($object) {
  if (is_object($object)) {
    foreach ($object as $key => $value) {
      $array[$key] = $value;
    }
  }else {
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
    $xcode = new \lubrdf\common\service\XDeode();
    if($type){
        $return = $xcode->decode($param);
    }else{
        $return = $xcode->encode($param);
    }
    return $return;
}