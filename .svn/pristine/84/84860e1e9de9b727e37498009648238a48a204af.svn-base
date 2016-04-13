<?php

/**
 * @Author: 翁昌华
 * @description: 产品（商品）管理
 * @Date: 2015-12-22
 *
 */
class productController extends Controller {
	// Action白名单
	public $initphp_list = array(
		'lists',
		'create',
		'edit',
		'success',
		'recycle',
		'inRecycleBatch',
		'outRecycleBatch',
		'delete',
		'productStatus',
		'productRecycle',
		'selectLists',
	);

	public function __construct() {
		parent::__construct();
		$this->userid = $userid = (int) $this->getUtil('session')->get('admin_userid');
		if ($userid) {
			$this->memberinfo = InitPHP::getRemoteService('admin', 'get', array(
				$userid,
			));
		}
		// 判断是否登入状态
		InitPHP::getService("admin")->check_admin();
	}

	/**
	 * 商品列表
	 */
	public function lists() {
		$fileds = array(
			'id',
			'title',
			'level',
			'catid',
			'is_recycled',
			'is_up',
			'is_hot',
			'catid',
			'type', //1为普通产品 2 为推荐产品
			'made_area',
		);
		$data = $this->controller->get_gp($fileds);
		$data = array_filter($data);

		$id = str_replace(' ', '', safe_replace($data['id']));
		$title = str_replace(' ', '', safe_replace($data['title']));
		$currentCatId = $data['catid'];
		$currentLevel = $data['level'];
		$currentUp = $data['is_up'];
		$currentHot = $data['is_hot'];
		$currentType = $data['type'];
		$made_area = str_replace(' ', '', safe_replace($data['made_area']));

		$where = $data;
		$where['is_recycled'] = 1;
		$where['sysadd'] = 1;
		if (isset($title) && $title != '') {
			unset($where['title']);
			$where['title'] = array('like' => '%' . $title . '%');
		}
		$offset = 15;
		$page = max((int) $_GET['page'], 1);
		$limit = ($page - 1) * $offset;
		$order = 'id';
		$sort = 'desc';
		$proRes = InitPHP::getRemoteService('product', 'lists', array(
			$where,
			$offset,
			$limit,
			$order,
			$sort,
		));
		$info = array();
		$tatol = 0;
		if ($proRes['code'] == 0) {
			$info = $proRes['data'][0];
			$tatol = $proRes['data'][1];
		}
		$where['title'] = $title;
		$pages = pages($tatol, $page, $offset, '', array(), '10', $where);
		$categories = $this->getCates(); //商品类别
		$typeArray = $this->getType(); //商品类型
		$hotArray = $this->getHot(); //消费属性
		$levelArray = $this->getLevel(); //商品等级
		$upArray = $this->getUp(); //上架状态

		include V('product', 'proList');
	}
	/**
	 * 筛选产品列表
	 */
	public function selectLists() {

		$fileds = array(
			'id',
			'title',
			'level',
			'catid',
			'is_recycled',
			'is_up',
			'is_hot',
			'catid',
			'type', //1为普通产品 2 为推荐产品
			'made_area',
		);
		$data = $this->controller->get_gp($fileds);
		$data = array_filter($data);

		$id = str_replace(' ', '', safe_replace($data['id']));
		$title = str_replace(' ', '', safe_replace($data['title']));
		$currentCatId = $data['catid'];
		$currentLevel = $data['level'];
		$currentUp = $data['is_up'];
		$currentHot = $data['is_hot'];
		$currentType = $data['type'];
		$made_area = str_replace(' ', '', safe_replace($data['made']));

		$where = $data;
		$where['is_recycled'] = 1;
		$where['sysadd'] = 1;
		if (isset($title) && $title != '') {
			unset($where['title']);
			$where['title'] = array('like' => '%' . $title . '%');
		}
		$offset = 10;
		$page = max((int) $_GET['page'], 1);
		$limit = ($page - 1) * $offset;
		$order = 'id';
		$sort = 'desc';
		$proRes = InitPHP::getRemoteService('product', 'lists', array(
			$where,
			$offset,
			$limit,
			$order,
			$sort,
		));
		$info = array();
		$tatol = 0;
		if ($proRes['code'] == 0) {
			$info = $proRes['data'][0];
			$tatol = $proRes['data'][1];
		}
		$where['title'] = $title;
		$pages = pages($tatol, $page, $offset, '', array(), '10', $where);
		$categories = $this->getCates(); //商品类别
		$typeArray = $this->getType(); //商品类型
		$hotArray = $this->getHot(); //消费属性
		$levelArray = $this->getLevel(); //商品等级
		$upArray = $this->getUp(); //上架状态
		include V('product', 'select_list');
	}

