<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-22
 * 商品
 */

class productDetailsDao extends Dao {
	public $table_name = 'product_details';
	private $fields = "id,pro_id,content,params";
	
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
     * @param $proLevel
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where, $offset = 15, $num = 0, $sortname = 'id', $sortorder, $fileds) {
        return $this->dao->db->get_all($this->table_name, $offset, $num, $where, $sortname, $sortorder, 'id',$fileds);
    }
    
    /**
     * 执行sql语句查询
     * @param $sql 字符串 sql语句条件
     */
    public function query_select($where) {
        $info = $this->dao->db->get_all_sql("select * from `".$this->table_name."` where  `path` LIKE '%,".$where."%'");
        return $info;
    }
}