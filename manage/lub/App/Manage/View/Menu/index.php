<script type="text/javascript">
//单击事件
function ZtreeClick(event, treeId, treeNode) {
    event.preventDefault();
    var $detail = $('#ztree-detail-{$scene}');
  //  alert(treeNode.id);
    if ($detail.attr('tid') == treeNode.tId) return
	if (treeNode.name) $('#j_menu_title_{$scene}').val(treeNode.name)
    treeNode.id ? $('#j_menu_id_{$scene}').val(treeNode.id) : $('#j_menu_id_{$scene}').val('');
    treeNode.pid ? $('#j_menu_pid_{$scene}').val(treeNode.pid) : $('#j_menu_pid_{$scene}').val('0');
    treeNode.app ? $('#j_menu_app_{$scene}').val(treeNode.app) : $('#j_menu_app_{$scene}').val('');
    treeNode.model ? $('#j_menu_model_{$scene}').val(treeNode.model) : $('#j_menu_model_{$scene}').val('');
    treeNode.action ? $('#j_menu_action_{$scene}').val(treeNode.action) : $('#j_menu_action_{$scene}').val('');
    treeNode.faicon ? $('#j_menu_icon_{$scene}').val(treeNode.faicon) : $('#j_menu_icon_{$scene}').val('');
    treeNode.type ? $('#j_menu_type_{$scene}').val(treeNode.type) : $('#j_menu_type_{$scene}').val('');
    treeNode.status ? $('#j_menu_status_{$scene}').val(treeNode.status) : $('#j_menu_status_{$scene}').val('');
    treeNode.target ? $('#j_menu_target_{$scene}').val(treeNode.target) : $('#j_menu_target_{$scene}').val('');
    treeNode.width ? $('#j_menu_width_{$scene}').val(treeNode.width) : $('#j_menu_width_{$scene}').val('');
    treeNode.height ? $('#j_menu_height_{$scene}').val(treeNode.height) : $('#j_menu_height_{$scene}').val('');
    treeNode.scene ? $('#j_menu_scene_{$scene}').val(treeNode.scene) : $('#j_menu_scene_{$scene}').val('');
    treeNode.listorder ? $('#j_menu_listorder_{$scene}').val(treeNode.listorder) : $('#j_menu_listorder_{$scene}').val('');
    treeNode.help ? $('#j_menu_help_{$scene}').val(treeNode.help) : $('#j_menu_help_{$scene}').val('');
    treeNode.stype ? $('#j_menu_stype_{$scene}').val(treeNode.stype) : $('#j_menu_stype_{$scene}').val();
    treeNode.parameter ? $('#j_menu_parameter_{$scene}').val(treeNode.parameter) : $('#j_menu_parameter_{$scene}').val();
    treeNode.isparam ? $('#j_menu_isparam_{$scene}').val(treeNode.isparam) : $('#j_menu_isparam_{$scene}').val('');
	$detail.attr('tid', treeNode.tId)
    $detail.show()
}
//删除结束事件
function M_NodeRemove(event, treeId, treeNode) {
    $.ajax({
        type:'GET',
        url:'<?php echo U('Manage/Menu/delete');?>',
        cache:false,    
        dataType:'json',
        data:{id:treeNode.id},
        success:function(data){
            var type = data.statusCode == '200' ? 'ok':'error';
            $(this).alertmsg(type,data.message);
        }
    });
}
</script>
<div class="bjui-pageContent">
    <div style="padding:20px;">
        <div class="clearfix">
            <div style="float:left; width:320px; overflow:auto;">
                <ul id="ztree{$scene}" class="ztree" data-toggle="ztree" data-options="{expandAll: false,onClick: 'ZtreeClick',showRemoveBtn: 'true',showRenameBtn: 'true',addDiyDom: 'true',maxAddLevel:'3',addHoverDom:'edit',removeHoverDom:'edit',onRemove:'M_NodeRemove'}">
                    <volist name="menu" id="vo">
                        <li data-id="{$vo.id}" data-help="{$vo.help}" data-scene="{$vo.is_scene}" data-pid="{$vo.parentid}" data-app="{$vo.app}" data-model="{$vo.model}" data-action="{$vo.action}" data-target="{$vo.target}" data-parameter="{$vo.parameter}" data-status="{$vo.status}" data-type="{$vo.type}" data-tabid="{$vo.tId}" data-faicon="{$vo.icon}" data-stype="{$vo.stype}" data-width="{$vo.width}" data-height="{$vo.height}" data-faicon-close="{$vo.icon}" data-listorder="{$vo.listorder}" data-doajax="{$vo.doajax}" data-isparam="{$vo.is_param}">{$vo.name}</li>
                    </volist>
                </ul>
            </div>
            <div id="ztree-detail-{$scene}" style="display:none; margin-left:330px; width:450px; height:470px;">
            <form action="{:U('Manage/Menu/add',array('menuid'=>$menuid));}" method="post" data-toggle="validate">
                <div class="bs-example" data-content="详细信息">
                    <input type="hidden" name="id" id="j_menu_id_{$scene}" value="">
                    <div class="form-group">
                        <label for="j_menu_parentid" class="control-label x85">上级菜单：</label>
                        <input type="text" class="form-control validate[required] required" name="parentid" id="j_menu_pid_{$scene}" size="15" placeholder="父级菜单" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_title" class="control-label x85">菜单名称：</label>
                        <input type="text" class="form-control validate[required] required" name="title" id="j_menu_title_{$scene}" size="15" placeholder="名称" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_icon" class="control-label x85">图标：</label>
                        <input type="text" name="icon" id="j_menu_icon_{$scene}" size="15" placeholder="图标，例：user" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_app" class="control-label x85">模块：</label>
                        <input type="text" class="form-control validate[required] required" class="form-control" name="app" id="j_menu_app_{$scene}" size="25" placeholder="例:Home/Index/index" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_model" class="control-label x85">模型：</label>
                        <input type="text" class="form-control validate[required] required" class="form-control" name="controller" id="j_menu_model_{$scene}" size="25" placeholder="例:Home/Index/index" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_action" class="control-label x85">控制器：</label>
                        <input type="text" class="form-control validate[required] required" class="form-control" name="action" id="j_menu_action_{$scene}" size="25" placeholder="例:Home/Index/index" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_parameter" class="control-label x85">参数：</label>
                        <input type="text" class="form-control" name="parameter" id="j_menu_parameter_{$scene}" size="15" placeholder="例:groupid=1&type=2" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_doajax" class="control-label x85">特殊参数：</label>
                        <select class="selectpicker show-tick" class="form-control" id="j_menu_isparam_{$scene}" name="is_param" data-style="btn-default btn-sel" data-width="auto">
                            <option value="0">无参数</option>
                            <option value="1">{#bjui-selected}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_status" class="control-label x85">状态：</label>
                        <select class="selectpicker show-tick" class="form-control validate[required] required" id="j_menu_status_{$scene}" name="status" data-style="btn-default btn-sel" data-width="auto">
                            <option value="1">显示</option>
                            <option value="0">不显示</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_type" class="control-label x85">类型：</label>
                        <select class="selectpicker show-tick" id="j_menu_type_{$scene}" name="type" data-style="btn-default btn-sel" data-width="auto">
                            <option value="1">权限认证+菜单</option>
                            <option value="0">只作为菜单</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_scene" class="control-label x85">应用场景：</label>
                        <select class="selectpicker show-tick" id="j_menu_scene_{$scene}" name="is_scene" data-style="btn-default btn-sel" data-width="auto">
                            <option value=""></option>
                            <option value="1">系统</option>
                            <option value="3">渠道版</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_target" class="control-label x85">target：</label>
                        <select class="selectpicker show-tick" id="j_menu_target_{$scene}" name="target" data-style="btn-default btn-sel" data-width="auto">
                            <option value=""></option>
                            <option value="navtab">navTab</option>
                            <option value="dialog">dialog</option>
                            <option value="doajax">doajax</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_stype" class="control-label x85">样式：</label>
                        <select class="selectpicker show-tick" id="j_menu_stype_{$scene}" name="stype" data-style="btn-default btn-sel" data-width="auto">
                            <option value="default">default</option>
                            <option value="primary">primary</option>
                            <option value="info">info</option>
                            <option value="success">success</option>
                            <option value="warning">warning</option>
                            <option value="danger">danger</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="j_menu_width" class="control-label x85">宽：</label>
                        <input type="text" class="form-control" name="width" id="j_menu_width_{$scene}" size="5" placeholder="800" />
                        <label for="j_menu_height" class="control-label x85">高：</label>
                        <input type="text" class="form-control" name="height" id="j_menu_height_{$scene}" size="5" placeholder="600" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_listorder" class="control-label x85">排序：</label>
                        <input type="text" class="form-control" name="listorder" id="j_menu_listorder_{$scene}" size="5" placeholder="0" />
                    </div>
                    <div class="form-group">
                        <label for="j_menu_help" class="control-label x85">手册地址：</label>
                        <input type="text" class="form-control" name="help" id="j_menu_help_{$scene}" size="35" placeholder="帮助文档地址" />
                    </div>
                    <div class="form-group" style="padding-top:8px; border-top:1px #DDD solid;">
                        <label class="control-label x85"></label>
                        <button class="btn btn-green" >新增/更新菜单</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
    </ul>
</div>