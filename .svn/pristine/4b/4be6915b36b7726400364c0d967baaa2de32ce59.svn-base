$(function() {
    'use strict';
    $(document).on('pageInit', '#page-order', function(e, id, page) {
        //判断是否登录
        var user = checkLogin('1');
        if (!user) {
            $.router.loadPage('login.php');
            return false;
        }
        //获取订单类型
        var orderType = getRrlParam('order_type');
        orderType = orderType || '';
        if (orderType && orderType !== '') {
            $('.order-page-bf').css({
                'border-color': '#fff',
                'color': '#3d4145'
            });
            var num = parseInt(orderType);
            if (num == 6) {
                num = 5;
            }
            $('.order-page-bf').eq(num).css({
                'border-color': '#fa6a0b',
                'color': '#fa6a0b',
                'border-bottom': '2px solid'
            });
        } else {
            $('.order-page-bf').css({
                'border-color': '#fff',
                'color': '#3d4145'
            });
            $('.order-page-bf').eq(0).css({
                'border-color': '#fa6a0b',
                'color': '#fa6a0b',
                'border-bottom': '2px solid'
            });
        }
     
        /**
         * 加载数据
         */
        function loadData(nums,offset) {
            var max = 0;
            var url = encodeURI(apiUrl + 'order/index/orderLists/num/'+nums+'/offset/'+offset+'/order_type/' + orderType);
            $.ajax({
                url: url,
                async: false,
                type: 'GET',
                headers: {
                    "Token": sso_Token
                },
                success: function(lists) {
                    lists = JSON.parse(lists);
                    // console.log(lists);
                    if (lists['code'] == 0) {
                        if (lists['data'][1] > 0) {
                            var orderHtml = '';
                            $.each(lists['data'][0], function(order_id, item) {

                                operation = '<a class="flr bor1 bce6 txac borrad5 marl10 padt4 padb4 padl10 padr10 c666 fs06" href="orderinfo.php?order_id=' + order_id + '">查看订单详情</a>';
                                
                                if(item.pay_status == 1){
                                    operation += '<a class="operation-buts flr borrad5 txac borrad3 marl10 padt4 padb4 padl10 padr10 white bgCB1408 fs06 payfor external" data-but-fn="confirm-order" data-order-id="' +  order_id + '" href="javascript:void(0);">立即付款</a>';
                                }

                                var orderGoods = '',
                                    order_num = 0,
                                    order_amount = 0,
                                    shipping_fee = 0,
                                    operation;
                                $.each(item['data'], function(og_id, orderinfo) {
                                    order_num += parseInt(orderinfo.goods_number);
                                    shipping_fee += orderinfo.shipping_fee * 10000;
                                    order_amount += orderinfo.order_total * 10000;
                                    var goodsAttrJson = JSON.parse(orderinfo['goods_attr']);
                                    var goodsAttrStr = '';
                                    $.each(goodsAttrJson, function(attr, attrValue) {
                                        goodsAttrStr += attr + '：' + attrValue + '；';
                                    })
                                    if (orderinfo.from_id == 1 && orderinfo.shop_id > 1) { //表示平台导入的商品
                                        var icon = '<span style="display:block;height:30px;" class="padr4 "><i class="iconfont mar0 pad0 s12 b1408 cb1408"></i></span>';
                                    } else if (orderinfo.from_id == 1 && orderinfo.shop_id == 1) { //平台商品
                                        var icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
                                    } else { //表示自己添加的商品
                                        var icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
                                    }
                                    orderGoods += '<a href="product.php?id=' + orderinfo['goods_id'] + '" class="external c666">' + '<div class="bgf4 marb10 h100">' + '<div class="w28b fll pad10 h100">' + '<img class="block w80 h80" src="' + orderinfo['goods_pic'] + '" alt="' + orderinfo['goods_name'] + '">' + '</div>' + '<div class="w44b h100 fll padt10 padb10 padl10 padl10">' + '<div class="w100b">' + orderinfo['goods_name'] + '</div>' + '<div class="w100b">' + goodsAttrStr + '</div>' + '</div>' + '<div class="w28b h100 fll txar pad10">' + '<div>￥' + orderinfo['goods_price'] + '</div>' + '<div class="c999">x<span>' + orderinfo['goods_number'] + '</span></div>' + icon + '<div class=""></div>' + '</div>' + '<div class="clear"></div>' + '</div>' + '</a>';
                                })
                                order_amount += shipping_fee
                                orderHtml += '<div class="card mar0 marb10 pad10">' + '<a class="c666 " href="orderinfo.php?order_id=' + order_id + '">' + '<div>' + '<div>' + '<div class="fll">订单号：' + order_id + '</div>' + '<div class="flr cfa6a0b"></div>' + '<div class="clear"></div>' + '</div>' + '<div class="mart5 fs06">' + orderGoods + '</div>' + '</div>' + '<div class="txar fs06 borb1 bce6 padb10">' + '共<span>' + order_num + '</span>件商品 合计：￥<span>' + order_amount / 10000 + '</span> (含运费￥<span>' + (shipping_fee / 10000) + '</span>)' + '</div>' + '</a>' + '<div class="padt10 padr10 padl10">' + operation + '<div class="clear"></div>' + '</div>' + '</div>';
                            })
                            var originalData = $('#all-order-list-block').html();
                            $('#all-order-list-block').html(originalData + orderHtml);
                            $('.infinite-scroll-preloader').remove();
                           
                            // 
                           
                        } else {
                            $.toast('订单已全部加载');
                            // 加载完毕，则注销无限加载事件，以防不必要的加载
                            $.detachInfiniteScroll($('.pull-to-refresh-content'));
                            // 删除加载提示符
                            $('.infinite-scroll-preloader').remove();
                            return false;
                        }
                    } else {
                          var noorderHtml = '<div class="card mar0 marb10 pad10"><div><div><a class="c666"><div class="fll">无相应订单</div></a><div class="flr cfa6a0b"></div><div class="clear"></div></div></div></div>';
                        $('#all-order-list-block').html(noorderHtml);
                        $('#page-order .infinite-scroll-preloader').remove();
                    }
                    max += parseInt(lists['data'][1]);
                }

            });
          return max;
        }
        // 微信支付获取openid
        $(page).on('click', '.payfor', function() {
            var order_id = $(this).attr('data-order-id');
            var appid = sessionStorage.getItem('appid') || 'wx34fdd0d60e7d4514';
            var fromurl = 'http://api.zj3w.net/wxpay/index/code?from=3&order_id=' + order_id;
            if (isWeixin) {
                var url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + appid + '&redirect_uri=' + encodeURIComponent(fromurl) + '&response_type=code&scope=snsapi_base&state=STATE%23wechat_redirect&connect_redirect=1#wechat_redirect';
                location.href = url;
                return false;
            }
        });
        /**========================================================================================================================================================**/
        
        //记录滚动
        var loading = false;
        var pages = 1;
        var offset = 4;
        var max =  loadData(pages,offset);

        //判读是否需要无限滚动加载
        loading = max > offset ? false : true;

        if (loading) {
          // 加载完毕，则注销无限加载事件，以防不必要的加载
          $.detachInfiniteScroll($('.infinite-scroll'));
          // 删除加载提示符
          //$('.infinite-scroll-preloader').remove();
          $(".preloader_null").removeClass("disn");
          $(".preloader").addClass("disn");
        }

        console.log(max);
        // /**
        //  * 下拉重新加载
        //  */
        // $(document).on('refresh', '.pull-to-refresh-content', function(e) {
        //     $('#all-order-list-block').html('');
        //     //刷新页面;
        //     loadData(1,offset);
        //     // 重置下拉刷新事件
        //     $.pullToRefreshDone('.pull-to-refresh-content');
        // });
       
        /**
         * 下拉翻页
         * 
         */
        $(page).on('infinite', function() {
            // 如果正在加载，则退出
            if (loading) return;
            // 设置flag
            loading = true;
            if (max > (pages * offset)) {
                // 更新页码
                pages++
                // 添加新条目
                max = loadData(pages,offset);
                // 重置加载flag
                loading = false;
                // 容器发生改变,如果是js滚动，需要刷新滚动
                $.refreshScroller();
            } else {
                // 加载完毕，则注销无限加载事件，以防不必要的加载
                //$.detachInfiniteScroll($('#page-order .infinite-scroll'));
                // 删除加载提示符
                //$('#page-order .infinite-scroll-preloader').remove();

                $.detachInfiniteScroll($('.infinite-scroll'));
                // 删除加载提示符
                //$('.infinite-scroll-preloader').remove();
                $(".preloader_null").removeClass("disn");
                $(".preloader").addClass("disn");
                return;
            }
        });
        /**========================================================================================================================================================**/
        /**
         * 订单操作
         * @author 李鹏
         * @date 2016-03-02
         */
        orderOperation();

        function orderOperation() {
            $(page).on('click', '.operation-buts', function() {
                $.showIndicator();
                var order_id = $(this).attr('data-order-id');
                switch ($(this).attr('data-but-fn')) {
                    case 'delete-order': //删除订单
                        var url = encodeURI(apiUrl + 'order/index/deleteOrder/order_id/' + order_id);
                        $.ajax({
                            url: url,
                            type: 'GET',
                            async: false,
                            headers: {
                                "Token": sso_Token
                            },
                            success: function(res) {
                                $.hideIndicator();
                                res = JSON.parse(res);
                                if (res.code == 0) {
                                    $.hideIndicator();
                                    $.toast('删除成功');
                                    //重新加载页面
                                    window.location.reload();
                                } else {
                                    $.hideIndicator();
                                    $.toast('操作失败，请稍后再试');
                                }
                            },
                            error: function(err) {
                                $.hideIndicator();
                                $.toast(err);
                            }
                        });
                        break;
                    case 'canael-order': //取消订单
                        var url = encodeURI(apiUrl + 'order/index/cancelOrder/order_id/' + order_id);
                        $.ajax({
                            url: url,
                            type: 'GET',
                            async: false,
                            headers: {
                                "Token": sso_Token
                            },
                            success: function(res) {
                                res = JSON.parse(res);
                                if (res.code == 0) {
                                    $.hideIndicator();
                                    $.toast('订单已撤销');
                                    //重新加载页面
                                    window.location.reload();
                                } else {
                                    $.hideIndicator();
                                    $.toast('操作失败，请稍后再试');
                                }
                            },
                            error: function(err) {
                                $.hideIndicator();
                                $.toast(err);
                            }
                        });
                        break;
                    case 'confirm-order': //确定支付
                        //判断订单是否已存在
                        var url = encodeURI(apiUrl + 'order/index/orderIsExists/order_id/' + order_id);
                        $.ajax({
                            url: url,
                            type: 'GET',
                            async: false,
                            headers: {
                                "Token": sso_Token
                            },
                            success: function(res) {
                                res = JSON.parse(res);
                                if (res.code == 0) {
                                    $.hideIndicator();
                                    $.toast('此订单已经支付');
                                    return false;
                                } else {
                                    $.hideIndicator();
                                    $.router.loadPage('trade_pay.php?order_id=' + order_id);
                                }
                            },
                            error: function(err) {
                                $.hideIndicator();
                                $.toast('网络出错，请稍后再试');
                            }
                        });
                        break;
                    default: //确认收货
                        var url = encodeURI(apiUrl + "order/index/confirmReceipt/order_id/" + order_id);
                        // console.log(order_id);
                        $.ajax({
                            url: url,
                            async: false,
                            type: 'GET',
                            headers: {
                                "Token": sso_Token
                            },
                            success: function(res) {
                                $.hideIndicator();
                                res = JSON.parse(res);
                                if (res.code == 0) {
                                    $.toast('您的订单已确认收货');
                                    $.router.loadPage('orderinfo.php?order_id=' + order_id, true);
                                } else {
                                    $.toast('订单确认收货失败');
                                }
                            },
                            error: function(err) {
                                $.hideIndicator();
                                $.toast(err);
                            }
                        });
                        break;
                }
            });
        }
        /**====================================================================================================================================================================================**/
    });
    //
});