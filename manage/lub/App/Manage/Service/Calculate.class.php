<?php
// +----------------------------------------------------------------------
// | LubTMP 奖金计算服务
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Manage\Service;

use Manage\Service\Calculate;

class Calculate {
	/**
     * 更新会员左右区人数
     * @param  array $minfo  需要更新的会员数据
     * @return [type]        [description]
     */
    function up_lr_num($minfo){
        $list = M('User')->where(array('group_id'=>$minfo['group_id']))->cache(120)->field('id,nickname,layer,fid,createtime,status')->order('id DESC,layer DESC')->select();
        
        $rootree = getRootTree($list,$minfo['id']);
        foreach ($rootree as $key => $value) {
            $sort[$value['layer']] = $value['layer'];
        }
        //获取路径集合id
        $ids = arr2string($rootree,'id');
        //缓存路径集合
        $dlist = $rootree;
        //按照层数从小到大排序
        array_multisort($sort,SORT_ASC,$rootree); 
        foreach ($rootree as $key => $value) {
            //分左右区
            $info = M("User")->where(array('fid'=>$value['id'],'id'=>array('not in',$ids)))->field('id,nickname,layer,fid,createtime,status')->find();
            if(empty($info)){
                //左侧
                $left[] = $value['id'];
            }else{
                $hinfo = $dlist[$info['fid']];
                if($hinfo['id'] < $info['id']){
                    //左侧
                    $left[] = $value['id'];
                }else{
                    //右侧
                    $right[] = $value['id'];
                }
            }   
        }
        //删除自己
        array_pop($left);
        //更新系统中左右区的人数
        $l_updata = array('l_num' => array('exp','l_num+1'),'update_time' => time());
        $l_status = M('UserData')->where(array('user_id'=>array('in',implode(',',$left))))->setField($l_updata);
        $r_updata = array('r_num' => array('exp','r_num+1'),'update_time' => time());
        $r_status = M('UserData')->where(array('user_id'=>array('in',implode(',',$right))))->setField($r_updata);
        if($l_status && $r_status){
            return true;
        }else{
            error_insert('400019');
            return false;
        }
    }
	/*计算层奖金
	* @param $info array 用户数据
	* @param $datetime int 结算日期 
	*/
	function layers($info,$datetime){
		$db = M('User');
		$dbs = M('Bonus');
		if(empty($info['layer'])){
			//第0层不计算
			return true;
		}else{
			//判断当前客户的上级客户是否获得当前层的层奖
			$bonus = Calculate::take_prize($info['fid'],$info['layer'],$info['group_id'],1);
			if(empty($bonus)){
				//未获得
				Calculate::insert_prize($info,1,$datetime);
				//从爷爷级开始计算 
				Calculate::ring_layers($info['fid'],$info['id'],$info['layer'],$datetime);
			}
			return true;
		}
	}
	//最新曾强计算
	function ring_layers($mfid,$userid,$layer,$datetime){
		$db = M('User');
		//查询当前客户的爷爷级的id
		$fminfo = $db->where(array('id'=>$mfid))->field('id,nickname,fid,layer,group_id')->find();
		//查询父亲存在兄弟
		if(count(if_brother($fminfo['fid'],$fminfo['group_id'])) > 1){
			//只有父亲存在兄弟的时候爷爷才会存在左右两区 
			//写入爷爷级别在该层的层奖金  允许夸一层拿奖
			$bonus = Calculate::take_prize($fminfo['fid'],$layer,$fminfo['group_id'],1);
			if(!$bonus){
				//爷爷未拿到层奖
				$prize_data = array(
					'fid' 		=>	$fminfo['fid'],
					'group_id'	=>	$fminfo['group_id'],
					'id'		=>	$userid,//奖金触发人(新增用户id)
					'layer'		=>	$layer,
				);
				Calculate::insert_prize($prize_data,1,$datetime);
			}
		}
		//获取从爷爷级开始获取到根节点的路径
		$list = $db->where(array('group_id'=>$fminfo['group_id']))->field('id,nickname,layer,fid,createtime,group_id,status')->cache(120)->select();
        $rootree = getRootTree($list,$fminfo['fid']);
        //获取节点集合
        $rootree_id = explode(',',arr2string($rootree,'id'));
        //dump($rootree_id);
		foreach ($rootree as $key => $value) {
			//判断是否有兄弟
			$brother = if_brother($value['id'],$value['group_id']);
			//dump($value);
			if(count($brother) > 1){
				//查询是否已经获奖
				$bonus[$key] = Calculate::take_prize($value['id'],$layer,$value['group_id'],1);
				if(!$bonus[$key]){
					//确定要获取左树还是有树
					//判断当前用户的子节点与新增节点的关系，得到是与新增用户到根路径的id 集合有关系的
					$ids = explode(',',arr2string($brother,'id'));
					foreach ($ids as $k => $v) {
						if(in_array($v,$rootree_id)){
							//取得当前节点到根节点路径集中的id,
							$s_id = $v;
						}
					}

					//取得id大的用户 小id为左分区  大id为右分区
			        $pos = array_search(max($ids), $ids);
			        $maxid = $ids[$pos];
			        //获取当前子集的最大层数 当前用户属于新增用户到根节点的路径集中时，获取另一侧的子树
					if($s_id == $maxid){
						//新增节点位于当前会员的右侧，此时查询当前会员的左侧最大层数
						//左
						$son_tree = Calculate::l_r_count($value['id'],$value['layer'],$value['group_id'],1);
					}else{
						//获取右子树
						$son_tree = Calculate::l_r_count($value['id'],$value['layer'],$value['group_id'],2);
					}
					//子树不能为空
					if(!empty($son_tree)){
						//判断层数是否大于或等于新增用户的层数
						$if_layer = Calculate::son_max_layer($son_tree);
						if($if_layer+1 >= $layer){
							$prize_data = array(
								'fid' 		=>	$value['id'],
								'group_id'	=>	$value['group_id'],
								'id'		=>	$userid,//奖金触发人(新增用户id)
								'layer'		=>	$layer,
							);
							Calculate::insert_prize($prize_data,1,$datetime);
						}
					}
				}
			}
		}
		//循环判断是否具备条件拿奖
	}

