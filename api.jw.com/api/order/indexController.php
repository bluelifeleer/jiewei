<?php
class indexController extends Controller
{
    public $initphp_list = array('recharge', 'confirmPay', 'get', 'orderLists', 'addOrder', 'getOrderGoodsLists', 'confirmReceipt', 'ShoporderLists', 'ShopconfirmReceipt', 'cancelOrder', 'deleteOrder', 'orderGoodsShipping', 'orderIsExists', 'payOrder');

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加充值订单
     * @using http://api.jw.com/order/index/recharge
     * @param [integer] $userid [会员id]
     * @param
     * @return [boolean] $status [添加充值订单是否成功]
     * @author 李鹏
     * @date 2016-01-06
     */
    public function recharge()
    {
        $value     = array('userid', 'username');
        $data      = $this->controller->get_gp($value, 'P');
        $orderData = array(
            'userid'          => $data['userid'], //会员id
            'order_sn'        => create_sn(), //订单号
            'parent_id'       => 0, //会员上级id
            'order_status'    => 0, //订单状态
            'shipping_status' => 0, //商品配送状态
            'pay_status'      => 0, //支付状态
            'consignee'       => $data['username'], //收货人姓名
            'order_remark'    => '加入会员充值缴费', //订单备注
            'shipping_id'     => 0, //配送方式id
            'pay_id'          => 0, //支付方式id
            'pay_name'        => '余额支付', //支付名称
            'shipping_fee'    => 0, //配送费用
            'pay_fee'         => 580, //支付费用
            'surplus'         => 0, //余额支付金额
            'order_amount'    => 580, //应付款金额
            'add_time'        => time(), //订单生成时间
            'confirm_time'    => 0, //订单确认时间
            'pay_time'        => 0, //订单支付时间
            'shipping_time'   => 0, //订单配送时间
            'invoice_no'      => '', //发货单号
            'order_type'      => 1, //订单类型
        );

        $create_status = InitPHP::getRemoteService('order', 'create', array($orderData));
        if ($create_status['code'] == 0) {
            //将返回的id添加到订单信息数组中
            $orderData['id'] = $create_status['data'];
            $data            = json_encode($orderData);
            InitPHP::Encode(0, 'Success', $data);
        } else {
            InitPHP::Encode(1, '请求失败，请稍后再试', '');
        }

    }

    /**
     * 确认支付订单
     */
    public function confirmPay()
    {
        $value     = array('userid');
        $data      = $this->controller->get_gp($value, 'G');
        $where     = array('userid' => intval($data['userid']));
        $updata    = array('confirm_time' => time(), 'pay_status' => 1);
        $payStatus = InitPHP::getRemoteService('order', 'update', array($updata, $where));
        if ($payStatus['code'] == 0) {
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }

    }

