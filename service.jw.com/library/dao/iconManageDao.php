<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-22
 * icon管理
 */

class iconManageDao extends Dao {
	public $table_name = 'icon_manage';
	private $fields    = "id,name,desc,path";

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
     * @param 
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where = array(''),$num = 10,$offset = 0,$is_key = 'id',$sort = 'DESC'){
         $where = $this->dao->db->build_key($where,$this->fields);
         return $this->dao->db->get_all($this->table_name,$num,$offset,$where,$is_key,$sort);
    }

    /**
     * 执行sql语句查询
     * @param $sql 字符串 sql语句条件
     */
    public function query_select($where) {
        $info = $this->dao->db->get_all_sql("select * from `".$this->table_name."` where path LIKE '%,".$where."%'");
        return $info;
    }
}
