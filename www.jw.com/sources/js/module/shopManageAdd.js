/*
* @Author: shaobo
* @Date:   2016-01-01 21:35:07
* @Last Modified by:   anchen
* @Last Modified time: 2016-04-08 23:44:39
*/
$(function(){


        $(document).on('pageInit', '#popup-page-product-import', function(e, id, page) {
                       //点击进入导入页面
    
              var catid = 0;
              //赋值到popup页面的导入按钮dom的属性data-id
              $('.popup-product-import #finish-add-goods-but').attr('data-id',catid)


             //商品列表
                var siteid = 1;
                var loading = false;
                var pages = 1;
                var offset = 6;
                var orderby = 1;
                var catid =  0;
                var max = addItems(offset, pages, orderby ,catid,siteid);


                /**
                * 下拉列表
                * @param
                */
                $(document).on('infinite','#popup-page-product-import', function() {
                // 如果正在加载，则退出
               
                    var siteid = 1;
                    if (loading) return false;
                    loading = true;
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
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            // 删除加载提示符
                            $('.infinite-scroll-preloader').remove();
                            $(".preloader_null").removeClass("disn");
                            $(".preloader").addClass("disn");
                            return false;
                    }
                });

                // var html = '';
                // html += '<div class="  panel-reveal bgf4 c333" id="panel-shop-product-list-cate">';
                // html += '<div class="padl15 c333" style="height:2.2rem; line-height:2.2rem;text-align:center; ">商品分类</div>';
                // html += '<div class="list-block" >';
                // html += '<ul  id="cateItem">';
                // html += '</ul>';
                // html += '</div>';
                // html += '</div>';

                // $('#popup-product-import').append(html);

                // $.popup('#popup-product-import');


              
            // });
            // 
           
      
    


            $(page).on("click",".select-but",function(){

                if($(this).attr('data-is-selected') == "false"){
                    $(this).attr('data-is-selected',true);
                    $(this).html('&#xe628;');
                }else{
                    $(this).attr('data-is-selected',false);
                    $(this).html('&#xe61c;');
                }
            });

       
            $(page).on("click",".select-all-but",function(){
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


            $(page).on("click",".random-select-but",function(){
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


               $(page).on("click",".shop-product-list-cate",function(){

                 var cateInfo = getPlatFormCate();
                if(!$.isEmptyObject(cateInfo)){
                      var html = '';
                      html += '<li class="item-content item-cate" data-catid="0" style="min-height: 1.2rem;">';
                      html += '<div class="item-inner c666 borb1 bceee" style="min-height: 1.2rem;">';
                      html += '<div class="item-title fs06 c666">全部商品</div>';
                      html += '<div class="item-after"><i class="icon iconfont mar0 c666 flr fs05 arrowr disi">&#xe648</i></div>';
                      html += '</div>';
                      html += '</li>';
                      $.each(cateInfo,function(index, el){
                        html +='<li class="item-content item-cate" data-catid="'+el.catid+'" style="min-height: 1.2rem;">';
                        html += '<div class="item-inner c666 borb1 bceee" style="min-height: 1.2rem;">';
                        html += '<div class="item-title fs06 c666">'+el.catname+'</div>';
                        html += '<div class="item-after"><i class="icon iconfont mar0 c666 flr fs05 arrowr disi">&#xe648;</i></div>';
                        html += '</div>';
                        html += '</li>';
                    });
                    $('#cateItem').html(html);

                    $('.item-cate').bind("click", function(){
                        var cateid = $(this).attr('data-catid');
                        sessionStorage.setItem('panel-categories-catid',cateid);
                        var siteid = 1;
                        var loading = false;
                        var pages = 1;
                        var offset = 8;
                        var orderby = 1;
                         $('.page-current #list-container').html('');
                        var max = addItems(offset, pages, orderby ,cateid ,siteid);
                    });
                }

                   $.openPanel("#panel-shop-product-list-cate");

               })

            
                //导入按钮
               $(page).on("click","#finish-add-goods-but",function(){
                   var importPro = $.parseJSON(sessionStorage.getItem('select_product'));
                   
                   //importPro = importPro != null ?importPro : {};
                   var catid = $(this).attr('data-id');
                   //var productIds = '';
                   var isSelect = false;
                   var shop_import_goods_data = $.parseJSON(sessionStorage.getItem('shop_import_goods_data'));
                   $.each($('.select-but'),function(){
                        if($(this).attr('data-is-selected') == 'true'){
                            //productIds += $(this).attr('data-cate-id')+',';
                            shop_import_goods_data[catid][$(this).attr('data-cate-id')] =  $(this).attr('data-cate-id');
                            isSelect = true;
                        }
                   });

                  // return false;

                   if(isSelect){
                        isSelect = false;
                        var shop_import_goods_number = 0;
                        $.each(shop_import_goods_data,function(catid,item){
                            var catid_numbers = Object.keys(item).length;
                            $("#page-manage-add-goods .badge_"+catid+"").html(catid_numbers);
                            shop_import_goods_number +=catid_numbers;
                        });
                        $.toast('导入成功！');
                        
                        $('#pro_number').html(shop_import_goods_number);
                   }else{
                      $.toast('至少选择一款商品！');
                   }
                   
                   // importPro[catid] = productIds;
                  sessionStorage.setItem('shop_import_goods_data',JSON.stringify(shop_import_goods_data));
                   

               })
             
             $(page).on("click",".sumTotal",function(){
                  // var product =  sessionStorage.getItem('select_product');
                  // // 如果导入产品不为空
                  // if(!isEmpty(product)){
                  //     var productData = JSON.parse(product)
                  //     var sum = 0;
                  //      $.each(productData , function( i, item){
                  //          var productCount =  item.split(",");
                  //         $("#page-manage-add-goods .badge_"+i+"").html(productCount.length);
                  //         sum += productCount.length;
                  //      })
                  //        $("#pro_number").html(sum);
                  // }
              })

/**
 * 
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
           data: {m:'shop',c:'index',a:'shoplists',page:pages,offset:offset,order:order,catid:catid,siteid:siteid,sysadd:1,is_up:99},
           dataType: "json",
           headers: {"Token":sso_Token},
           success: function(result){
              var data = result;
              max = data['total'];
              var list = data.data;
              var html = '';
              // var shop_import_goods_data = sessionStorage.getItem('shop_import_goods_data');
              //     shop_import_goods_data = JSON.parse(shop_import_goods_data);
              // var fromcatid = getRrlParam('fromcatid');
              // var shop_import_goods_catid_data = shop_import_goods_data[fromcatid] || [];

              $.each(list, function(i, item){
                  var goodsid = item.id;
                  var is_selected = 'false';
                  var select_but_icon = '&#xe61c;';
                  // if(in_array(goodsid,shop_import_goods_catid_data)){
                  //   is_selected = 'true';
                  //   select_but_icon = ('&#xe63e;');
                  //   //console.log(goodsid);
                  // }
                  html += '<div class="pad10 bgfff borb1 bce6">';
                  html += '<div class="fll select-but iconfont mar0 checked cCB1408 marr20 padt30" data-cate-id="'+item.id+'" data-is-selected="'+is_selected+'">'+select_but_icon+'</div>';
                  html += '<div class="w80 fll">';
                  html += '<a class="c666 external" href="#" data-id="'+item.id+'">';
                  html += '<img class="w80 pos-r" style="top:50%;" src="'+item.thumb+'" alt=""></a>';
                  html += '</div>';
                  html += '<a class="c999 external" href="#" data-id="'+item.id+'">';
                  html += '<div class="w60b fs06 fll padl10 padr0">';
                  html += '<a class="c666 external" href="#" data-id="'+item.id+'">';
                  html += '<div style="min-height:36px;">'+cutString(item.title,40)+'</div></a>';
                  html += '<div class="c999">商品等级:'+item.level+'</div>';
                  //html += '<div class="c999"> 销量：'+item.sales+' </div>';
                  html += '<div class="fs09 cfa6a0b"><span class="fs06">&yen;</span>'+item.sale_price+'</div>';
                  html += '</div></a>';
                  html += '<div class="w20b flr" style="padding-top:20px;"><a class="c666 external" href="#" data-id="'+item.id+'">';
                  html += '</a></div>';
                  html += '<div class="clear"></div>';
                  html += '</div>';

                  // html += '<li>';
                  // html += '<div class="item-content">';
                  // html += '<div class="item-inner">';
                  // html += '<div class="select-but w10b h80 lh80 iconfont mar0 cCB1408" data-is-selected="false">&#xe642;</div>';
                  // html += '<div class="w21b"><img src="'+item.thumb+'" class="w60 h60"></div>';
                  // html += '<div class="w69b fs08">'+cutString(item.title,40)+'</div>';
                  // html += '</div>';
                  // html += '</div>';
                  // html += '<i class="icon iconfont fs09  mar0">&#xe640;</i>';
                  // html += '</li>';
                });
                //alert()
                // $.alert(html)
              $('.page-current #list-container').append(html);
              $('.infinite-scroll-preloader').remove();

            }
        });
    return max;
    }
// addItem end
// 
// 
          })



$(document).on('pageInit', '#page-manage-add-goods', function(e, id, page) {
          var proCount = 0;
          var category = '';
          var url = encodeURI(apiUrl + 'shop/index/getShopCate');
          $.ajax({
              url: url,
              async: false,
              type: 'GET',
              data: {
                  module:'site',
              },
              headers: {
                  "Token": sso_Token
              },
              success: function(result) {
                  var data = $.parseJSON(result);
                  var shop_import_goods_data = 
                                                sessionStorage.getItem('shop_import_goods_data') 
                                                ?
                                                $.parseJSON(sessionStorage.getItem('shop_import_goods_data')) 
                                                : 
                                                {};

                  $.each(data, function(catid, cat) {
                      if(cat.parentid == 0){
                        if (cat.child == 0) {
                            category += '<a class="open-popup-product-import" href="#popup-page-product-import" data-id="'+catid+'">';
                        }else{
                            category += '<a href="javascript:void(0);" class="external">'; 
                        } 
                          var catitems = 0;
                          if(Object.keys(shop_import_goods_data).length == 0){
                            shop_import_goods_data[cat.catid] = {};
                          }else{
                            catitems = Object.keys(shop_import_goods_data[catid]).length
                          }
                          var numHtml = cat.child == 0 ? '<span class="badge_'+catid+'">'+catitems+'</span>' : '';
                          category += '<li class="item-content">';
                          category += '<div class="item-media">';
                          category += '<i class="icon icon-right"></i></div>';
                          category += '<div class="item-inner">';
                          category += '<div class="_catename item-title">' + cat.catname + '</div>';
                          if(cat.child == 0){
                            category += '<div class="item-after">' + numHtml + '</div>';
                          }
                          
                          
                          category += '</div>';
                          category += '</li>';
                          category += '</a>';
                          var parid = cat.arrchildid.split(",");//字符串转换成数组

                          cateid = parid.splice(0,1);//删除父类id
                        
                          if(parid){
                             
                              $.each(parid, function(index, value) {
                                  shop_import_goods_data[cat.catid] = {};
                                  var catitems = 0;
                                  if(Object.keys(shop_import_goods_data).length == 0){
                                    shop_import_goods_data[cat.catid] = {};
                                  }else{
                                    catitems = Object.keys(shop_import_goods_data[catid]).length
                                  }
                                  var numHtml = cat.child == 0 ? '<span class="badge_'+catid+'">'+catitems+'</span>' : '';


                                  category += '<a class="open-popup-product-import" data-id="'+cat.catid+'">';
                                  category += '<li class="item-content">';
                                  category += '<div class="item-media">';
                                  category += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
                                  category += '<div class="item-inner">';
                                  category += '<div class="_catename item-title">' + cat.catname + '</div>';
                                  category += '<div class="item-after">' + numHtml + '</div>';
                                  //proCount = proCount + catitems.length;
                                  category += '</div>';
                                  category += '</li>';
                                  category += '</a>';
                              })
                              
                          }
                          
                      } 
                  })
                  sessionStorage.setItem('shop_import_goods_data',JSON.stringify(shop_import_goods_data));
                  $('#cate-list-block').html(category);
                  $('.page-current #pro_number').html('0');
              }
          })

              $(page).on('click','.open-popup-product-import',function(){
           
             
              var catid = $(this).attr('data-id');
             $('#finish-add-goods-but').attr('data-id',catid)
           })

            //点击添加商品
            $(page).on('click', '#open-shop', function() {
                var product_info = sessionStorage.getItem('shop_import_goods_data');
                product_info = JSON.parse(product_info);

                //product_info = JSON.parse(product_info);
                var countItems = 0;
                $.each(product_info, function(i, item) {
                    countItems += Object.keys(item).length;
                })

                 if (countItems < 1) {
                     $.toast('您没有新增店铺商品');
                     return;
                 }

                 console.log(product_info);
                return;
                var url = encodeURI(apiUrl + 'shop/index/addShopProduct');
                $.ajax({
                    url: url,
                    async: false,
                    type: 'POST',
                    data: {
                        product_info: product_info
                    },
                    headers: {
                        "Token": sso_Token
                    },
                    success: function(result) {
                        var data = $.parseJSON(result);
                        if (data['code'] == 0) {
                            $.toast('您已确认!');
                            $.router.loadPage("shop_product_manage.php?fromid=1");
                        } else {
                            $.toast('确认失败!');
                            return false;
                        }

                    }
                });
            })
        })


    /**
     * 返回产品栏目列表
     */
    function getPlatFormCate(){
        //显示栏目列表
        var proCount = 0;
        var category = {};
        var url = encodeURI(apiUrl + 'shop/index/getCate');
        $.ajax({
            url: url,
            async: false,
            type: 'GET',
            data: {
                module:'system',
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = $.parseJSON(result);
                 category = data;
            }
        })
        return category;
    }
    
})