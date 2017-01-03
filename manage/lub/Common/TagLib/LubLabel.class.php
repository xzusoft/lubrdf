<?php

// +----------------------------------------------------------------------
// | LubTMP 标签解析库
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
// +----------------------------------------------------------------------

namespace Common\TagLib;

use Think\Template\TagLib;

class LubLabel extends TagLib {

    // 数据库where表达式
    protected $comparisonLublabel = array(
        '{eq}' => '=',
        '{neq}' => '<>',
        '{elt}' => '<=',
        '{egt}' => '>=',
        '{gt}' => '>',
        '{lt}' => '<',
    );
    // 标签定义
    protected $tags = array(
        //系统后台模板标签
        'managetemplate' => array('attr' => 'file', 'close' => 0),
        //前台模板标签
        'template' => array('attr' => 'file,theme', 'close' => 0),
        //区块缓存
        'blockcache' => array('attr' => 'cache', 'close' => 1),  
        //sp模块调用标签
        'spf' => array('attr' => 'module,action,cache,num,page,pagetp,pagefun,return,where,order', 'level' => 3),
        //内容标签
        'content' => array('attr' => 'action,cache,num,page,pagetp,pagefun,return,where,moreinfo,thumb,order,day,catid,output', 'level' => 3),
    );

    /**
     * 模板包含标签 
     * 格式：<managetemplate file="模块/控制器/模板名"/>
     * @param type $attr 属性字符串
     * @param type $content 标签内容
     * @return string 标签解析后的内容 
     */
    public function _managetemplate($attr, $content) {
        $file = explode("/", $attr['file']);
        $counts = count($file);
        if ($counts < 2) {
            return '';
        } else if ($counts < 3) {
            $file_path = "Manage/" . C('DEFAULT_V_LAYER') . "/{$attr['file']}";
        } else {
            $file_path = "$file[0]/" . C('DEFAULT_V_LAYER') . "/{$file[1]}/{$file[2]}";
        }
        //模板路径
        $TemplatePath = APP_PATH . $file_path . C("TMPL_TEMPLATE_SUFFIX");
        //判断模板是否存在
        if (file_exists_case($TemplatePath)) {
            //读取内容
            $tmplContent = file_get_contents($TemplatePath);
            //解析模板内容
            $parseStr = $this->tpl->parse($tmplContent);
            return $parseStr;
        }
        return '';
    }
    /**
     * 加载前台模板
     * 格式：<template file="Content/footer.php" theme="主题"/>
     * @staticvar array $_templateParseCache
     * @param type $attr file，theme
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _template($attr, $content) {
        static $_templateParseCache = array();
        $cacheIterateId = to_guid_string($attr);
        if (isset($_templateParseCache[$cacheIterateId])) {
            return $_templateParseCache[$cacheIterateId];
        }
        $config = cache('Config');
        $theme = $attr['theme']? : $config['theme'];
        $templateFile = $attr['file'];
        //不是直接指定模板路径的
        if (false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
            $templateFile = TEMPLATE_PATH . $theme . '/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
        } else {
            $templateFile = TEMPLATE_PATH . $theme . '/' . $templateFile;
        }
        //判断模板是否存在
        if (!file_exists_case($templateFile)) {
            $templateFile = str_replace($theme . '/', 'Default/', $templateFile);
            if (!file_exists_case($templateFile)) {
                return '';
            }
        }
        //读取内容
        $tmplContent = file_get_contents($templateFile);
        //解析模板
        $parseStr = $this->tpl->parse($tmplContent);
        $_templateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 区块内容缓存标签
     * @param type $attr
     * @param type $content
     * @return type
     */
    public function _blockcache($tag, $content) {
        $cacheIterateId = to_guid_string(to_guid_string($tag) . $content);
        //缓存时间
        $cache = (int) $tag['cache'] ? : 300;
        $parsestr = '<?php ';
        $parsestr .= ' $_cache = S("' . $cacheIterateId . '"); ';
        $parsestr .= ' if ($_cache) { ';
        $parsestr .= '    echo $_cache;';
        $parsestr .= ' }else{ ';
        $parsestr .= ' ob_start(); ';
        $parsestr .= ' ob_implicit_flush(0); ';
        $parsestr .= ' ?> ';
        $parsestr .= $content;
        $parsestr .= ' <?php';
        $parsestr .= ' $_html = ob_get_clean(); ';
        $parsestr .= ' if ($_html) { S("' . $cacheIterateId . '", $_html, ' . $cache . ');}';
        $parsestr .= ' echo $_html; ';
        $parsestr .= ' } ';
        $parsestr .= ' ?>';
        return $parsestr;
    }


