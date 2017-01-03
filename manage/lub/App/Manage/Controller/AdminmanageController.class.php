<?php
// +----------------------------------------------------------------------
// | LubTMP 我的面板
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Manage\Controller;
use Common\Controller\ManageBase;
use Manage\Service\User;
class AdminmanageController extends ManageBase {

    //修改当前登陆状态下的用户个人信息
    public function myinfo() {
        if (IS_POST) {
            $data = array(
                'id' => User::getInstance()->id,
                'nickname' => I('nickname'),
                'email' => I('email'),
                'remark' => I('remark')
            );
            if (D("Manage/User")->token(false)->create($data)) {
                if (D("Manage/User")->where(array('id' => User::getInstance()->id))->save() !== false) {
                    $this->srun("资料修改成功！",array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true,'forward'=>U('Manage/Index/index')));
                } else {
                    $this->erun("更新失败！");
                }
            } else {
                $this->erun(D("Manage/User")->getError());
            }
        } else {
            $this->assign("data", User::getInstance()->getInfo());
            $this->display();
        }
    }

    //后台登陆状态下修改当前登陆人密码
    public function chanpass() {
        if (IS_POST) {
            $oldPass = I('post.password', '', 'trim');
            if (empty($oldPass)) {
                $this->erun("请输入旧密码！");
            }
            $newPass = I('post.new_password', '', 'trim');
            $new_pwdconfirm = I('post.new_pwdconfirm', '', 'trim');
            if ($newPass != $new_pwdconfirm) {
                $this->erun("两次密码不相同！");
            }
            if (D("Manage/User")->changePassword(User::getInstance()->id, $newPass, $oldPass)) {
                //退出登陆
                User::getInstance()->logout();
                $this->srun("密码已经更新，请从新登陆！",array('tabid'=>$this->menuid.MODULE_NAME,'closeCurrent'=>true,'forward'=>U('Manage/Public/login')));
            } else {
                $error = D("Manage/User")->getError();
                $this->erun($error ? $error : "密码更新失败！");
            }
        } else {
            $this->assign('userInfo', User::getInstance()->getInfo());
            $this->display();
        }
    }

    //验证密码是否正确
    public function public_verifypass() {
        $password = I("get.password");
        if (empty($password)) {
            $this->erun("密码不能为空！");
        }
        //验证密码
        $user = D('Manage/User')->getUserInfo((int) User::getInstance()->id, $password);
        if (!empty($user)) {
            $this->srun("密码正确！");
        } else {
            $this->erun("密码错误！");
        }
    }
}