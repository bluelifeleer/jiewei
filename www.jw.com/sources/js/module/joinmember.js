$(function() {
  'use strict';
  $(document).on('pageInit', '#page-into-member', function(e, id, page) {
    /**
     * 用户加入会员操作
     * @author 李鹏
     * @date 2016-01-06
     */
    //判断用户是否登录
    var loginInfo = checkLogin('1');
    if (!loginInfo) {
      $.router.loadPage('login.php');
      return false;
    }

    // 微信支付获取openid
$(page).on('click', '#openshop', function() {
   
   var appid = sessionStorage.getItem('appid') || 'wx34fdd0d60e7d4514';
    var fromurl ='http://api.zj3w.net/wxpay/index/code?from=4';
     if (isWeixin) {
        var url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + appid + '&redirect_uri=' + encodeURIComponent(fromurl) + '&response_type=code&scope=snsapi_base&state=STATE%23wechat_redirect&connect_redirect=1#wechat_redirect';
        location.href = url;
        return false;
    }
});

$(page).on('click', '#gosale', function() {
   $.modal({
                title: '团队业绩如何累计?',
                afterText:  '<div style="color:#0894ec;text-align:left;"><p> 1、点击左下角“首页”进入商城首页，将商城首页或者官方商品推广出去 </p> <p> 2、点击右下角“我的”进入个人中心，打开二维码推广出去 </p> <p> <span style="color:red;">注：</span>微信登入和手机号注册后登入都算注册成功用户，只要有朋友首次通过你的分享，登录成为会员后，以后只要成功购买了官方商品就会产生相关业绩哦 ^o^</p></div>',
                buttons: [{
                    text: 'ok',
                    onClick: function() {
                      $.hideIndicator();
                    }
                } ]
              })

});


  });
});
