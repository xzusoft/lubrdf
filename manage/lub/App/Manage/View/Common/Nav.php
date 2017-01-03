<div class="toolBar">
<?php 
$getMenu = isset($Custom)?$Custom:D('Manage/Menu')->getMenu();
//print_r($getMenu);
if($getMenu['tool']) {
?>

  <div class="btn-group" role="group" aria-label="操作栏">

    <?php
    if(!empty($menuReturn)){
      echo '<a type="button" class="btn btn-link" href="'.$menuReturn['url'].'" data-id="'.$menuReturn['tabid'].'" data-toggle="navtab" data-title="'.$menuReturn['title'].'"><i class="fa fa-mail-reply-all"></i>'.$menuReturn['name'].' </a>';
    }
    ?>
    
      <?php
    foreach($getMenu['tool'] as $r){
      $app = $r['app'];
      $controller = $r['controller'];
      $action = $r['action'];
      $width  = $r['width'] ? $r['width'] : '800';
      $height = $r['height'] ? $r['height'] : '400';
      if($r['is_param'] == '1'){
        $url =  U("".$app."/".$controller."/".$action."",$r['parameter'])."&id={#bjui-selected}";
      }else{
        $url =  U("".$app."/".$controller."/".$action."",$r['parameter']);
      }
      if($r['target'] == 'doajax') $doajax = 'data-confirm-msg=确定要执行此操作吗？';
    ?>
      <a type="button" class="btn btn-{$r['stype']}" href="{$url}" data-toggle="{$r['target']}" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-id="<?php echo $r['action'].$r['id']?>" {$doajax} data-mask="true"><i class="fa fa-<?php echo $r['icon']?>"></i>  <?php echo $r['name'];?></a>
      <?php
    }
    ?>     
    </div>
  
<?php }?>
<div class="btn-group f-right" role="group">
      <a href="javascript:;" onclick="$(this).navtab('refresh');" class="btn btn-default" data-placement="bottom" data-toggle="tooltip" rel="reload" title="刷新当前页"><i class="fa fa-refresh"></i></a>
      <?php if($getMenu['help']){?>
      <a type="button" class="btn btn-default" href="<?php echo $getMenu['help']; ?>" target="_blank" data-placement="left" data-toggle="tooltip" title="使用帮助"><i class="fa fa-question-circle"></i></a>
      <?php }?>
  </div>
</div>