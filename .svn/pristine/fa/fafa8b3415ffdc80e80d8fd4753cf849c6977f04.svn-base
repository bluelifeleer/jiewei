$(function() {
  'use strict';
  $(document).on('pageInit', '#page-trade-pay', function(e, id, page) {
    //显示加载指示器
    $.showIndicator();
    //订单金额
    var orderAmount;
    //判断用户是否登录
    var userInfo = checkLogin('1');
    //获取订单信息
    var order_id = getRrlParam('order_id');
    var url = encodeURI(apiUrl + 'order/index/get/order_id/' + order_id);

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

    $.ajax({
      url: url,
      async: false,
      type: 'GET',
      headers: {
        "Token": sso_Token
      },
      success: function(result) {
        //隐藏加载指示器
        $.hideIndicator();
        result = JSON.parse(result);
        if (result['code'] == 0) {
          sessionStorage.setItem('payment', 1);
          var shippingFree = 0;
          var orderGoods = '';
         
          $.each(result['data']['detail'][0], function(order_id, item) {
               //计算所有商品的物流费用
               shippingFree += parseInt(item.shipping_fee*100);
                orderGoods += '<div style="overflow:hidden;width:100%;height:100px;">' +
                                 '<a href="product.php?id=' + item.goods_id + '" class="external">' +
                                        '<div class="bgf4 marb10">' +
                                               '<div class="w30b fll pad10">' +
                                               '<img class="block w80 h80" src="' + item.goods_pic + '" alt="' + item.goods_name + '">' +
                                               '</div>' +
                                               '<div class="w40b fll padt10 padb10 fs07" style="color:#3d4145;">' + item.goods_name + '</div>' +
                                               '<div class="w30b flr txar pad10">' +
                                                      '<div>￥' + item.goods_price + '</div>' +
                                                      '<div class="c999">x<span>' + item.goods_number + '</span></div>' +
                                               '</div>' +
                                               '<div class="clear"></div>' +
                                        '</div>' +
                                 '</a>' +
                          '</div>';
            })
          
          orderAmount = result['data']['order_amount'];
          var html = '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07">'+
            '<div class="fll w25b h40 lh40">订单编号：</div>'+
            '<div class="fll w75b h40 lh40" id="order-no">' + result['data']['order_id'] +'</div>'+
          '</div>'+
          '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07 padb10" syle="height:auto;">'+
            '<div class="w100b h40 lh40">订单商品详情：</div>'+
            '<div id="order-info" class="w100b">'+
              '<div style="padding-left:0">' + orderGoods + '</div>' +
            '</div>'+
          '</div>'+
          '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07">'+
            '<div class="fll w25b h40 lh40">优惠：</div>'+
            '<div class="fll w75b h40 lh40">' + result['data']['coupons_total'] +'</div>'+
          '</div>'+
          '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07">'+
            '<div class="fll w25b h40 lh40">物流费用：</div>'+
            '<div class="fll w75b h40 lh40">' + (shippingFree/100) + '</div>'+
          '</div>'+
          '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07">'+
            '<div class="fll w25b h40 lh40">需支付：</div>'+
            '<div class="fll w75b h40 lh40">&yen;' + result['data']['order_amount'] +'</div>'+
          '</div>'+
          '<div class="w90b marauto borb1 bcc1c1c1 ovfh fs07" id="picker">'+
            '<div class="fll w25b h40 lh40">支付方式：</div>'+
            '<div class="fll w65b h40 lh40 pay_name" id="pay_name">' + result['data']['pay_name'] + '</div>'+
            '<div class="fll w10b h40 lh40"><i class="iconfont fs09 cccc mar0">&#xe600;</i></div>'+
          '</div>';
          $('#order-info-block').html(html);

          //判断订单是否支付成功
          if (parseInt(result['data']['order_status']) == 2 && parseInt(result['data']['pay_status']) == 2) {
            $.toast('订单已支付成功');
            $.router.loadPage('orderinfo.php?order_id=' + result['data']['order_id']);
          } else {
            return false;
          }
        } else {
          //隐藏加载指示器
          $.hideIndicator();
          $.toast('查询订单信息失败');
        }
        $('#paybut').removeClass('disn')
      },
      error:function(err){
        //隐藏加载指示器
        $.hideIndicator();
        $.toast('请求失败');
      }

    });


    /**
     *	选择支付方式
     *	@author李鹏
     *	@date 2015-12-19
     */
    $(page).on('click', '#picker', function(obj) {

      var payments = [{
        text: '请选择支付方式',
        label: true
      }, {
        text: '余额支付',
        bold: true,
        color: 'danger',
        onClick: function() {
          $('.pay_name').text('余额支付');
          sessionStorage.setItem('payment', 1);
        }
      }, {
        text: '微信支付',
        onClick: function() {
          $('.pay_name').text('微信支付');
          sessionStorage.setItem('payment', 2);
        }
      }];
      var actions = [{
        text: '取消',
        bg: 'danger'
      }];
      var groups = [payments, actions];
      $.actions(groups);
    });

    /**
     *	提交支付请求信息
     *	@author李鹏
     *	@date 2015-12-19
     */
    $(page).on('click', '#pay-but', function() {
      $.showIndicator();
      var payType = parseInt(sessionStorage.getItem('payment'));
      if (payType == 1) { //余额支付
        var url = encodeURI(apiUrl + 'account/index/getWallet');

        $.ajax({
          url: url,
          async: false,
          type: 'GET',
          headers: {
            "Token": sso_Token
          },
          success: function(amount) {
            amount = JSON.parse(amount);
            if (amount['code'] == 0) {
              if (parseFloat(amount['data']['amount']) < parseFloat(orderAmount)) {
                $.hideIndicator();
                // $.toast('余额不足，请先充值');
                $.confirm('余额不足，使用微信支付', function(){
                    $('.pay_name').text('微信支付');
                    sessionStorage.setItem('payment', 2);
                }, function(){
                  $.router.loadPage('order.php?order_type=1');
                });
                  
              }else{
                var payUrl = encodeURI(apiUrl + 'order/index/payOrder');
                var data = {
                  'order_id' : order_id,
                  'is_coupon' : 0, //是否使用优惠券[默认0，不使用]，使用1
                  'coupon_id' : 0,//优惠券id
                  'is_red_packets' : 0,//是否使用红包
                  'red_packets_id' : 0//红包id
                }
                $.ajax({
                  url: payUrl,
                  async: false,
                  type: 'POST',
                  headers: {
                    "Token": sso_Token
                  },
                  data:data,
                  success: function(payStatus) {
                    // console.log(payStatus);
                    // return false;
                    payStatus = JSON.parse(payStatus);
                    if (payStatus['code'] == 0) {
                      //隐藏加载指示器
                      $.hideIndicator();
                      $.toast('支付成功');
                      window.location.href='order.php?order_type=2';
                    } else {
                      //隐藏加载指示器
                      $.hideIndicator();
                      $.toast('支付失败');
                      return false;
                    }
                  },
                  error:function(err){
                    //隐藏加载指示器
                    $.hideIndicator();
                    $.toast('请求失败');
                  }

                });
              }
            } else {
              $.toast('获取余额信息失败');
            }
          },
          error:function(err){
            //隐藏加载指示器
            $.hideIndicator();
            $.toast('请求失败');
          }

        });
      } else { //微信支付
          $.modal({
                title: '请在新开页面完成支付！',
                buttons: [{
                    text: '重试',
                    onClick: function() {
                      $.hideIndicator();
                      sessionStorage.removeItem('vpaystatu');
                      
                    }
                }, {
                    text: '完成支付',
                    onClick: function() {
                        var statu = sessionStorage.getItem('vpaystatu');
                        if (statu == 'ok') {
                             $.hideIndicator();
                             var url = encodeURI(apiUrl + 'account/index/getWallet');
                            $.ajax({
                              url: url,
                              async: false,
                              type: 'GET',
                              headers: {
                                "Token": sso_Token
                              },
                              success: function(amount) {
                                amount = JSON.parse(amount);
                                if (amount['code'] == 0) {
                                  if (parseFloat(amount['data']['amount']) < parseFloat(orderAmount)) {
                                    $.hideIndicator();
                                    // $.toast('余额不足，请先充值');
                                    $.confirm('余额不足，使用微信支付', function(){
                                        $('.pay_name').text('微信支付');
                                        sessionStorage.setItem('payment', 2);
                                    }, function(){
                                      $.router.loadPage('order.php?order_type=1');
                                    });
                                      
                                  }else{
                                    var payUrl = encodeURI(apiUrl + 'order/index/payOrder');
                                    var data = {
                                      'order_id' : order_id,
                                      'is_coupon' : 0, //是否使用优惠券[默认0，不使用]，使用1
                                      'coupon_id' : 0,//优惠券id
                                      'is_red_packets' : 0,//是否使用红包
                                      'red_packets_id' : 0//红包id
                                    }
                                    $.ajax({
                                      url: payUrl,
                                      async: false,
                                      type: 'POST',
                                      headers: {
                                        "Token": sso_Token
                                      },
                                      data:data,
                                      success: function(payStatus) {
                                        // console.log(payStatus);
                                        // return false;
                                        payStatus = JSON.parse(payStatus);
                                        if (payStatus['code'] == 0) {
                                          //隐藏加载指示器
                                          $.hideIndicator();
                                          $.toast('支付成功');
                                          window.location.href='order.php?order_type=2';
                                        } else {
                                          //隐藏加载指示器
                                          $.hideIndicator();
                                          $.toast('支付失败');
                                          return false;
                                        }
                                      },
                                      error:function(err){
                                        //隐藏加载指示器
                                        $.hideIndicator();
                                        $.toast('请求失败');
                                      }

                                    });
                                  }
                                } else {
                                  $.toast('获取余额信息失败');
                                }
                              },
                              error:function(err){
                                //隐藏加载指示器
                                $.hideIndicator();
                                $.toast('请求失败');
                              }

                            });
                            sessionStorage.removeItem('vpaystatu');
                            
                        }
                        if (statu == 'cancel') {
                            $.hideIndicator();

                            $.alert('支付失败')
                        }
                        if (statu == 'fail') {
                            $.hideIndicator();
                            $.alert('支付失败')
                        }
                    }
                }, ]
            })
            
            var openid = getRrlParam('openid');
            // alert(openid);
            var fee = parseFloat(orderAmount);
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
      }
    });



  });
  //
});
