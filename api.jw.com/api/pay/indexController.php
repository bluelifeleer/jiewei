<?php
class indexController extends Controller {
	public $initphp_list = array('recharge', 'get', 'paySpend', 'delete', 'payOrder', 'getPayment');

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 充值支付
	 * @using http://api.jw.com/pay/index/recharge
	 * @param [integer] $userid [会员id]
	 * @param [inreger] $pay_status [支付状态,0：未支付，1：支付中，2：支付完成]
	 * @return [boolean] $status [支付成功或失败]
	 */
	public function recharge() {
		$userid = $this->getUtil('session')->get('_userid');
		$value = array('pay_status');
		$data = $this->controller->get_gp($value, 'G');
		$where = array(
			'userid' => $userid,
			'order_id' => '',
		);
		$upDate = array('pay_status' => $data['pay_status']);
		$updateStatus = InitPHP::getRemoteService('pay', 'update', array($upDate, $where));
		if ($updateStatus) {
			InitPHP::Encode(0, 'Success', $updateStatus);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

	/**
	 * 获取一条数据
	 * @using http://api.jw.com/pay/index/get
	 * @method [string] GET [请求方式]
	 * @param [string] $userid [用户id]
	 * @param [integer] $pay_id [支付数据表id]
	 * @return [array] $result [返回数据]
	 * @author 李鹏
	 * @date 2015-01-21
	 */
	public function get() {
		$userid = $this->getUtil('session')->get('_userid');
		// $value = array('pay_id');
		// $data = $this->controller->get_gp($value,'G');
		// $payid = $data['pay_id'];
		// $result = InitPHP::getRemoteService('pay','get',array($userid,$payid));
		// if($result['code'] == 0){
		//   InitPHP::Encode(0,'Success',$result['data']);
		// }else{
		//   InitPHP::Encode(1,'Error','');
		// }
	}

	/**
	 * 查询订单列表
	 * @using http://api.jw.com/pay/index/paySpend
	 * @method [string] GET [请求方式]
	 * @param [string] $userid [用户id]
	 * @param [integer] $num [查询数据条数]
	 * @param [integer] $offset [偏移量]
	 * @param [string] $is_key [排序关键字]
	 * @param [string] $sort [排序方式]
	 * @return [array] $userid [返回订单的列表]
	 * @Author 李鹏
	 * @date 2016-01-21
	 */
	public function paySpend() {
		$userid = $this->getUtil('session')->get('_userid');
		if (!isset($userid) && $userid == '') {
			InitPHP::Encode(2, 'notLogin', '');
		}
		$where = array('userid' => $userid);
		$value = array('num', 'offset', 'is_key', 'sort');
		$data = $this->controller->get_gp($value, 'G');
		$num = isset($data['num']) && $data['num'] != '' ? $data['num'] : 20;
		$offset = isset($data['offset']) && $data['offset'] != '' ? $data['offset'] : 0;
		$is_key = isset($data['is_key']) && $data['is_key'] != '' ? $data['is_key'] : 'id';
		$sort = isset($data['sort']) && $data['sort'] != '' ? $data['sort'] : 'DESC';
		$lists = InitPHP::getRemoteService('pay', 'lists', array($where, $num, $offset, $is_key, $sort));
		// var_dump($lists['data'][0]);
		for ($i = 0; $i < count($lists['data'][0]); $i++) {
			$lists['data'][0][$i]['creat_at'] = date('Y-m-d H:i:s', $lists['data'][0][$i]['creat_at']);
		}
		if ($lists['code'] == 0) {
			InitPHP::Encode(0, 'Success', $lists['data']);
		} else {
			InitPHP::Encode(0, 'Error', '');
		}
	}

	/**
	 * 删除数据
	 * @param [string] $userid [用户id]
	 * @param [integer] $pay_id [支付数据表id]
	 * @return [blooean] $deleteStatus [是否删除成功]
	 * @author 李鹏
	 * @date 2015-01-21
	 */
	public function delete() {
		$userid = $this->getUtil('session')->get('_userid');
		$value = array('pay_id');
		$data = $this->constroller->get_gp($value, 'G');
		$payid = $data['pay_id'];
		$deleteStatus = InitPHP::getRemoteService('pay', 'delete', array($userid, $payid));
		if ($deleteStatus['code'] == 0) {
			InitPHP::Encode(0, 'Success', $deleteStatus['data']);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

	/**
	 * 支付订单操作
	 * @return [type] [description]
	 */
	public function payOrder() {
		$userid = $this->getUtil('session')->get('_userid');
		$username = $this->getUtil('session')->get('_nickname');
		$value = array('order_id');
		$data = $this->controller->get_gp($value, 'G');
		//确认支付
		$payStatus = InitPHP::getRemoteService('pay', 'payOrder', array($userid, $username, $data['order_id']));
		if ($payStatus) {
			InitPHP::Encode(0, 'Success', $payStatus['data']);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}





	public function getPayment(){
		$payment = InitPHP::getRemoteService('pay','getPayment',array(''));
		if($payment['code'] == 0){
			InitPHP::Encode(0,'Success',$payment['data']);
		}else{
			InitPHP::Encode(1,'Error','');
		}
	}


}
