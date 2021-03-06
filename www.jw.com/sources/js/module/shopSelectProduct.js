$(function(){
  'use strict';
  var max = 0;
  var loading = false;
  var pages = 1;
  $(document).on('open','.panel-categories',function(e,id,page){
    //产品栏目
    var cateInfo = getCategoty(1);
    if(!$.isEmptyObject(cateInfo)){
      var html = '';
      html += '<li class="item-content item-cate" data-catid="0" style="min-height: 1.2rem;">';

      html += '<div class="item-inner c666 borb1 bceee" style="min-height: 1.2rem;">';
      html += '<div class="item-title fs06 c666">全部商品</div>';
 
      html += '</div>';
      html += '</li>';
      $.each(cateInfo,function(index, el){
        html +='<li class="item-content item-cate" data-catid="'+el.catid+'" style="min-height: 1.2rem;">';
        html += '<div class="item-inner c666 borb1 bceee" style="min-height: 1.2rem;">';
        html += '<div class="item-title fs06 c666">'+el.catname+'</div>';
        html += '</div>';
        html += '</li>';
      });
      $('#cateItem').html(html);

      $('.item-cate').bind("click", function(){
          var cateid = $(this).attr('data-catid');
        
           sessionStorage.setItem('panel-categories-catid',cateid);

          var siteid =  1;
          loading = false;
          pages = 1;
          var offset = 8;
          var orderby = 1;
          $('.infinite-scroll .list-container').html('');
           max = addItems(offset, pages, orderby ,cateid ,siteid);
           loading = max > offset ? false : true;
           console.log(max+'------'+offset);
           if (loading) {
             // 加载完毕，则注销无限加载事件，以防不必要的加载
             //$.detachInfiniteScroll($('.infinite-scroll'));
             // 删除加载提示符
             //$('.infinite-scroll-preloader').remove();
             $(".preloader_null").removeClass("disn");
             $(".preloader").addClass("disn");
           }
        });
    }
  });

  $(document).on('pageInit','#page-shop-select-product',function(e,id,page){
        //商品列表
      var siteid = 1;
      loading = false;
      pages = 1;
      var offset = 8;
      var orderby = 1;
      var catid =  0;
      max = addItems(offset, pages, orderby ,catid,siteid);

      loading = max > offset ? false : true;

      if (loading) {
        // 加载完毕，则注销无限加载事件，以防不必要的加载
        //$.detachInfiniteScroll($('.infinite-scroll'));
        // 删除加载提示符
        //$('.infinite-scroll-preloader').remove();
        $(".preloader_null").removeClass("disn");
        $(".preloader").addClass("disn");
      }
      

      /**
       * 下拉列表
       * @param
       */
      $(page).on('infinite', function() {
         // 如果正在加载，则退出
        var siteid = 1;
        console.log(loading);

        if (loading) return false;
          loading = true;
          console.log(pages * offset);
          console.log(max > (pages * offset));

        if (max > (pages * offset)) {
           // 更新页码
           pages++
           // 添加新条目
           var cateid = sessionStorage.getItem('panel-categories-catid');
           max = addItems(offset, pages, orderby,cateid,siteid);
           // 重置加载flag
           loading = false;
           // 容器发生改变,如果是js滚动，需要刷新滚动
           $.refreshScroller();
        }else{
           // 加载完毕，则注销无限加载事件，以防不必要的加载
           //$.detachInfiniteScroll($('.infinite-scroll'));
           // 删除加载提示符
           // $('.infinite-scroll-preloader').remove();
           $(".preloader_null").removeClass("disn");
           $(".preloader").addClass("disn");

           return false;
        }
      });

      $(page).on('click','.select-but',function(){
        if($(this).attr('data-is-selected') == "false"){
          $(this).attr('data-is-selected',true);
          $(this).html('&#xe628;');
        }else{
          $(this).attr('data-is-selected',false);
          $(this).html('&#xe61c;');
        }
      });

      $(page).on('click','.select-all-but',function(){
        if($(this).attr('data-is-selected') == "false"){
          $(this).attr('data-is-selected',true);
          $(this).html('全不选');
          $('.select-but').attr('data-is-selected',true);
          $('.select-but').html('&#xe628;');
        }else{
          $(this).attr('data-is-selected',false);
          $(this).html('全选');
          $('.select-but').attr('data-is-selected',false);
          $('.select-but').html('&#xe61c;');
        }
      });


      $(page).on('click','.random-select-but',function(){
        $('.select-all-but').html('全选');
        $('.select-all-but').attr('data-is-selected',false);
        $('.select-but').html('&#xe61c;');
        $('.select-but').attr('data-is-selected',false);
        for(var i=0; i<=30; i++){
          var index = parseInt(Math.random()*30);
          $('.select-but').eq(index).html('&#xe628;');
          $('.select-but').eq(index).attr('data-is-selected',true);
        }
      });


     // var seStor = sessionStorage();
      
      $(page).on('click','#finish-add-goods-but',function(){
        var catId = getRrlParam('fromcatid');
        var shop_import_goods = sessionStorage.getItem('shop_import_goods_data');  
            shop_import_goods = JSON.parse(shop_import_goods);
        var temp = [];
        $('.select-but').each(function(i){
          if($(this).attr('data-is-selected') == 'true'){
            temp.push($(this).attr('data-cate-id'));
          }
        });
        shop_import_goods[catId] = temp;
        
        var shop_import_goods_data = JSON.stringify(shop_import_goods);
       
        sessionStorage.setItem('shop_import_goods_data',shop_import_goods_data);  
        //$.router.back();
        $.router.loadPage('apply_shop_import_goods.php');
        
      });
  });
   /**
   * [getCategoty 获取栏目信息]
   * @method getCategoty
   * @return {[type]}    [description]
   */
  function getCategoty(){
    var data = {m:'shop',c:'index',a:'getCate'};
    var json = '';
    json = ajaxRequestProduct('GET',false,data);
    return json;
  }


  function ajaxRequestProduct(type, async, data) {
    var json = '';
    $.ajax({
        type: type,
        url: apiUrl,
        async: async,
        data: data,
        dataType: "json",
        headers: {"Token":sso_Token},
        success: function(result) {
            json = result;
        }
    });
    return json;
  }

 
    /**
    * 载入产品
    * @param {[offset]} number  分页数量
    * @param {[pages]} number 页码
    * @param {[order]} string 排序字段
    * @param {[catid]} number 栏目id
    */
    function addItems(offset, pages, order, catid, siteid) {
      var max = 0 ;
      var order = order || 0;
      var catid = catid || 0;
      $.ajax({
           type: "GET",
           url: apiUrl,
           async: false,
           data: {m:'product',c:'index',a:'lists',page:pages,offset:offset,order:order,catid:catid,siteid:siteid,sysadd:1,is_up:99},
           dataType: "json",
           headers: {"Token":sso_Token},
           success: function(result){
              var data = result;
              max = data['total'];
              var list = data.data;
              var html = '';
              var shop_import_goods_data = sessionStorage.getItem('shop_import_goods_data');
                  shop_import_goods_data = JSON.parse(shop_import_goods_data);
              var fromcatid = getRrlParam('fromcatid');    
              var shop_import_goods_catid_data = shop_import_goods_data[fromcatid] || [];
              $.each(list, function(i, item){
                  var goodsid = item.id;
                  var is_selected = 'false';
                  var select_but_icon = '&#xe61c;';
                  if(in_array(goodsid,shop_import_goods_catid_data)){
                    is_selected = 'true';
                    select_but_icon = ('&#xe628;');
                  }
                  html += '<div class="pad10 bgfff borb1 bce6  close-panel">';
                  html += '<div class="fll select-but iconfont mar0 checked cCB1408 marr15" data-cate-id="'+item.id+'" data-is-selected="'+is_selected+'">'+select_but_icon+'</div>';
                  html += '<div class="w80 fll">';

                  html += '<img class="w80 pos-r" style="top:50%;" src="'+item.thumb+'" alt="">';
                  html += '</div>';
                  html += '<div class="w50b fs06 fll padl10 padr0">';
                  html += '<a class="c666 external" href="product.php?id='+item.id+'" data-id="'+item.id+'">';
                  html += '<div style="min-height:36px;">'+cutString(item.title,40)+'</div></a>';
                  html += '<div class="c999">商品等级:'+item.level+'</div>';

                  html += '<div class="c999"> 销量：'+item.sales+' </div>';
                  html += '<div class="fs09 cfa6a0b"><span class="fs06">&yen;</span>'+item.sale_price+'</div>';
                  html += '</div></a>';
                 
                  html += '<div class="clear"></div>';
                  html += '</div>';

                  
                });
              $('.infinite-scroll .list-container').append(html);
             

              // $('.infinite-scroll-preloader').remove();
        }
      });
    return max;
    }
  
//
});