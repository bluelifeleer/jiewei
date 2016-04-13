<?php

/**
 * 物流系统服务层
 * @Author: 明艺
 * @Date:   2015-12-26 15:21:40
 * @Last Modified time: 2016-01-01 20:12:01
 */
class logisticsService extends Service{

    public function __construct() {
        parent::__construct();
        //获取Dao
        $this->orderDB = InitPHP::getDao('order');
        $this->logisticsDB = InitPHP::getDao('logistics');
    }
    
    /**
     * 获取物流记录
     * @param  [array] $orderid [订单id]
     * @return [array]          [查询结果]
     */
    public function search($orderid) {
        $data = $this->orderDB->get($orderid);//获取订单详情

        $id = '107729';
        $secret = '407fcd35720a4a45d5c28def297d8c50';
        $com = $data['shipping_com'];//快递公司
        $nu = $data['invoice_no'];//快递单号
        $type = 'json';
        $encode = 'utf8';
        $url = 'http://api.ickd.cn/?id='.$id.'&secret='.$secret.'&com='.$com.'&nu='.$nu.'&type='.$type.'&encode='.$encode;

        $return = file_get_contents($url);

        return $return;
    }

    /**
     * 获取单条物流公司
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where) {
        return  $this->logisticsDB->get($where);
    }
    
    /**
     * 获取子集列表物流公司
     * @param  array   $where  [description]
     * @param  integer $offset [description]
     * @param  integer $num    [description]
     * @param  string  $order  [description]
     * @param  string  $sort   [description]
     * @param  string  $key    [description]
     * @param  string  $fileds [description]
     * @return [array]         [description]
     */
    public function lists($where = array(), $offset = 0, $num = 1000, $order = 'id', $sort = 'asc', $key = 'id', $fileds = '*') {
        return $this->logisticsDB->lists($where, $offset, $num, $order, $sort, $key, $fileds);
    }
    
    /**
     * 更新物流公司
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where) {
        return $this->logisticsDB->update($data, $where);
    }
    
    /**
     * 新增物流公司
     * @param  [array] $data [description]
     * @return [boolen or int] [成功则返回主键自增id，失败则返回flase]
     */
    public function create($data) {
        return $this->logisticsDB->create($data);
    }
    
    /**
     * 删除物流公司
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($ids) {
        return $this->logisticsDB->delete($ids);
    }
}