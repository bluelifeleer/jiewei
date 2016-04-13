<?php
/**
 * @Author: 邵博
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-03-09 23:08:32
 */
class shopDao extends Dao {

    public $table_name = 'shop';
    private $fields = "userid,name,username,satisfy,start_time,qq,wechat,phone,address,avatar,sex,desc";

    /**
     * 获取子集列表菜单
     * @param $user
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where,$num = 1000,$offset = 0,$order='userid',$sort='desc',$key='userid') {
        return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key);
       // return $this->dao->db->get_all_sql('select * from '.$this->table_name);
    }
    /**
     * 获取一条店铺
     * @param $id int
     */
    public function get($id) {
        // if(intval($id) > 0){
        //     $sql = array('userid'=>$id);
        // }else{
        //     $sql = $this->dao->db->build_key($id, $this->fields);
        // }
        return $this->dao->db->get_one_by_field($id, $this->table_name);
    }

    /*
     *根据用户id获取店铺信息
     */
    public function getshop($id){
        if($id){
            $sql = array('userid'=>$id);
        }else{
            $sql = $this->dao->db->build_key($id, $this->fields);
        }
        return $this->dao->db->get_one_by_field($sql, $this->table_name);
    }
    /**
     * 获取某个字段的值
     * @param $where array
     */
    public function get_User_by_field($where) {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->get_one_by_field($where, $this->table_name);
    }
    /**
     * 修改店铺
     * @param $address array
     * @param $id int
     */
    // public function update($where,$id) {
    //     $where = $this->dao->db->build_key($where, $this->fields);
    //     return $this->dao->db->update($id, $where, $this->table_name,'userid');
    // }

    /**
     *  根据字段修改店铺
     */
    public function updateField($data, $where) {
        return $this->dao->db->update_by_field($data, $where, $this->table_name);
    }

    /**
     * 新增店铺
     * @param $address array
     */
    public function create($shopInfo) {
        $shopInfo = $this->dao->db->build_key($shopInfo, $this->fields);
        return $this->dao->db->insert($shopInfo, $this->table_name);
    }
    /**
     * 删除店铺
     * @param $userid 一个或者多个值
     * @param 
     */
    public function delete($userid){
        //$ids = explode(',',$ids);
        return $this->dao->db->delete_by_field($userid, $this->table_name);
    }

     /**
     * 开启事务
     */
    public function transaction_start(){
        return $this->dao->db->transaction_start();
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
        return $this->dao->db->transaction_rollback();
    }
    /**
     * 根据sql语句查询
     * @param [array] $where [条件]
     */
    public function query_select($where,$limit,$offset) {
      // return "select * from `".$this->table_name."` where ".$where.' ORDER BY userid desc limit '.$limit.','.$offset;
      $info[0] = (array)$this->dao->db->get_all_sql("select * from `".$this->table_name."` where ".$where.' ORDER BY userid desc limit '.$limit.','.$offset);
      $count = $this->dao->db->get_all_sql("SELECT COUNT(*) as count FROM `".$this->table_name."` WHERE ".$where);
      $info[1] = intval($count[0]['count']);
      return $info;
    }

    public function queryUp($sql){
        return $this->dao->db->query($sql);
    }
}
