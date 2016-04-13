$(function () {
	'use strict';
	//获取商铺二维码
	$(document).on("pageInit", "#shop_qr", function(e, id, page) {
		sessionStorage.removeItem("shareData_info");
		var siteid = sessionStorage.getItem('userid');
		var shopInfo = getShopInfo(siteid);
		console.log(shopInfo)
		var shareData = {};
	   	 shareData.title = '云兆云商城-'+shopInfo.name;
	   	 shareData.desc = shopInfo.desc || '云兆云商城-'+shopInfo.name;
		 shareData.link = APP_PATH + 'index.php?siteid=' + siteid + '&YunUser=' + siteid;
	   	 shareData.thumb = shopInfo.avatar;
		sessionStorage.setItem('shareData_info',JSON.stringify(shareData));
		
		var userinfo = checkLogin('1');
		if(!userinfo['userid'])location.replace(document.domain+'/login.php');
		$.ajax({
			type: "POST",
			url: apiUrl+"userQcode/index/shopQcode",
			data: "userid="+userinfo['userid']+'&siteid='+userinfo['userid'],
			headers: {"Token":sso_Token},
			success: function(result){
				var res = JSON.parse(result)
				if(res['code'] == 200){
					$('.shop_qr').html('<img class="marauto w70b mart30" src="'+res['data']+'" alt="">');
				}else{
					$.toast(res['error']);
				}
			}
		});
	});
});
