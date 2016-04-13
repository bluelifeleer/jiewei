<?php

/**
 * 充值　服务层
 * @Author: 刘波
 * @Date:   2015-12-29 15:21:40
 * @Last Modified time: 2015-12-29 19:34:27
 */
class receiptsService extends Service
{
    
    //错误代码
    public static $msg;
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 现金消费　
     *　　
     * @param integer $type 仅支持　余额消费和积分消费
     * @param integer $amount 入账金额
     * @param integer $userid 用户ID
     * @param string $username 用户名
     * @param integer $trand_sn 操作订单ID,默认为自动生成
     * @param string $pay_type 入账类型 （可选值  offline 线下充值，weipay 微信支付）
     * @param string $payment 入账方式  （如后台充值，支付宝，银行汇款/转账等此处为自定义）
     * @param string  $op_username 管理员信息
     * @param string $status 入账状态  （可选值  succ 默认，入账成功，error 入账失败）注当且仅当为‘succ’时更改member数据
     * @param string  $ip ip
     * @param string  $note note
     */
    public static function init($type, $money, $userid, $username, $email, $mobile, $trade_sn, $pay_type, $payment, $op_username, $status, $ip, $note) {
        
        if (!in_array($type, array(1, 2))) return InitPHP::Encode(2, 'Pay Type Error', array(), 1);
        
        $payments = array(1 => 'amount', 2 => 'point');
        
        $payMethod = $payments[$type];
        
        $data = self::$payMethod($money, $userid, $username, $email, $mobile, $trade_sn, $pay_type, $payment, $op_username, $status, $ip, $note);
        
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        } 
        else {
            return InitPHP::Encode(3, self::getReceiptsMsg(), $data, 1);
        }
    }
    
    /**
     * 改变充值订单的状态，并实线补充充值
     * @param  [type] $tradeSN [description]
     * @param  [type] $status  [description]
     * @return [type]          [description]
     */
    public static function changeReceipts($tradeSN, $status) {
         
        //流水号为空
        if (!$tradeSN) return InitPHP::Encode(1, 'Error', array(), 1);
       
       //状态为空
        if (!$status) return InitPHP::Encode(2, 'Error', array(), 1);
        
        
        
        //获取Dao
        $Account = InitPHP::getDao('payAccount');
        
        //成功，失败，错误，进行中，超时，取消，等待，未支付
        if (in_array($status, array('failed', 'error', 'progress', 'timeout', 'cancel', 'waitting', 'unpay'))) {
            self::$msg = 8;
            
            //进入数据库操作
            $Account->update(array('status' => $status), array('trade_sn' => $tradeSN));
            return InitPHP::Encode(5, 'Success', self::getReceiptsMsg(), 1);
        } 
        else if ($status == 'succ') {
            $data = $Account->get(array('trade_sn' => $tradeSN));
            
            //进入数据库操作
            $Account->update(array('status' => $status), array('trade_sn' => $tradeSN));
            
            if ($data['type'] == 1) {
                
                //金钱方式充值
                $sql = array('amount' => "+=" . $data['money']);
            } 
            elseif ($data['type'] == 2) {
                
                //积分方式充值
                $sql = array('point' => '+=' . $data['money']);
            }
            
            $wallet = InitPHP::getDao('wallet');
            
            $wallet->update($sql, array('userid' => $data['userid'])) ? true : false;
            
            return InitPHP::Encode(0, 'Success', $data, 1);
        } 
        else {
            return InitPHP::Encode(3, 'Error', array(), 1);
            
            //充值状态码不正常
            
            
        }
    }
    
    /**
     * 添加金钱入账记录
     * 添加金钱入账记录操作放放
     * @param integer $value 入账金额
     * @param integer $userid 用户ID
     * @param string $username 用户名
     * @param integer $trand_sn 操作订单ID,默认为自动生成
     * @param string $pay_type 入账类型 （可选值  offline 线下充值，weipay 微信支付）
     * @param string $payment 入账方式  （如后台充值，支付宝，银行汇款/转账等此处为自定义）
     * @param string  $op_username 管理员信息
     * @param string $status 入账状态  （可选值  succ 默认，入账成功，error 入账失败）注当且仅当为‘succ’时更改member数据
     * @param string  $ip ip
     * @param string  $note note
     */
    private static function amount($value, $userid = '', $username = '', $email = '', $mobile = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $ip = '', $note = '') {
        return self::_add(array('username' => $username, 'userid' => $userid, 'money' => $value, 'trade_sn' => $trade_sn, 'pay_type' => $pay_type, 'payment' => $payment, 'status' => $status, 'type' => 1, 'adminnote' => $op_username, 'ip' => $ip, 'email' => $email, 'mobile' => $mobile, 'usernote' => $note));
    }
    
    /**
     * 添加积分消费记录
     * @param integer $value 入账金额
     * @param integer $userid 用户ID
     * @param string $username 用户名
     * @param integer $trand_sn 操作订单ID,默认为自动生成
     * @param string $pay_type 入账类型 （可选值  offline 线下充值，weipay 微信支付）
     * @param string $payment 入账方式  （如后台充值，支付宝，银行汇款/转账等此处为自定义）
     * @param string  $op_username 管理员信息
     * @param string $status 入账状态  （可选值  succ 默认，入账成功，error 入账失败）注当且仅当为‘succ’时更改member数据
     * @param string  $ip ip
     * @param string  $note note
     */
    private static function point($value, $userid = '', $username = '', $email = '', $mobile = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $ip = '', $note = '') {
        return self::_add(array('username' => $username, 'userid' => $userid, 'money' => $value, 'trade_sn' => $trade_sn, 'pay_type' => $pay_type, 'payment' => $payment, 'status' => $status, 'type' => 2, 'adminnote' => $op_username, 'ip' => $ip, 'email' => $email, 'mobile' => $mobile, 'usernote' => $note));
    }
    
    /**
     * 添加消费记录
     * @param array $data 添加消费记录参数
     */
    private static function _add($data) {
        $data['money'] = isset($data['money']) && floatval($data['money']) ? floatval($data['money']) : 0;
        $data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
        $data['username'] = isset($data['username']) ? trim($data['username']) : '';
        $data['trade_sn'] = (isset($data['trade_sn']) && $data['trade_sn']) ? trim($data['trade_sn']) : create_sn();
        $data['pay_type'] = isset($data['pay_type']) ? trim($data['pay_type']) : 'offline';
        $data['payment'] = isset($data['payment']) ? trim($data['payment']) : '';
        $data['adminnote'] = isset($data['op_username']) ? trim($data['op_username']) : '';
        $data['usernote'] = isset($data['usernote']) ? trim($data['usernote']) : '';
        $data['status'] = isset($data['status']) ? trim($data['status']) : 'succ';
        $data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
        $data['ip'] = isset($data['ip']) && trim($data['ip']) ? trim($data['type']) : '';
        $data['email'] = isset($data['email']) && trim($data['email']) ? trim($data['email']) : '';
        $data['mobile'] = isset($data['mobile']) && trim($data['mobile']) ? trim($data['mobile']) : '';
        $data['addtime'] = time();
        
        //检察消费类型
        if (!in_array($data['type'], array(1, 2))) {
            return false;
        }
        
        //检查入账类型
        if (!in_array($data['pay_type'], array('offline', 'weipay'))) {
            self::$msg = 4;
            return false;
        }
        
        //检查入账状态
        //成功，失败，错误，进行中，超时，取消，等待，未支付
        if (!in_array($data['status'], array('succ', 'failed', 'error', 'progress', 'timeout', 'cancel', 'waitting', 'unpay'))) {
            self::$msg = 5;
            return false;
        }
        
        //检查消费描述
        if (empty($data['payment'])) {
            self::$msg = 6;
            return false;
        }
        
        //检查消费金额
        if (empty($data['money'])) {
            self::$msg = 2;
            return false;
        }
        
        //检查userid和username并偿试再次的获取
        if (empty($data['userid']) || empty($data['username'])) {
            self::$msg = 3;
            return false;
        }
        
        //检查op_userid和op_username并偿试再次的获取
        if (empty($data['adminnote'])) {
            $data['adminnote'] = 'SYSTEM';
        }
        
        $sql = array();
        if ($data['type'] == 1) {
            
            //金钱方式充值
            $sql = array('amount' => "+=" . $data['money']);
        } 
        elseif ($data['type'] == 2) {
            
            //积分方式充值
            $sql = array('point' => '+=' . $data['money']);
        } 
        else {
            self::$msg = 7;
            return false;
        }
        $wallet = InitPHP::getDao('wallet');
        
        //获取Dao
        $Account = InitPHP::getDao('payAccount');
        
        //进入数据库操作
        $insertid = $Account->create($data, true);
        if ($insertid && $data['status'] == 'succ') {
            return $wallet->update($sql, array('userid' => $data['userid'])) ? true : false;
        } 
        else {
            self::$msg = 8;
            return false;
        }
    }
    
    /**
     * 获取详细的报错信息
     * @return [type] [description]
     */
    private function getReceiptsMsg() {
        $msg = self::$msg;
        $msgLang['1'] = '请对消费内容进行描述。';
        $msgLang['2'] = '请输入消费金额。';
        $msgLang['3'] = '用户不能为空。';
        $msgLang['4'] = '付款方式不支持';
        $msgLang['5'] = '入账状态错误';
        $msgLang['6'] = '支付接口错误';
        $msgLang['7'] = '充值类型为空。';
        $msgLang['8'] = '充值未成功';
        return isset($msgLang[$msg]) ? $msgLang[$msg] : $msg;
    }
}
