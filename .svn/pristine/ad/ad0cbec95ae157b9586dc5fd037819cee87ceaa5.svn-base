<?php

/**
 * 测试api
 * @Author: 明艺
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2016-01-01 20:06:22
 */
class indexController extends Controller
{
    
    //Action白名单
    public $initphp_list = array(
        'userQcode',//获得二维码
        'send',//发送手机短信
    );
    public function __construct() {
        parent::__construct();
    }
    public function init(){
       exit('API IS REDAY!');
    }
    /**
     * [send description]
     * @return [type] [description]
     */
    public function send(){
        $smsapi = InitPHP::getService('smsNApi');
       
        $InitPHP_conf = InitPHP::getConfig(); //

        $sms_uid = $sms_setting['sms_uid'];
         //短信接口用户ID
        $sms_pid = $sms_setting['productid'];
         //产品ID
        $sms_passwd = $sms_setting['sms_key'];
         //32位密码
        // $smsapi->init($sms_uid, $sms_pid, $sms_passwd);
        // $smsapi->init($sms_uid, $sms_pid, $sms_passwd);
        // $smsapi->init($sms_uid, $sms_pid, $sms_passwd);
         //初始化接口类
        $sent_time = date('Y-m-d H:i:s', time());
        $mobile = 18911570090;
        $id_code = 899889;
        $content = '您好，您的验证码是****'.$id_code;
        // echo $smsapi->api_balance_query_url;
     $a =   $smsapi->send_sms($mobile, $content ,$id_code , $siteid=1);
     var_dump($a);
    }
}
