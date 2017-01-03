<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/User/adminadd',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
	 <div class="form-group">
    <label class="col-sm-2 control-label">用户名:</label>
    <input type="text" name="username" class="form-control required" data-rule="required;name;remote[get:{:U('Manage/Check/public_check_name',array('ta'=>18))}]" size="20" placeholder="用户名">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">真实姓名:</label>
    <input type="text" name="nickname" class="form-control required" data-rule="required;" size="20" placeholder="真实姓名">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">密码:</label>
    <input type="password" name="password" class="form-control required" data-rule="required;" size="25" placeholder="密码">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">确认密码:</label>
    <input type="password" name="passwords" class="form-control required" data-rule="required;match(password)" size="25" placeholder="确认密码">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">手机:</label>
    <input type="text" name="phone" class="form-control required" data-rule="phone;required;" size="20" placeholder="手机号码">
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">email:</label>
    <input type="text" name="email" class="form-control required" data-rule="email;required;" size="30" placeholder="邮箱地址">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">权限组:</label>
    {$role}  
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">操作范围:</label>
    <volist name="group" id="vo">
      <input type="checkbox" checked="checked" data-toggle="icheck" name="group[]" value="{$vo.id}" data-label="{$vo.name}">
    </volist>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">备注:</label>
    <input type="text" name="remark" class="form-control" size="40" placeholder="备注">
  </div>
  <input type="hidden" name="is_scene" value="1">
  <div class="form-group">
    <label class="col-sm-2 control-label">状态:</label>
    <select name="status" class="required" data-toggle="selectpicker" data-rule="required">
	    <option value="">状态</option>
	    <option value="1">启用</option>
	    <option value="0">禁用</option>
	</select>
  </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>
</form>