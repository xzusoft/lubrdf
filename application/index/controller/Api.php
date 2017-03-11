<?php
// +----------------------------------------------------------------------
// | LubRDF 公共接口控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\index\controller;
use lubrdf\common\controller\LubRDF;
use \think\Cache;
class Api extends LubRDF{
	public function _initialize() {
		parent::_initialize();
        //验证接口调用权限
        if(!$this->isApi()){
        	return ['status'=>0,'info'=>'参数错误'];
       	}
	}
	//验证API访问权限
	function isApi(){
		//获取来路域名
		$url   = $_SERVER["HTTP_REFERER"];   //获取完整的来路URL
		$str   = str_replace("https://","",$url);  //去掉https://
		$strdomain = explode("/",$str);               // 以“/”分开成数组
		$domain    = $strdomain[0];              //取第一个“/”以前的字符
		//TODO 验证写死
		if($domain != 'www.alizhiyou.com' || $domain != 'new.leubao.com'){
			return false;
		}else{
			return 200;
		}
		//判断两次操作时间间隔
	}
	//发送短信验证码
	function putsms(){
		if(IS_POST){
			$phone = input('post.phone');
			$type  = input('post.type');
			if(empty($phone)){
				return ['status'=>0,'info'=>'参数错误'];
			}
			$code = genRandomString(6,1);
			Cache::store('redis')->set($phone.'code',$code);
			//存储验证码 有效期10分钟
			load_redis('setex',$phone.'code',$code,'600');
			//类型
			switch ($type) {
				case '1':
					//注册
					$check_account = $this->check_account($phone,'');
					if($check_account['status'] == '1'){
						$putdata = array(
							'phone'		=>	$phone,
							'content'	=> '#app#='.$this->config['sms_platform'].'&#code#='.$code.'&#company#='.$this->config['sms_suffix'],
							'tplid'		=>	'25704',
						);
					}else{
						$return = $check_account;
					}
					break;
				case '2':
					//找回密码
					$putdata = array(
						'phone'		=>	$phone,
						'content'	=> '#code#='.$code.'&#company#='.$this->config['sms_suffix'],
						'tplid'		=>	'25705',
					);
					break;
			}
			if(!empty($return)){
				return $return;
			}
			//return ['status'=>1,'info'=>'ok'];
			$sms = new \lubrdf\common\service\Sms;
			if($sms->sendMsg($putdata)){
				return ['status'=>1,'info'=>'ok'];
			}else{
				return ['status'=>0,'info'=>'发送失败'];
			}
		}
	}
	//判断是否已经注册过
	function check_account($phone = ' ',$gettime = ' '){
		//获取数据
		if(empty($phone)){
			return ['status'=>0,'info'=>'参数错误'];
		}
		$lubpass = new \lubrdf\common\service\LubPass;
		//组织条件
		$m_phone = $lubpass->authcode($phone,'DECODE');
		$status = db('user')->where(['phone'=>$m_phone])->find();
		if($status){
			return ['status'=>0,'info'=>'手机号已被注册'];
		}else{
			return ['status'=>1,'info'=>'ok'];
		}
	}
	//判断短时间内的重复操作 TODO
	function is_time(){

	}
	//微信接口认证
	function api_wechat($wd = null){
		if(empty($wd)){
			return ['code'=>'0','msg'=>'认证失败'];
		}
		//拉取配置
		$options = getWechat($wd);
		if($options){
			$WxServer = & \Wechat\Loader::get('WechatService',$options);
			$msg = "乐游宝软件欢迎您!电话18631451216";
			$WxServer->reply($msg);
		}else{
			return ['code'=>'0','msg'=>'认证失败'];
		}
	}
	//开发阶段重置缓存
	function reset_cache(){
		//删除缓存
		Cache::store('redis')->rm('sys_config');
		//生成缓存
		$config = model('Config')->lists();
		Cache::store('redis')->set('sys_config', $config);
		return ['code'=>'1','msg'=>'ok'];
	}
}