<?php
class payDao extends Dao {
	/**
	 * 支付数据层
	 * @author 李鹏
	 * @date 2016-01-06
	 */
	private $table_name = 'pay';
	private $fields = 'userid,username,pay_no,pay_type,pay_account,order_id,order_total,coupons_no,coupons_total,transit_total,total,pay_status,create_time,pay_time';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 添加一条数据
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 获取一条数据
	 */
	public function get($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}

	/**
	 * 获取一组数据
	 */
	public function lists($where = array(''), $num = 10, $offset = 0, $is_key = 'id', $sort = 'DESC') {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where, $is_key, $sort);
	}

	/**
	 * 更新一条数据
	 */
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

	/**
	 * 删除一条数据
	 */
	public function delete($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->delete_by_field($where, $this->table_name);
	}


	public function getPayment(){
		$sql = 'SELECT * FROM pay_payment';
		return $this->dao->db->get_all_sql($sql);
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