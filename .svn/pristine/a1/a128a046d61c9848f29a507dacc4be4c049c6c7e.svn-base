$(function () {
	'use strict';
	
	$(document).on('pageInit','#page-assess',function(e,id,page){
		//判断是否登录
		var userinfo = checkLogin('1');

		$(page).on("click", "#is_show_name", function(e, id, page) {
			if($('#is_show_name').val() == 1){
				$('#is_show_name').val(2);
			}else{
				$('#is_show_name').val(1);
			}
		});



		//发布
		$(page).on("click", ".release", function(e, id, page) {

			var assessContent = $('#asses-scontent').val();
			var isShowName = $('#is_show_name').val();
			var userid = userinfo.userid;
			var username = userinfo.nickname;
			var goodId = getRrlParam('goods_id');
			var orderId = getRrlParam('order_id');


			
			//判断评论内容是否为空
			if(assessContent == ''){
				$.toast('评论内容不能为空');
				return;
			}

			var url = encodeURI(apiUrl+"comment/index/createComment");
			var data = {
				'userid':userid,
				'nickname':username,
				'order_id':orderId,
				'product_id':goodId,
				'evaluate_content':assessContent,
				'is_show_name':isShowName
			}


			$.ajax({
				type: "POST",
				url: url,
				headers: {"Token":sso_Token},
				data:data,
				success: function(res){
					var res = JSON.parse(res);
					if(res.code == 0){
						//评论成功
						$.router.loadPage('product_comment.php?id='+parseInt(res.data));
					}else if(res.code == 2){
						//评论为空
						$.toast('您提交的评论为空');
						return false;
					}else if(res.code == 3){
						//评论为空
						$.toast('您已评论，不能再次评论！');
						return false;
					}else{
						//评论失败
						$.toast('评论失败，请稍后再试');
						return false;
					}
				},
				error:function(err){
					$.toast(err);
				}
			});
		});
	});

});
