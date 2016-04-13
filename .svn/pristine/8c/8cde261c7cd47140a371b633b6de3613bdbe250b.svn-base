<?php
/**
 * @Author: 明艺
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-03-14 17:41:22
 */
class categoriesDao extends Dao {

	public $table_name = 'category';
	private $fields = "catid,siteid,module,type,parentid,arrparentid,child,arrchildid,catname,image,description,url,items,hits,setting,listorder,letter";
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
		 * 批量删除多条记录
		 * @param Array $where array(1,2,3,4)
		 */
		public function deleteBatch($where){
				return $this->dao->db->delete($where, $this->table_name, 'catid');
		}
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
     * 更新一条数据
     * @param Array String $data 需要更新的数据
     * @param String $where 更新条件
     */
    public function update($data, $where) {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->update_by_field($data, $where, $this->table_name);
    }
    /**
     * 获取列表
     * @param $user
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where, $offset = 15, $num = 0, $sortname = 'catid', $sortorder='desc', $key='catid', $fileds='*') {
        return $this->dao->db->get_all($this->table_name, $offset, $num, $where, $sortname, $sortorder,$key,$fileds);
    }

}
