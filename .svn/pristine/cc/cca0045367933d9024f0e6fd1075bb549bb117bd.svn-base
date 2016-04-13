<?php

/**
 * 购物订单服务层
 * @Author: 刘波
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-29 15:04:09
 */
class orderService extends Service
{
    private $orderInfoDB;
    private $payDB;
    private $newsDB;
    private $orderGoodsDB;
    private $WalletDB;
    private $CapitalDB;

    public function __construct()
    {
        parent::__construct();

        //获取Dao
        $this->orderInfoDB  = InitPHP::getDao('order');
        $this->payDB        = InitPHP::getDao('pay');
        $this->newsDB       = InitPHP::getDao('message');
        $this->orderGoodsDB = InitPHP::getDao('orderGoods');
        $this->WalletDB     = InitPHP::getDao('wallet');
        $this->CapitalDB    = InitPHP::getDao('capitalLiquid');
    }

         /**
     * 获取单条订单
     * @param  [array] $where [order_id || order_sn || userid  仅限以上三个条件其一]
     * @param  [bool] $haveGoodsInfo [是否带上订单明细]
     * @return [array]        [单条数据]
     */
    public function get($where, $haveGoodsInfo = false)
    {
        $basic = array('order_id' => 0, 'userid' => 0);
        if (count(array_merge($basic, $where)) > 3) {
            return array('code' => 1, 'msg' => '字段不符合设计约定');
        }

        if (count($where) > 2) {
            return array('code' => 2, 'msg' => '条件过多，不符合设计约定');
        }

        if (!$haveGoodsInfo) {
            $data = $this->orderInfoDB->get($where);
        } else {
            $data = $this->orderInfoDB->getDetail($where);
        }
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        } else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

    /**
     * 获取订单列表
     * @param  array   $where  [description]
     * @param  integer $offset [description]
     * @param  integer $num    [description]
     * @return [array]          [description]
     */
    public function lists($userid = 0, $typeid = 0, $num = 5, $offset = 0, $shopid = false)
    {
        //$data = $this->orderInfoDB->lists($where, $num, $offset, $is_key, $sort, $field);
        //
        if ($userid) {
            $where['userid'] = $userid;
        }
        if ($shopid) {
            $where['shop_id'] = $shopid;
        }
        if ($typeid) {
            //此款商品在订单中的状态；
            //1：未支付,，未发货；
            //2：支付，未发货；
            //3：发货，未收货；
            //4：收货,已完成；
            //6: 正在申请售后的
            if ($typeid == 6) {
                $where['is_after_sales'] = '!=0';
            } else {
                $where['goods_status'] = $typeid;
            }
        }

        $result = $this->orderGoodsDB->lists($where, $offset, $num);
        $data   = array();
        if ($result[1]) {
            foreach ($result[0] as $key => $value) {
                $data[$value['order_id']]['data'][$key]             = $value;
                $shopinfo                                           = $this->getRedis('default')->redis()->hgetall('shop:' . $value['shop_id']);
                $data[$value['order_id']]['data'][$key]['shopname'] = $shopinfo['name'] . ($shopinfo['phone'] ? $shopinfo['phone'] : '');
                $data[$value['order_id']]['pay_status']             = ($value['goods_status'] == 1 ? 1 : 0); //0已付款 1未付款
                $data[$value['order_id']]['userid']                 = $value['userid'];
                $userinfo                                           = $this->getRedis('default')->redis()->hgetall('userinfo:' . $value['userid']);
                $data[$value['order_id']]['username']               = $userinfo['nickname'] . ($userinfo['phone'] ? $userinfo['phone'] : '');
            }
        }
        if ($data) {
            return InitPHP::Encode(0, 'Success', array($data, $result[1]), 1);
        } else {
            return InitPHP::Encode(1, 'Error', $data, 1);
        }
    }

