<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>云兆●云商城</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/favicon.ico">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
		<link rel="stylesheet" href="/sources/css/demos.css">
		<link rel="stylesheet" type="text/css" href="/sources/css/add.css">
	</head>
	<body>
		<!-- page 容器 -->

		<div class="page" id="page-product">

			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">商品详情</h1>
				<a class="pull-left back" id="pull-left" href="#">
					<i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
				</a>
				<span class="pull-right product-goto-cart">
					<i class="icon iconfont mar0 white fs13">&#xe605;</i>
				</span>
			</header>
			<!--工具栏-->
			<nav class="bar bar-tab">
				<span  class="inlineblock shareLink tab-item  w10b ">
					<i class="iconfont block">&#xe601;</i>
					<span class="block fs06">分享</span>
				</span>
				<input type="hidden" id="shareData" data-title="" data-desc="" data-link="" data-thumb="">
				<a href="javascript:void(0);" class="inlineblock tab-item  add-cart w40b bgcF3720E fs06 open-add-cart external" style="color:#FFF;">加入购物车</a>
				<a href="javascript:void(0);" id="buy-popup" class="inlineblock tab-item  w40b bgcFF3200 fs06 open-buy-popup external" data-fn="new-shop" style="color:#FFF;">立即购买</a>
			</nav>
			<div class="content">
				<div class="card mar0 bgfff">
					<div class="w100b">
						<div class="product_detail" >
							<div  class="pos-r product-banner" >
								<ul class="picitems" style="min-height: 15rem;">
									<div class="infinite-scroll-preloader">
										<div class="preloader" style="margin-top: 6rem" ></div>
										
									</div>
									
								</ul>
								<div class="pos-a product-banners" style="bottom:5px;left:50%"></div>
							</div>
						</div>
					</div>
					<div class="pad10 fs07">
						<div class="product-title">商品名称....</div>
						<div class="fs10 pad5">
							<div class="flr cfa6a0b sale_price">0.00</div>
							<div class="clear"></div>
						</div>
						<div class="row no-gutter padt5 fs06 c999">
							<div class="col-33 h30 lh30 txal transit_type">快递：免费</div>
							<div class="col-33 h30 lh30 txac seles">月销0笔</div>
							<div class="col-33 h30 lh30 txar made">产地</div>
						</div>
					</div>
				</div>
				<div class="card mar0 mart10">
				    <div class="card-content">
				    	<div class="card-content-inner">
				    		<div id="product-comment-list" class="padb10">
					    		<!-- <div class="w100b h25 lh25 fs07 ovfh">
					    			<div class="inlineblock w60b fll">
										<span class="inlineblock h20" style="vertical-align:middle"><img src="/sources/images/59d348e0f2e38b5994756c520f3d8e37.jpg" class="w20 h20 borrad10"></span>
										<span class="inlineblock  h20 lh20">blu****eer/2015-12-19</span>
									</div>
									
								</div>
								<div class="buy-comment fs06 mart5">是没有激活的新机，特意用了些日子才评价，cpu三星的，大贊。</div>
								<div class="seller-reply fs06 mart5">[卖家回复]只要亲的喜欢，就是我们最开心最成功的，～么么哒～．</div> -->

							</div>
							<div class="w100b h40 padt5"><a href="product_comment.php" class="product_comment block w150 h30 txac lh30 fs08 bor1 bcFF3200 cFF3200  borrad5" style="margin:auto;">查看更多评论</a></div>
						</div>
					</div>
				</div>
				<div class="card mar0 mart10">
					<div class="card-content">
          					
						<a  class="product_detail" href="javascript:void(0);" data-id="" class="c3D4145 product_detail"><div class="card-content-inner txac mar0">查看更多详情</div></a>
					</div>
				</div>
			</div>
		</div>

	</body>
<script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
<script type="text/javascript" src="/sources/js/zepto.picLazyLoad.min.js"></script>
<script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/sources/js/module/public.js"></script>
<script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.all.js"> </script>

<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
