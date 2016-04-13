<?php
/**
 * 设置表
 * @author seaven
 * @Date 215.5.25
 */
class settingDao extends Dao {

	public $table_name = 'setting';
	private $fields    = "key,value,app,description";
	/**
	 * 获取数据
	 * @param String $where (条件)
	 */
	public function get_setting($where) {
		if (!$where) {
			$where = '';
		} else {
			$where = " WHERE `keys` IN($where)";
		}
		$sql = sprintf("SELECT * FROM %s %s", '`'.$this->table_name.'`', $where);
		return $this->dao->db->get_all_sql($sql);
	}
	/**
	 * 更新数据
	 */
	public function update_setting($data, $where) {
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}
}