<?php
namespace Manage\Controller;

use Common\Controller\ManageBase;
use Manage\Service\User;
class IndexController extends ManageBase {
    public function index() {
        if (IS_AJAX) {
            $this->ajaxReturn(array('status' => 1));
            return true;
        }
        /*一键更新
        $list = D("Manage/Menu")->select();
        foreach ($list as $k => $v) {
            $name = $v['app'].'/'.$v['controller'].'/'.$v['action'];
            D("Manage/Menu")->where(array('id'=>$v['id']))->setField('name',$name);
        }*/
       // dump(D("Manage/Menu")->getMenuList());
        $this->assign("SUBMENU_CONFIG", D("Manage/Menu")->getMenuList());
        $this->assign('userInfo', User::getInstance()->getInfo());
        $this->assign('role_name', D('Manage/Role')->getRoleIdName(User::getInstance()->role_id));
        $this->display();
    }
    //缓存更新
    public function cache() {
        if (isset($_GET['type'])) {
            $Dir = new \Dir();
            $cache = D('Common/Cache');
            $type = I('get.type');
            set_time_limit(0);
            switch ($type) {
                case "site":
                    //开始刷新缓存
                    $stop = I('get.stop', 0, 'intval');
                    if (empty($stop)) {
                        try {
                            //已经清除过的目录
                            $dirList = explode(',', I('get.dir', ''));
                            //删除缓存目录下的文件
                            $Dir->del(RUNTIME_PATH);
                            //获取子目录
                            $subdir = glob(RUNTIME_PATH . '*', GLOB_ONLYDIR | GLOB_NOSORT);
                            if (is_array($subdir)) {
                                foreach ($subdir as $path) {
                                    $dirName = str_replace(RUNTIME_PATH, '', $path);
                                    //忽略目录
                                    if (in_array($dirName, array('Cache', 'Logs'))) {
                                        continue;
                                    }
                                    if (in_array($dirName, $dirList)) {
                                        continue;
                                    }
                                    $dirList[] = $dirName;
                                    //删除目录
                                    $Dir->delDir($path);
                                    //防止超时，清理一个从新跳转一次
                                   // $this->assign("waitSecond", 200);
                                    //$this->success("清理缓存目录[{$dirName}]成功！", );
                                    $this->srun("清理缓存目录[{$dirName}]成功！",array('urls'=>U('Index/cache', array('type' => 'site', 'dir' => implode(',', $dirList))),'stop'=>'999'));
                                    exit;
                                }
                            }
                            //更新开启其他方式的缓存
                            \Think\Cache::getInstance()->clear();
                        } catch (Exception $exc) {
                            
                        }
                    }
                    if ($stop) {
                        $modules = $cache->getCacheList();
                        //需要更新的缓存信息
                        $cacheInfo = $modules[$stop - 1];//dump($cacheInfo);
                        if ($cacheInfo) {
                            if ($cache->runUpdate($cacheInfo) !== false) {
                                $this->assign("waitSecond", 200);
                                $this->srun('更新缓存：' . $cacheInfo['name'], array('urls'=>U('Index/cache', array('type' => 'site', 'stop' => $stop + 1)),'stop'=>$stop));
                                exit;
                            } else {
                                $this->erun('缓存[' . $cacheInfo['name'] . ']更新失败！', array('urls'=>U('Index/cache', array('type' => 'site', 'stop' => $stop + 1)),'stop'=>$stop));
                            }
                        } else {
                            $this->srun('缓存更新完毕！', array('urls'=>U('Index/cache'),'stop'=>0));
                            exit;
                        }
                    }

                    $this->srun("即将更新系统缓存！", array('urls'=>U('Index/cache', array('type' => 'site', 'stop' => 1)),'stop'=>1));
                    break;
                case "template":
                    //删除缓存目录下的文件
                    $Dir->del(RUNTIME_PATH);
                    $Dir->delDir(RUNTIME_PATH . "Cache/");
                    $Dir->delDir(RUNTIME_PATH . "Temp/");
                    //更新开启其他方式的缓存
                    \Think\Cache::getInstance()->clear();
                    $this->srun("模板缓存清理成功！", array('urls'=>U('Index/cache'),'stop'=>'0'));
                    break;
                case "logs":
                    $Dir->delDir(RUNTIME_PATH . "Logs/");
                    $this->srun("站点日志清理成功！", array('urls'=>U('Index/cache'),'stop'=>'0'));
                    break;
                default:
                    $this->erun("请选择更新缓存类型！");
                    break;
            }
        } else {
            $this->display();
        }
    }
    public function index_info(){
    	$this->display();
    }
    //登录超时
    function login_time()
    {
        $this->display();
    }
    /*获取员工*/
    function user(){
        if(IS_POST){
            if($_POST["name"] != ""){
                $map["nickname"] = array('like','%'.$_POST["name"].'%');
                $this->assign("name",$_POST["name"]);
            }   
        }
        $uinfo = \Manage\Service\User::getInstance()->getInfo();
        if($uinfo['id'] <> '1'){
            $map['group_id'] = array('in',$uinfo['group']);
        }
        //add是否可追加  可多选 1可多选可追加  2只能单选
        $ifadd = I('ifadd');
        $map['is_scene'] = array('in','2');
        //TODO 员工中分售票员和普通员工 动态配置
        $this->basePage('User',$map,array('id'=>'ASC'),10);
        $this->assign('type',$type);
        $this->assign("ifadd",$ifadd)
            ->display();
    }
}