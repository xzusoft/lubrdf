<?php
// +----------------------------------------------------------------------
// | LubTMP 数据库处理类
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------
namespace Libs\System;

class Createsql {
	//存放sql模板目录
	 public $sqlPath = NULL;
	 //错误信息
    public $error = NULL;
	 
	/**
     * 构造方法
     */
    public function __construct() {
        $sqlPath = COMMON_PATH . 'Sql/';
    }
	/**
     * 连接
     * @access public
     * @return void
     */
    static public function getInstance() {
        static $createsql = NULL;
		if (empty($createsql)) {
			$createsql = new Createsql();
		}
		return $createsql;
    }
	/**
     * 获取错误提示
     * @return type
     */
    public function getError() {
        return $this->error;
    }
/**
     * 执行数据库脚本
     * @param type $sqlName 数据库模板名称
     * @return boolean
     */
    public function runSQL($sqlName = '') {
        $path = $sqlPath . "{$sqlName}.sql";
        if (!file_exists($path)) {
            return true;
        }
        $sql = file_get_contents($path);
        $sql = $this->resolveSQL($sql, C("DB_PREFIX"));
        if (!empty($sql) && is_array($sql)) {
            foreach ($sql as $sql_split) {
                M()->execute($sql_split);
            }
        }echo M()->_sql();
        return true;
    }


    /**
     * 分析处理sql语句，执行替换前缀都功能。
     * @param string $sql 原始的sql
     * @param string $tablepre 表前缀
     */
    private function resolveSQL($sql, $tablepre) {
        if ($tablepre != "lub_")
            $sql = str_replace("lub_", $tablepre, $sql);
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);
        if ($r_tablepre != $s_tablepre)
            $sql = str_replace($s_tablepre, $r_tablepre, $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num++;
        }
        return $ret;
    }
}