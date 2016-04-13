$(function() {
  'use strict';
  $(document).on('pageInit', '#page-shop-manager', function(e, id, page) {
    var user = checkLogin(true);

    var uid = user.userid;
    if (user.is_has_shop == 0) {
      var wechat = user.wechat;
      var qq = user.qq;
      var phone = user.phone;
      var sname = getRrlParam('shopname');
      $('.page-current .shopname').text(sname);
      $(".page-current #weachat").html(wechat);
      $(".page-current #qq").html(qq);
      $('.page-current #phone').html(phone);
    } else {
      var url = encodeURI(apiUrl + 'shop/index/getShopInfo');

      $.ajax({
        url: url,
        async: false,
        type: 'GET',
        data: {
          uid: uid
        },
        headers: {
          "Token": sso_Token
        },
        success: function(result) {
          var data = JSON.parse(result);
          if (data.code == 0) {
            var info = data.data;
            $('.page-current .shopname').html(info['sname']);
            $(".page-current #wechat").html(info['wechat']);
            $(".page-current #qq").html(info['qq']);
            $('.page-current #phone').html(info['phone']);
            var avatar = info['avatar'] == '' ? '/sources/images/shop_50x50.png' : info['avatar'];
            $('.page-current .avatar').attr('src',avatar);
          } else {
            return false;
          }
        }

      });
    }

    $(page).on('click', '#share', function() {
      sharePopup();
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


  });


  $(document).on('pageInit', '#page-shop-announcement', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_comment = $('#shop-announcement').html();
      if (shop_comment) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_comment'] = shop_comment;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })

  $(document).on('pageInit', '#page-shop-name', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_name = $('#shop-name').html();
      if (shop_name) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_name'] = shop_name;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })

  $(document).on('pageInit', '#page-shop-qq', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_qq = $('#shop-qq').html();
      if (shop_qq) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_qq'] = shop_qq;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })

  $(document).on('pageInit', '#page-shop-wechat', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_wechat = $('#shop-wechat').html();
      if (shop_wechat) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_wechat'] = shop_wechat;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })

  $(document).on('pageInit', '#page-shop-phone', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_phone = $('#shop-phone').html();
      if (shop_phone) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_phone'] = shop_phone;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })

  $(document).on('pageInit', '#page-shop-address', function(e, id, page) {
    $(page).on('click', '#finish', function() {
      var shop_address = $('#shop-address').html();
      if (shop_address) {
        var shopinfo = '';
        var info = '';
        shopinfo = sessionStorage.getItem('shop_info', shopinfo);
        var info = JSON.parse(shopinfo);
        info['shop_address'] = shop_address;
        info = JSON.stringify(info);
        sessionStorage.set('shop_info', info);
        $.toast('修改成功!');
        $.router.loadPage('shop_manager.php');
      }
    })
  })


  function getRrlParam(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
  }
  //
});