<?php
class usersService extends Service {
  private $usersDao;

  public function __construct(){
    parent::__construct();
    //获取Dao
    $this->usersDao = InitPHP::getDao('user');
  }

  /**
   *  添加数据
   */
  public function create($data){
    //重组数据
    $dataArr = array(
      'phone'               => trim($data['phone']),
      'password'            => md5(md5($data['pasd'])),
      'level'               => 0,
      'create_time'         => time()
    );
    return $status = $this->usersDao->create($dataArr);
  }

  /**
   *  判断用户手机号码是否存在
   */
  public function is_exists($data){
    $where = array('phone'=>$data);
    return $this->usersDao->get_count($where);
  }

  //查找根据条件用户
  public function find($data){
    $where = array('phone'=>$data['phone']);
    $userResult = $this->usersDao->find_one($where);
    if($userResult && $userResult['password'] == md5(md5($data['pasd']))){
      return $userResult;
    }else{
      return '';
    }
  }

}
