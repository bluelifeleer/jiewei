<?php

/**
 * 描述该文件的主要功能
 * @Author: 刘波
 * @description: 后台首页
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2016-03-26 01:41:16
 */
include_once CORE_PATH . 'library/wechat/lanewechat.php';
class indexController extends Controller
{

    //Action白名单
    public $initphp_list = array(

        //描述该控制器下的方法的简易说明
        //检测是否登录
        'chechLogin',
        'login',
        //退出
        'logout',
        //注册
        'register',
        //判断用户是否存在
        'isExists',
        //会员列表
        'accountList',
        //获取用户信息
        'memberInfo',
        //修改密码
        'modifyPassword',
        //找回密码
        'findPassword',
        //绑定手机
        'bindMobile',
        //更换手机
        'rebindMobile',
        //修改基本资料
        'modifyMemberInfo',
        //修改头像
        'modifyAvatar',
        //修改会员信息
        'modifyInfo',
        //更换绑定手机
        'replacePhone',
        //会员实名认证
        'authentication',
        //微信登入
        'wechatLogin',
        //get Waaly
        'getWallet',
        //消费记录列表
        'consumeRecordsLists',
        //开通店铺
        'openShop',
        //获取用户消费额度
        'getConsumptionQuota',
        //获取用户等级
        'getLevels',
        //手机号是否存在
        'isExistsPhone',
        //我的业绩
        'myBonus',
        // 团队业绩
        'teamBonus',
    );

    //用户登录方式
    private $loginType;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 如果访问URL未存在 参数，则必须有 init 方法
     * 例如  http://api.jw.com/account/index/init
     * @return [type] [description]
     */
    public function init()
    {
       // exit($this->getUtil('cookie')->get('LIUBO').'x');
        $sessionid = $this->getUtil('session')->get_session_id();
        $this->getUtil('session')->set('sso_session', $sessionid);
        $YunUser = $this->getUtil('session')->get('_YunUser');
        $this->getUtil('session')->set('_YunUser', $YunUser);
        exit($sessionid);
    }

    public function chechLogin($regPhone = '')
    {
        $chcGetSessionKey = '';
        //记录当前用户的推荐人信息
        $YunUser = $this->getUtil('session')->get('_YunUser');
        $this->getRedis('default')->redis()->delete('sso_session:');
        $this->getRedis('default')->redis()->delete('user:');
        $this->getRedis('default')->redis()->delete('null');
        if (isset($_POST['YunUser']) && trim($_POST['YunUser']) != '0') {
            $YunUser = safe_replace($_POST['YunUser']);
            $this->getUtil('session')->set('_YunUser', $YunUser);
        }
        if (isset($regPhone) && $regPhone != '') {
            $chcGetSessionKey = '_' . $regPhone;
            $phone            = $this->getUtil('session')->get($chcGetSessionKey);

            if ($phone && $phone !== '') {
                $redisGetKey = 'user:' . $phone;
                $memberInfo  = $this->getRedis('default')->redis()->hgetall($redisGetKey);
            } else {

                $memberInfo = false;
            }
        } else {
            $chcGetSessionKey = '_phone';
            //　１　 常规登入　、　判断是否存在 mobile
            $phone = $this->getUtil('session')->get($chcGetSessionKey);

            if ($phone && $phone !== '' && $phone !== 0) {
                $redisGetKey = 'user:' . $phone;
                $memberInfo  = $this->getRedis('default')->redis()->hgetall($redisGetKey);

            } else {

                // // 2　微信登入   openid
                $openid = $this->getUtil('session')->get('wechat_openid');
                if ($openid) {
                    $_memberInfo = \LaneWeChat\Core\UserManage::getUserInfo($openid);
                    $_res        = InitPHP::getRemoteService('account', 'get', array(array('wechat_openid' => $openid)));
                    $MemberInfo  = array_merge($_memberInfo, $_res['data']);

                    $memberInfo['userid']          = $MemberInfo['userid'];
                    $memberInfo['nickname']        = $MemberInfo['nickname'];
                    $memberInfo['sex']             = $MemberInfo['sex'];
                    $memberInfo['email']           = $MemberInfo['email'];
                    $memberInfo['parentid']        = $MemberInfo['parentid'];
                    $memberInfo['levels']          = $MemberInfo['levels'];
                    $memberInfo['layer']           = $MemberInfo['layer'];
                    $memberInfo['qq']              = $MemberInfo['qq'];
                    $memberInfo['wechat']          = $MemberInfo['wechat'];
                    $memberInfo['is_has_shop']     = $MemberInfo['is_has_shop'];
                    $memberInfo['phone']           = $MemberInfo['phone'];
                    $memberInfo['is_wechat_login'] = 1;
                    $memberInfo['avarat']          = !empty($MemberInfo['avarat']) ? $MemberInfo['avarat'] : $MemberInfo['headimgurl'];
                }

            }
        }

        if ($memberInfo) {
            $memberInfo['YunUser']     = $YunUser;
            $memberInfo['sso_session'] = $this->getUtil('session')->get_session_id();
            InitPHP::Encode(1, 'isExists', $memberInfo); //存在
        } else {
            InitPHP::Encode(0, 'noExists', array('YunUser' => $YunUser, 'sso_session' => $this->getUtil('session')->get_session_id())); //不存在
            //InitPHP::Encode(0, 'noExists',array('YunUser'=>$YunUser)); //不存在
        }
    }

