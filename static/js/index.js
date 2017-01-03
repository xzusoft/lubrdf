$(".regform").validate({
  //验证表单
  rules: {
    phone: {
      required: true,
      minlength : 11,
      isMobile: true
    },
    name: "required",
    sms: {
      required: true,
      minlength : 6,
    },
    password:{
      required: true,
      minlength : 6,
      regexPassword: true
    },
  },
  messages: {
    phone: "手机号码不合法",
    sms: "短信验证码是6位数字",
    name:"昵称不能为空",
    password:"至少8位且必须包含字母和数字"
  },
  submitHandler: function(form) {
    var form = $(form);
    form.ajaxSubmit({
        url: form.attr('action'),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
            //按钮文案、状态修改
            $(".btnSubmit").attr("disabled", true).text('注册中..');
        },
        success: function (data, statusText, xhr, $form) {
          if(data.code == 1){
            $(".btnSubmit").attr("disabled", true).text('注册成功,正在跳转...');
            window.location.href = data.url;
          }else{
            $('.alert').html(data.msg)
            $('.alert').removeClass('logintip');
            $(".btnSubmit").attr("disabled", false).text('确认注册');
          }
        }
    });
  }
});
$(".loginform").validate({
//验证表单
  rules: {
    phone: {
      required: true,
      minlength : 11,
      isMobile: true
    },
    code: {
      required: true,
    },
    password:{
      required: true,
      minlength : 6,
      regexPassword: true
    },
  },
  messages: {
    phone: "手机号码不合法",
    code: "请输入验证码",
    password:"密码不合法"
  },
  submitHandler: function(form) {
    var form = $(form);
    form.ajaxSubmit({
        url: form.attr('action'),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
            //按钮文案、状态修改
            $(".btnSubmit").attr("disabled", true).text('登录中..');
        },
        success: function (data, statusText, xhr, $form) {
          if(data.code == 1){
            $(".btnSubmit").attr("disabled", true).text('登录成功,正在跳转...');
            window.location.href = data.url;
          }else{
            $('.alert').html(data.msg)
            $('.alert').removeClass('logintip');
            $(".btnSubmit").attr("disabled", false).text('登录');
          }
        }
    });
  }
});
$(".retform").validate({
  //验证表单
  rules: {
    phone: {
      required: true,
      minlength : 11,
      isMobile: true
    },
    sms: {
      required: true,
      minlength : 6,
    },
    password:{
      required: true,
      minlength : 6,
      regexPassword: true
    },
  },
  messages: {
    phone: "手机号码不合法",
    sms: "请输入验证码",
    password:"密码不合法"
  },
  submitHandler: function(form) {
    var form = $(form);
    form.ajaxSubmit({
        url: form.attr('action'),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
            //按钮文案、状态修改
            $(".btnSubmit").attr("disabled", true).text('修改中..');
        },
        success: function (data, statusText, xhr, $form) {
          if(data.code == 1){
            $(".btnSubmit").attr("disabled", true).text('修改成功,正在跳转...');
            window.location.href = data.url;
          }else{
            $('.alert').html(data.msg)
            $('.alert').removeClass('logintip');
            $(".btnSubmit").attr("disabled", false).text('确认修改');
          }
        }
    });
  }
});
$(".changeform").validate({
  rules: {
    hpassword:{
      required: true,
    },
    password:{
      required: true,
      minlength : 6,
      regexPassword: true
    },
    npassword:{
      equalTo: "#password",
    }
  },
  messages: {
    hpassword:"旧密码不合法",
    password:"密码不合法",
    npassword:"两次密码输入不一致",
  },
  submitHandler: function(form) {
    var form = $(form);
    form.ajaxSubmit({
        url: form.attr('action'),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
            //按钮文案、状态修改
            $(".btnSubmit").attr("disabled", true).text('修改中..');
        },
        success: function (data, statusText, xhr, $form) {
          if(data.code == 1){
            $(".btnSubmit").attr("disabled", true).text('更新成功,正在跳转...');
            window.location.href = data.url;
          }else{
            $('.alert').html(data.msg)
            $('.alert').removeClass('logintip');
            $(".btnSubmit").attr("disabled", false).text('确认修改');
          }
        }
    });
  }
});
//刷新验证码
/*$('#code').focus(function(){changeCode();});*/
$(".captcha-img").click(function(){changeCode();});
function changeCode(){$(".captcha-img").attr("src", _global['website']+"captcha.html&time="+genTimestamp());}
//发送手机验证码

var InterValObj;
var count = 60;
var curCount;
function sendMessage(choose, type) {
    var phone = $("#phone").val();
    if ($('.' + choose).validate().element($("#phone"))) {
        curCount = count;
        $("#sndCode").attr("disabled", "true");
        $("#sndCode").html(curCount + "秒后重新获取...");
        InterValObj = window.setInterval(SetRemainTime, 1000);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: _global["website"] + "putsms.html&time=" + genTimestamp(),
            data: "phone=" + phone + "&type=" + type,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                curCount == 0
            },
            success : function(rdata){
              if(rdata.status == 0){
                $('.alert').html(rdata.info)
                $('.alert').removeClass('logintip');
                return true;
              }
            }
        })
    }
}
function SetRemainTime() {
    if (curCount == 0) {
        window.clearInterval(InterValObj);
        $("#sndCode").removeAttr("disabled");
        $("#sndCode").html("重新发送验证码")
    } else {
        curCount--;
        $("#sndCode").html(curCount + "秒后重新获取...")
    }
};
//与服务器通信验证
function checkServer(param,type){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: _global["website"] + "check_account.html&time=" + genTimestamp(),
    data: "param =" + param + "&type=" + type,
    async:false,
    success : function(rdata){
      if(rdata.code == 0){
        $('.alert').html(rdata.info)
        $('.alert').removeClass('logintip');
        return true;
      }
    }
  });
}