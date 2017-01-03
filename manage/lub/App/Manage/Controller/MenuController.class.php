<?php
// +----------------------------------------------------------------------
// | LubTMP 系统菜单管理
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

namespace Manage\Controller;

use Common\Controller\ManageBase;

class MenuController extends ManageBase {
	/*=============================================系统菜单============================================================================*/
    //菜单首页
    //is_scenic 应用场景标示符 1系统后台2商户后台3渠道后台
    public function index() {
        $map['is_scene'] = '1';
        $result = D("Manage/Menu")->where($map)->order(array("listorder" => "ASC"))->select();
        foreach ($result as $k => $v) {
            $data[] =  array(
                    "icon"     => $v['icon'],
                    "id"       => $v['id'],
                    "tId"      => $v['id'] . $v['title'],
                    "name"     => $v['title'],
                    "parentid" => $v['parentid'],
                    'parameter'=> $v['parameter'],
                    'status'   => $v['status'],
                    'target'   => $v['target'],
                    'type'     => $v['type'],
                    'app'      => $v['app'],
                    'model'    => $v['controller'],
                    'action'   => $v['action'],
                    'is_scene' => $v['is_scene'],
                    'help'     => $v['help'],
                    'listorder'=> $v['listorder'],
                    'stype'    => $v['stype'],
                    'width'    => $v['width'],
                    'height'   => $v['height'],
                    'is_param' => $v['is_param'],
                );
        }
        $this->assign('menu',$data)->assign('scene',1)->display();
    }


    

     /*==========================================================================渠道菜单===============================================*/
    public function home_index(){
        if (IS_POST) {
            $listorders = $_POST['listorders'];
            if (!empty($listorders)) {
                foreach ($listorders as $id => $v) {
                    D("Manage/Menu")->find($id);
                    D("Manage/Menu")->listorder = $v;
                    D("Manage/Menu")->save();
                }
                $this->success('修改成功！', U('index'));
                exit;
            }
        }
        $map['is_scene'] = '3';
        $result = D("Manage/Menu")->where($map)->order(array("listorder" => "ASC"))->select();
        foreach ($result as $k => $v) {
            $data[] =  array(
                    "icon"     => $v['icon'],
                    "id"       => $v['id'],
                    "tId"      => $v['id'] . $v['title'],
                    "name"     => $v['title'],
                    "parentid" => $v['parentid'],
                    'parameter'=> $v['parameter'],
                    'status'   => $v['status'],
                    'target'   => $v['target'],
                    'type'     => $v['type'],
                    'app'      => $v['app'],
                    'model'    => $v['controller'],
                    'action'   => $v['action'],
                    'is_scene' => $v['is_scene'],
                    'help'     => $v['help'],
                    'listorder'=> $v['listorder'],
                    'stype'    => $v['stype'],
                    'width'    => $v['width'],
                    'height'   => $v['height'],
                    'is_param' => $v['is_param'],
                );
        }
        $this->assign('menu',$data)->assign('scene',3)->display('index');
    }
    //添加菜单
    public function add(){
        if (IS_POST) {
            C('TOKEN_ON',false);
            if (D("Manage/Menu")->create()) {
                $id = I('id');
                if(!empty($id)){
                    $status = D("Manage/Menu")->save();
                }else{
                    $status = D("Manage/Menu")->add();
                }
                if($status != false){
                     $this->srun("添加/更新成功!",array('tabid'=>$this->menuid.MODULE_NAME));         
                }else{
                    $this->erun("添加/更新失败！");
                }
            }else{
                $this->erun(D("Manage/Menu")->getError());
            }
        }else{
            $tree = new \Tree();
            $parentid = I('get.parentid', 0, 'intval');
            $map['is_scene'] = I('get.scene', 1, 'intval');
            $result = D("Manage/Menu")->where($map)->select();
            foreach ($result as $r) {
                $r['selected'] = $r['id'] == $parentid ? 'selected' : '';
                $array[] = $r;
            }
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);
            $this->assign("select_categorys", $select_categorys);
            $this->display();
        }
    }

    //删除
    public function delete() {
        $id = I('get.id', 0, 'intval');
        $count = D("Manage/Menu")->where(array("parentid" => $id))->count();
        if ($count > 0) {
            $this->erun("该菜单下还有子菜单，无法删除！");
        }
        if (D("Manage/Menu")->delete($id)) {
            $this->srun("删除菜单成功！",array('tabid'=>$this->menuid.MODULE_NAME));
        } else {
            $this->erun("删除失败！");
        }
    }
}