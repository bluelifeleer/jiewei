/*
* @Author: seaven
* @Date:   2016-01-01 21:35:07
* @Last Modified by:   anchen
* @Last Modified time: 2016-01-13 18:31:48
*/
$(function() {
  'use strict';

  $(document).on('pageInit', '#page-shop-msg-list', function(e, id, page) {
  	
  	
  	$.ajax({
  	        type: "GET",
  	        url: apiUrl,
  	        async: false,
  	        data: {m:'message',c:'index',a:'lists',num:100,offset:1},
  	        dataType: "json",
  	        headers: {"Token":sso_Token},
  	        success: function(result){
  	        	//var data = JSON.parse(result);
  	        	var data = result.data;
  	        	$.each(data,function(key,value){
  	        		var html = '';
  	        		html += '<li>';
                    html += '<div class="item-link item-content">';
                    html += '<div class="item-inner">';
                    html += ' <div class="item-title-row">'
                    html += ' <div class="item-title">';
                    html += value.title;
                    html += '</div>';
                    html += '<div class="item-after">'+value.create_time+'</div>';
                    html += '</div>';
                    html += '<div class="item-text" style="height: 5.1rem;-webkit-line-clamp: 5;">'+value.contents+'</div>';
                    html += '</div>';
                    html += '</div>';
                    html +='</li>';
	                $('.page-current .shop-msg-list').append(html);
  	        	})
  	        	
  	        }
  	    });
  	

  })
});