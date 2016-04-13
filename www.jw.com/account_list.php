<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>云兆●云商城</title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
        <link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
        <link rel="stylesheet" href="/sources/css/demos.css"/>
        <link rel="stylesheet" href="/sources/css/add.css"/>
    </head>
    <body>
        <!-- page 容器 -->
        <div class="page" id="page-account-list">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <a class="pull-left back" href="member.php">
                    <i class="icon iconfont mar0 fs13 white">
                        &#xe61b;
                    </i>
                </a>
                <h1 class="title">
                    我的账单
                </h1>
            </header>
            <nav class="bar bar-tab">
        			<span class="toools-bar-but tab-item external" style="cursor:pointer;" id="shop-index" data-but-type="index">
        				<i class="icon iconfont">&#xe640;</i>
        				<span class="tab-label">首页</span>
        			</span>
        			<span class="toools-bar-but tab-item" style="cursor:pointer;">
        				<i class="icon iconfont">&#xe684;</i>
                        <span class="tab-label">云兆云商</span>
        			</span>
        			<span class="toools-bar-but tab-item" data-but-type="cart" style="cursor:pointer;">
        				<i class="icon iconfont">&#xe62e;</i>
        				<span class="tab-label">购物车</span>
        			</span>
        			<span class="toools-bar-but tab-item" data-but-type="order" style="cursor:pointer;">
        				<i class="icon iconfont">&#xe661;</i>
        				<span class="tab-label">订单</span>
        			</span>
        			<span class="toools-bar-but tab-item active" data-but-type="member" style="cursor:pointer;">
        				<i class="icon iconfont">&#xe65e;</i>
        				<span class="tab-label">我的</span>
        			</span>
        		</nav>
            <!-- 这里是页面内容区 -->
            <div class="content pull-to-refresh-content infinite-scroll" data-ptr-distance="50">
                <!-- 默认的下拉刷新层 -->
                <div class="pull-to-refresh-layer">
                    <div class="preloader">
                    </div>
                    <div class="pull-to-refresh-arrow">
                    </div>
                </div>
                <div class="list-block fs07">
                    <ul id="account-list-block">
                        <!--
                            a class="c666" href="">
                            <li class="item-content borb1 bce6 padt5 padb5">
                                <div class="fll">
                                    <div>
                                        2015-12-9
                                    </div>
                                    <div>
                                        购买商品
                                        <span class="">
                                            时尚女装
                                        </span>
                                    </div>
                                </div>
                                <div class="flr"  style="line-height:2rem;">
                                    <i class="flr icon iconfont mar0 cccc" style="margin:0 0.6rem 0 0.4rem">
                                        &#xe640;
                                    </i>
                                    <div class="flr">
                                        -100
                                    </div>
                                </div>
                            </li>
                        </a>
                        <a class="c666" href="">
                            <li class="item-content borb1 bce6 padt5 padb5">
                                <div class="fll">
                                    <div>
                                        2015-12-9
                                    </div>
                                    <div>
                                        购买商品
                                        <span class="">
                                            时尚女装
                                        </span>
                                    </div>
                                </div>
                                <div class="flr"  style="line-height:2rem;">
                                    <i class="flr icon iconfont mar0 cccc" style="margin:0 0.6rem 0 0.4rem">
                                        &#xe640;
                                    </i>
                                    <div class="flr">
                                        -100
                                    </div>
                                </div>
                            </li>
                        </a>
                        <a class="c666" href="">
                            <li class="item-content borb1 bce6 padt5 padb5">
                                <div class="fll">
                                    <div>
                                        2015-12-9
                                    </div>
                                    <div>
                                        购买商品
                                        <span class="">
                                            时尚女装
                                        </span>
                                    </div>
                                </div>
                                <div class="flr"  style="line-height:2rem;">
                                    <i class="flr icon iconfont mar0 cccc" style="margin:0 0.6rem 0 0.4rem">
                                        &#xe640;
                                    </i>
                                    <div class="flr">
                                        -100
                                    </div>
                                </div>
                            </li>
                        </a
                    -->
                </ul>
            </div>
            <!-- 加载提示符 -->
            <div class="infinite-scroll-preloader">
                <div class="preloader">
                </div>
            </div>
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
