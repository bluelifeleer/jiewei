<?php
/**
 * 充值接口
 */
class indexController extends Controller {
	public $initphp_list = array('recharge');

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 充值接口
	 * @using [string] http://zj3w.net/recharge/index/recharge [接口使用方法]
	 * @method [string] [POST] [请求方式]
	 * @param [array] $data [充值数据]
	 * @return [integer] $createId [添加是否成功]
	 * @autohr 李鹏
	 * @date 2016-02-18
	 */
	public function recharge() {
		$value = array('total', 'pay_type');
		$data = $this->controller->get_gp($value, 'P');
		$userid = $this->getUtil('session')->get('_userid');
		$username = $this->getUtil('session')->get('_nickname');

		$status = InitPHP::getRemoteService('recharge', 'create', array($userid, $username, $data['pay_type'], $data['total']));

		if ($status['code'] == 0) {
			InitPHP::Encode(0, '充值成功', '');
		} else {
			InitPHP::Encode(1, '充值失败', '');
		}
	}
}