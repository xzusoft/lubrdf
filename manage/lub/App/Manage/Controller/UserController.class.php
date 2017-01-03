<?php
namespace Manage\Controller;

use Common\Controller\ManageBase;
use Manage\Service\User;
class UserController extends ManageBase {
    public function index(){
       $map['is_scene'] = '1';//dump($this->products);
       $this->basePage('User',$map);
       $this->display();
    }
    //密码重置
    function changepwd(){
    	if(IS_POST){

    	}else{
    		$this->display();
    	}
    }
    //管理员列表
    public function manager() {
        $where = array();
        $role_id = I('get.role_id', 0, 'intval');
        if ($role_id) {
            $where['role_id'] = $role_id;
            $menuReturn = array(
                'url' => U('Rbac/rolemanage'),
                'name' => '返回角色管理',
            );
            $this->assign('menuReturn', $menuReturn);
        }
        $where['is_scene'] = 1;
        $count = D('Manage/User')->where($where)->count();
        $page = $this->page($count, 20);
        $User = D('Manage/User')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array('id' => 'DESC'))->select();
        $this->assign("Userlist", $User);
        $this->assign("Page", $page->show());
        $this->display();
    }

    //编辑信息
    public function edit() {
        $id = I('request.id', 0, 'intval');
        if (empty($id)) {
            $this->erun("请选择需要编辑的信息！");
        }
        //判断是否修改本人，在此方法，不能修改本人相关信息
        if (User::getInstance()->id == $id) {
            $this->erun("修改当前登录用户信息请进入[我的面板]中进行修改！");
        }
        if (1 == $id) {
            $this->erun("该帐号不允许修改！");
        }
        if (IS_POST) {
            if (false !== D('Manage/User')->amendManager($_POST)) {
                $this->srun("更新成功！", array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
            } else {
                $erun = D('Manage/User')->geterun();
                $this->erun($erun ? $erun : '修改失败！');
            }
        } else {
            $data = D('Manage/User')->where(array("id" => $id))->find();
            if (empty($data)) {
                $this->erun('该信息不存在！');
            }
            $this->assign("role", D('Manage/Role')->selectHtmlOption($data['role_id'], 'name="role_id"'));
            $this->assign("data", $data);
            $this->assign('group',M('UserGroup')->field('id,name')->select());
            $this->display();
        }
    }

    //添加管理员
    public function adminadd() {
        if (IS_POST) {
            if (D('Manage/User')->createManager($_POST)) {
                $this->srun("添加管理员成功！", array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
            } else {
                $erun = D('Manage/User')->geterun();
                $this->erun($erun ? $erun : '添加失败！');
            }
        } else {
            $this->assign("role", D('Manage/Role')->selectHtmlOption(0, 'name="role_id"'));
            $this->assign('group',M('UserGroup')->field('id,name')->select());
            $this->display();
        }
    }

    //管理员删除
    public function delete() {
        $id = I('get.id');
        if (empty($id)) {
            $this->erun("没有指定删除对象！");
        }
        if ((int) $id == User::getInstance()->id) {
            $this->erun("你不能删除你自己！");
        }
        //执行删除
         if (D('Manage/User')->deleteUser($id)) {
            $this->srun("删除成功！",array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true));
        } else {
            $this->erun(D('Manage/User')->geterun()? : '删除失败！');
        }
    }
    //详情
    function userinfo(){
    	$id = I('id');
    	if(empty($id)){$this->erun('参数错误');}
    	$info = D('User')->where(array('id'=>$id))->find();
        //->relation(true)
    	$this->assign('data',$info)->display();
    }
}