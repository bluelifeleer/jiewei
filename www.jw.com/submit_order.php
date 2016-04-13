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
    <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>	<link rel="stylesheet" href="/sources/css/add.css" />
	<link rel="stylesheet" href="/sources/css/demos.css">
</head>
<body>
	<!-- page 容器  begin -->
	<div class="page" id="page-submit-order">
		<!--  顶部标题栏  begin  -->
		<header class="bar bar-nav">
			<h1 class="title">购物车结算</h1>
			<a class="pull-left back " href="cart.php"> <i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
			</a>
		</header>
		<!--  顶部标题栏  end -->
		<!-- 底部导航栏   begin -->
		<nav class="bar bar-tab h40">
			<span class="fs06 marl20" style="line-height: 40px;">
				共	<span class="total">0</span>件商品，总金额： <font class="cfa6a0b fs05">&yen;<span class="amount">0.00</span></font>
			</span>
			<span id="submit-order-btn" style="cursor:pointer;" class="block w100 fs08 padt8 txac h40 lh30 flr bgcFF3200 white">确认</span>
		</nav>
		<!--  底部导航栏  end  -->

		<!-- 这里是页面内容区 -->
		<div class="content">
			<div class="card borrad0 marr0 marl0">
				<div class="list-block fs06 mar0 marb10">
                    <ul >
						<li class="open-choose-address-popup">
                        	<label class="label-checkbox item-content padl6" style="padding-left: 6px; ">
		                        <div class="item-media"><i class="icon iconfont mar0" title="选择收货地址" alt="选择收货地址">&#xe62b;</i></div>
		                        <div class="item-inner" style="margin-left: 6px; ">
			                        <div class="item-title w100b" >
				                        <div class="Address_username">收件人</div>
				                        <div class="Address_mobile">联系电话</div>
			                      
			                        	<div class="Address_shipAddress"></div> 
			                        </div>
			                    </div>
                        	</label>
                        </li>
                        <input type="hidden"  id="submit-order-address" name="address" value="">
                    </ul>
                </div>
			</div>
			<!--商家1的订单商品  begin-->
			<div class="card mar0 marb10 pad10">

				<div class="c666 ">
					<div>
						<div>
							<a href="" class="fll c666 ">结算商品</a>
							<div class="clear"></div>
						</div>
						<div id="select-product">
							<!-- 加载提示符 -->
							<div class="infinite-scroll-preloader">
									<div class="preloader"></div>
									<div class="preloader_null disn fs06">没有需要付款的商品！</div>
							</div>
						</div>

					</div>

					<div class="txar fs07 bort1 bce6 h40 padt8 padr10">
						<div class="fll c666">物流费：</div>
						<div class="flr fs06 padt2 marr4 c666" id="transit_cost"></div>
						<div class="clear"></div>
					</div>
					<div class="txar fs07 bort1 bce6 h40 padt8 padr0">
						<div class="fll c666">买家留言</div>

						<div class="item-input fll padl10" style="width:80%">
							<textarea  id="orderComment" class="bor0 fs06 h60 w100b" rows="3" maxlength="64" style="resize: none;" placeholder="选填，可填写你和卖家达成一致的要求"></textarea>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="txar fs06 bort1 bce6 padt10 pad0" >
					共
					<span class="total">0</span>
					件商品 合计：￥
					<span class="amount">0.00</span>
					(含运费￥
					<span class="other-amount">0.00</span>
					)
				</div>
			</div>
			<!--商家1的订单商品  end-->

		</div>

		<!-- 页面内容区  end -->
	</div>
	<!-- page 容器  end  -->
	<div class="panel-overlay"></div>
		<!-- Left Panel with Reveal effect -->
		<div class="panel panel-right panel-cover theme-dark" id='panel-js-demo'>
		  <div class="content-block">
		    	<div class="card borrad0 marr0 marl0">
					<div class="list-block fs06 mar0 marb10">
			            <ul class="address">
			            </ul>
			        </div>
				</div>
		    <!-- Click on link with "close-panel" class will close panel -->

		    <p style="padding-left: 1rem;">
		    	<a href="add_address.php?backPage=submit_order.php" class="item-title close-panel">添加</a>
		    	<span class="w30 h30 padl10"></span>
		    	<a href="#"  class="close-panel">关闭</a>
		    </p>
		  </div>

		</div>


	</body>
	<script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
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
