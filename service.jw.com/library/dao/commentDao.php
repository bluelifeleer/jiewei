<?php
/**
 * 评论数据库
 * @Author: 明艺
 * @Date:   2016-1-1 16:14:20
 * @Last Modified time: 2016-1-1 16:14:20
 */

class commentDao extends Dao {
	public $table_name = 'commodity_evaluate';
	private $fields = "evaluate_id,userid,order_id,product_id,evaluate_content,is_show_name,create_time,nickname";

	/**
	 * 添加一条记录
	 * @param Array $data
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 删除一条记录
	 * @param Array $where
	 */
	public function delete($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->delete_by_field($where, $this->table_name);
	}

	/**
	 * 获取一条数据
	 * @param Array String $where 条件
	 * @param String $fileds 需要获取的字段
	 */
	public function get($where, $fileds = '*') {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name, $fileds);
	}

	/**
	 * 更新一条数据
	 * @param Array String $data 需要更新的数据
	 * @param String $where 更新条件
	 */
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

	/**
	 * 获取列表
	 * @param $proLevel
	 * @param $num 每次查询偏移量
	 * @param $offset 分页量
	 * LIMIT $num,$offset
	 */
	public function lists($where, $num = 10, $offset = 0, $sortname = 'product_id', $sortorder = 'asc', $fileds = "*") {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where, $sortname, $sortorder, 'evaluate_id', '*');
	}

	//开启事务
	public function transaction_start() {
		$this->dao->db->transaction_start();
	}
	//提交事务
	public function transaction_commit() {
		return $this->dao->db->transaction_commit();
	}
	//事务滚回
	public function transaction_rollback() {
		$this->dao->db->transaction_rollback();
	}

}
