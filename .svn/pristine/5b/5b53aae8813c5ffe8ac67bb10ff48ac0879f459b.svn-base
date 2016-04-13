<?php
class indexController extends Controller {
	public $initphp_list = array('afterSales');

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 测试
	 * @return [null] [测试返回的数据]
	 */
	public function init() {
		$where = array('order_id' => '2016021912062700769');
		$lists = InitPHP::getRemoteService('afterSales', 'lists', array($where, 20, 0, 'id', 'DESC', '*'));
		var_dump($lists);
	}

	/**
	 * 添加售后数据
	 * @return [type]
	 * @author 李鹏
	 * @date 2016-02-22
	 * @ lihao 2016-3-27 
	 */
	public function afterSales() {
		$userid = $this->getUtil('session')->get('_userid') ? $this->getUtil('session')->get('_userid') : InitPHP::Encode(1, 'Error', ''); ;
		$username = $this->getUtil('session')->get('_nickname');
		$value = array('order_id', 'goods_id', 'shop_id','og_id');
		$data = $this->controller->get_gp($value, 'G');
		$orderShopInfo = InitPHP::getRemoteService('order','salesReturn',array($data['og_id'], $data['order_id'], 1));
		if($orderShopInfo['code'] == 1){
			InitPHP::Encode(2, 'Error', '售后条件未满足！');
		}
		$addId = InitPHP::getRemoteService('afterSales', 'create', array($data['order_id'], $data['goods_id'], $data['shop_id'], $userid, $username));
		$contents = '您有一条售后申请，请注意查收。';
		if ($addId['code'] == 0) {
			InitPHP::getRemoteService('message', 'send_one',array($orderShopInfo['data']['shop_id'],$contents,4));
			InitPHP::Encode(0, 'Success', '');
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

	/**
	 * 获取售后信息的列表
	 * @return [type]
	 * @author 李鹏
	 * @date 2016-02-22
	 */
	public function lists() {
		$where = array('order_id' => '2016021912062700769');
		$lists = InitPHP::getRemoteService('afterSales', 'lists', array($where, 20, 0, 'id', 'DESC', '*'));
		var_dump($lists);
	}
}