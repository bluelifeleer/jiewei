$(function(){
	'use strict';
	$(document).on('pageInit','#index-page',function(e,id,page){
		
	
		 //加载店铺
		 //店铺ID
		 var siteid = getRrlParam('siteid');
		 //判断地址是否有siteid
		 siteid = isEmpty(siteid)?'1':siteid;
		 //判断是否存在店铺，不存在转平台店铺
		 siteid = checkShop(siteid)== 0 ? 1: siteid;
		 //sessionStorage 清除浏览器中店铺信息
		 sessionStorage.removeItem("site_info");
		 sessionStorage.removeItem("categories_info");
		 //初始化浏览器中店铺的信息 siteinfo
		 var siteinfo = {};
		 	siteinfo.siteid = siteid;
		 sessionStorage.setItem('site_info',JSON.stringify(siteinfo));

		 //获取店铺信息
		 var shopInfo = getShopInfo(siteid);

	  
	   	   /**
		    * [默认分享 share]
		    * 
		    */
	   		 sessionStorage.removeItem("shareData_info");
		    var suse = sessionStorage.getItem('userid') || sessionStorage.getItem('YunUser') || JSON.parse(sessionStorage.getItem('site_info')).siteid || 1;
		    sessionStorage.setItem("YunUserId",suse);
		    var sdate = sessionStorage.getItem("shareData_info");
		    // if(!sdate){
		    // var siteid = JSON.parse(sessionStorage.getItem("site_info")).siteid;
		    var shopInfo = getShopInfo(siteid);
		    // if(!shopInfo) shopInfo = getShopInfo(1);
		    var shareData = {};
		    shareData.title = '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
		    shareData.desc = shopInfo.desc || '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
		    shareData.link = APP_PATH + 'index.php?siteid=' + siteid + '&YunUser=' + sessionStorage.getItem('YunUserId');
		    shareData.thumb = shopInfo.avatar || 'http://res.zj3w.net/category/icon/2016/03/11/56e2aa4726f2464.png';
		    ;
		    sessionStorage.setItem('shareData_info',JSON.stringify(shareData));
	   	
	   	 	$('#index-page #shareData').attr({'data-title':JSON.parse(sessionStorage.getItem('shareData_info')).title,'data-desc':JSON.parse(sessionStorage.getItem('shareData_info')).desc,'data-link':JSON.parse(sessionStorage.getItem('shareData_info')).link,'data-thumb':JSON.parse(sessionStorage.getItem('shareData_info')).thumb});

		    // }

		 $('#shop-title').html(shopInfo.name);
		 $('#shop-index').attr('href','/index.php?siteid='+siteid);
		 var avatar = shopInfo['avatar'] == '' ? imgUrl+'shop_50x50.png' : shopInfo.avatar;
		
		 var userInfoHtml = '<a class="pull-left external" href="index.php?siteid='+siteid+'">'+
			 '<img id="avatar"  src="'+avatar+'" class="borrad50 avatar w40  h40" style="margin-top:0.1rem;">'+
		 '</a>';
		 $('#shop-info-block').html(userInfoHtml);
		 //图片加载检查，失败默认图片替换
		 imgErrorReplace('/sources/images/shop_50x50.png','avatar');

		

		//轮播图插入
		var abvertInfo = getAdvert(siteid);
		if(!$.isEmptyObject(abvertInfo)){
			var html = '';
			var count = 0;
			$.each(abvertInfo,function(index, el) {
				  count == 0 ? html +='<li class="w100b"><a class="external" href="'+(el.link == ''?'javascript:void(0)':el.link)+'"><img class="w100b" src="'+el.images+'"></a></li>':html += '	<li class="w100b disn"><a class="external" href="'+(el.link == ''?'javascript:void(0)':el.link)+'"><img class="w100b" src="'+el.images+'"></a></li>';
				  count ++;
			});
			$("#shop-advert").html(html);
		}
		/**
		 *	首页轮播放
		 *	@date 2015-12-16
		 */
		var startX, endX;
		var bantime;

	 	for (var i = 1; i <= $('#index-banner ul li').size(); i++) {
	 		$('#index-banner ul li:eq('+(i-1)+')').addClass('li'+i);
	 		$('#index-banners').append('<div id="rad'+i+'" class="w10 h10 borrad50 marr5 bor2 fll bcfff">');
	 	};
	 	$('#index-banners').css('margin-left','-'+($('#index-banners div').size()*15)/2+'px');
	 	$('#index-banner ul .li1').css('display','block');
	 	$('#rad1').css('border-color','#fa6a0b');
	 	bantime = setTimeout(function(){
	 		index_banner();
	 	},4000);
	 	document.getElementById("index-banner").addEventListener("touchstart",touchStart,false);
	 	document.getElementById("index-banner").addEventListener("touchmove",touchMove,false);
	 	document.getElementById("index-banner").addEventListener("touchend",touchEnd,false);

		var k = 1;
		function index_banner(){
			k++;
			if(k > $('#index-banner ul li').size()) k = 1;
			if(k < 1) k = $('#index-banner ul li').size();
			$('#index-banners div').css('border-color','#fff');
			$('#rad'+k).css('border-color','#fa6a0b');
			$('#index-banner ul li').css('display','none');
			$('#index-banner ul li').removeClass('disn');
			$('#index-banner ul .li'+k).fadeIn(2000).css("display","block");
			clearTimeout(bantime);
			bantime = setTimeout(function(){
				index_banner();
			},4000);
		}

		function touchStart(event) {
			var touch = event.touches[0];
			startX = touch.pageX;
		}
		function touchMove(event) {
			var touch = event.touches[0];
			endX = touch.pageX;
		}
		function touchEnd(event) {
			if((startX - endX) > 10){
				if(k > 0){
					clearTimeout(bantime);
					index_banner();
				}
			}else if((startX - endX) < -10){
				if(k > 0){
					k = k - 2;
					if(k < 0) k = $('#banner ul li').size()-1;
					clearTimeout(bantime);
					index_banner();
				}
			}
		}

		//产品栏目
	    var cateInfo = getCategoty(siteid);
	    if(!$.isEmptyObject(cateInfo)){
			var html = '';
			$.each(cateInfo,function(index, el){

						html += '<div class="col-20 padb10">';
						html +=	'<a class="c666 open-indicator" href="product_list.php?cateid='+el.catid+'">';
					    html += '<div class="w50 h50 borrad50 marauto" style="line-height:43px;">';
						
						html += '<img src="'+el.image+'" class="w50 h50 " alt="placeholder+image" />';
					    html += '</div>';
						html += '<div>'+el.catname+'</div>';
						html += '</a>';
					    html += '</div>';
			});
			html += '<div class="col-20 padb10">';
			html +=	'<a class="c666 open-indicator item-link item-content" href="product_categories.php?catid=more">';
			html +=	'<div class="w50 h50 borrad50 marauto" style="line-height:20px;background-color:#f00;">';
			html += '<img src="http://res.zj3w.net/category/icon/2016/03/08/56deb3d7d9a4997.png" class="w50 h50 borrad50 marauto" alt="placeholder+image" />';
			html += '</div>';
			html += '<div>栏目</div>';
			html += '</a>';
			html += '</div>';
			$('#categories').html(html);
		}
		//数据加载前  显示加载图标
	    $(page).on('click','.open-indicator', function () {
	        $.showIndicator();
	        setTimeout(function () {
	          $.hideIndicator();
	        }, 1000);
   		});

		//热门产品列表
		var hotPorInfo = getHotProduct(siteid);

		if(!$.isEmptyObject(hotPorInfo)){
			$('#hot-porduct').removeClass('disn');
			var count = 4;
			$.each(hotPorInfo,function(index, el) {
					$('#hot'+count).attr({'href':'/product.php?id='+el.id,'data-id':el.id});
					$('#hot'+count+' img').attr({'src':'/sources/images/defaultpic.gif','data-original':el.thumb});
					count--;
			})
		}else{
			$('#hot-porduct').addClass('disn');
		}

		
		//全部商品列表
		var loading = false;
		var pages = 1;
		var offset = 6;
		var orderby = 1;
		var cateid = 0;
		var max = index_add_Items(offset, pages, orderby, cateid ,siteid);
		//图片懒加载
		$('.hot-thumb').picLazyLoad({
		    threshold: 0,
		    placeholder: 'sources/images/defaultpic.gif'
		});


		$('#index-product').removeClass('disn');
		loading = max > offset?false:true;
		if(loading){
			// 加载完毕，则注销无限加载事件，以防不必要的加载
			$.detachInfiniteScroll($('.infinite-scroll'));
			// 删除加载提示符
			//$('.infinite-scroll-preloader').remove();
			$(".preloader_null").removeClass("disn");
			$(".preloader").addClass("disn");
		}

		/**
		 * 下拉列表
		 * @param
		 */
		$(page).on('infinite', function() {
			//图片懒加载
			$('.hot-thumb').picLazyLoad({
			    threshold: 0,
			    placeholder: 'sources/images/defaultpic.gif'
			});

			 // 如果正在加载，则退出
			if (loading) return false;
			loading = true;
			if (max > (pages * offset)) {
				 // 更新页码
				 pages++
				 // 添加新条目
				 max = index_add_Items(offset, pages, orderby, cateid ,siteid);
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

		//图片懒加载
		$('.hot-thumb').picLazyLoad({
		    threshold: 0,
		    placeholder: 'sources/images/defaultpic.gif'
		});

	});



	/**
	* 载入产品
	* @param {[offset]} number  分页数量
	* @param {[pages]} number 页码
	* @param {[order]} string 排序字段
	* @param {[catid]} number 栏目id
	*/

	function index_add_Items(offset, pages, order, catid, siteid) {
		var max = 0 ;
		var order = order || 0;
		var catid = catid || 0;
		$.ajax({
					type: "GET",
					url: apiUrl,
					async: false,
					headers: {"Token":sso_Token},
					data: {m:'index',c:'index',a:'productAllLists',pages:pages,offset:offset,order:order,catid:catid,siteid:siteid},
					dataType: "json",
				  	success: function(result){
						if(result.code == 1){
							max = result.total;
							var html = '';

							var i = '';
							for( i in result.data){
								
								var icon = '';

								if(result.data[i].sysadd == 0 && result.data[i].fromid > 0){//表示平台导入的商品
									icon = '<span style="display:block;width:80px;height:30px;position:absolute;left:0px;top:0;">'+
										'<i class="iconfont mar0 pad0 fs15 cb1408">&#xe68c;</i>'+
									'</span>';
								}else if(!result.data[i].fromid && result.data[i].sysadd == 1){//平台商品
									icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
								}else{//表示自己添加的商品
									icon = '<span style="display:block;width:80px;height:40px;position:absolute;left:0px;top:0;"></span>';
								}
								//判断商品是否下架，如果下架隐藏
								if(parseInt(result.data[i].is_up) == 99){
									html += '<div class="col-50 bgfff bor2 bort2 bceee padb5 flr" style="position:relative;left:0;top:0;">'+
									'<a class="c666" href="product.php?id='+result.data[i].id+'">'+
									'<img class="hot-thumb w100b" src="/sources/images/defaultpic.gif" data-original="'+result.data[i].thumb+'" onError="this.onerror=null;this.src=\'/sources/images/defaultpic.gif\';"  alt="">'+
									'<div class="c333 padl5 padr5 textove">'+cutString(result.data[i].title,40)+'</div>'+
									'<div class="padl5 padr5">'+
									'<div class="cfa6a0b fll">&yen;'+result.data[i].sale_price+'</div>'+
									'<div class="flr fs06">销量'+result.data[i].sales+'</div>'+
									'</div>'+
									'</a>'+
									icon+
									'</div>';
								}
							}
							if(pages == 1){
								$('.infinite-scroll #list-container').html(html);
							}else{
								$('.infinite-scroll #list-container').append(html);		
							}
							
						}else{
							$.toast('获取数据失败，请刷新再试');
						}
					}
				});

				//图片懒加载
				$('.hot-thumb').picLazyLoad({
				    threshold: 0,
				    placeholder: 'sources/images/defaultpic.gif'
				});

				return max;
	}
  
});
