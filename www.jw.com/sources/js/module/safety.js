$(function(){
  'use strict';
  $(document).on('pageInit','#page-safety',function(e,id,page){


    /**
     * 判断用户是否登录
     * @type {[type]}
     */
    var user = checkLogin();
    if(!user){
      window.location.href='login.php';
    }

  });
 //
});
