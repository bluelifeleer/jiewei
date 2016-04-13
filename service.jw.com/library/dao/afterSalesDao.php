<?php
/**
 * 售后数据层
 * @author 李鹏
 * @date 2016-02-21
 */
class afterSalesDao extends Dao {
	public $table_name = 'after_sales';
	private $fields = 'order_id,goods_id,userid,user_name,shop_id,goods_name,goods_sn,goods_attr,goods_number,goods_price,goods_pic,content,create_time';
	/**
	 * @param  [array] $data [要添加的数据]
	 * @return [integer] $id [自增id]
	 * @author 李鹏
	 * @date 2016-02-23
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 获取一条数据
	 * @param  [array] $where [查询数据的条件]
	 * @return [array] $result [获取到的数据]
	 * @author 李鹏
	 * @date 2016-02-23
	 */
	public function get($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}

	/**
	 * 获取一组数据
	 * @param  array   $where  [查询数据条件]
	 * @param  integer $num    [要查询的数据]
	 * @param  integer $offset [查询偏移量]
	 * @param  string  $is_key [排序关键字]
	 * @param  string  $sort   [排序方式，默认DESC]
	 * @param  string  $field  [查询字段]
	 * @return [array] $collection [返回数据]
	 * @author 李鹏
	 * @date 2016-02-23
	 */
	public function lists($where = array('*'), $num = 20, $offset = 0, $is_key = 'id', $sort = 'DESC', $field = '*') {
		$where = $this->dao->db->build_key($where, $this->fields);
		$limit = $this->dao->db->build_limit($offset, $num);
		$sql = 'SELECT ' . $field . ' FROM ' . $this->table_name . ' ' . $this->dao->db->build_where($where) . ' ORDER BY ' . $is_key . ' ' . $sort . ' ' . $limit;
		$collection[0] = $this->dao->db->get_all_sql($sql);
		$collection[1] = $this->dao->db->get_count($this->table_name, $where);
		return $collection;
	}

	/**
	 * 删除一条数据
	 * @param  [array] $where [要删除数据的条件]
	 * @return [blooean] [删除是否成功]
	 * @author 李鹏
	 * @date 2016-02-23
	 */
	public function delete($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->delete_by_field($where, $this->table_name);
	}

	/**
	 * 更新一条数据
	 * @param [array] $data [要更新的数据]
	 * @param [array] $where [更新数据的条件]
	 * @return [blooean] $updateId [更新是否成功]
	 * @author 李鹏
	 * @date 2016-02-23
	 **/
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$data = $this->dao->db->build_key($data, $where);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

	//开启事务
	public function transaction_start() {
		$this->dao->db->transaction_start();
	}
	//提交事务
	public function transaction_commit() {
		$this->dao->db->transaction_commit();
	}
	//回滚事务
	public function transaction_rollback() {
		$this->dao->db->transaction_rollback();
	}
}