    /**
     * 更新订单支付状态
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where)
    {
        //开启事务
        $this->orderInfoDB->transaction_start();
        $state = $this->orderInfoDB->update($data, $where);

        $payUpData = array('pay_status' => $data['pay_status']);
        //同步支付状态支付数据表
        $updatePay = $this->payDB->update($payUpData, $where);

        if ($state && $updatePay) {
            $this->orderInfoDB->transaction_commit();
            $this->getRedis('order')->redis()->hmset('order:' . $where['order_id'], $payUpData);
            return InitPHP::Encode(0, 'Success', '', 1);
        } else {
            $this->orderInfoDB->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }

    /**
     * 新增订单
     * @param  [array] $data [description]
     * @return [boolen or int] [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data)
    {
        //开启事务
        $this->orderInfoDB->transaction_start();

        //添加订单数据

        $create_id = $this->orderInfoDB->create($data);
        //组织支付数据
        $payData = array(
            'userid'        => $data['userid'],
            'username'      => $data['consignee'],
            'pay_type'      => $data['pay_id'],
            'pay_account'   => '',
            'order_no'      => $data['order_sn'],
            'order_total'   => $data['order_amount'],
            'coupons_no'    => '',
            'coupons_total' => 0,
            'transit_total' => 0,
            'total'         => $data['pay_fee'],
            'pay_status'    => 0,
            'create_time'   => time(),
            'pay_time'      => 0,
        );
        //添加支付数据
        $addPay = $this->payDB->create($payData);

        //组织消息数据
        $newsData = array(
            'to_userid'   => $data['userid'],
            'from_userid' => '',
            'type'        => 1,
            'title'       => '开通会员提醒',
            'content'     => '亲爱的会员，您正在开通会员．',
            'is_read'     => 1,
            'create_time' => time(),
        );
        //添加支付数据
        $addNews = $this->newsDB->create($newsData);

        if ($create_id && $addPay) {
            $this->orderInfoDB->transaction_commit();
            return InitPHP::Encode(0, 'Success', $create_id, 1);
        } else {
            $this->orderInfoDB->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }

    /**
     * 删除订单
     * @param  [string] $userid [用户id]
     * @return [integer] $orderId [订单id]
     * @return [boolean] $status [删除状态]
     */
    public function delete($userid, $orderid)
    {
        return;
        $where  = array('userid' => $userid, 'order_id' => $orderid);
        $status = $this->orderInfoDB->delete($where);
        if ($status) {
            return InitPHP::Encode(0, 'Success', $status, 1);
        } else {
            return InitPHP::Encode(1, 'Error', $status, 1);
        }
    }

    /**
     * 添加商品订单
     * @param [array] $data [添加商品订单的数据]
     * @author 李鹏
     * @date 2016-06-26
     */