    /**
     * 用户登录
     * @param [string] $phone [登录手机号]
     * @param [string] $passsword [登录密码]
     * @return [array] $userinfo [登录成功返回用户信息]
     */
    public function login()
    {
        /*
         * 该方法在Controller层中，获取所有GET或者POST数据，都需要走这个接口
         *  Controller中使用方法：$this->controller->get_gp($value, $type = null,  $isfilter = true)
         * @param  string|array $value 参数
         * @param  string|array $type 获取GET或者POST参数，P - POST ， G - GET
         * @param  bool         $isfilter 变量是否过滤
         * @return string|array
         */
        $value = array('account', 'password');
        //http://api.jw.com/index/login/username/test\eval('php')/password/123456
        $data          = $this->controller->get_gp($value);
        $redisLoginKey = '';
        $redisGetKey   = '';
        if ($this->controller->is_phone($data['account'])) {
//手机
            $this->loginType = 'phone';
        } elseif ($this->controller->is_email($data['account'])) {
//邮箱
            $this->loginType = 'email';
        } else {
//用户名
            $this->loginType = 'nickname';
        }
        //判断是否已登录

        /**
         * 存储方式：login:phonr:13546481451 密码
         *          user:13546481451 array('id' => ,'userid' => ,........)
         */
        $redisLoginKey = 'login:' . $this->loginType . ':' . $data['account'];
        $redisGetKey   = 'user:' . $data['account'];
        if ($this->getRedis('default')->redis()->exists($redisLoginKey)) {
            $redisValueArr = $this->getRedis('default')->redis()->hmget($redisLoginKey, array('password', 'encrypt'));
            if ($redisValueArr['password'] == password($data['password'], $redisValueArr['encrypt'])) {

                $getValue = $this->getRedis('default')->redis()->hmget($redisGetKey, array('userid', 'nickname', 'sex', 'avarat', 'email', 'parentid', 'levels', 'qq', 'wechat', 'is_has_shop', 'phone', 'password', 'encrypt'));

                //set session
                $this->getUtil('session')->set('_userid', $getValue['userid']);
                $this->getUtil('session')->set('_nickname', $getValue['nickname']);
                $this->getUtil('session')->set('_phone', $getValue['phone']);
                $this->getUtil('session')->set('_YunUser', $getValue['parentid']); //推荐人
                $this->getUtil('session')->set('_loginType', $this->loginType);
                InitPHP::Encode(0, 'Success', $getValue);
            } else {
                InitPHP::Encode(1, 'passwordError', $_COOKIE);
            }
        } else {
            //用mysql方式二次验证
            $where = array($this->loginType => $data['account']);
            //提交服务层验证
            $loginStart = InitPHP::getRemoteService('account', 'checkPassword', array($where, $data['password']));

            if ($loginStart && $loginStart['code'] == 0) {
                //将数据存入redis
                $setValue = array(
                    'password' => $loginStart['data']['password'],
                    'encrypt'  => $loginStart['data']['encrypt'],
                );
                $hValue = array(
                    'userid'      => $loginStart['data']['userid'],
                    'nickname'    => $loginStart['data']['nickname'],
                    'sex'         => $loginStart['data']['sex'],
                    'avarat'      => $loginStart['data']['avarat'],
                    'email'       => $loginStart['data']['email'],
                    'parentid'    => $loginStart['data']['parentid'],
                    'levels'      => $loginStart['data']['levels'],
                    'qq'          => $loginStart['data']['qq'],
                    'wechat'      => $loginStart['data']['wechat'],
                    'is_has_shop' => $loginStart['data']['is_has_shop'],
                    'phone'       => $loginStart['data']['phone'],
                    'password'    => $loginStart['data']['password'],
                    'encrypt'     => $loginStart['data']['encrypt'],
                );
                $this->getRedis('default')->redis()->hmset($redisLoginKey, $setValue);
                $this->getRedis('default')->redis()->hmset($redisGetKey, $hValue);
                $this->getRedis('default')->redis()->hmset('userinfo:' . $loginStart['data']['userid'], $hValue);
                //将数据存入session
                $this->getUtil('session')->set('_userid', $loginStart['data']['userid']);
                $this->getUtil('session')->set('_nickname', $loginStart['data']['nickname']);
                $this->getUtil('session')->set('_phone', $loginStart['data']['phone']);
                $this->getUtil('session')->set('_YunUser', $loginStart['data']['parentid']); //推荐人
                $this->getUtil('session')->set('_loginType', $this->loginType);

                InitPHP::Encode(0, 'Success', jsonEncode($loginStart['data']));
            } else if ($loginStart['code'] == 2) {
//帐号未注册
                InitPHP::Encode(2, 'accountNotRegist', '');
            } else {
//密码错误
                //set session
                $this->getUtil('session')->set('_userid', 0);
                $this->getUtil('session')->set('_nickname', '');
                $this->getUtil('session')->set('_phone', '');
                $this->getUtil('session')->set('_YunUser', 1); //推荐人
                $this->getUtil('session')->set('_loginType', '');
                InitPHP::Encode(1, 'passwordError', '');
            }
        }

    }

