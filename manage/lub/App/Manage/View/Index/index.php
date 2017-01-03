<?php if (!defined('LUB_VERSION')) exit(); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--让360浏览器自动进入急速模式-->
<meta name="renderer" content="webkit">
<title>{$Config.company}</title>
<link rel="apple-touch-icon" href="{$config_siteurl}static/images/favicon.ico">
<link rel="icon" href="{$config_siteurl}static/images/favicon.ico">
<Managetemplate file="Common/cssjs"/>
<!-- init -->
<script type="text/javascript">
$(function() {
    BJUI.init({
        JSPATH       : '{$config_siteurl}static/bjui/',         //[可选]框架路径
        PLUGINPATH   : '{$config_siteurl}static/bjui/plugins/', //[可选]插件路径
        loginInfo    : {url:'{:U('Manage/Index/login_time');}', title:'登录', width:400, height:200}, // 会话超时后弹出登录对话框
        statusCode   : {ok:200, error:300, timeout:301}, //[可选]
        ajaxTimeout  : 5000, //[可选]全局Ajax请求超时时间(毫秒)
        pageInfo     : {total:'total', pageCurrent:'pageCurrent', pageSize:'pageSize', orderField:'orderField', orderDirection:'orderDirection'}, //[可选]分页参数
        alertMsg     : {displayPosition:'topcenter', displayMode:'slide', alertTimeout:1500}, //[可选]信息提示的显示位置，显隐方式，及[info/correct]方式时自动关闭延时(毫秒)
        keys         : {statusCode:'statusCode', message:'message'}, //[可选]
        ui           : {
                         windowWidth      : 0,    //框架可视宽度，0=100%宽，> 600为则居中显示
                         showSlidebar     : true, //[可选]左侧导航栏锁定/隐藏
                         clientPaging     : true, //[可选]是否在客户端响应分页及排序参数
                         overwriteHomeTab : false //[可选]当打开一个未定义id的navtab时，是否可以覆盖主navtab(我的主页)
                       },
        debug        : false,    // [可选]调试模式 [true|false，默认false]
        theme        : 'blue' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
    })
    // main - menu
    $('#bjui-accordionmenu')
        .collapse()
        .on('hidden.bs.collapse', function(e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                if ($a.hasClass('collapsed')) $heading.removeClass('active')
            })
        })
        .on('shown.bs.collapse', function (e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                
                if (!$a.hasClass('collapsed')) $heading.addClass('active')
            })
        })
    
    $(document).on('click', 'ul.menu-items > li > a', function(e) {
        var $a = $(this), $li = $a.parent(), options = $a.data('options').toObj()
        var onClose = function() {
            $li.removeClass('active')
        }
        var onSwitch = function() {
            $('#bjui-accordionmenu').find('ul.menu-items > li').removeClass('switch')
            $li.addClass('switch')
        }
        
        $li.addClass('active')
        if (options) {
            options.url      = $a.attr('href')
            options.onClose  = onClose
            options.onSwitch = onSwitch
            if (!options.title) options.title = $a.text()
            
            if (!options.target)
                $a.navtab(options)
            else
                $a.dialog(options)
        }
        
        e.preventDefault()
    })
})

//菜单-事件
function MainMenuClick(event, treeId, treeNode) {
    event.preventDefault()
    if (treeNode.isParent) {
        var zTree = $.fn.zTree.getZTreeObj(treeId)
        zTree.expandNode(treeNode, !treeNode.open, false, true, true)
        return
    }
    if (treeNode.target && treeNode.target == 'dialog')
        $(event.target).dialog({id:treeNode.tabid, url:treeNode.url, title:treeNode.name})
    else
        $(event.target).navtab({id:treeNode.tabid, url:treeNode.url, title:treeNode.name, fresh:treeNode.fresh, external:treeNode.external})
    }
</script>
</head>
<body> 
<!--[if lte IE 7]>
        <div id="errorie"><div>您还在使用老掉牙的IE，正常使用系统前请升级您的浏览器到 IE8以上版本 <a target="_blank" href="http://windows.microsoft.com/zh-cn/internet-explorer/ie-8-worldwide-languages">点击升级</a>&nbsp;&nbsp;强烈建议您更改换浏览器：<a href="http://down.tech.sina.com.cn/content/40975.html" target="_blank">谷歌 Chrome</a></div></div>
    <![endif]-->