    public function addPorductOrder($data)
    {
        // 开启事务
        $this->orderInfoDB->transaction_start();

        $temp           = array();
        $orderGoodsData = array();
        $order_no       = create_sn();
        $time           = time();
        $transit_cost   = 0;
        $address        = InitPHP::getDao('address')->get(intval($data['addressId']));
        $goodsForm      = '';
        $coupons_total  = 0;
        $bonus          = 0;
        //订单数据
        $shop_id   = isset($data['siteid']) && $data['siteid'] != '' ? trim($data['siteid']) : '1';
        $orderData = array(
            'order_id'       => $order_no, //订单号
            'userid'         => $data['userid'], //用户id
            'pay_status'     => 1, //支付状态
            'consignee'      => $address['username'],
            'country'        => '中国',
            'province'       => explode(' ', $address['ship_data'])[0],
            'city'           => explode(' ', $address['ship_data'])[1],
            'district'       => explode(' ', $address['ship_data'])[2],
            'address'        => $address['detail_address'],
            'zipcode'        => $address['code'],
            'mobile'         => $address['mobile'],
            'order_remark'   => trim($data['comment']),
            'pay_id'         => 0, //支付类型id
            'pay_name'       => '余额支付', //支付类型名称
            'pay_fee'        => 0, //订单总金额 - bonus(红包) - 使用的优惠券金额(优惠劵)
            'bonus'          => 0, //红包金额
            'bonus_id'       => 0, //红包id
            'order_amount'   => 0, //订单总额
            'from_shopid'    => $shop_id, //购买商品的店铺id
            'add_time'       => $time, //订单添加时间
            'confirm_time'   => 0, //订单确定时间
            'pay_time'       => 0, //支付时间
            'pay_no'         => $pay_no, //支付编号
            'is_use_coupons' => 0, //是否使用优惠券
            'coupons_total'  => 0, //优惠券金额
            'order_num'      => intval($data['productNum']),
            'is_cancel'      => 0, //是否取消订单0否[默认]，1是
        );

        //订单商品数据
        //formid == null 平台
        //sysadd == 1 平台
        $orderGoodsShipping = 0;
        $orderGoodsAmount   = 0;
        for ($i = 0; $i < count($data['productInfo']); $i++) {
            $orderGoods = null;
            $goods      = InitPHP::getDao('product')->get(array('id' => intval($data['productInfo'][$i]['id'])));
            /**
             * 判断是平台商品还是从平台导入的商品
             */
            if ($goods['fromid'] == '' && $goods['sysadd'] == 1) {
//表示平台商品
                $orderGoods = $goods;
                $goodsForm  = '1';
            } else if ($goods['fromid'] == '' && $goods['sysadd'] == 0) {
//表示用户自己店铺自己添加的商品（非平台导入商品、非平台商品）
                $orderGoods = $goods;
                $goodsForm  = trim($goods['userid']);
            } else {
//表示用户导入平台的商品
                $orderGoods = InitPHP::getDao('product')->get(array('id' => intval($goods['fromid'])));
                $goodsForm  = '1';
            }

            $temp['order_id']      = $order_no; //订单商品订单号
            $temp['goods_id']      = $goods['id']; //商品id
            $temp['goods_from_id'] = $orderGoods['id']; //商品id
            $temp['goods_name']    = $orderGoods['title']; //商品名称
            $temp['goods_pic']     = $orderGoods['thumb']; //商品图片
            $temp['goods_number']  = $data['productInfo'][$i]['num']; //商品数据

            $temp['goods_price']    = $orderGoods['sale_price']; //商品价格
            $temp['cost_price']     = $orderGoods['cost_price']; //商品成本价格
            $temp['purchase_price'] = $orderGoods['purchase_price']; //商品采购价格

            $temp['goods_level']    = $orderGoods['level']; //商品等级id
            $temp['YunUser']        = $data['YunUser']; //推荐人id
            $temp['userid']         = $data['userid']; //购买商品的用户id
            $temp['is_real']        = $orderGoods['is_real']; //是否是实物
            $temp['is_gift']        = ''; //是否有礼券
            $temp['is_send']        = 0; //是否发货
            $temp['goods_attr']     = $data['productInfo'][$i]['params'];
            $temp['goods_sn']       = $orderGoods['product_sn'];
            $temp['goods_status']   = 1;
            $temp['from_id']        = $goodsForm; //判断商品是店家自己上传的还是导入平台的商品，0表示店家自己上传的商品，非0表示平台导入的商品。
            $temp['shop_id']        = $goods['userid']; //店铺id
            $temp['order_total']    = $orderGoods['sale_price'] * intval($data['productInfo'][$i]['num']); //订单内单件商品的总金额
            $temp['shipping_id']    = 1; //物流方式id
            $temp['shipping_com']   = ''; //物流接口
            $temp['shipping_name']  = ''; //物流名称
            $temp['shipping_no']    = ''; //物流编号
            $temp['shipping_fee']   = $orderGoods['transit_cost'] * intval($data['productInfo'][$i]['num']); //物流费用
            $temp['shipping_time']  = ''; //发货时间
            $temp['is_comment']     = 0; //是否评价
            $temp['is_after_sales'] = 0; //是否售后
            array_push($orderGoodsData, $temp);
            //计算订单中商品的金额总和
            $orderGoodsAmount += sprintf('%01.2f', $orderGoods['sale_price']) * intval($data['productInfo'][$i]['num']);
            //计算订单中所有商品的物流费用总和
            $orderGoodsShipping += sprintf('%01.2f', $orderGoods['transit_cost']) * intval($data['productInfo'][$i]['num']);
        }

        //订单总金额 ＝ 订单商品金额+订单物流费用
        $orderData['order_amount'] = sprintf('%01.2f', ($orderGoodsShipping + $orderGoodsAmount));
        $orderData['pay_fee']      = sprintf('%01.2f', ($orderGoodsShipping + $orderGoodsAmount - $coupons_total - $bouns));

        //订单支付数据
        $orderPayData = array(
            'userid'        => $data['userid'],
            'username'      => $data['username'],
            'pay_no'        => '',
            'pay_type'      => 0,
            'pay_account'   => '',
            'order_no'      => $order_no,
            'order_total'   => $data['amount'],
            'coupons_no'    => '',
            'coupons_total' => $coupons_total,
            'transit_total' => $transit_cost,
            'total'         => $orderData['pay_fee'],
            'pay_status'    => 1,
            'create_time'   => $time,
            'pay_time'      => 0,
        );

        //消息记录数据
        $msgData = array(
            'to_userid'   => $data['userid'], //信息接收者id
            'from_userid' => 1, //信息发送者
            'title'       => '订单生成提醒', //信息标题
            'contents'    => htmlspecialchars('尊敬的' . $data['username'] . '先生/女士，您的订单于' . date('Y-m-d H:i:s', $time) . '已经生成，订单号' . $order_no . ',请点击<a href="orderinfo.html?order_id=' . $order_no . '">查看详细信息</a>。'), //信息内容
            'type'        => 1, //信息类型
            'is_read'     => 0, //信息是否读取
            'create_time' => $time, //信息生成时间
        );

        //添加订单信息
        $orderInfoAdd = $this->orderInfoDB->create($orderData);

        //添加订单中的商品信息
        $orderGoodsAdd = $this->orderGoodsDB->create($orderGoodsData);

        //添加支付数据
        $addPay = $this->payDB->create($orderPayData);

        //添加消息提示数据
        $addMsg = $this->newsDB->create($msgData);

        if ($orderInfoAdd && $orderGoodsAdd && $addPay && $addMsg) {
            $this->orderInfoDB->transaction_commit();
            //生成订单仓库数据
            $this->getRedis('order')->redis()->hmset('order:' . $orderData['order_id'], $orderData);
            return InitPHP::Encode(0, 'Success', $order_no, 1);
        } else {
            $this->orderInfoDB->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }

    }

