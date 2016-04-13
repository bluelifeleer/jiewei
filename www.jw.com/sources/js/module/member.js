$(function() {
  'use strict';
  $(document).on('pageInit', '#page-member', function(e, id, page) {

    //获取用户信息
    var user = checkLogin('1');
    if(!user){
      $.router.loadPage('login.php');
      return false;
    }

    /**
     * 获取用户信息
     * @return {[type]} [description]
     */
    getUserInfo(user);

    function getUserInfo(user){
      //判断用户登录方式，如果微信登录隐藏修改手机号、密码的接口
      if(user.is_wechat_login && user.is_wechat_login == 1){
        $('#safety-link-block').css('display','none');
      }



      // var name = '';
      // if(user['nickname'] == ''){
      //   name = user['phone'];
      // }else{
      //   if(user['nickname'].length >= 6){
      //     name = user['nickname'].substr(0,2)+'**'+user['nickname'].substr(parseInt(user['nickname'].length-2),2);
      //   }else{
      //     name = user['nickname'];
      //   }
      // }

      //$('.nickname').html(name);

      //var sex = user['sex'] == 1 ? '男' : '女';
      //var avarat = user['avarat'] == '' ? '/sources/images/default_50x50.jpg' : user['avarat'];
      //$('.avarat').attr('src', avarat);
     // var levels = '';
     // var levelsName = '';

    //   switch (parseInt(user['levels'])) {
    //     case 1:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe672;</i>';
    //       levelsName = '新人';
    //       break;
    //     case 2:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe673;</i>';
    //       levelsName = '主管';
    //       break;
    //     case 3:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe674;</i>';
    //       levelsName = '经理';
    //       break;
    //     case 4:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe675;</i>';
    //       levelsName = '总监';
    //       break;
    //     case 5:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe676;</i>';
    //       levelsName = '首席总监';
    //       break;
    //     case 6:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe677;</i>';
    //       levelsName = '总经理';
    //       break;
    //     case 7:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe678;</i>';
    //       levelsName = '总经理';
    //       break;
    //     default:
    //       levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe671;</i>';

    //       levelsName = '普通会员';
    //       break;
    //   }
    //   $('.is-vip').html(levels);
     }
    //会员等级名称
    // $('.levels-name').html(levelsName);
    /**
     *
     */
    $(page).on('mouseover', '#shop-to-link', function() {
      $(this).css('cursor', 'pointer');
    });
    $(page).on('click', '#shop-to-link', function() {
      if (parseInt(user['levels']) != 0) {
        if (parseInt(user['is_has_shop']) == 0) {
          $.router.loadPage('apply_shop.php');
        } else {
          $.router.loadPage('shop_manager.php?showwxpaytitle=1');
        }
      } else {
        $.router.loadPage('join_member.php');
        return false;
      }


    });

    // 微信支付
    $(page).on('click','#recharge',function(){
        var host = 'http://www.zj3w.net/';
            // var host = sessionStorage.getItem('site_host');
        var appid = sessionStorage.getItem('appid') || 'wx34fdd0d60e7d4514';
        var fromurl ='http://api.zj3w.net/wxpay/index/code?&from=1';
         if (isWeixin) {
            var url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + appid + '&redirect_uri=' + encodeURIComponent(fromurl) + '&response_type=code&scope=snsapi_base&state=STATE%23wechat_redirect&connect_redirect=1#wechat_redirect';
            location.href = url;
            return false;
        }

    });

      var siteid = getRrlParam('siteid');
     //判断地址是否有siteid
     siteid = isEmpty(siteid)?'1':siteid;
     //判断是否存在店铺，不存在转平台店铺
     siteid = checkShop(siteid)== 0 ? 1: siteid;


    /**
      * [默认分享 share]
      * 
      */
       sessionStorage.removeItem("shareData_info");
      var suse = sessionStorage.getItem('userid') || sessionStorage.getItem('YunUser') || JSON.parse(sessionStorage.getItem('site_info')).siteid || 1;
      sessionStorage.setItem("YunUserId",suse);
      var sdate = sessionStorage.getItem("shareData_info");
      // if(!sdate){
      // var siteid = JSON.parse(sessionStorage.getItem("site_info")).siteid;
      var shopInfo = getShopInfo(siteid);
      // if(!shopInfo) shopInfo = getShopInfo(1);
      var shareData = {};
      shareData.title = '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
      shareData.desc = shopInfo.desc || '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
      shareData.link = APP_PATH + 'index.php?siteid=' + siteid + '&YunUser=' + sessionStorage.getItem('YunUserId');
      shareData.thumb = shopInfo.avatar || 'http://res.zj3w.net/category/icon/2016/03/11/56e2aa4726f2464.png';
      ;
      sessionStorage.setItem('shareData_info',JSON.stringify(shareData));

    /**
     * 退出登录
     */
    $(page).on('click', '#loginout-but', function() {
      loginOut();
    });

    $(document).on('click', 'a', function() {
      if ($(this).attr('href') != '' && $(this).attr('href') != 'javascript:void(0);') {
        sessionStorage.setItem('history', $(this).attr('href'));
      }
    });

  });
  
});
