<?php
// +----------------------------------------------------------------------
// | LubRDF 短信发送
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\common\service;
class Sms{

	function sendMsg($data){
		$sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
		$smsConf = array(
			'key'   => '550699cb978b31b33c11ddb3d9a56834', //您申请的APPKEY
		    'mobile'    => $data['phone'], //接受短信的用户手机号码
		    'tpl_id'    => $data['tplid'], //您申请的短信模板ID，根据实际情况修改
		    //'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
		    'tpl_value' =>	$data['content'],
		);
		$status = getHttpContent($sendUrl,'POST',$smsConf);
		if($status){
		    $result = json_decode($status,true);
		    $error_code = $result['error_code'];
		    if($error_code == 0){
		        //状态为0，说明短信发送成功
		        //echo "短信发送成功,短信ID：".$result['result']['sid'];
		        return $result['result']['sid'];
		    }else{
		        //状态非0，说明失败
		        //$msg = $result['reason'];
		        //echo "短信发送失败(".$error_code.")：".$msg;
		        return 0;
		    }
		}else{
		    //返回内容异常，以下可根据业务逻辑自行修改
		    //echo "请求发送短信失败";
		    return 0;
		}
	}
}
