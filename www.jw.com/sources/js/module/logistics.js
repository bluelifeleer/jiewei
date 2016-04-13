$(function () {
	'use strict';
	
	//发布
	$(document).on("pageInit", "#logistics", function(e, id, page) {
		$.ajax({
			type: "POST",
			url: apiUrl+"logistics/index/lists",
			data: "order_id="+getRrlParam('order_id'),
			headers: {"Token":sso_Token},
			success: function(result){
				var res = JSON.parse(result)
				if(res['code'] == 200){
					var data = JSON.parse(res['data']);
					// console.log(data);
					$('.expTextName').text(data.expTextName);
					$('.mailNo').text('订单号：'+data.mailNo);
					$.each(data.data,function(k,v){
						$('.list-block ul').prepend(
							'<li class="item-content padt10 padb10 fs06 borb1 bce6">'+
								'<div class="w30bb fs055">'+v.time+'</div>'+
								'<div class="w70b padl10 padr10">'+v.context+'</div>'+
							'</li>'
						);
					});
				}else{
					$.toast(res['error']);
				}
			}
		});
	});
//
});