	function check_prize($fminfo,$layer,$poor){
		//判断是否已经获得该层奖
		$bonus = Calculate::take_prize($fminfo['id'],$fminfo['layer'],$fminfo['group_id'],1);
	}

	/*递归计算 层奖
	* @param $mfid 父级IDd
	* @param $userid  新增用户的id
	* @param $layer 新增用户的层数 
	* @param $datetime 结算日期
	
	function ring_layers($mfid,$userid,$layer,$datetime){
		$db = M('User');
		//查询当前客户的爷爷级的id
		$fminfo = $db->where(array('id'=>$mfid))->field('id,nickname,fid,layer,group_id')->find();
		//计算层差
		if(!empty($fminfo['fid'])){
			$layer_poor = $layer - $fminfo['layer'];
			$check_prize = Calculate::check_prize($fminfo,$layer,$layer_poor);
			switch ($check_prize) {
				case '1':
					//已获层奖//递归查询
					Calculate::ring_layers($fminfo['fid'],$userid,$layer,$datetime);
					break;
				case '2':
					//未获层奖
					$prize_data = array(
						'fid' 		=>	$fminfo['id'],
						'group_id'	=>	$fminfo['group_id'],
						'id'		=>	$userid,//奖金触发人(新增用户id)
						'layer'		=>	$layer,
					);
					Calculate::insert_prize($prize_data,1,$datetime);
					//递归查询
					Calculate::ring_layers($fminfo['fid'],$userid,$layer,$datetime);
					break;
			}
		}
	}
	/**
	 * 判断用户是否可以拿奖
	 * @param $fminfo array 要判断的用户数据包
	 * @param $layer int  新增用户的层数
	 * @param $poor int 层差
	function check_prize($fminfo,$layer,$poor){
		//判断是否已经取得奖金
		
		/**
		 * 1、它的下级必须获得该层层奖
		 * 2、自己本身左右区满员
		 * 3、拿奖线外的另一条线的下一层必须存在至少一个会员
		 
		$bonus = Calculate::take_prize($fminfo['id'],$fminfo['layer'],$fminfo['group_id'],1);
		if(!empty($bonus)){
			return 1;
		}else{
			$db = M('User');
			//层差大于2
			if($poor >= 2){
				//查找相同父级的人 存在父级拿到该层的层奖
				$f_user = $db->where(array('fid'=>$fminfo['id']))->count();
				if($f_user == 2){

					//计算满树的会员数 不包含自身
					$m_count = pow(2,$poor)-1;
					//统计当前会员实际子节点数量(统计层数小于当前新增客户的层数)
					$m_c_count = Calculate::get_count_list($fminfo['layer'],$layer,$fminfo['id'],$fminfo['group_id']);
					
					if($m_c_count == $m_count){
						return 2;
					}else{
						return 0;
					}
				}else{
					return 0;
				}
			}else{
				return 1;
			}
		}
		/*根据层差设定循环次数
		for ($i=1; $i < $poor; $i++) { 
			$bonus = Calculate::take_prize($fminfo['id'],$fminfo['layer'],$fminfo['group_id'],1);
			if(!empty($bonus)){
				return false;
			}else{
				//查找相同父级的人 存在父级拿到该层的层奖
				$f_user = $db->where(array('fid'=>$fminfo['id']))->count();
				if($f_user == 2){
					return true;
				}else{
					return false;
				}
			} 
		}	
	}*/
	/**
	 * 获取指定用户的左右子树
	 * @param  array $minfo 要查询的用户
	 * @param  int $area  要获取的区域 1左子树 2右子树
	 * @return [type]        [description]
	 */
	function l_r_tree($minfo,$area){
		$list = M('User')->where(array('group_id'=>$minfo['group_id']))->field('id,nickname,layer,fid,createtime,status,group_id')->select();
        $rootree = getRootTree($list,$minfo['id']);
        foreach ($rootree as $key => $value) {
            $sort[$value['layer']] = $value['layer'];
        }
        //获取路径集合id
        $ids = arr2string($rootree,'id');
        //缓存路径集合
        $dlist = $rootree;
        //按照层数从小到大排序
        array_multisort($sort,SORT_ASC,$rootree);
        //dump($rootree);
        foreach ($rootree as $key => $value) {
            //分左右区
            $info = M("User")->where(array('fid'=>$value['id'],'id'=>array('not in',$ids)))->field('id,nickname,layer,fid,createtime,status,group_id')->find();
            if(empty($info)){
                //左侧
                $left[] = $value;
            }else{
                $hinfo = $dlist[$info['fid']];
                if($hinfo['id'] < $info['id']){
                    //左侧
                    $left[] = $value;
                }else{
                    //右侧
                    $right[] = $value;
                }
            }   
        }
        switch ($area) {
        	case '1':
        		return $left;
        		break;
        	case '2':
        		return $right;
        		break;
        }
	}

