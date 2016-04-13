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
        <div class="page" id="page-add-category">
            <header class="bar bar-nav">
                <a class="pull-left back back" href="apply_shop.php">
                    <i class="icon iconfont mar0 white fs13">&#xe61b;</i>
                </a>
                <h1 class="title">添加栏目</h1>

            </header>

            <!-- 工具栏 -->
      			<nav class="bar bar-tab">
      				<span class="toools-bar-but tab-item" style="cursor:pointer;" id="shop-index" data-but-type="index">
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

            <!--这里是内容区-->
            <div class="content bgfff">
                <div class="padl5 padr5" id="classify">
                    <div class="w100b h50 lh50 borb1 bce6">
                        <span class="icon icon-form-name">请添加商品分类:</span>
                        <div class="flr txar w40b h50 lh50">
                            <a href="#" id="fenlei" class="">添加分类
                                </a>
                        </div>
                    </div>


                    <div data-parentid="0" data-catid="1"  id="category_1" class="add_category w100b h50 lh50 borb1 bce6" style="display:;">
                        <div class="padl20 w100b h40 mart5 flr">
                        分类：　<input type="text" class="add-create-cate bor0 w40b" data-parentid="0" value="" data-catid="1" placeholder="请编辑类目名称"><a href="#" data-catid="1" class="icon iconfont p_cate external c666">&#xe603;</a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div data-parentid="0" data-catid="2"  id="category_2" class="add_category w100b h50 lh50 borb1 bce6" style="display:;">
                        <div class="padl20 w100b h40 mart5 flr">
                            分类：　<input type="text" class="add-create-cate bor0 w40b" data-parentid="0" value="" data-catid="2" placeholder="请编辑类目名称"><a href="#" data-catid="2"  class="icon iconfont p_cate external c666">&#xe603;</a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div data-parentid="0" data-catid="3"  id="category_3" class="add_category w100b h50 lh50 borb1 bce6" style="display:;">
                        <div class="padl20 w100b h40 mart5 flr">
                            分类：　<input type="text" class="add-create-cate bor0 w40b" data-parentid="0" value=""  data-catid="3" placeholder="请编辑类目名称"><a href="# " data-catid="3"  class="icon iconfont p_cate external c666">&#xe603;</a>
                            <!-- <a href="#" class="marr10 modify">修改</a> -->
                            <!-- <a href="#" class="marr10 del">删除</a> -->
                        </div>
                        <div class="clear"></div>
                    </div>

                    <!-- <div class="w100b h50 lh50 borb1 bce6">
                        <div class="padl20 w100b h40 mart5 flr">
                            <input type="text" class="bor0" placeholder="请在这里填写您的分类">
                            <div class="flr txar w40b h50 lh50">
                                <a href="#" type="text" class="">添加子分类
                                </a>
                                <a href="#" class="marr10">
                                修改
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div> -->
                </div>
                <a id="next-but" href="javascript:void(0);" class="external block w80b marauto h50 lh50 txac white bgCB1408 mart20 borrad5">下一步</a>
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
