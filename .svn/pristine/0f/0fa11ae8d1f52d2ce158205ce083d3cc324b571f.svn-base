$(function(){
	'use strict';
	$(document).on('pageInit','#page-letter-detail',function(e, id, page){
		/**
		 * 消息详情页面
		 * @author 李鹏
		 * @date 2016-02-23
		 */

		//判断是否登录
	    var user = checkLogin('1');
	    if (!user) {
	      $.router.loadPage('login.php');
	    }
	    $.showIndicator();
	    
	    //加载数据
	    loadingData();
	    function loadingData(num,offset,ev){
	    	var num,offset,isLoading = false;
	    	if(isLoading) return false;
	    	isLoading = true;
	    	if(!num){
	    		num = 10
	    	}else{
	    		num = num;
	    	}
	    	if(!offset){
	    		offset = 0;
	    	}else{
	    		offset = offset;
	    	}
	    	//获取消息id
		    var msgType = getRrlParam('msg_type');
		    var url = encodeURI(apiUrl + 'message/index/lists/msgType/'+msgType+'/num/'+num+'/offset/'+offset);
		    $.ajax({
		    	url : url,
		    	type : 'GET',
		    	asycn : false,
		    	headers : {
			    	"Token": sso_Token
			    },
		    	success:function(res){
		    		res = JSON.parse(res);
		    		var htmlStr = '';
		    		if(res.code == 0){
						$.hideIndicator();
						if(res.data.length){
							for(var i=0; i<res.data.length; i++){
								htmlStr += '<div class="content-block-title mart10 txac">	'+res.data[i]['create_time']+'</div>'+
											'<div class="card">'+
												'<div class="card-header">'+res.data[i]['title']+'</div>'+
												'<div class="card-content">'+
													'<div class="card-content-inner">'+
														res.data[i]['contents']+
													'</div>'+
												'</div>'+
												'<a href="letter.php?msgid='+res.data[i]['id']+'" class="c3D4145">'+
												'<div class="card-footer" style="text-align:center;">查看详情</div>'+
												'</a>'+
											'</div>';
							}
							//原始数据
							var originalData = $('#msg-list-block').html();
							$('#msg-list-block').html(originalData+htmlStr);
				            if(parseInt($('#msg-list-block').height()) < screenH){
				              $('.infinite-scroll-preloader').css('display','none');
				            }
							// 加载完毕需要重置
							$.pullToRefreshDone('.pull-to-refresh-content');

						}else{//表示没有数据了
							$.toast('没有更多数据可加载', 2000);
							if(ev){
								isLoading = false;
								// 加载完毕，则注销无限加载事件，以防不必要的加载
				                $.detachInfiniteScroll($('.infinite-scroll'));
				                // 删除加载提示符
				                $('.infinite-scroll-preloader').remove();
							}
						}
		    		}else{
		    			$.hideIndicator();
		    			$.toast('加载数据失败');
		    			if(ev){
		    				isLoading = false;
		    				// 加载完毕需要重置
        					$.pullToRefreshDone('.pull-to-refresh-content');
        					// 加载完毕，则注销无限加载事件，以防不必要的加载
			                $.detachInfiniteScroll($('.infinite-scroll'));
			                // 删除加载提示符
			                $('.infinite-scroll-preloader').remove();
		    			}
		    		}
		    	},
		    	error:function(err){
		    		$.hideIndicator();
		    		$.toast('请求失败，请稍后再试！');
		    		if(ev){//表示是滚动加载
		    			isLoading = false;
		    			// 加载完毕需要重置
        				$.pullToRefreshDone('.pull-to-refresh-content');
        				// 加载完毕，则注销无限加载事件，以防不必要的加载
			            $.detachInfiniteScroll($('.infinite-scroll'));
			            // 删除加载提示符
			            $('.infinite-scroll-preloader').remove();
		    		}
		    	}
		    });
	    }
/**-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------**/
		/**
		 * 下拉刷新
		 */
		$(document).on('refresh', '.pull-to-refresh-content',function(e) {
			$('#msg-list-block').html('');
			loadingData();
		});
/**-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------**/
		/**
		 * 滚动加载
		 */
		infiniteScroll();
		function infiniteScroll(){
			var index = 0;
			var num = 10;
			var offset = 0;
			// 注册'infinite'事件处理函数
	    	$(document).on('infinite', '.infinite-scroll',function() {
	    		index++;
	    		offset = num*index;
	    		loadingData(num,offset,'1');
	    	});
		}
/**-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------**/
	});
});