    /**
     *  用户注册
     *  @using http://api.jw.com/account/index/register
     *  @method [string]　POST [请求方式]
     *  @param [json] $postData [提交数据{phone,vaildataCode,password,agianPassword}]
     *  @return [int] $status [返回值０:成功;１:失败;2:验证码错误;3:两次输入密码不相同;4:手机格式不正确]
     *  @author 李鹏
     *  ***** 记得把 YunUser 给传上来，并且保存到数据库。
     *  @date 2015-12-22
     */
    public function register()
    {
        $value   = array('phone', 'pasd', 'confirm_pasd', 'vail_code', 'YunUser');
        $regData = $this->controller->get_gp($value, 'P');
        //$parentId = $this->controller->get_gp($value, 'G');
        //获取session中的验证码
        $vailCode = $this->getUtil('session')->get('valCode');
        //判断手机格式是否正确
        if (!$this->controller->is_phone(trim($regData['phone']))) {
            InitPHP::Encode(4, '手机格式不正确', '');
        }
        //判断验证码是否一至
        if ($vailCode !== trim($regData['vail_code'])) {
            InitPHP::Encode(2, '验证码错误', '');
        }
        //判断两次输入的密码是否相同
        if (trim($regData['pasd']) !== trim($regData['confirm_pasd'])) {
            InitPHP::Encode(3, '两次输入密码不相同', '');
        }
        $userid   = $this->create_randid();
        $encrypt  = create_randomstr();
        $password = password(trim($regData['pasd']), $encrypt);
        $time     = time();
        //layer 关系网中的层级
        $YunUserId = $this->getUtil('session')->get('_YunUser') && $this->getUtil('session')->get('_YunUser') != '' ? $this->getUtil('session')->get('_YunUser') : 1;
        $YunUser   = $this->getRedis('default')->redis()->hmget('user:' . $YunUserId, array('levels', 'layer'));
        $data      = array('userid' => $userid, 'nickname' => '', 'password' => $password, 'encrypt' => $encrypt, 'sex' => 1, 'avarat' => '', 'qq_openid' => '', 'wechat_openid' => '', 'sina_openid' => '', 'phone' => trim($regData['phone']), 'email' => '', 'parentid' => $YunUserId, 'levels' => 0, 'layer' => intval($YunUser['layer'] + 1), 'qq' => '', 'wechat' => '', 'create_time' => $time, 'is_has_shop' => 0,
        );

        $regresult = InitPHP::getRemoteService('account', 'create', array($data));

        if ($regresult['code'] == 0) {
            //判断session中是否有保存的验证码，如果有则清除
            if (isset($vailCode) && $vailCode !== "") {
                $this->getUtil('session')->del('valCode');
            }
            //将数据存入redis
            $setKey   = 'login:phone:' . trim($regData['phone']);
            $setValue = array(
                'password' => $password,
                'encrypt'  => $encrypt,
            );
            $hkey   = 'user:' . trim($regData['phone']);
            $hValue = array(
                'userid'      => $userid,
                'nickname'    => '',
                'sex'         => 1,
                'avarat'      => '',
                'email'       => '',
                'parentid'    => $YunUserId,
                'levels'      => 0,
                'layer'       => intval($YunUser['layer'] + 1),
                'qq'          => '',
                'wechat'      => '',
                'is_has_shop' => 0,
                'phone'       => trim($regData['phone']),
                'password'    => $password,
                'encrypt'     => $encrypt,
            );
            $this->getRedis('default')->redis()->hmset($setKey, $setValue);
            $this->getRedis('default')->redis()->hmset($hkey, $hValue);
            $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, $hValue);
            //将数据存入session
            $sessionData = array(
                'userid'    => $userid,
                'nickname'  => '',
                'loginType' => trim($regData['phone']),
            );
            $this->getUtil('session')->set('user:login', jsonEncode($sessionData));
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }

    }

    /**
     * 判断注册的手机号码是否已注册
     * @method [string] get [请求方式]
     * @param [string] $phone [要判断的手机号]
     * @return [boolean] $status　[返回的状态]
     * @author 李鹏
     * @date 2015-12-22
     */
    public function isExists()
    {
        $value  = array('no');
        $phone  = $this->controller->get_gp($value, 'G');
        $where  = array('phone' => trim($phone['no']));
        $result = InitPHP::getRemoteService('account', 'get', array($where));
        if ($result['code'] && $result['code'] == 1) {
            //帐号不存在，可注册
            InitPHP::Encode(1, '帐号不存在，可注册', '');
        } else {
            //帐号已存，不可注册
            InitPHP::Encode(2, '已注册，请登录', '');
        }
    }

    /**
     * 用户列表
     * @using url:http://api.jw.com/account/index/accountList/userid/1
     * @method  [string]    get             [请求方式]
     * @param   [int]       $userid         [用户id]                                                                        [必填]
     * @param   [int]       $start          [开始值，如果需要分页则需要此参数，查询要跳过的记录，如要从第十条开始，则此值为１０]         [选填]
     * @param   [int]       $num            [查询的条数,如果需要分页则需要此参数,要查询几条数据，默认20条]                           [选填]
     * @param   [string]    $sortKey        [排序字段，如果需要分页则需要此参数，以指定的字段排序，默认id]                           [选填]
     * @param   [string]    $sort           [排序方式，如果需要分页则需要此参数，默认：DESC正序排序．]                              [选填]
     * @return  [array]     $accountLists   [用户信息列表]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function accountList()
    {
        $userid      = $this->getUtil('session')->get('_userid');
        $value       = array('skep', 'num', 'sort', 'key', 'field');
        $data        = $this->controller->get_gp($value, 'G');
        $where       = array('parentid' => isset($userid) && $userid != '' ? $userid : ''); //条件
        $offset      = isset($data['skep']) && $data['skep'] != '' ? intval($data['skep']) : intval(0); //查询起始位置,默认0
        $num         = isset($data['num']) && $data['num'] != '' ? intval($data['num']) : intval(20); //查询多少条,默认20
        $sort        = isset($data['sort']) && $data['sort'] != '' ? trim($data['sort']) : 'ASC'; //排序方式asc:正序排序（默认）;desc:倒序排序
        $is_key      = isset($data['key']) && $data['key'] != '' ? trim($data['key']) : 'userid'; //排序关键字，［以什么为排序标准，默认id］
        $field       = isset($data['field']) && $data['field'] != '' ? explode(',', $data['field']) : array('*');
        $accountList = InitPHP::getRemoteService('account', 'lists', array($where, $num, $offset, $is_key, $sort, $field));
        if ($accountList['code'] == 0) {
            InitPHP::Encode(0, 'Success', jsonEncode($accountList[data][0]));
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 会员信息
     * @using url:http://api.jw.com/account/index/memberInfo/userid/1
     * @method [string] get [请求方式]
     * @param [init] $userid [用户id]
     * @return [array] $memberInfo [用户信息]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function memberInfo()
    {
        $value      = array('userid');
        $data       = $this->controller->get_gp($value, 'G');
        $where      = array('userid' => trim($data['userid']));
        $memberInfo = InitPHP::getRemoteService('account', 'get', array($where));
        if ($memberInfo['code'] == 0) {
            $code = 0;
            $msg  = "Success";
            $userinfo = $memberInfo['data'];
            unset($userinfo['password'],$userinfo['encrypt']);
            $data = jsonEncode($userinfo);
        } else {
            $code = 1;
            $msg  = 'Error';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    /**
     * 修改密码
     * 用户是手机注册或登录可以修改密码，如果是微信登录则不能修改密码或手机号
     * @using http://api.jw.com/account/index/modifyPassword
     * @method [string] post
     * @param [int] $userid [用户id]
     * @param [string] $oldPasd [原密码]
     * @param [string] $nwePasd [新密码]
     * @param [string] $confirmPasd [新密码]
     * @return [array] $code [0:成功;1:失败]
     *                 $msg  输出信息
     *                 $data 附加数据
     *          返回信息：
     *              0：修改成功
     *              1：修改失败
     *              2：原始密码不正确
     *              3：新旧密码一样
     *              4：两次输入密码不一样
     * @author 李鹏
     * @date 2015-12-24
     * @editDate 2016-03-22
     */
    public function modifyPassword()
    {
        $value        = array('original_pasd', 'new_pasd', 'confirm_pasd');
        $data         = $this->controller->get_gp($value, 'P');
        $phone        = $this->getUtil('session')->get('_phone');
        $userid       = $this->getUtil('session')->get('_userid');
        $loginType    = $this->getUtil('session')->get('_loginType');
        $originalPasd = trim($data['original_pasd']);
        $newPasd      = trim($data['new_pasd']);
        $confirmPasd  = trim($data['confirm_pasd']);
        if ($originalPasd == $newPasd) {
            InitPHP::Encode(3, 'Error', '新密码跟旧密码一样');
        } else if ($newPasd != $confirmPasd) {
            InitPHP::Encode(4, 'Error', '两次输入的新密码不一样');
        } else {
            $originalPasdIsTrue = InitPHP::getRemoteService('account', 'checkPassword', array(array('phone' => $phone, 'userid' => $userid), trim($data['original_pasd'])));
            if ($originalPasdIsTrue['code'] == 0) {
                $encrypt     = create_randomstr();
                $password    = password(trim($data['new_pasd']), $encrypt);
                $updateWhere = array('phone' => $phone, 'userid' => $userid);
                $updateData  = array('password' => $password, 'encrypt' => $encrypt);
                $modifPasd   = InitPHP::getRemoteService('account', 'update', array($updateData, $updateWhere));
                if ($modifPasd['code'] == 0) {
                    $this->getRedis('default')->redis()->hmset('login:' . $loginType . ':' . $phone, $updateData);
                    $this->getRedis('default')->redis()->hmset('user:' . $phone, $updateData);
                    $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, $updateData);
                    InitPHP::Encode(0, 'Success', '修改成功');
                } else {
                    InitPHP::Encode(1, 'Error', '修改失败');
                }
            } else {
                InitPHP::Encode(2, 'Error', '原始密码不正确');
            }
        }
    }

    /**
     * 找回密码
     * @using http://api.jw.com/account/index/findPassword/
     * @method [string] post
     * @param [int]　$userid
     * @param [string]　$phone
     * @param [string]
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function findPassword()
    {
        $value = array('userid', 'phone');
        $data  = $this->controller->get_gp($value, 'P');
        //检测手机号码是否格式正确
        if (!checkmobile($data['phone'])) {
            InintPHP::Encode(1, 'mobilePhoneFormatIsNotCorrect', '');
        } else {
            var_dump($data);
        }
    }

    /**
     * 绑定手机
     * @using http://api.jw.com/account/index/bindMobile/
     * @method [string] post
     * @param [int] $userid
     * @param [string] $phone
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function bindMobile()
    {
        $value = array('userid', 'phone');
        $data  = $this->controller->get_gp($value, 'P');
        //检测手机号码是否格式正确
        if (!checkmobile($data['phone'])) {
            InintPHP::Encode(1, 'mobilePhoneFormatIsNotCorrect', '');
        } else {
            var_dump($data);
        }
    }

    /**
     * 更换手机
     * @using http://api.jw.com/account/index/rebindMobile/
     * @method [string] post
     * @param [int]  $userid
     * @param [string] $phone
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function rebindMobile()
    {
        $value = array('userid', 'phone');
        $data  = $this->controller->get_gp($value, 'P');
        //检测手机号码是否格式正确
        if (!checkmobile($data['phone'])) {
            InintPHP::Encode(1, 'mobilePhoneFormatIsNotCorrect', '');
        } else {
            var_dump($data);
        }
    }

    /**
     * 修改基本资料
     * @using http://api.jw.com/account/index/modifyMemberInfo/
     * @method [string] post
     * @param [int]
     * @param [string]
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function modifyMemberInfo()
    {
        $value = array('nickname', 'sex', 'phone', 'email', 'qq', 'wechat');
        $data  = $this->controller->get_gp($value, 'P');
        var_dump($data);
    }

    /**
     * 修改头像
     * @using http://api.jw.com/account/index/modifyAvatar/
     * @method [string] post
     * @param [int]
     * @param [string]
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function modifyAvatar()
    {
        $value  = array('avarat');
        $data   = $this->controller->get_gp($value, 'P');
        $updata = array('avarat' => trim($data['avarat']));
        $userid = $this->getUtil('session')->get('_userid');
        $phone  = $this->getUtil('session')->get('_phone');
        $wechat = $this->getUtil('session')->get('wechat_openid');
        if ($phone && $phone != '') {
            $redusUserKey = 'user:' . $phone;
        } else if ($wechat && $wechat != '') {
            $redusUserKey = 'user:' . $wechat;
        }
        $where                = array('userid' => $userid);
        $redisValue['avarat'] = trim($data['avarat']);
        $updateId             = InitPHP::getRemoteService('account', 'update', array($updata, $where));

        if ($updateId['code'] == 0) {
            //更新redias中的头像
            $this->getRedis('default')->redis()->hmset($redusUserKey, $updata);
            $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, $updata);
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }

    }

    /**
     * 微信登入
     * @using http://api.jw.com/account/index/modifyMemberModel/
     * @date 2015-12-24
     */
    public function wechatLogin()
    {
        if (isset($_GET['HTTP_TOKEN']) && $_GET['HTTP_TOKEN'] != '' && $_GET['HTTP_TOKEN'] != 'sso_session:' && $_GET['HTTP_TOKEN'] != 'undefined') {
            initPHP::getUtils('cookie')->set('sso_session', $_GET['HTTP_TOKEN'], time() + 6400, '/', 'zj3w.net');
            $_COOKIE['sso_session'] = $_GET['HTTP_TOKEN'];
            $_SERVER['HTTP_TOKEN']  = $_GET['HTTP_TOKEN'];
        }

        $back = isset($_GET['goback']) ? $_GET['goback'] : '';

        if (isset($_GET['code'])) {

            $code = $_GET['code'];

            $openId = \LaneWeChat\Core\WeChatOAuth::getAccessTokenAndOpenId($code);

            $userInfo = \LaneWeChat\Core\UserManage::getUserInfo($openId['openid']);
            $back     = base64_decode($back);

            if ($userInfo['openid']) {

                $_YunUser = (string) $this->getUtil('session')->get('_YunUser');
                // var_dump($this->getUtil('session')->getAll());exit;
                $_YunUser = trim($_YunUser) != '' ? trim($_YunUser) : 1;

                $_YunUserInfo = $this->getRedis('default')->redis()->hmget('user:' . $_YunUser, array('levels', 'layer'));
                $this->getRedis('default')->redis()->delete('sso_session:');
                $this->getRedis('default')->redis()->delete('user:');
                $this->getRedis('default')->redis()->delete('null');

                $_YunUserLayer = (int) $_YunUserInfo['layer'] + 1;

                $where['wechat_openid'] = $userInfo['openid'];

                $res = InitPHP::getRemoteService('account', 'get', array($where));

                $data = $res['data'];

                if ($res['code'] == '1') {
                    //首次登入则自动注册
                    $data = array(
                        'userid'        => $this->create_randid(),
                        'phone'         => '',
                        'nickname'      => safe_replace($userInfo['nickname']),
                        'password'      => '',
                        'encrypt'       => '',
                        'wechat_openid' => $userInfo['openid'],
                        'parentid'      => $_YunUser,
                        'levels'        => 0,
                        'layer'         => $_YunUserLayer,
                        'create_time'   => time());
                    InitPHP::getRemoteService('account', 'create', array($data));

                    //
                    $memberInfo['userid']      = $data['userid'];
                    $memberInfo['nickname']    = $data['nickname'];
                    $memberInfo['sex']         = max(intval($data['sex']), 1);
                    $memberInfo['email']       = '';
                    $memberInfo['parentid']    = $data['parentid'];
                    $memberInfo['levels']      = $data['levels'];
                    $memberInfo['layer']       = $data['layer'];
                    $memberInfo['qq']          = '';
                    $memberInfo['wechat']      = '';
                    $memberInfo['is_has_shop'] = 0;
                    $memberInfo['phone']       = '';
                    $memberInfo['password']    = $data['password'];
                    $memberInfo['encrypt']     = $data['encrypt'];

                    $userkey = 'user:' . trim($userInfo['openid']);

                    $this->getRedis('default')->redis()->hmset($userkey, $memberInfo);
                    $this->getRedis('default')->redis()->hmset('userinfo:' . $data['userid'], $memberInfo);
                    //将数据存入session
                }
                $userkey = 'user:' . trim($userInfo['openid']);

                $this->getRedis('default')->redis()->hmset($userkey, $data);
                $this->getRedis('default')->redis()->hmset('userinfo:' . $data['userid'], $data);

                $this->getUtil('session')->set('wechat_openid', $userInfo['openid']);
                //set session
                $this->getUtil('session')->set('_userid', $data['userid']);
                $this->getUtil('session')->set('_nickname', $data['nickname']);
                $this->getUtil('session')->set('wechat_openid', $data['wechat_openid']);
                $this->getUtil('session')->set('_YunUser', $data['parentid']); //推荐人
                $this->getUtil('session')->set('_loginType', 'wechat');
                $this->getUtil('session')->set('_HTTP_TOKEN', $_GET['HTTP_TOKEN']);
                $this->getUtil('session')->set('_phone', '');
                $back = urldecode($back);
                $back = str_replace('login', 'member', $back);
                //$back = str_replace('.php', '.html', $back);
                
                header('Location:' . $back . '?HTTP_TOKEN=' . $_GET['HTTP_TOKEN'].'&userid='.$data['userid'], true, 301);
            } else {

                header('Location:http://www.zj3w.net/login.php?HTTP_TOKEN=' . $_GET['HTTP_TOKEN'] . '&goback=' . $back, true, 301);
            }

        } else {
            $back = base64_encode($back);
            \LaneWeChat\Core\WeChatOAuth::getCode('?m=account&c=index&a=wechatLogin&HTTP_TOKEN=' . $_GET['HTTP_TOKEN'] . '&goback=' . $back, 1, 'snsapi_base');

        }
    }

    /**
     * 实名认证
     * @using http://api.jw.com/account/index/authentication/
     * @method [string] post
     * @param [int]
     * @param [string]
     * @param [string]
     * @param [string]
     * @return [array]
     * @author 李鹏
     * @date 2015-12-24
     */
    public function authentication()
    {

    }

    /**
     * 修改用户信息
     * @using http://api.jw.com/account/index/modifInfo
     * @param [integer] $userid 用户id
     * @param [string] $modifType 修改的信息类型
     * @param [string] $modifData 修改的信息
     * @return [boolean] $status
     * @author 李鹏
     * @date 2016-01-16
     */
    public function modifyInfo()
    {
        $value  = array('modifType', 'modifData');
        $data   = $this->controller->get_gp($value, 'P');
        $userid = $this->getUtil('session')->get('_userid');
        if (!$this->controller->is_empty($userid)) {
            $where = array('userid' => $userid);
            switch ($data['modifType']) {
                case 'avarat':
                    $editData = array('avarat' => trim($data['modifData']));
                    break;
                case 'sex':
                    $editData = array('sex' => intval($data['modifData']));
                    break;
                case 'qq':
                    $editData = array('qq' => trim($data['modifData']));
                    break;
                case 'wechat':
                    $editData = array('wechat' => trim($data['modifData']));
                    break;
                case 'email':
                    $editData = array('email' => trim($data['modifData']));
                    break;
                default:
                    $editData = array('nickname' => trim($data['modifData']));
                    break;
            }
            $update = InitPHP::getRemoteService('account', 'update', array($editData, $where));
            if ($update['code'] == 0) {
                //将redis中的信息也修改
                $phone         = $this->getUtil('session')->get('_phone');
                $wechat_openid = $this->getUtil('session')->get('wechat_openid');
                $redisKey      = $wechat_openid ? $wechat_openid : $phone;
                $this->getRedis('default')->redis()->hmset('user:' . $redisKey, $editData);
                $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, $editData);
                InitPHP::Encode(0, 'Success', '');
            } else {
                InitPHP::Encode(1, 'Error', '');
            }
        } else {
//session中没有用户id
            InitPHP::Encode(1, 'Error', '');
        }

    }

    /**
     * 更换绑定手机号
     * @using http://api.jw.com/account/index/replacePhone
     * @param [integer] $userid [会员手机号]
     * @param [string] $vailcode [验证码]
     * @param [string] $replacephone [要更换的手机号]
     * @return [boolean] $status [更换成功或失败]
     * @author 李鹏
     * @date 2016-01-06
     */
    public function replacePhone()
    {
        $value            = array('replacephone');
        $data             = $this->controller->get_gp($value, 'P');
        $getSessionUserId = $this->getUtil('session')->get('_userid');
        $getSessionPhone  = $this->getUtil('session')->get('_phone');
        $where            = array('userid' => $getSessionUserId);
        $binData          = array('phone' => trim($data['replacephone']));
        $replace          = $this->getRemoteService('account', 'update', array($binData, $where));
        if ($replace) {
            $code = 0;
            $msg  = 'Success';
            $data = '';
        } else {
            $code = 1;
            $msg  = 'Error';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    /**
     *
     *默认路由页面
     *登入页面
     */
    public function logout()
    {
        //清除session
        $this->getUtil('session')->delAll();
        // $this->getUtil('cookie')->delAll();
        InitPHP::Encode(0, '', '');
    }

    /**
     * 获取帐户余额
     * @return [type] [用户的余额]
     * @author 李鹏
     * @date 2016-01-15
     */
    public function getWallet()
    {
        $userId = trim($this->getUtil('session')->get('_userid'));
        if ($userId != '') {
            $where  = array('userid' => $userId);
            // 钱包能获取的金额只有 可使用余额 推荐奖金
            $wallet = InitPHP::getRemoteService('account', 'getWallet', array($where));
            // 冻结自营货款  含运费
            $mysales = InitPHP::getRemoteService('orderGoods', 'myAmount', array($userId));
            // 本店销售金额 含运费
            
            // 个人业绩 团队 冻结业绩
            $self  = InitPHP::getRemoteService('Bonus', 'FrozenBonus', array($userId));
            
            
            

            if ($wallet['code'] == 0 && $self['code'] ==0 && $mysales['code'] == 0) {
             $return =    array_merge($wallet['data'],$self['data'],$mysales['data']);
                InitPHP::Encode(0, 'Success', $return);
            } else {
                InitPHP::Encode(1, 'Error', '');
            }
        }
    }

    /**
     * [查询用户帐单记录]
     * @return [type] [description]
     */
    public function consumeRecordsLists()
    {
        $userid = $this->getUtil('session')->get('_userid');
        $value  = array('type','offset','pages');
        $data   = $this->controller->get_gp($value, 'G');
        $type   = $data['type']; // 2 冻结自营货款 3 本店销售额 4 开店奖励  5 账户余额
        
       
        $offset = $data['offset'];
        $page   = max((int) $data['pages'], 1);
        $limit  = ($page - 1) * $offset;
        $order  = 'id';
        $sort   = 'desc';
        switch ($type) {
            case 2:
                $where =  array('shop_id' => $userid, 'from_id'=>$userid,'goods_status'=>'!=1');
                $res = InitPHP::getRemoteService('orderGoods', 'lists', array($where, $offset, $limit, 'og_id', 'desc', '*'));
                if($res[1] == 0){
                    $consum['code'] == 1;
                    $consum['data'][1] = $res[1];
                    
                }else{
                        foreach ($res[0] as $key => $value) {
                       
                        $result['data'][0][$key]['action'] = 1;
                        $result['data'][0][$key]['amount'] = $value['order_total'] + $value['shipping_fee'];
                        $result['data'][0][$key]['content'] = $value['goods_name'];
                        $result['data'][0][$key]['create_time'] = $value['shipping_time'] ? '发货时间：'.date('Y-m-d H:i:s',$value['shipping_time']) : '还未发货' ;
                        $result['data'][0][$key]['orderid'] = '订单号：'.$value['order_id'] ;
                        $result['data'][0][$key]['id'] = $value['og_id'];
                        $result['data'][0][$key]['make'] = '';
                        $result['data'][0][$key]['shop_id'] = $value['shop_id'];
                        $result['data'][0][$key]['status'] = 1;
                        $result['data'][0][$key]['title'] = $value['goods_name'];
                        $result['data'][0][$key]['type'] =1;
                        $result['data'][0][$key]['userid'] = $userid;
                    }
                        $consum['code'] == 0;
                        $consum['data'][1] = $res[1];
                        $consum['data'][0] = array_values($result['data'][0]);
                }
                

                break;
            case 3:
                $where =  array('shop_id' => $userid, 'is_over'=>99,'goods_status'=>'!=1');
                $res = InitPHP::getRemoteService('orderGoods', 'lists', array($where, $offset, $limit, 'og_id', 'desc', '*'));
                if($res[1] == 0){
                    $consum['code'] == 1;
                    $consum['data'][1] = $res[1];
                }else{
                    foreach ($res[0] as $key => $value) {
                       
                        $result['data'][0][$key]['action'] = 1;
                        $result['data'][0][$key]['amount'] = $value['order_total'] + $value['shipping_fee'];
                        $result['data'][0][$key]['content'] = $value['goods_name'];
                        $result['data'][0][$key]['create_time'] = '发货时间：'.date('Y-m-d H:i:s',$value['shipping_time'])  ;
                        $result['data'][0][$key]['orderid'] = '订单号：'.$value['order_id'];  ;
                        $result['data'][0][$key]['id'] = $value['og_id'];
                        $result['data'][0][$key]['make'] = '';
                        $result['data'][0][$key]['shop_id'] = $value['shop_id'];
                        $result['data'][0][$key]['status'] = 1;
                        $result['data'][0][$key]['title'] = $value['goods_name'];
                        $result['data'][0][$key]['type'] =1;
                        $result['data'][0][$key]['userid'] = $userid;
                    }
                        $consum['data'][1] = $res[1];
                        $consum['data'][0] = array_values($result['data'][0]);
                        $consum['code'] == 0;
                }
                break;
            default:
               $where  = array(
                    'userid' => $userid,
                    'type'   => $data['type'],
                );
                $consum = InitPHP::getRemoteService('account', 'consumLists', array($where, $offset, $limit, $order, $sort, '*'));

                for ($i = 0; $i < count($consum['data'][0]); $i++) {
                    $consum['data'][0][$i]['create_time'] = date('Y-m-d H:i:s', $consum['data'][0][$i]['create_time']);
                }
                break;
        }
         

        if ($consum['code'] == 0) {
            InitPHP::Encode(0, 'Success', $consum['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    //我的业绩
    /**
     * 从我的店铺获取
     *
     * @param $limit
     * @param $offset
     */
    public function myBonus()
    {
        $shopid = $this->getUtil('session')->get('_userid');
        $value  = array('pages', 'offset');
        $data   = $this->controller->get_gp($value, 'G');
        $lists  = InitPHP::getRemoteService('Bonus', 'myBonus', array($shopid, $data['pages'], $data['offset']));
        if ($lists['code'] == 0) {
            InitPHP::Encode(0, 'Success', $lists['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }
    /**
     * [teamBonus 我的团队业绩]
     * @param $limit
     * @param $offset
     * @return [type] [description]
     */
    public function teamBonus()
    {
        $userid = $this->getUtil('session')->get('_userid');
        $value  = array('pages', 'offset');
        $data   = $this->controller->get_gp($value, 'G');
        $lists  = InitPHP::getRemoteService('Bonus', 'myTeamBonus', array($userid, $data['pages'], $data['offset']));
        // echo $start = strtotime(date('Y/m/d 00:00:01', time()));
        // echo '<br>';
        // echo date('Y/m/d H:i:s', $start);
        if ($lists['code'] == 0) {
            InitPHP::Encode(0, 'Success', $lists['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }
    /**
     * 开通店铺
     * @return [blooean] $isOpenShop [开通店铺是否成功]
     */
    public function openShop()
    {
        $value      = array('total', 'payType');
        $data       = $this->controller->get_gp($value, 'P');
        $userid     = $this->getUtil('session')->get('_userid');
        $username   = $this->getUtil('session')->get('_nickname');
        $isOpenShop = InitPHP::getRemoteService('account', 'openShop', array($userid, $username, $data['total'], $data['payType']));

        if ($isOpenShop) {

            //更新redis中的用户等级数据
            $phone         = $this->getUtil('session')->get('_phone');
            $wechat_openid = $this->getUtil('session')->get('wechat_openid');
            $redisKey      = $wechat_openid ? $wechat_openid : $phone;

            $redisValue['levels'] = 1;
            $this->getRedis('default')->redis()->hmset('user:' . $redisKey, $redisValue);
            $this->getRedis('default')->redis()->hmset('userinfo:' . $userid, $redisValue);

            InitPHP::Encode(0, 'Success', $isOpenShop['data']);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 获取用户消费额度
     * @method [string] GET
     * @using [string] http://api.zj3w.net/account/index/getConsumptionQuota
     * @return [string] [返回用户总消费额度]
     */
    public function getConsumptionQuota()
    {
        $userid           = $this->getUtil('session')->get('_userid');
        $ConsumptionQuota = InitPHP::getRemoteService('account', 'getAllConsumptionQuota', array($userid));
        if ($ConsumptionQuota) {
            InitPHP::Encode(0, 'Success', $ConsumptionQuota);
        } else {
            InitPHP::Encode(1, 'Error', '');
        };
    }

    /**
     * 判断是否存在指定的手机号
     * @return boolean [description]
     */
    public function isExistsPhone()
    {
        $value         = array('phone');
        $data          = $this->controller->get_gp($value, 'G');
        $where         = array('phone' => $data['phone']);
        $isExistsPhone = InitPHP::getRemoteService('account', 'get', array($where));
        if ($isExistsPhone['code'] == 0) {
            InitPHP::Encode(0, 'Success', 'true');
        } else {
            InitPHP::Encode(1, 'Error', 'false');
        }
    }

    /**
     * 获取用户等级
     * @method [string] GET
     * @using [string] http://api.zj3w.net/account/index/getLevels
     */
    public function getLevels()
    {
        $userid = $this->getUtil('session')->get('_userid');
        $levels = InitPHP::getRemoteService('account', 'getLevels', array($userid));
        if ($levels) {
            InitPHP::Encode(0, 'Success', $levels);
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }

    /**
     * 私有方法生成20位的用户id
     * 规则：通过microtime()函数生成[微秒数 时间戳]0.67298300 1452406477这种格式的字符串，将时间戳随机打乱，从微秒数小数点后面取6位字符如果第一位是0则替换成1~9的随机数，将打乱的时间戳与取到的6位秒微数拼接，如果不够20位则加缺少的位数的0~9的随机数，
     * 返回一个20位的数字字符串
     * @author 李鹏
     * @data 2016-01-10
     */
    private function create_randid()
    {
        $skep = '';
        $rand = microtime();
        //0.67298300 1452406477
        $strToArr = explode(' ', $rand);
        // var_dump($strToArr);

        $priv = substr($strToArr[0], 2, 6);
        $end  = '';
        for ($i = 0; $i < strlen($strToArr[1]); $i++) {
            $end .= substr($strToArr[1], mt_rand(0, strlen($strToArr[1])), 1);
        }
        $temp = $end . substr($strToArr[0], 2, 6);
        if (substr($temp, 0, 1) == 0) {
            $temp = mt_rand(1, 9) . substr($temp, 1, intval(strlen($temp) - 1));
        }
        if (strlen($temp) < 20) {
            for ($j = 0; $j < 20 - strlen($temp); $j++) {
                $skep .= mt_rand(0, 9);
            }
            $temp = $temp . $skep;
        }
        return $temp;
    }
}
