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
        <link rel="stylesheet" href="/sources/css/demos.css"/>
        <link rel="stylesheet" href="/sources/css/add.css"/>
    </head>
    <body>
        <!-- page 容器 -->
        <div class="page" id="page-shop-manager">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <a class="pull-left back" data-no-cache="true" href="member.php">
                    <i class="icon iconfont mar0 white">
                        &#xe61b;
                    </i>
                </a>
                <h1 class="title">
                    店铺管理
                </h1>
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
            <!-- 这里是页面内容区 -->
            <div class="content bgEEEEEE">
                <div class="w100b marb10 bgfff">
                    <div class="w100b h90 borb1 bcc1c1c1 ovfh">
                        <div class="fll w35b h90">
                            <img src="" class="w60 h60 borrad50 mart20 marl20 avatar" />
                        </div>
                        <div class="fll w65b h90">
                            <p class="pad0 mar0 h30 lh30 fs10 mart20" >
                                <span id="shopname"></span>
                                <a class="location-but " href="shop_qr.php">
                                    <i class="icon iconfont fs10 c666 marl10" style="line-height:0.2rem;">&#xe638;</i>
                                </a>
                            </p>
                            <p class="pad0 mar0 h30 lh30">
                                <span class="inlineblock w80 h20 lh20 txac fs05 white bgDCDEE1 borrad5 cCB1408">
                                    代理商
                                </span>
                                <!-- <span class="inlineblock w80 h20 lh20 txac fs05 white bgDCDEE1 borrad5 marl20 c595C60">
                                    非供货商
                                </span> -->
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w100b bgfff">
                     <a href="javascript:void(0);" id="toShopIndex" class="external  c3D4145">
                        <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                          
                                <span class="marl20">
                                店铺首页
                                </span>
                                <span class="iconfont-right flr iconfont marr10">
                                    &#xe600;
                                </span>
                            
                        </div>
                    </a>
                     <a href="javascript:void(0);" id="toShopMsg" class="c3D4145">
                        <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                       
                            <span class="marl20">
                            店铺消息
                            </span>
                            <span class="iconfont-right flr iconfont marr10">
                                &#xe600;
                            </span>
                       
                         </div>
                      </a>
                    
                      <a href="apply_shop_manager_set.php" class="c3D4145">
                         <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                      
                            <span class="marl20">
                            店铺资料
                            </span>
                            <span class="iconfont-right flr iconfont marr10">
                                &#xe600;
                            </span>
                        
                         </div>
                        </a>
                     <a href="shop_product_classify.php" class="c3D4145">
                         <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                       
                            <span class="marl20">
                            商品管理
                            </span>
                            <span class="iconfont-right flr iconfont marr10">
                                &#xe600;
                            </span>
                       
                        </div>
                     </a>
                    <a href="shop_order.php" class="c3D4145">
                        <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                      
                            <span class="marl20">
                            订单管理
                            </span>
                            <span class="iconfont-right flr iconfont marr10">
                                &#xe600;
                            </span>
                       
                      </div>
                     </a>
                     <a href="shop_category_manage.php" class="c3D4145">
                       <div class="edit-shop-info-title w100b h50 lh50 borb1 bcc1c1c1">
                       
                            <span class="marl20">
                            栏目管理
                            </span>
                            <span class="iconfont-right flr iconfont marr10">
                                &#xe600;
                            </span>
                        
                      </div>
                    </a>

                    
                </div>
                <!-- <div class="w100b h50 lh50 bgfff">
                    <span class="marl20">
                        申请成为供货商
                    </span>
                    <span class="flr iconfont marr10">
                        &#xe63d;
                    </span>
                </div> -->
            </div>
        </div>
        <!-- popup, panel 等放在这里 -->
        <div class="panel-overlay"></div>
        <!-- Left Panel with Reveal effect -->
        <div class="panel panel-left panel-reveal bgfff">
            <div class="content-block">
                <div class="w100b h50 lh50">
                    <a href="javascript:void(0);" class="external">
                        <i class="iconfont mar0 marr10">
                            &#xe639;
                        </i>
                        退出登录
                    </a>
                    <a href="javascript:void(0);" class="external marl10">
                        <i class="iconfont mar0 marr10">
                            &#xe637;
                        </i>
                        设置
                    </a>
                </div>
                <!-- Click on link with "close-panel" class will close panel -->
                <p>
                    <a href="#" class="close-panel">
                        关闭
                    </a>
                </p>
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
