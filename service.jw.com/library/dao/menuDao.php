<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:02:08
 */
class menuDao extends Dao {
	
	public $table_name = 'menu';
	private $fields = "menuid,pid,name,m,c,a,data,sort,display,isopenid";
	/**
	 * 获取单条信息
	 * @param $menuid
	 */
	public function get($menuid) {
		if((int)$menuid > 0){
			$sql = array('menuid'=>$menuid);
		}else{
			$sql = $this->dao->db->build_key($menuid, $this->fields);
		}
		
		return $this->dao->db->get_one_by_field($sql, $this->table_name);
	}

	/**
	 * 获取列表
	 * @param $where
	 */
	public function lists($where,$offset = 0,$num = 1000,$order='sort',$sort='asc',$key='menuid',$fileds='*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,'menuid',$fileds);
	}
	/**
	 * 更新菜单
	 * @param $data
	 * @param $where
	 */
	public function update($data,$where) {
		$data = $this->dao->db->build_key($data, $this->fields);
		if(!is_array($where))$where =array('menuid'=>$where);
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->update_by_field($data,$where, $this->table_name);
	}
	/**
	 * 新增菜单
	 * @param $data
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}
	/**
	 * 删除菜单
	 * @param $ids 一个或者多个值
	 * @param $id_key 上面值的对应的键
	 */
	public function delete($ids, $id_key = 'menuid'){
		$ids = explode(',',$ids);
		return $this->dao->db->delete($ids, $this->table_name,$id_key);
	}
}