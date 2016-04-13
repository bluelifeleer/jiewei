<?php
include_once('./Common/public.php');
$memberInfo = array();
if(isset($_GET['HTTP_TOKEN']) &&  isset($_COOKIE['sso_session'])){
	header('location:member.php');
}
$res = getRedis($_COOKIE['sso_session'],'hgetall');
if(!isset($res['_userid']))header('location:login.php');
	
	$userinfo = json_decode(file_get_contents('http://api.zj3w.net/account/index/memberInfo/userid/'.$res['_userid']),true);
	//var_dump($userinfo);exit;
	$memberInfo = json_decode($userinfo['data'],true);
	$memberInfo['avarat'] = $memberInfo['avarat']?$memberInfo['avarat']:'/sources/images/default_50x50.jpg';
	//NICK NAME
	if($memberInfo['nickname'] == ''){
       $nickname = $memberInfo['phone'];
    }else{
       $nickname = htmlspecialchars($memberInfo['nickname']);
    }
    if(strlen($nickname) > 10){
    	$nickname = '<font size="4rem">'.$nickname.'<font>';		
    }
    if(strlen($nickname) > 12){
    	$nickname = '<font size="3rem">'.$nickname.'<font>';		
    }
    if(strlen($nickname) > 14){
    	$nickname = '<font size="2.5rem">'.$nickname.'<font>';		
    }
    if(strlen($nickname) > 16){
    	$nickname = '<font size="2rem">'.$nickname.'<font>';		
    }
	//ICON
    switch($memberInfo['levels']) {
        case 1:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe672;</i>';
          $levelsName = '新人';
          break;
        case 2:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe673;</i>';
          $levelsName = '主管';
          break;
        case 3:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe674;</i>';
          $levelsName = '经理';
          break;
        case 4:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe675;</i>';
          $levelsName = '总监';
          break;
        case 5:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe676;</i>';
          $levelsName = '首席总监';
          break;
        case 6:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe677;</i>';
          $levelsName = '总经理';
          break;
        case 7:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe678;</i>';
          $levelsName = '总经理';
          break;
        default:
          $levels = '<i class="iconfont cCB1408" style="font-size:1.5rem;">&#xe671;</i>';

          $levelsName = '普通会员';
          break;
      }

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
		<div class="page" id="page-member">
			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<!--a class="pull-left back" href="index.php">
					<i class="icon iconfont mar0 white">&#xe64c;</i>
				</a-->
				<h1 class="title">个人中心</h1>
					<span id="loginout-but" class="pull-right h56 lh56 marl0 marr10 white" style="position:absolute;right:0;top:0;z-index:99999;cursor:pointer;">退出</span>
			</header>

			<!-- 工具栏 -->
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
			<div class="content">
				<div class="card mar0 pos-r h140">
					<img class="pos-a w100b h100" src="/sources/images/member_bg.jpg" alt="">
					<div id="user-info" class="pos-a padl10 w100b box_bor" style="top:25px;overflow: hidden;">
						<a class="external" href="userinfo.php">
							<div class="w50 h50 fll pos-r" style="overflow:hidden;">
								<img class="block w50 h50 bor1 bcfff borrad50 avarat" src="<?php echo $memberInfo['avarat']?>" alt="" />
							</div>
							<div class="fll padl10 h50 fs10 black nickname" style="line-height:50px;"><?php echo $nickname?></div>
						</a>
						<div class="fll black" style="line-height:50px;">
							<a class="location-but" href="qr.php">
								<i class="iconfont fs12 cfa6a0b marl10">&#xe638;</i>
							</a>
						</div>
						<div class="flr txalr w60 h30 mart10 is-vip " style="opacity:0.6;line-height:30px;font-size:1.5rem;"><?php echo $levels;?></div>
					</div>
					<div class="pos-a w100b h40" style="bottom:0;">
						<div class="w100 pad10 fll"><img class="w100b" src="/sources/images/tt.png" alt=""></div>
						<div style="line-height:40px;">
							<marquee style="position:absolute;width:70%;"  direction="left" scrolldelay="50" loop="-1" scrollamount="1.5">恭贺"云兆平台"正式上线！成功开通店铺，好礼相送！客服服务热线4008-477-007</marquee>
						</div>

					</div>
				</div>
				<div class="list-block mart10">
					<ul>
						<li class="item-content borb1 bce6" style="padding:0;">
							<div class="w100b row no-gutter txac fs07">
								<div class="col-20"><a class="c666 external" href="order.php?order_type=1">待付款</a></div>
								<div class="col-20"><a class="c666 external" href="order.php?order_type=2">待发货</a></div>
								<div class="col-20"><a class="c666 external" href="order.php?order_type=3">待收货</a></div>
								<div class="col-20"><a class="c666 external" href="order.php?order_type=4">已完成</a></div>
								<div class="col-20"><a class="c666 external" href="order.php?order_type=6">售后</a></div>
							</div>
						</li>
						<a class="c666" href="balance.php">
							<li class="item-content borb1 bce6" style="overflow: hidden;">
								<span class="block col-50 txal">我的钱包</span>
								<span class="block col-50 txar"><i class="icon iconfont fs09 cccc">&#xe600;</i></span>
							</li>
						</a>
						<a class="c666" href="account_list.php">
							<li class="item-content borb1 bce6" style="overflow: hidden;">
								<span class="block col-50 txal">我的账单</span>
								<span class="block col-50 txal"><i class="icon iconfont fs09 cccc">&#xe600;</i></span>
							</li>
						</a>
						<a class="c666" href="safety.php">
							<li id="safety-link-block" class="item-content borb1 bce6" style="overflow: hidden;">
								<span class="block col-50 txal">帐号安全</span>
								<span class="block col-50 txal"><i class="icon iconfont fs09 cccc">&#xe600;</i></span>
							</li>
						</a>
						<a class="c666" href="address.php">
							<li class="item-content borb1 bce6" style="overflow: hidden;">
								<span class="block col-50 txal">收货地址</span>
								<span class="block col-50 txal"><i class="icon iconfont fs09 cccc">&#xe600;</i></span>
							</li>
						</a>
							<!--li class="item-content borb1 bce6" id="loginout-but" style="cursor:pointer;">
								<div class="fll w40 iconfont mar0" style="color:#0894EC;">&#xe639;</div>
							</li-->
					</ul>
				</div>
				<div class="w100b row no-gutter txac fs07 padl20 padr20">
					<div class="col-33">
						<a class="c666" href="achievement.php?type=myBonus">
							<i class="icon iconfont fs25 marauto cff552e">&#xe67e;</i>
							<div>我的业绩</div>
						</a>
					</div>
					<div class="col-33">
						<a class="c666" href="achievement.php?type=teamBonus">
							<i class="icon iconfont fs25 marauto cfd5745">&#xe67f;</i>
							<div>团队业绩</div>
						</a>
					</div>
					<!-- <div class="col-33">
						<a class="c666" href="family.php">
							<i class="icon iconfont fs25 marauto cff9845">&#xe67b;</i>
							<div>我的家族</div>
						</a>
					</div>
					<div class="col-33">
						<a class="c666" href="collection.php">
							<i class="icon iconfont fs25 marauto cff9845" style="">&#xe67c;</i>
							<div>收藏夹</div>
						</a>
					</div>
					<div class="col-33">
						<a class="c666" href="bargain.php">
							<i class="icon iconfont fs25 marauto cfd5745">&#xe67a;</i>
							<div>特价商品</div>
						</a>
					</div> -->
					<div class="col-33">
						<a class="c666" href="letter_box.php">
							<i class="icon iconfont fs25 marauto cff9845">&#xe679;</i>
							<div>信报箱</div>
						</a>
					</div>
					<div class="shop-block col-33" >
						<div id="shop-to-link">
							<i class="icon iconfont fs25 marauto cCB1408">&#xe67d;</i>
							<div class="shop">我的店铺</div>
						</div>
					</div>
					<div class="col-33">
						<a class="c666" id="recharge">
							<i class="icon iconfont fs25 marauto cCB1408">&#xe659;</i>
							<div>帐户充值</div>
						</a>
					</div>
					<div class="col-33">
						<a class="c666" href="present_manner.php">
							<i class="icon iconfont fs25 marauto cCB1408">&#xe68e;</i>
							<div>帐户提现</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- popup, panel 等放在这里 -->
		<div class="panel-overlay"></div>
		<!-- Left Panel with Reveal effect -->
		<div class="panel panel-left panel-reveal">
			<div class="content-block">
				<p>这是一个侧栏</p>
				<p></p>
				<!-- Click on link with "close-panel" class will close panel -->
				<p><a href="#" class="close-panel">关闭</a></p>
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
