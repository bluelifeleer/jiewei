<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html lang="en">
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
        <link rel="stylesheet" href="/sources/css/add.css">
        <link rel="stylesheet" href="/sources/css/webuploader.css">
    </head>
    <body>
        <div class="page" id="page-category-manage">
            <header class="bar bar-nav">
                <a class="pull-left back" href="shop_manager.php">
                    <i class="icon iconfont mar0 white fs13">&#xe61b;</i>
                </a>
                <h1 class="title">修改栏目</h1>
                <a class="pull-right" href="shop_category_add.php">
                    <h1 class="title">添加栏目</i>
                </a>
            </header>

            <!-- 工具栏 -->

            <!--这里是内容区-->
            <div class="content bgfff">
                <div class="padl5 padr5" id="classify">
                    <div class="w100b h50 lh50 borb1 bce6">
                        <span class="icon icon-form-name">请添加您的商品栏目:</span>
                    </div>
                </div>
                <!--显示栏目列表-->
                <div class="padl5 padr5" id="cate-list-block">

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
