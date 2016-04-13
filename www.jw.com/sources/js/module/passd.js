$(function() {
  'use strict';
  $(document).on('pageInit', '#page-password', function(e, id, page) {
    //获取sessionStorage中的值
    var rsgMsg = JSON.parse(sessionStorage.getItem('reg_mesg'));
    var phone = rsgMsg['phone'];
    var vailCode = rsgMsg['verifi'];　 //if(!regMeagToJson)$.router.loadPage('login.php');
    $(page).on("click", "#submit-but", function() {
      if ($('#pasd').val().length < 6 || $('#confirm-pasd').val().length < 6) {
        $.toast('密码长度不得小于６位');
        return false;
      } else {
        //验证两次密码
        if ($('#pasd').val() !== $('#confirm-pasd').val()) {
          $.toast('两次输入的密码不同');
          return false;
        }
        //注册开始
        var data = {
          "phone": phone,
          "pasd": $('#pasd').val(),
          "confirm_pasd": $('#confirm-pasd').val(),
          "vail_code": vailCode
        };

        var url = encodeURI(apiUrl + 'account/index/register');
        $.ajax({
          url: url,
          async: false,
          type: 'POST',
          data: data,
          headers: {
            "Token": sso_Token
          },
          success: function(res) {
            res = JSON.parse(res);
            if(res.code == 0){
              //清除注册记录的手机及验证码
              sessionStorage.removeItem('reg_mesg');
              $.toast('注册成功');
              setTimeout(function(){
                $.router.loadPage('login.php');
              },2000);
            }else{
              $.toast('注册失败');
              return false;
            }
          },
          error:function(err){
            $.toast('请求错误');
            return false;
          }
        });


      }

    });
    //其他节点
  });
  //其他页面
});