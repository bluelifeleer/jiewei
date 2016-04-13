<?php

/**
 * 描述该文件的主要功能
 * @Author: 刘波
 * @description: 后台首页
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2016-01-14 17:25:37
 */
include_once CORE_PATH . 'library/WxPay.JsApiPay.init.php';
include_once CORE_PATH . 'library/wxpay/WxPay.Notify.php';
include_once CORE_PATH . 'library/WxPay.notify.init.php';
class indexController extends Controller {
	//Action白名单
	public $initphp_list = array(
		'code',
		'vpay',
		'notifiy',
		
	);
	
	/**
	 * @return [type] [description]
	 */
	public function init() {
		echo 'API is Ready';
	}
	// 获取微信openid
	public function code(){
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		$siteurl = array(
			1=>'http://www.zj3w.net/recharge.php',
			2=>'http://www.zj3w.net',
			3=>'http://www.zj3w.net/trade_pay.php',
			4=>'http://www.zj3w.net/open_shop.php'
			);

		$fields = array('from','order_id');

    	$data_gp = $this->controller->get_gp($fields);
    	$data = array_filter($data_gp);
    	if($data['from'] == 3){
    		$url =  $siteurl[$data['from']].'?openid='.$openId.'&order_id='.$data['order_id'];
    		
    	}else{
    		$url =  $siteurl[$data['from']].'?openid='.$openId;

    	}
    	
    	header('Location: '.$url);
		// echo $url;
		exit();
	}
	// 调用微信支付
	public function vpay(){
		$fields = array('fee','openid');
    	$data_gp = $this->controller->get_gp($fields);
    	$datagp = array_filter($data_gp);
    	$fee = $datagp['fee']*100;
    	$openId = $datagp['openid'];
		$tools = new JsApiPay();
		$input = new WxPayUnifiedOrder();
		$input->SetBody("云兆商城");
		$input->SetAttach("云兆商城");
		// $create_sn = WxPayConfig::MCHID . date("YmdHis");

		$create_sn =  strtoupper(md5(create_sn()));

		$input->SetOut_trade_no($create_sn);
		$input->SetTotal_fee($fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("云兆商城");
		$input->SetNotify_url("http://api.zj3w.net/wxpay/index/notifiy");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);


		/**完成支付的一个站位***/
		$userid = $this->getUtil('session')->get('_userid');
		$username = $this->getUtil('session')->get('_nickname');
		// var_dump($this->getUtil('session')->getAll());exit;
		$status = InitPHP::getRemoteService('recharge', 'createwxorder', array($userid, $username, $fee/100, $create_sn));

		if ($status['code'] == 0) {
		
		
			$jsApiParameters = $tools->GetJsApiParameters($order);
			if(isset($jsApiParameters['return_code']) && $jsApiParameters['return_code'] == 'FAIL'){
				// 获取失败
				$data['code'] = 1;
				$data['data']['msg'] = $jsApiParameters['return_msg'];
			}else{
				// 获取成功
				$data['code'] = 0;
				$data['data'] = $jsApiParameters;
			}

		}else{
				$data['code'] = 1;
				$data['data']['msg'] = '订单插入失败';
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit();

	}
	// 微信支付回调
	public function notifiy(){
		$notify = new PayNotifyCallBack();
		// echo  $notify->test;
		// var_dump($notify);
		$notify->Handle(false);
		// echo 1;
	}
	

}