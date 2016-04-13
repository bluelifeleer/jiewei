$(function(){
  'use strict';


  $(document).on('pageInit','#page-login',function(e,id,page){
    // $('#account').val('');
    // $('#password').val('');
    var siteid = getRrlParam('siteid');
    //判断地址是否有siteid
     siteid = isEmpty(siteid)?'1':siteid;
     //判断是否存在店铺，不存在转平台店铺
     siteid = checkShop(siteid)== 0 ? 1: siteid;
     $('#shop-index').attr('href','/index.php?siteid='+siteid);

    //判断用户是否登录
    var user_info = sessionStorage.getItem('user_info')|| '{}';
        user_info = JSON.parse(user_info);
    if(Object.keys(user_info) > 1){
       $.router.loadPage('member.php');
    }
    var _back = JSON.parse(sessionStorage.getItem('back'));
    var callbackurl = getRrlParam('backPage') || 'http://www.zj3w.net/member.php';
      callbackurl = urlencode(callbackurl);
    $("#wechat-login-but").attr('href','http://api.zj3w.net?m=account&c=index&a=wechatLogin&HTTP_TOKEN='+sessionStorage.getItem('sso_session')+'&goback='+callbackurl);
    /**
     *	用户登录
     *	@auther 李鹏
     *	@data 2015-12-15
     *  @editDate 2015-12-23
     */
     $(page).on('click','#login-in-but',function(){
      //获取输入的帐号、密码
      // del_cookie('userid');
      var account = $('#account').val();
      var pasd = $('#password').val();
      
       $.showIndicator();
       //判断手机号或者密码是否为空
       if(account == ''){
         $.hideIndicator();
         $.toast('手机号不能为空！');
         return false;
       }
       //判断手机号或者密码是否为空
       if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(account))){
          $.hideIndicator();
          $.toast('手机格式错误！');
          return false;
       }

       //判断密码是否为空
       if(pasd == ''){
          $.hideIndicator();
          $.toast('请填写密码！');
          return false;
       }

      

      var url = encodeURI(apiUrl+'account/index/login');
      var data = {
          'account' : account,
          'password' : pasd
        };
      /**
       * 登录处理中转到页面处理方式
       * 判断请求地址是否有 back参数  back参数是登录请求跳转时的一个时间搓
       * 如果存在则返回上一个页面，不存在则返回会员中心
       */
    $.ajax({
        type: 'POST',
        url: url,
        timeout: 500,
        aysnc: false,
        data:data,
        headers: {"Token":sso_Token},
        success: function(respos) {
              var strToJsonObj = JSON.parse(respos);
              if(strToJsonObj.code == 0){//登录成功
                $.hideIndicator();
                var userid =  strToJsonObj.data.userid;
                // if(!isEmpty(userid)){
                //   set_cookie('userid', userid,1,'/');
                // }
                // sessionStorage.setItem('user_info',JSON.stringify(strToJsonObj['data']));
                //判断是否放回上一个页面
                if(!isEmpty(getRrlParam('backPage'))){
                  //返回上一页
                  var form_app_page = getRrlParam('backPage');
                  $.router.loadPage(form_app_page,true);
                }else{
                  //转到会员中心
                  $.router.loadPage('member.php');
                }
              }else if(strToJsonObj.code == 2){//手机号不存在
                $.hideIndicator();
                $.toast('手机号不存在，请注册',1500);
                $.router.loadPage('register.php');
              }else if(strToJsonObj.code == 1){//密码错误
                $.hideIndicator();
                $.toast('密码错误，请重新输入',1500);
                // console.log(sso_Token);
              }else{
                $.hideIndicator();
              }
        },
        error:function(err){
          $.hideIndicator();
          $.toast('请求失败'+err);
        }
    });  



     });
//其他事件




  });
//
});
