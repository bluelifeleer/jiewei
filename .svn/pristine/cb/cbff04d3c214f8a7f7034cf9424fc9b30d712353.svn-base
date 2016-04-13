<?php
/**
 * 钱包数据表
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-29 16:10:38
 */

class walletDao extends Dao {
	public $table_name = 'my_wallet';
	private $fields = "userid,shop_id,amount,point,frozen_amount,current_month_bonus,current_month_sales_amount";

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
	 * 更新一条数据
	 * @param Array String $data 需要更新的数据
	 * @param String $where 更新条件
	 */
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

}
