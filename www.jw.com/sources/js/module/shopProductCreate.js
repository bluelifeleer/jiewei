/*
 * @Author: seaven
 * @Date:   2016-01-01 21:35:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-24 12:20:20
 */

$(function() {
    'use strict';

    function verify(obj){ // 值允许输入一个小数点和数字
  
      obj.value = obj.value.replace(/[^\d.]/g,""); //先把非数字的都替换掉，除了数字和.
      obj.value = obj.value.replace(/^\./g,""); //必须保证第一个为数字而不是.
      obj.value = obj.value.replace(/\.{2,}/g,"."); //保证只有出现一个.而没有多个.
      obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); //保证.只出现一次，value而不能出现两次以上
      return obj.value;
    } 

    $(document).on('pageInit', "#page-product-create", function(e, pageid, page) {

        /////////////////////////
        //-=----编辑赋值---------- //
        /////////////////////////
        //begin-------判断请求id
        var id = getRrlParam('id');
        if (!isEmpty(id)) {

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
                 $("#page-product-create .input-product-id").val(data.id);
                 $("#page-product-create .input-product-sn").val(data.product_sn);
                 $("#page-product-create .input-product-title").val(data.title);
                 $("#page-product-create .input-product-short-desc").val(data.short_desc);
                 $("#page-product-create .input-product-keywords").val(data.keywords);
                 $("#page-product-create .input-product-sale-price").val(data.sale_price);
                 $("#page-product-create .input-product-stock").val(data.stock);
                 $("#page-product-create .input-product-thumb").val(data.thumb.replace('_200_200',''));
                 $("#page-product-create  .input-product-thumb-img").attr('src',data.thumb);

                 $('.page-current .input-product-transit-type').val(data.transit_type);
                 $('.page-current .input-product-transit-cost').val(data.transit_cost);
             
                 var arr = Object.keys(data.pictures); //图片个数
                 var pic = data.pictures; //图片数据

                 for (var i = 0; i < arr.length; i++) {
                    var n = i+1;
                    $("#page-product-create  .input-product-pictures-"+n).val(pic[i].replace('_400_400',''));
                    $("#page-product-create  #input-product-pic-"+n).attr('src',pic[i]);
                 }
                 $("#page-product-create .input-product-made").val(data.made);

                  if(data.is_up == 1){
                      $("#page-product-create .input-product-is-up").attr('checked',data.is_up);
                 }

                 if(data.is_hot == 1){
                     $("#page-product-create .input-product-is-hot").attr('checked',data.is_hot);
                 }
                 if(data.is_real == 1){
                      $("#page-product-create .input-product-is-real").attr('checked',data.is_real);
                 }
                
                 if(data.is_explosion == 1){
                      $("#page-product-create .input-product-is-explosion").attr('checked',data.is_explosion);
                 }
                  if(data.is_overseas == 1){
                      $("#page-product-create .input-product-is-overseas").attr('checked',data.is_overseas);
                 }
                 if(data.is_recommend == 1){
                      $("#page-product-create .input-is-recommend").attr('checked',data.is_recommend);
                 }


                 $('.page-current  .shop-product-detail').removeClass('disn').attr('href','shop_product_detail.php?id='+data.id);
                 


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
                   $('#page-product-create .input-select-product-cate').html(html);
                 }

               }
           })

        }else{
            /////////////////////////
            //------产品栏目---------- //
            /////////////////////////
            var siteid = $.parseJSON(sessionStorage.getItem('user_info')).userid;
            var cateInfo = getCategoty(siteid);
            if(!$.isEmptyObject(cateInfo)){
              var html = '';
              $.each(cateInfo,function(index, el){
                
                html += ' <option value="'+el.catid+'">'+el.catname+'</option>';
               
              });
              $('#page-product-create .input-select-product-cate').html(html);
            }
        }


        uploadImg('thumb','#uploaderThumb','#input-product-thumb-img','.page-current .input-product-thumb','200','200');

        uploadImg('pictures','#uploaderPic-1','#input-product-pic-1','.page-current .input-product-pictures-1','64','64');
        uploadImg('pictures','#uploaderPic-2','#input-product-pic-2','.page-current .input-product-pictures-2','64','64');
        uploadImg('pictures','#uploaderPic-3','#input-product-pic-3','.page-current .input-product-pictures-3','64','64');
        uploadImg('pictures','#uploaderPic-4','#input-product-pic-4','.page-current .input-product-pictures-4','64','64');
        uploadImg('pictures','#uploaderPic-5','#input-product-pic-5','.page-current .input-product-pictures-5','64','64');


        /////////////////////////////
        //----------上传图片---------- //
        /////////////////////////////
        function uploadImg(thumb,uploader,thumbImg,value,width,height) {
          var currDate = new Date();
          var uploader1 = WebUploader.create({
            auto: true,
            swf: 'http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png',
            server: 'http://res.zj3w.net/upload.php?root=product/'+thumb+'/'+currDate.getFullYear()+'/'+currDate.getMonth()+'/'+currDate.getDate()+'/',
            pick: uploader,
            resize: false
          });

        $(uploader).find('.webuploader-pick').css({'width':width+'px','height':height+'px'});

          uploader1.on('fileQueued', function(file) {

            $(thumbImg).attr('src',imgUrl + 'loading.gif');
            this.upload();


            this.on('uploadSuccess', function(file, response) {
              $(thumbImg).attr('src',response.thumb);
              $(value).val(response.thumb);
            });

            this.on( 'uploadError', function( file ) {
                  $error.text('上传失败');
              });
          });

        }

    	///////////////////////////
        //------提交表单-=---------- //
        ///////////////////////////
        $(page).on('click','.input-product-submit',function(){
            var isSubmit = true;

            
            

        	var id = $('.page-current .input-product-id').val();//id
            var product_sn = $('.page-current .input-product-sn').val();//货号
            if(product_sn == '') {
                $.toast('货号不能为空！');
                isSubmit = false;
                return ;
            }
            if(product_sn.length > 8){
                $.toast('货号不能超过８个字符！');
                isSubmit = false;
                return ;
            }
            var title = $('.page-current .input-product-title').val();//标题
            if(title == '') {
                $.toast('标题不能为空！');
                isSubmit = false;
                return ;
            }
            if(title.length > 16){
                $.toast('标题不能超过16个字符！');
                isSubmit = false;
                return ;
            }
            var short_desc = $('.page-current .input-product-short-desc').val();//描述
            if(short_desc == '') {
                $.toast('描述不能为空！');
                isSubmit = false;
                return ;
            }
            if(short_desc.length > 200){
                $.toast('描述不能超过200个字！');
                isSubmit = false;
                return ;
            }
            var keywords = $('.page-current .input-product-keywords').val();//关键字
            if(keywords == ''){
                $.toast('关键字不能为空！');
                isSubmit = false;
                return ;
            }
            if(keywords.length > 16){
                $.toast('关键字不能超过16个字！');
                isSubmit = false;
                return ;
            }
            //var sale_price = $('.page-current .input-product-sale-price').val();//价格
            var sale_price = verify($('.page-current .input-product-sale-price')[0]);
            if(sale_price == '') {
                $.toast('产品价格不能为空,请填写正确的格式。');
                isSubmit = false;
                return ;
            }
            if(sale_price.length > 9990000) {
                $.toast('价格不能超过9990000元！');
                isSubmit = false;
                return ;
            } 
            var stock = $('.page-current .input-product-stock').val();//库存
            if(stock == '') {
                $.toast('库存不能为空！');
                isSubmit = false;
                return ;
            }
            if(stock > 10000) {
                $.toast('库存不能大于10000件！');
                isSubmit = false;
                return ;
            } 
            var thumb = $('.page-current .input-product-thumb').val();//封面
             if(thumb == '') {
                $.toast('封面不能为空！');
                isSubmit = false;
                return ;
            } 
          
            //获取图组
            var pic = new Object();
            $.each($('.input-product-pic'),function(i,v){
                if($(this).val() != ""){
                    pic[i] = $(this).val();
                }
            });

            if(JSON.stringify(pic) == "{}"){
                $.toast('图组至少上传一张图片，请选择图片！');
                isSubmit = false;
                return ;
            } 
            var pictures = pic;
         

            var catid = $('.page-current .input-select-product-cate').val(); //栏目
            var made = $('.page-current .input-product-made').val();//产地
            if(made == '') {
                $.toast('产地不能为空！');
                isSubmit = false;
                return ;
            }
            //var transit_cost = $('.page-current .input-product-transit-cost').val();
            //var obj = $('.page-current .input-product-transit-cost');
            var transit_cost = verify($('.page-current .input-product-transit-cost')[0]);
            if(transit_cost == '') {
                $.toast('物流费用不能为空,请填写正确的格式。');
                isSubmit = false;
                return ;
            } 
            var transit_type = $('.page-current .input-product-transit-type').val();
            if(transit_type == '') {
                $.toast('物流方式不能为空！');
                isSubmit = false;
                return ;
            } 

            
            //上架 
            if ($(".page-current .input-product-is-up").is(':checked')) {
                var is_up = 99;
            } else {
                var is_up = 1;
            }
            //热销
            if ($(".page-current .input-product-is-hot").is(':checked')) {
                var is_hot = 1;
            } else {
                var is_hot = 99;
            }
            //是否虚拟产品
            if ($(".page-current .input-product-is-real").is(':checked')) {
                var is_real = 1;
            } else {
                var is_real = 99;
            }
            //爆款
            if ($(".page-current .input-product-is-explosion").is(':checked')) {
                var is_explosion = 1;
            } else {
                var is_explosion = 99;
            }
            //进口
            if ($(".page-current .input-product-is-overseas").is(':checked')) {
                var is_overseas = 1;
            } else {
                var is_overseas = 99;
            }
            //推荐
            if ($(".page-current .input-product-is-recommend").is(':checked')) {
                var is_recommend = 1;
            } else {
                var is_recommend = 99;
            }

            if(isEmpty(id)){
                var url = encodeURI(apiUrl + 'product/index/createProduct');
                var msg = '创建成功！点击详情添加详细信息';
                var errormsg = '创建失败！';
            }else{
                var url = encodeURI(apiUrl + 'product/index/ModifiedProduct');
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
                    id: id,
                    product_sn: product_sn,
                    title: title,
                    catid: catid,
                    short_desc: short_desc,
                    keywords:keywords,
                    sale_price: sale_price,
                    transit_type: transit_type,
                    transit_cost: transit_cost,
                    stock:stock,
                    thumb:thumb,
                    pictures:pictures,
                    made:made,
                    is_up:is_up,
                    is_real:is_real,
                    is_explosion:is_explosion,
                    is_overseas:is_overseas,
                    is_hot:is_hot,
                    is_recommend:is_recommend
                },
                headers: {
                    "Token": sso_Token
                },
                success: function(result) {
                    var data =result;

                    if (data.code == 200) {
                      var toid = data.id || id;
                      location.href = 'shop_product_detail.php?id='+toid; 
                      // $.router.loadPage('shop_product_detail.php?id='+data.id, true);
                      $('.page-current  .shop-product-detail').removeClass('disn').attr('href','shop_product_detail.php?id='+data.id);
                        $.toast(msg);
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