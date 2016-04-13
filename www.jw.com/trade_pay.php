<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>
            云兆●云商城
        </title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
        <link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
        <link rel="stylesheet" href="/sources/css/demos.css" />
        <link rel="stylesheet" href="/sources/css/add.css" />
    </head>
    <body>
        <!-- page 容器  begin -->
        <div class="page" id="page-trade-pay">
            <!-- 顶部标题栏  begin -->
            <header class="bar bar-nav">
                <h1 class="title">
                    付款详情
                </h1>
                <a class="pull-left back " href="submit_order.php">
                    <i class="icon iconfont mar0 white">
                        &#xe64c;
                    </i>
                </a>
            </header>
            <!-- 顶部标题栏  end -->
            <!-- 工具栏 -->
            <nav class="bar bar-tab">
                <span class="toools-bar-but tab-item external active" style="cursor:pointer;" id="shop-index" data-but-type="index">
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
                <span class="toools-bar-but tab-item " data-but-type="member" style="cursor:pointer;">
                    <i class="icon iconfont">&#xe65e;</i>
                    <span class="tab-label">我的</span>
                </span>
            </nav>
            <!-- 这里是页面内容区  begin -->
            <div class="content" id="order-info">
                <div class="list-block mart10">
                    <ul id="order-info-block" class='pad10'>
                        <!-- 订单内容 -->
                    </ul>
                    <p class="mar10 mart10  ">
                        <a class="button button-big button-fill  bgfa6a0b external" href="javascript:void(0);" id="pay-but">
                            确定支付
                        </a>
                    </p>
                </div>
            </div>
            <!-- 这里是页面内容区  end -->
        </div>
        <!-- page 容器  end -->
    </body>
    <script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
    <script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-city-picker.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/module/public.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.all.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
