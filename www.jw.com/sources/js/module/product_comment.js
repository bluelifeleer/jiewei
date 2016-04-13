/**
 * 评价列表
 * @Author: seaven
 * @Date:   2016-1-11 15:21:40
 * @Last Modified time: 2016-1-11 15:21:40
 */
$(function(){
  'use strict';


  //$("#left-link").attr({'href':'/product.php?id='+id ,'data-id':id});

 
  $(document).on("pageInit", "#page-comment", function(e, id, page) {
  
    /**
     *  分享弹出层
     *  author 李鹏
     *  date    2015-12-13
     */
    $(page).on('click','.open-share-popup',function(){
      sharePopup();
      });
    var id = getRrlParam('id');
        if(isEmpty(id)){
             $.router.loadPage('index.php');
             return false;
         }
    $(".page-current #backProduct").attr({'href':'product.php?id='+id ,'data-id':id});

    //初始化加载
    var loading = false;
    var pages = 1;
    var offset = 10;
    var max = 0;

    max = addItems(offset, pages,id);

    loading = max > offset ? false : true;


    if (loading) {
      // 加载完毕，则注销无限加载事件，以防不必要的加载
      $.detachInfiniteScroll($('.infinite-scroll'));
      // 删除加载提示符
      //$('.infinite-scroll-preloader').remove();
      $(".page-current .preloader_null").removeClass("disn");
      $(".page-current .preloader").addClass("disn");
      $('.page-current .infinite-scroll-preloader').text('没有更多的评论!')
    }



      //////////////////////////////////
      //BEGIN ------------转到购物车页面 //
      //////////////////////////////////
      $(page).on('click','.product-comment-goto-cart',function(){
           var isLogin = checkLogin();
           if (!isLogin) {
             $.router.loadPage("login.php?backPage=http://www.zj3w.net/cart.php"); //转到登录页
             return false;
           }
           $.router.loadPage('cart.php');

      })

      ///////////////////
    //begin---立即购买弹出层 //
    ////////////////////
    $(page).on('click', '.open-buy-popup', function() {
        promptlyBuy();
    });

    //////////////////////////
    //begin-------弹出加入购物车层, //
    //////////////////////////
    $(page).on('click', '.open-add-cart', function() {
        addToCart();
    });
 
    });

  /**
   * 下拉列表
   * @param
   */
  $(document).on('infinite', '.infinite-scroll-bottom',function() {
    // 如果正在加载，则退出
    if (loading) return;
    // 设置flag
    loading = true;

    if (max > (pages * offset)) {
      // 更新页码
      pages++
      // 添加新条目
      var id = getRrlParam('id');
          if(isEmpty(id)){
               $.router.loadPage('index.php');
               return false;
           }
     //初始化加载
     var loading = false;
     var pages = 1;
     var offset = 10;
     var max = 0;

      max = addItems(offset, pages,id);
      // 重置加载flag
      loading = false;
      // 容器发生改变,如果是js滚动，需要刷新滚动
      $.refreshScroller();
    }else{
      // 加载完毕，则注销无限加载事件，以防不必要的加载
      $.detachInfiniteScroll($('.infinite-scroll'));
      // 删除加载提示符
      //$('.infinite-scroll-preloader').remove();
      $(".page-current .preloader_null").removeClass("disn");
      $(".page-current .preloader").addClass("disn");
      $('.page-current .infinite-scroll-preloader').text('没有更多的评论!')

      return true;
    }
  });

  /**
   * 加载商品评价列表
   * @param {[offset]} number  分页数量
   * @param {[pages]} number 页码
   * @param {[order]} string 排序字段
   */
  function addItems(offset, pages,id) {
    var max = 0 ;
    var catid = catid || 0;
    $.ajax({
      type: "GET",
      url: apiUrl+'/comment/index/lists',
      async: false,
      data: "pages="+pages+"&offset="+offset+"&id="+id,
      headers: {"Token":sso_Token},
      success: function(result){
        var result = JSON.parse(result);
        // console.log(data);
        max = result.total;
       // var data = result.data;
        var list = result.data;
        var html = '';
        $.each(list, function(i, item){
          var nickname = item.is_show_name == 1?'匿名':item.nickname;
          var avertImg =  item.avarat  != ''? item.avarat:'/sources/images/default_50x50.jpg';

          html += '<div class="card mar0 pad5 marb10">'
          html += '<div class="h30" style="line-height:30px;">'
          html += '<div class="w10b fll">'
          html += '<img class="w30 h30 borrad50 marauto" src="'+avertImg+'" alt="">'
          html += '</div>'
          html += '<div class="w90b flr">'
          html += '<span class="fll marl5">'+nickname+'</span>'
          html += '<span class="flr c999 fs06">'+item.create_time+'</span>'
          html += '<div class="clear"></div>'
          html += '</div>'
          html += '<div class="clear"></div>'
          html += '</div>'
          html += '<div class="padt5 padb5">'+item.evaluate_content+'</div>'
          html += '</div>'
        });
        $('.infinite-scroll-bottom .comment-content-list-block').append(html);
      }
    });
    return max;
  }
});