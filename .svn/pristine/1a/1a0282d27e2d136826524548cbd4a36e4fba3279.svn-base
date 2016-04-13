$(function () {
	// 我的业绩
	  'use strict';
		$(document).on('pageInit','#page-achievement',function(e,id,page){
			var pages = 1;
			var action = getRrlParam('type') ? getRrlParam('type') : 'myBonus' ;
			if(action == 'teamBonus'){
				$(".title").text('团队业绩');
			}
			// 获取 业绩详情
			function selfBonusAddItems(offset, pages) {
			    //加载数据
			    var max = 0;
			    $.ajax({
			      type: "GET",
			      url: apiUrl,
			      async: false,
			      data: {
			        m: 'account',
			        c: 'index',
			        a: action,
			        pages: pages,
			        offset: offset,
			      },
			      headers: {
			        "Token": sso_Token
			      },
			      success: function(result) {
			        var data = result;
			        var data = JSON.parse(result);
                  	
                        if (data.code == 0) {
                    		max = data.data.total;	
                    		var amount = data.data.amount;
                    		var DayAmount = data.data.DayAmount;
                    		var MonthAmount = data.data.MonthAmount;
                    		$(".amount").text(amount);
                    		$(".Damount").text(DayAmount);
                    		$(".Mamount").text(MonthAmount);
                            var info = data.data.lists;
                            var bonushtml = '';
                            $.each(info, function(index, val) {
                                bonushtml += '<li class="borb1 bce6">';
                                bonushtml += '<div class="item-content">';
                                bonushtml += '<div class="item-inner w100b">';
                                bonushtml += '<span class="inlineblock w80b fs06">';
                                bonushtml += '<span class="inlineblock c333 fs05 textove w100b">'+val.title+'</span>';
                                bonushtml += '<span class="inlineblock c999 fs05">'+val.datetime+ ' &nbsp;&nbsp;&nbsp;&nbsp;'+val.status+'</span>';
                                bonushtml += '</span>';
                                bonushtml += '<span class="inlineblock w20b fs06 c0894EC"><i class="iconfont mar0 marr10">&#xe623;</i>'+val.bonus+'</span>';
                                bonushtml += '</div>';
                                bonushtml += '</div>';
                                bonushtml += '</li>';
                              
                            });
                        $('.list-container > ul').append(bonushtml);
                         // 删除加载提示符
              			$('.infinite-scroll-preloader').remove();
			      	}else{
			      		$('.list-container > ul').append('<li><div class="item-content"><div class="item-inner w100b"><span class="inlineblock c333 fs05 textove w100b">暂无业绩，请继续加油！</span></div></div></li>');
			      		$('.infinite-scroll-preloader').remove();
			      		$.detachInfiniteScroll($('.infinite-scroll'));
			      	}
			    }
			  });
			   return max;
			}
		var loading = false;
		var max = selfBonusAddItems(6,1);
		/**
		 * 下拉列表
		 * @param
		 */
		
		$(page).on('infinite',function() {
		
		var offset = 6;
		var max = selfBonusAddItems(offset,pages);
		 //如果正在加载，则退出
		if (loading) return false;
		loading = true;
		if (max > (pages * offset)) {
			 // 更新页码
			 pages++
			 // 添加新条目
			 max = selfBonusAddItems(offset, pages);
			 // 重置加载flag
			 loading = false;
			 // 容器发生改变,如果是js滚动，需要刷新滚动
			 $.refreshScroller();
		}else{
			 // 加载完毕，则注销无限加载事件，以防不必要的加载
			 $.detachInfiniteScroll($('.infinite-scroll'));
			 // 删除加载提示符
			 //$('.infinite-scroll-preloader').remove();
			 $(".preloader_null").removeClass("disn");
			 $(".preloader").addClass("disn");

			 return false;
		}


		});

	});
})