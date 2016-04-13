<?php

/**
 * @Author: 邵博
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-03-19 13:55:05
 */
class shopService extends Service
{
    private $DB;
    public $openShopPrice;

    public function __construct()
    {
        parent::__construct();
        //获取Dao
        $this->DB            = InitPHP::getDao('shop');
        $this->storeData     = InitPHP::getDao('storeData');
        $this->categorysDao  = InitPHP::getDao("categories");
        $this->productDao    = InitPHP::getDao("product");
        $this->accountDao    = InitPHP::getDao("account");
        $this->shopBonus     = InitPHP::getDao("openShopBonus");
        $this->openShopPrice = array('tA' => 580, 'tB' => 80, 'tC' => 20);
    }

    /**
     * 获取单条菜单
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where)
    {
        return $this->DB->get($where);
    }

    public function getshop($id)
    {
        $info = $this->DB->getshop($id);
        $this->getRedis('default')->redis()->hmset('shop:' . $id, $info);
        return $info;
    }
    /**
     * 获取子集列表菜单
     * @param  array   $where  [description]
     * @param  integer $offset [description]
     * @param  integer $num    [description]
     * @param  string  $order  [description]
     * @param  string  $sort   [description]
     * @param  string  $key    [description]
     * @param  string  $fileds [description]
     * @return [array]         [description]
     */
    public function lists($where = array(), $offset = 0, $num = 20, $order = 'userid', $sort = 'desc', $key = 'userid')
    {
        return $this->DB->lists($where, $offset, $num, $order, $sort, $key);
    }

