$(function() {
  'use strict';
  //修改昵称
  $(document).on('pageInit', '#page-modif', function(e, id, page) {
    var user = JSON.parse(sessionStorage.getItem('user_info'));
    var userid = user['userid'];
    var url = encodeURI(apiUrl + '/account/index/modifyInfo');

    //判断要修改什么信息，将对应的数据信息添加到对应的默认的value值中
    switch ($(page).attr('data-page-fn')) {
      case 'email':
        $('input').val(user['email']);
        break;
      case 'qq':
        $('input').val(user['qq']);
        break;
      case 'wechat':
        $('input').val(user['wechat']);
        break;
      default:
        $('input').val(user['nickname']);
        break;
    }

    $(page).on('click', '#modif-but', function() {
      var type = $(this).attr('data-modif-type');
      var modifDate = $('#' + type).val();
      if (modifDate == '') { //如果提交的值为空则提示错误信息
        $.toast(type + '不能为空', 2000);
      } else if (modifDate == user[type]) { //如果提交的值跟之前的值一样则停止提交
        return false;
      } else { //提交数据，并显示工作提示器
        $.showIndicator();
        var url = encodeURI(apiUrl+'account/index/modifyInfo');
        var data = {
          "modifType": type,
          "modifData": modifDate
        };

        $.ajax({
          url: url,
          async: false,
          type: 'POST',
          data: data,
          headers: {
            "Token": sso_Token
          },
          success: function(status) {
            status = JSON.parse(status);
            if (status['code'] == 0) {
              $.hideIndicator();
              $.toast('修改成功');
              $.router.loadPage('userinfo.php');
            } else {
              $.hideIndicator();
              $.toast('修改失败', 2000);
              return false;
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