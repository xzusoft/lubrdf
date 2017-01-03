-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-12-09 20:27:27
-- 服务器版本： 5.5.37-log
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zhiixao`
--

-- --------------------------------------------------------

--
-- 表的结构 `lub_access`
--

CREATE TABLE IF NOT EXISTS `lub_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `app` varchar(20) NOT NULL COMMENT '模块',
  `controller` varchar(20) NOT NULL COMMENT '控制器',
  `action` varchar(20) NOT NULL COMMENT '方法',
  `status` tinyint(4) DEFAULT '0' COMMENT '是否有效',
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色权限表';

-- --------------------------------------------------------

--
-- 表的结构 `lub_admin_panel`
--

CREATE TABLE IF NOT EXISTS `lub_admin_panel` (
  `mid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(32) NOT NULL COMMENT '菜单名',
  `url` char(255) NOT NULL COMMENT '菜单地址',
  PRIMARY KEY (`mid`,`userid`),
  UNIQUE KEY `userid` (`mid`,`userid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='常用菜单';

--
-- 转存表中的数据 `lub_admin_panel`
--

INSERT INTO `lub_admin_panel` (`mid`, `userid`, `name`, `url`) VALUES
(6, 1, '修改密码', 'Manage/Adminmanage/chanpass');

-- --------------------------------------------------------

--
-- 表的结构 `lub_behavior`
--

CREATE TABLE IF NOT EXISTS `lub_behavior` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-控制器，2-视图',
  `status` tinyint(2) NOT NULL COMMENT '状态（0：禁用，1：正常）',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '所属模块',
  `datetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统行为表' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `lub_behavior`
--

INSERT INTO `lub_behavior` (`id`, `name`, `title`, `remark`, `type`, `status`, `system`, `module`, `datetime`) VALUES
(1, 'app_init', '应用初始化标签位', '应用初始化标签位', 1, 1, 1, '', 1381021393),
(2, 'path_info', 'PATH_INFO检测标签位', 'PATH_INFO检测标签位', 1, 1, 1, '', 1381021411),
(3, 'app_begin', '应用开始标签位', '应用开始标签位', 1, 1, 1, '', 1381021424),
(4, 'action_name', '操作方法名标签位', '操作方法名标签位', 1, 1, 1, '', 1381021437),
(5, 'action_begin', '控制器开始标签位', '控制器开始标签位', 1, 1, 1, '', 1381021450),
(6, 'view_begin', '视图输出开始标签位', '视图输出开始标签位', 1, 1, 1, '', 1381021463),
(7, 'view_parse', '视图解析标签位', '视图解析标签位', 1, 1, 1, '', 1381021476),
(8, 'template_filter', '模板内容解析标签位', '模板内容解析标签位', 1, 1, 1, '', 1381021488),
(9, 'view_filter', '视图输出过滤标签位', '视图输出过滤标签位', 1, 1, 1, '', 1381021621),
(10, 'view_end', '视图输出结束标签位', '视图输出结束标签位', 1, 1, 1, '', 1381021631),
(11, 'action_end', '控制器结束标签位', '控制器结束标签位', 1, 1, 1, '', 1381021642),
(12, 'app_end', '应用结束标签位', '应用结束标签位', 1, 1, 1, '', 1381021654),
(13, 'appframe_rbac_init', '后台权限控制', '后台权限控制', 1, 1, 1, '', 1381023560);

-- --------------------------------------------------------

--
-- 表的结构 `lub_behavior_log`
--

CREATE TABLE IF NOT EXISTS `lub_behavior_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ruleid` int(10) NOT NULL COMMENT '行为ID',
  `guid` char(50) NOT NULL COMMENT '标识',
  `create_time` int(10) NOT NULL COMMENT '执行行为的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lub_behavior_rule`
--

CREATE TABLE IF NOT EXISTS `lub_behavior_rule` (
  `ruleid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `behaviorid` int(11) NOT NULL COMMENT '行为id',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '规则所属模块',
  `addons` char(20) NOT NULL COMMENT '规则所属插件',
  `rule` text NOT NULL COMMENT '行为规则',
  `listorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `datetime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`ruleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='行为规则表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `lub_behavior_rule`
--

INSERT INTO `lub_behavior_rule` (`ruleid`, `behaviorid`, `system`, `module`, `addons`, `rule`, `listorder`, `datetime`) VALUES
(1, 1, 1, '', '', 'phpfile:BuildLiteBehavior', 0, 1381021954),
(2, 3, 1, '', '', 'phpfile:ReadHtmlCacheBehavior', 0, 1381021954),
(3, 12, 1, '', '', 'phpfile:ShowPageTraceBehavior', 0, 1381021954),
(4, 7, 1, '', '', 'phpfile:ParseTemplateBehavior', 0, 1381021954),
(5, 8, 1, '', '', 'phpfile:ContentReplaceBehavior', 0, 1381021954),
(6, 9, 1, '', '', 'phpfile:WriteHtmlCacheBehavior', 0, 1381021954),
(7, 1, 1, '', '', 'phpfile:AppInitBehavior|module:Common', 0, 1381021954),
(8, 3, 1, '', '', 'phpfile:AppBeginBehavior|module:Common', 0, 1381021954),
(9, 6, 1, '', '', 'phpfile:ViewBeginBehavior|module:Common', 0, 1381021954),
(10, 9, 0, '', '', 'phpfile:TokenBuildBehavior', 0, 1407742411);

-- --------------------------------------------------------

--
-- 表的结构 `lub_cache`
--

CREATE TABLE IF NOT EXISTS `lub_cache` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `key` char(100) NOT NULL COMMENT '缓存key值',
  `name` char(100) NOT NULL COMMENT '名称',
  `module` char(20) NOT NULL COMMENT '模块名称',
  `model` char(30) NOT NULL COMMENT '模型名称',
  `action` char(30) NOT NULL COMMENT '方法名',
  `param` char(255) NOT NULL COMMENT '参数',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统1系统0非系统2客户端缓存',
  PRIMARY KEY (`id`),
  KEY `ckey` (`key`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='缓存更新列队' AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `lub_cache`
--

INSERT INTO `lub_cache` (`id`, `key`, `name`, `module`, `model`, `action`, `param`, `system`) VALUES
(1, 'Config', '网站配置', '', 'Config', 'config_cache', '', 1),
(2, 'Module', '可用模块列表', '', 'Module', 'module_cache', '', 1),
(3, 'Behavior', '行为列表', '', 'Behavior', 'behavior_cache', '', 1),
(4, 'Menu', '系统菜单', 'Manage', 'Menu', 'menu_cache', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `lub_config`
--

CREATE TABLE IF NOT EXISTS `lub_config` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(20) NOT NULL DEFAULT '',
  `info` varchar(100) NOT NULL DEFAULT '',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='网站配置表' AUTO_INCREMENT=56 ;

--
-- 转存表中的数据 `lub_config`
--

INSERT INTO `lub_config` (`id`, `varname`, `info`, `groupid`, `value`) VALUES
(1, 'sitename', '系统名称', 1, '直销管理系统--DSS v1.0'),
(2, 'siteurl', '系统地址', 1, 'http://new.leubao.com/zhixiao/'),
(3, 'sitefileurl', '附件地址', 1, 'http://new.leubao.com/zhixiao/f/c/'),
(4, 'siteemail', '管理员邮箱', 1, 'admin@admin.com'),
(6, 'siteinfo', '系统介绍', 1, '直销管理系统Direct selling management system'),
(7, 'sitekeywords', '系统关键字', 1, '直销管理系统--DSS v1.0'),
(8, 'uploadmaxsize', '允许上传附件大小', 1, '20240'),
(9, 'uploadallowext', '允许上传附件类型', 1, 'jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf'),
(10, 'qtuploadmaxsize', '前台允许上传附件大小', 1, '200'),
(11, 'qtuploadallowext', '前台允许上传附件类型', 1, 'jpg|jpeg|gif'),
(12, 'watermarkenable', '是否开启图片水印', 1, '1'),
(13, 'watermarkminwidth', '水印-宽', 1, '300'),
(14, 'watermarkminheight', '水印-高', 1, '100'),
(15, 'watermarkimg', '水印图片', 1, '/statics/images/mark_bai.png'),
(16, 'watermarkpct', '水印透明度', 1, '80'),
(17, 'watermarkquality', 'JPEG 水印质量', 1, '85'),
(18, 'watermarkpos', '水印位置', 1, '7'),
(19, 'theme', '主题风格', 1, 'Default'),
(20, 'ftpstatus', 'FTP上传', 1, '0'),
(21, 'ftpuser', 'FTP用户名', 1, 'admin'),
(22, 'ftppassword', 'FTP密码', 1, 'zhoujing'),
(23, 'ftphost', 'FTP服务器地址', 1, ''),
(24, 'ftpport', 'FTP服务器端口', 1, '21'),
(25, 'ftppasv', 'FTP是否开启被动模式', 1, '1'),
(26, 'ftpssl', 'FTP是否使用SSL连接', 1, '0'),
(27, 'ftptimeout', 'FTP超时时间', 1, '10'),
(28, 'ftpuppat', 'FTP上传目录', 1, '/'),
(29, 'mail_type', '邮件发送模式', 1, '1'),
(30, 'mail_server', '邮件服务器', 1, 'smtp.qq.com'),
(31, 'mail_port', '邮件发送端口', 1, '25'),
(32, 'mail_from', '发件人地址', 1, 'admin@chengde360.com'),
(33, 'mail_auth', '密码验证', 1, '0'),
(34, 'mail_user', '邮箱用户名', 1, 'admin'),
(35, 'mail_password', '邮箱密码', 1, '3712483'),
(36, 'mail_fname', '发件人名称', 1, 'LubTMP管理员'),
(37, 'domainaccess', '指定域名访问', 1, '0'),
(38, 'online_help', '在线帮助', 1, 'http://www.chengde360.com/help/'),
(39, 'level', '纠错级别', 1, '4'),
(40, 'code_size', '二维码大小', 1, '120'),
(41, 'q_color', '前景色', 1, '#000000'),
(42, 'clientid', '客户端默认菜单ID', 1, '129'),
(43, 'b_color', '背景色', 1, '#ffffff'),
(44, 'w_color', '定位外框线', 1, '#000000'),
(45, 'n_color', '定位内框线', 1, '#000000'),
(46, 'client_role_id', '客户端权限组ID', 1, '4'),
(47, 'channel_role_id', '渠道商权限组ID', 1, '21'),
(48, 'channelid', '渠道默认菜单ID', 1, '237'),
(49, 'channel_agents_id', '代理商级别', 1, '15'),
(50, 'level_1', '一级渠道商', 1, '16'),
(51, 'level_2', '二级渠道商', 1, '17'),
(52, 'level_3', '三级渠道商', 1, '18'),
(53, 'subtract', '核减率(定单核减)', 1, '0.1'),
(54, 'guide', '导游权限组', 1, '20'),
(55, 'guide', '导游权限组', 1, '20');

-- --------------------------------------------------------

--
-- 表的结构 `lub_config_field`
--

CREATE TABLE IF NOT EXISTS `lub_config_field` (
  `fid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `fieldname` varchar(30) NOT NULL COMMENT '字段名',
  `type` varchar(10) NOT NULL COMMENT '类型,input',
  `setting` mediumtext NOT NULL COMMENT '其他',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='网站配置，扩展字段列表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lub_loginlog`
--

CREATE TABLE IF NOT EXISTS `lub_loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `is_scene` tinyint(1) NOT NULL COMMENT '登录场景1系统2客户端',
  `username` char(30) NOT NULL COMMENT '登录帐号',
  `logintime` int(10) NOT NULL COMMENT '登录时间戳',
  `loginip` char(20) NOT NULL COMMENT '登录IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,1为登录成功，0为登录失败',
  `password` varchar(30) NOT NULL DEFAULT '' COMMENT '尝试错误密码',
  `info` varchar(255) NOT NULL COMMENT '其他说明',
  PRIMARY KEY (`id`),
  KEY `is_scene` (`is_scene`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='登陆日志表' AUTO_INCREMENT=333 ;

--
-- 转存表中的数据 `lub_loginlog`
--

INSERT INTO `lub_loginlog` (`id`, `is_scene`, `username`, `logintime`, `loginip`, `status`, `password`, `info`) VALUES
(330, 1, 'admin', 1449554240, '183.196.224.144', 1, '密码保密', '用户名登录'),
(329, 1, 'admin', 1449554143, '183.196.224.144', 0, 'admin', '用户名登录'),
(328, 1, 'admin', 1449553990, '183.196.224.144', 1, '密码保密', '用户名登录'),
(327, 1, 'admin', 1449553865, '183.196.224.144', 0, '12345', '用户名登录'),
(326, 1, 'admin', 1449553831, '183.196.224.144', 0, 'wqe', '用户名登录'),
(325, 3, 'wf', 1449413016, '120.13.23.2', 1, '密码保密', '用户名登录'),
(324, 1, 'admin', 1449375844, '183.196.224.144', 1, '密码保密', '用户名登录'),
(323, 1, 'admin', 1449375833, '183.196.224.144', 0, 'admin', '用户名登录'),
(322, 1, 'admin', 1449215813, '120.236.34.70', 1, '密码保密', '用户名登录'),
(321, 1, 'admin', 1449211705, '120.236.34.70', 1, '密码保密', '用户名登录'),
(320, 1, 'admin', 1449193980, '120.236.34.70', 1, '密码保密', '用户名登录'),
(319, 1, 'admin', 1449155222, '120.13.23.2', 1, '密码保密', '用户名登录'),
(318, 1, 'admin', 1449105674, '120.236.34.70', 1, '密码保密', '用户名登录'),
(317, 1, 'admin', 1448939545, '183.198.236.177', 1, '密码保密', '用户名登录'),
(316, 1, 'admin', 1448893622, '120.13.11.55', 1, '密码保密', '用户名登录'),
(315, 1, 'admin', 1448893615, '120.13.11.55', 0, 'chengde360', '用户名登录'),
(314, 1, 'admin', 1448858084, '183.196.224.144', 1, '密码保密', '用户名登录'),
(313, 1, 'wf', 1448544542, '27.156.40.243', 0, '123456', '用户名登录'),
(312, 1, 'wf', 1448544497, '27.156.40.243', 0, '123456', '用户名登录'),
(311, 1, 'wf', 1448544443, '27.156.40.243', 0, '123456', '用户名登录'),
(310, 1, 'admin', 1448521645, '117.29.64.181', 1, '密码保密', '用户名登录'),
(309, 1, 'admin', 1448521417, '117.29.64.181', 1, '密码保密', '用户名登录'),
(308, 1, 'admin', 1448520781, '117.29.64.181', 1, '密码保密', '用户名登录'),
(307, 3, 'wf', 1448516184, '183.196.224.144', 1, '密码保密', '用户名登录'),
(306, 3, 'wf', 1448460746, '27.156.40.243', 1, '密码保密', '用户名登录'),
(305, 1, 'admin', 1448444178, '120.13.11.55', 1, '密码保密', '用户名登录'),
(304, 1, 'admin', 1448435093, '120.13.11.55', 1, '密码保密', '用户名登录'),
(303, 1, 'admin', 1448433305, '120.13.11.55', 1, '密码保密', '用户名登录'),
(302, 1, 'zhoujing', 1448433221, '120.13.11.55', 1, '密码保密', '用户名登录'),
(301, 1, 'admin', 1448182743, '59.60.234.202', 1, '密码保密', '用户名登录'),
(300, 3, 'dd003', 1448182680, '59.60.234.202', 1, '密码保密', '用户名登录'),
(299, 3, 'wf', 1448106087, '117.31.49.56', 1, '密码保密', '用户名登录'),
(298, 1, 'admin', 1448085070, '59.60.224.192', 1, '密码保密', '用户名登录'),
(297, 1, 'cy', 1448085056, '59.60.224.192', 0, 'rabbit208', '用户名登录'),
(296, 1, 'admin', 1448078890, '117.31.48.71', 1, '密码保密', '用户名登录'),
(295, 3, 'wf', 1448035303, '117.31.48.71', 1, '密码保密', '用户名登录'),
(294, 1, 'admin', 1447991166, '117.31.49.56', 1, '密码保密', '用户名登录'),
(293, 1, 'zhoujing', 1447991067, '117.31.49.56', 1, '密码保密', '用户名登录'),
(292, 1, 'admin', 1447926869, '183.158.76.28', 1, '密码保密', '用户名登录'),
(291, 1, 'admin', 1447904433, '121.206.237.75', 1, '密码保密', '用户名登录'),
(290, 1, 'zhoujing', 1447904370, '121.206.237.75', 1, '密码保密', '用户名登录'),
(289, 1, 'admin', 1447852966, '59.60.234.202', 1, '密码保密', '用户名登录'),
(288, 1, 'admin', 1447852958, '59.60.234.202', 0, 'chengde360', '用户名登录'),
(287, 1, 'admin', 1447826723, '123.139.23.74', 1, '密码保密', '用户名登录'),
(286, 1, 'admin', 1447826712, '123.139.23.74', 0, 'admin111111', '用户名登录'),
(285, 3, 'dd003', 1447770544, '59.60.234.202', 1, '密码保密', '用户名登录'),
(284, 1, 'admin', 1447769228, '59.60.234.202', 1, '密码保密', '用户名登录'),
(283, 3, 'dd003', 1447766983, '59.60.234.202', 1, '密码保密', '用户名登录'),
(282, 1, 'zhoujing', 1447765760, '59.60.234.202', 1, '密码保密', '用户名登录'),
(281, 1, 'zhoujing', 1447759557, '59.60.234.202', 1, '密码保密', '用户名登录'),
(280, 1, 'admin', 1447757233, '117.31.22.133', 1, '密码保密', '用户名登录'),
(279, 1, 'admin', 1447748684, '121.206.237.75', 1, '密码保密', '用户名登录'),
(278, 1, 'zhoujing', 1447748366, '121.206.237.75', 1, '密码保密', '用户名登录'),
(277, 3, 'wf', 1447695850, '120.38.221.60', 1, '密码保密', '用户名登录'),
(276, 1, 'zhoujing', 1447693174, '120.38.221.60', 1, '密码保密', '用户名登录'),
(275, 1, 'admin', 1447679927, '183.54.65.162', 1, '密码保密', '用户名登录'),
(274, 1, 'admin', 1447679917, '183.54.65.162', 0, 'admin', '用户名登录'),
(273, 1, 'admin', 1447679904, '183.54.65.162', 0, 'admin123', '用户名登录'),
(272, 1, 'admin', 1447664315, '120.38.221.60', 1, '密码保密', '用户名登录'),
(271, 1, 'admin', 1447658557, '115.204.117.91', 1, '密码保密', '用户名登录'),
(270, 1, 'admin', 1447610539, '120.38.221.60', 1, '密码保密', '用户名登录'),
(269, 3, 'wf', 1447606712, '120.38.221.60', 1, '密码保密', '用户名登录'),
(268, 1, 'admin', 1447606645, '120.38.221.60', 1, '密码保密', '用户名登录'),
(267, 1, 'admin', 1447605022, '120.38.221.60', 1, '密码保密', '用户名登录'),
(266, 1, 'admin', 1447604808, '120.38.221.60', 1, '密码保密', '用户名登录'),
(265, 1, 'admin', 1447604380, '120.38.221.60', 1, '密码保密', '用户名登录'),
(264, 3, 'wf', 1447603912, '120.38.221.60', 1, '密码保密', '用户名登录'),
(263, 1, 'admin', 1447589260, '120.38.221.60', 1, '密码保密', '用户名登录'),
(262, 1, 'admin', 1447589250, '120.38.221.60', 0, '23456', '用户名登录'),
(261, 1, 'admin', 1447589242, '120.38.221.60', 0, '23456', '用户名登录'),
(260, 1, 'admin', 1447589077, '120.38.221.60', 1, '密码保密', '用户名登录'),
(259, 1, 'admin', 1447588448, '120.38.221.60', 1, '密码保密', '用户名登录'),
(258, 1, 'cy', 1447588381, '120.38.221.60', 0, 'rabbit208', '用户名登录'),
(257, 1, 'zqr', 1447588365, '120.38.221.60', 0, '654321', '用户名登录'),
(256, 1, 'zqr', 1447588355, '120.38.221.60', 0, '123456', '用户名登录'),
(255, 3, 'lb', 1447588317, '120.38.221.60', 1, '密码保密', '用户名登录'),
(254, 1, 'zqr', 1447588259, '120.38.221.60', 0, 'zhoujing', '用户名登录'),
(253, 1, 'zqr', 1447588245, '120.38.221.60', 0, '654321', '用户名登录'),
(252, 3, 'wf', 1447517480, '120.38.221.60', 1, '密码保密', '用户名登录'),
(251, 1, 'admin', 1447477701, '218.29.172.117', 0, '123123', '用户名登录'),
(250, 1, 'admin', 1447297814, '59.59.161.191', 1, '密码保密', '用户名登录'),
(249, 1, 'admin', 1447067819, '59.60.239.148', 1, '密码保密', '用户名登录'),
(248, 3, 'wf', 1447063113, '59.60.239.148', 1, '密码保密', '用户名登录'),
(247, 3, 'wf', 1447059003, '59.60.239.148', 1, '密码保密', '用户名登录'),
(246, 1, 'admin', 1446985635, '59.60.239.148', 1, '密码保密', '用户名登录'),
(245, 1, 'admin', 1446962424, '59.60.239.148', 1, '密码保密', '用户名登录'),
(244, 1, 'admin', 1446906457, '125.118.67.54', 1, '密码保密', '用户名登录'),
(243, 1, 'admin', 1446900120, '59.60.239.148', 1, '密码保密', '用户名登录'),
(242, 3, 'wf', 1446899482, '59.60.239.148', 1, '密码保密', '用户名登录'),
(241, 1, 'admin', 1446897609, '59.60.239.148', 1, '密码保密', '用户名登录'),
(240, 1, 'admin', 1446897586, '59.60.239.148', 0, 'chengde360', '用户名登录'),
(239, 1, 'admin', 1446897580, '59.60.239.148', 0, 'chengde360', '用户名登录'),
(238, 1, 'admin', 1446886986, '220.184.4.88', 1, '密码保密', '用户名登录'),
(192, 1, 'admin', 1444374261, '120.13.39.71', 0, 'chengde360', '用户名登录'),
(193, 1, 'admin', 1444374271, '120.13.39.71', 0, 'admin', '用户名登录'),
(194, 1, 'admin', 1444374281, '120.13.39.71', 1, '密码保密', '用户名登录'),
(195, 1, 'admin', 1444458897, '120.13.14.39', 0, '123456', '用户名登录'),
(196, 1, 'admin', 1444458906, '120.13.14.39', 0, 'chengde360', '用户名登录'),
(197, 1, 'admin', 1444458915, '120.13.14.39', 0, 'admin', '用户名登录'),
(198, 1, 'admin', 1444458922, '120.13.14.39', 1, '密码保密', '用户名登录'),
(199, 1, 'admin', 1444649581, '27.150.179.188', 1, '密码保密', '用户名登录'),
(200, 1, 'admin', 1444660908, '120.13.6.26', 0, '123456', '用户名登录'),
(201, 1, 'admin', 1444660916, '120.13.6.26', 1, '密码保密', '用户名登录'),
(202, 1, 'admin', 1444704439, '120.13.38.128', 1, '密码保密', '用户名登录'),
(203, 1, 'admin', 1444835045, '120.13.38.128', 1, '密码保密', '用户名登录'),
(204, 1, 'admin', 1444871792, '120.13.4.105', 1, '密码保密', '用户名登录'),
(205, 1, 'admin', 1445093448, '120.13.4.105', 1, '密码保密', '用户名登录'),
(206, 1, 'admin', 1445257986, '120.13.4.105', 0, 'zhoujing', '用户名登录'),
(207, 1, 'admin', 1445257996, '120.13.4.105', 0, 'zhoujing', '用户名登录'),
(208, 1, 'admin', 1445258009, '120.13.4.105', 1, '密码保密', '用户名登录'),
(209, 3, 'wf', 1445302267, '120.13.4.105', 1, '密码保密', '用户名登录'),
(210, 1, 'admin', 1445472973, '120.13.4.105', 1, '密码保密', '用户名登录'),
(211, 1, 'admin', 1445515590, '120.13.4.105', 0, 'chengde360', '用户名登录'),
(212, 1, 'admin', 1445515597, '120.13.4.105', 0, 'chengde360', '用户名登录'),
(213, 1, 'admin', 1445515606, '120.13.4.105', 1, '密码保密', '用户名登录'),
(214, 1, 'admin', 1445582700, '120.13.4.105', 1, '密码保密', '用户名登录'),
(215, 1, 'admin', 1445656515, '120.13.4.105', 1, '密码保密', '用户名登录'),
(216, 3, 'wf', 1445701705, '120.13.2.143', 1, '密码保密', '用户名登录'),
(217, 1, 'admin', 1445737636, '120.13.2.143', 1, '密码保密', '用户名登录'),
(218, 1, 'admin', 1445770992, '120.13.2.143', 1, '密码保密', '用户名登录'),
(219, 1, 'admin', 1445828101, '120.13.6.184', 1, '密码保密', '用户名登录'),
(220, 1, 'admin', 1445830510, '120.13.6.184', 1, '密码保密', '用户名登录'),
(221, 1, 'admin', 1445868105, '120.13.6.184', 1, '密码保密', '用户名登录'),
(222, 1, 'admin', 1445925974, '120.13.6.184', 1, '密码保密', '用户名登录'),
(223, 1, 'admin', 1445934077, '183.128.213.155', 1, '密码保密', '用户名登录'),
(224, 1, 'admin', 1446011384, '183.158.89.222', 1, '密码保密', '用户名登录'),
(225, 1, 'admin', 1446124874, '120.13.6.184', 1, '密码保密', '用户名登录'),
(226, 1, 'admin', 1446274325, '120.13.6.184', 1, '密码保密', '用户名登录'),
(227, 1, 'admin', 1446313279, '120.13.6.184', 1, '密码保密', '用户名登录'),
(228, 1, 'admin', 1446313723, '120.13.6.184', 1, '密码保密', '用户名登录'),
(229, 1, 'admin', 1446379408, '120.13.6.184', 1, '密码保密', '用户名登录'),
(230, 1, 'admin', 1446431817, '120.13.6.184', 1, '密码保密', '用户名登录'),
(231, 1, 'admin', 1446452037, '120.13.6.184', 1, '密码保密', '用户名登录'),
(232, 1, 'admin', 1446453182, '60.186.143.152', 1, '密码保密', '用户名登录'),
(233, 1, 'admin', 1446515479, '120.13.6.184', 1, '密码保密', '用户名登录'),
(234, 1, 'admin', 1446607635, '120.13.6.184', 1, '密码保密', '用户名登录'),
(235, 1, 'admin', 1446641692, '120.13.6.184', 1, '密码保密', '用户名登录'),
(236, 1, 'admin', 1446807602, '59.60.239.148', 1, '密码保密', '用户名登录'),
(237, 1, 'admin', 1446880688, '59.60.239.148', 1, '密码保密', '用户名登录'),
(331, 1, 'admin', 1449656949, '120.13.23.2', 0, 'admin', '用户名登录'),
(332, 1, 'admin', 1449656964, '120.13.23.2', 1, '密码保密', '用户名登录');

-- --------------------------------------------------------

--
-- 表的结构 `lub_member`
--

CREATE TABLE IF NOT EXISTS `lub_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` int(11) NOT NULL COMMENT '电话',
  `id_card` varchar(18) NOT NULL COMMENT '身份证号码',
  `bank` varchar(19) NOT NULL COMMENT '卡号',
  `fid` int(11) NOT NULL COMMENT '父级id',
  `createtime` int(11) NOT NULL COMMENT '添加时间',
  `password` varchar(40) NOT NULL COMMENT '密码',
  `code` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lub_menu`
--

CREATE TABLE IF NOT EXISTS `lub_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `app` char(20) NOT NULL COMMENT '应用标识',
  `controller` char(20) NOT NULL COMMENT '控制键',
  `action` char(20) NOT NULL COMMENT '方法',
  `width` int(3) unsigned NOT NULL COMMENT '弹窗宽',
  `height` int(3) unsigned NOT NULL COMMENT '弹窗高',
  `target` varchar(20) NOT NULL COMMENT '操作方式选项卡  弹窗 ajax',
  `help` varchar(200) NOT NULL COMMENT '功能帮助',
  `icon` varchar(20) NOT NULL COMMENT '图标',
  `parameter` char(255) NOT NULL COMMENT '附加参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `stype` varchar(10) NOT NULL COMMENT '按钮样式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `is_scene` tinyint(1) unsigned NOT NULL COMMENT '应用场景1系统后台2商户后台',
  `is_param` tinyint(1) NOT NULL COMMENT '参数特殊{#bjui-selected}',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `is_scene` (`is_scene`) USING BTREE,
  KEY `parentid` (`parentid`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台菜单表' AUTO_INCREMENT=501 ;

--
-- 转存表中的数据 `lub_menu`
--

INSERT INTO `lub_menu` (`id`, `name`, `parentid`, `app`, `controller`, `action`, `width`, `height`, `target`, `help`, `icon`, `parameter`, `type`, `stype`, `status`, `is_scene`, `is_param`, `listorder`) VALUES
(1, '缓存更新', 7, 'Manage', 'Index', 'cache', 0, 0, 'navTab', '', 'recycle', '', 1, '', 1, 1, 0, 0),
(2, '我的主页', 0, 'Manage', 'Idenx', 'index_info', 0, 0, 'navTab', '', 'user', '', 1, 'default', 0, 1, 0, 1),
(3, '设置', 0, 'Manage', 'Config', 'index_1', 0, 0, 'navTab', '', 'gears', '', 1, 'default', 1, 1, 0, 9),
(4, '个人信息', 2, 'Manage', 'Adminmanage', 'myinfo', 0, 0, 'dialog', '', '', '', 1, '', 0, 1, 0, 0),
(5, '修改个人信息', 4, 'Manage', 'Adminmanage', 'myinfo', 0, 0, '', '', 'user', '', 1, 'default', 1, 1, 0, 0),
(6, '修改密码', 4, 'Manage', 'Adminmanage', 'chanpass', 0, 0, 'dialog', '', '', '', 1, 'default', 0, 1, 0, 0),
(7, '系统设置', 3, 'Manage', 'Config', 'index_2', 0, 0, '', '', 'gears', '', 1, 'default', 1, 1, 0, 0),
(8, '系统配置', 7, 'Manage', 'Config', 'index', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(9, '邮箱配置', 8, 'Manage', 'Config', 'mail', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 2),
(10, '附件配置', 8, 'Manage', 'Config', 'attach', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 3),
(11, '高级配置', 8, 'Manage', 'Config', 'addition', 0, 0, 'dialog', '', 'wrench', '', 1, 'success', 1, 1, 0, 4),
(12, '扩展配置', 8, 'Manage', 'Config', 'extend', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 6),
(13, '行为管理', 7, 'Manage', 'Behavior', 'index', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(14, '行为日志', 31, 'Manage', 'Behavior', 'logs', 0, 0, 'navtab', '', '', '', 1, 'default', 1, 1, 0, 0),
(15, '编辑行为', 13, 'Manage', 'Behavior', 'edit', 0, 0, 'dialog', '', 'edit', '', 1, 'info', 1, 1, 1, 0),
(16, '删除行为', 13, 'Manage', 'Behavior', 'delete', 0, 0, 'doajax', '', 'trash', '', 1, 'danger', 1, 1, 1, 0),
(17, '菜单管理(系统)', 7, 'Manage', 'Menu', 'index', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(18, '添加菜单', 17, 'Manage', 'Menu', 'add', 0, 0, 'dialog', '', 'plus-square', 'scene=1', 1, 'success', 1, 1, 0, 0),
(19, '修改', 17, 'Manage', 'Menu', 'edit', 0, 0, 'dialog', '', 'edit', 'scene=1', 1, 'info', 0, 1, 0, 0),
(20, '删除', 17, 'Manage', 'Menu', 'delete', 0, 0, '', '', 'trash', '', 1, 'danger', 0, 1, 0, 0),
(21, '员工管理', 3, 'Manage', 'Management', 'index', 0, 0, 'navTab', '', 'user', '', 1, 'default', 1, 1, 0, 5),
(22, '员工列表', 21, 'Manage', 'User', 'index', 0, 0, 'navtab', '', 'user', '', 1, 'default', 1, 1, 0, 0),
(23, '添加人员', 22, 'Manage', 'User', 'adminadd', 0, 0, 'dialog', '', 'plus-square', '', 1, 'success', 1, 1, 0, 0),
(24, '编辑人员', 22, 'Manage', 'User', 'edit', 0, 0, 'dialog', '', 'edit', '', 1, 'info', 1, 1, 1, 0),
(25, '删除人员', 22, 'Manage', 'User', 'delete', 0, 0, 'navtab', '', 'trash', '', 1, 'danger', 1, 1, 0, 0),
(26, '权限组', 7, 'Manage', 'Rbac', 'rolemanage', 0, 0, 'navTab', '', 'flag-checkered', '', 1, '', 1, 1, 0, 0),
(27, '添加组', 26, 'Manage', 'Rbac', 'roleadd', 0, 0, 'dialog', '', 'plus-square', '', 1, 'success', 1, 1, 0, 0),
(28, '删除角色', 26, 'Manage', 'Rbac', 'roledelete', 0, 0, '', '', 'trash', '', 1, 'danger', 0, 1, 0, 0),
(29, '角色编辑', 26, 'Manage', 'Rbac', 'roleedit', 0, 0, 'dialog', '', 'edit', '', 1, 'info', 0, 1, 0, 0),
(30, '角色授权', 26, 'Manage', 'Rbac', 'authorize', 0, 0, '', '', '', '', 1, '', 0, 1, 0, 0),
(31, '日志管理', 3, 'Manage', 'Logs', 'index', 0, 0, '', '', 'server', '', 0, '', 1, 1, 0, 0),
(32, '登陆日志', 31, 'Manage', 'Logs', 'loginlog', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(33, '后台操作日志', 31, 'Manage', 'Logs', 'index', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(34, '删除一个月前的登陆日志', 32, 'Manage', 'Logs', 'deleteloginlog', 0, 0, '', '', 'trash', '', 1, 'danger', 1, 1, 0, 0),
(35, '删除一个月前的操作日志', 33, 'Manage', 'Logs', 'deletelog', 0, 0, '', '', 'trash', '', 1, 'danger', 1, 1, 0, 0),
(36, '添加行为', 13, 'Manage', 'Behavior', 'add', 0, 0, 'dialog', '', 'plus-square', '', 1, 'success', 1, 1, 0, 0),
(256, '销售查找带回', 437, 'Crm', 'Index', 'lookup', 0, 0, '', '', '', '', 1, '', 0, 1, 0, 0),
(277, '缓存队列', 7, 'Manage', 'Cache', 'cache', 0, 0, '', '', '', '', 1, '', 1, 1, 0, 0),
(278, '添加队列', 277, 'Manage', 'Cache', 'add', 0, 0, 'dialog', '', 'plus-square', '', 1, 'success', 1, 1, 0, 0),
(279, '编辑队列', 277, 'Manage', 'Cache', 'edit', 0, 0, 'dialog', '', 'edit', '', 1, 'info', 1, 1, 1, 0),
(280, '删除队列', 277, 'Manage', 'Cache', 'delete', 0, 0, 'doajax', '', 'trash', '', 1, 'danger', 1, 1, 1, 0),
(281, '个性设置', 3, 'Item', 'Set', 'index', 0, 0, 'navTab', '', 'street-view', '', 1, '', 1, 1, 0, 0),
(437, '通用配置', 3, 'Item', 'Index', 'index', 0, 0, '', '', 'support ', '', 1, 'default', 0, 1, 0, 77),
(445, '图片文件上传', 437, 'Crm', 'Customer', 'upload', 0, 0, '', '', '', '', 1, '', 0, 1, 0, 0),
(469, '人员详情', 22, 'Manage', 'User', 'userinfo', 0, 0, 'dialog', '', 'info-circle', '', 1, 'info', 0, 1, 0, 0),
(482, '登录背景', 281, 'Manage', 'Config', 'login_bj', 0, 0, 'navtab', '', '', '', 1, 'primary', 1, 1, 0, 0),
(496, '会员管理', 0, 'Manage', 'Member', 'index_1', 0, 0, 'navtab', '', 'user', '', 1, 'default', 1, 1, 0, 3),
(497, '会员管理', 496, 'Manage', 'Member', 'index_2', 0, 0, 'navtab', '', 'user', '', 1, 'default', 1, 1, 0, 0),
(498, '会员列表', 497, 'Manage', 'Member', 'index', 0, 0, 'navtab', '', 'user', '', 1, 'default', 1, 1, 0, 0),
(499, '新增会员', 498, 'Manage', 'Member', 'useradd', 0, 0, 'navtab', '', 'user-plus', '', 1, 'success', 1, 1, 0, 0),
(500, '编辑', 498, 'Manage', 'Member', 'edit', 0, 0, 'navtab', '', '', '', 1, 'default', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lub_module`
--

CREATE TABLE IF NOT EXISTS `lub_module` (
  `module` varchar(15) NOT NULL COMMENT '模块',
  `modulename` varchar(20) NOT NULL COMMENT '模块名称',
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内置模块',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否可用',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '版本',
  `setting` mediumtext NOT NULL COMMENT '设置信息',
  `installtime` int(10) NOT NULL COMMENT '安装时间',
  `updatetime` int(10) NOT NULL COMMENT '更新时间',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='已安装模块列表';

-- --------------------------------------------------------

--
-- 表的结构 `lub_operationlog`
--

CREATE TABLE IF NOT EXISTS `lub_operationlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `uid` smallint(6) NOT NULL COMMENT '操作帐号ID',
  `time` int(10) NOT NULL COMMENT '操作时间',
  `ip` char(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0错误提示，1为正确提示',
  `info` text NOT NULL COMMENT '其他说明',
  `get` varchar(255) NOT NULL COMMENT 'get数据',
  `scena` tinyint(1) unsigned NOT NULL COMMENT '创建场景1后台（manage）2前台（Item）3渠道（Home）',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `username` (`uid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台操作日志表' AUTO_INCREMENT=564 ;

--
-- 转存表中的数据 `lub_operationlog`
--

INSERT INTO `lub_operationlog` (`id`, `uid`, `time`, `ip`, `status`, `info`, `get`, `scena`) VALUES
(556, 0, 1449656949, '120.13.23.2', 0, '提示语：用户名或者密码错误，登陆失败！<br/>模块：Manage,控制器：Public,方法：tologin<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php?m=Public&a=login', 1),
(557, 1, 1449656964, '120.13.23.2', 1, '提示语：登录成功<br/>模块：Manage,控制器：Public,方法：tologin<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php?m=Public&a=login', 1),
(558, 1, 1449657078, '120.13.23.2', 1, '提示语：添加/更新成功!<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1),
(559, 1, 1449659629, '120.13.23.2', 0, '提示语：添加/更新失败！<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1),
(560, 1, 1449660718, '120.13.23.2', 1, '提示语：添加/更新成功!<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1),
(561, 1, 1449661869, '120.13.23.2', 1, '提示语：添加/更新成功!<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1),
(562, 1, 1449661882, '120.13.23.2', 1, '提示语：添加/更新成功!<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1),
(563, 1, 1449661910, '120.13.23.2', 1, '提示语：添加/更新成功!<br/>模块：Manage,控制器：Menu,方法：add<br/>请求方式：Ajax', 'http://new.leubao.com/zhixiao/index.php', 1);

-- --------------------------------------------------------

--
-- 表的结构 `lub_role`
--

CREATE TABLE IF NOT EXISTS `lub_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '角色名称',
  `parentid` smallint(6) NOT NULL COMMENT '父角色ID',
  `is_scene` tinyint(1) unsigned NOT NULL COMMENT '应用场景1系统后台2商户后台3渠道版',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色信息列表' AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `lub_role`
--

INSERT INTO `lub_role` (`id`, `name`, `parentid`, `is_scene`, `status`, `remark`, `create_time`, `update_time`, `listorder`) VALUES
(1, '超级管理员', 0, 1, 1, '拥有系统最高管理员权限！', 1329633709, 1329633709, 0),
(5, '项目权限设置', 1, 1, 1, '无实际权限，主要用于区分渠道版权限设置', 1404567762, 1446524184, 0),
(31, '售票员', 5, 1, 1, '窗口门票销售', 1446524224, 1446524224, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lub_user`
--

CREATE TABLE IF NOT EXISTS `lub_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称/姓名',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `password` char(32) NOT NULL COMMENT '密码',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) NOT NULL COMMENT '上次登录IP',
  `verify` varchar(32) NOT NULL COMMENT '证验码',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `is_scene` tinyint(1) NOT NULL COMMENT '应用场景1系统后台2商户后台3渠道商4微信',
  `role_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '对应角色ID',
  `rpassword` char(32) DEFAULT NULL COMMENT '随机密码(渠道专用)',
  `groupid` smallint(8) DEFAULT NULL COMMENT '客户分组id',
  `fid` smallint(8) NOT NULL COMMENT '上一级id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `is_scene` (`is_scene`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台用户表' AUTO_INCREMENT=309 ;

--
-- 转存表中的数据 `lub_user`
--

INSERT INTO `lub_user` (`id`, `username`, `nickname`, `phone`, `password`, `last_login_time`, `last_login_ip`, `verify`, `email`, `remark`, `create_time`, `update_time`, `status`, `is_scene`, `role_id`, `rpassword`, `groupid`, `fid`) VALUES
(1, 'admin', '超级管理员', '0', 'ce13e686346202f203b7d9a6bc4404f4', 1449656964, '120.13.23.2', 'gwY6Y3', 'admin@abc3210.com', '备注信息', 1404282986, 1421559641, 1, 1, 1, NULL, NULL, 0),
(2, 'wechat', '微信售票', '18631451216', 'cb09d2e0a74ca50243010d20020190d8', 0, '', 'p1O7TF', 'cdpc120@163.com', '', 1448169412, 1448169412, 1, 1, 31, NULL, NULL, 0),
(155, 'zqr', '郑青荣', '212', 'a4e2c88ee235a3bd9699012a7f921440', 1438853685, '110.90.34.167', 'z2kIDU', '234@qq.com', '', 1428047174, 1448092942, 1, 1, 1, NULL, NULL, 0),
(221, 'lw', 'lw', '18650689950', '7855b8cbc932198d92f02405f6c68be5', 1429579471, '59.59.140.161', 'TD6vr6', '', '', 1428338868, 1428338868, 1, 3, 9, NULL, 1, 0),
(222, 'wf', 'wf', '13459951826', 'ad2d13003c2cc977eb65a5b6d9a5b1ac', 1449413016, '120.13.23.2', 'LNHB97', '', '', 1428338967, 1428338967, 1, 3, 15, NULL, 1, 0),
(223, 'zcp', 'zcp', '13695087285', 'db290f550a15ecc3b5975878dab30de1', 1433759155, '110.82.230.91', 'NXSmSl', '', '', 1428339084, 1428339084, 1, 3, 9, NULL, 1, 0),
(224, 'lbx', 'lbx', '18905095288', '070800f9ce705f955c4d5e0be3b3f817', 1429690821, '222.78.246.158', 'HQjfTt', '', '', 1428339223, 1428339223, 1, 3, 9, NULL, 1, 0),
(225, 'lg', 'lg', '18950641659', '47b76b363afa0ad7b193793b92eff94b', 1429609606, '121.206.235.47', 'A1Cmdh', '', '', 1428339358, 1428339358, 1, 3, 9, NULL, 1, 0),
(226, 'xjl', 'xjl', '18905991980', 'f12e1e7fd5dc13e5847160123beb9c0b', 1428468948, '218.6.53.150', 'Gsyqo7', '', '', 1428339504, 1428339504, 1, 3, 9, NULL, 1, 0),
(227, 'wjy', 'wjy', '13859463687', 'e7233d670572c51fbd67f27ee8f70a28', 1429582690, '121.206.233.198', '6ZmrqG', '', '', 1428339773, 1428339773, 1, 3, 9, NULL, 1, 0),
(228, 'xly', 'xly', '18905090497', '3ac0939c097075fa2f1c40de10725fd1', 1429583713, '59.60.239.149', 'DHOxdB', '', '', 1428339898, 1428339898, 1, 3, 9, NULL, 1, 0),
(229, 'cx', 'cx', '18905995485', 'ed3d2b1e09e33634130ef39f0a9ca091', 1429579973, '59.60.236.244', 'eKOUnR', '', '', 1428340065, 1428340065, 1, 3, 9, NULL, 1, 0),
(230, 'ccq', 'ccq', '18905095300', '2e238c17b053e76b54ca9e85b9cb8e0a', 1429581300, '120.38.221.109', 'yfhyYv', '', '', 1428340170, 1428340170, 1, 3, 9, NULL, 1, 0),
(231, 'cgy', 'cgy', '13509546226', '62da905d32a2cb9dca7ab13b61659ee1', 1429580308, '121.206.234.43', 'bhVAQO', '', '', 1428340262, 1428340262, 1, 3, 9, NULL, 1, 0),
(232, 'lb', 'lb', '13859341866', 'dbf86fc4c98556c60d6051263dc226b6', 1447588317, '120.38.221.60', 'zUs9V8', '', '', 1428340409, 1428340409, 1, 3, 9, NULL, 1, 0),
(233, 'fh', 'fh', '05995258922', '404f2fa93bf7d28222e8506337670c90', 1429579568, '218.86.0.133', 'yoMDAz', '', '', 1428340519, 1428340519, 1, 3, 9, NULL, 1, 0),
(234, 'lgh', 'lgh', '13950604768', '52f874e13430e0f8d3ccaec215dbfd81', 1430909929, '110.87.223.248', '8kMB52', '', '', 1428340612, 1428340612, 1, 3, 9, NULL, 1, 0),
(235, 'pgh', 'pgh', '13960671032', 'cce33dfe531174fc9fca6155d780404b', 1428340832, '59.59.114.96', 'nbtP1T', '', '', 1428340718, 1428340718, 1, 3, 9, NULL, 1, 0),
(236, 'lcf', 'lcf', '13905097009', '00fba781d39c89df046640597d6eeac0', 0, '', 'UaVz8Q', '', '', 1428340887, 1428340887, 1, 3, 9, NULL, 1, 0),
(237, 'yc', 'yc', '13859388849', '83ba0ebff4d64d92153bf8317cab43b5', 1428341074, '59.59.114.96', 'JQLXB8', '', '', 1428340980, 1428340980, 1, 3, 9, NULL, 1, 0),
(238, 'chenyu', 'chenyu', '18960696692', 'eadc59847c601ac7d922a9be7b60f26d', 1437793817, '60.164.164.105', 'zdq1yy', '', '', 1428341066, 1428341066, 1, 3, 9, NULL, 1, 0),
(239, 'yf', 'yf', '18960696692', '4ba2cc711ba96e75b86c4bb322c83abf', 0, '', 'hFCf8x', '2824774@qq.com', '', 1428341268, 1428341268, 1, 3, 9, NULL, NULL, 0),
(240, 'sp1', '黄惠枝', '', '70a3204e6a1e9a332347bd19b8d90fd4', 1428403930, '27.157.202.65', 'RCqqmm', '23@qq.com', '', 1428341505, 1428341505, 1, 1, 31, NULL, NULL, 0),
(241, 'sp2', '林嫣', '', '58c48deee2ed442f85634c84bfcc1454', 1428816103, '220.160.221.92', 'VlscLU', '23@qq.com', '', 1428341776, 1428341776, 1, 1, 31, NULL, NULL, 0),
(242, 'sp3', '林玉者', '', 'da121c1db8bf6ba57fc0293cf232d5b6', 1429515997, '59.60.231.8', '63WAVe', '23@qq.com', '', 1428341949, 1428341949, 1, 1, 31, NULL, NULL, 0),
(243, 'sh1', '徐艳红', '', '77c2e9de9807848854bc4cc6d9e2d7aa', 1428389200, '27.157.202.65', 'NmsrZI', '23@qq.com', '', 1428342406, 1428389255, 1, 1, 22, NULL, NULL, 0),
(244, 'sh2', '叶美虹', '', '646695c376b9406b4fd78da6c946a45e', 1428405078, '27.157.202.65', 'YoG0MF', '23@qq.com', '', 1428342431, 1428342431, 1, 1, 22, NULL, NULL, 0),
(245, 'sh3', '郑伟', '', '987e4ebe24c5867ada5b58bbd4146664', 1428387670, '27.157.202.65', 'M1pKiW', '23@qq.com', '', 1428343028, 1428343028, 1, 1, 22, NULL, NULL, 0),
(246, 'xm', '相敏', '', '1eb179b577f233565fd37d6cfdadc23b', 1428343666, '59.59.114.96', 'j5tYyf', '1111@qq.com', '', 1428343605, 1428343605, 1, 1, 24, NULL, NULL, 0),
(247, 'lmz', '林美珍', '', '65991019f9662d3de353a27c07d33fea', 0, '', 'nTPdZg', '1111@qq.com', '', 1428343644, 1428343644, 1, 1, 24, NULL, NULL, 0),
(248, 'hxf', '黄晓芳', '', '3087705a5e8315830417c59ac35fc4a8', 1428396070, '222.78.246.246', 'kApL8o', '23@qq.com', '', 1428343774, 1428343774, 1, 1, 25, NULL, NULL, 0),
(249, 'xc1', '曾金华', '', '949e6fea19a33316f4799967d26d4f11', 1428346943, '59.59.114.96', 'JpbhHC', '1111@qq.com', '', 1428344766, 1428344766, 1, 1, 27, NULL, NULL, 0),
(250, 'dd001', '黄总', '18279363732', '541cebddbc7753476f3c36613d3c6cb6', 1434200187, '61.175.96.182', 'BwTgNZ', '501267502@QQ.COM', '', 1428345560, 1428648746, 1, 3, 9, NULL, 3, 0),
(251, 'dd002', 'dd002', '13850921011', 'cd899b0a01aa007f67dfe7d149d68e94', 1431395869, '27.150.178.185', 'HN3URG', '', '', 1428345583, 1428345583, 1, 3, 9, NULL, 3, 0),
(252, 'kanpiao', 'kanpiao', '18960696692', 'c729406473a7f52b9ae2c0d0e16fa31a', 1428345693, '59.59.114.96', 'LCYF2B', '', '', 1428345677, 1428345677, 1, 3, 9, NULL, 1, 0),
(253, 'zlh', 'zlh', '13706010936', 'b1f1ea65279a0001133494c9fda7ae64', 1428395731, '27.150.167.99', '2eG8e5', '1111@qq.com', '', 1428346093, 1428346093, 1, 3, 29, NULL, NULL, 0),
(254, 'zjh', 'zjh', '18960696662', '18c2eaf04f0c63ebc33a584e5e4aa9bf', 1428398966, '27.149.211.138', 'Y1yMDP', '1111@qq.com', '', 1428346231, 1428346231, 1, 3, 29, NULL, NULL, 0),
(255, 'plm', 'plm', '13960678060', '52a933f426a5503e474a4fb8f1fc4d75', 0, '', 'vq7JeA', '1111@qq.com', '', 1428346515, 1428346515, 1, 3, 29, NULL, NULL, 0),
(256, 'wx', 'wx', '18960696662', '06c23e3348cf3c141bd99c51405ebad7', 1428404899, '59.60.226.160', '7GbfFP', '1111@qq.com', '', 1428346774, 1428346774, 1, 3, 29, NULL, NULL, 0),
(257, 'zlz', 'zlz', '18960696662', '03190ea02c04f50fac160429510f0461', 1428346818, '59.59.114.96', 'po5bxI', '1111@qq.com', '', 1428346808, 1428346808, 1, 3, 29, NULL, NULL, 0),
(258, 'cp1', '售票员1', '', 'c666a83b9dcbbb1c2967ad97b538f129', 1428480826, '121.206.232.245', 'Lcom6n', '1111@qq.com', '', 1428372057, 1428372057, 1, 1, 30, NULL, NULL, 0),
(259, 'cp2', '打票员2', '', 'cd697ce62fb6714647d55938849d6aeb', 1428372381, '59.59.114.96', 'RpTiHB', '1111@qq.com', '', 1428372113, 1428372113, 1, 1, 30, NULL, NULL, 0),
(260, 'liuwenhui', '刘文辉', '13950677687', '13dbb888cca0d2474a51d3f17d5d8c05', 1428375321, '218.86.0.133', 'aWf2VP', '549516581@qq.com', '', 1428372203, 1428372203, 1, 3, 9, NULL, NULL, 0),
(261, 'chenlina', '陈莉娜', '14759930918', '1170028eb48d775011ad6ec476ca0b9f', 1428375209, '218.86.0.133', 'aqtufn', '549516581@qq.com', '', 1428372256, 1428372256, 1, 3, 10, NULL, NULL, 0),
(265, 'luojunfei', '罗俊飞', '18950687713', 'cbb1ac200be3fa18ba68461767a20891', 1429582913, '59.60.226.231', 'y2xnau', '108887506@qq.com', '', 1428384029, 1428384029, 1, 3, 10, NULL, NULL, 0),
(266, 'cp3', '出票员3', '', '1d6665a4584474ff8642051d20d95a8f', 0, '', 'kQdNc7', '23@qq.com', '在', 1428385512, 1428385512, 1, 1, 30, NULL, NULL, 0),
(267, 'cp4', '出票员4', '', '129dd9457e3af1afd70131095a18593b', 0, '', 'YBsmuD', '42342@126.com', '', 1428385562, 1428385562, 1, 1, 30, NULL, NULL, 0),
(268, 'zhoujing', '周靖', '', 'e14e32be552b559e9b624054a7e51e95', 1448433221, '120.13.11.55', '9bMyom', 'zhoujing@163.com', '', 1428390318, 1428390318, 1, 1, 2, NULL, NULL, 0),
(269, 'liu', 'liu', '18605990748', '377f25144cf43cd281adad01ce05814b', 1428416043, '220.160.220.23', 'FZV963', '416509430@QQ.com', '', 1428397559, 1428397559, 1, 3, 2, NULL, NULL, 0),
(272, 'wangziyin', '王子吟', '13386991989', 'a2005d71b473972a3c64c0861cc575e2', 1428400089, '59.60.228.254', 'NEK0hO', '929814626@qq.com', '', 1428399601, 1428399601, 0, 3, 9, NULL, NULL, 0),
(273, 'chenfa', '陈发', '13860037290', 'c2942d193d99b44e5e46e2d4df9c0aad', 0, '', 'lt6F1i', '23@qq.com', '', 1428479252, 1428479252, 1, 3, 9, NULL, 9, 0),
(274, 'qd', 'qd', '18634151216', '90699a3c4d3d002b99f5f3e0e1941c38', 1428580768, '117.44.105.220', 'xo2uEh', '', '', 1428560133, 1428560133, 0, 3, 9, NULL, 1, 0),
(275, 'dd', 'dd', '18631451216', '946ccde382ed04ee93a845300be83ecf', 1428647364, '220.176.228.100', 'BNMWay', '', '', 1428565609, 1428565609, 1, 3, 9, NULL, 3, 0),
(276, 'wf1', 'wf1', '13463652179', 'ab5904a03137ff1d460b49f0b2b34413', 1436251537, '123.138.32.66', 'NNHnuf', '', '', 1428581062, 1428581062, 1, 3, 9, NULL, 1, 0),
(277, 'wulei', '吴磊', '', '65772a4c8552dd7daf5acd9b1970bf69', 1436251549, '123.138.32.66', 'vKKWMW', 'wulei@wulei.com', '', 1428904802, 1428904802, 1, 1, 4, NULL, NULL, 0),
(279, 'dd003', 'dd003', '18960696692', '1ac99d7cc94cf5cb94ccef48795abfcf', 1448182680, '59.60.234.202', 'uR2yMt', '', '', 1428931249, 1428931249, 1, 3, 19, NULL, 3, 0),
(280, 'yuangong2', '员工2', '18631451216', 'bb5e3caf29aeadf3024e2344669c7aaf', 1430024548, '120.13.51.106', 'YrLQIU', 'ce@sina.com', '', 1429795802, 1429795802, 1, 3, 9, NULL, NULL, 0),
(281, 'daoyou1', '导游1', '18631451216', '1f487cff7c66bc1154f1b81de5858de9', 0, '', 'kiMfxn', '', '', 1429951298, 1429951298, 1, 3, 0, NULL, 2, 0),
(282, '俞琼艳', '俞琼艳', '', 'c7f6bcdc2eed57a6fe92774aeeed4553', 1430972806, '61.175.96.182', 'Trkxy5', 'jolita_esp@126.com', '', 1430972582, 1430972582, 1, 1, 1, NULL, NULL, 0),
(283, 'fw', 'fw', '13200987654', 'aa4d25aee66c4bea76a44bb57e410b75', 1431237764, '183.184.19.231', 'Ry0ll5', '', NULL, 1431237753, 1431237753, 2, 3, 9, NULL, 1, 0),
(284, 'wu', 'wu', '13123232132', '58bc93aaf24e455972beba64fdd86c65', 0, '', 'RhYTlT', '', NULL, 1431507763, 1431507763, 1, 3, 9, NULL, 1, 0),
(285, '12323', '12323', '12312312321', '66a69cd0cae98d84f3e210cdfe305988', 0, '', 'tyGTZr', '', NULL, 1431507941, 1431507941, 1, 3, 10, NULL, 2, 0),
(286, '123', '123', '12312312312', 'f9dbe7f8c525c4a614ce4a5721fdcc10', 0, '', '6Y7WYO', '', NULL, 1431678196, 1431678196, 1, 3, 9, NULL, 1, 0),
(287, '1111', '1111', '18631451216', 'bdde15ac4b7b00c4f2aab024f17502cc', 0, '', 'pqXdYF', '', NULL, 1431938807, 1431938807, 1, 3, 9, NULL, 1, 0),
(288, '', 'yuan', '18631451216', '59d864e7191e621f567a8cf7d7fda001', 0, '', '3PThiM', '', NULL, 1432020441, 1432020441, 0, 3, 9, NULL, 1, 0),
(289, 'keda', '科大11', '18631451216', '04490016b2a67071081e7fd15d14883c', 0, '', 'qtb0IK', '', NULL, 1432021537, 1432021537, 0, 3, 9, NULL, 1, 0),
(290, 'wangshumei', '王淑梅', '', '0a14277d5f6436bf4fb785a3155d63f3', 1432521859, '182.108.207.108', '1xUc5O', 'cdpc120@163.com', '', 1432521631, 1432521631, 1, 1, 4, NULL, NULL, 0),
(291, 'wf3', 'wf3', '18631451216', '9029d78cfc14e1ab39196df19ed1525f', 1432886470, '121.26.231.38', 'BsnjHO', '221@das.com', NULL, 1432886357, 1432886357, 1, 3, 9, NULL, NULL, 0),
(292, 'chengde', '承德', '18631451216', '952a9337322644f125c912e0906240e8', 0, '', 'VfLf37', 'sad@fdg.com', NULL, 1432888623, 1432888623, 1, 3, 9, NULL, 1, 0),
(293, 'nihao', 'nihao', '18631451216', '950a67aff02f6748deaf2499997e36c8', 1433416164, '120.13.30.180', 'hWZIBk', 'xc@sxa.com', NULL, 1433407574, 1433407574, 0, 3, 9, NULL, 1, 0),
(294, 'zj', 'zj', '', 'f1439e6bf34c852e4740bfe9024d0ff7', 1435154480, '120.13.23.61', 'ScUEFk', 'cdpc120@163.com', '', 1435145359, 1435145359, 1, 1, 30, NULL, NULL, 0),
(295, '12', '12', '18631451216', '6c45d9918bb7ac93ccc6ac61daf921b6', 0, '', 'wHz0p7', '', NULL, 1437708567, 1437708567, 0, 3, 9, '123456', 1, 0),
(296, '123456', '1212', '18631451216', '86966435bfec68bc58bd571f483e2775', 1438249770, '60.164.164.105', '8exjgn', '', NULL, 1438249754, 1438249754, 1, 3, 9, '123456', 2, 0),
(297, '你哈', '阿斯达岁的', '', '4c8fe9a97b03695b3550605cb009329b', 0, '', 'dJZ2SV', 'sd@s.com', '', 1441432467, 1441432467, 1, 0, 4, NULL, NULL, 0),
(298, '231', '123', '', '02307b22981c77dc2fbc862c8b73ada0', 0, '', 'cKHBP9', '12312s@s.gg', '112', 1441432593, 1441432593, 1, 0, 30, NULL, NULL, 0),
(299, '12345', '周', '18960696692', '427518f93223ff1990c496bc7b7d27fe', 0, '', 'rJmBHn', 'cdpc120@163.com', '', 1441438955, 1441438955, 1, 1, 2, NULL, NULL, 0),
(300, '12312', '1231', '13315889666', '70955a27ae4e14fedb644598681d394c', 0, '', 'lEKTcn', '12312s@s.gg', '', 1441440182, 1441440182, 1, 1, 25, NULL, NULL, 0),
(301, 'product', '周靖', '18631451216', '27bfe6677a06104b52abc193ec391a26', 0, '', 'BfQnsb', 'cdpc120@163.com', '', 1441447479, 1441447479, 1, 1, 26, NULL, NULL, 0),
(302, '1231', '12', '13315889666', 'e7db4c98135c90bfa016cb0013cd77e4', 0, '', 'YlPvMO', '12312s@s.gg', '', 1441447602, 1441447602, 1, 1, 3, NULL, NULL, 0),
(303, '测试', '1123', '18732439121', 'be6cf995bfd72e9804475e718bac81d5', 0, '', '21oetO', 'cdpc120@163.com', '', 1441447744, 1441447744, 1, 1, 2, NULL, NULL, 0),
(304, 'nh', '123456', '18631451216', 'fb0b4777d5c9b0f8827377e3d0e7ca5c', 0, '', 'hrxMiR', 'cdpc120@163.com', '', 1441447850, 1441447850, 1, 1, 25, NULL, NULL, 0),
(305, 'nihao1', 'hah', '13315889666', '9c8ef62616b1db6f362f3310e8fbc2bf', 0, '', 'vn42GW', 'cdpc120@163.com', '', 1441448137, 1441448137, 1, 1, 22, NULL, NULL, 0),
(306, 'ti', '123456', '13315889666', '8ee17ecbe1534a938865efba3522808a', 0, '', 'pvFpVQ', 'cdpc120@163.com', '', 1441448269, 1441448269, 1, 1, 22, NULL, NULL, 0),
(307, 'zhou', '周靖', '13463652179', 'ac01aee953d2147f674a5b869afb62b3', 1443247302, '120.13.6.26', 'fdev6h', 'cdpc@163.com', '', 1443247288, 1443247288, 1, 1, 2, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lub_user_data`
--

CREATE TABLE IF NOT EXISTS `lub_user_data` (
  `user_id` smallint(5) NOT NULL,
  `id_card` varchar(18) NOT NULL COMMENT '身份证号',
  `bank` varchar(100) DEFAULT NULL COMMENT '开户银行',
  `bank_account` varchar(20) DEFAULT NULL COMMENT '银行账号',
  `wechat` varchar(50) DEFAULT NULL COMMENT '微信号',
  `weibo` varchar(50) DEFAULT NULL COMMENT '微博',
  `type` tinyint(3) DEFAULT NULL COMMENT '导游类型',
  `sex` tinyint(1) NOT NULL COMMENT '性别'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `lub_user_data`
--

INSERT INTO `lub_user_data` (`user_id`, `id_card`, `bank`, `bank_account`, `wechat`, `weibo`, `type`, `sex`) VALUES
(221, '5345345345', NULL, NULL, '', '', 0, 1),
(222, '5435345435', NULL, NULL, '', '', 0, 1),
(223, '543523453453', NULL, NULL, '', '', 0, 1),
(224, '5245245345', NULL, NULL, '', '', 0, 1),
(225, '54353453454', NULL, NULL, '', '', 0, 1),
(226, '524543534', NULL, NULL, '', '', 0, 1),
(227, '542543534', NULL, NULL, '', '', 0, 1),
(228, '4356346534', NULL, NULL, '', '', 0, 1),
(229, '245235345', NULL, NULL, '', '', 0, 1),
(230, '5234532534', NULL, NULL, '', '', 0, 1),
(231, '5435345345', NULL, NULL, '', '', 0, 1),
(232, '54353453', NULL, NULL, '', '', 0, 1),
(233, '542534534', NULL, NULL, '', '', 0, 1),
(234, '43253453453', NULL, NULL, '', '', 0, 1),
(235, '5345324532', NULL, NULL, '', '', 0, 1),
(236, '543534534', NULL, NULL, '', '', 0, 1),
(237, '543534534', NULL, NULL, '', '', 0, 1),
(238, '54534534', NULL, NULL, '', '', 0, 1),
(250, '', NULL, NULL, NULL, NULL, NULL, 1),
(251, '', NULL, NULL, NULL, NULL, NULL, 1),
(252, '3424552353245', NULL, NULL, '', '', 0, 1),
(274, '12', NULL, NULL, '', '', 0, 1),
(275, '', NULL, NULL, NULL, NULL, NULL, 1),
(276, '1232131', NULL, NULL, '', '', 0, 1),
(0, '122321', NULL, NULL, '', '', 0, 1),
(279, '', NULL, NULL, NULL, NULL, NULL, 1),
(281, '12355', NULL, NULL, '', '', 0, 1),
(283, '14222317659876098', NULL, NULL, '', '', 0, 1),
(284, '12312', NULL, NULL, '', '', 0, 1),
(285, '12312312', NULL, NULL, '', '', 0, 1),
(286, '1231233', NULL, NULL, '', '', 0, 1),
(287, '5455454', NULL, NULL, '', '', 0, 1),
(288, '1232131', NULL, NULL, '', '', 0, 1),
(289, '112', NULL, NULL, '', '', 0, 1),
(295, '12312', NULL, NULL, '', '', 0, 1),
(296, '11111111111', NULL, NULL, '', '', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
