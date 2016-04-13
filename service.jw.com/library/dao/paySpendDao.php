<?php
/**
 * 消费记录数据表
 * @Author: 刘波
 * @Date:   2015-12-29 15:21:40
 * @Last Modified time: 2015-12-29 15:41:43
 *
 */

class paySpendDao extends Dao {
	public $table_name = 'pay_spend';
	private $fields = "id,creat_at,userid,username,type,value,op_userid,op_username,msg,logo";

	/**
	 * 添加一条消费记录
	 * @param Array $data
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 获取一条消费数据
	 * @param Array String $where 条件
	 * @param String $fileds 需要获取的字段
	 */
	public function get($where, $fileds = '*') {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name, $fileds);
	}

	/**
	 * 获取消费列表
	 * @param  [Array]  $where     [description]
	 * @param  integer $num       [description]
	 * @param  integer $offset    [description]
	 * @param  string  $sortname  [description]
	 * @param  [string]  $sortorder [description]
	 * @param  [string]  $fileds    [description]
	 * @return [Array]             [description]
	 */
	public function lists($where, $num = 10, $offset = 0, $is_key = 'id', $sort = 'DESC', $field = '*') {
		$where = $this->dao->db->build_key($where, $this->fields);
		$limit = $this->dao->db->build_limit($offset, $num);
		$sql = 'SELECT ' . $field . ' FROM ' . $this->table_name . $this->dao->db->build_where($where) . 'ORDER BY ' . $is_key . ' ' . $sort . ' ' . $limit;
		$collection[0] = $this->dao->db->get_all_sql($sql);
		$collection[1] = $this->dao->db->get_count($this->table_name, $where);
		return $collection;
	}

	/**
	 * 删除一条数据
	 */
	public function delete($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->delete_by_field($where, $this->table_name);
	}

}