	/**
	 * 创建产品
	 */

	public function create() {

		$fileds = array(
			'id',
			'title',
			'keywords',
			'product_sn',
			'short_desc',
			'purchase_price',
			'cost_price',
			'sale_price',
			'level',
			'stock',
			'pictures',
			'thumb',
			'catid',
			'sales',
			'is_up', //商品上下架  99：上架，1：仓库中
			'is_hot', //是否热门  1,热门，99：非热门，
			'is_explosion', //是否爆款，99:是，1，不是
			'is_overseas', //是否进口，1不是，99是
			'is_recommend', //是否推荐  1不是  99是
			'is_recycled', //回收站  1：存在产品库，99：存在于回收站
			'is_real', //是否虚拟产品  1 不是  99 是
			'content',
			'transit_type',
			'transit_cost',
			'params',
			'made',

		);
		if (intval($_POST['dosubmit']) > 0) {
			$data_gp = $this->controller->get_gp($fileds);
			$data = array_filter($data_gp);

			//产品基本信息
			$productInfo = array();
			$productInfo['title'] = $title = str_replace(' ', '', safe_replace($data['title']));
			$productInfo['keywords'] = $data['keywords'];
			$productInfo['product_sn'] = $data['product_sn'];
			$productInfo['short_desc'] = $data['short_desc'];
			$productInfo['purchase_price'] = $data['purchase_price'];
			$productInfo['cost_price'] = $data['cost_price'];
			$productInfo['sale_price'] = $data['sale_price'];
			$productInfo['level'] = $data['level'];
			$productInfo['stock'] = $data['stock']; //库存
			$productInfo['pictures'] = jsonEncode($data['pictures']);
			$productInfo['thumb'] = $data['thumb'];
			$productInfo['sales'] = 0; //销售量为０
			$productInfo['is_recycled'] = 1; //回收站  1：存在产品库，99：存在于回收站
			$productInfo['is_up'] = $data['is_up']; //商品上下架  99：上架，1：仓库中
			$productInfo['is_hot'] = $data['is_hot']; //是否热门  1,热门，99：非热门，
			$productInfo['is_explosion'] = $data['is_explosion']; //是否爆款，99:是，1，不是
			$productInfo['is_overseas'] = $data['is_overseas']; //是否进口，1不是，99是
			$productInfo['is_recommend'] = $data['is_recommend']; //是否推荐  1不是  99是
			$productInfo['is_real'] = $data['is_real'];
			$productInfo['catid'] = $data['catid'];
			$productInfo['create_time'] = time();
			$productInfo['update_time'] = time();
			$productInfo['userid'] = InitPHP::getConfig('userid'); //界微平台商城管理用户ID
			$productInfo['username'] = InitPHP::getConfig('username'); //界微平台商城管理用户名
			$productInfo['made'] = str_replace(' ', '', safe_replace($data['made']));
			$productInfo['sysadd'] = 1; //是否后台添加　１　是　　　　０　否
			$productInfo['status'] = 99; // 商品审核状态 0：未审核处理状态，1,未通过审核，99;通过审核（平台发布不需审核）
			$productInfo['transit_type'] = $data['transit_type'];
			$productInfo['transit_cost'] = $data['transit_cost'];

			//产品图文信息
			$productDetails = array();

			$productDetails['content'] = $data['content'];

			$productDetails['params'] = $data['params'];

			//同时插入产品基本信息和图文信息
			$createRes = InitPHP::getRemoteService('product', 'transactionCreate', array($productInfo, $productDetails));

			if ($createRes['code'] == 200) {
				echo jsonEncode(array('code' => 200, 'info' => '添加成功'));
				exit();
			} else {
				echo jsonEncode(array('code' => 300, 'info' => '更新失败'));
				exit();
			}

		} else {

			$catid = $_GET['catid'];
			$productInfo['catid'] = $catid;

			$hotArray = $this->getHot();
			$upArray = $this->getUp();
			//$categories = $this->getCates();
			$categories = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system'), 0, 2000));
			$categories = $categories['data'][0];

			$proLevels = $this->getLevel();
			$explosion_array = $this->getExplosion();
			$overseas_array = $this->overseas_array;
			$recommend_array = $this->recommend_array;

			$isReal_array = $this->isReal_array;
		}

		include V('product', 'createProduct');
	}

