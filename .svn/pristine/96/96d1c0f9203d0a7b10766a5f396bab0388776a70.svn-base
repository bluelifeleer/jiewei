<?php
class indexController extends Controller
{
    public $initphp_list = array('order_lists', 'delivery', 'get', 'search', 'salesReturn', 'cache');
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 订单列表
     */
    public function order_lists()
    {

        $page   = isset($_GET['page']) && (int) $_GET['page'] != 0 ? intval($_GET['page']) : 1;
        $offset = 20;
        $type   = (int) $_GET['order_status'];
        $limit  = ($page - 1) * $offset;
        //谁，状态，条数，偏移
        $orderLists = InitPHP::getRemoteService('order', 'lists', array(false, $type, $limit, $offset));

        $info  = $orderLists['data'][0];
        $total = $orderLists['data'][1];
        $pages = pages($total, $page, $offset);
        include V('order', 'order_lists');
    }

    /*
     * 发货操作
     * pay_status　支付状态
     * shipping_id 物流方式id
     * shipping_name 物流名称
     * shipping_fee 物流费用
     * shipping_no 物流单号
     * shipping_time 发货时间
     * pay_no　支付编号
     *
     */
    public function delivery()
    {
        $where         = array('og_id' => (int) $_GET['og_id'], 'order_id' => (String) $_GET['orderid']);
        $ordergoodinfo = InitPHP::getRemoteService('orderGoods', 'get', array($where));
        if ($ordergoodinfo['from_id'] != 1) {
            showmessage('该商品由商家发货', HTTP_REFERER);
        }
        $ordergoodinfo['goods_attr'] = json_decode($ordergoodinfo['goods_attr'], true);
        $productattr                 = '';
        foreach ($ordergoodinfo['goods_attr'] as $key => $value) {
            $productattr .= $key . ':' . $value . ',';
        }
        $ordergoodinfo['goods_attr'] = $productattr;
        $order_info                  = InitPHP::getRemoteService('order', 'get', array(array('order_id' => $where['order_id'])));
        if ($order_info['data']['pay_status'] == 1) {
            $pay_status = '未支付';
        } else {
            $pay_status = '已支付';
        }
        if (intval($_POST['dosubmit']) > 0) {
            $order_info_field = array('shipping_id', 'shipping_no', 'shipping_time');
            $data             = $this->controller->get_gp($order_info_field, 'P'); //物流等信息
            if ($data['shipping_id'] == '' || $data['shipping_no'] == '' || $data['shipping_time'] == '') {
                showmessage('请填写完整的物流信息！', HTTP_REFERER);
                //return false;
            }
            //查询shipping_com shipping_name
            $shippinginfo          = InitPHP::getRemoteService('transit', 'get', array(array('id' => $data['shipping_id'])));
            $data['shipping_com']  = $shippinginfo['com'];
            $data['shipping_name'] = $shippinginfo['name'];
            $data['goods_status']  = 3;
            $data['shipping_time'] = strtotime($data['shipping_time']);
            //更新多个商品信息
            $where['from_id'] = '1';
            unset($where['goods_id']);
            $orderupdate = InitPHP::getRemoteService('orderGoods', 'update', array($data, array('og_id' => $where['og_id'])));

            if ($orderupdate) {
                showmessage('发货成功', '/index.php?m=order&c=index&a=order_lists');
            } else {
                showmessage('发货失败', '/index.php?m=order&c=index&a=order_lists');
            }
            //ＰＯＳＴ　end
        } else {
            $shipping     = InitPHP::getRemoteService('transit', 'lists', array(array()));
            $shippinglist = $shipping[0];
            include V('order', 'edit');
        }
    }

    public function search()
    {
        $order_id  = $_POST['order_id'];
        $orderInfo = InitPHP::getRemoteService('order', 'get', array(array('order_id' => $order_id), true));
        $orderInfo = $orderInfo['data'];
        // echo '<pre>';
        // var_dump($orderInfo);
        include V('order', 'search');
    }

    /**
     * 同意退货
     * @return [type] [description]
     */
    public function salesReturn()
    {
        $og_id                          =  $_GET['og_id'];
        $orderid                        =  $_GET['orderid'];
        $status                         = (int) $_GET['status'];
        $res                            = InitPHP::getRemoteService('order', 'salesReturn', array($og_id, $orderid, $status));
        if (intval($res['code']) == 0) {
            showmessage('您已同意退货', '/index.php?m=order&c=index&a=order_lists');
        } else {
            showmessage('操作失败'.$res['data'], '/index.php?m=order&c=index&a=order_lists');
        }
    }

    /**
     * 生成订单仓库数据
     * @return [type] [description]
     */
    public function cache()
    {
        $id = trim($_GET['id']);
        $id = str_replace(' ', '', $id);
        if (!$id) {
            return false;
        }
        $order = InitPHP::getRemoteService('order', 'get', array(array('order_id' => $id), false));
        $this->getRedis('order')->redis()->hmset('order:' . $id, $order['data']);
        showmessage('操作成功', '/index.php?m=order&c=index&a=order_lists');
    }
}
