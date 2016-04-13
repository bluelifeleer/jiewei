<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:00:54
 */
class adminPrivDao extends Dao {
	
	public $table_name = 'admin_private';
	private $fields = "id,role,chk,keyid";

	/**
	 * 获取列表
	 * @param $user
	 */
	public function lists($where,$offset = 0,$num = 1000,$order='id',$sort='desc',$key='id',$fileds='*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key,$fileds);
	}
	/**
	 * 获取用户
	 * @param $user
	 */
	public function get($id) {
		
		if(is_numeric($id)){
			$sql = array('id'=>$id);
		}else{
			$sql = $this->dao->db->build_key($id, $this->fields);
		}
		return $this->dao->db->get_one_by_field($sql, $this->table_name);
	}
	/**
	 * 获取单条信息
	 * @param $menuid
	 */
	public function get_one($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}
	/**
	 * 更新用户资料
	 * @param $user
	 */
	public function update($data,$where) {
		$data = $this->dao->db->build_key($data, $this->fields);
		if(!is_array($where))$where =array('id'=>$where);
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->update_by_field($data,$where, $this->table_name);
	}
	/**
	 * 新增用户
	 * @param $user
	 */
	public function create($user) {
		$user = $this->dao->db->build_key($user, $this->fields);
		return $this->dao->db->insert($user, $this->table_name);
	}
	/**
	 * 删除管理员
	 * @param $ids 一个或者多个值
	 * @param $id_key 上面值的对应的键
	 */
	public function delete($ids, $id_key = 'id'){
		$ids = explode(',',$ids);
		return $this->dao->db->delete($ids, $this->table_name,$id_key);
	}
}