<?php
// +----------------------------------------------------------------------
// | LubTMP 系统通用增删改查
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Libs\Service;

class Operate{
	/**
	 * 连接服务
	 * @staticvar \Manage\Service\Cache $systemHandier
	 * @return \Manage\Service\Cache
	 */
	static public function getInstance() {
		static $operate = NULL;
		if (empty($operate)) {
			$operate = new  Operate();
		}
		return $operate;
	}
	/**
	 *通用添加
	 *@param string  $table   表名
	 *@param array  $arr    用于在表单创建以后再添加额外的数据
	 *@param bool $trans 是否将写库过程启用事务  true false 默认为False
	 *@param $transData array 事务数据包
	 */
	public function do_add($table,$arr=null,$trans = false ,$transData = null){
		$db = D("$table");
		if($db->create()){
			if(is_array($arr)){
				foreach ($arr as $key=>$val){
					$db->$key=$val;
				}
			}
		}else{
			return $db->getError();
		}
		if($trans){
			$db->startTrans();//开启事务
			$i =(int)1;
			$status[$i] = $db->add();//主进程
			if($status[$i]){
				//主进程成功之后进行子进程
				$count = count($transData);//子进程的数量
				foreach($transData as $k=>$v){
					if(is_array($v['data'])){
						foreach($v['data'] as $a=>$c){
							$b[$a] = str_replace(replace,$status[$i],$c);//引用上一进程的返回值
							if(is_array($b[$a])){
								$b[$a] = implode(',', $b[$a]);
							}
						}
						$v['data'] = $b;
					}
					if($v['type'] == 'add'){//新增数据
						$status[$i] = D(ucwords($v['table']))->add($v['data']);
					}else{//更新数据
						$status[$i] = D(ucwords($v['table']))->where($v['map'])->save($v['data']);
					}
					if($status[$i] == false){
						//回滚任务
						$db->rollback();
						return false;
					}
					if($count == $k+1){
						$db->commit();//提交事务
						return true;
					}
					$i++;
				}
			}else{
				$db->rollback();
				return false;
			}
		} else {
			$status=$db->add();
			return $status;
		}
	}
	/**
	 *通用更新
	 *@param string  $table   表名
	 *@param array $condition 根据条件更新
	 *@param bool $trans 是否将写库过程启用事务  true false 默认为False
	 *@param $transData array 事务数据包或根据条件更新数据包
	 *$transData=array(
	 *		'type'	=>'add',//'save'
	 *		'table'	=>'',
	 *		'map'	=>array(),
	 *		'data'	=>array(
	 *			'id' => $status,//引用上一进程的返回数据
	 *		),
	 *);
	 */
	public function do_up($table,$condition=null,$trans = false ,$data = null){
		$db = D("$table");
		if($trans){
			if($db->create()){
				$db->startTrans();//开启事务
				$i =(int)1;
				$status[$i]=$db->save();
				if($status[$i]){
					//主进程成功之后进行子进程
					$count = count($data);//子进程的数量
					foreach($data as $k=>$v){
						if(is_array($v['data'])){
							//引用上一进程的返回值
							foreach($v['data'] as $a=>$c){
								$b[$a] = str_replace(replace,$status[$i],$c);
								if(is_array($b[$a])){
									$b[$a] = implode(',', $b[$a]);
								}
							}
							$v['data'] = $b;
						}
						if($v['type'] == 'add'){//新增数据
							$status[$i] = D(ucwords($v['table']))->add($v['data']);
						}else{//更新数据
							$status[$i] = D(ucwords($v['table']))->where($v['map'])->save($v['data']);
						}
						if($status[$i] == false){
							//回滚任务
							$db->rollback();
							return false;
						}
						if($count == $k+1){
							return true;
							$db->commit();//提交事务
						}
						$i++;
					}
				}else{
					$db->rollback();
					return false;
				}
			}else{
				return $db->getError();
			}
		}else{
			if(!empty($condition)){
				$status = $db->where($condition)->save($data);
				return $status;
			}else{
				if($db->create()){
					$status=$db->save();
					return $status;
				}else{
					return $db->getError();
				}
			}
			
		}
		 
	}
	/**
	 *通用删除
	 *@param string  $table   表名
	 *@param array $condition 条件
	 */
	public function do_del($table,$condition){
		$db = M("$table");
		$status=$db->where($condition)->delete();
		return $status;
			
	}
	/**
	 *通用读取
	 *@param string  $table   表名
	 *@param int $is_list 1读取列表0根据ID读取单条
	 *@param array $condition 查询条件
	 *@param array $order 排序
	 *@param array $field 返回的字段
	 *@param string||bool 关联查询  具体参考thinkPHP官方文档
	 */
	public function do_read($table,$is_list=0,$condition=null,$order=null,$field=null,$relation=false){
		$db = D("$table");
		if(!$relation){
			if ($is_list == 1){
				$info = $db->where($condition)->order($order)->field($field)->select();
			} else {
				$info=$db->where($condition)->field($field)->find();
			}
		}else{
			if ($is_list == 1){
				$info = $db->where($condition)->relation($relation)->order($order)->field($field)->select();
			} else {
				$info=$db->where($condition)->relation($relation)->field($field)->find();
			}
		}
		return $info;
	}
	/**
	 * 通用改变状态
	 * @param string  $table   表名
	 * @param array $condition 查询条件
	 * @param int $status 要改变的状态码 通常用status作为状态子弹0代表禁用1代表启用
	 */
	public function do_status($table,$condition,$status){
		$db = D("$table");
		$state = $db->where($condition)->setField('status',$status);
		return $state;
	}
}