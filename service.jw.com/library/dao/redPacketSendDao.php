<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-22
 * 红包发送
 */

class redPacketSendDao extends Dao {
	public $table_name = 'red_packet_send';
	private $fields = "id,red_id,type,mobile,email,sendUser,sendTime,up,note,wx_no";

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
        return $this->dao->db->delete($where, $this->table_name, 'id');
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
     *　通过某一字段更新多条数据的某一字段属性
     * @param array $where　更新条件　更新字段组成的数组array(1,2,3,4)
     * @param array $data　更新数据
     * @param string $filed 更新字段
     */
    public function updateAttr($where,$data,$filed){
        return $this->dao->db->update_by_in_field($data, $filed, $where, $this->table_name);
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

    /**
     * 开启事务
     */
    public function transaction_start(){
        $this->dao->db->transaction_start();
    }
    /**
     * 提交事务
     */
    public  function transaction_commit(){
        return $this->dao->db->transaction_commit();
    }
    /**
     * 事务回滚
     */
    public  function  transaction_rollback(){
        $this->dao->db->transaction_rollback();
    }
}