    /**
     * 更新店铺
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where)
    {
        return $this->DB->update($data, $where);
    }

    /*
     *修改店铺某字段的值
     */
    public function updateField($data, $where)
    {
        $updateId = $this->DB->updateField($data, $where);
        if ($updateId) {
            return InitPHP::Encode(0, 'Success', $updateId, 1);
        } else {
            return InitPHP::Encode(1, 'Error', '', 1);
        }
    }
    /**
     * 新增店铺
     * @param  [array] $data [description]
     * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data)
    {
        return $this->DB->create($data);
    }

    /**
     * 删除店铺
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($userid)
    {
        return $this->DB->delete($userid);
    }

    /**
     * 事务方式同时插入商铺信息　产品信息　栏目信息　改变店铺状态 创建店铺
     * @param $infoData　商铺信息
     * @param $cateData　栏目信息
     * @param $productData 产品信息
     * @param $is_has_shop 用户表商铺改为开启
     * @return boolean 200 参数错误 300 新增成功 500 新增失败
     */
    public function transactionCreate($userid, $shopInfo, $cateInfo, $productInfo)
    {
        //判断参数
        if (!isset($shopInfo) || !isset($cateInfo) || !isset($productInfo)) {
            return json_encode(array('code' => 500, 'msg' => 'Error')); //参数错误
        }
        //开启事务
        $this->DB->transaction_start();
        //插入商铺信息
        //$shopData = $this->DB->create($shopInfo);
        //插入栏目信息

        $isSus = true;
        foreach ($cateInfo as $key => $value) {

            $fwhere['catname']     = $value['catname'];
            $fwhere['siteid']      = $userid;
            $fwhere['module']      = 'site';
            $fwhere['parentid']    = 0;
            $fwhere['arrparentid'] = 0;

            if (isset($value['children'])) {
                $fwhere['child'] = 1;
                $arrchildid      = '';
                $ftrueCateid     = $this->categorysDao->create($fwhere);
                $arrchildid      = $ftrueCateid . ',';
                if (!$ftrueCateid) {
                    $isSus = false;
                }

                foreach ($value['children'] as $key => $value) {

                    $pwhere['catname']     = $value['catname'];
                    $pwhere['siteid']      = $userid;
                    $pwhere['module']      = 'site';
                    $pwhere['parentid']    = $ftrueCateid;
                    $pwhere['arrparentid'] = 0;
                    $pwhere['child']       = 0;

                    $ptrueCateid     = $this->categorysDao->create($pwhere);
                    $cwhere['catid'] = $ptrueCateid;
                    foreach ($productInfo as $k => $vInfo) {
                        if ($value['catid'] == $k) {
                            $cwhere['userid'] = $userid;
                            foreach ($vInfo as $key => $infovalue) {
                                $cwhere['is_up']  = 99;
                                $cwhere['status'] = 99;
                                $cwhere['fromid'] = $infovalue;
                                $this->productDao->create($cwhere);
                            }
                        }
                    }

                    if (!$ptrueCateid) {
                        $isSus = false;
                    }

                    $arrchildid .= $ptrueCateid . ',';
                    $UptrueCateid = $this->categorysDao->update(array('arrparentid' => '0,' . $ftrueCateid, 'arrchildid' => $ptrueCateid), array('catid' => $ptrueCateid));

                }

                $UftrueCateid = $this->categorysDao->update(array('arrchildid' => substr($arrchildid, 0, -1)), array('catid' => $ftrueCateid));

            } else {

                $fwhere['child'] = 0;
                $trueCateid      = $this->categorysDao->create($fwhere);
                $cwhere['catid'] = $trueCateid;
                foreach ($productInfo as $k => $vInfo) {
                    if ($value['catid'] == $k) {
                        $cwhere['userid'] = $userid;
                        foreach ($vInfo as $key => $infovalue) {
                            $cwhere['is_up']  = 99;
                            $cwhere['status'] = 99;
                            $cwhere['fromid'] = $infovalue; //真实id
                            $this->productDao->create($cwhere);
                        }
                    }
                }
                if (!$trueCateid) {
                    $isSus = false;
                }

                $trueCateid = $this->categorysDao->update(array('arrchildid' => $trueCateid), array('catid' => $trueCateid));
                if (!$trueCateid) {
                    $isSus = false;
                }

                // if($trueCateid) return $trueCateid;

            }
        }
        $shopInfo['userid'] = $userid;
        $this->DB->create($shopInfo);
        $has_shop = $this->accountDao->update(array('is_has_shop' => 1), array('userid' => $userid));
        if (!$has_shop) {
            $isSus = false;
        }

        // 获取用户信息
        $userInfo = $this->accountDao->get(array('userid' => $userid));
        if (!$userInfo) {
            $isSus = false;
        }

        // 增加开店信息
        $storeInfo['shop_info'] = json_encode($shopInfo, JSON_UNESCAPED_UNICODE);
        $storeInfo['user_info'] = json_encode($userInfo, JSON_UNESCAPED_UNICODE);
        $storeInfo['type']      = $shopInfo['type'];
        $storeInfo['addtime']   = time();

        $storData = $this->storeData->create($storeInfo);
        if (!$storData) {
            $isSus = false;
        }

        // $storeInfo['shop_info'] = json_encode($shopInfo);
        // $storeInfo['user_info'] = json_encode($shopInfo);
        // $storeInfo['type'] = $shopInfo['type'];
        // $storeInfo['addtime'] = time();

        // $this->storeData->create($storeInfo);
        //$cateData = $this->categorysDao->create($cateInfo);
        //插入商品信息
        //$productData = $this->productDao->create($productInfo);
        // if($shopData){
        //     $is_has_shop = 1;
        //     $this->accountDao->update(array('is_has_shop'=>$is_has_shop),array('userid'=>$userid));
        // }
        //if($shopData && $cateData && $productData){
        if ($isSus) {
            //提交事务
            $this->DB->transaction_commit();
            $this->openShopBonus($userid);
            return array('code' => 200, 'msg' => 'Success'); //更新成功
        } else {
            //事务回滚
            $this->DB->transaction_rollback();
            return array('code' => 300, 'msg' => 'Error'); //更新失败
        }
    }
    /**
     * 开店奖励
     * @param  [type] $userid [description]
     * @return [type]         [description]
     */
    public function openShopBonus($userid)
    {
        $ShopPrice       = $this->openShopPrice;
        $insert['money'] = $ShopPrice['tA'];
        $uid_1           = $this->accountDao->get(array('userid' => $userid));

        if ($uid_1['levels'] == 0) {
            $this->accountDao->update(array('is_has_shop' => 1, 'levels' => 1), array('userid' => $userid));
        }

        $insert['userid'] = $userid;
        //推荐人利润
        $uid_2 = $this->accountDao->get(array('userid' => $uid_1['parentid']));

        if ($uid_1['parentid'] > 1) {
            $insert['uid_2']   = $uid_1['parentid'];
            $insert['level_2'] = $uid_2['levels'];
            $insert['bonus_2'] = $ShopPrice['tB'];
            // 添加 资金流动方法
            $this->acountAmount($uid_1, $uid_2['userid'], $ShopPrice['tB']);
        } else {
            $insert['uid_2']   = 1;
            $insert['level_2'] = 1;
            $insert['bonus_2'] = 0;
        }
        //推荐人上级利润
        if ($uid_2['parentid'] > 1) {
            $uid_3             = $this->accountDao->get(array('userid' => $uid_2['parentid']));
            $insert['uid_3']   = $uid_3['userid'];
            $insert['level_3'] = $uid_3['levels'];
            $insert['bonus_3'] = $ShopPrice['tC'];
            // 添加 资金流动方法
            $this->acountAmount($uid_1, $uid_3['userid'], $ShopPrice['tC']);

        } else {
            $insert['uid_3']   = 1;
            $insert['levels']  = 1;
            $insert['bonus_3'] = 0;
        }
        //冗余利润
        $insert['less']      = $ShopPrice['tA'] - $insert['bonus_2'] - $insert['bonus_3'];
        $insert['inputtime'] = time();
        $this->shopBonus->create($insert);
    }

