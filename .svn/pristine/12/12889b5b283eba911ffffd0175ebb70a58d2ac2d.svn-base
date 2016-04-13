<?php
/**
 *  会员关系api
 *  @author 李鹏
 *  @date 2015-12-30
 */
class indexController extends Controller {
  public $initphp_list = array(
    //添加好友
    'jionFriend',
    //待验证的好友列表
    'checkFriendList',
    //好友列表
    'friendsList',
    //验证好友
    'checkFriend');

  public function __construct(){
    parent::__construct();
  }



  /**
   * 加友
   * @using http://api.jw.com/memberFriend/index/jionFriend
   * @method [string] get [请求方式]
   * @param [int] $userid [会员id]
   * @param [int] $friendId [好友的id]
   * @return [boolean] $status 状态，０：表示成功，１：表示失败
   * @author 李鹏
   * @date 2015-12-30
   */
  public function jionFriend(){
    $value = array('userid','friendid','friendname','friendsex','friendaccount','friendavarat','friendlevels');
    $jionData = $this->controller->get_gp($value,'P');
    $jionFriend = InitPHP::getRemoteService('memberFriendShip','create',array($jionData));
    if($jionFriend['code'] == 0){
      $code = 0;
      $msg = '添加成功，等待通过';
      $data = $jionFriend['data'];
    }else{
      $code = 1;
      $msg = '添加失败，请稍后再试';
      $data = $jionFriend['data'];
    }
    InitPHP::Encode($code,$msg,$data);
  }





  /**
   * 验证好友
   * @using http://api.jw.com/memberFriend/index/checkFriend
   * @method [string] get [请求方式]
   * @param [integer] $userid [会员id]
   * @param [integer] $friendid [请求验证通过的好友id]
   * @return [integer] $waitFriendsList [等待验证的好友的列表]
   * @author 李鹏
   * @date 2015-12-30
   */
  public function checkFriend(){
    $value = array('userid','is_allow');
    $data = $this->controller->get_gp($value,'G');
    $param = array(
      'where' => $data['userid'],
      'data' => $data['is_allow']
    );
    $checkStatusreturn  = InitPHP::getRemoteService('memberFriendShip','update',array($param));
    if($checkStatus['code'] == 0){
      $code = 0;
      $msg = '已通过请求，成为朋友';
      $data = '';
    }else{
      $code = 1;
      $msg = '未通过请求，没有为朋友';
      $data = '';
    }
    InitPHP::Encode($code,$msg,$data);
  }





  /**
   * 待验证的朋友列表
   * @param [integer] $userid [会员id]
   * @param [integer] $is_allow [待验证标识]
   * @return [array] $checkFriendList [未通过验证的朋友信息列表]
   */
  public function checkFriendList(){
    $value = array('userid','is_allow','offset','num','sort','key','fileds');
    $data = $this->controller->get_gp($value,'G');
    $where = array(
      'where' => array('userid' => isset($data['userid'])?$data['userid']:'', 'is_allow' => 0),
      'offset' => isset($data['offset'])?$data['offset']:0,
      'num' => isset($data['num'])?$data['num']:5,
      'sort' => isset($data['sort'])?$data['sort']:'DESC',
      'key' => isset($data['key'])?:'id',
      'fileds' => isset($data['fields'])?:array('*')
    );
    $checkFriendsList = InitPHP::getRemoteService('memberFriendShip','lists',array($where));
    if($checkFriendsList['code'] == 0){
      $code = 0;
      $msg = 'Success';
      $data = $checkFriendsList['data'];
    }else{
      $code = 1;
      $msg = 'Error';
      $data = '';
    }
    InitPHP::Encode($code,$msg,$data);
  }


  /**
   * 我的好友
   * @using http://api.jw.com/memberFriend/index/friendsList
   * @method [string] get [请求方式]
   * @param [int] $userid [会员id]
   * @return [array] $friends [会员的朋友列表]
   * @author 李鹏
   * @date 2015-12-30
   */
  public function friendsList(){
    $value = array('userid','is_allow','offset','num','sort','key','fileds');
    $data = $this->controller->get_gp($value,'G');
    $where = array(
      'where' => array('userid' => isset($data['userid'])?$data['userid']:'', 'is_allow' => 1),
      'offset' => isset($data['offset'])?$data['offset']:0,
      'num' => isset($data['num'])?$data['num']:5,
      'sort' => isset($data['sort'])?$data['sort']:'DESC',
      'key' => isset($data['key'])?:'id',
      'fileds' => isset($data['fields'])?:array('*')
    );
    $friendsList = InitPHP::getRemoteService('memberFriendShip','lists',array($where));
    if($friendsList['code'] == 0){
      $code = 0;
      $msg = 'Success';
      $data = $friendsList['data'];
    }else{
      $code = 1;
      $msg = 'Error';
      $data = '';
    }
    InitPHP::Encode($code,$msg,$data);
  }



  /**
   * 家族成员列表
   * @using http://api.jw.com/memberFriend/index/groupMemberList
   * @method [string] get [请求方式]
   * @param int $userid [会员id]
   * @return array $groupMemberList [家族成员列表]
   * @author 李鹏
   * @date 2015-12-30
   */
  public function groupMemberList(){
    $value = array('userid');
    $data = $this->controller->get_gp($value);
    $param = array(
      'where' => $data['userid'],
      'offset' => isset($data['offset'])?$data['offset']:0,
      'num' => isset($data['num'])?$data['num']:5,
      'sort' => isset($data['sort'])?$data['sort']:'DESC',
      'key' => isset($data['key'])?$data['key']:'id',
      'fields' => isset($data['fields'])?$data['fields']:array('*'),
    );

  }

  /**
   * 家族成员进入
   * @using http://api.jw.com/memberFriend/index/jionGroup
   * @method [string] get [请求方式]
   * @param [int] $userid [会员id(刚注册的会员id)]
   * @param [int] $parentid [父级会员id(通过二维码分享的会员的id,某个会员分享了自己的二维码，某个用户通过此二维码注册成功对用户来说此二维码中的id就是父级id)]
   * @return [boolean] $status [状态，0：成功；1：失败]
   * @author 李鹏
   * @date 2015-12-30
   */
  public function jionGroup(){

  }

  /**
   * 搜索家族成员
   * @using http://api.jw.com/memberFriend/index/searchMemberList
   * @method [string] get [请求方式]
   * @param int $userid 会员id(刚注册的会员id)
   * @param allType $where 搜索条件
   * @return array $memberGroupInfo 家族成员信息
   * @author 李鹏
   * @date 2015-12-30
   */
  public function searchMemberList(){

  }



}
