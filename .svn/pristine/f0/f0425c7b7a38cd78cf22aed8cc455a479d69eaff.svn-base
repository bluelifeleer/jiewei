<?php
class mobileValidateController extends Controller
{
    private $session;

    //定义ACTION白名单
    public $initphp_list = array('send', 'get', 'unsession', 'checkVailCode','resetPasd');

    public function __construct() {
        parent::__construct();
        //$this->session = $this->getUtil('session');
    }

    /**
     *  通过手机发送验证码
     *  @using http://apt.jw.com/account/mobileValidate/mobile/3423423
     *  @param $mobile:initval 手机号码
     *  @return code:initval  短信发送是否成功，１：成功，０：失败
     *  @author 李鹏
     *  @date 2015-12-22
     */
    public function send() {
        $value = array('mobile','type');
        $data = $this->controller->get_gp($value,'G');
        $mobile = trim($data['mobile']);
        $type = $data['type'];
        if (!$this->controller->is_phone($mobile)) {
          $validateCode = '';
          $code = 1;
          $msg = '手机格式不正确';
          InitPHP::Encode($code, $msg, $validateCode);
        }else{
            $sessionVailCode = $this->getUtil('session')->get('valCode');
            if($sessionVailCode){//判断session中是否有验证码，有就继续发送
              $res = $this->sendMobileCode2($mobile,(string)$sessionVailCode);
              InitPHP::Encode(0,'','');
            }else{//没有重新生成发送
              $validateCode = $this->createVaildateCode(6, 1);
              //发送短信验证码
              $res = $this->sendMobileCode2($mobile,(string)$validateCode);
              // var_dump($res);
              $this->getUtil('session')->set('valCode', $validateCode);
              InitPHP::Encode(0,'','');
            }



      }


    }

    /**
     *  获取验证码
     *  @using http://api.jw.com/account/mobileValidate/get
     *  @param none
     *  @return vatilCode
     *  @author 李鹏
     *  @date 2015-12-22
     */
    public function get() {
        $session = $this->getUtil('session');
        $vailCode = $session->get('valCode');
        $code = 1;
        InitPHP::Encode($code,$vailCode);
    }



    /**
     * 重置密码
     * @param [string] $mobile [手机号]
     * @return [string || boolean] 重置密码的状态
     *                    			0:密码重置成功
     *                    			1:手机格式错误
     *                    			2:手机号码为空
     *                    			3:写入数据库失败
     *                    			4:没有此用户
     *                    			5:消息写入数据库失败
     * @author 李鹏
     * @date 2016-01-14
     */
    public function resetPasd(){
      $value = array('modile');
      $data = $this->controller->get_gp($value,'G');
      $mobile = trim($data['modile']);
      if($this->controller->is_empty($mobile)){
        InitPHP::Encode(2,'','');
      }else if(!$this->controller->is_phone($mobile)){
        InitPHP::Encode(1,'','');
      }else{
        $where = array('phone' => $mobile);
        $redisUserKey = 'user:'.$mobile;
        $redLoginKey = 'login:phone:'.$mobile;
        //检测这个手机号码是否有绑定的用户
        $userByPhone = InitPHP::getRemoteService('account','get',array($where));
        if($userByPhone['code'] == 0){

          //生成明文密码
          $newPasd = $this->createVaildateCode();
          $encrypt = create_randomstr();
          $password = password($newPasd,$encrypt);
          $data = array('password' => $password, 'encrypt' => $encrypt);
          $RedisValue = array('password' => $password, 'encrypt' => $encrypt);

          //将新密码写入数据库
          $resetPasd = InitPHP::getRemoteService('account','update',array($data,$where));

          if($resetPasd['code'] == 0){

            //将新密码发送到手机
            $res = $this->sendMobileCode2($mobile,(string)$newPasd,2);

            //更新redis中的密码与加密字符串
            $this->getRedis('default')->redis()->hmset($redisUserKey,$RedisValue);
            $this->getRedis('default')->redis()->hmset($redLoginKey,$RedisValue);

            //记录一条消息
            $data = array(
            	'to_userid' => $userByPhone['data']['userid'],
            	'from_userid' => 0,
            	'title' => '找回密码通知',
            	'contents'=> '你在'.date('Y-m-d H:i:s').'通过手机找回密码进行密码重置操作,如果非本人操作可能是账号泄露，请尽快修改密码',
            	'type'=> 1,
            	'is_read' => 0,
            	'create_time' => time()
            );
            //将消息写入数据库
            $InsertMsgId = InitPHP::getRemoteService('message','create',array($data));
            if($InsertMsgId['code'] == 0){

              InitPHP::Encode(0,'','');

            }else{
              InitPHP::Encode(5,'','');
            }

          }else{
            InitPHP::Encode(3,'','');
          }

        }else{
          InitPHP::Encode(4,'','');
        }
      }

    }



