<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:01:05
 */
class adminRoleDao extends Dao {
	
	public $table_name = 'admin_role';
	private $fields = "role,name,remark";
	/**
	 * 获取单条
	 * @param $role
	 */
	public function get($role) {
		if(intval($role) > 0){
			$sql = array('role'=>$role);
		}else{
			$sql = $this->dao->db->build_key($role, $this->fields);
		}
		return $this->dao->db->get_one_by_field($sql, $this->table_name);
	}
	/**
	 * 列表
	 * @param $where
	 * @param $offset
	 * @param $num
	 * @param $order
	 * @param $sort
	 * @param $key  
	 * @param $fileds  返回字段
	 */
	public function lists($where,$offset = 0,$num = 1000,$order='role',$sort='asc',$key='role',$fileds='*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key,$fileds);
	}

	
	/**
	 * 更新
	 * @param $data
	 * @param $id
	 */
	public function update($data,$id) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update($id,$data, $this->table_name,'role');
	}
	/**
	 * 新增
	 * @param $data
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}
	/**
	 * 删除
	 * @param $ids 一个或者多个值
	 * @param $id_key 上面值的对应的键
	 */
	public function delete($ids, $id_key = 'role'){
		$ids = explode(',',$ids);
		return $this->dao->db->delete($ids, $this->table_name,$id_key);
	}
}