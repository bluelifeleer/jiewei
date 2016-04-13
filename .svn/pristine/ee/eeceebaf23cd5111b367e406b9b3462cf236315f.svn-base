<?php

/**
 * 提现　、消费　服务层
 * @Author: 刘波
 * @Date:   2015-12-29 15:21:40
 * @Last Modified time: 2015-12-29 18:50:06
 */
class spendService extends Service
{
    //错误代码
    public static $msg;
    public function __construct() {
        parent::__construct();
        //获取Dao
    }
    
    /**
     * 现金消费　
     *　　仅支持　余额消费和积分消费
     * @param integer $type           消费类型　１现金，２，积分
     * @param integer $value          消费金额
     * @param string $msg             消费信息
     * @param integer $userid         用户ID
     * @param string $username        用户名
     * @param integer $op_userid      操作人
     * @param string $op_username     操作人用户名
     * @param string $logo            特殊标识，如文章消费时，可以对文章进行标识，以满足在一段时间内，都可以再次的使用
     * @return [type]              [description]
     */
    public static function init($type, $value, $msg, $userid = '', $username = '', $op_userid = '', $op_username = '', $logo = '') {
        if (!in_array($type, array(1, 2))) return InitPHP::Encode(2, 'Pay Type Error', array(), 1);


        $payment = array(1 => 'amount', 2 => 'point');
        
        $payMethod = $payment[$type];
         
        $data = self::$payMethod($value, $msg, $userid, $username, $op_userid, $op_username, $logo) ;
       
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        } 
        else {
            return InitPHP::Encode(3, self::getSpendMsg(), $data, 1);
        }
    }
    
    /**
     * 添加金钱消费记录
     * @param integer $value          消费金额
     * @param string $msg             消费信息
     * @param integer $userid         用户ID
     * @param string $username        用户名
     * @param integer $op_userid      操作人
     * @param string $op_username     操作人用户名
     * @param string $logo            特殊标识，如文章消费时，可以对文章进行标识，以满足在一段时间内，都可以再次的使用
     */
    private static function amount($value, $msg, $userid, $username, $op_userid, $op_username, $logo) {
        
        return self::_add(array('username' => $username, 'userid' => $userid, 'type' => 1, 'value' => $value, 'op_userid' => $op_userid, 'op_username' => $op_username, 'msg' => $msg, 'logo' => $logo));
    }
    
    /**
     * 添加积分消费记录
     * @param integer $value          消费金额
     * @param string $msg             消费信息
     * @param integer $userid         用户ID
     * @param string $username        用户名
     * @param integer $op_userid      操作人
     * @param string $op_username     操作人用户名
     * @param string $logo            特殊标识，如文章消费时，可以对文章进行标识，以满足在一段时间内，都可以再次的使用
     */
    private static function point($value, $msg, $userid, $username, $op_userid, $op_username, $logo) {
        return self::_add(array('username' => $username, 'userid' => $userid, 'type' => 2, 'value' => $value, 'op_userid' => $op_userid, 'op_username' => $op_username, 'msg' => $msg, 'logo' => $logo));
    }
    
    /**
     * 添加消费记录
     * @param array $data 添加消费记录参数
     */
    private static function _add($data) {
         
        $data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
        $data['username'] = isset($data['username']) ? trim($data['username']) : '';
        $data['op_userid'] = isset($data['op_userid']) && intval($data['op_userid']) ? intval($data['op_userid']) : 0;
        $data['op_username'] = isset($data['op_username']) ? trim($data['op_username']) : '';
        $data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
        $data['value'] = isset($data['value']) && intval($data['value']) ? abs(intval($data['value'])) : 0;
        $data['msg'] = isset($data['msg']) ? trim($data['msg']) : '';
        $data['logo'] = isset($data['logo']) ? trim($data['logo']) : '';
        $data['creat_at'] = time();
        
        //判断消费类型
        if (!in_array($data['type'], array(1, 2))) {
            return false;
        }
        
        //判断消费描述
        if (empty($data['msg'])) {
            self::$msg = 1;
            return false;
        }
        
        //判断消费金额
        if (empty($data['value'])) {
            self::$msg = 2;
            return false;
        }
        
        //判断userid和username并
        if (empty($data['userid']) || empty($data['username'])) {
            self::$msg = 3;
            return false;
        }
        
        //判断op_userid和op_username并偿试再次的获取
        if (empty($data['op_userid']) || empty($data['op_username'])) {
            $data['op_username'] = 'system';
            $data['op_userid'] = 0;
        }
        
        //判断用户的金钱或积分是否足够。
        if (!self::_checkUserAcount($data['userid'], $data['type'], $data['value'])) {
            self::$msg = 6;
            return false;
        }
       
        $sql = array();
        if ($data['type'] == 1) {
            
            //金钱方式消费
            $sql = array('amount' => "-=" . $data['value']);
        } 
        elseif ($data['type'] == 2) {
            
            //积分方式消费
            $sql = array('point' => '-=' . $data['value']);
        } 
        else {
            self::$msg = 7;
            return false;
        }
        $wallet = InitPHP::getDao('wallet');
         
        
        $Spend = InitPHP::getDao('paySpend');  
        //进入数据库操作
        if ($Spend->create($data)) {
            
            self::$msg = 0;
            $wallet->update($sql, array('userid' => $data['userid']));
            return true;
        }
        else {
            self::$msg = 8;
            return false;
        }
    }
    
    /**
     * 判断用户的金钱、积分是否足够
     * @param integer $userid    用户ID
     * @param integer $type      判断（1：金钱，2：积分）
     * @param integer $value     数量
     * @param $db                数据库连接
     */
    private static function _checkUserAcount($userid, $type, $value) {
        $wallet = InitPHP::getDao('wallet');
     
        $myWallet = $wallet->get(array('userid' => $userid));

        if ($myWallet) {
            if ($type == 1) {
                
                //金钱消费
                if ($myWallet['amount'] < $value) {
                    return false;
                } 
                else {
                    return true;
                }
            } 
            elseif ($type == 2) {
                
                //积分
                if ($myWallet['point'] < $value) {
                    return false;
                } 
                else {
                    return true;
                }
            } 
            else {
                return false;
            }
        } 
        else {
            return false;
        }
    }
    
    /**
     * 获取详细的报错信息
     * @return [type] [description]
     */
    private static function getSpendMsg() {
        $msg = self::$msg;
        $msgLang['1'] = '请对消费内容进行描述。';
        $msgLang['2'] = '请输入消费金额。';
        $msgLang['3'] = '用户不能为空。';
        $msgLang['6'] = '账户余额不足。';
        $msgLang['7'] = '消费类型为空。';
        $msgLang['8'] = '数据存入数据库时出错。';
        return isset($msgLang[$msg]) ? $msgLang[$msg] : false;
    }
}
