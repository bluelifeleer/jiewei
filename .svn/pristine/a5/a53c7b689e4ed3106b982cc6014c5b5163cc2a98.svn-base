<?php
/**
 * @Author: seaven
 * @Date:   2015-12-31 15:30:33
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-24 15:11:14
 */

class indexController extends Controller {
	//Action白名单
	public $initphp_list = array('init', 'product_lists','lists', 'getInfo', 'getDetail', 'getCate', 'ModifiedProduct', 'createProduct', 'createProductDetail', 'getProductDetail', 'updateProductDetail', 'getCounts', 'deleteProduct');

	//初始化继承父类
	public function __construct() {
		parent::__construct();
	}
	/**
	 * [product_lists 用于产品在首页分类产品列表展示 【专用】]
	 * @return [type] [description]
	 */
	public function product_lists(){
		//过滤请求参数
		$fileds = array('catid',  'siteid', 'order','sort');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);
		$where = $data;
		if(isset($data['catid']) && (bool)$data['catid']){
			$catRes = InitPHP::getRemoteService('categories', 'get', array(array('catid'=>$data['catid'])));
			$catArr = explode(',',$catRes['arrchildid']);
			$where['catid'] = $catArr;
		}
		$where['userid'] = $data['siteid'];
		$where['status'] = 99;
		$where['is_up'] = 99;
		$offset = $_GET['offset'];
		//页码
		$page = max((int) $_GET['page'], 1);
		//sql limit 限制
		$limit = ($page - 1) * $offset;
		//排序字段
		$order = isset($data['order']) && intval($data['order']) != 1 ? trim($data['order']) : 'id';