    /**
     * 验证用户输入的验证码是否正确
     * @using http://api.jw.com/account/mobileValidate/checkVailCode/
     * @method [string] GET [接口请求方式]
     * @param [string] $vailcode [验证码]
     * @return [string] [验证成功或者失败信息]
     * @author 李鹏
     * @date 2016-01-02
     */
    public function checkVailCode(){
      $value = array('vailcode');
      $data = $this->controller->get_gp($value,'G');
      $session = $this->getUtil('session');
      $vailCode = $session->get('valCode');
      if($vailCode == $data['vailcode']){
        $code = 0;
        $msg = '验证成功';
        $data = '';
      }else{
        $code = 1;
        $msg = '验证失败';
        $data = '';
      }
      InitPHP::Encode($code,$msg,$data);
    }

    /**
     *  销毁session中的短信验证码
     */
    public function unsession() {
        $this->session->del('valCode');
    }

    /**
     *  生成验证码
     *  @param $count:interval 验证码的个数
     *  @param $type:interval 验证码个类型，１：数字２：字符串３：数字字符串组合
     *  @return $code 返回６位数的验证码
     *  @author 李鹏
     *  @date 2015-12-22
     */
    private function createVaildateCode($count = 6, $type = 1) {
        $code = '';
        $str = '';
        switch ($type) {
            case 2:
                $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;

            case 3:
                $str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                break;

            default:
                $str = '1234567890';
                break;
        }
        for ($i = 0; $i < $count; $i++) {
            $start = mt_rand(0, strlen($str)) !== 0 ? mt_rand(0, strlen($str)) - 1 : mt_rand(0, strlen($str));
            $code.= substr($str, $start, 1);
        }
        return substr($code,0,1) == 0 ? mt_rand(1,9).substr($code,1,intval(strlen($code)-1)) : $code ;
    }


    /**
     * 发送短信验证码给手机
     * @param  [string] $mobile
     * @param  [string] $code
     * @return [array]
     */
    private function sendMobileCode($mobile, $code) {
        $smsapi = InitPHP::getService('smsApi');

        $InitPHP_conf = InitPHP::getConfig(); //

        $sms_setting = $InitPHP_conf['sms'];

        $sms_uid = $sms_setting['sms_uid'];
         //短信接口用户ID
        $sms_pid = $sms_setting['productid'];
         //产品ID
        $sms_passwd = $sms_setting['sms_key'];
         //32位密码
        $smsapi->init($sms_uid, $sms_pid, $sms_passwd);
         //初始化接口类
        $sent_time = date('Y-m-d H:i:s', time());

        return $smsapi->send_sms($mobile, $code, $sent_time, 'utf-8', $code,170);
    }

    /**
     * 发送短信验证码给手机
     * @param  [string] $mobile
     * @param  [string] $code
     * @return [array]
     */
    private function sendMobileCode2($mobile, $code,$type = 1) {
        $smsapi = InitPHP::getService('smsNApi');

        $InitPHP_conf = InitPHP::getConfig(); //

        $sms_setting = $InitPHP_conf['sms'];

        $sms_uid = $sms_setting['sms_uid'];
         //短信接口用户ID
        $sms_pid = $sms_setting['productid'];
         //产品ID
        $sms_passwd = $sms_setting['sms_key'];
         //32位密码
         //初始化接口类
        $sent_time = date('Y-m-d H:i:s', time());
        if($type == 1){
           $content = '您好，您的验证码是'.$code.',有效期10分钟。如非本人操作,可以不用理会。';
        }else{
          $content = '您好，您的验证码(手机用户密码)是'.$code.'。如非本人操作,可以不用理会。';
        }

        return $smsapi->send_sms($mobile, $content,$code, $siteid=1);
    }
}
