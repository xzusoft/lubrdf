<?php
// +----------------------------------------------------------------------
// | LubTMP 系统权限配置，用户角色管理
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Manage\Controller;

use Common\Controller\ManageBase;

class RbacController extends ManageBase {

    //角色管理首页
    public function rolemanage() {
        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $roleList = D("Manage/Role")->getTreeArray();
        foreach ($roleList as $k => $rs) {
        	$is_scene = '';
        	if($rs['is_scene'] == '1'){$is_scene = "*系统角色";}elseif ($rs['is_scene'] == '2'){$is_scene = "客户端角色";}else {$is_scene = "渠道商角色";}
            $operating = '';
            if ($rs['id'] == 1) {
                $operating = '<a class="btn btn-default" href="' . U('Management/manager', array('role_id' => $rs['id'])) . '"><i class="fa fa-group"></i></a>';
            } else {
                $operating = '<div class="btn-group btn-group-xs" role="group">
                <a type="button" class="btn btn-default" data-toggle="dialog" data-width="400" data-height="700" href="' . U("Rbac/authorize", array("id" => $rs["id"],"scene"=>$rs["is_scene"],"menuid"=>$this->menuid)) . '" data-title="角色授权"><i class="fa fa-wrench"></i></a>
                <a type="button" class="btn btn-default" data-toggle="dialog" data-width="800" data-height="400" data-id="rolegroup" href="' . U('Management/manager', array('role_id' => $rs['id'])) . '" data-title="组用户"><i class="fa fa-group"></i></a>
                <a type="button" class="btn btn-default" data-toggle="dialog" data-width="800" data-height="400" data-id="role" href="' . U('Rbac/roleedit', array('id' => $rs['id'])) . '" data-title="编辑角色"><i class="fa fa-edit"></i></a> 
                <a type="button" class="btn btn-default" data-toggle="doajax" data-confirm-msg="确定要删除信息吗？" href="' . U('Rbac/roledelete', array('id' => $rs['id'])) . '"><i class="fa fa-trash"></i></a></div>';
            }
            $roleList[$k]['is_scene'] = $is_scene;
            $roleList[$k]['operating'] = $operating;
        }
        $str = "<tr>
          <td>\$id</td>
          <td>\$spacer\$name</td>
          <td>\$is_scene</td>
          <td>\$remark</td>
          <td align='center'><font color='red'>√</font></td>
          <td align='center'>\$operating</td>
        </tr>";
        $tree->init($roleList);
        $this->assign("role", $tree->get_tree(0, $str));
        $this->assign("data", D("Manage/Role")->order(array("listorder" => "asc", "id" => "desc"))->select())
                ->display();
    }

    //添加角色
    public function roleadd() {
        if (IS_POST) {
            if (D("Manage/Role")->create()) {
                if (D("Manage/Role")->add()) {
                    $this->srun("添加角色成功！", array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
                } else {
                    $this->erun("添加失败！");
                }
            } else {
                $error = D("Manage/Role")->getError();
                $this->erun($error ? $error : '添加失败！');
            }
        } else {
            $this->display();
        }
    }

    //删除角色
    public function roledelete() {
        $id = I('get.id', 0, 'intval');
        if (D("Manage/Role")->roleDelete($id)) {
            $this->srun("删除成功！", array('tabid'=>$this->menuid.MODULE_NAME));
        } else {
            $error = D("Manage/Role")->getError();
            $this->erun($error ? $error : '删除失败！');
        }
    }

    //编辑角色
    public function roleedit() {
        $id = I('request.id', 0, 'intval');
        if (empty($id)) {
            $this->erun('请选择需要编辑的角色！');
        }
        if (1 == $id) {
            $this->erun("超级管理员角色不能被修改！");
        }
        if (IS_POST) {
            if (D("Manage/Role")->create()) {
                if (D("Manage/Role")->where(array('id' => $id))->save()) {
                    $this->srun("修改成功！", array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
                } else {
                    $this->erun("修改失败！");
                }
            } else {
                $error = D("Manage/Role")->getError();
                $this->erun($error ? $error : '修改失败！');
            }
        } else {
            $data = D("Manage/Role")->where(array("id" => $id))->find();
            if (empty($data)) {
                $this->erun("该角色不存在！", array('tabid'=>$this->menuid.MODULE_NAME));
            }
            $this->assign("data", $data)
                    ->display();
        }
    }

    //角色授权
    public function authorize() {
        if (IS_POST) {
            $pinfo = $_POST['data'];
            $pinfo = json_decode($pinfo,true);
            //dump(empty($pinfo['roleid']));
            if(empty($pinfo['roleid'])){
                $this->erun("需要授权的角色不存在！");
            }
            //被选中的菜单项
            $menuidAll = explode(',', $pinfo['menuid']);
            if (is_array($menuidAll) && count($menuidAll) > 0) {
                //取得菜单数据
                $scene	= $pinfo['scene'];
            	if($scene == '1'){$menu_info = cache("Menu");}elseif ($scene == '2'){$menu_info = cache("ItemMenu");}else{$menu_info = cache("HomeMenu");}
                $addauthorize = array();
                //检测数据合法性
                foreach ($menuidAll as $menuid) {
                    if (empty($menu_info[$menuid])) {
                        continue;
                    }
                    $info = array(
                        'app' => $menu_info[$menuid]['app'],
                        'controller' => $menu_info[$menuid]['controller'],
                        'action' => $menu_info[$menuid]['action'],
                        'type' => $menu_info[$menuid]['type'],
                    );
                    //菜单项
                    if ($info['type'] == 0) {
                        $info['app'] = $info['app'];
                        $info['controller'] = $info['controller'] . $menuid;
                        $info['action'] = $info['action'] . $menuid;
                    }
                    $info['role_id'] = $pinfo['roleid'];
                    $info['status'] = $info['type'] ? 1 : 0;
                    $addauthorize[] = $info;
                }
                if (D('Manage/Access')->batchAuthorize($addauthorize, $pinfo['roleid'])) {
                    $this->ajaxReturn(array('statusCode'=>'200','message'=>"授权成功！"),json);
                } else {
                    $error = D("Manage/Access")->getError();
                    $this->erun($error ? $error : '授权失败！');
                    $this->ajaxReturn(array('statusCode'=>'300','message'=>$error ? $error : '授权失败！'),json);
                }
            } else {
                $this->erun("没有接收到数据，执行清除授权成功！");
            }
        } else {
            //角色ID
            $roleid = I('get.id', 0, 'intval');
            if (empty($roleid)) {
                $this->error("参数错误！");
            }
            //菜单缓存
            $scene	= I('get.scene', 1, 'intval');
            
            if($scene == '1'){$result = cache("Menu");}else{$result = cache("HomeMenu");}
            //获取已权限表数据
            $priv_data = D("Manage/Role")->getAccessList($roleid);
            $json = array();
            foreach ($result as $rs) {
                $data = array(
                    'id' => $rs['id'],
                    'checked' => $rs['id'],
                    'parentid' => $rs['parentid'],
                    'icon'     => $rs['icon'],
                    'name' => $rs['name'] . ($rs['type'] == 0 ? "(菜单项)" : ""),
                    'checked' => D("Manage/Role")->isCompetence($rs, $roleid, $priv_data) ? true : false,
                );
                $json[] = $data;
            }
            //dump($json);->assign('json', json_encode($json))
            $this->assign("roleid", $roleid)
                ->assign('menu',$json)
                ->assign("scene", $scene)
                ->assign('name', D("Manage/Role")->getRoleIdName($roleid))
                ->display();
        }
    }

}
