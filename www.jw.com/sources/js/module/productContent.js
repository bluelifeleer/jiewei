/*
* @Author: seaven
* @Date:   2016-01-02 01:02:52
* @Last Modified by:   anchen
* @Last Modified time: 2016-01-13 18:31:34
*/
$(function(){

    //载入产品图文详情
    $(document).on('pageInit','#page-product-content',function(e,id,page){

        //加载产品图文信息
        //载入商品信息
        var id = getRrlParam('id');
            if(isEmpty(id)){
                 $.router.loadPage('index.php');
                 return false;
             }
        $(".page-current #backProduct").attr({'href':'product.php?id='+id ,'data-id':id});
        //ajax获取产品信息
        $.ajax({
              url: apiUrl+'product/index/getInfo',
              type: 'GET',
              dataType: 'json',
              async: false,
              data: {id: id},
              headers: {"Token":sso_Token},
              success:function(result){
                var data = result;
                html = $.isEmptyObject(data.content)?'没有发布详情内容！':data.content;
                $("#product_content").html(html);
              },
              error:function(request, status, error){
                $("#product_content").html('请求超时！');
                return false;
              }
            });
            


        /**
         *  分享弹出层
         */
        $(page).on('click','.open-share-popup',function(){
             sharePopup();
        });

        /**
         *  收藏弹框
         */
        $(page).on('click','.collection-button',function(){
           collection();
        });
        /**
         *  加入购物车/立即购买弹出层
         */
        $(page).on('click','.open-popup-but',function(){
            var action = "";
            if($(this).attr('data-fn') == 'add-cart'){//添加购物车
                addToCart();
            }else{//立即购买
                promptlyBuy();
            }

        });

        //////////////////////////////////
        //BEGIN ------------转到购物车页面 //
        //////////////////////////////////
        $(page).on('click','.product-content-goto-cart',function(){
             var isLogin = checkLogin();
             if (!isLogin) {
               $.router.loadPage("login.php?backPage=http://www.zj3w.net/cart.php"); //转到登录页
               return false;
             }
             $.router.loadPage('cart.php');

        })
        /**
         * 回到顶部
         */
         $(page).on('click','#go-to-top-block',function(event){

            scrollToTop($('#product-contenter'));
         })


        
    });

});
