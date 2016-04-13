$(function(){
	'use strict';
	$(document).on('pageInit','#page-shipping-detail',function(e,id,page){
		/**
		 * 查看订单商品物流
		 * @author 李鹏
		 * @data 2016-03-12
		 */
		 //判断是否登录
	    var user = checkLogin('1');
	    if (!user) {
	      $.router.loadPage('login.php');
	    }
	    //获取订单号
		var orderId = getRrlParam('order_id');
		//获取商品id
		var goodsId = getRrlParam('goods_id');
		var url = encodeURI(apiUrl+'order/index/orderGoodsShipping/order_id/'+orderId+'/goods_id/'+goodsId);
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
					var orderStatus = '';
					var goodsAttr2Json = JSON.parse(res['data']['order_goods']['goods_attr']);
					var i='';
					var goodsHtml = '';
					for(i in goodsAttr2Json){
						goodsHtml+= i+':'+goodsAttr2Json[i]+',';
					}
					// 循环订单下的产品
		                // 添加官字标志
		                var icon = '';
		                if(res['data']['order_goods']['from_id'] == 1 && res['data']['order_goods']['shop_id'] > 1){//表示平台导入的商品
		                    icon =  '<span style="display:block;height:30px;" class="padr4 "><i class="iconfont mar0 pad0 s12 b1408 cb1408"></i></span>';
		                }else if(res['data']['order_goods']['from_id'] == 1 && res['data']['order_goods']['shop_id'] == 1){//平台商品
		                  icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
		                }else{//表示自己添加的商品
		                  icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
		                }
		                
					var goodsDetailHtml = '<div class="w100b">'+
                      '<div class="fs08 marb10"></div>' +
                      '<div class="bgf4 h100 marb10">' +
                        '<div class="w28b h100 fll pad10">' +
                        '<a class="c666 external" href="product.php?id=' + res['data']['order_goods']['goods_id'] + '">' +
                          '<img class="block w80 h80" src="' + res['data']['order_goods']['goods_pic'] + '" alt="">' +
                        '</a>'+
                        '</div>'+
                        '<a class="c666 external" href="product.php?id=' + res['data']['order_goods']['goods_id'] + '">' +
                        '<div class="w40b h100 fll padl10 padt10 padb10">'+
                          '<div class="w100b">' + res['data']['order_goods']['goods_name'] + '</div>'+
                          '<div class="w100b">'+goodsHtml.substr(0,(goodsHtml.length-1))+'</div>'+
                        '</div>'+
                        '</a>'+
                        '<div class="w28b h100 fll txar pad10">'+
                          '<div>￥' + res['data']['order_goods']['goods_price'] + '</div>'+
                          '<div class="c999">x<span>' + res['data']['order_goods']['goods_number'] + '</span></div>' +
                          icon +
                          '<div class="mart8">'
                          '</div>'+
                        '</div>'+
                        '<div class="clear"></div>'+
                      '</div>'+
                      '</div>';
					var html = '<div class="list-block marb10 pad10 bgfff borb1 bce6 fs06">' +
			            '<div class="cfa6a0b fs08">' + orderStatus + '</div>' +
			            '<div>订单号：' + res['data']['order_info']['order_id'] + '</div>' +
			            '<div>支付方式：' + res['data']['order_info']['pay_name'] + '</div>' +
			            '<div>交易号：' + res['data']['order_info']['pay_no'] + '</div>' +
			            '<div>创建时间：' + res['data']['order_info']['add_time'] + '</div>' +
			            '<div>付款时间：' + res['data']['order_info']['pay_time'] + '</div>' +
			            '<div>发货时间：' + res['data']['order_goods']['shipping_time'] + '</div>' +
			            '<div>物流单号：' + res['data']['order_goods']['shipping_no'] + '</div>' +
			            '<div>物流费用：' + res['data']['order_goods']['shipping_fee'] + '</div>' +
			            '<div>物流名称：' + res['data']['order_goods']['shipping_name'] + '</div>' +
			            '<!--div>成交时间：' + res['data']['order_info']['confirm_time'] + '</div-->' +
			            '<div>订单备注：' + res['data']['order_info']['order_remark'] + '</div>' +
			            '</div>' +
			            '<div class="list-block marb10 pad10 bgfff bort1 borb1 bce6 fs06">' +
			            '<div class="c666">' +
			            '<div>' +
			            '<div class="fll">收货人：' + res['data']['order_info']['consignee'] + '</div>' +
			            '<div class="flr">' + res['data']['order_info']['mobile'] + '</div>' +
			            '<div class="clear"></div>' +
			            '</div>' +
			            '<div>收货地址：' + res['data']['order_info']['country'] + ' ' + res['data']['order_info']['province'] + ' ' + res['data']['order_info']['city'] + ' ' + res['data']['order_info']['district'] + ' ' + res['data']['order_info']['address'] + '</div>' +
			            '</div>' +
			            '</div>' +
			            '<div style="height:60px;overflow:hidden;cursor:pointer;" id="get-order-goods" class="list-block marb10 pad10 bgfff bort1 borb1 bce6 fs08" data-order-id="' + res['data']['order_info']['order_id'] + '">' +
			            '<span class="block fll h40 lh40">订单商品详情：</span>' +
			            '<span class="flr iconfont cCB1408">&#xe65d;</span>' +
			            '</div>' +
			            '<div class="card mar0 marb10 pad10">' +
			            '<div id="order-goods-block" class="mart5 fs06">' +
			            	goodsDetailHtml+
			            '</div>' +
			            '<div class="padt10 padr10 padl10" id="operation-block"><div class="clear"></div>' +
			            '</div>' +
			            '</div>';

	          			$('#order-infomartion-block').html(html);
				}else{

				}
			},
			error:function(err){
				$.toast('网络错误，请稍后再试');
			}
		});
	});
});