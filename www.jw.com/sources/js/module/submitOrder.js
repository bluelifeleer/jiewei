/**
 * @Author: seaven
 * @Date:   2016-01-01 21:35:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-13 18:31:48
 */
/**
 * 选中地址
 * @param  {[type]} addressid   [description]
 * @param  {[type]} username    [description]
 * @param  {[type]} mobile      [description]
 * @param  {[type]} shipAddress [description]
 * @return {[type]}             [description]
 */
function choseAddress(addressid, username, mobile, shipAddress) {
  $("input[name=address]").val(addressid);
  $(".Address_username").html('收货人:'+username);
  $(".Address_mobile").html('联系方式:'+mobile);
  $(".Address_shipAddress").html('地址:'+shipAddress);
  $(".Address_icon").html('&#xe626;');
  $.closePanel("#panel-js-demo");
}
$(function() {
  'use strict';
  $(document).on('pageInit', '#page-submit-order', function(e, id, page) {

    ////////////////////////////////////////////
    //判断是否的登入----------------BDGIN----------- //
    ////////////////////////////////////////////
    var userInfo = checkLogin();
    if (!userInfo) {
      setTimeout(function() {
        $.router.load("/login.php?back=cart.php"); //转到登录页
      }, 2000);
      return false;
    }

    ///////////////////////////////////////////////
    //------------加载默认地址------------------------ //
    ///////////////////////////////////////////////
    $.ajax({
      url: apiUrl + 'address/index/get_def_add',
      async: false,
      type: 'GET',
      headers: {
        "Token": sso_Token
      },
      success: function(result) {
        var data = JSON.parse(result);
        if (data.code == '0') {
         var info = data.data;
         $("input[name=address]").val(info.id);
         $(".Address_username").html('收货人:'+info.username);
         $(".Address_mobile").html('联系方式:'+info.mobile);
         $(".Address_shipAddress").html('地址:'+info.ship_data+' '+info.detail_address);
         $(".Address_icon").html('&#xe626;');
        }
      }
    })

    //////////////////////////////////////////////
    //browserStorage 取出购物车中需要结算商品信息      //
    //载入商品--------------------------------BEGIN //
    //////////////////////////////////////////////
    var submitOrderInfo = $.parseJSON(sessionStorage.getItem('submitOrder_info'));

    if (!$.isEmptyObject(submitOrderInfo)) {
      var userid = $.parseJSON(sessionStorage.getItem('user_info')).userid;
      var html = '';
      var total = 0;
      var amount = 0;
      var transit_cost = 0; //物流费用
      var ids = submitOrderInfo.ids; //购车结算 同时可以结算多款产品

      if (isEmpty(ids)) { //ids为空则为商品立即购买 只购买单款产品

        $.each(submitOrderInfo, function(index, el) {
          if (el.userid == userid) {
            html += '<div class="mart5 fs06  c666">';
            html += '<div class="bgf4 marb10">';
            html += '<div class="w30b fll pad10">';
            html += '<img class="w100b" width="100%" src="' + el.thumb + '" alt=""></div>';
            html += '<div class="w40b fll padt10 padb10">' + cutString(el.title, 200) + '</div>';
            html += '<div class="w20b flr txar pad10">';
            html += '<div>&yen' + parseFloat(el.price).toFixed(2) + '</div>';
            html += '<div class="c999 mart50">';
            html += 'x';
            html += '<span>' + el.num + '</span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="clear"></div>';
            html += '</div>';
            html += '</div>';
            transit_cost = parseFloat(transit_cost) + parseFloat(el.transit_cost)*el.num;
            total = parseInt(total) + parseInt(el.num);
            amount = amount + parseFloat(el.num).toFixed(2) * parseFloat(el.price).toFixed(2);
          }

        });
      } else { //购物车结算

        ids = ids.split(','); //','拆分字符串  返回ids数组
        $.each(ids, function(index, id) {
          var cartInfo = $.parseJSON(sessionStorage.getItem('cart_info'));
          if (!$.isEmptyObject(cartInfo)) {
            $.each(cartInfo, function(index, el) {
              if (el.userid == userid && el.id == id) {
                var transitHtml = el.transit_cost != 0 ? "物流费用：&yen;"+el.transit_cost:"";
                html += '<a class="mart5 fs06  c666" href="javascript:void(0)">';
                html += '<div class="bgf4 marb10">';
                html += '<div class="w80 fll padl10 padt10 padr10">';
                html += '<img class="w100b"  src="' + el.thumb + '" alt=""></div>';
                html += '<div class="w50b fll padt10 padb10"><div class="w100b h36">' + cutString(el.title, 200) + '</div><span class="c999 padt10 w100b">'+transitHtml+'</span></div>';
                html += '<div class="w10b flr txar padt10 padr10">';
                html += '<div>&yen' + el.price + '</div>';
                html += '<div class="c999 mart20">';
                html += 'x';
                html += '<span>' + el.num + '</span>';
                html += '</div>';
                html += '</div>';
                html += '<div class="clear"></div>';
                html += '</div>';
                html += '</a>';
                transit_cost = parseFloat(transit_cost) + parseFloat(el.transit_cost)*el.num;
                total = parseInt(total) + parseInt(el.num);
                amount = amount + parseFloat(el.num).toFixed(2) * parseFloat(el.price).toFixed(2);
              }
            });

          }

        });
      }
      $('.page-current #select-product').html(html);
      $('.page-current .total').html(total);
      $('.page-current .amount').html(parseFloat(amount + transit_cost).toFixed(2));
      $('.page-current #transit_cost').html(parseInt(transit_cost) != 0 ? parseFloat(transit_cost).toFixed(2) : '免邮');
      $('.page-current .other-amount').html(parseFloat(transit_cost).toFixed(2));
      $(".page-current .preloader").html('加载完成！');
      $(".page-current .preloader").addClass("disn");
      $(".page-current .preloader_null").removeClass("disn");
    } else {
      $(".page-current .preloader_null").removeClass("disn");
      $(".page-current .preloader").addClass("disn");
    }


    ///////////////////////////////////////
    // 载入收货地址------------BEGIN---------÷ //
    ///////////////////////////////////////
    $(page).on('click','.open-choose-address-popup',function(){
      sessionStorage.setItem('back', JSON.stringify([]));
     
      $.ajax({
        url: apiUrl + 'address/index/show_address',
        async: false,
        type: 'GET',
        headers: {
          "Token": sso_Token
        },
        success: function(result) {
          var data = JSON.parse(result);
          if (data.code == '0') {
            var info = data.data;
            html = '';
            $.each(info, function(id, item) {
              html += '<li onclick="choseAddress(' + item.id + ',\'' + item.username + '\',\'' + item.mobile + '\',\'' + item.ship_data + item.detail_address + '\');void(0);">';
              html += '<label class="label-checkbox item-content">';
              html += '<input type="radio" class="address-radio" id="order-address" name="address-radio" data-id="' + item.id + '" value="' + item.id + '">';
              html += '<div class="item-media"><i class="icon icon-form-checkbox"></i></div>';
              html += '<div class="item-inner"  style="display:block;">';
              html += '<div class="item-title">';
              html += '<div>' + item.username + '</div>';
              html += '<div>' + item.mobile + '</div>';
              html += '</div><div class="clear"></div>';
              html += '<div class="items-title">' + item.ship_data + item.detail_address + '</div>';
              html += '</div>';
              html += '</label>';
              html += '</li>';
            })
          }else if(data.code == 2){
             html = '<li><label class="label-checkbox item-content"><div class="item-title close-panel"><a href="add_address.php?backPage=submit_order.php">请先增加您的地址</a></div></label></li>';
          }

        }
      })
      $("#panel-js-demo .address").html(html);
      $.openPanel("#panel-js-demo");
    });


    ///////////////////////////////////
    //提交订单信息-------------------BEGIN //
    ///////////////////////////////////


    $(page).on('click', '#submit-order-btn', function() {

      if($('#page-submit-order #submit-order-address').val() == ''){
         $.toast('请选择收货地址！');
         return ;
      }


      //提交订单
      var submitOrderInfo = $.parseJSON(sessionStorage.getItem('submitOrder_info'));
      var userid = $.parseJSON(sessionStorage.getItem('user_info')).userid;
      var total = 0;
      var amount = 0;
      var transit_cost = 0; //物流费用
      var data = {}; //提交数据
      if (!$.isEmptyObject(submitOrderInfo)) {
        var ids = submitOrderInfo.ids; //购车结算 同时可以结算多款产品
        data.addressId = $('#page-submit-order #submit-order-address').val();
        data.amount = parseFloat($('.amount').html()).toFixed(2);
        data.productNum = $('.total').html();
        data.comment = $('#orderComment').val();
        data.YunUser = sessionStorage.getItem('YunUser');
        //店铺Id
        data.siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
        var productInfo = {};

        if (isEmpty(ids)) { //ids为空则为商品立即购买 只购买单款产品
          var i = 0;
          var products = [];
          $.each(submitOrderInfo, function(index, el) {
            if (el.userid == userid) {
              productInfo.id = el.id;
              productInfo.num = el.num;
              productInfo.siteid = el.siteid;
              productInfo.transit_cost = parseFloat(el.transit_cost).toFixed(2)*el.num;
              productInfo.params = el.params;
              products[i] = productInfo;
              i++;
            }
          });
          data.productInfo = products;
        } else {
          ids = ids.split(','); //','拆分字符串  返回ids数组
          var i = 0;
          var cartInfo = $.parseJSON(sessionStorage.getItem('cart_info'));
          var products = [];
          $.each(ids, function(index, id) {

            $.each(cartInfo, function(index, el) {
              if (el.userid == userid && el.id == id) {
                var productInfo = {};
                productInfo.id = el.id;
                productInfo.num = el.num;
                productInfo.siteid = el.siteid;
                productInfo.transit_cost = parseFloat(el.transit_cost).toFixed(2)*el.num;
                productInfo.params = el.params;
                products[i] = productInfo;
                i++;
              }

            });
          });
          data.productInfo = products;

        }
      }
      //ajax提交订单
      $.showIndicator();

      var url = encodeURI(apiUrl + 'order/index/addOrder');

      $.ajax({
        url: url,
        async: false,
        type: 'POST',
        data: data,
        headers: {
          "Token": sso_Token
        },
        success: function(respos) {
          sessionStorage.setItem('submit_order', JSON.stringify(data));
          respos = JSON.parse(respos);
          if (respos['code'] == 0) {

            //提交成功清除购物车中对应的产品
            var userid = JSON.parse(sessionStorage.getItem('user_info')).userid;
            var submitOrderInfo = $.parseJSON(sessionStorage.getItem('submitOrder_info'));
            var ids = submitOrderInfo.ids; //购车结算 同时可以结算多款产品
            var cartInfo = $.parseJSON(sessionStorage.getItem('cart_info'));

            if (!isEmpty(ids)) {
              ids = ids.split(','); //','拆分字符串  返回ids数组
              $.each(ids, function(index, id) {
                $.each(cartInfo, function(index, el) {
                  if (el.userid == userid && el.id == id) {
                    delete cartInfo[index];
                  }
                });

              });

              sessionStorage.setItem('cart_info', JSON.stringify(cartInfo));

            }
            $.hideIndicator();
            //清除sessionStorage订单提交信息
            sessionStorage.removeItem('submitOrder_info');

            var appid = sessionStorage.getItem('appid') || 'wx34fdd0d60e7d4514';
            var fromurl ='http://api.zj3w.net/wxpay/index/code?from=3&order_id=' + respos['data'];
             if (isWeixin) {
                var url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + appid + '&redirect_uri=' + encodeURIComponent(fromurl) + '&response_type=code&scope=snsapi_base&state=STATE%23wechat_redirect&connect_redirect=1#wechat_redirect';
                location.href = url;
                return false;
            }


            // $.router.loadPage('trade_pay.php?order_id=' + respos['data']);

          } else {
            $.hideIndicator();
            $.toast('添加订单信息失败请稍后再试');
            return false;
          }
        }

      });

    });

  });

  ///////////////////////////////////////
  //InitPage --------测试svn--------------EBD //
  ///////////////////////////////////////
});