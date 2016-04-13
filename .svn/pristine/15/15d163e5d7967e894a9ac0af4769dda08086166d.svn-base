<?php
class indexController extends Controller {
	public $initphp_list = array('get', 'lists', 'createMessag', 'delete');

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 添加一条数据
	 * @using http://api.jw.com/message/index/createMsg
	 * @method [string] POST [请求方式]
	 * @param [string] $userid [接收信息的用户id]
	 * @param [string] $from_userid [发送信息的用户id]
	 * @param [string] $title [信息标题]
	 * @param [string] $contents [信息内容]
	 * @param [integer] $type [信息类型，１：系统消息，２：购买商品(功订单提醒)消息，３：公告消息，４：其它．．．]
	 * @author 李鹏
	 * @date 2016-01-10
	 */
	public function createMessag() {
		$value = array('to_userid', 'from_userid', 'title', 'contents', 'type');
		$getPostData = $this->controller->get_gp($value, 'P');
		$data = array(
			'to_userid' => isset($getPostData['to_userid']) && $getPostData['to_userid'] != '' ? $getPostData['to_userid'] : '',
			'from_userid' => isset($getPostData['from_userid']) && $getPostData['from_userid'] != '' ? $getPostData['from_userid'] : '',
			'title' => isset($getPostData['title']) && $getPostData['title'] != '' ? $getPostData['title'] : '',
			'contents' => isset($getPostData['contents']) && $getPostData['contents'] != '' ? $getPostData['contents'] : '',
			'type' => isset($getPostData['type']) && $getPostData['type'] != '' ? $getPostData['type'] : '',
			'is_read' => 0,
			'create_time' => time(),
		);
		$insertId = InitPHP::getRemoteService('message', 'create', array($data));
		if ($insertId['code'] == 0) {
			$code = 1;
			$msg = 'Success';
			$data = $insertId['data'];
		} else {
			$code = 1;
			$msg = 'Error';
			$data = '';
		}
		InitPHP::Encode($code, $msg, $data);
	}

	/**
	 * 获取一条消息
	 * @using http://api.jw.com/message/index/get
	 * @param [string] $userid [用户id]
	 * @param [integer] $gid [消息id]
	 * @return [array] $result [消息详情]
	 * @author 李鹏
	 * @date 2016-01-10
	 */
	public function get() {
		$userid = $this->getUtil('session')->get('_userid');
		$value = array('msgid');
		$getData = $this->controller->get_gp($value, 'G');
		$where = array(
			'to_userid' => $userid,
			'id' => isset($getData['msgid']) && $getData['msgid'] != '' ? intval($getData['msgid']) : '',
		);
		$result = InitPHP::getRemoteService('message', 'get', array($where));

		if ($result['code'] == 0) {
			InitPHP::Encode(0, 'Success', $result['data']);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}

	}

	/**
	 * 获取用户所有的信息列表
	 * @using htt://api.jw.com/message/index/lists
	 * @method [string] GET [请求方式]
	 * @param [string] $userid [会员id,必须]
	 * @param [integer] $offset [数据偏移量，可选]
	 * @param [integer] $num [数据数量，可选]
	 * @param [array] $field [数据字段，可选]
	 * @param [string] $is_key [排序关键字，可先]
	 * @param [string] $sort [数据排序方式,可选]
	 * @return [array] $msgLists [所有的消息列表]
	 * @athor 李朋
	 * @date 2016-01-10
	 */
	public function lists() {
		$userid = $this->getUtil('session')->get('_userid');
		$value = array('offset', 'num', 'is_key', 'sort', 'msgType');
		$data = $this->controller->get_gp($value, 'G');
		if (isset($data['msgType']) && $data['msgType'] != '') {
//如果消息类型存在则条件中加入消息类型
			$where = array(
				'to_userid' => $userid,
				'type' => isset($data['msgType']) && $data['msgType'] != '' ? intval($data['msgType']) : 1,
			);
		} else {
//如果不存在则没有消息类型
			$where = array(
				'to_userid' => $userid,
			);
		}
		$offset = isset($data['offset']) && $data['offset'] != '' ? $data['offset'] : 0;
		$num = isset($data['num']) && $data['num'] != '' ? $data['num'] : 10;
		$is_key = isset($data['is_key']) && $data['is_key'] != '' ? $data['is_key'] : 'create_time';
		$sort = isset($data['sort']) && $data['sort'] != '' ? $data['sort'] : 'DESC';
		$msgLists = InitPHP::getRemoteService('message', 'lists', array($where, $num, $offset, $is_key, $sort));
		for ($i = 0; $i < count($msgLists['data'][0]); $i++) {
			$msgLists['data'][0][$i]['contents'] = htmlspecialchars_decode($msgLists['data'][0][$i]['contents']);
		}

		// var_dump($msgLists['data'][0]);
		if ($msgLists['code'] == 0) {
			InitPHP::Encode(0, 'Success', $msgLists['data'][0]);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

	/**
	 * 删除一条或多条[多个以数组形式传入]消息
	 * @using http://api.jw.com/message/index/delete
	 * @method [string] POST [请求方式]
	 * @param [array] $where [要删除的条件，如果$where = arrray('to_userid' => )]
	 * @param [string || array] $ids [要删除的数据的id，可以是一个或多个]
	 * @param [string] $del_key [要删除的关键字,默认以id为关键字]
	 * @author 李鹏
	 * @date 2015-01-10
	 */
	public function delete() {
		$value = array('userid', 'msgid');
		$getData = $this->controller->get_gp($value, 'P');
		$msgIdArr = explode(',', $getData['msg']);
		$where = array('to_userid' => $getData['userid']);
		$deleStatus = InitPHP::getRemoteService('message', 'delete', array($where, $msgIdArr));
	}

	/**
	 * 更新数据
	 * @param [array] $where [更新数据条件,如：$where = array('id' => ,'to_userid' => )]
	 * @param [array] $data [要更新的数据,如：$data = array('title' => ,'contents' => )]
	 * @return [boolean || integer] $updateStatus [更新状态，是否成功]
	 * @author 李鹏
	 * @date 2015-01-10
	 */
	public function update() {

	}

}
