<?php

/**
 * 好友关系系统服务层
 * @Author: 李鹏
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-01-01
 */
class memberFriendShipService extends Service{


  public function __construct() {
    parent::__construct();

  }

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
  public function create($data) {
      $create_id = InitPHP::getDao('memberFriendShip')->create($data);
      if ($create_id) {
        return InitPHP::Encode(0, 'Success', $create_id, 1);
      }
      else {
        return InitPHP::Encode(1, 'Error', $create_id, 1);
      }
  }



  /**
   * 获取一条数据
   * @param [array] $where [获取数据的条件,$where = array('userid' => $userid)]
   * @return [array] $friendInfomartion [返回用户相关联的朋友的简单信息]
   * @author 李鹏
   * @date 2016-01-01
   */
    public function get($where) {
        $data = InitPHP::getDao('memberFriendShip')->get($where);
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        }
        else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

    /**
     * 根据条件获取一组数据
     * @param [array] $where [获取数据的条件,如：$where = array('userid' => 1126578)]
     * @param [integer] $offset [查询数据的起始位置，默认0]
     * @param [integer] $num [查询的数据量]
     * @param [string] $sort [排序方式，有DESC,ASC,默认DESC]
     * @param [vtype] $key [排序关键字]
     * @param [array] $fields [要查询的字段,默认所有(*)]
     * @return [array] $lists [返回一组查询成功的数据]
     * @author 李鹏
     * @date 2016-01-02
     */
    public function lists() {
        if(func_num_args() == 1){
          $where = func_get_args()[0]['where'];
          $offset = func_get_args()[0]['offset'];
          $num = func_get_args()[0]['num'];
          $sort = func_get_args()[0]['sort'];
          $key = func_get_args()[0]['key'];
          $fields = func_get_args()[0]['fileds'];
        }else{
          $where = isset($where)?$where:array('');
          $offset = isset($offset)?:0;
          $num = isset($num)?:10;
          $sort = isset($sort)?$sort:'DESC';
          $key = isset($key)?:'id';
          $fields = isset($fileds)?:array('*');
        }
        $friendLists = InitPHP::getDao('memberFriendShip')->lists($where, $offset, $num, $sort, $key, $fields);
        if ($friendLists) {
          return InitPHP::Encode(0, 'Success', $friendLists, 1);
        }
        else {
            return InitPHP::Encode(1, 'Error', $friendLists, 1);
        }
    }

    /**
     * 根据条件更新一条数据
     * @param [array] $where [更新的条件以数组形式，如：$where = array('userid' => 34534);]
     * @param [array] $data [要更新的条件以数组形式，如：$data = array('name' => 'bluelife', 'email' => 'thebulelife@163.com');]
     * @return $updateRowsNum [返回更新的行数]
     * @author 李鹏
     * @date 2016-01-01
     */
    public function update($param) {
      $where = array('friendid' => $param['where']);
      $data = array('is_allow' => $param['data']);
      $updateRowsNum = InitPHP::getDao('memberFriendShip')->update($where,$data);
      if ($updateRowsNum) {
        return InitPHP::Encode(0, 'Success', $updateRowsNum, 1);
      }else {
        return InitPHP::Encode(1, 'Error', $updateRowsNum, 1);
      }
    }





    /**
     * 删除
     * @param  [array] $ids [一个或者多个值 1,2,3以数据形式,如：$field = array('userid' => 34534)]
     * @return [boolean] $status [删除状态,true|false]
     * @author 李鹏
     * @date 2015-01-02
     */
    public function delete($ids) {
        $state = InitPHP::getDao('memberFriendShip')->delete($field);
        if ($state) {
            return InitPHP::Encode(0, 'Success', $state, 1);
        }
        else {
            return InitPHP::Encode(1, 'Error', $state, 1);
        }
    }
}
