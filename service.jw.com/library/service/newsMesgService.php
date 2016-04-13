<?php
/**
 * 消息服务
 * @author 李鹏
 * @date 2016-01-08
 */
class newsMesgService extends Service {
  public function __construct(){
    parent::__construct();
  }

  /**
   * 添加一条数据
   * @param [array] $data [要添加的数据]
   * @return [integer || boolean] $insertId [添加成功后的自增id]
   * @author 李鹏
   * @date 2015-01-08
   */
  public function create($data){
    $insert_id = InitPHP::getDao('newsMesg')->create($data);
    if($insert_id){
      return InitPHP::Encode(0,'Success',$insert_id,1);
    }else{
      return InitPHP::Encode(1,'Error',$insert_id,1);
    }
  }

  /**
   * 根据条件获取一条数据
   * @param [array] $where [查询的条件]
   * @return [array] $result [查询成功返回的数据]
   * @author 李鹏
   * @date 2015-01-08
   */
  public function get($where){
    $result = InitPHP::getDao('newsMesg')->get($where);
    if($result){
      return InitPHP::Encode(0,'Success',$result,1);
    }else{
      return InitPHP::Encode(1,'Error',$result,1);
    }
  }

  /**
   * 根据条件获取一组数据
   * @param [array $where [获取数据的条件]
   * @param [integer] $offset [获取数据的开始位置]
   * @param [integer] $num [获取数据的数量]
   * @param [array] $field [获取指定字段的数据]
   * @param [string] $is_key [指定排序的字段]
   * @param [string] $sort [指定排序的方式]
   * @return [array] $resutlLists [返回根据指定条件查询出来的一组数据]
   * @author 李鹏
   * @date 2015-01-08
   */
  public function lists($where,$offset,$num,$field,$is_key,$sort){
    $result_lists = InitPHP::getDao('newsMesg')->lists($where,$offset,$num,$field,$is_key,$sort);
    if($result_lists){
      return InitPHP::Enocde(0,'Success',$result_lists,1);
    }else{
      return InitPHP::Enocde(1,'Error',$result_lists,1);
    }
  }


  /**
   * 根据指定条件更新一条数据
   * @param [array] $where [更新数据的条件]
   * @param [array] $data [更新的数据]
   * @return [boolean] $updateStatus [返回更新的状态]
   * @author 李鹏
   * @date 2015-01-08
   */
  public function update($data,$where){
    $update_status = InitPHP::getDao('newsMesg')->update($data,$where);
    if($update_status){
      return InitPHP::Enocde(0,'Success',$update_status,1);
    }else{
      return InitPHP::Enocde(1,'Error',$update_status,1);
    }
  }

  /**
   * 根据指定条件删除一条数据
   * @param [array] $where [指定条件]
   * @return [boolean] $delStatus [返回删除的状态]
   * @author 李鹏
   * @date 2015-01-08
   */
  public function delete($where){
    $del_status = InitPHP::getDao('newsMesg')->delete($where);
    if($del_status){
      return InitPHP::Encode(0,'Success',$del_status,1);
    }else{
      return InitPHP::Encode(1,'Error',$del_status,1);
    }
  }

}