		//排序方式
		$sort = $data['sort'];
		var_dump($catArr);
	}


	/**
	 * [lists] 获取产品列表信息
	 * @link http://api.jw.com/product/index/lists
	 * @param [catid] 栏目id
	 * @param [keywords]  搜索关键字
	 * @return [echoJson] 查询结果array 组成的json数据
	 *
	 */
	public function lists() {
		//过滤请求参数
		$fileds = array('catid', 'keywords', 'siteid', 'sysadd', 'is_up', 'order','sort');
		$data_gp = $this->controller->get_gp($fileds);

		$data = array_filter($data_gp);
		$where = $data;
		if(isset($data['catid']) && (bool)$data['catid']){
			$catRes = InitPHP::getRemoteService('categories', 'get', array(array('catid'=>$data['catid'])));
			$catArr = explode(',',$catRes['arrchildid']);
			$where['catid'] = $catArr;
		}
		
		$where['userid'] = $data['siteid'];
		$where['status'] = 99;
		$where['is_up'] = 99;

		//查询条件

		unset($where['siteid']);
		unset($where['order']);
		unset($where['sort']);
		//is_exist = 1存在仓库中
		// $where['is_recycled'] = 1;
		// //上架属性 99 为上架  1下架
		// $where['is_up'] = 99;
		//分页量
		$offset = $_GET['offset'];
		//页码
		$page = max((int) $_GET['page'], 1);
		//sql limit 限制
		$limit = ($page - 1) * $offset;
		//排序字段
		$order = isset($data['order']) && intval($data['order']) != 1 ? trim($data['order']) : 'id';

		//排序方式
		$sort = $data['sort'];

		switch ($order) {
			case 'id':
			case 'sales':
				//调用产品服务list
				//销量排序
				$res = InitPHP::getRemoteService('product', 'indexLists', array(
					$where,
					$offset,
					$limit,
					$order,
					$sort,
					'id,title,catid,thumb,sale_price,sales,fromid,is_up,is_recycled,fromid,level',
				));
				break;
			case 'sale_price':
				//调用产品服务list
				//价格排序
				$res = InitPHP::getRemoteService('product', 'lists', array(
					$where,
					$offset,
					$limit,
					$order,
					$sort,
					'id,title,catid,thumb,sale_price,sales,fromid,is_up,is_recycled,fromid,level',
				));

				break;
			default:
				# code...
				break;
		}
		
		$proLevel = InitPHP::getRemoteService('proLevel', 'lists', array(array(), 0, 1000));
		if(is_array($proLevel['data'][0]))
		foreach ($proLevel['data'][0] as $key => $value) {
			$prokey[] = $value['id'];
			$provalue[] = $value['name'];
		}
		$prol = array_combine($prokey, $provalue);
		if(is_array($res['data'][0]))
		foreach ($res['data'][0] as $k => $v) {
			$res['data'][0][$k]['level'] = $prol[$v['level']];
		}

		$total = '0';
		$code = '0';
		$info = array();
		if ($res['code'] == 0) {
			$info = $res['data'][0];
			if(is_array($info))
			foreach ($info as $key => $value) {
				if ($value['is_up'] != 99 && $value['is_recycled'] != 1) {
					unset($info[$key]);
				}
			}

			$total = $res['data'][1];
			$code = '1';
		}
		if(is_array($info))
		foreach ($info as $key => $value) {
			$info[$key]['thumb'] = picThumbSrc($value['thumb'], 200, 200);
		}
		if (empty($info)) {
			$code = '0';
		}

		$echoJson = array('code' => $code, 'data' => !empty($info)?array_values($info):array(), 'total' => $total);

		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}
	/**
	 * [getInfo] 通过请求id获取一条产品基本信息
	 * @link http://api.jw.com/product/index/getInfo/id/6/
	 * @param [id] 请求id
	 * @return [echoJson][查询结果array组成的json数据
	 *
	 */
	public function getInfo() {
		//过滤请求参数
		$fileds = array('id');
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);

		//查询条件
		$where = $data;
		//调用产品服务get
		$res = InitPHP::getRemoteService('product', 'get', array($where, true, true, true));

		$echoJson = array();
		if ($res) {

			$echoJson['id'] = $res['id'];
			$echoJson['catid'] = $res['catid'];
			$echoJson['title'] = $res['title'];
			$echoJson['keywords'] = $res['keywords'];
			$echoJson['short_desc'] = $res['short_desc'];
			$echoJson['sale_price'] = $res['sale_price'];
			$echoJson['product_sn'] = $res['product_sn'];
			$echoJson['thumb'] = $res['thumb'];
			$echoJson['pictures'] = $res['pictures'];
			$echoJson['params'] = $res['params'];
			$echoJson['sales'] = $res['sales'];
			$echoJson['stock'] = $res['stock'];
			$echoJson['transit_cost'] = $res['transit_cost'];
			$echoJson['transit_type'] = $res['transit_type'];
			$echoJson['made'] = $res['made'];
			$echoJson['content'] = $res['content'];
			$echoJson['is_hot'] = $res['is_hot'];
			$echoJson['is_recommend'] = $res['is_recommend'];
			$echoJson['is_real'] = $res['is_real'];
			$echoJson['is_up'] = $res['is_up'];
			$echoJson['is_overseas'] = $res['is_overseas'];
			$echoJson['is_explosion'] = $res['is_up'];
			$echoJson['levelId'] = $res['levelId'];
			$echoJson['fromid'] = $res['fromid'];
			$echoJson['sysadd'] = $res['sysadd'];
			$pictures = json_decode($echoJson['pictures']);
			foreach ($pictures as $key => $value) {
				$pictures[$key] = picThumbSrc($value, 400, 400);
			}
			$echoJson['pictures'] = $pictures;
			$echoJson['thumb'] = picThumbSrc($echoJson['thumb'], 200, 200);

		}
		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}

	/**
	 * [getCate 获取产品栏目信息]
	 * @method getCate
	 * @link http://api.jw.com/product/index/getCate/
	 * @return [type]  [description]
	 */
	public function getCate() {
		//　０　为共享库，其他为用户的userid
		$fields = array('siteid');
		$data_gp = $this->controller->get_gp($fields);
		$data = array_filter($data_gp);
		$where['siteid'] = isset($data['siteid']) ? $data['siteid'] : 0;
		//module　　：　　system　共享商品库，store为店铺的栏目分类
		//$where['module'] = isset($_GET['module'])?intval($_GET['module']):'system';
		$res = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 200));
		if ($res['code'] == 0) {
			$echoJson = $res['data'][0];
		}

		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}

	/**
	 * [ModifiedProduct 店长修改产品信息]
	 */
	public function ModifiedProduct() {

		$fields = array(
			'id',
			'fromid',
			'title',
			'keywords',
			'short_desc',
			'sale_price',
			'product_sn',
			'stock',
			'pictures',
			'thumb',
			'catid',
			'is_up', //商品上下架  99：上架，1：仓库中
			'is_hot', //是否热门  1,热门，99：非热门，
			'is_explosion', //是否爆款，99:是，1，不是
			'is_overseas', //是否进口，1不是，99是
			'is_recommend', //是否推荐  1不是  99是
			'is_real', //是否虚拟产品 1不是 99 是
			'made',
			'transit_cost',//
			'transit_type',
		);

		$data_gp = $this->controller->get_gp($fields);
		$data = array_filter($data_gp);

		if (isset($data['fromid'])) {
			unset($data['fromid']);
			unset($data['keywords']);
			unset($data['title']);
			unset($data['short_desc']);
			unset($data['sale_price']);
			unset($data['product_sn']);
			unset($data['is_overseas']);
			unset($data['is_real']);
			unset($data['made']);
			unset($data['thumb']);
			unset($data['pictures']);
			unset($data['stock']);
			unset($data['transit_cost']);
			unset($data['transit_type']);

		}

		$whereData['id'] = $data['id']; //更新数据的ｉｄ
		$data['pictures'] = jsonEncode($data['pictures']);
		$where['status'] = 99;

		//同时更新产品基本数据和图文信息记录
		$updateRes = InitPHP::getRemoteService('product', 'update', array($data, $whereData));

		if ($updateRes) {
			echo jsonEncode(array('code' => 200, 'info' => '更新成功'));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '更新失败'));
			exit();
		}

	}
	/**
	 * [createProduct 创建产品]
	 * @return [type] [description]
	 */
	public function createProduct() {
		$fields = array(
			'id',
			'title',
			'keywords',
			'short_desc',
			'sale_price',
			'product_sn',
			'stock',
			'pictures',
			'thumb',
			'catid',
			'is_up', //商品上下架  99：上架，1：仓库中
			'is_hot', //是否热门  1,热门，99：非热门，
			'is_explosion', //是否爆款，99:是，1，不是
			'is_overseas', //是否进口，1不是，99是
			'is_recommend', //是否推荐  1不是  99是
			'is_real', //是否虚拟产品 1不是 99 是
			'made',
		);

		$data_gp = $this->controller->get_gp($fields);
		$data = array_filter($data_gp);

		$where = $data;
		$where['userid'] = $this->getUtil('session')->get('_userid');
		$where['username'] = $this->getUtil('session')->get('_username');
		$where['pictures'] = jsonEncode(array_values($data['pictures']));
		$where['sales'] = 0;
		$where['create_time'] = time();
		$where['update_time'] = time();
		$where['sysadd'] = 0;
		$where['status'] = 99;

		$Res = InitPHP::getRemoteService('product', 'create', array($where));

		if ($Res) {
			echo jsonEncode(array('code' => 200, 'info' => '创建成功', 'id' => $Res));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '创建失败'));
			exit();
		}
	}

	/**
	 * [getProductDetail 获取产品详情]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function getProductDetail() {
		$fields = array(
			'pro_id',
		);
		$data_gp = $this->controller->get_gp($fields);
		$data = array_filter($data_gp);

		$where = $data;

		$Res = InitPHP::getRemoteService('productDetails', 'get', array($where));

		$echoJson = array();
		if ($Res) {
			$echoJson = $Res;
		}

		//输出json数据
		echo jsonEncode($echoJson);
		exit();
	}

	/**
	 * [createProductDetail 创建产品图文详情]
	 * @return [type] [description]
	 */
	public function createProductDetail() {
		$fields = array(
			'pro_id',
			'content',
			'params',
			'transit_cost',
			'transit_type',
		);
		$data_gp = $this->controller->get_gp($fields);
		$data = array_filter($data_gp);

		$where = $data;

		$isExist = InitPHP::getRemoteService('productDetails', 'get', array(array('pro_id' => $where['pro_id'])));
		if ($isExist) {
			$updateWhere['pro_id'] = $data['pro_id']; //更新数据的ｉｄ

			$Res = InitPHP::getRemoteService('productDetails', 'update', array($where, $updateWhere));
		} else {

			$Res = InitPHP::getRemoteService('productDetails', 'create', array($where));
		}

		if ($Res) {
			echo jsonEncode(array('code' => 200, 'info' => '创建成功', 'id' => $Res));
			exit();
		} else {
			echo jsonEncode(array('code' => 300, 'info' => '创建失败'));
			exit();
		}
	}

	/**
	 * [updateProductDetail 更新商品详情]
	 * @return [type] [description]
	 */
	public function updateProductDetail() {
		{
			$fields = array(
				'id',
				'pro_id',
				'content',
				'params',
				'transit_cost',
				'transit_type',
			);
			$data_gp = $this->controller->get_gp($fields);
			$data = array_filter($data_gp);

			$where['id'] = $data['id']; //更新数据的ｉｄ

			$Res = InitPHP::getRemoteService('productDetails', 'update', array($data, $where));

			if ($Res) {
				echo jsonEncode(array('code' => 200, 'info' => '更新成功', 'id' => $Res));
				exit();
			} else {
				echo jsonEncode(array('code' => 300, 'info' => '更新失败'));
				exit();
			}
		}
	}

	/**
	 * 获取商品数量
	 * @return [integer] [商品数量]
	 * @author 李鹏
	 * @date 2016-03-16
	 */
	public function getCounts() {
		$value = array('shop_id');
		$data = $this->controller->get_gp($value, 'G');
		$count = InitPHP::getRemoteService('product', 'getCounts', array($data['shop_id']));
		if ($count['code'] == 0) {
			InitPHP::Encode(0, 'Success', $count['data']);
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

	/**
	 * 删除一条商品数据
	 * @param  [string] $userid    [店铺用户的id]
	 * @param  [integer] $productId [商品id]
	 * @return [blooean] $dele [删除是否成功]
	 * @author 李鹏
	 * @date 2016-03-16
	 */
	public function deleteProduct() {
		$userid = $this->getUtil('session')->get('_userid');
		$value = array('product_id');
		$data = $this->controller->get_gp($value, 'G');
		$dele = InitPHP::getRemoteService('product', 'deleteProduct', array($userid, $data['product_id']));
		if ($dele['code'] == 0) {
			InitPHP::Encode(0, 'Success', '');
		} else {
			InitPHP::Encode(1, 'Error', '');
		}
	}

}
