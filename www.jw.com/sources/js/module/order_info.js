$(function() {
  'use strict';
  $(document).on('pageInit', '#page-order-infomartion', function(e, id, page) {
    //判断是否登录
    var user = checkLogin('1');
    if (!user) {
      $.router.loadPage('login.php');
    }
    //获取订单号
    var orderId = getRrlParam('order_id');
    var url = encodeURI(apiUrl + 'order/index/get/order_id/' + orderId);


    $.ajax({
      url: url,
      async: false,
      type: 'GET',
      headers: {
        "Token": sso_Token
      },
      success: function(orderInfo) {
        orderInfo = JSON.parse(orderInfo);
        // 
        if (orderInfo['code'] == 0) {
                  
                var orderStatus = '';
                var operation = '';
                var goodsDetailHtml = '';
                var shipping_fee = 0;
                var orderdata = orderInfo['data'];
                // 产品循环
                $.each(orderdata['detail'][0], function(order_id, item) {
                  // icon 标志
                   if(item.from_id == 1 && item.shop_id > 1){//表示平台导入的商品
                       var icon =  '<span style="display:block;height:30px;" class="padr4 "><i class="iconfont mar0 pad0 s12 b1408 cb1408"></i></span>';
                    }else if(item.from_id == 1 && item.shop_id == 1){//平台商品
                     var icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
                    }else{//表示自己添加的商品
                     var icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
                    }

                    shipping_fee += item.shipping_fee * 10000;
                  // 产品属性
                  
                  var goodsAttrJson = JSON.parse(item.goods_attr);
                  var goodsAttrStrHtml ='';
                  var orderGoodsStatusHtml = '';
                  $.each(goodsAttrJson, function(attr, attrValue) {
                     goodsAttrStrHtml += attr + '：' + attrValue + '；';
                  })
                  // console.log(item.goods_status)
                  // 产品状态按钮
                  switch (parseInt(item.goods_status)) {
                    case 2:
                  
                    orderStatus = '付款成功，等待发货';
                      if(parseInt(item.goods_status) == 3){
                        orderGoodsStatusHtml = '<span class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06">已发货</span><a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="shipping.php?order_id='+ item.order_id +'&goods_id='+ item.goods_id +'">查看物流</a>';
                      }else{
                        orderGoodsStatusHtml = '<span class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06">未发货</span>';
                      }
                    break;
                   
                    case 3:
                    orderStatus = '已发货，等待收货 ';
                    if(parseInt(item.goods_status) == 3){
                      orderGoodsStatusHtml = '<span class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06">未收货</span><a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="shipping.php?order_id='+ orderdata['order_id'] +'&goods_id='+ item.goods_id +'">查看物流</a>';
                    }else{
                      orderGoodsStatusHtml = '<span class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06">已收货</span><a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="assess.php?goods_id=' + item.goods_id + '&order_id=' + orderdata['order_id'] + '">我要评价</a><a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="shipping.php?order_id='+ orderdata['order_id'] +'&goods_id='+ item.goods_id +'">查看物流</a>';
                    }
                      orderGoodsStatusHtml += '<a class="operation-buts flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 external" data-but-fn="" data-goods-id="' + item.goods_id + '" data-order-id="' + item.order_id + '" data-shop-id="'+ orderdata.from_shopid +'" href="javascript:void(0);">确认收货</a>';

                    break;
                    
                    case 4:
                    orderStatus = '已收货 ';
                      if(parseInt(item.is_comment) == 1){
                        // 已评价
                         orderGoodsStatusHtml += '<a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 external" href="javascript:void(0);">已评价</a>';
                        
                      }else{
                          orderGoodsStatusHtml += '<a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="assess.php?goods_id=' + item.goods_id + '&order_id=' + orderdata.order_id + '">我要评价</a>';
                      }
                        // ，0未申请，1同意退货，2，申请退货,3不同意退货
                      if(parseInt(item.is_after_sales) == 1){
                          // 未申请售后
                            orderGoodsStatusHtml += '<a class=" flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 " data-but-fn="after-sales" data-goods-id="' + item.goods_id + '" data-order-id="' + item.order_id + '" data-shop-id="'+ orderInfo.from_shopid +'" data-is-after-sales="'+ item.is_after_sales +'" href="after_sales.php">同意退货</a>';
                            
                        }else if(parseInt(item.is_after_sales) == 2){
                            orderGoodsStatusHtml += '<a class=" flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 " data-but-fn="after-sales" data-goods-id="' + item.goods_id + '" data-order-id="' + item.order_id + '" data-shop-id="'+ orderInfo.from_shopid +'" data-is-after-sales="'+ item.is_after_sales +'" href="after_sales.php">退货受理中</a>';

                        }else if(parseInt(item.is_after_sales) == 3){
                            orderGoodsStatusHtml += '<a class=" flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 " data-but-fn="after-sales" data-goods-id="' + item.goods_id + '" data-order-id="' + item.order_id + '" data-shop-id="'+ orderInfo.from_shopid +'" data-is-after-sales="'+ item.is_after_sales +'" href="after_sales.php">退货失败</a>';

                        }else{
                            orderGoodsStatusHtml += '<a class="operation-buts flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06 external" data-but-fn="after-sales" data-goods-id="' + item.goods_id + '" data-og-id="' + item.og_id + '" data-order-id="' + item.order_id + '" data-shop-id="'+ orderdata.from_shopid +'" href="javascript:void(0);">申请售后</a>';

                        }
                             
                       orderGoodsStatusHtml +=     '<a class="flr bor1 bce6 txac borrad5 marl10 padl10 padr10 c666 fs06" href="shipping.php?order_id='+ orderdata.order_id +'&goods_id='+ item.goods_id +'">查看物流</a>';
                        
                    break;

                  }
                  
                  // 产品详情
                  goodsDetailHtml += '<div class="w100b">'+
                        '<div class="fs08 marb10"></div>' +
                        '<div class="bgf4 h100 marb10">' +
                          '<div class="w28b h100 fll pad10">' +
                          '<a class="c666 external" href="product.php?id=' + item.goods_id + '">' +
                            '<img class="block w80 h80" src="' + item.goods_pic + '" alt="">' +
                          '</a>'+
                          '</div>'+
                          '<a class="c666 external" href="product.php?id=' + item.goods_id + '">' +
                          '<div class="w40b h100 fll padl10 padt10 padb10">'+
                            '<div class="w100b">' + item.goods_name + '</div>'+
                            '<div class="w100b">' + goodsAttrStrHtml + '</div>'+
                          '</div>'+
                          '</a>'+
                          '<div class="w28b h100 fll txar pad10">'+
                            '<div>￥' + item.goods_price + '</div>'+
                            '<div class="c999">x<span>' + item.goods_number + '</span></div>' +
                            icon+
                            '<div class="mart8">'+
                            '</div>'+
                          '</div>'+
                         
                          '<div class="clear"></div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="w100b" style="overflow:hidden;">' + orderGoodsStatusHtml + '</div>';

                 })
                var html = '<div class="list-block marb10 pad10 bgfff borb1 bce6 fs06">' +
                  '<div class="cfa6a0b fs08">' + orderStatus + '</div>' +
                  '<div>订单号：' + orderdata['order_id'] + '</div>' +
                  '<div>支付方式：' + orderdata['pay_name'] + '</div>' +
                  '<div>交易号：' + orderdata['pay_no'] + '</div>' +
                  '<div>创建时间：' + orderdata['add_time'] + '</div>' +
                  '<div>付款时间：' + orderdata['pay_time'] + '</div>' +
                  '<!--div>成交时间：' + orderdata['confirm_time'] + '</div-->' +
                  '<div>订单备注：' + orderdata['order_remark'] + '</div>' +
                  '</div>' +
                  '<div class="list-block marb10 pad10 bgfff bort1 borb1 bce6 fs06">' +
                  '<div class="c666">' +
                  '<div>' +
                  '<div class="fll">收货人：' + orderdata['consignee'] + '</div>' +
                  '<div class="flr">' + orderdata['mobile'] + '</div>' +
                  '<div class="clear"></div>' +
                  '</div>' +
                  '<div>收货地址：' + orderdata['country'] + ' ' + orderdata['province'] + ' ' + orderdata['city'] + ' ' + orderdata['district'] + ' ' + orderdata['address'] + '</div>' +
                  '</div>' +
                  '</div>' +
                  '<div style="height:60px;overflow:hidden;cursor:pointer;" id="get-order-goods" class="list-block marb10 pad10 bgfff bort1 borb1 bce6 fs08" data-order-id="' + orderdata['order_id'] + '">' +
                  '<span class="block fll h40 lh40">订单商品详情：</span>' +
                  '<span class="flr iconfont cCB1408 mart5">&#xe65d;</span>' +
                  '</div>' +
                  '<div class="card mar0 marb10 pad10">' +
                  '<div id="order-goods-block" class="mart5 fs06">' +
                    goodsDetailHtml+
                  '</div>' +
                  '<div class="txar fs06 borb1 bce6 padb10">' +
                  '共<span>'+ orderdata['order_num'] +'</span>件商品 合计：￥<span>' + orderdata['order_amount'] + '</span> (含运费￥<span>' + shipping_fee / 10000 + '</span>)' +
                  '</div>' +
                  '<div class="padt10 padr10 padl10" id="operation-block">' + operation   + '<div class="clear"></div>' +
                  '</div>' +
                  '</div>';

                
                  // 删除
               
                $('#order-infomartion-block').html(html);
                
              
          } else {
            $.toast('查询失败');
          }
      }

    });
/**---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

  
  /**
     * 订单操作
     * @author 李鹏
     * @date 2016-03-09
     */
    orderOperation();
    function orderOperation(){
      $(page).on('click','.operation-buts',function(){
        var _this = this;
        $.showIndicator();
        var order_id = $(this).attr('data-order-id');
        var goods_id = $(this).attr('data-goods-id');
        switch($(this).attr('data-but-fn')){
          case 'delete-order'://删除订单
            var url = encodeURI(apiUrl+'order/index/deleteOrder/order_id/'+order_id);
            $.ajax({
              url : url,
              type : 'GET',
              async : false,
              headers : {
                "Token" : sso_Token
              },
              success : function(res){
                $.hideIndicator();
                res = JSON.parse(res);
                if(res.code == 0){
                  $.hideIndicator();
                  $.toast('删除成功');
                  //重新加载页面
                  $.router.loadPage('');
                }else{
                  $.hideIndicator();
                  $.toast('操作失败，请稍后再试');
                }
              },
              error : function(err){
                $.hideIndicator();
                $.toast(err);
              }
            });
          break;
          case 'canael-order'://取消订单
            var url = encodeURI(apiUrl+'order/index/cancelOrder/order_id/'+order_id);
            // console.log(url);
            $.ajax({
              url:url,
              type:'GET',
              async:false,
              headers:{
                "Token": sso_Token
              },
              success:function(res){
                res = JSON.parse(res);
                if(res.code == 0){
                  $.hideIndicator();
                  $.toast('订单已撤销');
                  //重新加载页面
                  $.reouter.loadPage('');
                }else{
                  $.hideIndicator();
                  $.toast('操作失败，请稍后再试');
                }
              },
              error:function(err){
                $.hideIndicator();
                $.toast(err);
              }
            });
          break;
          case 'after-sales'://申请售后
            if(parseInt($(this).attr('data-is-after-sales')) == 1){
              $.hideIndicator();
              $.toast('此商品正在售后中');
              return false;
            }
            $.confirm('您确定申请售后',function(){
              var goodsId = $(_this).attr('data-goods-id');
              var shopId = $(_this).attr('data-shop-id');
              var url = encodeURI(apiUrl+'afterSales/index/afterSales/order_id/'+order_id+'/goods_id/'+goodsId+'/shop_id/'+shopId);
              $.ajax({
                url:url,
                type:'GET',
                async:false,
                headers:{
                  "Token": sso_Token
                },success:function(res){
                  res = JSON.parse(res);
                  if(res.code == 0){
                    $.hideIndicator();
                    $.router.loadPage('after_sales.php',true);
                  }else　if(res.code == 1){
                    $.hideIndicator();
                    $.toast('请求出错，请稍后再试！');
                  }else{
                    $.hideIndicator();
                    $.toast('售后条件未满足！发货时间超过15天!');
                  }
                },
                error:function(err){
                  $.hideIndicator();
                  $.toast('网络出错，请稍后再试');
                }
              });
            },function(){
              $.hideIndicator();
              return false;
            });
          break;
          case 'confirm-order'://确定支付
            //判断订单是否已存在
            var url = encodeURI(apiUrl+'order/index/orderIsExists/order_id/'+order_id);
            $.ajax({
              url:url,
              type:'GET',
              async:false,
              headers:{
                "Token": sso_Token
              },
              success:function(res){
                res = JSON.parse(res);
                if(res.code == 0){
                  $.hideIndicator();
                  $.toast('此订单已经支付');
                  return false;
                }else{
                  $.hideIndicator();
                  $.router.loadPage('trade_pay.php?order_id='+order_id);
                }
              },
              error:function(err){
                $.hideIndicator();
                $.toast('网络出错，请稍后再试');
              }
            });
          break;
          default://确认收货
            var url = encodeURI(apiUrl+"order/index/confirmReceipt/order_id/"+order_id+"/goods_id/"+goods_id);
            // console.log(order_id);
            $.ajax({
              url: url,
              async: false,
              type: 'GET',
              headers: {
                "Token": sso_Token
              },
              success : function(res){
                $.hideIndicator();
                res = JSON.parse(res);
                if(res.code == 0){
                  $.toast('您的订单的产品已确认收货');
                  $.router.loadPage('orderinfo.php?order_id='+order_id,true);
                }else{
                  $.toast('订单确认收货失败');
                }
              },
              error : function(err){
                $.hideIndicator();
                $.toast(err);
              }
            });
          break;
        }
      });
    }



  });
});
