/*
* @Author: seaven
* @Date:   2016-01-01 21:35:07
* @Last Modified by:   anchen
* @Last Modified time: 2016-01-13 18:31:48
*/
$(function(){
    'use strict';
    $(document).on('pageInit',"#page-search",function(e,id,page){
       $(page).on('click','#search-btn', function () {

            var keywords = $('#search').val();

            if(!isEmpty(keywords)){

                var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid:'1';
                var pages = 0;
                var offset = 200;
                var orderby = 1;
                var cateid = 0;
                var max = search_add_Items(offset, pages, orderby,siteid,keywords);
            }else{
                 $.toast('请输入搜索关键字', 1000, 'error');
            }

        });
      

    });
});
/**
 * [getAdvert 获取商品广告信息]
 * @param  {[type]} id [用户id]
 * @return {[type]}    [description]
 */
function search_add_Items(offset, pages, orders,siteid,keywords) {
        var max = 0 ;
        var order = order || 0;
        var siteid = siteid || 1;
        $('.infinite-scroll .list-container').html('');
         $.ajax({
                type: "GET",
                url: apiUrl,
                async: false,
                data: {'m':'search','c':'index','a':'getSearchRes','page':pages,'offset':offset,'order':order,'siteid':siteid,'keywords':keywords},
                dataType: "json",
                headers: {"Token":sso_Token},
                success: function(result){
                      var data = result;
                      max = data['total'];
                      var list = data.data;
                      html = '';
                      $.each(list, function(i, item){
                          html += '<div class="pad10 bgfff borb1 bce6">';
                          html += '<a class="c999" data-no-cache="true" href="product.php?id='+item.id+'" data-id="'+item.id+'">';
                          html += '<div class="w80 fll">';
                          html += '<a class="c666" data-no-cache="true" href="product.php?id='+item.id+'" data-id="'+item.id+'">';
                          html += '<img class="w80 pos-r" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\';" style="top:50%;" src="'+item.thumb+'" alt=""></a>';
                          html += '</div><div class="w60b fs06 fll padl10 padr0">';
                          html += '<a class="c666 fs07" data-no-cache="true" href="product.php?id='+item.id+'" data-id="'+item.id+'">';
                          html += '<div style="min-height:36px;">'+cutString(item.title,80)+'</div></a>';
                          html += '<div class="c999 "> 销量：'+item.sales+' </div>';
                          html += '<div class="fs09  cfa6a0b"><span class="fs06">价格：&yen;</span>'+item.sale_price+'</div>';
                          html += '</div></a>';
                          html += '<div class="w10b flr" style="padding-top:20px;"><a class="c666" data-no-cache="true" href="product.php?id='+item.id+'" data-id="'+item.id+'">';
                          html += '<div class=" h40  txac borrad50 flr" style="line-height:35px;">';
                          html += '<i class="icon iconfont fs06 mar0 padr10">&#xe648;</i>';
                          html += '</div>';
                          html += '</a></div>';
                          html += '<div class="clear"></div>';
                          html += '</div>'; 
                       });
                      $('.infinite-scroll .list-container').append(html);
                    }
               });
}