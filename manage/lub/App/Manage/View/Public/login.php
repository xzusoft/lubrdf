<?php if (!defined('LUB_VERSION')) exit(); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="apple-touch-icon" href="{$config_siteurl}static/images/favicon.ico">
<link rel="icon" href="{$config_siteurl}static/images/favicon.ico">
<title>有伴科技 会员管理系统 CRM v1.0.1</title>
<script src="{$config_siteurl}static/bjui/js/jquery-1.7.2.min.js"></script>
<script src="{$config_siteurl}static/bjui/js/jquery.cookie.js"></script>
<link href="{$config_siteurl}static/bjui/themes/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
*{font-family:"Verdana","Tahoma","Lucida Grande","Microsoft YaHei","Hiragino Sans GB",sans-serif}body{background:url(static/images/loginbg_01.jpg) no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover}a:link{color:#285e8e}.main_box{position:absolute;top:50%;left:50%;margin-top:-260px;margin-left:-300px;padding:30px;width:600px;height:360px;background:#fafafa;background:rgba(255,255,255,0.5);border:1px #DDD solid;border-radius:5px;-webkit-box-shadow:1px 5px 8px #888;-moz-box-shadow:1px 5px 8px #888;box-shadow:1px 5px 8px #888}.main_box .setting{position:absolute;top:5px;right:10px;width:10px;height:10px}.main_box .setting a{color:#f60}.main_box .setting a:hover{color:#555}.login_logo{margin-bottom:20px;height:45px;text-align:center}.login_logo img{height:45px}
.login_msg{text-align:center;font-size:14px;display: none;color: red; margin:10px;padding:5px;}
.login_form{padding-top:20px;font-size:16px}
.login_box .form-control{display:inline-block;*display:inline;zoom:1;width:auto;font-size:18px}
.login_box .form-control.x319{width:319px}.login_box .form-control.x164{width:164px}
.login_box .form-group{margin-bottom:20px}.login_box .form-group label.t{width:120px;text-align:right;cursor:pointer}.login_box .form-group.space{padding-top:15px;border-top:1px #FFF dotted}.login_box .form-group img{margin-top:1px;height:32px;vertical-align:top}.login_box .m{cursor:pointer}.bottom{text-align:center;font-size:12px}
.main_box {overflow:hidden;-webkit-animation: bounceIn 600ms linear;-moz-animation: bounceIn 600ms linear;-o-animation: bounceIn 600ms linear;animation: bounceIn 600ms linear;}
/*登录框动画*/
@-webkit-keyframes bounceIn {
	0% {
		opacity: 0;
		-webkit-transform: scale(.3);
	}
	50% {
		opacity: 1;
		-webkit-transform: scale(1.05);
	}
	70% {
		-webkit-transform: scale(.9);
	}
	100% {
		-webkit-transform: scale(1);
	}
}
@-moz-keyframes bounceIn {
	0% {
		opacity: 0;
		-moz-transform: scale(.3);
	}

	50% {
		opacity: 1;
		-moz-transform: scale(1.05);
	}

	70% {
		-moz-transform: scale(.9);
	}

	100% {
		-moz-transform: scale(1);
	}
}
@-o-keyframes bounceIn {
	0% {opacity: 0;-o-transform: scale(.3);}

	50% {
		opacity: 1;
		-o-transform: scale(1.05);
	}

	70% {
		-o-transform: scale(.9);
	}

	100% {
		-o-transform: scale(1);
	}
}
@keyframes bounceIn {
	0% {
		opacity: 0;
		transform: scale(.3);
	}

	50% {
		opacity: 1;
		transform: scale(1.05);
	}

	70% {
		transform: scale(.9);
	}

	100% {
		transform: scale(1);
	}
}
</style>
</head>
<body>
<!--[if lte IE 7]>
<style type="text/css">
#errorie {position: fixed; top: 0; z-index: 100000; height: 30px; background: #FCF8E3;}
#errorie div {width: 900px; margin: 0 auto; line-height: 30px; color: orange; font-size: 14px; text-align: center;}
#errorie div a {color: #459f79;font-size: 14px;}
#errorie div a:hover {text-decoration: underline;}
</style>
<div id="errorie"><div>您还在使用老掉牙的IE，请升级您的浏览器到 IE8以上版本 <a target="_blank" href="http://windows.microsoft.com/zh-cn/internet-explorer/ie-8-worldwide-languages">点击升级</a>&nbsp;&nbsp;强烈建议您更改换浏览器：<a href="http://down.tech.sina.com.cn/content/40975.html" target="_blank">谷歌 Chrome</a></div></div>
<![endif]-->
<div class="main_box">
    <div class="setting"><a href="javascript:;" onclick="choose_bg();" title="更换背景"><span class="glyphicon glyphicon-th-large"></span></a></div>
	<div class="login_box">
        <!--<div class="login_logo">
            <img src="images/logo.png" >
        </div>
        -->
        
        <div class="login_form">
    		<form action="{:U('Public/tologin')}" id="login_form" method="post">
    			<div class="form-group">
    				<label for="username" class="t">用户名：</label> <input id="username" value="" name="username" type="text" class="form-control x319 in" autocomplete="off">
    			</div>
    			<div class="form-group">
    				<label for="password" class="t">密　码：</label> <input id="password" value="" name="password" type="password" class="form-control x319 in" autocomplete="off">
    			</div>
    			<div class="form-group">
    				<label for="captcha" class="t">验证码：</label> <input id="captcha" name="code" type="text" class="form-control x164 in">
    				<img id="captcha_img" alt="点击更换" title="点击更换" src="{:U('Api/Checkcode/index','code_len=4&font_size=30&width=150&height=60&font_color=&background=')}" class="m">
    			</div>
    			<!--
    			<div class="form-group">
                    <label class="t"></label>
                    <label for="j_remember" class="m"><input id="j_remember" type="checkbox" value="true">&nbsp;记住登陆账号!</label>
    			</div>-->
    			<div class="login_msg"></div>
    			<div class="form-group space">
                    <label class="t"></label>　　　
    				<input type="submit" id="login_ok" value="&nbsp;登&nbsp;录&nbsp;" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;&nbsp;
    				<input type="reset" value="&nbsp;重&nbsp;置&nbsp;" class="btn btn-default btn-lg">
    			</div>
    		</form>
        </div>
	</div>
	<div class="bottom"> Copyright &copy; <?php echo date('Y');?>　<a href="http://www.leubao.com/" target="_blank">leubao.com</a> </div>
</div>
<script type="text/javascript">
$(function(){
	$("#login_form").submit(function(){
		var issubmit = true;
		var i_index  = 0;
		$(this).find('.in').each(function(i){
			if ($.trim($(this).val()).length == 0) {
				$(this).css('border', '1px #ff0000 solid');
				issubmit = false;
				if (i_index == 0)
					i_index  = i;
			}
		});
		if (!issubmit) {
			$(this).find('.in').eq(i_index).focus();
			return false;
		}
		/*
		if ($remember.attr('checked')) {
			$.cookie(COOKIE_NAME, $("#username").val(), { path: '/', expires: 15 });
		} else {
			$.cookie(COOKIE_NAME, null, { path: '/' });  //删除cookie
		}*/
		$("#login_ok").attr("disabled", true).val('登录中..');
		var self = $(this);
		$.post(self.attr("action"), self.serialize(), success, "json");
        return false;
        function success(data){
            if(data.statusCode == '200'){
                window.location.href = data.url;
            } else {
            	self.find(".login_msg").css('display','block');
                self.find(".login_msg").text(data.message);
                //刷新验证码
                changeCode();
                $("#login_ok").attr("disabled",false).val("登录");
                setTimeout(function(){self.find(".login_msg").css('display','none')},2000);
            }
        }
		
	});
});
function choose_bg() {
	var bg = Math.floor(Math.random() * 9 + 1);
	$('body').css('background-image', 'url(static/images/loginbg_0'+ bg +'.jpg)');
}
choose_bg();
//刷新验证码
$('#captcha').focus(function(){changeCode();});
$("#captcha_img").click(function(){changeCode();});
function genTimestamp(){
	var time = new Date();
	return time.getTime();
}
function changeCode(){
	$("#captcha_img").attr("src", "{:U('Api/Checkcode/index','code_len=4&font_size=30&width=150&height=60&font_color=&background=&refresh=1')}&time="+genTimestamp());
}
</script>
</body>
</html>