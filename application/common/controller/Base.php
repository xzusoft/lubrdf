<?php
// +----------------------------------------------------------------------
// | LubRDF 通用入口
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace lubrdf\common\controller;
use lubrdf\common\controller\LubRDF;
class Base extends LubRDF
{
	public function _initialize() {
		parent::_initialize();
		if (!is_login() and !in_array($this->url, array('base/login/login', 'base/login/tologin', 'base/login/logout', 'base/login/register'))) {
			echo "string";
			//$this->redirect('base/login/login');
		}
		/*
		if (!in_array($this->url, array('base/login/login', 'base/login/logout', 'base/login/register'))) {

			// 是否是超级管理员
			define('IS_ROOT', is_administrator());
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
			$this->setMeta();
		}
		*/
	}
	
}