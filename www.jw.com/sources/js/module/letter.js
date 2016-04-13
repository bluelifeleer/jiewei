$(function(){
	'';
	$(document).on('pageInit','#page-letter',function(){

		/**
		 * 消息页面
		 * @author 李鹏
		 * @date 2016-02-23
		 */

		var user = checkLogin('1');
		if (!user) {
	      $.router.loadPage('login.php');
	    }
	    $.showIndicator();

	    var msgId = getRrlParam('msgid');
	    var url = encodeURI(apiUrl + 'message/index/get/msgid/' + msgId);
	    $.ajax({
	    	url : url,
	    	type : 'GET',
	    	async : false,
	    	headers : {
			    "Token": sso_Token
			},
	    	success : function(res){
	    		var htmlStr = '';
	    		res = JSON.parse(res);
	    		if(res.code == 0){
	    			$.hideIndicator();
	    			htmlStr = '<div class="w100b h40 lh40 fs08" style="font-weight:bold">'+res.data['title']+'</div>'+
	    				'<div class="w100b h40 lh40 fs07">'+res.data['create_time']+'</div>'+
	    				'<div class="w100b fs07">'+res.data['contents']+'</div>'+
	    				'<div class="w100b h50 lh50"></div>';
	    			$('#letter-block').html(htmlStr);
	    		}else{
	    			$.hideIndicator();
	    			$.toast('获取信息失败');
	    		}
	    	},
	    	error : function(err){
	    		$.hideIndicator();
	    		$.toast(err);
	    	}
	    })
	});
});
