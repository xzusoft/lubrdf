<?php if (!defined('LUB_VERSION')) exit(); ?>
<div class="bjui-pageHeader">
<!--工具条 s-->
<Managetemplate file="Common/Nav"/>
<!--工具条 e--> 
</div>
<div class="bjui-pageContent tableContent">
  <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
    <thead>
      <tr>
        <th>商户名称</th>
        <th>识别码</th>
        <th width="70">状态</th>
        <th>创建时间</th> 
      </tr>
    </thead>
    <tbody>
    <volist name="list" id="vo">
      <tr data-id="{$vo.id}">
        <td>{$vo.name}</td>
        <td>{$vo.idcode}</td>
        <td>{$vo.status|status}</td>
        <td>{$vo.createtime|date="Y-m-d H:i:s",###}</td>
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