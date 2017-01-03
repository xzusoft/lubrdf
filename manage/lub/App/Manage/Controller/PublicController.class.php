<?php
// +----------------------------------------------------------------------
// | LubTMP 系统公共方法
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Manage\Controller;
use Common\Controller\ManageBase;
use Manage\Service\User;
class PublicController extends ManageBase {
    public function index(){
       $this->assign('data',$data)->display();
    }
    function login(){
        if(IS_POST){
            if (empty($username) || empty($password)) {
                $this->erun("用户名或者密码不能为空，请重新输入");
            }
        }else{
            //如果已经登录
            if (User::getInstance()->id) {
                $this->redirect('Manage/Index/index');
            }
            $this->display();
        }
        
    }
    //后台登陆验证
    public function tologin() {
        //记录登陆失败者IP
        $ip = get_client_ip();
        $username = I("post.username", "", "trim");
        $password = I("post.password", "", "trim");
        $code = I("post.code", "", "trim");
        if (empty($username) || empty($password)) {
             $this->erun("用户名或者密码不能为空，请重新输入！");
        }
        if (empty($code)) {
            $this->erun("请输入验证码！", U("Public/login"));
        }
        //验证码开始验证
        if (!$this->verify($code)) {
            $this->erun("验证码错误，请重新输入！");
            return false;
        }
        if (User::getInstance()->login($username, $password, 1)) {
            $forward = cookie("forward");
            if (!$forward) {
                $forward = U("Manage/Index/index");
            } else {
                cookie("forward", NULL);
            }
            //增加登陆成功行为调用
            $admin_public_tologin = array(
                'username' => $username,
                'ip' => $ip,
            );
            tag('admin_public_tologin', $admin_public_tologin);
            $this->srun("登录成功",array('url'=>U('Index/index')));
        } else {
            //增加登陆失败行为调用
            $admin_public_tologin = array(
                'username' => $username,
                'password' => $password,
                'ip' => $ip,
            );
            tag('admin_public_tologin_error', $admin_public_tologin);
            $this->erun("用户名或者密码错误，登陆失败！");
        }
    }

    //退出登陆
    public function logout() {
        if (User::getInstance()->logout()) {
            //手动登出时，清空forward
            cookie("forward", NULL);
            $this->success('注销成功！', U("Manage/Public/login"));
        }
    }

    //常用菜单设置
    public function changyong() {
        if (IS_POST) {
            //被选中的菜单项
            $menuidAll = explode(',', I('post.menuid', ''));
            if (is_array($menuidAll) && count($menuidAll) > 0) {
                //取得菜单数据
                $menu_info = cache('Menu');
                $addPanel = array();
                //检测数据合法性
                foreach ($menuidAll as $menuid) {
                    if (empty($menu_info[$menuid])) {
                        continue;
                    }
                    $info = array(
                        'mid' => $menuid,
                        'userid' => User::getInstance()->id,
                        'name' => $menu_info[$menuid]['name'],
                        'url' => "{$menu_info[$menuid]['app']}/{$menu_info[$menuid]['controller']}/{$menu_info[$menuid]['action']}",
                    );
                    $addPanel[] = $info;
                }
                if (D('Manage/AdminPanel')->addPanel($addPanel)) {
                    $this->success("添加成功！", U("Public/changyong"));
                } else {
                    $error = D('Manage/AdminPanel')->getError();
                    $this->error($error ? $error : '添加失败！');
                }
            } else {
                D('Manage/AdminPanel')->where(array("userid" => \Manage\Service\User::getInstance()->id))->delete();
                $this->error("常用菜单清除成功！");
            }
        } else {
            //菜单缓存
            $result = cache("Menu");
            $json = array();
            //子角色列表
            $child = explode(',', D("Manage/Role")->getArrchildid(\Manage\Service\User::getInstance()->role_id));
            foreach ($result as $rs) {
                if ($rs['status'] == 0) {
                    continue;
                }
                //条件
                $where = array('app' => $rs['app'], 'controller' => $rs['controller'], 'action' => $rs['action'], 'role_id' => array('IN', $child));
                //是否有权限
                if (!D('Manage/Access')->isCompetence($where)) {
                    continue;
                }
                $data = array(
                    'id' => $rs['id'],
                    'nocheck' => $rs['type'] ? 0 : 1,
                    'checked' => $rs['id'],
                    'parentid' => $rs['parentid'],
                    'name' => $rs['name'],
                    'checked' => D("Admin/AdminPanel")->isExist($rs['id']) ? true : false,
                );
                $json[] = $data;
            }

            $this->assign('json', json_encode($json))
                    ->display();
        }
    }
    function index_info(){
    	$this->display();
    }
}