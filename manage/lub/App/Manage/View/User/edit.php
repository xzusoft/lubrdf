<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/User/edit',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
	 <div class="form-group">
    <label class="col-sm-2 control-label">用户名:</label>
    <input type="text" name="username" class="form-control required" value="{$data.username}" size="20" placeholder="用户名">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">真实姓名:</label>
    <input type="text" name="nickname" class="form-control required" value="{$data.nickname}" data-rule="required;" size="20" placeholder="真实姓名">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">手机:</label>
    <input type="text" name="phone" class="form-control required" data-rule="phone;required;" value="{$data.phone}" size="20" placeholder="手机号码">
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">email:</label>
    <input type="text" name="email" class="form-control required" data-rule="email;required;" value="{$data.email}" size="30" placeholder="邮箱地址">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">权限组:</label>
    {$role}  
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">操作范围:</label>
    <volist name="group" id="vo">
      <input type="checkbox" <if condition="in_array($vo['id'],explode(',',$data['group']))"> checked="checked"</if> data-toggle="icheck" name="group[]" value="{$vo.id}" data-label="{$vo.name}">
    </volist>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">备注:</label>
    <input type="text" name="remark" class="form-control" size="40" placeholder="备注">
  </div>
  <input type="hidden" name="id" value="{$data.id}">
  <div class="form-group">
    <label class="col-sm-2 control-label">状态:</label>
    <select name="status" class="required" data-toggle="selectpicker" data-rule="required">
	    <option value="">状态</option>
	    <option value="1" <if condition="$data['status'] eq 1">selected</if>>启用</option>
      <option value="0" <if condition="$data['status'] eq 0">selected</if>>禁用</option>
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