<?php
class systemMenuService extends Service
{
    
    /**
     * 获取单条菜单
     * @param $user
     */
    public function get($where) {
        return InitPHP::getDao("menu")->get($where);
    }
    
    /**
     * 获取子集列表菜单
     * @param $user
     */
    public function lists($where = array(), $offset = 0, $num = 1000, $order = 'sort', $sort = 'asc', $key = 'menuid', $fileds = '*') {
        return InitPHP::getDao("menu")->lists($where, $offset, $num, $order, $sort, $key, $fileds);
    }
    
    /**
     * 更新菜单
     * @param $user
     */
    public function update($data, $where) {
        return InitPHP::getDao("menu")->update($data, $where);
    }
    
    /**
     * 新增菜单
     * @param $user
     */
    public function create($data) {
        return InitPHP::getDao("menu")->create($data);
    }
    
    /**
     * 删除菜单
     * @param $ids 一个或者多个值
     * @param $id_key 上面值的对应的键
     */
    public function delete($ids) {
        return InitPHP::getDao("menu")->delete($ids);
    }
}
