<?php

/**
 * 提现方式，系统服务层
 * @Author: 邵博
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-04-09 21:48:17
 */
class presentRecordService extends Service{
    private $DB;
    private $walletDB;
    
    public function __construct() {
        parent::__construct();
        //获取Dao
        $this->DB = InitPHP::getDao('presentRecord');
        $this->walletDB = InitPHP::getDao('wallet');
    }
    
    /**
     * 获取单条
     * @param  [array] $where [查询条件]
     * @return [array]        [单条数据]
     */
    /**
     * 获取单条菜单
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where) {
        return  $this->DB->get($where);
    }
    
    /**
     * 获取子集列表菜单
     * @param  array   $where  [description]
     * @param  integer $offset [description]
     * @param  integer $num    [description]
     * @param  string  $order  [description]
     * @param  string  $sort   [description]
     * @param  string  $key    [description]
     * @param  string  $fileds [description]
     * @return [array]          [description]
     */
    public function lists($where = array(), $offset = 0, $num = 20, $order = 'id', $sort = 'desc', $key = 'id', $fileds = '*') {
        return $this->DB->lists($where, $offset, $num, $order, $sort, $key, $fileds);
    }
    
    public function update_filed($data,$where){
        return $this->DB->update_filed($data, $where);
    }

    /**
     * 更新菜单
     * @param  [array] $data  [更改的数据]
     * @param  int $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where) {
        return $this->DB->update($data, $where);
    }
    
    /**
     * 新增菜单
     * @param  [array] $data [description]
     * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data) {
        return $this->DB->create($data);
    }
    
    /**
     * 删除菜单
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($ids) {
        return $this->DB->delete($ids);
    }


    public function updateDef($id,$userid){
        if($id && $userid){
        return $this->DB->updateDef("update `present_record` set defaultv=0 where `id` not in (".$id.") and `userid`=".$userid);
        }   
    }

    /**
     * 获取我的金额　如果有足够的金额才能提现
     * @param  [varchar] $userid [description]
     * @param  [int] $cash   [description]
     * @return [type]         [description]
     */
    public function getWallet($userid,$cash){
        $mywallet = $this->walletDB->get(array('userid'=>$userid));
        //return $mywallet;
        if($mywallet['amount'] == 0){
            return false;
        }
        if($cash > $mywallet['amount']){
            return false;
        }
        return true;
    }

    /**
     * 获取我的账号金额
     */
    public function get_account($userid){
        return $this->walletDB->get(array('userid'=>$userid));
    }

    /**
     * 更新我的账户金额
     * $data array 更新的数据
     * $where array　更新的条件
     */
    public function update_amount($data,$where){
        return $this->walletDB->update($data,$where);
    }
}