    //查询指定节点的左右区人数
    function l_r_count($root,$layer,$group_id,$type){
        //查询直接子客户
        $child_mem = M('User')->where(array('fid'=>$root))->cache(60)->field('id,fid,nickname,layer')->select();
        //是否存在子集
        if(!empty($child_mem)){
            $map = array(
                'layer' => array('egt',$layer-1),
                'group_id' => $group_id,
            );
            $list = M('User')->where($map)->field('id,nickname,layer,fid')->cache(60)->order('layer DESC')->select();
            //判断子集数量
            if(count($child_mem) == '1'){
                $child_mem_left = $child_mem[0];
                //获取左子树 
                $child_left = Calculate::child_tree($list,$child_mem_left['id']);
            }else{
                //设定左右子书的根节点
                if($child_mem[0]['id'] < $child_mem[1]['id']){
                    $child_mem_left = $child_mem[0];
                    $child_mem_right = $child_mem[1];
                }else{
                	$child_mem_left = $child_mem[1];
                    $child_mem_right = $child_mem[0];
                }
                $child_left = Calculate::child_tree($list,$child_mem_left['id']);
                $child_right = Calculate::child_tree($list,$child_mem_right['id']);
            }
           	if($type == '1'){
           		return $child_left;
           	}else{
           		return $child_right;
           	}
        }else{
        	return '0';
        }
    }

    /**
     * 获取子树
     * @param  array $list 数据
     * @param  int $root 根节点
     * @return array
     */
    function child_tree($list,$root){
        $data = D('Manage/Tree')->toFormatTree($list,'nickname','id','fid',$root);
        return $data;
    }
























