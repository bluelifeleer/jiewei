<?php
class indexController extends Controller
{
    public $initphp_list = array('payOrder');
    public $today,$cleaningTimeStart,$cleaningTimeEnd,$bonus;
    public function __construct()
    {
        parent::__construct();
        //设定给核算提成的周期
        $this->today = strtotime(date('Y-m-d 00:00:01',time()));
        $stepDays = 15; //可以控制 的天数，测试期为0 ，表示今天
        $step = 86400;
        $this->cleaningTimeStart = $this->today - ($stepDays*$step);
        $this->cleaningTimeEnd = $this->today - ($stepDays*$step) + ($step-2);
        //
        $this->bonus = InitPHP::getDao('orderBonus');
        //资金流水
        $this->CapitalDB    = InitPHP::getDao('capitalLiquid');
        //钱包
        $this->wallet    = InitPHP::getDao('wallet');
        //站内信
        $this->message       = InitPHP::getDao('message');
    }
    /**
     * 拉取数据到 提成表。
     * 3 ，发货了
     * 4 ，收货了
     * @return [type] [description]
     */
    public function init (){
        //查询范围
        //--范围开始 -默认是 $stepDays天前的早上00：00：01
        // $cleaningTimeStart = $this->cleaningTimeStart;
        //--范围结束 -默认是 $stepDays 天前的早上23：59：59
        //$cleaningTimeEnd = $this->cleaningTimeEnd;
        //echo date('Y-m-d H:i:s',$cleaningTimeEnd).'<br>';
        //$where = " `is_over`=1 AND `is_after_sales` !=1 AND `is_after_sales` !=2 AND `from_id`=1 AND `goods_status` >= 3 AND `shipping_time` between ".$cleaningTimeStart." and ".$cleaningTimeEnd;
        //时时冻结 已发货且未冻结的平台商品的订单。
        $where = " `is_over`=1 AND `is_after_sales` !=1 AND `is_after_sales` !=2 AND `from_id`=1 AND `goods_status` >= 3 ";
        //1. 已结算，并且非退款及申请退款中商品，并且已发货状态，且发货时间在 核算周期内的商品
        $waitingList = InitPHP::getDao('orderGoods')->select($where);
        //2. 拒绝退款，且发货时间 超过15 （限定周期）天的。
        
        if(!empty($waitingList))
        foreach ($waitingList as $key => $value) {
            $this->copyBonus($value);
        };
        //$this->logs(json_encode($waitingList));
    }

