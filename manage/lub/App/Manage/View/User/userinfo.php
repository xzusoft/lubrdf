<?php if (!defined('LUB_VERSION')) exit(); ?>
<div class="bjui-pageContent">
  <table class="table table-bordered table-condensed">
    <tbody>
      <tr>
        <td><label class="control-label x85">姓名:</label>{$data.nickname}</td>
        <td><label class="control-label x85">用户名:</label>{$data.username}</td>
      </tr>
      <tr>
        <td><label class="control-label x85">电话:</label>{$data.phone}</td>
        <td><label class="control-label x85">E-mail:</label>{$data.email}</td>
      </tr>
      <tr>
        <td><label class="control-label x90">最后登陆时间:</label>{$data.last_login_time|date="Y-m-d H:i:s",###}</td>
        <td><label class="control-label x90">最后登陆IP:</label>{$data.last_login_ip}</td>
      </tr>
      <tr>
        <td><label class="control-label x85">状态:</label>{$data.status|status}</td>
        <td><label class="control-label x85">所属角色:</label>{$data.role_id|roleName}</td>
      </tr>
     
      <tr>
        <td><label class="control-label x85">备注:</label>{$data.remark}</td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="bjui-pageFooter">
  <ul>
    <li>
      <button type="button" class="btn-close" data-icon="close">关闭</button>
    </li>
  </ul>
</div>