<div id="bjui-window">
  <header id="bjui-header">
    <nav id="bjui-hnav-navbar-box" class='navbar navbar-inverse navbar-fixed-top'>
      <div class='navbar-header'> <a class='navbar-brand' href=''>LUBRDF cloud</a> </div>
      <div class='collapse navbar-collapse'>
        <ul id="bjui-hnav-navbar" class='nav navbar-nav'>
          <volist name="SUBMENU_CONFIG" id="menu" key='k'>
            <li <if condition="$k eq '1'">class="active"</if>><a href="javascript:;" data-toggle="slidebar"><i class="fa fa-{$menu.icon}"></i> {$menu.name}</a>
              <div class="items hide" data-noinit="true">
              <volist name="menu['items']" id="items">
              <ul class="menu-items" data-faicon="{$items.icon}" data-tit="{$items.name}">
                <volist name="items['items']" id="item">
                <li><a href="{$item.url}" data-tabid="{$item.id}" data-options="{id:'{$item.id}', faicon:'caret-right'}">{$item.name}</a></li>
                 </volist>               
              </ul>
              
              </volist></div> 
            </li>
          </volist>
        </ul>
        <ul class='nav navbar-nav navbar-right'>
          <!--<li><a href="#">消息 <span class="badge">4</span></a></li>-->
          
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">我的账户 <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{:U('Manage/Adminmanage/chanpass');}" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="465" data-height="240">&nbsp;<span class="fa fa-lock"></span> 修改密码&nbsp;</a></li>
              <li><a href="{:U('Manage/Adminmanage/myinfo');}" data-toggle="dialog" data-id="myinfo_page" data-mask="true" data-width="465" data-height="240">&nbsp;<span class="fa fa-user"></span> 我的资料</a></li>
              <li class="divider"></li>
              <li><a href="{:U('Public/logout')}" class="red">&nbsp;<span class="fa fa-power-off"></span> 注销登陆</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle theme blue" data-toggle="dropdown" title="切换皮肤"><i class="fa fa-tree"></i></a>
            <ul class="dropdown-menu" role="menu" id="bjui-themes">
              <li><a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-tree"></i> 黑白分明&nbsp;&nbsp;</a></li>
              <li><a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-tree"></i> 橘子红了</a></li>
              <li><a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-tree"></i> 紫罗兰</a></li>
              <li class="active"><a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-tree"></i> 天空蓝</a></li>
              <li><a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-tree"></i> 绿草如茵</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <div id="bjui-container">
    <div id="bjui-leftside">
      <div id="bjui-sidebar-s">
        <div class="collapse"></div>
      </div>
      <div id="bjui-sidebar">
        <div class="toggleCollapse">
          <h2> <i class="icon-bars"></i> 导航栏 <i class="icon-bars"></i></h2>
          <a href="javascript:;" class="lock"><i class="icon-double-angle-left"></i></a></div>
        <div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu" data-heightbox="#bjui-sidebar" data-offsety="26"> </div>
      </div>
    </div>
    <div id="bjui-navtab" class="tabsPage">
      <div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navtab-tab nav nav-tabs">
            <li data-url="{:U('Manage/Index/index_info');}"><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>
          </ul>
        </div>
        <div class="tabsLeft"><i class="fa  fa-angle-double-left"></i></div>
        <div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
        <div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
      </div>
      <ul class="tabsMoreList">
        <li><a href="javascript:;">#maintab#</a></li>
      </ul>
      <div class="navtab-panel tabsPageContent">
        <div class="navtabPage unitBox">
          <div class="bjui-pageContent" style="background:#FFF;"> Loading... </div>
        </div>
      </div>
    </div>
  </div>
  <footer id="bjui-footer">Copyright &copy; <?php echo date('Y');?>  <a href="http://www.leubao.com/" target="_blank">leubao.com</a><span class="f-right" >Powered by LUBRDF 企业快速开发框架 Pro 1473</span></footer>
</div>
</body>
<script>
/*设置全局变量*/
var USER_INFO = {$USER_INFO};

</script>
</html>