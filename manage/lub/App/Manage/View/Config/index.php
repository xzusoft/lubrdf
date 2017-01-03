<div class="bjui-pageContent">
<div class="h_a">功能说明


<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on top">
<i class="icon icon-info-sign"></i></button>
 </div>

<div class="prompt_text">
    <ul>
      <li><font color="#FF0000">行为是系统中非常重要的一项功能，如果行为设置错误会导致系统崩溃或者不稳定的情况。</font></li>
      <li>行为标签都是程序开发中，内置在程序业务逻辑流程中！</li>
      <li>行为的增加，会<font color="#FF0000">严重影响</font>程序性能，请合理使用！</li>
    </ul>
  </div>
    <form action="ajaxDone1.html" id="j_form_form" class="pageForm" data-toggle="validate">
        <div>
        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#sys" role="tab" data-toggle="tab">系统配置</a></li>
          <li><a href="{:U('Manage/Config/mail');}" role="tab" data-toggle="ajaxtab" data-target="#mail" data-reload="false">邮件配置</a></li>
          <li><a href="{:U('Manage/Config/mail');}" role="tab" data-toggle="ajaxtab" data-target="#attachment" data-reload="false">附件配置</a></li>
          <li><a href="#mail" role="tab" data-toggle="tab">高级配置</a></li>
          <li><a href="#mail" role="tab" data-toggle="tab">扩展配置</a></li>
          <li><a href="#mail" role="tab" data-toggle="tab">二维码设置</a></li>
        </ul>
                <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade active in" id="sys">
            <div class="bjui-pageContent">
  <form action="ajaxDone1.html" id="j_form_form" class="pageForm" data-toggle="validate">
    <table class="table table-hover table_form">
      <tbody>
        <tr>
          <td align="right"><label class="label-control">访问地址：</label></td>
          
          <td><input type="text" name="siteurl" value="{$Site.siteurl}" size="40">
            <span class="gray"> 请以“/”结尾</span></td>
        </tr>
        <tr>
          <td align="right"><label class="label-control">附件地址：</label></td>
         
          <td><input type="text" name="sitefileurl" value="{$Site.sitefileurl}" size="40">
            <span class="gray"> 非上传目录设置</span></td>
        </tr>
        <tr>
          <td align="right"><label class="label-control">系统帮助：</label></td>
          
          <td><input type="text" name="online_help" value="{$Site.online_help}" size="40"></td>
        </tr>
        <tr>
          <td align="right"><label class="label-control">联系邮箱：</label></td>
         
          <td><input type="text" name="siteemail" value="{$Site.siteemail}" size="40"></td>
        </tr>
        <tr>
          <td align="right"><label class="label-control">验证码类型：</label></td>
         
          <td><select name="checkcode_type">
            <option value="0" <if condition="$Site['checkcode_type'] eq '0' "> selected</if>>数字字母混合</option>
            <option value="1" <if condition="$Site['checkcode_type'] eq '1' "> selected</if>>纯数字</option>
            <option value="2" <if condition="$Site['checkcode_type'] eq '2' "> selected</if>>纯字母</option>
          </select></td>
        </tr>
      </tbody>
    </table>
    <div class="form-group submit">
        <div class="col-md-offset-2 col-md-20">
            <input type="submit" id="submit" class="btn btn-primary" value="保存" data-loading="稍候...">
        </div>
    </div>
  </form>
</div>

                    </div>
                   <div class="tab-pane fade" id="mail"><!-- Ajax加载 --></div>
                   <div class="tab-pane fade" id="attachment"></div>
                </div>
        </div>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
    </ul>
</div>