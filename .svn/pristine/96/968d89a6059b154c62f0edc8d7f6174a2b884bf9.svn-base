<?php
 
/**
 * @Author: 李昊
 * @Date:   2016-3-13 15:21:40
 * @Last Modified time: 2016-03-13 15:36:56
 */
class storeDataService extends Service
{
    private $DB;

    public function __construct() {
        parent::__construct();
        //获取Dao
        $this->DB = InitPHP::getDao('storeData');
        
    }

    /**
     * 获取单条菜单
     * @param  [array] $where [条件]
     * @return [array]        [单条数据]
     */
    public function get($where) {
        return $this->DB->get($where);
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
     * @return [array]         [description]
     */
    public function lists($where = array(), $offset = 0, $num = 20, $order = 'id', $sort = 'desc', $key = 'id') {
        return $this->DB->lists($where, $num, $offset, $order, $sort, $key);
    }

    /**
     * 更新店铺
     * @param  [array] $data  [更改的数据]
     * @param  [array] $where [更改的条件]
     * @return [bool]        [true or false]
     */
    public function update($data, $where) {
        return $this->DB->update($data, $where);
    }

   
    /**
     * 新增店铺
     * @param  [array] $data [description]
     * @return [boolen or int]       [成功则返回主键自增ｉｄ，失败则返回flase]
     */
    public function create($data) {
        return $this->DB->create($data);
    }

    /**
     * 删除店铺
     * @param  [type] $ids [一个或者多个值 1,2,3]
     * @return [type]      [description]
     */
    public function delete($userid) {
        return $this->DB->delete($userid);
    }


   

    /**
     * 试用sql查询
     * @param [string] $like [查询条件]
     * @param [integer] $limit [查询起始位置]
     * @param [integer] $offset [查询的数据数量]
     */
    public function query_select($like,$limit,$offset){
        $where = ' userid like "%'.$like.'%" or name like "%'.$like.'%" or wechat like "%'.$like.'%" or phone like "%'.$like.'%" or area like "%'.$like.'%" ';
        return $this->DB->query_select($where,$limit,$offset);
    }

    

    /*
    **添加店铺父类栏目
     */
    public function createShopCate($data){
        $insertid = $this->categorysDao->create($data);
        if($insertid){
            $datas = $this->categorysDao->update(array('arrchildid'=>$insertid),array('catid'=>$insertid));
            if($datas){ 
                if($data['parentid'] != 0){
                    $cateparent = $this->categorysDao->get(array('catid'=>$data['parentid']));
                    $this->categorysDao->update(array('arrchildid'=>$cateparent['arrchildid'].','.$insertid),array('catid'=>$data['parentid']));
                }
                return array('code' => 200, 'msg' => 'Success');//更新成功
            }else{
                return array('code' => 300, 'msg' => 'failed');//更新成功
            }
        }else{
            return array('code' => 400, 'msg' => 'nulled');//插入失败
        }
    }
}