	/**
	 * 编辑产品信息
	 */
	public function edit() {

		$fileds = array('id');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$where = $data;
		$productInfo = InitPHP::getRemoteService('product', 'get', array($where, true, true, true));
		$productInfo['params'] = json_decode($productInfo['params'], true);

		$html = '';

		if (is_array($productInfo['params'])) {

			foreach ($productInfo['params'] as $key => $value) {

				$html = $html . '<tr>';
				$html = $html . '<td class="col-sm-1 input-group" class="col-sm-12" style="padding-left:10px;">';
				$html = $html . '<input type="text" name="paramName" value="' . $key . '" placeholder="请输入属性名" />';
				$html = $html . '</td>';
				$html = $html . '<td class="col-sm-8 input-group">';
				$html = $html . '<input type="text" class="col-sm-12 paramValue" name="paramValue" value="' . $value . '" placeholder="请输入属性值" />';

				$html = $html . '</td>';
				$html = $html . '<td onclick="$(this).parent().remove();">移除</td>';
				$html = $html . '</tr>';

			}
		}

		$categories = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system'), 0, 2000));
		$categories = $categories['data'][0];

		$hotArray = $this->getHot();
		$upArray = $this->getUp();
		//$categories = $this->getCates();
		$proLevels = $this->getLevel();
		$explosion_array = $this->getExplosion();
		$overseas_array = $this->overseas_array;
		$recommend_array = $this->recommend_array;
		$isReal_array = $this->isReal_array;

		if (intval($_POST['dosubmit']) > 0) {
			$fileds = array(
				'id',
				'title',
				'keywords',
				'short_desc',
				'purchase_price',
				'cost_price',
				'sale_price',
				'product_sn',
				'level',
				'stock',
				'pictures',
				'thumb',
				'catid',
				'sales',
				'is_up', //商品上下架  99：上架，1：仓库中
				'is_hot', //是否热门  1,热门，99：非热门，
				'is_explosion', //是否爆款，99:是，1，不是
				'is_overseas', //是否进口，1不是，99是
				'is_recommend', //是否推荐  1不是  99是
				'is_recycled', //回收站  1：存在产品库，99：存在于回收站
				'is_real', //是否虚拟产品 1不是 99 是
				'content',
				'ransit_type',
				'transit_cost',
				'transit_type',
				'params',
				'made',
			);
			$data_gp = $this->controller->get_gp($fileds);
			$data = array_filter($data_gp);
			$infoData['id'] = $data['id']; //更新数据的ｉｄ
			$detailData['pro_id'] = $data['id'];

			if ($detailDetail['pro_id'] == '' && $infoData['id'] == '') {
				echo json_encode(array('code' => 300, 'error' => '发布失败'));
				exit();
			}
			//产品基本信息
			$productInfo = array();
			$productInfo['title'] = $title = str_replace(' ', '', safe_replace($data['title']));
			$productInfo['keywords'] = $data['keywords'];
			$productInfo['product_sn'] = $data['product_sn'];
			$productInfo['short_desc'] = $data['short_desc'];
			$productInfo['purchase_price'] = $data['purchase_price'];
			$productInfo['cost_price'] = $data['cost_price'];
			$productInfo['sale_price'] = $data['sale_price'];
			$productInfo['level'] = $data['level'];
			$productInfo['stock'] = $data['stock'];
			$productInfo['pictures'] = jsonEncode($data['pictures']);
			$productInfo['thumb'] = $data['thumb'];
			$productInfo['is_up'] = $data['is_up']; //商品上下架  99：上架，1：仓库中
			$productInfo['is_hot'] = $data['is_hot']; //是否热门  1,热门，99：非热门，
			$productInfo['is_explosion'] = $data['is_explosion']; //是否爆款，99:是，1，不是
			$productInfo['is_overseas'] = $data['is_overseas']; //是否进口，1不是，99是
			$productInfo['is_recommend'] = $data['is_recommend']; //是否推荐  1不是  99是
			$productInfo['is_real'] = $data['is_real'];
			$productInfo['catid'] = $data['catid'];
			$productInfo['made'] = str_replace(' ', '', safe_replace($data['made']));
			$productInfo['update_time'] = time();
			$productInfo['transit_type'] = $data['transit_type'];
			$productInfo['transit_cost'] = $data['transit_cost'];

			//产品图文信息
			$productDetails = array();
			$productDetails['content'] = $data['content'];
			$productDetails['params'] = $data['params'];

			//同时更新产品基本数据和图文信息记录
			$updateRes = InitPHP::getRemoteService('product', 'transactionUpdate', array($productInfo, $infoData, $productDetails, $detailData));

			if ($updateRes['code'] == 200) {
				echo jsonEncode(array('code' => 200, 'info' => '更新成功'));
				exit();
			} else {
				echo jsonEncode(array('code' => 300, 'info' => '更新失败'));
				exit();
			}
		}

		include V('product', 'createProduct');
	}
	/**
	 * 回收站产品列表
	 * @return [type]
	 */
	public function productRecycle() {
		$fileds = array(
			'id',
			'title',
			'level',
			'catid',
			'is_recycled',
			'is_up',
			'is_hot',
			'catid',
			'type', //1为普通产品 2 为推荐产品
			'made',
		);
		$data = $this->controller->get_gp($fileds);
		$data = array_filter($data);

		$id = str_replace(' ', '', safe_replace($data['id']));
		$title = str_replace(' ', '', safe_replace($data['title']));
		$currentCatId = $data['catid'];
		$currentLevel = $data['level'];
		$currentUp = $data['is_up'];
		$currentHot = $data['is_hot'];
		$currentType = $data['type'];
		$made_area = str_replace(' ', '', safe_replace($data['made']));

		$where = $data;
		$where['is_recycled'] = 99;
		if (isset($title) && $title != '') {
			unset($where['title']);
			$where['title'] = array('like' => '%' . $title . '%');
		}
		$offset = 15;
		$page = max((int) $_GET['page'], 1);
		$limit = ($page - 1) * $offset;
		$order = 'id';
		$sort = 'desc';
		$proRes = InitPHP::getRemoteService('product', 'lists', array(
			$where,
			$offset,
			$limit,
			$order,
			$sort,
		));
		$info = array();
		$tatol = 0;
		if ($proRes['code'] == 0) {
			$info = $proRes['data'][0];
			$tatol = $proRes['data'][1];
		}
		$where['title'] = $title;
		$pages = pages($tatol, $page, $offset, '', array(), '10', $where);
		$categories = $this->getCates(); //商品类别
		$typeArray = $this->getType(); //商品类型
		$hotArray = $this->getHot(); //消费属性
		$levelArray = $this->getLevel(); //商品等级
		$upArray = $this->getUp(); //上架状态

		include V('product', 'product_recycle_List');
	}
	/**
	 * 移动回收站
	 * 单个数据移入回收站
	 */

