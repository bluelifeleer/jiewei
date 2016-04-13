/*
 * @Author: seaven
 * @Date:   2016-03-02 21:35:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-12 21:02:10
 */
$(function() {
  'use strict';

  
   $(document).on('pageInit', '#page-shop-order-delivery', function(e, id, page) {

        var currDate = new Date();
        var year = currDate.getFullYear();
        var month = currDate.getMonth()>9?(currDate.getMonth()+1):'0' + (currDate.getMonth()+1).toString();
        var day = currDate.getDate()>9?currDate.getDate().toString():'0' + currDate.getDate();
        var hour = currDate.getHours();
        var minutes = currDate.getMinutes();

        $(".shipping_time").val(year+'-'+month+'-'+day+' '+hour+':'+minutes);

        $(".shipping_time").datetimePicker({
          dateFormat: 'yyyy-mm-dd',
          toolbarTemplate: '<header class="bar bar-nav">\
          <button class="button button-link pull-right close-picker">确定</button>\
          <h1 class="title">选择日期和时间</h1>\
          </header>'
        });
        $(page).on('click','.input-product-delivery-submit',function(){
            var url = encodeURI(apiUrl + 'shop/shopOrder/delivery');
            var goodsid = getRrlParam('pro_id');
            var orderid = getRrlParam('order_id');
            var shipping_name = $(".shipping_name").val();
            var shipping_no = $(".shipping_no").val();
            var shipping_time = $(".shipping_time").val();
            if(!shipping_name){
                $.toast('请填写您的物流名称！');
                return false;
            }
            if(!shipping_no){
                $.toast('请填写您的物流编号！');
                return false;
            }
            
            if(!shipping_time){
                $.toast('请填写您的发货时间！');
                return false;
            }
            $.ajax({
                    url: url,
                    async: false,
                    type: 'POST',
                    data: {
                        goodsid: goodsid,
                        orderid: orderid,
                        shipping_name: shipping_name,
                        shipping_no: shipping_no,
                        shipping_time: shipping_time
                    },
                    headers: {
                        "Token": sso_Token
                    },
                    success: function(result) {
                        var data = $.parseJSON(result);
                        if (data['code'] == 0) {
                            $.toast('发货成功!');
                            $.router.loadPage('shop_order.php?order_type=');
                        } else {
                            $.toast('发货失败！');
                            return false;
                        }

                    }
            });
        })
        
	});
});