<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/Rbac/roleedit',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
  <div class="form-group">
    <label class="col-sm-2 control-label">父角色:</label>
    <?php echo D('Manage/Role')->selectHtmlOption($data['parentid'],'name="parentid"') ?>
  </div>
	<div class="form-group">
    <label class="col-sm-2 control-label">角色名称:</label>
    <input type="text" name="name" class="form-control required" value="{$data.name}" data-rule="required;" size="30" placeholder="商户名称">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">角色范围:</label>
    <input type="radio" name="is_scene" data-toggle="icheck" value="1" <eq name="data['is_scene']" value="1">checked</eq> data-label="系统角色&nbsp;&nbsp;">
    <input type="radio" name="is_scene" data-toggle="icheck" value="3" <eq name="data['is_scene']" value="3">checked</eq> data-label="渠道版角色">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">角色描述:</label>
    <textarea class="form-control" rows="3" name="remark" cols="60">{$data.remark}</textarea>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">状态:</label>
    <select name="status" class="required" data-toggle="selectpicker" data-rule="required">
	    <option value="">状态</option>
	    <option value="1" <eq name="data['status']" value="1">selected</eq>>启用</option>
	    <option value="0" <eq name="data['status']" value="0">selected</eq>>禁用</option>
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