    /**
     * 获取订单信息
     * @using http://api.jw.com/order/index/get
     * @param [integer] $orderid [订单id]
     * @param [string] $userid [用户id]
     * @return [array] $result [返回查询的数据]
     * @author 李鹏
     * @date 2016-01-21
     */
    public function get()
    {
        $userid    = $this->getUtil('session')->get('_userid');
        $value     = array('order_id','is_shop');
        $data      = $this->controller->get_gp($value, 'G');
        if(isset($data['is_shop']) && !empty($data['is_shop'])){
            $where     = array('shop_id' => $userid, 'order_id' => trim($data['order_id']));
        }else{
            $where     = array('userid' => $userid, 'order_id' => trim($data['order_id']));
        }
        $orderInfo = InitPHP::getRemoteService('order', 'get', array($where,true));
        if ($orderInfo['code'] == 0) {
            $orderInfo['data']['add_time']      = $orderInfo['data']['add_time'] != 0 ? date('Y-m-d H:i:s', $orderInfo['data']['add_time']) : '';
            $orderInfo['data']['confirm_time']  = $orderInfo['data']['confirm_time'] != 0 ? date('Y-m-d H:i:s', $orderInfo['data']['confirm_time']) : '';
            $orderInfo['data']['pay_time']      = $orderInfo['data']['pay_time'] != 0 ? date('Y-m-d H:i:s', $orderInfo['data']['pay_time']) : '';
            $orderInfo['data']['shipping_time'] = $orderInfo['data']['shipping_time'] != 0 ? date('Y-m-d H:i:s', $orderInfo['data']['shipping_time']) : '';
            InitPHP::Encode(0, 'Success', $orderInfo['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }

    }

    /**
     * 获取所有订单
     * @using http://api.jw.com/order/index/orderLists
     * @param [string] $userid [用户id]
     * @param [integer] $num [获取数据数量]
     * @param [integer] $offset [设置查询偏移]
     * @param [string] $is_key [默认的排序关键字]
     * @param [string] $sort [排序方式，默认DESC]
     * @return [array] $lists [获取到一组数据]
     * @author 李鹏
     * @date 2016-10-21
     */
    public function orderLists()
    {
        $userid       = $this->getUtil('session')->get('_userid');
        $get_gp_value = array('num', 'offset', 'order_type');
        $data         = $this->controller->get_gp($get_gp_value, 'G');
        $page         = isset($data['num']) && (int) $data['num'] != 0 ? intval($data['num']) : 1;
        $offset       = isset($data['offset']) && (int) $data['offset'] != 0 ? intval($data['offset']) : 0;
        $order_type   = (int) $data['order_type'];
        $limit        = ($page - 1) * $offset;
        //谁，状态，条数，偏移
        $orderLists = InitPHP::getRemoteService('order', 'lists', array($userid, $order_type, $limit, $offset));

        if ($orderLists['code'] == 0) {
            InitPHP::Encode(0, 'Success', $orderLists['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 删除一条数据
     * @using http://api.jw.com/order/index/delete
     * @method [string] GET [请求方式]
     * @param [string] $userid [用户id]
     * @papram [integer] $orderid [订单id]
     * @return [boolean] $deleteStatus [删除状态]
     */
    public function delete()
    {
        //获取session中的用户id
        $userid       = $this->getUtil('session')->get('_userid');
        $value        = array('order_id');
        $data         = $this->controller->get_gp($value, 'G');
        $deleteStatus = InitPHP::getRemoteService('order', 'delete', array($userid, intval($data['order_id'])));

        if ($deleteStatus['code'] == 0) {
            InitPHP::Encode(0, 'Success', $deleteStatus['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 添加一条订单信息
     *
     */

    public function addOrder()
    {
        $username         = $this->getUtil('session')->get('_nickname');
        $userid           = $this->getUtil('session')->get('_userid');
        $value            = array('addressId', 'amount', 'productNum', 'comment', 'siteid', 'productInfo');
        $data             = $this->controller->get_gp($value, 'P');
        $data['userid']   = $userid;
        $data['username'] = $username;

        // 波哥看 YunUser 是传过来的都是1
        $memberInfo = InitPHP::getRemoteService('account', 'get', array(array('userid' => trim($data['userid']))));

        $data['userid']   = $userid;
        $data['username'] = $username;
        $data['YunUser']  = $memberInfo['data']['parentid'];
        // var_dump($memberInfo);exit;
        // 波哥看 结束

        $insertOrderId = InitPHP::getRemoteService('order', 'addPorductOrder', array($data));

        if ($insertOrderId['code'] == 0) {
            InitPHP::Encode(0, 'Success', $insertOrderId['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 支付订单
     * @return [type] [description]
     */
    public function payOrder()
    {
        $userid   = $this->getUtil('session')->get('_userid');
        $userName = $this->getUtil('session')->get('_username');
        $value    = array('order_id', 'is_coupon', 'coupon_id', 'is_red_packets', 'red_packets_id');
        $data     = $this->controller->get_gp($value, 'P');
        //查询优惠券金额
        $redPacketsTotal = 0;
        if (intval($data['is_coupon']) == 1) {
            $redPacketsTotal = InitPHP::getRemoteService('coupon', 'get', array(array('coupon_id' => $data['coupon_id'])));
        } else {
            $redPacketsTotal = 0;
        }
        //查询红包金额
        $couponTotal = 0;
        if (intval($data['is_red_packets']) == 1) {
            $couponTotal = InitPHP::getRemoteService('redPacket', 'get', array(array('red_id' => intval($data['red_packets_id']))));
        } else {
            $couponTotal = 0;
        }
        //查询订单信息
        $orderInfo = InitPHP::getRemoteService('order', 'get', array(array('order_id' => $data['order_id'])));

        $payFree = sprintf('%01.2f', ($orderInfo['data']['order_amount'] - $couponTotal - $redPacketsTotal));
        $where   = array(
            'userid'   => $userid,
            'username' => $userName,
            'order_id' => $data['order_id'],
            'pay_free' => $payFree,
        );
        $payStatus = InitPHP::getRemoteService('pay', 'payOrder', array($where));
        if ($payStatus) {
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 获取订单中的商品列表
     */
    public function getOrderGoodsLists()
    {
        $value      = array('order_id');
        $data       = $this->controller->get_gp($value, 'G');
        $where      = array('order_id' => $data['order_id']);
        $orderGoods = InitPHP::getRemoteService('order', 'getOrderGoodsLists', array($where));
        if ($orderGoods[code] == 0) {
            InitPHP::Encode(0, 'Success', $orderGoods['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 确认收货->对应商品
     * @param [array] $data [更改数据]
     * @param [array] $where [更改条件]
     * @return [boolean] $confirm [返回更改的状态]
     * @author 李鹏
     * @date 2016-02-19
     * @modify 李昊
     * @modify_date 2016-4-9
     */
    public function confirmReceipt()
    {
        $value  = array('order_id','goods_id');
        $data   = $this->controller->get_gp($value, 'G');
        $userid = $this->getUtil('session')->get('_userid');
        $goodsid = $data['goods_id'];
        $orderid = $data['order_id'];
        if(!$goodsid || !$orderid){ InitPHP::Encode(1, 'Error', '缺少必要参数'); }
        // 修改为按照产品来发货
        $confirm = InitPHP::getRemoteService('orderGoods', 'confirmReceipt', array($orderid,$goodsid,$userid));
        if($confirm){
            InitPHP::Encode(0, 'Success', '');
        }else{
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 获取所有订单 商铺
     * @using http://api.jw.com/order/index/ShoporderLists
     * @param [string] $userid [用户id]
     * @param [integer] $num [获取数据数量]
     * @param [integer] $offset [设置查询偏移]
     * @param [string] $is_key [默认的排序关键字]
     * @param [string] $sort [排序方式，默认DESC]
     * @return [array] $lists [获取到一组数据]
     * @author 邵博
     * @date 2016-1-21
     */
    public function ShoporderLists()
    {
        $userid     = $this->getUtil('session')->get('_userid');
        $value      = array('num', 'offset', 'is_key', 'sort', 'order_type', 'field');
        $data       = $this->controller->get_gp($value, 'G');
        $num        = isset($data['num']) && $data['num'] != '' ? intval($data['num']) : 20;
        $offset     = isset($data['offset']) && $data['offset'] != '' ? intval($data['offset']) : 0;
        $is_key     = isset($data['is_key']) && $data['is_key'] != '' ? $data['is_key'] : 'id';
        $sort       = isset($data['sort']) && $data['sort'] != '' ? $data['sort'] : 'DESC';
        $where      = isset($data['order_type']) && $data['order_type'] != '' ? array('from_shopid' => $userid, 'order_status' => intval($data['order_type'])) : array('from_shopid' => $userid);
        $field      = isset($data['field']) && $data['field'] != '' ? $data['field'] : '*';
        $orderLists = InitPHP::getRemoteService('order', 'lists', array($where, $num, $offset, $is_key, $sort, $field));
        if ($orderLists['code'] == 0) {
            InitPHP::Encode(0, 'Success', $orderLists[data][0]);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 确认收货 -？
     * @param [array] $data [更改数据]
     * @param [array] $where [更改条件]
     * @return [boolean] $confirm [返回更改的状态]
     * @author 李鹏
     * @date 2016-02-19
     */
    public function ShopconfirmReceipt()
    {
        $value  = array('order_id');
        $data   = $this->controller->get_gp($value, 'G');
        $userid = $this->getUtil('session')->get('_userid');
        $where  = array(
            'from_shopid' => $userid,
            'order_id'    => $data['order_id'],
        );
        $data = array(
            'order_status' => 4,
            'confirm_time' => time(),
        );
        $confirmStatus = InitPHP::getRemoteService('order', 'confirmReceipt', array($data, $where));
        if ($confirmStatus) {
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 关闭订单
     * @return [type] [description]
     */
    public function cancelOrder()
    {
        $value  = array('order_id');
        $data   = $this->controller->get_gp($value, 'G');
        $userid = $this->getUtil('session')->get('_userid');

        $closeOrderStatus = InitPHP::getRemoteService('order', 'cancelOrder', array($data['order_id'], $userid));

        if ($closeOrderStatus['code'] == 0) {
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 删除订单
     * @return [blooean] [删除是否成功]
     */
    public function deleteOrder()
    {
        $value             = array('order_id');
        $data              = $this->controller->get_gp($value, 'G');
        $userid            = $this->getUtil('session')->get('_userid');
        $deleteOrderStatus = InitPHP::getRemoteService('order', 'deleteOrder', array($data['order_id'], $userid));

        if ($deleteOrderStatus['code'] == 0) {
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    public function orderGoodsShipping()
    {
        $userid             = $this->getUtil('session')->get('_userid');
        $value              = array('order_id', 'goods_id');
        $data               = $this->controller->get_gp($value, 'G');
        $orderGoodsShipping = InitPHP::getRemoteService('order', 'orderGoodsShipping', array($userid, $data['order_id'], $data['goods_id']));

        if ($orderGoodsShipping['code'] == 0) {
            InitPHP::Encode(0, 'Success', $orderGoodsShipping['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }

    }

    public function orderIsExists()
    {
        $userid   = $this->getUtil('session')->get('_userid');
        $value    = array('order_id');
        $data     = $this->controller->get_gp($value, 'G');
        $isExists = InitPHP::getRemoteService('order', 'isExists', array($userid, $order_id));
        if ($isExists['code'] == 0) {
            InitPHP::Encode(0, 'Success', '1');
        } else {
            InitPHP::Encode(1, 'Error', '0');
        }
    }
}
