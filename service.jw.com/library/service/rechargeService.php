<?php
class rechargeService extends Service {
	/**
	 * 充值服务系统
	 * @author 李鹏
	 * @date 2016-02-18
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * 用户充值
	 * @param  [string] $userid        [用户ID]
	 * @param  [string] $username      [用户名]
	 * @param  [integer] $payType  [支付类型]
	 * @param  [string] $rechargeTotal [充值金额]
	 * @return [integer||blooean] $addID [充值成功后的状态]
	 * @autohr 李鹏
	 * @date 2016-02-18
	 */
	public function create($userid, $username, $payType, $rechargeTotal) {

		$payAccount = ''; //支付帐号
		$pay_status = 1; //支付状态
		$timer = time(); //支付时间
		$payNo = strtoupper(md5(create_sn())); //支付单号

		//开启事务
		InitPHP::getDao('pay')->transaction_start();

		/**
		 * 调用微信息接口
		 */
		//codeing......

		//支付数据
		$payData = array(
			'pay_no' => $payNo,
			'userid' => $userid,
			'username' => $username,
			'pay_type' => $payType,
			'pay_account' => $payAccount,
			'total' => $rechargeTotal,
			'pay_status' => $pay_status,
			'create_time' => $timer,
			'pay_time' => $timer,
		);

		//获取用户钱包中原有的余额
		$sumAmount = 0;
		$getOriginalWallet = InitPHP::getDao('wallet')->get(array('userid' => $userid));
		$sumAmount = sprintf("%01.2f", (sprintf("%01.2f", $rechargeTotal) + sprintf("%01.2f", $getOriginalWallet['amount'])));
		$walletData = array(
			'amount' => $sumAmount,
		);

		//获取支付的信息
		$pay_name_text = '余额支付';
		$getPayment = InitPHP::getDao('payment')->get(array('pay_id' => intval($payType)));
		$pay_name_text = $getPayment['pay_name'];
		switch (intval($getPayment['pay_id'])) {
		case 2: //微信支付
			$payAccount = '';
			break;
		case 3: //支付宝支付
			$payAccount = '';
			break;
		default: //余额支付
			$payAccount = $payNo;
			break;
		}

		//消息数据
		$msgData = array(
			'to_userid' => $userid,
			'from_userid' => 1,
			'title' => '充值提醒消息',
			'contents' => htmlspecialchars('您于' . date('Y-m-d H:i:s', $timer) . '通过' . $pay_name_text . '充值' . sprintf("%01.2f", $rechargeTotal) . '元，支付帐号：' . $payAccount . '，总金额：' . $sumAmount . '，具体详情请到<a href="balance.html">我的钱包</a>查看'),
			'type' => 1,
			'is_read' => 0,
			'create_time' => $timer,
		);

		//资金往来记录
		$capitalLiquidData = array(
			'userid' => $userid,
			'shop_id' => '',
			'title' => $pay_name_text . '充值',
			'content' => $pay_name_text . '充值，充值金额：' . sprintf("%01.2f", $rechargeTotal) . '，支付帐号：' . $payAccount . '，总金额：' . $sumAmount,
			'amount' => sprintf("%01.2f", $rechargeTotal),
			'make' => '',
			'status' => 1,
			'type' => 1,
			'create_time' => $timer,
			'action' => 1,
		);

		//更新钱包数据
		$walletStatus = InitPHP::getDao('wallet')->update($walletData, array('userid' => $userid));
		//添加支付数据
		$payId = InitPHP::getDao('pay')->create($payData);
		//添加消息数据
		$msgId = InitPHP::getDao('message')->create($msgData);
		//添加资金流动数据
		$capitalLiquidId = InitPHP::getDao('capitalLiquid')->create($capitalLiquidData);

		if ($walletStatus && $payId > 0 && $msgId > 0 && $capitalLiquidId > 0) {
			//提交事务
			InitPHP::getDao('pay')->transaction_commit();

			return InitPHP::Encode(0, '充值成功', '', 1);
		} else {
			//关闭事务
			InitPHP::getDao('pay')->transaction_rollback();

			return InitPHP::Encode(1, '充值失败', '', 1);
		}
	}