	/**
	 * 获取当前用户的所有子用户中最大层数
	 * @param  array $list 要查询的用户集合
	 * @param  int $area  要查询的区 1 左 2右
	 * @return [type]        [description]
	 */
	function son_max_layer($list){
        //获取子集层数的集合
        $layer = arr2string($list,'layer');
        $layer = explode(',',$layer);
        //获取当前子集的最大层数
        $pos = array_search(max($layer), $layer);
        $maxlayer = $layer[$pos];
        return $maxlayer;
	}
	/**
	 * 获取当前会员的子节点数 不包含自己
	 * @param  int $layer     开始层数
	 * @param  int $layers 结束层数
	 * @param  int $mid 会员id
	 * @param  int $group_id 分组id
	 * @return int 统计数量
	 */
    function get_count_list($layer, $layers, $mid, $group_id){
    	//查询该层
    	$map = array(
            'layer' => array(array('egt',$layer),array('elt',$layers),'AND'),
            'group_id' => $group_id,
        );
        $list = M('User')->where($map)->field('id,nickname,layer,fid,createtime,status')->select();
        $list = getMenuTree($list,$mid,0);
        $count = count($list);
        return $count;
    }
	/**
	 * 判断是否已经取得奖金
	 * @param $mid 要判断的用户id
	 * @param $layer 层数
	 * @param $type 奖金类型
	 */
	function take_prize($mid,$layer,$groupid,$type){
		$dbs = M('Bonus');
		$map = array(
			'member_id'	=>	$mid,
			'layer'		=>	$layer,
			'group_id'	=>	$groupid,
			'type'		=>	$type,
		);
		$status = $dbs->where($map)->find();
		return $status;
	}
	/*计算对奖*/
	function the_prize($list){
		//循环今日更新记录
		foreach ($list as $key => $value) {
			calculate::couple($value);
		}
		return true;
	}
	//计算对奖
	function couple($minfo){
		$db = M('Couple');
		//查询历史对奖记录
		$h_couple = $db->where(array('user_id'=>$minfo['id']))->find();
		//取得未获奖人数
		$n_l_num = $minfo['l_num'] - $h_couple['l_num'];
		$n_r_num = $minfo['r_num'] - $h_couple['r_num'];
		//比较左右区未获奖的人数，得到有效数
		$num = $n_l_num > $n_r_num ? $n_r_num : $n_l_num;
		//写入奖金记录
		$money = $num * 50;
		$bonus_data = array(
			'member_id' =>	$minfo['id'],
			'group_id'	=>	$minfo['group_id'],
			'user_id'	=>	$minfo['id'],//奖金触发人
			'money'		=>	$money,
			'layer'		=>	'0',
			'createtime'=>	time(),
			'type'		=>	'2',
			'status'	=>	'1',	
		);
		$model = new Model();
		$model->startTrans();
		$status_1 = $model->table(C('DB_PREFIX').'bonus')->add($bonus_data);
		//更新历史获奖人数
		$couple = array('l_num' => array('exp','l_num+'.$num),'r_num' => array('exp','r_num+'.$num),'uptime' => time());
		$status_2 = $model->table(C('DB_PREFIX').'couple')->where(array('user_id'=>$minfo['id']))->save($couple);
		if($status_1 && $status_2){
			$model->commit();//提交事务
			return true;
		}else{
			$data = array(
				'title' => $minfo['nickname']."对奖计算失败",
				);
			error_insert($data);
			$model->rollback();//事务回滚
			return false;
		}
	}
	/*写入奖金记录
	* @param $data 数据条件
	* @param $type 奖金类型 1层奖 2 对奖 3直推奖
	* @param $datetime  结算日期
	*/
	function insert_prize($data,$type = '1',$datetime){
		$dbs = M('Bonus');
		switch ($type) {
			case '1':
				$money = '100.00';
				break;
			case '2':
				$money = $num * 50;
				break;
		}

		if(!empty($data['fid'])){
			$bonus_data = array(
				'member_id' =>	$data['fid'],
				'group_id'	=>	$data['group_id'],
				'userid'	=>	$data['id'],//奖金触发人
				'money'		=>	$money,
				'layer'		=>	$data['layer'] ? $data['layer'] : 0,
				'createtime'=>	time(),
				'type'		=>	$type,
				'status'	=>	'1',	
				'datetime'  =>	$datetime,
			);
			$status = $dbs->add($bonus_data);
			if(empty($status)){
				//写入记录失败。写入报警信息
				$data = array(
					'title' => $data['nickname']."层奖计算失败",
				);
				error_insert($data);
			}
			return $status;
		}else{
			return false;
		}
	}
}