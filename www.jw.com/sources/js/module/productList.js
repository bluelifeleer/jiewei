/*
 * @Author: seaven
 * @Date:   2015-12-31 18:47:17
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-13 18:31:14
 */

$(function() {
  'use strict';
  /**
   * 载入产品
   * @param {[offset]} number  分页数量
   * @param {[pages]} number 页码
   * @param {[order]} string 排序字段
   * @param {[catid]} number 栏目id
   */
  var pages = 1;
  function productAddItems(offset, pages, catid, siteid) {
    var max = 0;
    var catid = catid || 0;
    //获取排序字段
    var sortKey = sessionStorage.getItem('sortKey');
    //获取排序方式  
    var sortValue = sessionStorage.getItem('sortValue');

    //加载数据
    $.ajax({
      type: "GET",
      url: apiUrl,
      async: false,
      data: {
        m: 'product',
        c: 'index',
        a: 'lists',
        page: pages,
        offset: offset,
        order: sortKey,
        sort:sortValue,
        catid: catid,
        siteid: siteid
      },
      dataType: "json",
      headers: {
        "Token": sso_Token
      },
      success: function(result) {
        var data = result;
        max = data['total'];
        var list = data.data;
        var html = '';
        $.each(list, function(i, item) {
          html += '<div class="pad10 bgfff borb1 bce6">';
          html += '<a class="c999"  href="product.php?id=' + item.id + '" data-id="' + item.id + '">';
          html += '<div class="w80 fll">';
          html += '<a class="c666"  href="product.php?id=' + item.id + '" data-id="' + item.id + '">';
          html += '<img class="pos-r product-list-thumb" width="100%" style="top:50%;" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\';"  src="/sources/images/defaultpic.gif" data-original="' + item.thumb + '" alt=""></a>';
          html += '</div><div class="w60b fs06 fll padl10 padr0">';
          html += '<a class="c666 fs07"  href="product.php?id=' + item.id + '" data-id="' + item.id + '">';
          html += '<div style="min-height:36px;">' + cutString(item.title, 40) + '</div></a>';
          html += '<div class="c999"> 销量：' + item.sales + ' </div>';
          html += '<div class="fs09  cfa6a0b"><span class="fs06">价格：&yen;</span>' + item.sale_price + '</div>';
          html += '</div></a>';
          html += '<div class="w10b flr" style="padding-top:20px;"><a class="c666" href="product.php?id=' + item.id + '" data-id="' + item.id + '">';
          html += '<div class=" h40  txac borrad50 flr" style="line-height:35px;">';
          html += '<i class="icon iconfont fs06 mar0 padr10">&#xe600;</i>';
          html += '</div>';
          html += '</a></div>';
          html += '<div class="clear"></div>';
          html += '</div>';
        });
        $('.infinite-scroll .list-container').append(html);
        //图片懒加载
        $('.product-list-thumb').picLazyLoad({
          threshold: 0,
          placeholder: '/sources/images/defaultpic.gif'
        });
         // 删除加载提示符
        $('.infinite-scroll-preloader').remove();
      }
    });

    return max;
  }

  /**
   * [getCategoty 获取栏目信息]
   * @method getCategoty
   * @return {[type]}    [description]
   */
  function getCategoty(siteid) {
    var data = {
      m: 'product',
      c: 'index',
      a: 'getCate',
      siteid: siteid
    };
    var json = '';
    json = ajaxRequest('GET', false, data);
    return json;
  }


  //初始化页面
  $(document).on('pageInit', '#page-product-list', function(e, id, page) {
    //设置排序方式和字段
    sessionStorage.setItem('sortKey','id');
    sessionStorage.setItem('sortValue','DESC');

    //获取店铺ID
    var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
    var loading = false;
    pages = 1;
    var offset = 6;
    //设置栏目值，先获取url地址栏目id,重新给 sessionStorage中categories_info赋值
    var cateid = isEmpty(getRrlParam('cateid')) ? '0' : getRrlParam('cateid');
    sessionStorage.removeItem("categories_info");
    var categoriesInfo = {};
    categoriesInfo.cateid = cateid;
    sessionStorage.setItem('categories_info', JSON.stringify(categoriesInfo));
    //加载商品列表数据
    var max = productAddItems(offset, pages, cateid, siteid);
    //图片懒加载
    $('.product-list-thumb').picLazyLoad({
      threshold: 0,
      placeholder: '/sources/images/defaultpic.gif'
    });
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

    /**
     * 下拉列表，
     * @param
     */
    $(page).on('infinite', function() {
      dropRefresh(max,offset,pages,loading);
      pages++;
    });

    //下拉刷新商品数据加载
    function dropRefresh(max,offset,pages,loading){
     
      // 如果正在加载，则退出
      //图片懒加载
      $('.product-list-thumb').picLazyLoad({
        threshold: 0,
        placeholder: '/sources/images/defaultpic.gif'
      });
      var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
      if (loading) return false;
      loading = true;
      if (max > (pages * offset)) {
        // 更新页码
        pages++
        // 添加新条目

        var cateid = sessionStorage.getItem('categories_info') != null ? JSON.parse(sessionStorage.getItem('categories_info')).cateid : 0;
        max = productAddItems(offset, pages, cateid, siteid);

        // 重置加载flag
        loading = false;
        // 容器发生改变,如果是js滚动，需要刷新滚动
        $.refreshScroller();
      } else {
        // 加载完毕，则注销无限加载事件，以防不必要的加载
        //$.detachInfiniteScroll($('.infinite-scroll'));
        // 删除加载提示符
        
        $(".preloader_null").removeClass("disn");
        $(".preloader").addClass("disn");

        return false;
      }

    }


    //侧边栏打开之前事件 open  打开动画开始之前触发。
    $(page).on('click', '#product-list-cate', function() {
      $.openPanel("#categories-popup");
      //获取店铺id
      var siteid = JSON.parse(sessionStorage.getItem('site_info')).siteid;
      //获取栏目信息，初始化栏目页面数据
      var cateInfo = getCategoty(siteid);
      if (!$.isEmptyObject(cateInfo)) {
        var html = '';
        var count = 0;
        $.each(cateInfo, function(index, el) {
          if (el.parentid == 0) {
            html += '<li class="item-cate p-' + el.catid + '" item-data="' + el.catid + '"  data-catid="' + el.catid + '" style="min-height: 1.2rem;">';
            html += '<div class="item-inner c666 pad10" style="min-height: 1.2rem;">';
            html += '<div class="item-title fs06 c666">' + el.catname + '</div>';
            html += '<div class="item-after">';
            html += '<i class="icon iconfont mar0 c666 flr fs05 arrowr disi">&#xe648;</i>';
            html += '</div>';
            html += '</div>';
            html += '</li>';
            var tmpid = el.catid;
            if (el.child == 1) {
              $.each(cateInfo, function(index, el) {
                if (el.parentid == tmpid) {
                  html += '<div class="c-' + el.parentid + ' borl3  disn">';
                  html += '<div class="item-content child-item" data-catid="' + el.catid + '" style="min-height: 1.2rem;">';
                  html += '<div class="item-inner c666" style="min-height: 1.2rem;">';
                  html += '<div class="item-title fs06 c666">' + el.catname + '</div>';
                  html += '<div class="item-after">';
                  html += '</div>';
                  html += '</div>';
                  html += '</div>';
                  html += '</div>';
                }
              });
            }
          }
          count++;
        });
        $('#cateItem').html(html);

        //栏目控制，加入点击事件
        var open = -1;
        $('.item-cate').bind('click', function() {
          var item = $(this).attr('item-data');
          $('.c-' + open).addClass('disn');
          $('.p-' + open).removeClass('bgefeeee');
          $('.p-' + open).find('.iconfont').html('&#xe648');
          $(this).addClass('bgefeeee');
          open = item;
          $('.c-' + item).removeClass('disn');
          $('.p-' + item).find('.iconfont').html('&#xe645;');
          loadProductList($(this),false);
        });
        //点击栏目，加载对应栏目商品列表
        $('.child-item').bind('click', function() {
          loadProductList($(this),false);
        });
      }
    });

    //加载对应栏目下的商品数据列表
    function loadProductList(obj,loading) {

      var cateid = obj.attr('data-catid');

      sessionStorage.removeItem("categories_info");
      var categoriesInfo = {};
      categoriesInfo.cateid = cateid;
      sessionStorage.setItem('categories_info', JSON.stringify(categoriesInfo));

      var siteid = JSON.parse(sessionStorage.getItem('site_info')).siteid;
      loading = false;
      pages = 1;
      var offset = 6;
      $('.infinite-scroll .list-container').html('');
      var max = productAddItems(offset, pages, cateid, siteid);
      loading = max > offset ? false : true;

      if (loading) {
        // 加载完毕，则注销无限加载事件，以防不必要的加载
        $.detachInfiniteScroll($('.infinite-scroll'));
        // 删除加载提示符
        //$('.infinite-scroll-preloader').remove();
        $(".preloader_null").removeClass("disn");
        $(".preloader").addClass("disn");
      }
      
    }


    /////////////////////////////////
    //---默认排序显示------------------- //
    /////////////////////////////////
    $(page).on('click','#product-default-sort',function(){
       
       var sortValue = $(this).data('value') || '1';
         if(sortValue==1){
            sessionStorage.setItem('sortKey','id');
            sessionStorage.setItem('sortValue','DESC');
            $(this).data('value',2)
         }else{
            sessionStorage.setItem('sortKey','id');
            sessionStorage.setItem('sortValue','ASC');
            $(this).data('value',1)
         }

     claerData();
    
    })

    //////////////////////////////////////
    //---销售量排序显示----------------------- //
    //////////////////////////////////////
    $(page).on('click','#product-sales-sort',function(){

       var sortValue = $(this).data('value') || '1';
         if(sortValue==1){
            sessionStorage.setItem('sortKey','sales');
            sessionStorage.setItem('sortValue','DESC');
            $(this).data('value',2)
         }else{
            sessionStorage.setItem('sortKey','sales');
            sessionStorage.setItem('sortValue','ASC');
            $(this).data('value',1)
         }
        
       claerData();
    })
    ////////////////////////////////////
    //------销售价格排序显示----------------- //
    ////////////////////////////////////
    $(page).on('click','#product-prices-sort',function(){

         var sortValue = $(this).data('value') || '1';
         if(sortValue==1){
            sessionStorage.setItem('sortKey','sale_price');
            sessionStorage.setItem('sortValue','DESC');
            $(this).data('value',2)
         }else{
            sessionStorage.setItem('sortKey','sale_price');
            sessionStorage.setItem('sortValue','ASC');
            $(this).data('value',1)
         }
         
        claerData();
    })

    ////////////////////////////////////////////
    //---------------清楚之前加载的数据--------------- //
    ////////////////////////////////////////////
    ///
    function claerData(){
      //显示加载提示图片
      $(".preloader_null").addClass("disn");

      $(".preloader").removeClass("disn");
      
      $('.infinite-scroll .list-container').html('');
      $('.infinite-scroll .list-container').scrollTop(0);
    
      
       setTimeout(function(){
        
        //载入产品列表
        var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
        var loading = false;
        pages = 1;
        var offset = 6;
        var cateid = isEmpty(getRrlParam('cateid')) ? '0' : getRrlParam('cateid');

        cateid = sessionStorage.getItem('categories_info') != null ? JSON.parse(sessionStorage.getItem('categories_info')).cateid : cateid;
        sessionStorage.removeItem("categories_info");
        var categoriesInfo = {};
        categoriesInfo.cateid = cateid;
        sessionStorage.setItem('categories_info', JSON.stringify(categoriesInfo));
        var max = productAddItems(offset, pages, cateid, siteid);
        loading = max > offset ? false : true;


        if (loading) {
          // 加载完毕，则注销无限加载事件，以防不必要的加载
          $.detachInfiniteScroll($('.infinite-scroll'));
          // 删除加载提示符

          $(".preloader_null").removeClass("disn");
          $(".preloader").addClass("disn");
        }
        //图片懒加载
        $('.product-list-thumb').picLazyLoad({
          threshold: 0,
          placeholder: '/sources/images/defaultpic.gif'
        });
       
      },500)
    }

    //帅选弹出框
    $(page).on('click', '#product-filter', function() {
      $.openPanel("#product-filter-popup");
    })

  });


});