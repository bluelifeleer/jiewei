<?php
class indexController extends Controller {
	/**
	 * 评价接口
	 * @Author: 明艺
	 * @Date:   2016-1-1 16:14:20
	 * @Last Modified time: 2016-1-1 16:14:20
	 */

	public $initphp_list = array(
		'lists',
		'getComment',
		'createComment',
	);

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 获取商品评论列表
	 * @param $good_id:inier 商品id
	 * @param $good_id:inier 商品id
	 * @param $good_id:inier 商品id
	 * @return $commentInfo:json 商品评论信息
	 * @author 明艺
	 * @date 2015-12-20
	 */
	public function lists() {
		$fileds = array('id');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);

		$where['product_id'] = $data['id'];

		//分页量
		$offset = $_GET['offset'];
		//页码
		$page = max((int) $_GET['pages'], 1);
		//sql limit 限制
		$limit = ($page - 1) * $offset;

		$res = InitPHP::getRemoteService('comment', 'lists', array($where, $offset, $limit, 'evaluate_id', 'desc'));

		$echoJson = array();

		$total = '0';
		$code = '0';
		if ($res['code'] == 0) {
			$info = $res['data'][0];
			foreach ($info as $key => $value) {
				$memberInfo = InitPHP::getRemoteService('account', 'get', array(array('userid' => $value['userid'])));
				if ($memberInfo['code'] == 0) {
					$info[$key]['avarat'] = $memberInfo['data']['avarat'];
				} else {
					$info[$key]['avarat'] = '/sources/images/default_50x50.jpg';
				}
				$info[$key]['create_time'] = date('Y-m-d', $value['create_time']);
			}
			$total = $res['data'][1];
			$code = '1';
		}

		$echoJson = array('code' => $code, 'data' => $info, 'total' => $total);
		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}

	/**
	 * 添加商品评价
	 * @param $data 添加内容
	 * @return $code:json 添加结果
	 * @author 明艺
	 * @date 2016-1-1
	 */
	public function createComment() {
		$fileds = array(
			'userid',
			'nickname',
			'evaluate_content',
			'is_show_name',
			'order_id',
			'product_id',
		);
		$data = $this->controller->get_gp($fileds, 'P');

        $userid       = $this->getUtil('session')->get('_userid');
        // 用户id二次验证
		$data['userid'] ==  $userid ? '' : InitPHP::Encode(1, 'Error', '') ;

		if (!trim($data['evaluate_content'])) {
			InitPHP::Encode(2, 'Error', '');
		}

		$orderWhere['goods_id'] = intval($data['product_id']);
		$orderWhere['order_id'] = $data['order_id'];

		$proInfoFromOG = InitPHP::getRemoteService('orderGoods', 'get', array($orderWhere));

		if (intval($proInfoFromOG['is_comment']) == 1) {
			InitPHP::Encode(3, 'Exist', '');
		}

		$addId = InitPHP::getRemoteService('comment', 'create', array($data));

		if ($addId['code'] == 0) {
			InitPHP::Encode(0, 'Success', $data['product_id']);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}

	}

	/**
	 * 根据商品id获取对应的评价
	 * @link http://api.jw.com/comment/index/getComment/product_id/1
	 * @return [json] [json数据]
	 */
	public function getComment() {
		$fileds = array('product_id');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);

		$where = $data;

		$res = InitPHP::getRemoteService('comment', 'lists', array($where, 4, 0, 'evaluate_id', 'desc'));

		$echoJson = array();

		$total = '0';
		$code = '0';
		if ($res['code'] == 0) {
			$info = $res['data'][0];
			foreach ($info as $key => $value) {
				$memberInfo = InitPHP::getRemoteService('account', 'get', array(array('userid' => $value['userid'])));
				if ($memberInfo['code'] == 0) {
					$info[$key]['avarat'] = $memberInfo['data']['avarat'];
				} else {
					$info[$key]['avarat'] = '/sources/images/default_50x50.jpg';
				}
				$info[$key]['create_time'] = date('Y-m-d', $value['create_time']);
			}
			$total = $res['data'][1];
			$code = '1';
		}

		$echoJson = array('code' => $code, 'data' => $info, 'total' => $total);
		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}
}
