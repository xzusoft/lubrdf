<?php
// +----------------------------------------------------------------------
// | LubTMP Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
// +----------------------------------------------------------------------
namespace Common\Controller;
use Libs\System\Components;
use Libs\Util\Page;
class LubTMP extends \Think\Controller {

    //缓存
    public static $Cache = array();
    //当前对象
    private static $_app;

    public function __get($name) {
        $parent = parent::__get($name);
        if (empty($parent)) {
            return Components::getInstance()->$name;
        }
        return $parent;
    }

    public function __construct() {
        parent::__construct();
        self::$_app = $this;
    }

    //初始化
    protected function _initialize() {
        $this->initSite();
        //默认跳转时间
        $this->assign("waitSecond", 3);
    }

    /**
     * 获取LubTMP 对象
     * @return type
     */
    public static function app() {
        return self::$_app;
    }

    /**
     * 初始化站点配置信息
     * @return Arry 配置数组
     */
    protected function initSite() {
        $Config = cache("Config");
        self::$Cache['Config'] = $Config;
        $config_siteurl = $Config['siteurl'];
        if (isModuleInstall('Domains')) {
            $parse_url = parse_url($config_siteurl);
            $config_siteurl = (is_ssl() ? 'https://' : 'http://') . "{$_SERVER['HTTP_HOST']}{$parse_url['path']}";
        }
        defined('CONFIG_SITEURL_MODEL') or define('CONFIG_SITEURL_MODEL', $config_siteurl);
        /*
         * 判断必须缓存是否存在
         
        if(empty(cache('Item')) || empty(cache('Product'))){
        	
        }*/
        $this->assign("config_siteurl", $config_siteurl);
        $this->assign("Config", $Config);
    }
	
    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data, $type = '') {
        $data['state'] = $data['status'] ? "success" : "fail";
        if (empty($type))
            $type = C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)) {
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data));
            case 'XML' :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                $handler = isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler . '(' . json_encode($data) . ');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default :
                // 用于扩展其他返回格式数据
                tag('ajax_return', $data);
        }
    }

    /**
     * 返回模型对象
     * @param type $model
     * @return type
     */
    protected function getModelObject($model) {
        if (is_string($model) && strpos($model, '/') == false) {
            $model = M(ucwords($model));
        } else if (strpos($model, '/') && is_string($model)) {
            $model = D($model);
        } else if (is_object($model)) {
            return $model;
        } else {
            $model = M();
        }
        return $model;
    }

    /**
     * 基本信息分页列表方法
     * @param type $model 可以是模型对象，或者表名，自定义模型请传递完整（例如：Content/Model）
     * @param type $where 条件表达式
     * @param type $order 排序
     * @param type $limit 每次显示多少
     */
    protected function basePage($model, $where = '', $order = '', $limit = 25) {
        $model = $this->getModelObject($model);
        $count = $model->where($where)->count();
        $currentPage = !empty($_REQUEST["pageCurrent"])?$_REQUEST["pageCurrent"]:1;
        $firstRow = ($currentPage - 1) * $limit;
        $page = new page($count, $limit);
        $data = $model->where($where)->order($order)->limit($firstRow . ',' . $page->listRows)->select();
        $this->assign('data', $data)
             ->assign( 'totalCount', $count )
             ->assign( 'numPerPage', $page->listRows)
             ->assign( 'currentPage', $currentPage);



        /*$options    =   array();
        $REQUEST    =   (array)I('request.');
         if(is_string($model)){
             $model  =   M($model);
         }
         
         $OPT        =   new \ReflectionProperty($model,'options');
         $OPT->setAccessible(true);
         
         $pk         =   $model->getPk();
         //排序
         if ( isset($REQUEST['orderField']) && isset($REQUEST['orderDirection']) && in_array(strtolower($REQUEST['orderDirection']),array('desc','asc')) ) {
             $options['order'] = '`'.$REQUEST['orderField'].'` '.$REQUEST['orderDirection'];
         }elseif( empty($options['orderField']) && !empty($pk) ){
             $options['order'] = $pk.' desc';
         }
         unset($REQUEST['orderField'],$REQUEST['orderDirection']);
         //查询条件
         if( !empty($map)){
             $options['where'] = $map;
         }else {
             $options['where']['_logic'] = 'or';;
         }
         //每页显示行数
         $pageSize=C('PAGE_SIZE') > 0 ? C('PAGE_SIZE') : 10;
         //当前页
         $pageCurrent =null;
         if (isset($_REQUEST ['pageCurrent'])) {
             $pageCurrent = $_REQUEST ['pageCurrent'];
         }
        if ($pageCurrent == '') {
            $pageCurrent = 1;
        }
         
         $options      =   array_merge( (array)$OPT->getValue($model), $options );
         $count        =   $model->where($options['where'])->count();
         $options['limit'] = $pageSize;
         $options['page'] = $pageCurrent.','.$pageSize.'';
         
         $model->setProperty('options',$options);
         
         $voList= $model->field($field)->select();
         $this->assign('list', $voList);
         $this->assign('total', $count);//数据总数
         $this->assign('pageCurrent', !empty($_REQUEST['pageCurrent']) ? $_REQUEST['pageCurrent'] : 1);//当前的页数，默认为1
         $this->assign('pageSize', $pageSize); //每页显示多少条
         cookie('_currentUrl_', __SELF__);*/
         return;





    }

    /**
     * 基本信息添加
     * @param type $model 可以是模型对象，或者表名，自定义模型请传递完整（例如：Content/Model）
     * @param type $u 添加成功后的跳转地址
     * @param type $data 需要添加的数据
     */
    protected function baseAdd($model, $u = 'index', $data = '') {
        $model = $this->getModelObject($model);
        if (IS_POST) {
            if (empty($data)) {
                $data = I('post.', '', '');
            }
            if ($model->create($data) && $model->add()) {
                $this->success('添加成功！', $u ? U($u) : '');
            } else {
                $error = $model->getError();
                $this->error($error? : '添加失败！');
            }
        } else {
            $this->display();
        }
    }

    /**
     * 基础修改信息方法
     * @param type $model 可以是模型对象，或者表名，自定义模型请传递完整（例如：Content/Model）
     * @param type $u 修改成功后的跳转地址
     * @param type $data 需要修改的数据
     */
    protected function baseEdit($model, $u = 'index', $data = '') {
        $model = $this->getModelObject($model);
        $fidePk = $model->getPk();
        $pk = I('request.' . $fidePk, '', '');
        if (empty($pk)) {
            $this->error('请指定需要修改的信息！');
        }
        $where = array($fidePk => $pk);
        if (IS_POST) {
            if (empty($data)) {
                $data = I('post.', '', '');
            }
            if ($model->create($data) && $model->where($where)->save() !== false) {
                $this->success('修改成功！', $u ? U($u) : '');
            } else {
                $error = $model->getError();
                $this->error($error? : '修改失败！');
            }
        } else {
            $data = $model->where($where)->find();
            if (empty($data)) {
                $this->error('该信息不存在！');
            }
            $this->assign('data', $data);
            $this->display();
        }
    }

    /**
     * 基础信息单条记录删除，根据主键
     * @param type $model 可以是模型对象，或者表名，自定义模型请传递完整（例如：Content/Model）
     * @param type $u 删除成功后跳转地址
     */
    protected function baseDelete($model, $u = 'index') {
        $model = $this->getModelObject($model);
        $pk = I('request.' . $model->getPk());
        if (empty($pk)) {
            $this->error('请指定需要修改的信息！');
        }
        $where = array($model->getPk() => $pk);
        $data = $model->where($where)->find();
        if (empty($data)) {
            $this->error('该信息不存在！');
        }
        if ($model->delete() !== false) {
            $this->success('删除成功！', $u ? U($u) : '');
        } else {
            $error = $model->getError();
            $this->error($error? : '删除失败！');
        }
    }

    /**
     * 客户端成功返回代码
     * @param statusCode  int 必选。状态码(ok = 200, error = 300, timeout = 301)，可以在BJUI.init时配置三个参数的默认值。
     * @param message string  可选。信息内容。
     * @param tabid  string  可选。待刷新navtab id，多个id以英文逗号分隔开，当前的navtab id不需要填写，填写后可能会导致当前navtab重复刷新。
     * @param dialogid    string  可选。待刷新dialog id，多个id以英文逗号分隔开，请不要填写当前的dialog id，要控制刷新当前dialog，请设置dialog中表单的reload参数。
     * @param divid   string  可选。待刷新div id，多个id以英文逗号分隔开，请不要填写当前的div id，要控制刷新当前div，请设置该div中表单的reload参数。
     * @param closeCurrent    boolean 可选。是否关闭当前窗口(navtab或dialog)。
     * @param forward string  可选。跳转到某个url。
     * @param forwardConfirm  string  可选。跳转url前的确认提示信息。
     */
    final public function srun($message = '', $param = null){
        $return = array(
            'statusCode' => '200',
            'message'   => $message,
        );
        if($param){
            $return = array_merge($return,$param);
        }
        D('Manage/Operationlog')->record($message, 1);
        $this->ajaxReturn($return,'json');
    }
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    final public function erun($message = '', $param = null){
         $return = array(
            'statusCode' => '300',
            'message'   => $message,
        );
        if($param){
            $return = array_merge($return,$param);
        }
        D('Manage/Operationlog')->record($message, 0);
       // echo json_encode($return);
        $this->ajaxReturn($return,'json');
    }
    /**
     * 验证码验证
     * @param type $verify 验证码
     * @param type $type 验证码类型
     * @return boolean
     */
    static public function verify($verify, $type = "verify") {
        return A('Api/Checkcode')->validate($type, $verify);
    }

    static public function logo() {
        return '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';
    }
    
    //空操作
    public function _empty() {
        $this->error('该页面不存在！');
    }
}