    /**
     * 获取订单中的商品
     */
    public function getOrderGoodsLists($where)
    {
        $goodsLists = InitPHP::getDao('order')->getOrderGoodsLists($where);
        if ($goodsLists) {
            return InitPHP::Encode(0, 'Success', $goodsLists, 1);
        } else {
            return InitPHP::Encode(1, 'Error', $goodsLists, 1);
        }
    }

    /**
     * 添加充值
     */
    public function recharge($data)
    {
        // 开启事务
        $this->orderInfoDB->transaction_start();
        $time = time();
        //订单数据
        $orderData = array(
            'userid'          => $data['userid'], //会员id
            'order_id'        => $data['order_id'], //订单号
            'parent_id'       => $data['YunUser'], //会员上级id
            'order_status'    => 1, //订单状态
            'shipping_status' => 0, //商品配送状态
            'pay_status'      => 1, //支付状态
            'consignee'       => $data['userName'], //收货人姓名
            'order_remark'    => '加入会员充值缴费', //订单备注
            'shipping_id'     => 0, //配送方式id
            'pay_id'          => 2, //支付方式id
            'pay_name'        => '微信支付', //支付名称
            'shipping_fee'    => 0, //配送费用
            'pay_fee'         => $data['amount'], //支付费用
            'surplus'         => 0, //余额支付金额
            'order_amount'    => $data['amount'], //应付款金额
            'add_time'        => $time, //订单生成时间
            'confirm_time'    => 0, //订单确认时间
            'pay_time'        => 0, //订单支付时间
            'shipping_time'   => 0, //订单配送时间
            'invoice_no'      => '', //发货单号

        );

        //商品数据
        $orderGoodsData = array(
            'order_id'           => $data['order_id'], //订单商品订单号
            'goods_name'         => '缴费充值', //商品名称
            'goods_number'       => 1, //商品数据
            'goods_price'        => $data['amount'], //商品价格
            'YunUser'            => $data['YunUser'], //推荐人id
            'is_real'            => 0,
            'rorder_goods_total' => $data['amount'], //订单内单件商品的总金额
        );

        //支付数据
        $payData = array(
            'order_no'    => $data['order_id'],
            'pay_no'      => strtoupper(md5(create_sn())), //支付号
            'userid'      => $data['userid'], //用户id
            'username'    => $data['userName'], //用户名
            'pay_type'    => 2, //支付类型
            'pay_account' => '', //支付帐号
            'total'       => $data['amount'], //支付金额
            'pay_status'  => 1, //支付状态
            'create_time' => $time, //支付创建时间
            'pay_time'    => 0, //支付时间
        );

        //消息记录数据
        $msgData = array(
            'to_userid'   => $data['userid'], //信息接收者id
            'from_userid' => 1, //信息发送者
            'title'       => '订单生成提醒', //信息标题
            'contents'    => htmlspecialchars('尊敬的' . $data['username'] . '先生/女士，您的于' . date('Y-m-d H:i:s', $time) . '进行充值操作，充值金额' . $data['amount'] . '元，订单号' . $data['order_id'] . ',请点击<a href="orderinfo.html?order_id=' . $order_no . '">查看详细信息</a>。'), //信息内容
            'type'        => 1, //信息类型
            'is_read'     => 0, //信息是否读取
            'create_time' => $time, //信息生成时间
        );

        //添加订单信息
        $orderInfoAdd = $this->orderInfoDB->create($orderData);

        //添加订单中的商品信息
        $orderGoodsAdd = $this->orderGoodsDB->create($orderGoodsData);

        //添加支付数据
        $addPay = $this->payDB->create($payData);

        //添加消息提示数据
        $addMsg = $this->newsDB->create($msgData);

        if ($orderInfoAdd && $orderGoodsAdd && $addPay && $addMsg) {
            $this->orderInfoDB->transaction_commit();
            return InitPHP::Encode(0, 'Success', $order_no, 1);
        } else {
            $this->orderInfoDB->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }

    }

