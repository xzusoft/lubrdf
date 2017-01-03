<?php if (!defined('LUB_VERSION')) exit(); ?>
<!--Page -->
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/User/index',array('menuid'=>$menuid));}" method="post">
  <input type="hidden" name="pageSize" value="{$numPerPage}">             
  <input type="hidden" name="pageCurrent" value="{$currentPage}">
</form>
<!--Page end-->
<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
</div>
<div class="bjui-pageContent tableContent">
  <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
    <thead>
      <tr>
        <th align="center">用户名</th>
        <th align="center">名称</th>
        <th align="center">所属角色</th>
        <th align="center">最后登录IP</th>
        <th align="center">组后登陆时间</th>
        <th align="center">E-mail</th>
        <th align="center">状态</th>
        <th align="center">添加时间</th>
      </tr>
    </thead>
    <tbody>
    <volist name="data" id="vo">
      <tr data-id="{$vo.id}">
        <td align="center"><a href="{:U('Manage/User/userinfo',array('menuid'=>$menuid,'id'=>$vo['id']));}" data-toggle="dialog" data-width="800" data-height="600" data-id="userinfo" data-mask="true">{$vo.username}</a></td>
        <td align="center">{$vo.nickname}</td>
        <td align="center">{$vo.role_id|roleName}</td>
        <td align="center">{$vo.last_login_ip} </td>
        <td align="center">{$vo.last_login_time|date="Y-m-d H:i:s",###}</td>
        <td align="center">{$vo.email}</td>
        <td align="center">{$vo.status|status}</td>
        <td align="center">{$vo.create_time|date="Y-m-d H:i:s",###}</td>
       </tr>
    </volist>
     
    </tbody>
  </table>
</div>
<div class="bjui-pageFooter">
  <div class="pages">
    <span>共 {$totalCount} 条</span>
  </div>
  <div class="pagination-box" data-toggle="pagination" data-total="{$totalCount}" data-page-size="{$numPerPage}" data-page-current="{$currentPage}"> </div>
</div>