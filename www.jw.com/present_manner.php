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
        <div class="page" id="page-present-manner">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <a class="pull-left back" href="member.php">
                    <i class="icon iconfont fs16 mar0 white">&#xe61b;</i>
                </a>
                <h1 class="title">余额提现</h1>
                <a class="pull-right" href="present_manner_list.php">
                    <i class="icon iconfont fs10 mar0 white">提现记录</i>
                </a>
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
            <!--金额显示-->
            

            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="row no-gutter bgfff padl0 padr0 bor1 bce6">
                    <div class="col-33 h100">
                        <span class="block h50 lh50 txac fs12  cFF4400 Damount">
                            0
                        </span>
                        <span class="block h30 lh30 txac fs06  teamtitle">
                            可使用余额
                        </span>
                    </div>
                    <div class="col-33 h100">
                        <span class="block h50 lh50 txac fs12  cFF4400 Mamount">
                            0
                        </span>
                        <span class="block h30 lh30 txac fs06  teamtitle">
                            可提现金额
                        </span>
                    </div>
                    <div class="col-33 h100">
                        <span class="block h50 lh50 txac fs12  cFF4400 amount">
                            0
                        </span>
                        <span class="block h30 lh30 txac fs06  teamtitle">
                            申请中金额
                        </span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="card" style="display:block">
                  <div class="card-content">
                    <div class="card-content-inner ovfh">
                      <div class="w100b h40 lh40 borb1 bcc1c1c1 ovfh"><span class="block fll w30b h40 lh40">提现金额：</span><input type="text" value="" id="input-total-but" class="total-title block fll w70b h40 lh40 bor0" placeholder="建议金额大于1元"></div>
                    </div>
                  </div>
                </div>
                <div class="card select-but" data-index='1' data-is-open="false">
                  <div class="card-content">
                    <div class="card-content-inner ovfh h50 lh50 pad0">
                        <span class="block w30b fll h50 lh50 marl20">提现方式：</span>
                        <span id="pay-type" data-pay-type-value="2" class="block w50b fll h50 lh50">银行卡转账(默认)</span>
                        <span class="block w08b mar0 iconfont flr mar option-status-icon">&#xe600;</span>
                    </div>
                  </div>
                </div>
                <div class="card rechager-content-block" style="display:none">
                  <div class="card-content">
                    <div class="card-content-inner ovfh">
                        <ul >
                            <li class="open-choose-address-popup">
                                <!-- <label class="label-checkbox item-content padl6" style="padding-left: 6px; "> -->
                                    <!-- <div class="item-media"><i class="icon iconfont mar0" title="选择收货地址" alt="选择收货地址"></i></div> -->
                                    <a href="present_record.php">
                                        <div class="record-info-list item-inner" style="margin-left: 6px; ">
                                            <div class="item-title w100b" >
                                                <div class="account_name">账户名</div>
                                                <div class="bank_name">银行名称</div>
                                                <div class="card_number">银行卡号</div>
                                                <div class="contact_way">联系电话</div>
                                            </div>
                                        </div>
                                    </a>
                                <!-- </label> -->
                            </li>
                            <input type="hidden"  id="submit-present-manner" name="record_id" value="">
                        </ul>
                    </div>
                  </div>
                </div>
                <div class="w95b h50 lh50 txalc white marauto mart20 bgCB1408 borrad5" id="submit-but">提现</div>
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
<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
