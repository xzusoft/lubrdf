<?php if (!defined('LUB_VERSION')) exit(); ?>
<script type="text/javascript">
function sub(){
    var treeObj = $.fn.zTree.getZTreeObj("rbactree{$scene}");
    var nodes = treeObj.getCheckedNodes(true);
    var str = "",
        postdata = "",
        scene = {$scene},
        roleid = {$roleid};
    $.each(nodes,function(i,v){
        if (str != "") {
            str += ","; 
        }
        str += v.id;
    });
    postdata = 'data={"menuid":"'+str+'","scene":'+scene+',"roleid":'+roleid+'}';
    $.ajax({
        type:'POST',  
        url:'<?php echo U('Manage/Rbac/authorize',array('menuid'=>$menuid));?>',
        data:postdata,
        cache:false,  
        dataType:'JSON',
        success:function(data){  
           if(data.statusCode == "200"){
              $(this).alertmsg('ok',data.message);
           }else{
              $(this).alertmsg('error',data.message);
           }
        },
    });
    $(this).dialog("closeCurrent","true");
}
/*默认折叠第四级菜单
$(function(){
    var treeObj = $.fn.zTree.getZTreeObj("ztree{$scene}");
    var nodes = treeObj.getSelectedNodes();
    if (nodes.length>1) {
        alert(nodes[0]);
        treeObj.expandNode(nodes[0], true, true, true);
    }
});*/
</script>
<div class="bjui-pageContent">
    <div style="float:left; width:320px; overflow:auto;">
        <ul id="rbactree{$scene}" class="ztree" data-toggle="ztree" data-options="{'expandAll':true,onClick: 'ZtreeClick',checkEnable:'true',chkStyle:'checkbox'}" >
            <volist name="menu" id="vo">
                <li data-id="{$vo.id}" data-pid="{$vo.parentid}" data-faicon="{$vo.icon}" data-checked="<if condition="$vo.checked eq '1'">true<else />false</if>" data-faicon-close="{$vo.icon}">{$vo.name}</li>
            </volist>
        </ul>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <li><button type="submit" class="btn-default" data-icon="save" onclick="sub();">保存</button></li>
    </ul>
</div>