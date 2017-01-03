<div class="bjui-pageContent">
  <form action="ajaxDone1.html" id="j_form_form" class="pageForm" data-toggle="validate">
    <table class="table table-hover table_form">
      <tbody>
        <tr>
          <td align="right"><label class="label-control">邮件发送模式：</label></td>
          <td><input name="mail_type" checkbox="mail_type" value="1"  type="radio"  checked>
            SMTP 函数发送 </td>
        </tr>
       
          <tr>
            <td align="right"><label class="label-control">邮件服务器：</label></td>
            <td><input type="text" name="mail_server" id="mail_server" size="30" value="{$Site.mail_server}"/></td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">邮件发送端口：</label></td>
            <td><input type="text" name="mail_port" id="mail_port" size="30" value="{$Site.mail_port}"/></td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">发件人地址：</label></td>
            <td><input type="text" name="mail_from" id="mail_from" size="30" value="{$Site.mail_from}"/></td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">发件人名称：</label></td>
            <td><input type="text" name="mail_fname" id="mail_fname" size="30" value="{$Site.mail_fname}"/></td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">密码验证：</label></td>
            <td><input name="mail_auth" id="mail_auth" value="1" type="radio"  <if condition=" $Site['mail_auth'] == '1' ">checked</if>> 开启 
            <input name="mail_auth" id="mail_auth" value="0" type="radio" <if condition=" $Site['mail_auth'] == '0' ">checked</if>> 关闭</td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">验证用户名：</label></td>
            <td><input type="text" name="mail_user" id="mail_user" size="30" value="{$Site.mail_user}"/></td>
          </tr>
          <tr>
            <td align="right"><label class="label-control">验证密码：</label></td>
            <td><input type="password" name="mail_password" id="mail_password" size="30" value="{$Site.mail_password}"/></td>
          </tr>
        </tbody>
     
      </tbody>
    </table>
    <div class="form-group submit">
        <div class="col-md-offset-2 col-md-20">
            <input type="submit" id="submit" class="btn btn-primary" value="保存" data-loading="稍候...">
        </div>
    </div>
  </form>
</div>
