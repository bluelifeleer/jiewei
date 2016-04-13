$(function() {

  'use strict';
  $(document).on('pageInit', '#page-modify-password', function(e, id, page) {

    var loginInfo = checkLogin('1');
    if (!loginInfo) {
      $.router.loadPage('login.php');
    }


    $(page).on('click', '#modify-pasd-but', function() {
      $.showIndicator();
      var original_pasd = $('#original-pasd').val();
      var new_pasd = $('#new-pasd').val();
      var confirm_pasd = $('#confirm-pasd').val();
      if(original_pasd == ''){
        $.hideIndicator();
        $.toast('请输入原始密码');
        return false;
      } else if (new_pasd == '' || confirm_pasd == ''){
        $.hideIndicator();
        $.toast('请输入新密码');
        return false;
      } else if (new_pasd.length < 6 || confirm_pasd.length < 6) {
        $.hideIndicator();
        $.toast('密码不能小于６位数');
        return false;
      } else if (confirm_pasd != new_pasd) {
        $.hideIndicator();
        $.toast('两次输入的密码不一致');
        return false;
      } else if (original_pasd.length < 6){
        $.hideIndicator();
        $.toast('请输入格式正确的原密码');
      } else {
        
        var url = encodeURI(apiUrl + 'account/index/modifyPassword');
        var data = {
          'original_pasd':original_pasd,
          'new_pasd':new_pasd,
          "confirm_pasd": confirm_pasd
        };

        $.ajax({
          url: url,
          async: false,
          type: 'POST',
          data: data,
          headers: {
            "Token": sso_Token
          },
          success: function(res) {
            res = $.parseJSON(res);
            switch(res.code){
              case 1:
                $.hideIndicator();
                $.toast('密码修改失败');
              break;
              case 2:
                $.hideIndicator();
                $.toast('原始密码不正确');
              break;
              case 3:
                $.hideIndicator();
                $.toast('新密码跟旧密码一样');
              break;
              case 4:
                $.hideIndicator();
                $.toast('两次输入的新密码不一样');
              break;
              default:
                $.hideIndicator();
                $.toast('密码修改成功');
                //退出登录
                loginOut();
              break;
            }
          },
          error:function(err){
            $.hideIndicator();
            $.toast(err);

          }

        });

      }
    });
  });
  //
});