$(function(){
  'use strict';
  $(document).on('pageInit','#page-replace-phone',function(e,id,page){
    var isRun = false;
    var timer = null;

  // var loginInfo = checkLogin();
  //   if(!loginInfo){
  //     window.location.href='login.php';
  //   }



    //确定更换
    $(page).on('click','#replace-but',function(){
      var replacePhone = $('#replace-phone').val();
      if(replacePhone == ''){
        alert('手机不能为空');
        return false;
      }else if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(replacePhone))){
        alert('手机格式不正确');
        return false;
      }
      var url = encodeURI(apiUrl+'account/index/replacePhone');
      var data = {"replacephone":replacePhone};

      $.ajax({
        url: url,
        async: false,
        data:data,
        type: 'GET',
        headers: {
          "Token": sso_Token
        },
        success: function(status) {
          status = $.parseJSON(status);
          if(status['code'] == 0){
            $.toast('更换成功');
            $.router.loadPage('confirm_return.php');
          }else{
            $.toast('更换失败，请稍后再试');
            return false;
          }
        }

      });

    });
  });
//
});
