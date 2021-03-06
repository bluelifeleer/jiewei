<?php
/**
 * @Author: 刘波
 * @Date:   2015-06-04 12:14:10
 * @Last Modified time: 2016-01-11 21:00:43
 */
class orderBonusDao extends Dao
{

    public $table_name = 'order_bonus';
    private $fields    = "id,order_id,goods_id,goods_name,goods_sn,goods_number,goods_price,goods_level,goods_pic,order_total,cost_price,purchase_price,uid_1,level_1,uid_2,level_2,bonus_2,uid_3,level_3,bonus_3,siteid,site_level,site_bonus,bonus,system_bonus,less_bonus,inputtime,shipping_time,status,formula,pay_time";
    
    /**
     *特殊查询
     */
    public function select($where, $fields = '*', $limit = false, $order = "id desc")
    {
        if (is_array($where)) {
            $where = $this->dao->db->build_key($where, $this->fields);
        }
        return $this->dao->db->get_all_sql("SELECT " . $fields . " FROM `" . $this->table_name . "` WHERE " . $where . " ORDER BY " . $order . ($limit ? ' LIMIT ' . $limit : ''));
    }
    /**
     *特殊查询
     */
    public function query($sql)
    {
        return $this->dao->db->get_all_sql($sql);
    }

    /**
     * 获取子集列表菜单
     * @param $user
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where, $offset = 0, $num = 1000, $order = 'id', $sort = 'desc', $key = 'id', $fileds = '*')
    {
        return $this->dao->db->get_all($this->table_name, $num, $offset, $where, $order, $sort, $key, $fileds);
    }

    /**
     * 获取是否有插入数据
     * @param $order_id
     * @return 存在数据返回假，不存在返回真
     */
    public function checkOrder($order_id,$goods_id)
    {
        if ($this->get(array('order_id' => $order_id,'goods_id'=>$goods_id))) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * 获取单条记录
     * @param $user
     */
    public function get($id)
    {
        if (intval($userid) > 0) {
            $sql = array('id' => $id);
        } else {
            $sql = $this->dao->db->build_key($id, $this->fields);
        }
        return $this->dao->db->get_one_by_field($sql, $this->table_name);
    }

    /**
     * 获取
     * @param $user
     */
    public function get_User_by_field($where)
    {
        $where = $this->dao->db->build_key($where, $this->fields);
        return $this->dao->db->get_one_by_field($where, $this->table_name);
    }
    /**
     * 更新
     * @param $user
     */
    public function update($data, $id)
    {
        $data = $this->dao->db->build_key($data, $this->fields);
        return $this->dao->db->update($id, $data, $this->table_name, 'id');
    }
    /**
     * 新增一条
     * @param $user
     */
    public function create($data)
    {
        $data = $this->dao->db->build_key($data, $this->fields);
        return $this->dao->db->insert($data, $this->table_name);
    }

    /**
     * 删除
     * @param $ids 一个或者多个值
     * @param $id_key 上面值的对应的键
     */
    public function delete($id, $id_key = 'id')
    {
        $ids = explode(',', $id);
        return $this->dao->db->delete($ids, $this->table_name, $id_key);
    }

    /**
     * [sum 统计数值]
     * @param  [type] $userid [sql语句]
     * @return [type] $type    [1:终身,2：月，3：天 4冻结金额]
     */
    public function sumAmount($userid, $type = 1)
    {
        $where = '';
        switch ($type) {
            case 1:
                $where = '';
                break;
            case 2:
                $start = strtotime(date('Y/m/01 00:00:01', time()));
                $where .= ' AND `inputtime` BETWEEN ' . $start . ' AND ' . time();
                break;
            case 3:
                $start = strtotime(date('Y/m/d 00:00:01', time()));
                $where .= ' AND `inputtime` BETWEEN ' . $start . ' AND ' . time();
                break;
            case 4:
                $where .= ' AND `pay_time` = 0';
                break;
        }
        $sql    = 'SELECT SUM(`bonus_2`) as total FROM ' . $this->table_name . ' WHERE `uid_2`=' . $userid . $where . ' UNION SELECT SUM(`bonus_3`) AS total FROM ' . $this->table_name . ' WHERE `uid_3` = ' . $userid . $where;
        $result = $this->dao->db->get_all_sql($sql);
        $total  = 0;
        foreach ($result as $value) {
            $total += $value['total'];
        }
        return $total;
    }

     /**
     * [sum 统计数值]
     * @param  [type] $userid [sql语句]
     * @return [type] $type    [1:终身,2：月，3：天 4所有冻结金额]
     */
    public function sumMyAmount($siteid, $type = 1 )
    {
        $where = '';
        switch ($type) {
            case 1:
                $where = '';
                break;
            case 2:
                $start = strtotime(date('Y/m/01 00:00:01', time()));
                $where .= ' AND `inputtime` BETWEEN ' . $start . ' AND ' . time();
                break;
            case 3:
                $start = strtotime(date('Y/m/d 00:00:01', time()));
                $where .= ' AND `inputtime` BETWEEN ' . $start . ' AND ' . time();
                break;
            case 4:
                $where .= ' AND `pay_time` = 0';
                break;
        }
        $sql    = 'SELECT SUM(`site_bonus`) as total FROM ' . $this->table_name . ' WHERE `siteid`=' . $siteid . $where ;
        $result = $this->dao->db->get_all_sql($sql);
        $total  = $result[0]['total'];
        
        return $total;
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
