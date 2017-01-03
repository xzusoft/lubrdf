<?php
// +----------------------------------------------------------------------
// | LubRDF 系统基础文件
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\common\controller;
use \think\Cache;
use \think\Cookie;
use \think\Request;
class LubRDF extends \think\Controller {

	public function _initialize() {
		/* 读取数据库中的配置 */
		$this->config = Cache::store('redis')->get('sys_config');
		if (!$this->config) {
			$config = model('Config')->lists();
			Cache::store('redis')->set('sys_config', $config);
		}
		//config('config',$config);
		//$config = array();
		$this->requestInfo();
		$this->assign('config',$this->config);
		$this->assign('global',json_encode($this->setConfig($this->config)));
	}
	/**
	 * 系统配置文件
	 */
	function setConfig($config){
		$global = array(
			'print' =>	'1',
			'cssjs'	=>	$config['cssjs'],
			'website'	=>	$config['website'],
		);
		return $global;
	}
	/**
	 * 检测验证码
	 * @param  integer $id 验证码ID
	 * @return boolean     检测结果
	 */
	public function checkVerify($code='') {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
           return true;
        }
    }
	//request信息
	protected function requestInfo() {
		$this->param = $this->request->param();
		defined('MODULE_NAME') or define('MODULE_NAME', $this->request->module());
		defined('CONTROLLER_NAME') or define('CONTROLLER_NAME', $this->request->controller());
		defined('ACTION_NAME') or define('ACTION_NAME', $this->request->action());
		defined('IS_POST') or define('IS_POST', $this->request->isPost());
		defined('IS_GET') or define('IS_GET', $this->request->isGet());
		$this->url = strtolower($this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action());
		$this->assign('request', $this->request);
		$this->assign('param', $this->param);
	}
	/**
	 * 通用数据拉取
	 */
	function getList($table,$where = null, $order = 'id DESC', $field = null, $page = 1, $limit = 25, $count = '100000'){
		if(empty($table)){
			return false;
		}
		if(is_null($where)){

		}
		if(is_null($field)){

		}
		$list = model($table)->where($where)->field($field)->paginate($limit,$count);
		// 获取分页显示
		$page = $list->render();
		
	}
}