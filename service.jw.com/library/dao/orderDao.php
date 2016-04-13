<?php

/**
 * 订单数据库
 *     －　延伸的DAO还有 orderGoodsDao \ orderActionDao
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-03-23 23:09:25
 */

class orderDao extends Dao
{
    public $table_name = 'order_info';
    private $fields    = "id,order_id,userid,pay_status,consignee,country,province,city,district,address,zipcode,mobile,order_remark,pay_name,order_num,pay_id,pay_no,pay_fee,bonus,bonus_id,order_amount,from_shopid,add_time,confirm_time,pay_time,is_use_coupons,coupons_total,is_cancel";

    /**
     * 获取一条数据
     * @param Array String $where 条件
     * @param String $fileds 需要获取的字段
     */
    public function get($where)
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->get_one_by_field($where, $this->table_name);
    }

    /**
     * 获取订单明细，包含商品信息
     * @param $where [订单主表的详细条件语句]
     * @return [type] [description]
     */
    public function getDetail($where)
    {

        $basic = self::get($where);

        if (!$basic) {
            return false;
        }

        $sql = array('order_id' => $basic['order_id']);

        $detail = InitPHP::getDao('orderGoods')->lists($sql);

        if (!$detail) {
            return false;
        }

        $basic['detail'] = $detail;

        return $basic;
    }
    /**
     * 添加一条记录
     * @param Array $data
     */
    public function create($data)
    {
        $data = $this->dao->db->build_key($data, $this->fields);
        return $this->dao->db->insert($data, $this->table_name);
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
     * 获取订单列表，以及订单的详情
     */
    public function lists($where = array('*'), $num = 20, $offset = 0, $orderby = 'id', $sort = 'DESC', $field = '*')
    {
        $temp = 0;
        if (isset($where['is_after_sales'])) {
            $aftersales['is_after_sales'] = $where['is_after_sales'];
            $temp                         = 1;
            unset($where['is_after_sales']);
        }

        $where = $this->dao->db->build_key($where, $this->fields);
        $limit = $this->dao->db->build_limit($offset, $num);
        $where = $this->dao->db->build_where($where);

        $sql = 'SELECT ' . $field . ' FROM ' . $this->table_name . $where . 'ORDER BY ' . $orderby . ' ' . $sort . ' ' . $limit;

        $orderLists[0] = $this->dao->db->get_all_sql($sql);

        for ($i = 0; $i < count($orderLists[0]); $i++) {
            if ($temp) {
                $orderLists[0][$i]['goods'] = array();
                $orderGoods                 = InitPHP::getDao('orderGoods')->lists(array('order_id' => $orderLists[0][$i]['order_id'], 'is_after_sales' => $aftersales['is_after_sales']));
                array_push($orderLists[0][$i]['goods'], $orderGoods);
            } else {
                $orderLists[0][$i]['goods'] = array();
                $orderGoods                 = InitPHP::getDao('orderGoods')->lists(array('order_id' => $orderLists[0][$i]['order_id']));
                array_push($orderLists[0][$i]['goods'], $orderGoods);
            }

        }
        $orderLists[1] = $this->dao->db->get_count($this->table_name, $where);
        return $orderLists;
    }

    /**
     * 获取订单商品
     */
    public function getOrderGoodsLists($where)
    {
        $where = $this->dao->db->build_where($where);
        $sql   = 'SELECT * FROM ' . $this->order_goods_table_name . $where;
        return $this->dao->db->get_all_sql($sql);
    }

    public function managerOrderlists($where = array('*'), $num = 20, $offset = 0, $orderby = 'id', $sort = 'DESC', $field = '*')
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        $limit = $this->dao->db->build_limit($offset, $num);
        if ($where['order_status'] == '') {
            $sql                  = 'SELECT ' . $field . ' FROM ' . $this->table_name . ' ' . 'ORDER BY ' . $orderby . ' ' . $sort . ' ' . $limit;
            $managerCollection[0] = $this->dao->db->get_all_sql($sql);
            $managerCollection[1] = $this->dao->db->get_count($this->table_name);

            for ($i = 0; $i < count($managerCollection[0]); $i++) {
                $managerCollection[0][$i]['goods'] = array();
                $orderGoods                        = InitPHP::getDao('orderGoods')->lists(array('order_id' => $managerCollection[0][$i]['order_id']));
                array_push($managerCollection[0][$i]['goods'], $orderGoods);
            }

            return $managerCollection;
        } else {
            $sql                  = 'SELECT ' . $field . ' FROM ' . $this->table_name . $this->dao->db->build_where($where) . 'ORDER BY ' . $orderby . ' ' . $sort . ' ' . $limit;
            $managerCollection[0] = $this->dao->db->get_all_sql($sql);
            $managerCollection[1] = $this->dao->db->get_count($this->table_name, $where);

            for ($i = 0; $i < count($managerCollection[0]); $i++) {
                $managerCollection[0][$i]['goods'] = array();
                $orderGoods                        = InitPHP::getDao('orderGoods')->lists(array('order_id' => $managerCollection[0][$i]['order_id']));
                array_push($managerCollection[0][$i]['goods'], $orderGoods);
            }

            return $managerCollection;
        }
    }

    /**
     * 开启事务
     */
    public function transaction_start()
    {
        $this->dao->db->transaction_start();
    }
    /**
     * 提交事务
     */
    public function transaction_commit()
    {
        return $this->dao->db->transaction_commit();
    }
    /**
     * 事务回滚
     */
    public function transaction_rollback()
    {
        $this->dao->db->transaction_rollback();
    }

}
