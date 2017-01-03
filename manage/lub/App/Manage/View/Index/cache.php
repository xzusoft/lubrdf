<?php if (!defined('LUB_VERSION')) exit(); ?>
<script src="{$config_siteurl}static/js/layer.js"></script>
<div class="bjui-pageHeader">
  <Managetemplate file="Common/Nav"/>
</div>
<div class="bjui-pageContent tableContent">
<div class="alert alert-danger" role="alert"><strong>警告!</strong> 下述操作会中断系统服务，请谨慎操作!</div>
	<ul class="list-group">
	  <li class="list-group-item">更新系统数据缓存:  <a class="btn" href="#" onclick="ajax_cache('{:U('Index/cache',array('type'=>'site'))}');" >提交</a> <div class="fun_tips">修改过系统设置，或者系统菜单，模块安装等时可以进行缓存更新</div></li>
	  <li class="list-group-item">更新系统模板缓存:  <a class="btn" href="#" onclick="ajax_cache('{:U('Index/cache',array('type'=>'template'))}');" >提交</a> <div class="fun_tips">当修改模板时，模板没及时生效可以对模板缓存进行更新</div></li>
	  <li class="list-group-item">清除系统运行日志:  <a class="btn" href="#" onclick="ajax_cache('{:U('Index/cache',array('type'=>'logs'))}');" >提交</a> <div class="fun_tips">系统运行过程中会记录各种错误日志，以文件的方式保存</div></li>
	</ul>
</div>
<script>
	/*ajax 更新缓存*/
	function ajax_cache(urls){
		var msg = '开始更新缓存',
		ii = 0;
		$.ajax({
			type:"get",
			url:urls,
			dataType:"JSON",
			success: function(data){
				if(data.stop != '0'){
					if(ii == 0){
						progress_bar();
					}
					msg = data.message;
					$('.cache_msg').html(data.message);
					setTimeout(function (){ajax_cache(data.urls);}, 2000);
					ii++;
				}else{
					//关闭
					$('.cache_msg').html(data.message);
					setTimeout(function (){layer.closeAll();$(this).navtab('refresh');}, 1000);
				}
         	}
		});
	}
	/*贤心弹窗*/
function progress_bar(){
    var str ="<div class='cache_msg'></div>";
    layer.msg(str);
}
</script>
<!--
<div id="jd">jindu</div>
-->