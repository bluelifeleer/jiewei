$(function(){
  'use strict';
  $(document).on('pageInit','#page-user-information',function(e,id,page){
    $.showIndicator();
    //var YunUser = getRrlParam('YunUser');
    var url = encodeURI(apiUrl+'account/index/memberInfo/userid/'+YunUser);
    //console.log(YunUser);

    $.ajax({
      url: url,
      async: false,
      type: 'GET',
      headers: {
        "Token": sso_Token
      },
      success: function(result) {
        result = $.parseJSON(result);
        if(result['code'] == 0){
          $.hideIndicator();
          var userInfo = $.parseJSON(result['data']);
          var userid = userInfo['userid'] !== ''?parseInt(userInfo['userid']):0;
          var nickname = userInfo['nickname'] !== ''?userInfo['nickname']:'';
          var avarat = userInfo['avarat'] !== ''?userInfo['avarat']:'/sources/images/5111e6f7612b0.jpg';
          var phone = userInfo['phone'] !== ''?userInfo['phone']:'';
          var sex = userInfo['sex'] == 1?'男':'女';
          var levels = '';
          switch(parseInt(userInfo['levels'])){
            case 1:
              levels = '<em class="iconfont cCB1408">&#xe656;</em>'
            break;
            case 2:
              levels = '<em class="iconfont cCB1408">&#xe657;</em>'
            break;
            case 3:
              levels = '<em class="iconfont cCB1408">&#xe658;</em>'
            break;
            case 4:
              levels = '<em class="iconfont cCB1408">&#xe655;</em>'
            break;
            case 5:
              levels = '<em class="iconfont cCB1408">&#xe65a;</em>'
            break;
            case 6:
              levels = '<em class="iconfont cCB1408">&#xe659;</em>'
            break;
            default:
              levels = '<em class="iconfont c5F646E">&#xe65c;</em>'
            break;
          }
          var userInfomartionHtml = '<div class="w100b h180">'+
            '<div class="w100b h100 borb1 bcc1c1c1">'+
              '<div class="fll w15b h100"><img src="'+avarat+'" class="block w80 h80 borrad50 mart10 marl20" /></div>'+
              '<div class="fll w70b h100">'+
                '<div class="w100b h30 mart20">'+
                  '<span class="inlineblock h30 lh30 marl10" style="width:auto;">'+nickname+'</span>'+
                  '<span class="inlineblock h25 lh25 txac marl10 borrad5" style="width:auto;">'+levels+'</span>'+
                '</div>'+
                '<div class="w100b">'+
                  '<span class="marl10">'+sex+'</span>'+
                '</div>'+
              '</div>'+
              '<div class="fll w5b h100 lh100 iconfont mar0"></div>'+
            '</div>'+
            '<div class="w100b h40 lh40 borb1 bcc1c1c1">'+
              '<span class="block fll w25b h40 lh40 marl20 txalr">用户名：</span>'+
              '<span class="block fll w65b h40 lh40">'+nickname+'</span>'+
            '</div>'+
            '<div class="w100b h40 lh40 borb1 bcc1c1c1">'+
              '<span class="block fll w25b h40 lh40 marl20 txalr">账号信息：</span>'+
              '<span class="block fll w65b h40 lh40">'+phone+'</span>'+
            '</div>'+
          '</div>'+
          '<div class="w100b mart20 h50">'+
            '<!--<a href="javascript:void(0);" class="block w90b marauto borrad5 h40 lh40 txalc white bg1EA1F2 marl20 external" data-user-id="'+userid+'">加好友</a>-->'+
          '</div>';


          $('#show-infomartion').html(userInfomartionHtml);
        }else{
          $.hideIndicator();
          $.toast('拉取信息失败');
          return false;
        }
      }

    });
  });
//
});
