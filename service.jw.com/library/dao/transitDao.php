<?php
/**
 * @Author: 邵博
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:00:31
 */
class transitDao extends Dao {

	public $table_name = 'transit';
	private $fields = "id,name,url,com";
	/**
	 * 获取子集列表菜单
	 * @param $user
	 * @param $num 每次查询偏移量
	 * @param $offset 分页量
	 * LIMIT $num,$offset
	 */
	public function lists($where, $offset = 0, $num = 1000, $order = 'id', $sort = 'desc', $key = 'id', $fileds = '*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where, $order, $sort, $key, $fileds);
	}
	/**
	 * 获取一条收货地址
	 * @param $id int
	 */
	public function get($where, $fields = "*") {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name, $fields);
	}

	/**
	 * 获取某个字段的值
	 * @param $where array
	 */
	public function get_User_by_field($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}
	/**
	 * 修改收货地址
	 * @param $address array
	 * @param $id int
	 */
	public function update($address, $id) {
		$address = $this->dao->db->build_key($address, $this->fields);
		return $this->dao->db->update($id, $address, $this->table_name, 'id');
	}
	/**
	 * 新增收货地址
	 * @param $address array
	 */
	public function create($address) {
		$address = $this->dao->db->build_key($address, $this->fields);
		return $this->dao->db->insert($address, $this->table_name);
	}
	/**
	 * 删除收货地址
	 * @param $ids 一个或者多个值
	 * @param $id_key 上面值的对应的键
	 */
	public function delete($id, $id_key = 'id') {
		$ids = explode(',', $id);
		return $this->dao->db->delete($ids, $this->table_name, $id_key);
	}

	/**
	 * 修改默认值
	 * @param $sql string
	 */
	public function updateDef($sql) {
		return $this->dao->db->get_all_sql($sql);
	}
}