    /**
     * 确认收货
     * @param [array] $data [更改数据]
     * @param [array] $where [更改条件]
     * @return [boolean] $confirm [返回更改的状态]
     * @author 李鹏
     * @date 2016-02-19
     */
    public function confirmReceipt($data, $where)
    {
        $confirm = $this->orderInfoDB->update($data, $where);
        if ($confirm) {
            //生成订单仓库数据
            $this->getRedis('order')->redis()->hmset('order:' . $where['order_id'], $data);
            return InitPHP::Encode(0, 'Success', $confirm, 1);
        } else {
            return InitPHP::Encode(1, 'Error', $confirm, 1);
        }
    }

    /**
     * 售后处理动作
     * @param  [type] $og_id    [订单号]
     * @param  [type] $order_id [订单流水号]
     * @param  [type] $status   [处理状态 1:申请  2：同意，3：拒绝]
     * @return [type]           [description]
     */

public function salesReturn($og_id, $order_id, $status)
    {
        $order = $this->getRedis('order')->redis()->hgetall('order:' . $order_id);
        if (!$order) {
            return InitPHP::Encode(1, 'Error', '无订单数据', 1);
        }
        //拒绝处理已取消订单
        if ($order['is_cancel'] == 1) {
            return InitPHP::Encode(1, 'Error', '订单已取消', 1);
        }
        //拒绝处理未支付订单
        if ($order['pay_status'] == 1) {
            return InitPHP::Encode(1, 'Error', '订单已支付', 1);
        }
        $orderGoods = $this->orderGoodsDB->get(array('order_id' => $order_id, 'og_id' => $og_id));
        if (!$orderGoods) {
            return InitPHP::Encode(1, 'Error', '无订单数据', 1);
        }
        // 申请售后
        if($status == 1){
            // 如果订单产品的状态小于3 则为未发货状态不予申请售后
            if($orderGoods['goods_status'] < 3) return InitPHP::Encode(1, 'Error', '数据异常,商品未发货', 1);
            // 当前 如果时间大于 发货时间15天
            if(time() - $orderGoods['shipping_time'] > 15*24*60*60 ) return InitPHP::Encode(1, 'Error', '超出发货时间15天,不可进行售后', 1);
            // 产品售后状态
            if($orderGoods['is_after_sales'] != 0) return InitPHP::Encode(1, 'Error', '数据异常,商品售后中', 1);
            $this->orderGoodsDB->update(array('is_after_sales' => '2'), array('order_id' => $order_id, 'og_id' => $og_id));
            return InitPHP::Encode(0, 'Success', $orderGoods,1);
           
        }

        //退款
        if ($status == 2) {
           //退钱！！！
            $time = time();
            $amount =  sprintf("%01.2f", (sprintf("%01.2f", $orderGoods['goods_price']) * $orderGoods['goods_number'] + sprintf("%01.2f", $orderGoods['shipping_fee'])));//goods_price * goods_number + shipping_fee
            $amountInfo = InitPHP::getDao('wallet')->get(array('userid' => $orderGoods['userid']));
           if(!$amountInfo){
                return InitPHP::Encode(1, 'Error', '退款用户无账户信息', 1);
           }
            // 资金流动记录
            $capitalLiquidData = array(
                'userid'      => $orderGoods['userid'],
                'shop_id'     => '',
                'title'       => '退款记录',
                'content'     => '订单号为' . $orderGoods['order_id'] . '的产品：' . $orderGoods['goods_name'] ,
                'amount'      => $amount,
                'make'        => '',
                'status'      => 1,
               'type'        => 6, //1：充值；2：购物消费；3：销售提成；4：开店奖励；5：销售本店产品的收益 6退款
                'create_time' => $time,
                'action'      => 1,
            );
            //消息记录数据
            $msgData = array(
                'to_userid'   => $orderGoods['userid'], //信息接收者id
                'from_userid' => 1, //信息发送者
                'title'       => '产品退款提醒', //信息标题
                'contents'    => htmlspecialchars('尊敬的' . $data['username'] . '先生/女士，系统于' . date('Y-m-d H:i:s', time) . '进行退款操作，退款金额' . $amount . '元，订单号为' . $orderGoods['order_id'] . '的产品：' . $orderGoods['goods_name'] . ',请点击<a href="orderinfo.html?order_id=' . $order_id . '">查看详细信息</a>。'), //信息内容
                'type'        => 2, //信息类型 1.系统,2订单,3公告
                'is_read'     => 0, //信息是否读取
                'create_time' => $time, //信息生成时间
            );

                // 更新钱包数据
            $updateAmountData = array(
               'amount' => sprintf("%01.2f", sprintf("%01.2f", $amountInfo['amount']) + $amount),
           );
            // 修改订单产品状态
            $updateOrderGoods = $this->orderGoodsDB->update(array('is_after_sales' => '1'), array('order_id' => $order_id, 'og_id' => $og_id));
            
            // 记录流水
            $capitalLiquidId = $this->CapitalDB->create($capitalLiquidData);
            // 发消息
            $addMsg = $this->newsDB->create($msgData);
            // 退款到账户 
            $updateAmountStatus = $this->WalletDB->update($updateAmountData, array('userid' => $orderGoods['userid']));
            
            if($updateOrderGoods && $capitalLiquidId && $addMsg && $updateAmountStatus)
            {
                return InitPHP::Encode(0, 'Success', '退款成功',1);
            }else{
                return InitPHP::Encode(1, 'Error', '退款失败', 1);
            }   
       }
       //拒绝退款
        if ($status == 3) {
            $this->orderGoodsDB->update(array('is_after_sales' => '3'), array('order_id' => $order_id, 'og_id' => $og_id));
        }
        return;
    }
    /**
     * 关闭订单
     * @param  [string] $order_id [要取消的订单]
     * @param  [string] $userid   [用户id]
     * @return [blooean]           [操作是否成功]
     * @author 李鹏
     * @date 2016-03-01
     */
    public function cancelOrder($order_id, $userid)
    {
        $order = $this->getRedis('order')->redis()->hgetall('order:' . $order_id);
        if (!$order) {
            return InitPHP::Encode(1, 'Error', '无订单数据', 1);
        }
        //拒绝处理已支付订单
        if ($order['pay_status'] == 2) {
            return InitPHP::Encode(1, 'Error', '订单已支付，无法取消', 1);
        }

        //开启事务
        InitPHP::getDao('order')->transaction_start();
        //更新订单状态
        $updateOrderStatus = InitPHP::getDao('order')->update(array('is_cancel' => 1), array('userid' => $userid, 'order_id' => $order_id));
        if ($updateOrderStatus && $updateOrderGoodsStatus) {
            //提交事务
            InitPHP::getDao('order')->transaction_commit();
            $this->getRedis('order')->redis()->hmset('order:' . $order_id, array('is_cancel' => 1));
            return InitPHP::Encode(0, 'Success', '', 1);
        } else {
            //回滚事务
            InitPHP::getDao('order')->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }

    /**
     * 删除订单
     * @param  [string] $order_id [订单id]
     * @param  [string] $userid   [用户id]
     * @return [blooean]           [删除是否成功]
     * @author 李鹏
     * @date 2016-03-01
     */
    public function deleteOrder($order_id, $userid)
    {
        return true;
        //开启事务
        InitPHP::getDao('order')->transaction_start();
        //删除订单信息
        $deleteOrderStatus = InitPHP::getDao('order')->delete(array('order_id' => $order_id, 'userid' => $userid));
        //删除订单中的商品
        $deleteOrderGoodsStatus = InitPHP::getDao('orderGoods')->delete(array('order_id' => $order_id));

        if ($deleteOrderStatus && $deleteOrderGoodsStatus) {
            //提交事务
            InitPHP::getDao('order')->transaction_commit();
            return InitPHP::Encode(0, 'Success', '', 1);
        } else {
            //回滚事务
            InitPHP::getDao('order')->transaction_rollback();
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }

    public function managerOrderlists($where = array('*'), $num = 20, $offset = 0, $is_key = 'add_time', $sort = 'DESC', $field = '*')
    {
        $orderList = InitPHP::getDao('order')->managerOrderlists($where, $num, $offset, $is_key, $sort, $field);
        if ($orderList) {
            return InitPHP::Encode(0, 'Success', $orderList, 1);
        } else {
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }

    /**
     * 订单物流信息
     * @param  [type] $userid  [description]
     * @param  [type] $orderid [description]
     * @param  [type] $goodsid [description]
     * @return [type]          [description]
     */
    public function orderGoodsShipping($userid, $orderid, $goodsid)
    {
        $temp                       = array();
        $orderInfo                  = InitPHP::getDao('order')->get(array('userid' => $userid, 'order_id' => $orderid));
        $goodsInfo                  = InitPHP::getDao('orderGoods')->get(array('order_id' => $orderid, 'goods_id' => $goodsid));
        $orderInfo['add_time']      = $orderInfo['add_time'] && $orderInfo['add_time'] != '' ? date('Y-m-d H:i:s', $orderInfo['add_time']) : '';
        $orderInfo['confirm_time']  = $orderInfo['confirm_time'] && $orderInfo['confirm_time'] != '' ? date('Y-m-d H:i:s', $orderInfo['confirm_time']) : '';
        $orderInfo['pay_time']      = $orderInfo['pay_time'] && $orderInfo['pay_time'] != '' ? date('Y-m-d H:i:s', $orderInfo['pay_time']) : '';
        $goodsInfo['shipping_time'] = $goodsInfo['shipping_time'] && $goodsInfo['shipping_time'] != '' ? date('Y-m-d H:i:s', $goodsInfo['shipping_time']) : '';
        $goodsInfo['shipping_fee']  = $goodsInfo['shipping_fee'] && $goodsInfo['shipping_fee'] != '' ? $goodsInfo['shipping_fee'] : '';
        $goodsInfo['shipping_no']   = $goodsInfo['shipping_no'] && $goodsInfo['shipping_no'] != '' ? $goodsInfo['shipping_no'] : '';
        $goodsInfo['shipping_name'] = $goodsInfo['shipping_name'] && $goodsInfo['shipping_name'] != '' ? $goodsInfo['shipping_name'] : '';
        if ($orderInfo && $goodsInfo) {
            $temp['order_info']  = $orderInfo;
            $temp['order_goods'] = $goodsInfo;
            return InitPHP::Encode(0, 'Success', $temp, 1);
        } else {
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }
    /**
     * 订单是否存在
     * @param  [type]  $userid   [description]
     * @param  [type]  $order_id [description]
     * @return boolean           [description]
     */
    public function isExists($userid, $order_id)
    {
        $where    = array('userid' => $userid, 'order_id' => $order_id);
        $isExists = InitPHP::getDao('order')->get($where);
        if ($isExists) {
            return InitPHP::Encode(0, 'Success', 1, 1);
        } else {
            return InitPHP::Encode(1, 'Error', 0, 1);
        }
    }

}
