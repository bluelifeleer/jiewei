<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:00:43
 */
class adminDao extends Dao {
	
	public $table_name = 'admin';
	private $fields = "userid,username,password,encrypt,role,lastlogin,ip,truename,email,tel,mobile,remark";
	/**
	 * 获取子集列表菜单
	 * @param $user
	 * @param $num 每次查询偏移量
	 * @param $offset 分页量
	 * LIMIT $num,$offset
	 */
	public function lists($where,$offset = 0,$num = 1000,$order='userid',$sort='desc',$key='userid',$fileds='*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key,$fileds);
	}
	/**
	 * 获取用户
	 * @param $user
	 */
	public function get($userid) {
		if(intval($userid) > 0){
			$sql = array('userid'=>$userid);
		}else{
			$sql = $this->dao->db->build_key($userid, $this->fields);
		}
		return $this->dao->db->get_one_by_field($sql, $this->table_name);
	}

	/**
	 * 获取用户 by where 
	 * @param $user
	 */
	public function get_User_by_field($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}
	/**
	 * 更新用户资料
	 * @param $user
	 */
	public function update($user,$userid) {
		$user = $this->dao->db->build_key($user, $this->fields);
		return $this->dao->db->update($userid,$user, $this->table_name,'userid');
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
	public function delete($id, $id_key = 'userid'){
		$ids = explode(',',$ids);
		return $this->dao->db->delete($ids, $this->table_name,$id_key);
	}
}