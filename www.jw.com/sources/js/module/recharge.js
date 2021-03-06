$(function(){
  'use strict';
  $(document).on('pageInit','#page-recharge',function(e,id,page){
    //判断用户是否登录
    var loginInfo = checkLogin('1');
    if (!loginInfo) {
      $.router.loadPage('login.php');
      return false;
    }

    // 支付获取code
      function jsApiCall(info) {
        WeixinJSBridge.invoke('getBrandWCPayRequest', info, function(res) {
            WeixinJSBridge.log(res.err_msg);
            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                sessionStorage.setItem('vpaystatu', 'ok');
            }
            if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                sessionStorage.setItem('vpaystatu', 'cancel');
            }
            if (res.err_msg == 'get_brand_wcpay_request:fail') {
                sessionStorage.setItem('vpaystatu', 'fail');
            }
        });
    }
    //
    function callpay(info) {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        } else {
            jsApiCall(info);
        }
    }
    // 支付获取code结束

    var pageFn = getRrlParam('fn');
    if(pageFn && pageFn != ''){
      $('.total-title').html('550元');
      $('.total-title').attr('data-total-value',550);
    }else{
      $('.total-title').html('500元');
      $('.total-title').attr('data-total-value',500);
    }


    $(page).on('click', '.select-but', function(){
      $('.select-but').attr('data-is-open',false);
      $('.rechager-content-block').css('display','none');
      $('.option-status-icon').html('&#xe600;');
      $(this).attr('data-is-open',true);
      $('.rechager-content-block').eq(parseInt($(this).attr('data-index'))).css('display','block');
      $('.option-status-icon').eq(parseInt($(this).attr('data-index'))).html('&#xe658;');
    });


       

    /**
     * 选择金额
     * @author 李鹏
     * @date 2016-02-17
     */
     $(page).on('click','.select-total',function(){
         $('.select-total').attr('data-is-checked',false);
         $(this).attr('is-checked',true);
         $('.check-but').html('&#xe61c;');
         $('.check-but').eq($(this).index()).html('&#xe626;');
         $('.total-title').html($('.total').eq($(this).index()).html());
         $('.total-title').attr('data-total-value',$('.total').eq($(this).index()).attr('data-opation-value'));
     });

     /**
      * 自定义金额
      * @author 李鹏
      * @date 2016-02-17
      */
    $(page).on('focus','#input-total-but',function(){
      $('.select-total').attr('data-is-checked',false);
      $('.check-but').html('&#xe61c;');
    });
    $(page).on('blur','#input-total-but',function(){
      if($(this).val() != ''){
        if(parseInt($(this).val()) == 'NAN'){
          $.toast('请输入正确的金额');
          return false;
        }else{
          $('.total-title').html($(this).val()+'元');
          $('.total-title').attr('data-total-value',$(this).val());
        }
      }else{
        $.toast('请选择或输入金额');
        return false;
      }
    });


    /**
     * 选择支付方式
     * @author 李鹏
     * @date 2016-02-17
     */
     $(page).on('click','.select-pay-type-but',function(){
       $('.select-pay-type-but').attr('data-selected',false);
       $(this).attr('data-selected',true);
       if($(this).attr('data-value') == 'wechat-pay'){
         $('#pay-type').html('微信支付');
         $('#pay-type').attr('data-pay-type-value',2);
       }else{
         $('#pay-type').html('支付宝支付');
         $('#pay-type').attr('data-pay-type-value',3);
       }
     });



     /**
      * 提交支付
      * @author 李鹏
      * @date 2016-02-17
      */
      $(page).on('click','#submit-but',function(){
         $.modal({
                title: '请在新开页面完成支付！',
                buttons: [{
                    text: '重试',
                    onClick: function() {}
                }, {
                    text: '完成支付',
                    onClick: function() {
                        var statu = sessionStorage.getItem('vpaystatu');
                        if (statu == 'ok') {
                            $.router.loadPage('balance.php');
                            sessionStorage.removeItem('vpaystatu');
                            
                        }
                        if (statu == 'cancel') {
                            $.alert('支付失败')
                        }
                        if (statu == 'fail') {
                            $.alert('支付失败')
                        }
                    }
                }, ]
            })
            
            var openid = getRrlParam('openid');
            // alert(openid);
            var fee = parseFloat($('.total-title').attr('data-total-value'));
            //如果有openid就获取info 调用支付
            $.ajax({
                type: "GET",
                url: encodeURI(apiUrl+'wxpay/index/vpay')+"?fee=" + fee + "&openid=" + openid,
                async: false,
                headers: {
                  "Token": sso_Token
                },
                success: function(result) {
                    // alert(result);
                    if (result != '0') {
                        var data = JSON.parse(result);
                        var info = JSON.parse(data.data);
                        callpay(info);
                    } 
                    // else {
                    //     $.router.loadPage('recharge_choice.php');
                    // }
                },
                error: function() {
                    wcpay_request_cancel();
                }
            });
        // 原有支付逻辑开始
        // var url = encodeURI(apiUrl+'recharge/index/recharge');
        // var data = {
        //   'total' : parseFloat($('.total-title').attr('data-total-value')),
        //   'pay_type' : $('#pay-type').attr('data-pay-type-value')
        // }
        // $.ajax({
        //   url : url,
        //   async : false,  //同步请求
        //   timeout : 500,  //请求超时时间
        //   type : 'POST', //请求类型
        //   headers: {
        //     "Token": sso_Token
        //   },
        //   data : data,
        //   success : function(res){
        //     //有数据时隐藏加载器
        //     $.hideIndicator();
        //     //将返回数据转成json对象
        //     res = JSON.parse(res);
        //     if(res.code == 0){
        //       $.toast('充值成功',2000);
        //       //充值成功中转到用户钱包页面
        //       $.router.loadPage('balance.php');
        //     }else{
        //       $.toast('充值失败',2000);
        //     }
        //   }, 
        //   error : function(err){
        //     //请求失败，隐藏加载器，并显示错误
        //     $.hideIndicator();
        //     $.toast(err,2000);
        //   }
        // });
        // 原有支付逻辑结束


      });


  });
});
