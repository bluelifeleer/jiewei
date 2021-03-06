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
    $(document).on('pageInit', "#page-product-detail-manage", function(e, id, page) {
    	 //begin-------产品详情页面
    	  //begin-------判断请求id
        var id = getRrlParam('id');
        if (isEmpty(id)) {
        	var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
            $.router.loadPage("index.php?siteid="+siteid);
            return false;
        }
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
                        $("#page-product-detail-manage .preloader").addClass("disn");
                        var arr = Object.keys(data.pictures); //图片个数
                        var pic = data.pictures; //图片数据

                        for (var i = 0; i < arr.length; i++) {
                            pichtml += (i == 0) ? '<li class="w100b"><img class="w100b" style="min-height:15rem;" src="' + pic[i] + '" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" ></li>' : '<li class="w100b disn"><img class="w100b"  src="' + pic[i] + '" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" ></li>';
                        }
                    } else {
                        $("#page-product-detail-manage .preloader").addClass("disn");
                        pichtml = '<li class="w100b disn"><img class="w100b" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\'" src="/sources/images/defaultpic.gif"></li>';
                    }
                    $('#page-product-detail-manage .picitems').html(pichtml);
                    
                    //网页赋值
                    $("#page-product-detail-manage  .product-title").html(data.title);
                   
                    $("#page-product-detail-manage .input_product_id").val(data.id);
                    $("#page-product-detail-manage .input_product_sn").val(data.product_sn);
                    $("#page-product-detail-manage .input_title").val(data.title);
                    $("#page-product-detail-manage .input_short_desc").html(data.short_desc);
                    $("#page-product-detail-manage .input_sale_price").val(data.sale_price);
                    $("#page-product-detail-manage .input_made").val(data.made);
                    $("#page-product-detail-manage .input_fromid").val(data.fromid);
                    if(data.is_hot == 99){
                        $("#page-product-detail-manage .input_is_hot").attr('checked',data.is_hot);
                    }
                    if(data.is_recommend == 99){
                         $("#page-product-detail-manage .input_is_recommend").attr('checked',data.is_recommend);
                    }

                    // if(data.is_up == 99){
                    //      $("#page-product-detail-manage .input_is_up").attr('checked',data.is_up);
                    // }
                   
                    //产品栏目
                    var siteid = $.parseJSON(sessionStorage.getItem('user_info')).userid;
                    var cateInfo = getCategoty(siteid);
                    if(!$.isEmptyObject(cateInfo)){
                      var html = '';
                      $.each(cateInfo,function(index, el){
                      	if(el.catid == data.catid) {
                      		  html += ' <option selected="selected" value="'+el.catid+'">'+el.catname+'</option>';
                      	}
                        html += ' <option value="'+el.catid+'">'+el.catname+'</option>';
                       
                      });
                      $('#page-product-detail-manage .input-select-cate').html(html);
                    }

                   
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
        

        ///////////////////////////
        //------提交表单-=---------- //
        ///////////////////////////
        $(page).on('click','.input_submit',function(){
            var id = $('.page-current .input_product_id').val();
            var product_sn = $('.page-current .input_product_sn').val();
            var title = $('.page-current .input_title').val();
            var catid = $('.page-current .input-select-cate').val();
            var fromid = $('.page-current .input_fromid').val();
            var short_desc = $('.page-current .input_short_desc').val();
            var sale_price = $('.page-current .input_sale_price').val();
            var made = $('.page-current .input_made').val();
            if ($(".page-current .input_is_hot").is(':checked')) {
                var is_hot = 1;
            } else {
                var is_hot = 99;
            }
            if ($(".page-current .input_is_recommend").is(':checked')) {
                var is_recommend = 1;
            } else {
                var is_recommend = 99;
            }

            var url = encodeURI(apiUrl + 'product/index/ModifiedProduct');

            $.ajax({
                url: url,
                async: false,
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    product_sn: product_sn,
                    title: title,
                    catid: catid,
                    fromid:fromid,
                    short_desc: short_desc,
                    sale_price: sale_price,
                    made:made,
                    is_hot:is_hot,
                    is_recommend:is_recommend
                },
                headers: {
                    "Token": sso_Token
                },
                success: function(result) {
                    var data =result;

                    if (data.code == 200) {
                        $.toast('更新成功!');
                    } else {
                        $.toast('更新失败!');
                        return false;
                    }
                }

            });


        });
    })
})