<?php

/**
 * 描述该文件的主要功能
 * @Author: 刘波
 * @description: 后台首页
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2016-03-26 10:50:32
 */
include_once CORE_PATH . 'library/wechat/lanewechat.php';
class indexController extends Controller {
	//Action白名单
	public $initphp_list = array(
		'setMenu',
		'weixinJs',
		'test'
	);
	public function test(){
		echo 'hello';
	}
	/**
	 * @return [type] [description]
	 */
	public function init() {
		//初始化微信类
		$wechat = new LaneWeChat\Core\Wechat(WECHAT_TOKEN, TRUE);
		//首次使用需要注视掉下面这1行（26行），并打开最后一行（29行）
		echo $wechat->run();
		//首次使用需要打开下面这一行（29行），并且注释掉上面1行（26行）。本行用来验证URL
		// $wechat->checkSignature();
	}

	public function setMenu(){
		//设置菜单
		$menuList = array(
		    array('id'=>'1', 'pid'=>'',  'name'=>'走进云兆', 'type'=>'view', 'code'=>'http://www.zj3w.net'),
		    array('id'=>'2', 'pid'=>'',  'name'=>'商品栏目', 'type'=>'view', 'code'=>'http://www.zj3w.net/product_categories.html?catid=more'),
		    array('id'=>'3', 'pid'=>'',  'name'=>'我的服务', 'type'=>'', 'code'=>'key_3'),
		    array('id'=>'4', 'pid'=>'3', 'name'=>'推荐开店', 'type'=>'view', 'code'=>'http://mp.weixin.qq.com/s?__biz=MzI5NjEwMTM2Ng==&mid=402662329&idx=3&sn=b1af223ab9ec7524941723507a9a1e5a#rd'),
		    array('id'=>'5', 'pid'=>'3', 'name'=>'购物&开店指南', 'type'=>'view', 'code'=>'http://b.eqxiu.com/s/mBmsknou?eqrcode=1&from=singlemessage&isappinstalled=0'),
		    array('id'=>'6', 'pid'=>'3', 'name'=>'客服&售后','type'=>'view', 'code'=>'http://mp.weixin.qq.com/s?__biz=MzI5NjEwMTM2Ng==&mid=402662329&idx=2&sn=e19e88a44578f5be90cfaaf500e8d401#rd'),
            array('id'=>'7', 'pid'=>'3', 'name'=>'常见问题', 'type'=>'view', 'code'=>'http://mp.weixin.qq.com/s?__biz=MzI5NjEwMTM2Ng==&mid=402662329&idx=1&sn=c1208756cafb75e6cfe5917602738b36#rd'),
            array('id'=>'8', 'pid'=>'3', 'name'=>'关于我们', 'type'=>'view', 'code'=>'http://mp.weixin.qq.com/s?__biz=MzI5NjEwMTM2Ng==&mid=402662329&idx=4&sn=eda42e34a5f05a216f8e6a76ac2e19b8#rd'),
		    
		);
		\LaneWeChat\Core\Menu::setMenu($menuList);
	}

	public function weixinJs(){
		$url = $_GET['url'];
		
		$jssdk = $this->getLibrary('JSSDK');
		
		$jssdk->init("wx34fdd0d60e7d4514", "428144f61ac3753970c581c781e6d9e5",$url);
		
		$signPackage = $jssdk->GetSignPackage();
		$tmp=json_encode(array ('appId'=>$signPackage["appId"],'timestamp'=>$signPackage["timestamp"],'nonceStr'=>$signPackage["nonceStr"],'signature'=>$signPackage["signature"],'url'=>$signPackage["url"]));
		$callback = $_GET['callback'];
	
		echo $callback.'('.$tmp.')';
		exit;
	}

}