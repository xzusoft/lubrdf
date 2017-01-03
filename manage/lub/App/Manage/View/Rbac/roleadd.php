<?php if (!defined('LUB_VERSION')) exit(); ?>
<form class="form-horizontal" action="{:U('Manage/Rbac/roleadd',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
<div class="bjui-pageContent">
  <div class="form-group">
    <label class="col-sm-2 control-label">父角色:</label>
    <?php echo D('Manage/Role')->selectHtmlOption(0,'name="parentid"') ?>
  </div>
	<div class="form-group">
    <label class="col-sm-2 control-label">角色名称:</label>
    <input type="text" name="name" class="form-control required" data-rule="required;" size="30" placeholder="商户名称">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">角色范围:</label>
    <input type="radio" name="is_scene" data-toggle="icheck" value="1" data-rule="checked" data-label="系统角色&nbsp;&nbsp;">
    <input type="radio" name="is_scene" data-toggle="icheck" value="3" data-label="渠道版角色">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">角色描述:</label>
    <textarea class="form-control" rows="3" name="remark" cols="60"></textarea>
  </div>
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