	public function recycle() {
		$fileds = array('id');
		$data_gp = $this->controller->get_gp($fileds, 'G');
		$data = array_filter($data_gp);

		// $where = $data;
		// $where['is_recycled'] = 99; //，99：存于回收站
		// $updateData['id'] = $where['id'];

		$where = array('id' => intval($data['id']));
		$upData = array('is_recycled' => 99);
		$Res = InitPHP::getRemoteService('product', 'update', array($upData, $where));

		if ($Res) {
			showmessage('成功移出回收站', '/index.php?m=product&c=index&a=listing');
			//echo jsonEncode(array('code' => 200, 'info' => '成功移动回收站'));
			//exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}

	}
	/**
	 * 批量移入回收站
	 * 接受多个id字符串组成的字符串
	 */
	public function inRecycleBatch() {
		$fileds = array('ids');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$ids = $data['ids'];
		if (isset($ids)) {
			$where = explode(",", $data['ids']);
		} else {
			$where = array();
		}

		$Res = InitPHP::getRemoteService('product', 'recycle', array($where, true));
		if ($Res) {
			echo jsonEncode(array('code' => 200, 'info' => '成功移动回收站'));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}
	}
	/**
	 * 批量移出回收站
	 * 接受多个id字符串组成的字符串
	 * ids = "1，2，3，4，5，6";
	 */
	public function outRecycleBatch() {
		$fileds = array('ids');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$ids = $data['ids'];
		if (isset($ids)) {
			$where = explode(",", $data['ids']);
		} else {
			$where = array();
		}

		$Res = InitPHP::getRemoteService('product', 'recycle', array($where, false));

		if ($Res) {
			showmessage('成功还原到产品库中！', '/index.php?m=product&c=index&a=recycleLists');
			//echo jsonEncode(array('code' => 200, 'info' => '成功移出回收站'));
			//exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}
	}
	/**
	 * 删除产品
	 */
	public function delete() {
		$fileds = array('ids');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$ids = $data['ids'];
		if (isset($ids) && $ids != '') {
			$where = explode(",", $data['ids']);
		} else {
			$where = array();
		}

		$Res = InitPHP::getRemoteService('product', 'delete', array($where));

		if ($Res) {
			showmessage('删除成功！', '/index.php?m=product&c=index&a=recycleLists');
			// echo jsonEncode(array('code' => 200, 'info' => '删除成功'));
			// exit();
		} else {
			//echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}

	}
	/**
	 * 商品上下架
	 *
	 */
	public function productStatus() {
		$fileds = array('ids', 'status');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$ids = $data['ids'];
		if (isset($ids) && $ids != '') {
			$where = explode(",", $data['ids']);
		} else {
			$where = array();
		}

		$status = $data['status'];

		if (isset($status) && $status == 'up') {
			$info = '上架成功';
			$Res = InitPHP::getRemoteService('product', 'updateStatus', array($where, true));
		}
		if (isset($status) && $status == 'down') {
			$info = '下架成功';
			$Res = InitPHP::getRemoteService('product', 'updateStatus', array($where, false));
		}
		if ($Res) {
			echo jsonEncode(array('code' => 200, 'info' => $info));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}

	}
	/**
	 * 设置产品属性
	 * [is_hot]  为属性 99：热销，0 非促销商品，1：促销商品 ２：活动：３：爆款：４：进口
	 */
	public function setAttr() {
		$fileds = array('ids', 'is_hot');
		$data_dp = $this->controller->get_gp($fileds);
		$data = array_filter($data_dp);
		$ids = $data['ids'];
		if (isset($ids) && $ids != '') {
			$where = explode(',', $ids);
		} else {
			$where = array();
		}

		$isHot = $data['is_hot'];
		if (isset($isHot) && $isHot != '') {
			$Res = InitPHP::getRemoteService('product', 'updateAttritute', array($where, $isHot));
		}
		if ($Res) {
			echo jsonEncode(array('code' => 200, 'info' => '操作成功'));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '操作失败'));
			exit();
		}

	}
	/**
	 * 设置产品类型
	 * $type 　1 普通商品  2 推荐商品
	 */
	public function setType() {
		$fileds = array('ids', 'type');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$ids = $data['ids'];
		if (isset($ids) && $ids != '') {
			$where = explode(',', $ids);
		} else {
			$where = array();
		}

		$type = $data['type'];
		if (isset($type) && $type != '') {
			$Res = InitPHP::getRemoteService('product', 'updateType', array($where, $type));
		}
		if ($Res) {
			echo jsonEncode(array(
				'code' => 200,
				'info' => '操作成功',
			));
			exit();
		} else {
			echo jsonEncode(array(
				'code' => 300,
				'info' => '操作失败',
			));
			exit();
		}
	}
	/**
	 * 审核产品
	 * 商品审核状态 0：未审核处理状态，1,未通过审核，99;通过审核（平台发布不需审核）
	 */
	public function approval() {
		$fileds = array('ids', 'status');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);

		$ids = $data['ids'];
		if (isset($ids) && $ids != '') {
			$where = explode(',', $ids);
		} else {
			$where = array();
		}

		$status = $data['status'];
		if (isset($status) && $status != '') {
			$Res = InitPHP::getRemoteService('product', 'approval', array($where, $status));
		}
		if ($Res) {
			echo jsonEncode(array(
				'code' => 200,
				'info' => '操作成功',
			));
			exit();
		} else {
			echo jsonEncode(array(
				'code' => 300,
				'info' => '操作失败',
			));
			exit();
		}
	}
	/**
	 * 产品热门属性
	 */
	public function getHot() {
		//
		$hotArray = array(99 => '非热门', 1 => '热门');
		return $hotArray;

	}
	/**
	 * 获取上架状态数组
	 */
	public function getUp() {
		//上架状态
		$upArray = array('1' => '仓库中', '99' => '上架');
		return $upArray;
	}
	/**
	 * 获取商品属性类别
	 */
	private function getType() {
		$typeArray = array('1' => '普通商品', '2' => '推荐商品');
		return $typeArray;
	}
	/**
	 * 产品爆款属性
	 * @var array
	 */
	private function getExplosion() {
		$explosion_array = array(
			'1' => '非爆款产品',
			'99' => '爆款产品',
		);
		return $explosion_array;
	}

