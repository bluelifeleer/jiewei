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
		<div class="page" id="page-add-address">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<a class="pull-left back" href="address.php">
					<i class="icon iconfont fs13 mar0 white">&#xe61b;</i>
				</a>
				<h1 class="title">添加收获地址</h1>
			</header>
			<!-- 这里是页面内容区 -->
			<div class="content">
                <div class="list-block">
                    <ul>
                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                                <div class="col-20 input_title">收货人</div>
                                <div class="col-80 input_text">
                                    <input type="text" name="username" id="username" placeholder="" />
                                </div>
                            </div>
                        </li>
                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                                <div class="col-20 input_title">手机号码</div>
                                <div class="col-80 input_text">
                                    <input type="text" name="mobile" id="mobile" placeholder="" />
                                </div>
                            </div>
                        </li>
                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                                <div class="col-20 input_title">邮政编码</div>
                                <div class="col-80 input_text">
                                    <input type="text" name="code" id="code" placeholder="" />
                                </div>
                            </div>
                        </li>

                            <!-- <div class="list-block"> -->
                                <!-- Text inputs -->
                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                              <div class="col-20 input_title">省市区</div>
                              <div class="col-80 input_text item-input">
                                <input type="text" placeholder="" id='city-picker'/>
                              </div>
                            </div>
                        </li>
                            <!-- </div> -->

                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                                <div class="col-20 input_title">详细地址</div>
                                <div class="col-80 input_text">
                                    <textarea name="daddress" id="daddress" cols="30" rows="10" style="font-size:0.7rem;"></textarea>
                                </div>
                            </div>
                        </li>
                        <li class="pad10 padl15 padr15 borb1 bce6">
                            <div class="row no-gutter input_c padt5 padb5 padr5">
                                <div class="col-20 input_title">是否默认</div>
                                <div class="col-80 input_text">
                                    <label class="label-switch flr">
                                        <input type="checkbox" name="default" id="box1"  value="1">
                                        <div class="checkbox"></div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li class="pad10 padl15 padr15 borb1 bce6" style="border:none;">
							<div id="putaddress" href="javascript:void(0);" class="external block w90b marauto h50 lh50 borrad6 txac white bgFB1608">确定</div>
						</li>
                    </ul>
                </div>
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
