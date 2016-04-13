<?php
/**
 * 好友关系数据层
 * @author 李鹏
 * @date 2016-01-01
 * @Last Modified time: 2016-01-01
 */
class memberFriendShipDao extends Dao {
  private $table_name = 'friends';
  private $fields = 'userid,friendid,friendname,friendsex,friendaccount,friendavarat,friendlevels,is_allow,is_exists,create_time,update_time';


  /**
   * 添加一条朋友信息
   * @param [array] $data [朋友的信息，包括：朋友id,名称，性别，帐号，头像，等级，是否通过，是否存在，添加时间，修改时间;如：
   * $data = array(
   * 	'userid' => $userid,
   * 	'frinedid' => $friendid,
   * 	'friendname' => $friendname,
   * 	'friendsex' => $friendsex,
   * 	'friendaccount' => $friendaccount,
   * 	'friendavarat' => $friendavarat,
   * 	'friendlevels' => $friendlevels,
   * 	'is_allow' => 0,默认没有通过
   * 	'is_exists' => 1,默认存在
   * 	'create_time' => time(),
   * 	'update_time' => time(),
   * 	'' => ,
   * )]
   * @return [integer] $autoIncrementId [添加成功后的自增id]
   * @author 李鹏
   * @date 2016-01-01
   */
  public function create($data){
    $data = array(
      'userid' => $data['userid'],
      'friendid' => $data['friendid'],
      'friendname' => $data['friendname'],
      'friendsex' => intval($data['friendsex']),
      'friendaccount' => $data['friendaccount'],
      'friendavarat' => $data['friendavarat'],
      'friendlevels' => intval($data['friendlevels']),
      'is_allow' => 0,
      'is_exists' => 1,
      'create_time' => time(),
      'update_time' => time()
    );
    $data = $this->dao->db->build_key($data,$this->fields);
    return $this->dao->db->insert($data,$this->table_name);

  }


  /**
   * 获取一条数据
   * @param [array] $where [获取数据的条件,$where = array('userid' => $userid)]
   * @return [array] $friendInfomartion [返回用户相关联的朋友的简单信息]
   * @author 李鹏
   * @date 2016-01-01
   */
  public function get($where){
    $where = $this->dao->db->build_key($where,$this->fields);
    return $this->dao->db->get_one_by_field($where,$this->table_name);
  }




  /**
   * 根据条件更新一条数据
   * @param [array] $where [更新的条件以数组形式，如：$where = array('userid' => 34534);]
   * @param [array] $data [要更新的条件以数组形式，如：$data = array('name' => 'bluelife', 'email' => 'thebulelife@163.com');]
   * @return $update_rows_num [返回更新的行数]
   * @author 李鹏
   * @date 2016-01-01
   */
  public function update($where,$data){
    $where = $this->dao->db->build_key($where,$this->fields);
    return $this->dao->db->update_by_field($data,$where,$this->table_name);
  }


  /**
   * 根据条件获取一组数据
   * @param [array] $where [获取数据的条件]
   * @param [integer] $offset [查询数据的起始位置，默认0]
   * @param [integer] $num [查询的数据量]
   * @param [string] $sort [排序方式，有DESC,ASC,默认DESC]
   * @param [vtype] $key [排序关键字]
   * @param [array] $fields [要查询的字段,默认所有(*)]
   * @return [array] $lists [返回一组查询成功的数据]
   * @author 李鹏
   * @date 2016-01-02
   */
  public function lists($where = array(),$offset = 0,$num = 5,$sort = 'DESC',$key = 'id',$fields = array('*')){
    $fields = arrToStr($fields);
    $where = create_where($where);
    $limit = $this->dao->db->build_limit($offset,$num);
    $sql = "SELECT ".$fields." FROM ".$this->table_name.$where." ORDER BY ".$key . " " . $sort . " " . $limit;
    return $this->dao->db->get_all_sql($sql);
  }


  /**
   * 根据条件删除一个或多个数据
   * @param [array] $field [要删除的条件，一个或多个，如：$field = array('userid' => 354235)]
   * @return [boolean] $status [删除失败或成功返回的状态，true|false]
   * @author 李鹏
   * @date 2015-01-02
   */
  public function detele($field){
    $this->dao->db->delete_by_field($field, $this->table_name)
  }


}
