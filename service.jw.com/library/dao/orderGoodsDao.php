<?php

/**
 * 订单数据库
 *     －　延伸的DAO还有 orderGoodsDao \ orderActionDao
 * @Author 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-24 21:29:18
 */

class orderGoodsDao extends Dao
{
    public $table_name = 'order_goods';
    private $fields    = "og_id,order_id,goods_id,goods_from_id,goods_name,goods_sn,goods_number,goods_price,goods_attr,goods_level,is_real,is_gift,is_send,userid,YunUser,goods_pic,order_total,cost_price,goods_status,purchase_price,shipping_id,shipping_com,shipping_name,shipping_no,shipping_fee,shipping_time,from_id,is_comment,shop_id,is_after_sales,is_over";

    /**
     * 添加一条记录
     * @param Array $data
     */
    public function create($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $insertData   = $this->dao->db->build_key($data[$i], $this->fields);
            $insertStatus = $this->dao->db->insert($insertData, $this->table_name);
        }
        return $insertStatus;
    }

    /**
     * 删除一条记录
     * @param Array $where
     */
    public function delete($where)
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->delete_by_field($where, $this->table_name);
    }

    /**
     * 获取一条数据
     * @param Array String $where 条件
     * @param String $fileds 需要获取的字段
     */
    public function get($where, $fileds = '*')
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->get_one_by_field($where, $this->table_name, $fileds);
    }

    /**
     * 更新一条数据
     * @param Array String $data 需要更新的数据
     * @param String $where 更新条件
     */
    public function update($data, $where)
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        $data  = $this->dao->db->build_key($data, $this->fields);
        return $this->dao->db->update_by_field($data, $where, $this->table_name);
    }

    /**
     * 获取列表
     * @param $proLevel
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where, $offset = 15, $num = 0, $sortname = 'og_id', $sortorder = 'desc', $fileds = '*')
    {
        $where = $this->dao->db->build_where($where);
        return $this->dao->db->get_all($this->table_name, $offset, $num, $where, $sortname, $sortorder, 'og_id', $fileds);
    }

    /**
     *特殊查询
     */
    public function select($where, $fields = '*', $limit = false, $order = "og_id desc")
    {
        if (is_array($where)) {
            $where = $this->dao->db->build_key($where, $this->fields);
        }

        return $this->dao->db->get_all_sql("SELECT " . $fields . " FROM `" . $this->table_name . "` WHERE " . $where . " ORDER BY " . $order . ($limit ? ' LIMIT ' . $limit : ''));
    }

    /**
     * [sum 统计数值]
     * @param  [type] $userid [sql语句]
     * @return [type] $type    [1:店铺所有的,2：店铺自营的，]
     */
    public function sumAmount($shopid, $type = 1 )
    {
        $where = '';
        switch ($type) {
            case 1:
                $where = ' AND goods_status > 1';
                break;
            case 2:
                $where = ' AND `from_id` = '.$shopid . ' AND goods_status > 1' ;
                break;
            
        }
        $sql    = 'SELECT SUM(`order_total`) + SUM(`shipping_fee`) as total FROM ' . $this->table_name . ' WHERE `shop_id`=' . $shopid . $where ;
        $result = $this->dao->db->get_all_sql($sql);
        $total  = $result[0]['total'];
        
        return $total;
    }
}
