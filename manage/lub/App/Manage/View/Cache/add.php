<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/Cache/add',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
	<div class="form-group">
    <label class="col-sm-2 control-label">缓存名称:</label>
    <input type="text" name="name" class="form-control required" data-rule="required;" size="40" placeholder="缓存名称">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">缓存KEY值:</label>
    <input type="text" name="key" class="form-control required" data-rule="required;" size="20" placeholder="Menu">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">模块名称:</label>
    <input type="text" name="module" class="form-control required" data-rule="required;" size="20" placeholder="Home">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">模型名称:</label>
    <input type="text" name="model" class="form-control required" data-rule="required;" size="20" placeholder="Index">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">方法名称:</label>
    <input type="text" name="action" class="form-control required" data-rule="required;" size="20" placeholder="index">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">参数:</label>
    <input type="text" name="param" class="form-control " size="30" placeholder="id=1&type=1">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">系统缓存:</label>
    <select name="system" class="required" data-toggle="selectpicker" data-rule="required">
      <option value="1">系统缓存</option>
      <option value="0">非系统缓存</option>
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