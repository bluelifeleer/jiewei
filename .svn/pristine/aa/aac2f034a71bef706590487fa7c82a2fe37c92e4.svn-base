<?php
/**
 * 支付插件管理数据表
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-29 15:21:38
 * 
 * `pay_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付插件标识id',
 * `name` varchar(120) NOT NULL COMMENT '支付插件标识',
 * `pay_name` varchar(120) NOT NULL,
 * `config` text NOT NULL,
 */

class paymentDao extends Dao {
    public $table_name = 'pay_payment';
    private $fields    = "pay_id,name,pay_name,config";
    
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
    public function lists($where,  $num = 0, $offset = 15, $sortname = 'pay_id', $sortorder, $fileds) {
        return $this->dao->db->get_all($this->table_name, $num, $offset,  $where, $sortname, $sortorder, $fileds);
    }

}