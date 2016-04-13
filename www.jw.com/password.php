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
        <div class="page" id="page-password">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <h1 class="title">设置密码</h1>
                <a class="pull-left back " href="register.php">
                <i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
                </a>
            </header>
            <div class="content">
                <div class="page-login">
                    <div class="list-block mar15 borl1 borr1 bce6">
                        <ul>
                            <li class="borb1 bce6">
                                <input id="pasd" type="password" placeholder="密码">
                            </li>
                            <li>
                                <input id="confirm-pasd" type="password" placeholder="确认密码">
                            </li>
                        </ul>
                    </div>
                    <div class="content-block mar15 pad0">
                        <p class="mar0 mart10"><a id="submit-but" class="external button button-big button-fill bgfa6a0b " href="javascript:void(0);">提交</a></p>
                    </div>
                    <p class="block w100b h60 lh60 txac ftwghtb"><i class="inlineblock h50 lh50 mar0 iconfont cCB1408 fs08 padr10">&#xe66e;</i><a class="inlineblock h50 lh50 cCB1408 fs08 external" href="login.php">已有帐号？直接登录</a></p>
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
