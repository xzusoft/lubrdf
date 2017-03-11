<?php
// +----------------------------------------------------------------------
// | LubRDF 加密解密，使用的是OpenSLL 来加密解密
// | 默认使用的加密方式为AES-128-CBC 可通过openssl_get_cipher_methods() 获取更多加密方法
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
namespace lubrdf\common\service;
class LubPass{
	/**
     * 加密解密
     * @param type $string 明文 或 密文  
     * @param type $operation DECODE表示解密,其它表示加密  
     * @param type $key 密匙  
     * @param type $tag 身份验证标记使用AEAD密码时以引用的方式传递模式(GCM或CCM)。
     * @return string 
     */
	public static function authcode($string, $operation = 'DECODE', $key = '', $metoh  = 'AES-128-CBC') {
		$key = md5(($key ? $key : config('AUTHCODE')));
		$iv  = substr($key, 0, 16);
		//加密
		if($operation == 'ENCODE'){
			$result = openssl_encrypt($string,$metoh,$key,false,$iv);
		}
		//对称解密
		if($operation == 'DECODE'){
			$result = openssl_decrypt($string,$metoh,$key,false,$iv);
		}
		return $result;
	}

	//非对称加密
}