    /**
     * spf标签，用于调用模块扩展标签
     * 标签：<spf></spf>
     * 作用：调用非系统内置标签，例如安装新模块后，例如新模块（Demo）目录下TagLib/DemoTagLib.class.php(类名为DemoTagLib)
     *          用法就是 <spf module="Demo" action="lists"> .. HTML ..</spf> lists表示类DemoTagLib中一个public方法。
     * 用法示例：<spf module="Like"> .. HTML ..</spf>
     * 参数说明：
     * 	基本参数
     * 		@module                     对应模块（必填）
     * 		@action		调用方法（必填）
     * 		@page		当前分页号，默认$page，当传入该参数表示启用分页，一个页面只允许有一个page，多个标签使用多个page会造成不可预知的问题。
     * 		@num		每次返回数据量
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@pagefun                      分页函数，默认page
     * 		@pagetp		分页模板，必须是变量传递
     * 		@return		返回值变量名称，默认data
     * @staticvar array $sp_iterateParseCache
     * @param type $attr
     * @param type $content
     * @return array
     */
    public function _spf($tag, $content) {
        static $sp_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($sp_iterateParseCache[$cacheIterateId])) {
            return $sp_iterateParseCache[$cacheIterateId];
        }
        //模块
        $tag['module'] = $mo = ucwords($tag['module']);
        //每页显示总数
        $tag['num'] = $num = (int) $tag['num'];
        //当前分页参数
        $tag['page'] = $page = (isset($tag['page'])) ? ( (substr($tag['page'], 0, 1) == '$') ? $tag['page'] : (int) $tag['page'] ) : 0;
        //分页函数，默认page
        $tag['pagefun'] = $pagefun = empty($tag['pagefun']) ? "page" : trim($tag['pagefun']);
        //数据返回变量
        $tag['return'] = $return = empty($tag['return']) ? "data" : $tag['return'];
        //方法
        $tag['action'] = $action = trim($tag['action']);
        //sql语句的where部分
        if ($tag['where']) {
            $tag['where'] = $this->parseSqlCondition($tag['where']);
        }
        $tag['where'] = $where = $tag['where'];

        //拼接php代码
        $parseStr = '<?php';
        $parseStr .= '  import("' . $mo . 'TagLib", APP_PATH . "' . $mo . '/TagLib/"); ';
        $parseStr .= '  $' . $mo . 'TagLib = \Think\Think::instance("\\' . $mo . '\\TagLib\\' . $mo . 'TagLib"); ';
        //如果有传入$page参数，则启用分页。
        if ($page) {
            //分页配置处理
            $pageConfig = $this->resolvePageParameter($tag);
            //进行信息数量统计 需要 action catid where
            $parseStr .= ' $count = $' . $mo . 'TagLib->count(' . self::arr_to_html($tag) . ');' . "\r\n";
            //分页函数
            $parseStr .= ' $_page_ = ' . $pagefun . '($count ,' . $num . ',' . $page . ',' . self::arr_to_html($pageConfig) . ');';
            $tag['count'] = '$count';
            $tag['limit'] = '$_page_->firstRow.",".$_page_->listRows';
            //总分页数，生成静态时需要
            $parseStr .= ' $GLOBALS["Total_Pages"] = $_page_->Total_Pages;';
            //显示分页导航
            $parseStr .= ' $pages = $_page_->show("default");';
            //分页总数
            $parseStr .= ' $pagetotal = $_page_->Total_Pages;';
            //总信息数
            $parseStr .= ' $totalsize = $_page_->Total_Size;';
        }
        $parseStr .= ' if(method_exists($' . $mo . 'TagLib, "' . $action . '")){';
        $parseStr .= ' $' . $return . ' = $' . $mo . 'TagLib->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' }';
        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $sp_iterateParseCache[$cacheIterateId] = $parseStr;
        return $sp_iterateParseCache[$cacheIterateId];
    }

    /**
     * 转换数据为HTML代码
     * @param array $data 数组
     */
    private static function arr_to_html($data) {
        if (is_array($data)) {
            $str = 'array(';
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $str .= "'$key'=>" . self::arr_to_html($val) . ",";
                } else {
                    //如果是变量的情况
                    if (strpos($val, '$') === 0) {
                        $str .= "'$key'=>$val,";
                    } else if (preg_match("/^([a-zA-Z_].*)\(/i", $val, $matches)) {//判断是否使用函数
                        if (function_exists($matches[1])) {
                            $str .= "'$key'=>$val,";
                        } else {
                            $str .= "'$key'=>'" . self::newAddslashes($val) . "',";
                        }
                    } else {
                        $str .= "'$key'=>'" . self::newAddslashes($val) . "',";
                    }
                }
            }
            return $str . ')';
        }
        return false;
    }

    /**
     * 返回经addslashes处理过的字符串或数组
     * @param $string 需要处理的字符串或数组
     * @return mixed
     */
    protected static function newAddslashes($string) {
        if (!is_array($string))
            return addslashes($string);
        foreach ($string as $key => $val)
            $string[$key] = $this->newAddslashes($val);
        return $string;
    }

    /**
     * 检查是否变量
     * @param type $variable
     * @return type
     */
    protected function variable($variable) {
        return substr(trim($variable), 0, 1) == '$';
    }

    /**
     * 解析条件表达式
     * @access public
     * @param string $condition 表达式标签内容
     * @return array
     */
    protected function parseSqlCondition($condition) {
        $condition = str_ireplace(array_keys($this->comparisonLublabel), array_values($this->comparisonLublabel), $condition);
        return $condition;
    }

    /**
     * 解析分页参数
     * @param type $tag
     * @return type\
     */
    protected function resolvePageParameter(&$tag) {
        if (empty($tag)) {
            return array();
        }
        //分页设置
        $config = array();
        foreach ($tag as $key => $value) {
            if ($key && substr($key, 0, 5) == "page_") {
                //配置名称
                $name = str_replace('page_', '', $key);
                if (substr($value, 0, 1) == '$') {
                    $config[$name] = $value;
                } else {
                    $config[$name] = $this->parseSqlCondition($value);
                }
                unset($tag[$key]);
            }
        }
        //兼容 pagetp 参数
        if (!empty($tag['pagetp'])) {
            $config['tpl'] = (substr($tag['pagetp'], 0, 1) == '$') ? $tag['pagetp'] : '';
        }
        //标签默认开启自定义分页规则
        $config['isrule'] = true;
        return $config;
    }

}