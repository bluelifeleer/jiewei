<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:00:43
 */
class openShopBonusDao extends Dao {
	
	public $table_name = 'open_shop_bonus';
	private $fields = "id,money,userid,uid_2,level_2,bonus_2,uid_3,level_3,bonus_3,less,inputtime";
	/**
	 * 获取子集列表菜单
	 * @param $user
	 * @param $num 每次查询偏移量
	 * @param $offset 分页量
	 * LIMIT $num,$offset
	 */
	public function lists($where,$offset = 0,$num = 1000,$order='id',$sort='desc',$key='id',$fileds='*') {
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key,$fileds);
	}

	/**
	 * 获取是否有插入数据
	 * @param $order_id
	 * @return 存在数据返回假，不存在返回真
	 */
	public function checkOrder($id){
		if($this->get(array('id'=>$id))){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * 获取单条记录
	 * @param $user
	 */
	public function get($id) {
		if(intval($userid) > 0){
			$sql = array('id'=>$id);
		}else{
			$sql = $this->dao->db->build_key($id, $this->fields);
		}
		return $this->dao->db->get_one_by_field($sql, $this->table_name);
	}

	/**
	 * 获取 
	 * @param $user
	 */
	public function get_User_by_field($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}
	/**
	 * 更新
	 * @param $user
	 */
	public function update($data,$id) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update($id,$data, $this->table_name,'id');
	}
	/**
	 * 新增一条
	 * @param $user
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
	public function delete($id, $id_key = 'id'){
		$ids = explode(',',$id);
		return $this->dao->db->delete($ids, $this->table_name,$id_key);
	}
}