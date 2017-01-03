<?php if (!defined('LUB_VERSION')) exit(); ?>
<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
</div>
<div class="bjui-pageContent tableContent">
 <form name="myform" action="{:U("Rbac/listorders")}" method="post">
 <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
    <thead>
      <tr>
        <th width="40">ID</th>
        <th>角色名称</th>
        <th align="center">角色范围</th>
        <th align="center">角色描述</th>
        <th align="center">状态</th>
        <th align="center">管理操作</th>
      </tr>
    </thead>
    <tbody>
        {$role}
    </tbody>
   </table>
  </form>
</div>
<div class="bjui-pageFooter"></div>