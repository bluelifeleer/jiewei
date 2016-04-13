/*
* @Author: seaven
* @Date:   2015-12-31 18:47:17
* @Last Modified by:   anchen
* @Last Modified time: 2016-01-13 18:31:38
*/
$(function(){
    'use strict';
    $(document).on('pageInit','#product-categories',function(e,id,page){
      //产品栏目
      var siteid = JSON.parse(sessionStorage.getItem('site_info')).siteid;
      var cateInfo = getCategoty(siteid);
      if(!$.isEmptyObject(cateInfo)){
        var html = '';
        $.each(cateInfo,function(index, el){
          html += '<li>';
          html += '<a href="product_list.php?cateid='+el.catid+'" alt="'+el.catname+'" class="item-link item-content">';
          html += '<div class="item-inner">';
          html += '<div class="item-title">'+el.catname+'</div>';
          html += '<div class="item-after">';
          html += '<i class="icon iconfont mar0 c666 flr fs05 arrowr disi">&#xe648;</i>';
          html += '</div>';
          html += '</div>';
          html += '</a>';
          html += '</li>';
        });
        $('#categories-list').html(html);
      }
    });

    /**
     * [getCategoty 获取栏目信息]
     * @method getCategoty
     * @return {[type]}    [description]
     */
     function getCategoty(siteid){
       var data = {m:'product',c:'index',a:'getCate',siteid:siteid};
       var json = '';
       json = ajaxRequest('GET',false,data);
       return json;
     }

//
});
