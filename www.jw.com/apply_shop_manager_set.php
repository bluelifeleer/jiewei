<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
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
        <link rel="stylesheet" href="/sources/css/webuploader.css">
        <link rel="stylesheet" href="/sources/css/demos.css">
        <link rel="stylesheet" href="/sources/css/add.css">
    </head>
    <body>
        <div class="page" id="page-shop-manager-set">


         <style type="text/css">
          
          .webuploader-container {
            position: relative;
          }
          .webuploader-element-invisible {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
              clip: rect(1px,1px,1px,1px);
          }
          .webuploader-pick {
            position: relative;
            display: inline-block;
            cursor: pointer;
            background: #00b7ee;
            padding: 15px 20px;
            color: #fff;
            text-align: center;
            border-radius: 3px;
            overflow: hidden;/*
            width:176px;
            height:176px;*/
            opacity:0;
            filter:alpha(opacity=0);
          }
          .webuploader-pick-hover {
            background: #00a2d4;
          }

          .webuploader-pick-disable {
            opacity: 0.6;
            pointer-events:none;
          }
          #filePicker{
            position: absolute;
            top:0;
            right:0;
            opacity: 0;
            height: 45px;
          }
        </style>
        
            <header class="bar bar-nav">
                <a class="pull-left back" href="shop_manager.php">
                    <i class="icon iconfont mar0 white">&#xe61b;</i>
                </a>
                <h1 class="title">商铺设置</h1>
                <!-- <a class="pull-right open-panel" href="javascript:void(0);">
                    <i class="icon iconfont marr0 marl10 white">&#xe605;</i>
                </a>
                <a class="pull-right external" href="javascript:void(0);">
                    <i class="icon iconfont mar0 white">&#xe604;</i>
                </a> -->
            </header>
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
              <span class="toools-bar-but tab-item active" data-but-type="member" style="cursor:pointer;">
                <i class="icon iconfont">&#xe65e;</i>
                <span class="tab-label">我的</span>
              </span>
            </nav>
            <!--这里是内容区-->
            <div class="content bgfff">
                <div class="list-block fs07">
                    <ul>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">店铺名称</div>
                                <div class="item-input">
                                    <input type="text" name="name" id="name" placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">微信号</div>
                                <div class="item-input">
                                    <input type="text" name="wechat" id="wechat" placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">qq号</div>
                                <div class="item-input">
                                    <input type="text" name="qq" id="qq" placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">客服电话</div>
                                <div class="item-input">
                                    <input type="text" name="phone" id="phone" placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">店铺地址</div>
                                <div class="item-input">
                                    <input type="text" id='city-picker' placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">店主名称</div>
                                <div class="item-input">
                                    <input type="text" name="username" id="username" placeholder="">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-inner" style="padding-left:0.75rem;">
                                <div class="item-title label w20b">店铺LOGO</div>
                                <div class="item-input">
                                    <span id="avarat-block" class="fll block w40 h40 flr">
                                        <img class="w40 h40 borrad50 bor2 bcfff avarat" src="/sources/images/shop_50x50.png" alt="" />
                                    </span>
                                    <div id="shop-uploader" class="w100b h50" style="position:absolute;left:0;top:0;z-index:1100"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="submit-shop" class="block w80b marauto h50 lh50 txac white bgCB1408 mart20 borrad5">提交</div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
    <script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-city-picker.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/module/public.js"></script>
    <script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
    
    <script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>

    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.all.js"> </script>

    <script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/lang/zh-cn/zh-cn.js"></script>
   <!--  <script type="text/javascript" src="/sources/js/module/shopInfoUpdate.js" charset="utf-8"></script> -->
     <script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
   <!--  <script type="text/javascript">
        $(function(){
             'use strict';
             $.init();
        });
    </script> -->
</html>
