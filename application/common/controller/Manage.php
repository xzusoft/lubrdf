<?php
// +----------------------------------------------------------------------
// | LubRDF 后台文件
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\common\controller;
use lubrdf\common\controller\LubRDF;
class Manage extends LubRDF
{
	//验证登录
	public function _initialize() {
		parent::_initialize();
		/*
		if (!is_login() and !in_array($this->url, array(',manage/login/login', ',manage/login/tologin', ',manage/login/logout', ',manage/login/register'))) {
			$this->redirect('manage/login/login');
		}
		
		if (!in_array($this->url, array(',manage/login/login', ',manage/login/logout', ',manage/login/register'))) {

			// 是否是超级管理员
			define('IS_ROOT', is_administrator());
			/* 检测ip地址黑白名单
			if (!IS_ROOT && \think\Config::get('admin_allow_ip')) {
				// 检查IP地址访问
				if (!in_array(get_client_ip(), explode(',', \think\Config::get('admin_allow_ip')))) {
					$this->error('403:禁止访问');
				}
			}
			
			// 检测系统权限
			if (!IS_ROOT) {
				$access = $this->accessControl();
				if (false === $access) {
					$this->error('403:禁止访问');
				} elseif (null === $access) {
					$dynamic = $this->checkDynamic(); //检测分类栏目有关的各项动态权限
					if ($dynamic === null) {
						//检测访问权限
						if (!$this->checkRule($this->url, array('in', '1,2'))) {
							$this->error('未授权访问!');
						} else {
							// 检测分类及内容有关的各项动态权限
							$dynamic = $this->checkDynamic();
							if (false === $dynamic) {
								$this->error('未授权访问!');
							}
						}
					} elseif ($dynamic === false) {
						$this->error('未授权访问!');
					}
				}
			}
			//菜单设置
			$this->setMenu();
			//$this->setMeta();
		}
		*/
	}
	/**
	 * 权限检测
	 * @param string  $rule    检测的规则
	 * @param string  $mode    check模式
	 * @return boolean
	 * @author 朱亚杰  <xcoolcc@gmail.com>
	 */
	final protected function checkRule($rule, $type = AuthRule::rule_url, $mode = 'url') {
		static $Auth = null;
		if (!$Auth) {
			$Auth = new \com\Auth();
		}
		if (!$Auth->check($rule, session('user_auth.uid'), $type, $mode)) {
			return false;
		}
		return true;
	}

	/**
	 * 检测是否是需要动态判断的权限
	 * @return boolean|null
	 *      返回true则表示当前访问有权限
	 *      返回false则表示当前访问无权限
	 *      返回null，则表示权限不明
	 *
	 * @author 朱亚杰  <xcoolcc@gmail.com>
	 */
	protected function checkDynamic() {
		if (IS_ROOT) {
			return true; //管理员允许访问任何页面
		}
		return null; //不明,需checkRule
	}

	/**
	 * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
	 *
	 * @return boolean|null  返回值必须使用 `===` 进行判断
	 *
	 *   返回 **false**, 不允许任何人访问(超管除外)
	 *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
	 *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
	 * @author 朱亚杰  <xcoolcc@gmail.com>
	 */
	final protected function accessControl() {
		$allow = \think\Config::get('allow_visit');
		$deny  = \think\Config::get('deny_visit');
		$check = strtolower($this->request->controller() . '/' . $this->request->action());
		if (!empty($deny) && in_array_case($check, $deny)) {
			return false; //非超管禁止访问deny中的方法
		}
		if (!empty($allow) && in_array_case($check, $allow)) {
			return true;
		}
		return null; //需要检测节点权限
	}
	/**
	 * 当前用户权限顶级菜单
	 */
	private function setMenu(){
		
	}
}