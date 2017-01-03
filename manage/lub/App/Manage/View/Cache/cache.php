<?php if (!defined('LUB_VERSION')) exit(); ?>
<!--Page -->
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Cache/cache',array('menuid'=>$menuid));}" method="post">
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
        <th>缓存名称</th>
        <th align="center">缓存key值</th>
        <th align="center">模块名称</th>
        <th align="center">模型名称</th>
        <th align="center">方法名称</th>
        <th align="center">参数</th>
        <th align="center">级别</th>
      </tr>
    </thead>
    <tbody>
      <volist name="data" id="vo">
        <tr data-id="{$vo.id}">
          <td>{$vo.name}</td>
          <td>{$vo.key}</td>
          <td>{$vo.module}</td>
          <td>{$vo.model}</td>
          <td>{$vo.action}</td>
          <td>{$vo.param}</td>
          <td><if condition="$vo['system'] eq 1">系统
              <else />
              自定义</if></td>
        </tr>
      </volist>
    </tbody>
  </table>
</div>
<div class="bjui-pageFooter">
  <div class="pages"> <span>共 {$totalCount} 条</span> </div>
  <div class="pagination-box" data-toggle="pagination" data-total="{$totalCount}" data-page-size="{$numPerPage}" data-page-current="{$currentPage}"> </div>
</div>