    /**
     * 成功复制信息到 提成表
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function copyBonus($value){
                $orderId = $value['order_id'];
                $goodsId = $value['goods_id'];
                if (!$this->bonus->checkOrder($orderId,$value['goods_id'])) {
                    $msg = date('m-d H:i:s',time()).' 订单号已存在:'.$orderId.':'.$goodsId."\r\n";
                    $this->logs($msg);
                    return true;
                }
                $insert['id']             = $value['og_id'];
                $insert['order_id']       = $value['order_id'];
                $insert['goods_id']       = $value['goods_id'];
                $insert['goods_name']     = $value['goods_name'];
                $insert['goods_sn']       = $value['goods_sn'];
                $insert['goods_number']   = $value['goods_number'];
                $insert['goods_price']    = $value['goods_price'];
                $insert['goods_level']    = $value['goods_level'];
                $insert['goods_pic']      = $value['goods_pic'];
                $insert['order_total']    = $value['order_total'];
                $insert['cost_price']     = $value['cost_price']; //商品成本价格,－外部使用
                $insert['purchase_price'] = $value['purchase_price']; //商品采购价格,－内部使用
                $insert['shipping_time'] = $value['shipping_time']; //发货时间
                //卖家利润　＝　销售价　－　商品成本价格
                $bonus           = ($value['goods_price'] - $value['cost_price']) * $value['goods_number'];
                $insert['bonus'] = $bonus * 10000;
                //平台利润　＝　销售价　－　商品采购价格
                $insert['system_bonus'] = ($value['cost_price'] - $value['purchase_price']) * 10000;
                //优先计算出　买家的等级
                $insert['siteid']     = $value['shop_id'];
                $site_level           = InitPHP::getDao("account")->getLevels($value['shop_id']);
                $insert['site_level'] = $site_level;

                //商品等级核算公式
                $site_Level_co     = $this->getRedis('default')->redis()->hgetall('proLevel:' . $site_level . 'S');
                $insert['formula'] = json_encode($site_Level_co);
                //销售方利润
                if ($value['shop_id'] > 1) {
                    $insert['site_bonus'] = $bonus * (int) $site_Level_co['tA'] * 100;
                } else {
                    $insert['site_bonus'] = 0;
                }
                $uid_1             = InitPHP::getDao("account")->get(array('userid' => $value['userid']));
                $insert['uid_1']   = $uid_1['userid'];
                $insert['level_1'] = $uid_1['level'];

                //推荐人利润
                $uid_2 = InitPHP::getDao("account")->get(array('userid' => $uid_1['parentid']));
                if ($uid_1['parentid'] > 1) {
                    $insert['uid_2']   = $uid_2['userid'];
                    $insert['level_2'] = $uid_2['levels'];
                    $insert['bonus_2'] = $bonus * (int) $site_Level_co['tB'] * 100;
                } else {
                    $insert['uid_2']   = 1;
                    $insert['level_2'] = 1;
                    $insert['bonus_2'] = 0;
                }

                //推荐人上级利润
                if ($uid_2['parentid'] > 1) {
                    $uid_3             = InitPHP::getDao("account")->get(array('userid' => $uid_2['parentid']));
                    $insert['uid_3']   = $uid_3['userid'];
                    $insert['level_3'] = $uid_3['levels'];
                    $insert['bonus_3'] = $bonus * (int) $site_Level_co['tC'] * 100;
                } else {
                    $insert['userid']  = 1;
                    $insert['levels']  = 1;
                    $insert['bonus_3'] = 0;
                }
                //冗余利润
                $insert['less_bonus'] = $insert['bonus'] - $insert['site_bonus'] - $insert['bonus_2'] - $insert['bonus_3'];
                $insert['inputtime'] = time();
                $insert['status']    = 0;
                $res = $this->bonus->create($insert);
                if($res){
                    InitPHP::getDao('orderGoods')->update(array('is_over'=>99),array('order_id'=>$orderId,'goods_id'=>$goodsId,'goods_status'=>$value['goods_status'],'shipping_time'=>$value['shipping_time']));
                    $msg = date('m-d H:i:s',time()).' 记录订单号:'.$orderId.':'.$goodsId."\r\n";
                    $this->logs($msg);
                }else{
                    $msg = date('m-d H:i:s',time()).' 订单插入失败:'.$orderId.':'.$goodsId."\r\n";
                    $this->logs($msg);
                }
                
    }
    /**
     * 再次验证 提成表的数据是否可以结算钱给用户
     * 3 ，发货了
     * 4 ，收货了
     * @return [type] [description]
     */
    public function  overBonus(){
        //查询范围
        //--范围开始 -默认是 $stepDays天前的早上00：00：01
        $cleaningTimeStart = $this->cleaningTimeStart;
        //--范围结束 -默认是 $stepDays 天前的早上23：59：59
        $cleaningTimeEnd = $this->cleaningTimeEnd;
        //echo date('Y-m-d H:i:s',$cleaningTimeEnd).'<br>';
        $where = " `pay_time`=0 AND `status` =0  AND `shipping_time` < ".$cleaningTimeEnd;
        //1. 已结算，并且非退款及申请退款中商品，并且已发货状态，且发货时间在 核算周期内的商品
        $waitingList = $this->bonus->select($where);
        // echo date('m-d H:i:s',1458462480).'=';
        //var_dump(count($waitingList));
        //2. 拒绝退款，且发货时间 超过15 （限定周期）天的。
        if(!empty($waitingList)){
            
            foreach($waitingList as $val):
                 
                /*************UID 2 ************/
                if($val['uid_2'] !='' && $val['uid_2']!='1'){
                         //添加资金记录
                        $val['bonus_2'] = $val['bonus_2']/10000;
                        
                        $this->wallet->update(array('amount'=>'+='.$val['bonus_2']),array('userid'=>$val['uid_2']));

                        $this->upLevels($val['uid_2']);

                        $CapitalInfo_2 = array(
                            'userid' => $val['uid_2'],
                            'shop_id' => '',
                            'title' => '订单['.$val['order_id'].']团队提成',
                            'content' => '买家['.$val['uid_1'].']消费的订单['.$val['order_id'].'],TA是您的团队成员,本单提成￥:' . sprintf("%01.2f", ($val['bonus_2']/10000)) . '已到账.',
                            'amount' => sprintf("%01.2f", ($val['bonus_2'])),
                            'make' => '',
                            'status' => 1,
                            'type' => 2,
                            'create_time' => time(),
                            'action' => 1,
                        );
                        $rs = $this->CapitalDB->insert($CapitalInfo_2);
                       
                        //添加消息记录
                        $msgData_2 = array(
                            'to_userid' => $val['uid_2'],
                            'from_userid' => 1,
                            'title' => '订单['.$val['order_id'].'] 团队提成已到账',
                            'contents' => htmlspecialchars('买家['.$val['uid_1'].']消费的订单['.$val['order_id'].'],TA是您的团队成员,本单提成￥:' . sprintf("%01.2f", $val['bonus_2']) . '已到账.'),
                            'type' => 1,
                            'is_read' => 0,
                            'create_time' =>  time(),
                        );
                        $this->message->insert($msgData_2);
                 }

                /*************UID 3 ************/
                if($val['uid_3'] !='' && $val['uid_3']!='1' ){
                        $val['bonus_3'] = $val['bonus_3']/10000;

                        $this->wallet->update(array('amount'=>'+='.$val['bonus_3']),array('userid'=>$val['uid_3']));
                        $this->upLevels($val['uid_3']);
                        //添加资金记录
                        $CapitalInfo_3 = array(
                            'userid' => $val['uid_3'],
                            'shop_id' => '',
                            'title' => '订单['.$val['order_id'].'] 团队提成',
                            'content' => '买家['.$val['uid_1'].']消费的订单['.$val['order_id'].'],TA是您的团队成员,本单提成￥:' . sprintf("%01.2f", $val['bonus_3']) . '已到账.',
                            'amount' => sprintf("%01.2f",$val['bonus_3']),
                            'make' => '',
                            'status' => 1,
                            'type' => 2,
                            'create_time' => time(),
                            'action' => 1,
                        );
                        $this->CapitalDB->insert($CapitalInfo_3);
                        
                        //添加消息记录
                        $msgData_3 = array(
                            'to_userid' => $val['uid_3'],
                            'from_userid' => 1,
                            'title' => '订单['.$val['order_id'].'] 团队提成已到账',
                            'contents' => htmlspecialchars('买家['.$val['uid_1'].']消费的订单['.$val['order_id'].'],TA是您的团队成员,本单提成￥:' . sprintf("%01.2f", $val['bonus_3']) . '已到账.'),
                            'type' => 1,
                            'is_read' => 0,
                            'create_time' =>  time(),
                        );
                        $this->message->insert($msgData_3);
                }
                /*************siteid ************/
                if($val['siteid'] !='' && $val['siteid']!='1' ){
                    
                    $val['site_bonus'] = $val['site_bonus']/10000;

                    $this->wallet->update(array('amount'=>'+='.$val['site_bonus']),array('userid'=>$val['siteid']));
                    $this->upLevels($val['siteid']);
                    //添加资金记录
                    $CapitalInfo_site = array(
                        'userid' => $val['siteid'],
                        'shop_id' => '',
                        'title' => '订单['.$val['order_id'].'] 销售提成',
                        'content' => '买家['.$val['uid_1'].']在您点里购买的订单['.$val['order_id'].']，您当前是V'.$val['site_level'].',享有销售提成￥:' . sprintf("%01.2f", $val['site_bonus']) . '已到账.',
                        'amount' => sprintf("%01.2f", $val['site_bonus']),
                        'make' => '',
                        'status' => 1,
                        'type' => 2,
                        'create_time' => time(),
                        'action' => 1,
                    );

                    $this->CapitalDB->insert($CapitalInfo_3);
                    
                    //添加消息记录
                    $msgData_site = array(
                        'to_userid' => $val['siteid'],
                        'from_userid' => 1,
                        'title' => '订单['.$val['order_id'].'] 销售提成已到账',
                        'contents' => htmlspecialchars('买家['.$val['uid_1'].']在您点里购买的订单['.$val['order_id'].']，您当前是V'.$val['site_level'].',享有销售提成￥:' . sprintf("%01.2f", $val['site_bonus']) . '已到账.'),
                        'type' => 1,
                        'is_read' => 0,
                        'create_time' =>  time(),
                    );
                   $this->message->insert($msgData_site);
                }

                $this->bonus->update(array('pay_time'=>time()),$val['id']);
                       
            endforeach;       
        }
        
    }

