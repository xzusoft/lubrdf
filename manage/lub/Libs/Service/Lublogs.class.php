<?php
// +----------------------------------------------------------------------
// | LubTMP 日志记录
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Libs\Service;
class Lublogs extends \Libs\System\Service {
	/*短信发送本地记录
	* @param $phone 目标号码
	* @param $content 短信内容
	* @param $status 短信发送状态
	* @param $type 短信类型
	*/
	function local_sms($phone,$content,$status,$type,$order_sn = '0'){
		$db = M('SmsLog');
		if(!empty($order_sn)){
			$num = $db->where(array('order_sn'=>$order_sn))->getField('num');
		}
		$db->add(array(
			'order_sn'=>$order_sn,
			'phone' => $phone,
			'content'=>$content,
			'status'=>$status,
			'type'=>$type,
			'createtime'=>time(),
			'num'=>$num ? $num : 1,	
			));
		return true;
	}
}