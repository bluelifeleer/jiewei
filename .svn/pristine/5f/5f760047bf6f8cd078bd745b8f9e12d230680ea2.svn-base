$(function() {
  'use strict';
  $(document).on('pageInit', '#page-shop-product-classify', function(e, id, page) {
    var user = checkLogin(true);
    var uid = user.userid;
    var url = encodeURI(apiUrl + 'shop/index/getShopClassify');
    $.ajax({
      url: url,
      async: false,
      type: 'GET',
      data: {uid:uid},
      headers: {
        "Token": sso_Token
      },
      success: function(result) {
        var data = JSON.parse(result);
        if (data.code == 0) {
          var Shopcounts = data.data1;
          var platforms = data.data2;
          $('#Shopcounts').html(Shopcounts+$('#Shopcounts').html());
          $('#platforms').html(platforms+$('#platforms').html());
        } else {
          return false;
        }
      }
    });



    $(page).on('click', '#toShopIndex', function() {
       var userid = JSON.parse(sessionStorage.getItem('user_info')).userid;
       $(this).attr('href','index.php?siteid='+userid);
       //$.router.loadPage('index.php?siteid='+userid,true);
    });

     $(page).on('click', '#toShopMsg', function() {
       var userid = JSON.parse(sessionStorage.getItem('user_info')).userid;
       $(this).attr('href','shop_msg.php');
       //$.router.loadPage('index.php?siteid='+userid,true);
    });




     //获取url中的参数
    function getRrlParam(name) {
      var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
      return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }
  });
  //
});