    /**
     * [acountAmount 开店奖励]
     * @param  [type] $userid  [奖励人id]
     * @param  [type] $amount  [奖励金额]
     * @param  [type] $message [通知信息]
     * @return [type]          [description]
     */
    public function acountAmount($userInfo, $userid, $rechargeTotal)
    {
        // 添加一条资金流动记录
        $payAccount = ''; //支付帐号
        $pay_status = 1; //支付状态
        $timer      = time(); //支付时间
        $payType    = 3; //支付类型 1余额支付 2微信支付 3 开店奖励
        $payNo      = strtoupper(md5(create_sn())); //支付单号

        //支付数据
        $payData = array(
            'pay_no'      => $payNo,
            'userid'      => $userid,
            'username'    => $username,
            'pay_type'    => $payType,
            'pay_account' => $payAccount,
            'total'       => $rechargeTotal,
            'pay_status'  => $pay_status,
            'create_time' => $timer,
            'pay_time'    => $timer,
        );

        //获取用户钱包中原有的余额
        $sumAmount         = 0;
        $getOriginalWallet = InitPHP::getDao('wallet')->get(array('userid' => $userid));
        $sumAmount         = sprintf("%01.2f", (sprintf("%01.2f", $rechargeTotal) + sprintf("%01.2f", $getOriginalWallet['amount'])));
        $bonusAmount       = sprintf("%01.2f", (sprintf("%01.2f", $rechargeTotal) + sprintf("%01.2f", $getOriginalWallet['current_month_bonus'])));

        $walletData = array(
            'amount'              => $sumAmount,
            'current_month_bonus' => $bonusAmount,
        );

        $pay_name_text = '开店奖励';
        //消息数据
        $msgData = array(
            'to_userid'   => $userid,
            'from_userid' => 1,
            'title'       => '奖金提醒消息',
            'contents'    => htmlspecialchars('你的好友' . $userInfo['username'] . ',' . date('Y-m-d H:i:s', $timer) . '' . $pay_name_text . sprintf("%01.2f", $rechargeTotal) . '元，账户总金额：' . $sumAmount . '，具体详情请到<a href="balance.html">我的钱包</a>查看'),
            'type'        => 1,
            'is_read'     => 0,
            'create_time' => $timer,
        );

        //资金往来记录
        $capitalLiquidData = array(
            'userid'      => $userid,
            'shop_id'     => '',
            'title'       => $pay_name_text,
            'content'     => $pay_name_text . '，奖励金额：' . sprintf("%01.2f", $rechargeTotal) . '，来自好友：' . $userInfo['username'] . '，账户总金额：' . $sumAmount,
            'amount'      => sprintf("%01.2f", $rechargeTotal),
            'make'        => '',
            'status'      => 1,
            'type'        => 4,
            'create_time' => $timer,
            'action'      => 1,
        );

        //更新钱包数据
        $walletStatus = InitPHP::getDao('wallet')->update($walletData, array('userid' => $userid));
        //添加支付数据
        $payId = InitPHP::getDao('pay')->create($payData);
        //添加消息数据
        $msgId = InitPHP::getDao('message')->create($msgData);
        //添加资金流动数据
        $capitalLiquidId = InitPHP::getDao('capitalLiquid')->create($capitalLiquidData);
    }

    /**
     * 试用sql查询
     * @param [string] $like [查询条件]
     * @param [integer] $limit [查询起始位置]
     * @param [integer] $offset [查询的数据数量]
     */
    public function query_select($like, $limit, $offset)
    {
        $where = ' userid like "%' . $like . '%" or name like "%' . $like . '%" or wechat like "%' . $like . '%" or phone like "%' . $like . '%" or area like "%' . $like . '%" ';
        return $this->DB->query_select($where, $limit, $offset);
    }

    /*
     * 修改数据
     */
    public function queryUp($data, $userid)
    {
        if (isset($data['name'])) {
            $set = " name = '" . $data['name'] . "',";
        }
        if (isset($data['wechat'])) {
            $set .= " wechat = '" . $data['wechat'] . "',";
        }
        if (isset($data['qq'])) {
            $set .= " qq = '" . $data['qq'] . "',";
        }
        if (isset($data['phone'])) {
            $set .= " phone = '" . $data['phone'] . "',";
        }
        if (isset($data['address'])) {
            $set .= " address = '" . $data['address'] . "',";
        }
        if (isset($data['username'])) {
            $set .= " username = '" . $data['username'] . "'";
        }
        $sql = 'update `shop` set ' . $set . ' where userid=' . $userid;
        return $this->DB->queryUp($sql);
    }

    /*
     **添加店铺父类栏目
     */
    public function createShopCate($data)
    {
        $insertid = $this->categorysDao->create($data);
        if ($insertid) {
            $datas = $this->categorysDao->update(array('arrchildid' => $insertid), array('catid' => $insertid));
            if ($datas) {
                if ($data['parentid'] != 0) {
                    $cateparent = $this->categorysDao->get(array('catid' => $data['parentid']));
                    $this->categorysDao->update(array('arrchildid' => $cateparent['arrchildid'] . ',' . $insertid, 'child' => 1), array('catid' => $data['parentid']));
                }
                return array('code' => 200, 'msg' => 'Success'); //更新成功
            } else {
                return array('code' => 300, 'msg' => 'failed'); //更新成功
            }
        } else {
            return array('code' => 400, 'msg' => 'nulled'); //插入失败
        }
    }
}
