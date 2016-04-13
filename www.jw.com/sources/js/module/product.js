/*
 * @Author: seaven
 * @Date:   2016-01-01 21:35:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-13 18:31:48
 */

var startX, endX;
var bantime;
$(function() {
    //---------begin load function----------------------/
    'use strict';
    $(document).on('pageInit', "#page-product", function(e, id, page) {
        //begin-------产品详情页面
        //begin-------判断请求id
        var id = getRrlParam('id');
        if (isEmpty(id)) {
            $.router.loadPage("index.php");
            return false;
        }
        var productInfo = {};
        //end-------判断请求id
        //begin-----ajax获取产品信息
        $.ajax({
            url: apiUrl + 'product/index/getInfo',
            type: 'GET',
            async: false,
            data: {
                id: id
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = JSON.parse(result);
                
                //判断数据是否为空
                if (!$.isEmptyObject(data)) {
                    //判断是否存在图组
                    var pichtml = ''; //图片的html
                    if (!$.isEmptyObject(data.pictures)) {
                        $(".preloader").addClass("disn");
                        var arr = Object.keys(data.pictures); //图片个数
                        var pic = data.pictures; //图片数据
                        for (var i = 0; i < arr.length; i++) {
                            pichtml += (i == 0) ? '<li class="w100b"><img class="w100b" style="min-height:15rem;" src="' + pic[i] + '" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" ></li>' : '<li class="w100b disn"><img class="w100b"  src="' + pic[i] + '" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" ></li>';
                        }
                    } else {
                        $(".preloader").addClass("disn");
                        pichtml = '<li class="w100b disn"><img class="w100b" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" src="/sources/images/defaultpic.gif"></li>';
                    }
                    $('#page-product .picitems').html(pichtml);
                    //产品信息存入sessionStroage中，加入购物车时读取
                    sessionStorage.removeItem("product_info");

                    productInfo.id = data.id;
                    productInfo.title = data.title;
                    productInfo.price = data.sale_price;
                    productInfo.stock = data.stock;
                    productInfo.short_desc = data.short_desc;
                    productInfo.thumb = data.thumb;
                    productInfo.transit_cost = data.transit_cost;
                    productInfo.params = data.params;
                    productInfo.is_real = data.is_real;
                    productInfo.product_sn = data.product_sn;
                    productInfo.levelId = data.levelId;
                    sessionStorage.setItem('product_info', JSON.stringify(productInfo));
                    sessionStorage.removeItem("categories_info");
                    var categoriesInfo = {};
                    categoriesInfo.cateid = data.catid;
                    sessionStorage.setItem('categories_info', JSON.stringify(categoriesInfo));

                    //判断品是否是平台导入的商品
                    var iconHTML = '';
                    console.log(data)
                    if(data.fromid  ){//用户导入的商品
                        iconHTML = '<i class="iconfont  fs10 cb1408">&#xe68c;</a>';
                    }else{
                        iconHTML = '';
                    }
                    //网页赋值
                    $("#page-product .product-title").html(data.title);
                    $("#page-product .sale_price").html("&yen;" + parseFloat(data.sale_price).toFixed(2) + "元");
                    $("#page-product .transit_type").html("库存:" + data.stock + "件" + iconHTML );
                    $("#page-product .seles").html("销量:" + data.sales + "笔");
                    $("#page-product .made").html("制造地:" + data.made);
                    $("#page-product .product_detail").attr({
                        'href': 'product_detail.php?id=' + data.id,
                        'data-id': data.id
                    });
                    $("#page-product .product_comment").attr({
                        'href': 'product_comment.php?id=' + data.id,
                        'data-id': data.id
                    });
                    $("#page-product .add-cart").attr({
                        'data-id': data.id
                    });
                    //$.alert('加载结束'+data.title);
                } else {
                    //获取数据为空，转到首页
                    $.toast('参数错误！正在转到首页....', 2000, 'error');
                    var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
                    $.router.loadPage("index.php?siteid=" + siteid); //转到首页
                    return false;
                }
            },
            error: function(request, status, error) {
                $.toast('参数错误！正在转到首页....', 2000, 'error');
                var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
                $.router.loadPage("index.php?siteid=" + siteid); //转到首页
                return false;
            }
        });
        //end-----ajax获取产品信息
        
        //微信分享
        
        $(".page-current  #shareData").attr('data-title', productInfo.title);
        $(".page-current  #shareData").attr('data-thumb', productInfo.thumb);
        $(".page-current  #shareData").attr('data-desc', productInfo.short_desc);
        $(".page-current  #shareData").attr('data-link', APP_PATH + 'product.php?id=' + productInfo.id + '&YunUser=' + sessionStorage.getItem('userid'));


        sessionStorage.removeItem("shareData_info");
        var shareData = {};
        shareData.title = productInfo.title;
        shareData.desc = productInfo.short_desc;
        shareData.link = APP_PATH + 'product.php?id=' + productInfo.id + '&YunUser=' + sessionStorage.getItem('userid');
        shareData.thumb = productInfo.thumb;

        sessionStorage.setItem('shareData_info',JSON.stringify(shareData));

        //begin-----分享弹出层
         $(page).on('click','.shareLink',function () { 
             sharePopup();
         });


        //end-----分享弹出层
        ////////////////////
        //begin---立即购买弹出层 //
        ////////////////////
        $(page).on('click', '.open-buy-popup', function() {
            promptlyBuy();
        });
        ////////////////////
        //end-----立即购买弹出层 //
        ////////////////////
        ///
        //////////////////////////
        //begin-------弹出加入购物车层, //
        //////////////////////////
        $(page).on('click', '.open-add-cart', function() {
            addToCart();
        });
        ////////////////////////
        //end-------弹出加入购物车层, //
        ////////////////////////
        ///
        /////////////////
        //begin---收藏弹框 //
        /////////////////
        $(page).on('click', '.collection-button', function() {
            collection();
        });
        /////////////////
        //end-----收藏弹框 //
        /////////////////
        ///

        //////////////////////////////////
        //BEGIN ------------转到购物车页面 //
        //////////////////////////////////
        $(page).on('click','.product-goto-cart',function(){
             var isLogin = checkLogin();
             if (!isLogin) {
               $.router.loadPage("login.php?backPage=http://www.zj3w.net/cart.php"); //转到登录页
               return false;
             }
             $.router.loadPage('cart.php');

        })



        /////////////////
        //begin---轮播图片 //
        /////////////////
        var radHtml = '';
        for (var i = 1; i <= $('.page-current  .product-banner ul li').size(); i++) {

            $('.page-current .product-banner ul li:eq(' + (i - 1) + ')').addClass('li' + i).attr('data-li',i);
            radHtml += '<div id="rad' + i + '" class="w10 h10 borrad50 marr5 bor2 fll bcfff"></div>';
            //$('#page-product .product-banners').append('<div id="rad' + i + '" class="w10 h10 borrad50 marr5 bor2 fll bcfff">');
        };
        $('.page-current .product-banners').html(radHtml);

        $('.page-current  .product-banners').css('margin-left', '-' + ($('.page-current   .product-banners div').size() * 15) / 2 + 'px');
        $('.page-current .product-banner ul .li1').css('display', 'block');
        $('.page-current  .product-banners #rad1').css('border-color', '#fa6a0b');
        bantime = setTimeout(function() {
            product_banner();
        }, 2000);

       var k = 1;

       $(page).on('swipeRight','.product-banner li',function(){
          clearTimeout(bantime);
          product_banner();
        })
        $(page).on('swipeLeft','.product-banner li',function(){
            k = $(this).attr('data-li');
            k = k - 2;
            if(k<0) k = $('.page-current .product-banner ul li').size() - 1;
            clearTimeout(bantime);
            product_banner();

        })


        function product_banner() {
            k++;
            if (k > $('.page-current .product-banner ul li').size()) k = 1;
            $('.page-current .product-banners div').css('border-color', '#fff');
            $('.page-current .product-banners #rad' + k).css('border-color', '#fa6a0b');
            $('.page-current .product-banner ul li').css('display', 'none');
            $('.page-current .product-banner ul li').removeClass('disn');
            $('.page-current .product-banner ul .li' + k).fadeIn(2000).css("display", "block");
            clearTimeout(bantime);
            bantime = setTimeout(function() {
                product_banner();
            }, 2000);
        }


        ///////////////
        //end---轮播图片 //
        ///////////////
        ///
        //////////////////////////
        //begin----------加载商品评论 //
        //////////////////////////
        //begin-----ajax获取产品信息
        $.ajax({
            url: apiUrl + '/comment/index/getComment',
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {
                product_id: $(".page-current .product_comment").attr('data-id')
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = result.data;
                var html = '';
                //判断数据是否为空
                if (!$.isEmptyObject(data)) {
                    $.each(data, function(index, item) {
                        var nickname = item.is_show_name == 1 ? '匿名' : item.nickname;
                        var avertImg =  item.avarat  != ''?item.avarat:'/sources/images/default_50x50.jpg';
                        html += '<div class="w100b padt10 bord1 bceee">';
                        html += '<div class="w100b h30 lh30 fs07 ovfh">';
                        html += '<div class="inlineblock w100b fll">';
                        html += '<span class="inlineblock h30 fll" style="vertical-align:middle"><img src="' + avertImg + '" class="w30 h30 borrad10"></span>';
                        html += '<span class="fll marl5">'+nickname+'</span>'
                        html += '<span class="flr c999 fs06">'+item.create_time+'</span>'
                       
                        html += '</div>';

                        html += '</div>';
                        html += '<div class="buy-comment fs06 mart5">' + item.evaluate_content + '</div>';
                        html += '</div>';

                    });

                } else {
                    html += '暂无评价！！';
                }
                $('.page-current  #product-comment-list').html(html);
            }
        });
        //end-------产品详情页面
    });
    //---------end load function-------------测试svn-------------
    //-------------/
});