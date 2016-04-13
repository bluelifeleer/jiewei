<?php
/**
 * @Author: 邵博 提现记录
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-04-09 21:11:37
 */
class presentMannerDao extends Dao {
    public $table_name = 'present_manner';
     private $fields = "id,record_id,userid,cash,account_name,bank_address,manner_time,apply_time,payment_time,is_success,bank_name,bank_address,card_number";

    /**
     * 获取子集列表菜单
     * @param $user
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where,$num = 1000,$offset = 0,$order='id',$sort='desc',$key='id') {
        return $this->dao->db->get_all($this->table_name, $num, $offset, $where ,$order ,$sort,$key);
       // return $this->dao->db->get_all_sql('select * from '.$this->table_name);
    }
    /**
     * 获取一条店铺
     * @param $id int
     */
    public function get($id) {
        return $this->dao->db->get_one_by_field($id, $this->table_name);
    }

    /*
     *根据用户id获取店铺信息
     */
    public function getshop($id){
        if($id){
            $sql = array('id'=>$id);
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
   

    public function queryUp($sql){
        return $this->dao->db->query($sql);
    }

    /**
     * 修改提现记录
     * @param $address array
     * @param $id int
     */
    public function update($where,$id) {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->update($id, $where, $this->table_name,'id');
    }

    /**
     * [sumAmount 体现申请合计]
     * @param  [type]  $userid [用户id]
     * @param  integer $type   [类型 1 为所有 2 为未成功 3为成功]
     * @return [type]          [description]
     */
    public function sumAmount($userid,$type=1){
        $where = '';
        switch ($type) {
            case 1:
                $where = '';
                break;
            case 2:
                
                $where .= ' AND `is_success` = 1';
                break;
            case 3:
                $where .= ' AND `is_success` = 2';
                break;
            case 4:
                $where .= ' AND `is_success` = 99';
                break;
           
        }
        $sql    = 'SELECT SUM(`cash`) as total FROM ' . $this->table_name . ' WHERE `userid`=' . $userid . $where ;
        $result = $this->dao->db->get_all_sql($sql);
        $total  = $result[0]['total'];
        return $total;
    }
}
