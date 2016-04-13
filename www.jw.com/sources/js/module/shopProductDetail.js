/*
 * @Author: seaven
 * @Date:   2016-01-01 21:35:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-13 18:31:48
 */

$(function() {
    'use strict';

   
    $(document).on('pageInit', "#page-shop-product-add-detail", function(e, id, page) {

        var ImgDeatail = '';

    	 //begin-------判断请求id
        var id = getRrlParam('id');

        $('.page-current .pull-left').attr('href','shop_product_create.php?id='+id);

        //begin-----ajax获取产品信息
        $.ajax({
            url: apiUrl + 'product/index/getProductDetail',
            type: 'GET',
            async: false,
            data: {
                pro_id: id
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = JSON.parse(result);
                //判断数据是否为空
                if (!$.isEmptyObject(data)) {
                	$('.page-current .input-product-id').val(data.id);
                    editor.setValue(data.content);
                	
                	$.each(JSON.parse(data.params),function(key,item){
                			var html = '';
                			html += '<li>'
                		    html += '<div class="item-content">';
                		    html += '<div class="item-inner">';
                		    html += '<div class="item-title label w20b fs07">';
                		    html += '<input type="text" class="input-product-paramName" value="'+key+'" style="font-size: 0.75rem;color: #999;border:1px #ccc solid;" >';
                		    html += '</div>';
                		    html += '<div class="item-input w70b">';
                		    html += '<input type="text" class="input-product-paramValue" value="'+item+'" style="font-size: 0.75rem;color: #999;border:1px #ccc solid;" >';
                		    html += '</div>';
                		    html += '<div class="item-input w10b delete-product-params">';
                		    html += '<i class="icon iconfont mar0 c666"> &#xe61a; </i>';
                		    html += ' </div>';
                		    html += '</div>';
                		    html += '</div>';
                		    html += '</li>';
                		    $('.page-current .product-params-list').append(html);
                	})
                }
            }
        });

          

        uploadImg('detail','#uploaderDetail','#input-product-detail-img','.page-current .detail-img-List','120','30');


        /////////////////////////////
        //----------上传图片---------- //
        /////////////////////////////
        function uploadImg(thumb,uploader,thumbImg,value,width,height) {

        var currDate = new Date();
        var uploader2 = WebUploader.create({
          auto: true,
          swf: 'http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png',
          server: 'http://res.zj3w.net/upload.php?root=product/detail/'+currDate.getFullYear()+'/'+currDate.getMonth()+'/'+currDate.getDate()+'/',
          pick: '#uploaderDetail',
          resize: false
        });

          
        $(uploader).find('.webuploader-pick').css({'width':width+'px','height':height+'px'});


          uploader2.upload();

          uploader2.on( 'uploadSuccess', function( file ,response) {
             ImgDeatail += '<img src="'+response.thumb+'" width="100%" />';
              var html = '';
              html += '<img class="input-product-detail-img"  src="'+response.thumb+'" width="100%"  style="border:1px #ccc solid;">';
              $(value).append(html);
          });

          uploader2.on( 'uploadError', function( file ) {
                $error.text('上传失败');
            });

        }


        $(page).on('click','#add-product-params',function(){
        	var html = '';
        	html += '<li>'
            html += '<div class="item-content">';
            html += '<div class="item-inner">';
            html += '<div class="item-title label w20b fs07">';
            html += '<input type="text" class="input-product-paramName" style="font-size: 0.75rem;color: #999;border:1px #ccc solid;"  placeholder="如：颜色">';
            html += '</div>';
            html += '<div class="item-input w70b">';
            html += '<input type="text" class="input-product-paramValue" style="font-size: 0.75rem;color: #999;border:1px #ccc solid;"  placeholder="如：红色,白色">';
            html += '</div>';
            html += '<div class="item-input w10b delete-product-params">';
            html += '<i class="icon iconfont mar0 c666"> &#xe61a; </i>';
            html += ' </div>';
            html += '</div>';
            html += '</div>';
            html += '</li>';

            $('.page-current .product-params-list').append(html);
        });

        $(page).on('click','.delete-product-params',function(){
        	$(this).parent().parent().remove();
        })


        $(page).on('click','.submit-product-detail',function(){
        	 var params = '{';
        	 var hasParams = false;
        	 var isSubmit = true;

        	 if($('.page-current .input-product-paramName').length>0){
        	 	$('.page-current .input-product-paramName').each(function(index){
        	 		if($(this).val() != '' && $('.page-current .input-product-paramValue').eq(index).val() != '') {
        	 			var paramName = $(this).val();
	        	 		var paramValue = $('.page-current .input-product-paramValue').eq(index).val();
	        	 		params = params+'"'+paramName + '":'+'"'+paramValue+'",';
	        	 		hasParams = true;
        	 		}else{
        	 			isSubmit = false;
        	 			$.toast('属性名或属性值不能为空');
        	 		}
        	 	});
        	 	if(hasParams) params = params.substring(0,params.length-1);
        	 	
        	 }

        	  params += '}';
        	  var content = editor.getValue() + '<br/>'+ImgDeatail;
        	 
        	  var pro_id = getRrlParam('id');

        	  var detailId = $('.page-current .input-product-id').val();;

        	  if(isEmpty(detailId)){
        	  	var url = encodeURI(apiUrl + 'product/index/createProductDetail');
        	  	var msg = '创建成功！';
        	  	var errormsg = '创建失败！';
        	  }else{
        	  	var url = encodeURI(apiUrl + 'product/index/updateProductDetail');
        	  	var msg = '更新成功！';
        	  	var errormsg = '更新失败！';
        	  }

        	  if(isSubmit){
        	  	$.ajax({
        	  	    url: url,
        	  	    async: false,
        	  	    type: 'POST',
        	  	    dataType: "json",
        	  	    data: {
        	  	        id: detailId,
        	  	        pro_id: pro_id,
        	  	        params: params,
        	  	        content:content
        	  	    },
        	  	    headers: {
        	  	        "Token": sso_Token
        	  	    },
        	  	    success: function(result) {
        	  	        var data =result;
        	  	        if (data.code == 200) {
        	  	            $.toast(msg);
                            $.router.loadPage('shop_product_classify.php',true);
        	  	        } else {
        	  	            $.toast(errormsg);
        	  	            return false;
        	  	        }
        	  	    }

        	  	});
        	  }

        })
    })

});