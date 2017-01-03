<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/Cache/edit',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
	<div class="form-group">
    <label class="col-sm-2 control-label">缓存名称:</label>
    <input type="text" name="name" class="form-control required" data-rule="required;" size="40" value="{$data.name}" placeholder="缓存名称">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">缓存KEY值:</label>
    <input type="text" name="key" class="form-control required" data-rule="required;" size="20" value="{$data.key}" placeholder="Menu">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">模块名称:</label>
    <input type="text" name="module" class="form-control required" data-rule="required;" size="20" value="{$data.module}" placeholder="Home">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">模型名称:</label>
    <input type="text" name="model" class="form-control required" data-rule="required;" size="20" value="{$data.model}" placeholder="Index">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">方法名称:</label>
    <input type="text" name="action" class="form-control required" data-rule="required;" size="20" value="{$data.action}" placeholder="index">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">参数:</label>
    <input type="text" value="{$data.param}" name="param" class="form-control " size="30" placeholder="id=1&type=1">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">系统缓存:</label>
    <select name="system" class="required" data-toggle="selectpicker" data-rule="required">
      <option value="1" <eq name="data.system" value='1'>selected</eq>>系统缓存</option>
      <option value="0" <eq name="data.system" value='0'>selected</eq>>非系统缓存</option>
  </select>
  </div>
</div>
<input name="id" type="hidden" value="{$data.id}">
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>
</form>