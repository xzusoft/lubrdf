<?php

// +----------------------------------------------------------------------
// | LubTMP 生成静态页面
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
// +----------------------------------------------------------------------

namespace Libs\System;

use Common\Controller\Base;
use Content\Model\ContentModel;

class Html extends Base {

    //数据
    protected $data = array();
    //错误信息
    protected $error = NULL;

    //初始化
    protected function _initialize() {
        define('APP_SUB_DOMAIN_NO', 1);
        parent::_initialize();
    }

    /**
     * 获取错误提示
     * @return type
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 设置数据对象值
     * @access public
     * @param mixed $data 数据
     * @return Model
     */
    public function data($data = '') {
        if ('' === $data && !empty($this->data)) {
            return $this->data;
        }
        if (is_object($data)) {
            $data = get_object_vars($data);
        } elseif (is_string($data)) {
            parse_str($data, $data);
        } elseif (!is_array($data)) {
            E('数据类型错误！');
        }
        $this->data = $data;
        return $this;
    }

    /**
     * 获取首页页URL规则处理后的
     * @param type $data 数据
     * @param type $page 分页号
     * @return type
     */
    protected function generateIndexUrl($page = 1) {
        return $this->Url->index($page);
    }

    /**
     * 获取内容页URL规则处理后的
     * @param type $data 数据
     * @param type $page 分页号
     * @return type
     */
    protected function generateShowUrl($data, $page = 1) {
        return $this->Url->show($data, $page);
    }

    /**
     * 获取栏目页URL规则处理后的
     * @param type $catid 栏目ID
     * @param type $page 分页号
     * @return type
     */
    protected function generateCategoryUrl($catid, $page = 1) {
        return $this->Url->category_url($catid, $page);
    }

    /**
     * 另类的销毁分配给模板的变量
     * 防止生成不同类型的页面，造成参数乱窜！
     */
    protected function assignInitialize() {
        //栏目ID
        $this->assign('catid', NULL);
        //分页号
        $this->assign(C('VAR_PAGE'), NULL);
        //seo分配到模板
        $this->assign('SEO', NULL);
        $this->assign('content', NULL);
        $this->assign('pages', NULL);
    }

}