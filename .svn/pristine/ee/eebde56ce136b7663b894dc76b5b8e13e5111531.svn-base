<?php

/**
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-03-03 11:10:11
 */
class orderGoodsService extends Service
{
    private $DB;
    
    public function __construct() {
        parent::__construct();
        //获取Dao
        $this->DB = InitPHP::getDao('orderGoods');
    }
    
    /**
     * 获取单条订单
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where) {
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
    public function lists($where = array(), $offset = 0, $num = 1000, $order = '`og_id`', $sort = 'asc',$key='`og_id`', $fileds = '*') {
        return $this->DB->lists($where, $offset, $num, $order, $sort,$key,$fileds);
    }
    
    /**
     * 更新订单
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where) {
        return $this->DB->update($data, $where);
    }
    
    /**
     * 新增订单
     * @param  [array] $data [description]
     * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data) {
        return $this->DB->create($data);
    }
    
    /**
     * 删除订单
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($ids) {
        return $this->DB->delete($ids);
    }
    /**
     * [confirmReceipt 确认收货服务]
     * @param  [type] $orderid [订单id]
     * @param  [type] $goodsid [产品id]
     * @param  [type] $userid  [用户id]
     * @return [type]          [bool]
     * @author [李昊] <[<email address>]>
     */
    public function confirmReceipt($orderid,$goodsid,$userid){
        $where = array('order_id' => $orderid,'goods_id'=>$goodsid,'userid'=>$userid);
        $check = $this->DB->get($where);
        // 检查时候有该条订单 并且订单状态为3已发货
        if(isset($check) && $check['goods_status'] == 3){
            $data = array('goods_status' => 4);
            return $this->DB->update($data, $where);
        }
       return false;
    }

    
    /**
     * [confirmDelivery 确认发货]
     * @param  [int] $orderid [订单id]
     * @param  [int] $goodsid [订单产品id]
     * @param  [int] $shopid  [商家id]
     * @param  [array] $shippingInfo  [发货信息]
     * @return [type]          [bool]
     * @author [李昊] <[<email address>]>
     * @date   2016-4-9
     */
    public function confirmDelivery($orderid,$goodsid,$shopid,$shippingInfo){
        $where = array('order_id' => $orderid,'goods_id'=>$goodsid,'shop_id'=>$shopid,'from_id'=>$shopid);
        if(!is_array($shippingInfo)) return false;
        
        $check = $this->DB->get($where);
        if(isset($check) && $check['goods_status'] == 2){
            $data['shipping_name'] = $shippingInfo['shipping_name'];
            $data['shipping_no'] = $shippingInfo['shipping_no'];
            $data['shipping_time'] = $shippingInfo['shipping_time'];
            $data['shipping_com'] = $shippingInfo['shipping_com']?$shippingInfo['shipping_com']:'';
            $data['goods_status'] = 3;
            if($this->DB->update($data, $where)){
                return InitPHP::Encode(0, 'Success', $check);
            }
        }
        return false;
    }


    public function myAmount($shopid){
        $salesAmount = $this->DB->sumAmount($shopid);
        $frozenAmount = $this->DB->sumAmount($shopid,2);

        $return = array('salesAmount' => $salesAmount, 'myfrozenAmount' => $frozenAmount);
        return InitPHP::Encode(0, 'Success', $return, 1);
    }
    //public function createMoll
}
