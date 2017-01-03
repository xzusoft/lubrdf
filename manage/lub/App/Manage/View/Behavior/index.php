<?php if (!defined('LUB_VERSION')) exit(); ?>
<!--Page -->
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Behavior/index',array('menuid'=>$menuid));}" method="post">
  <input type="hidden" name="pageSize" value="{$numPerPage}">             
  <input type="hidden" name="pageCurrent" value="{$currentPage}">       
  <input type="hidden" name="orderField" value="${param.orderField}">         
  <input type="hidden" name="orderDirection" value="${param.orderDirection}">
</form>
<!--Page end-->
<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
</div>
<div class="bjui-pageContent tableContent">
  <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
    <thead>
      <tr>
        <th>行为标识</th>
        <th>行为名称</th>
        <th align="center">规则说明</th>
        <th align="center">类型</th>
        <th align="center">级别</th>
        <th align="center">状态</th>
        <th align="center">更新时间</th>
      </tr>
    </thead>
    <tbody>
    <volist name="data" id="vo">
      <tr data-id="{$vo.id}">
        <td>{$vo.name}</td>
        <td>{$vo.title}</td>
        <td>{$vo.remark}</td>
        <td><if condition="$vo['type'] eq 1">控制器<elseif condition="$vo['type'] eq 2"/>视图</if></td>
        <td align="center"><if condition="$vo['system'] eq 1">系统<else />自定义</if></td>
        <td align="center">{$vo.status|status}</td>
        <td>{$vo.datetime|datetime}</td>
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