	/**
	 * 产品进口属性
	 * [$overseas_array description]
	 * @var array
	 */
	private $overseas_array = array(
		'1' => '非进口产品',
		'99' => '进口产品',
	);
	/**
	 * 产品推荐属性
	 * [$recommend_array description]
	 * @var array
	 */
	private $recommend_array = array(
		'1' => '普通商品',
		'99' => '推荐商品',
	);
	/**
	 * 产品回收站属性
	 * [$recycled_array description]
	 * @var array
	 */
	public $recycled_array = array(
		'1' => '产品库中',
		'2' => '回收站中',
	);
	/**
	 * 是否虚拟产品
	 */
	public $isReal_array = array(
		'1' => '不是',
		'99' => '是',
	);

	/**
	 * 获取栏目信息类别
	 */
	public function getCates() {
		$categories = array();

		$catRes = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system'), 0, 2000));
		if ($catRes['code'] == 0) {
			$catInfo = $catRes['data'][0];
			foreach ($catInfo as $r) {
				$categories[$r['catid']] = $r['catname'];
			}
		}
		return $categories;
	}

	/**
	 * 获取产品等级列表信息
	 */
	public function getLevel() {
		$proLevels = array();
		$proLevelRes = InitPHP::getRemoteService('proLevel', 'lists', array(
			array(),
			0,
			2000,
		));
		if ($proLevelRes['code'] == 0) {
			$proLevelInfo = $proLevelRes['data'][0];
			foreach ($proLevelInfo as $r) {
				$proLevels[$r['id']] = $r['name'];
			}
		}
		return $proLevels;
	}

	/**
	 * 成功页面
	 */
	public function success() {
		$catid  = 0;
		 if (isset($_GET['catid']) && (bool)$_GET['catid']) {
            $catid = $_GET['catid'];
        }
		showmessage('更新成功', '/index.php?m=product&c=index&a=listing&catid='.$catid);
	}
	/**
	 * 产品状态
	 * @param  [type]
	 * @return [type]
	 */
	private function _status($status) {
		$status_array = $this->status_array;
		$string = '';
		foreach ($status_array as $k => $s) {
			if ($k == $status) {
				$string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="icon-check btn-icon"></i>' . $s . '<span class="caret"></span></a>';
			}
		}
		$string .= '<ul class="dropdown-menu">';
		foreach ($status_array as $k => $s) {
			if ($k != $status) {
				$url = URL() . '&status=' . $k;
				$url = url_unique($url);
				$string .= '<li><a href="?' . $url . '">' . $s . '</a></li>';
			}
		}
		$string .= '</ul>';
		return $string;
	}

}
