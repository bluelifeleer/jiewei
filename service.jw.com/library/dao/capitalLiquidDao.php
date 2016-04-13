<?php
class capitalLiquidDao extends Dao {
	private $table_name = 'capital_transactions';
	private $fields = 'userid,shop_id,title,content,amount,make,status,type,create_time,action';

	/**
	 * 添加一条资金流动信息数据
	 * @param  [array] $data [数据]
	 * @return [blooean or integer] $addid [添加成功(自增id)或失败(fasle)]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 获取一条资金流动数据
	 * @param  [array] $where [获取信息的条件]
	 * @return [array] $result [返回一条信息]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function get($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}

	/**
	 * 获取一组数据
	 * @param  array   $where  [获取数据有条件]
	 * @param  integer $num    [一次查询的数据量]
	 * @param  integer $offset [一次查询的偏移量]
	 * @param  string  $is_key [排序关键字]
	 * @param  string  $sort   [排序方式]
	 * @param  string  $field  [查询的字段]
	 * @return [type]  $collection  [返回的结果集合]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function lists($where = array('*'), $num = 10, $offset = 0, $is_key = 'id', $sort = 'DESC', $field = '*') {
		$where = $this->dao->db->build_key($where, $this->fields);
		$limit = $this->dao->db->build_limit($offset, $num);
		$sql = 'SELECT ' . $field . ' FROM ' . $this->table_name . $this->dao->db->build_where($where) . 'ORDER BY ' . $is_key . ' ' . $sort . ' ' . $limit;
		$collection[0] = $this->dao->db->get_all_sql($sql);
		$collection[1] = $this->dao->db->get_count($this->table_name, $where);
		return $collection;
	}

	/**
	 * 更新一条数据
	 * @param  [array] $data  [要更新的数据]
	 * @param  [array] $where [条件]
	 * @return [blooean] $status [更新成功或失败]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

	/**
	 * 删除一条数据
	 * @param  [array] $where [要删除的条件]
	 * @return [blooean] $status [删除成功或失败]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function delete($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->delete_by_field($where, $this->table_name);
	}
}