	/**
	 * 创建微信充值订单
	 * @param  [string] $userid        [用户ID]
	 * @param  [string] $username      [用户名]
	 * @param  [integer] $payType  [支付类型]
	 * @param  [string] $rechargeTotal [充值金额]
	 * @return 
	 * @autohr 李昊
	 * @date 2016-03-10
	 */
	public function createwxorder($userid, $username, $rechargeTotal ,$payNo,$payType=2 ) {

		$payAccount = ''; //支付帐号
		$pay_status = 1; //支付状态  0：未支付，1：支付中，2：支付完成
		$timer = time(); //支付时间

		//开启事务

		/**
		 * 调用微信息接口
		 */
		//codeing......

		//支付数据
		$payData = array(
			'pay_no' => $payNo,
			'userid' => $userid,
			'username' => $username,
			'pay_type' => $payType,
			'pay_account' => $payAccount,
			'total' => $rechargeTotal,
			'pay_status' => $pay_status,
			'create_time' => $timer,
			'pay_time' => $timer,
		);
	
		// 添加支付订单
		$payId = InitPHP::getDao('pay')->create($payData);
		
		if(isset($payId) && intval($payId) >1){
			return array('code'=>0,'data'=>$payId);
		}else{
			return array('code'=>1,'data'=>'订单创建失败');

		}
		
	}
	/**
	 * 回调微信充值
	 * @param  [string] $userid        [用户ID]
	 * @param  [string] $username      [用户名]
	 * @param  [integer] $payType  [支付类型]
	 * @param  [string] $rechargeTotal [充值金额]
	 * @return 
	 * @autohr 李昊
	 * @date 2016-03-10
	 */
	public function notifiywxorder($payNo,$total){
		$where = array('pay_no' => $payNo,'pay_status' => 1);
		$orderinfo = InitPHP::getDao('pay')->get($where);

		$rechargeTotal = $orderinfo['total'];
		$userid = $orderinfo['userid'];
		$payAccount = ''; //支付帐号
		$pay_status = 2; //支付状态
		$payType = 2;	//支付类型
		$timer = time(); //支付时间

		//开启事务
		InitPHP::getDao('pay')->transaction_start();

		/**
		 * 调用微信息接口
		 */
		//codeing......

		//支付数据
		$payData = array(
			'pay_status' => $pay_status,
			'pay_time' => $timer,
		);

		$payWhere = array(
			'pay_status' => 1,
			'pay_no' => $payNo,
		);
		//获取用户钱包中原有的余额
		$sumAmount = 0;
		$getOriginalWallet = InitPHP::getDao('wallet')->get(array('userid' => $userid));
		$sumAmount = sprintf("%01.2f", (sprintf("%01.2f", $rechargeTotal) + sprintf("%01.2f", $getOriginalWallet['amount'])));
		$walletData = array(
			'amount' => $sumAmount,
		);

		//获取支付的信息
		$pay_name_text = '余额支付';
		$getPayment = InitPHP::getDao('payment')->get(array('pay_id' => intval($payType)));
		$pay_name_text = $getPayment['pay_name'];
		switch (intval($getPayment['pay_id'])) {
		case 2: //微信支付
			$payAccount = '';
			break;
		case 3: //支付宝支付
			$payAccount = '';
			break;
		default: //余额支付
			$payAccount = $payNo;
			break;
		}

		//消息数据
		$msgData = array(
			'to_userid' => $userid,
			'from_userid' => 1,
			'title' => '充值提醒消息',
			'contents' => htmlspecialchars('您于' . date('Y-m-d H:i:s', $timer) . '通过' . $pay_name_text . '充值' . sprintf("%01.2f", $rechargeTotal) . '元，支付帐号：' . $payAccount . '，总金额：' . $sumAmount . '，具体详情请到<a href="balance.html">我的钱包</a>查看'),
			'type' => 1,
			'is_read' => 0,
			'create_time' => $timer,
		);

		//资金往来记录
		$capitalLiquidData = array(
			'userid' => $userid,
			'shop_id' => '',
			'title' => $pay_name_text . '充值',
			'content' => $pay_name_text . '充值，充值金额：' . sprintf("%01.2f", $rechargeTotal) . '，支付帐号：' . $payAccount . '，总金额：' . $sumAmount,
			'amount' => sprintf("%01.2f", $rechargeTotal),
			'make' => '',
			'status' => 1,
			'type' => 1,
			'create_time' => $timer,
			'action' => 1,
		);

		//更新钱包数据
		$walletStatus = InitPHP::getDao('wallet')->update($walletData, array('userid' => $userid));
		//更新支付数据
		$payId = InitPHP::getDao('pay')->update($payData,$payWhere);
		//添加消息数据
		$msgId = InitPHP::getDao('message')->create($msgData);
		//添加资金流动数据
		$capitalLiquidId = InitPHP::getDao('capitalLiquid')->create($capitalLiquidData);

		if ($walletStatus && $payId > 0 && $msgId > 0 && $capitalLiquidId > 0) {
			//提交事务
			InitPHP::getDao('pay')->transaction_commit();

			return InitPHP::Encode(0, '充值成功', '', 1);
		} else {
			//关闭事务
			InitPHP::getDao('pay')->transaction_rollback();

			return InitPHP::Encode(1, '充值失败', '', 1);
		}

	}

}