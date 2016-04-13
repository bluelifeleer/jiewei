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
        <link rel="stylesheet" href="/sources/css/add.css">
    </head>
    <body>
        <!-- page 容器 -->
        <div class="page" id="page-shop-order-delivery">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <h1 class="title" id="order-page-title">发货</h1>
                <a class="pull-left back " href="shop_order.php">
                    <i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
                </a>
            </header>
            <!-- 工具栏 -->
            <nav class="bar bar-tab">
                <span class="toools-bar-but tab-item" style="cursor:pointer;" id="shop-index" data-but-type="index">
                    <i class="icon iconfont">&#xe640;</i>
                    <span class="tab-label">首页</span>
                </span>
                <span class="toools-bar-but tab-item" style="cursor:pointer;">
                    <i class="icon iconfont">&#xe684;</i>
                <span class="tab-label">云兆</span>
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
            <div class="content bgEEEEEE">
             <div class="content-block-title" style="margin-top: .75rem;">填写发货信息</div>

             <form action="#" method="post">
                 
             </form>
             <div class="list-block">
                 
                  <ul>
                    <!--  shipping_id 物流方式id   shipping_name  物流名称 shipping_no 物流单号，如快递单号（圆通、EMS等） shipping_fee 物流费用 shipping_time 发货时间-->
                       
                        <li>
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">物流方式</div>
                              <div class="item-input w80b">
                                <input type="text" class="shipping_name" style="font-size: 0.75rem;color: #999;"  placeholder="如：顺丰">
                              </div>
                            </div>
                          </div>
                        </li>

                         <li>
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">物流单号</div>
                              <div class="item-input w80b">
                                <input type="text" class="shipping_no" style="font-size: 0.75rem;color: #999;"  >
                              </div>
                            </div>
                          </div>
                        </li>
                      <!--    <li>
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">物流费用</div>
                              <div class="item-input w80b">
                                <input type="text" class="shipping_fee" style="font-size: 0.75rem;color: #999;"  >
                              </div>
                            </div>
                          </div>
                        </li> -->
                         <li>
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">发货时间</div>
                              <div class="item-input w80b">
                                <input type="text"  name="shipping_time"  class="shipping_time"   style="font-size: 0.75rem;color: #999;"  >
                              </div>
                            </div>
                          </div>
                        </li>


                    </ul>
                    <div class="content-block">
                      <div class="row">
                        <div class="w50b" style="margin: 10px auto;"><span class="button input-product-delivery-submit button-fill button-success">提交</span></div>
                      </div>
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