    /**
     * 等级提升
     * @param  [type] $amount [description]
     * @param  [type] $userid [description]
     * @return [type]         [description]
     */
    public function upLevels($userid){
         //$userid='12460104948885299106';
        $userinfo = $this->getRedis('default')->redis()->hgetall('userinfo:'.$userid);
        $lv = $this->Levels($userid,$userinfo);
        if($lv == $userinfo['levels'])return true;
        InitPHP::getDao("account")->update(array('levels'=>$lv),array('userid'=>$userid));
        $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, array('levels'=>$lv));
        if(trim($userinfo['phone']) !=''){
            $this->getRedis('default')->redis()->hmset('user:' . $userinfo['phone'], array('levels'=>$lv));
        }else{
            $this->getRedis('default')->redis()->hmset('user:' . $userinfo['wechat_openid'], array('levels'=>$lv));
        }
        return true;
    }

    private function Levels($userid,$userinfo){

        $bonusList = $this->bonus->query('SELECT * FROM (SELECT SUM(`bonus_2`) FROM `order_bonus` WHERE `uid_2`='.$userid.' and `pay_time`!=0) AS bonus_2,(SELECT SUM(`bonus_3`) FROM `order_bonus` WHERE `uid_3`='.$userid.' and `pay_time`!=0) AS bonus_3,(SELECT SUM(`site_bonus`) FROM `order_bonus` WHERE `siteid`='.$userid.' and `pay_time`!=0) AS site_bonus');
        $amount = 0 ;
        foreach ($bonusList[0] as $value) {
            $amount +=(int)$value;  
        }
        $amount = $amount / 10000;
        if ($amount < 580) {
            $LV = 0;
            if($userinfo['is_has_shop']){
                $LV = 1;
            }
        }
        $LVamount = $userinfo['is_has_shop']?0:580;
        if ($amount >= $LVamount) {
            $LV = 1;
        }
        $LVamount = $userinfo['is_has_shop']?5000-580:5000;
        if ($amount >= $LVamount) {
            $LV = 2;
        }
        $LVamount = $userinfo['is_has_shop']?20000-580:20000;
        if ($amount >= $LVamount) {
            $LV = 3;
        }
        $LVamount = $userinfo['is_has_shop']?50000-580:50000;
        if ($amount >= $LVamount) {
            $LV = 4;
        }
        $LVamount = $userinfo['is_has_shop']?150000-580:150000;
        if ($amount >= $LVamount) {
            $LV = 5;
        }
        $LVamount = $userinfo['is_has_shop']?200000-580:200000;
        if ($amount >= $LVamount) {
            $LV = 6;
        }
        $LVamount = $userinfo['is_has_shop']?400000-580:400000;
        if ($amount >= $LVamount) {
            $LV = 7;
        }
        $LVamount = $userinfo['is_has_shop']?600000-580:600000;
        if ($amount >= $LVamount) {
            $LV = 8;
        }
        $LVamount = $userinfo['is_has_shop']?800000-580:800000;
        if ($amount >= $LVamount) {
            $LV = 9;
        }
        return $LV;
    }



    /**
     * [logs description]
     * @param  [type] $msg [description]
     * @return [type]      [description]
     */
    public function logs ($msg){
        error_log($msg, 3, APP_PATH.'error_log.php');
    }
}
