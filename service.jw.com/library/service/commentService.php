<?php
/**
 * 评论服务层
 * @Author: 明艺
 * @Date:   2016-1-1 16:14:20
 * @Last Modified time: 2016-1-1 16:14:20
 */
class commentService extends Service {
	private $DB;

	public function __construct() {
		parent::__construct();
		//获取Dao
		$this->DB = InitPHP::getDao('comment');
	}

	/**
	 * 获取单条
	 * @param  [array] $where [查询条件]
	 * @return [array]        [单条数据]
	 */
	public function get($where) {
		$data = $this->DB->get($where);
		if ($data) {
			return InitPHP::Encode(0, 'Success', $data, 1);
		} else {
			return InitPHP::Encode(3, 'Error', $data, 1);
		}
	}

	/**
	 * 获取列表
	 * @param  array   $where  [description]
	 * @param  integer $offset [description]
	 * @param  integer $num    [description]
	 * @param  string  $order  [description]
	 * @param  string  $sort   [description]
	 * @param  string  $key    [description]
	 * @param  string  $fileds [description]
	 * @return [array]          [description]
	 */
	public function lists($where = array(), $num = 10, $offset = 0, $order = 'product_id', $sort = 'asc', $key = 'evaluate_id', $fileds = '*') {
		$data = $this->DB->lists($where, $num, $offset, $order, $sort, $key, $fileds);
		if ($data) {
			return InitPHP::Encode(0, 'Success', $data, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $data, 1);
		}
	}

	/**
	 * 更新
	 * @param  [array] $data  [更改的数据]
	 * @param  [array] $where [更改的条件]
	 * @return [bool]        [true or false]
	 */
	public function update($data, $where) {
		$state = $this->DB->update($data, $where);
		if ($state) {
			return InitPHP::Encode(0, 'Success', $state, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $state, 1);
		}
	}


	/**
	 * 新增
	 * @param  [array] $data [description]
	 * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
	 */
	public function create($data) {
		//开启事务
		$this->DB->transaction_start();
		//创建评价
		$data['create_time'] = time();
		
		$create_id = $this->DB->create($data);
		//修改订单 为已评价
		$updataOrderGoodsStatus = InitPHP::getDao('orderGoods')->update(array('is_comment' => 1), array('order_id' => $data['order_id'], 'goods_id' => $data['product_id']));

		
		if ($create_id && $updataOrderGoodsStatus ) {
			//提交事务
			$this->DB->transaction_commit();
			return InitPHP::Encode(0, 'Success', $create_id, 1);
		} else {
			//关闭事务
			$this->DB->transaction_rollback();
			return InitPHP::Encode(1, 'Error', $create_id, 1);
		}
	}

	/**
	 * 删除
	 * @param  [type] $ids [一个或者多个值 1,2,3]
	 * @return [type]      [description]
	 */
	public function delete($ids) {
		$state = $this->DB->delete($ids);
		if ($state) {
			return InitPHP::Encode(0, 'Success', $state, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $state, 1);
		}
	}
}
