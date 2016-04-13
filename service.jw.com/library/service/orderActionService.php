<?php

/**
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-02-18 14:17:52
 */
class orderActionService extends Service
{
    private $DB;

    public function __construct()
    {
        parent::__construct();
        //获取Dao
        $this->DB = InitPHP::getDao('orderAction');
    }

    /**
     * 获取单条订单
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where)
    {
        return $this->DB->get($where);
    }

    /**
     * 获取订单列表
     * @param  array   $where  [description]
     * @param  integer $offset [description]
     * @param  integer $num    [description]
     * @param  string  $order  [description]
     * @param  string  $sort   [description]
     * @param  string  $key    [description]
     * @param  string  $fileds [description]
     * @return [array]          [description]
     */
    public function lists($where = array(), $offset = 0, $num = 1000, $order = 'role', $sort = 'asc', $key = 'role', $fileds = '*')
    {
        return $this->DB->lists($where, $offset, $num, $order, $sort, $key, $fileds);
    }

    /**
     * 更新订单
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where)
    {
        return $this->DB->update($data, $where);
    }

    /**
     * 新增订单
     * @param  [array] $data [description]
     * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data)
    {
        return $this->DB->create($data);
    }

    /**
     * 删除订单
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($ids)
    {
        return $this->DB->delete($ids);
    }
}
