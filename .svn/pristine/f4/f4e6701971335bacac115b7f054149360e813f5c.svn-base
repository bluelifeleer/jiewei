<?php
/**
*管理员控制类
*/
class adminPrivService extends Service{
	
	/**
	 * 获取单条菜单
	 * @param $user
	 */
	public function get($where) {
		return InitPHP::getDao("adminPriv")->get($where);
	}

	/**
	 * 获取子集列表菜单
	 * @param $user
	 */
	public function lists($where=array(),$offset = 0,$num = 1000,$order='role',$sort='asc',$key='role',$fileds='*') {
		return InitPHP::getDao("adminPriv")->lists($where,$offset,$num,$order,$sort,$key,$fileds);
	}
	/**
	 * 更新菜单
	 * @param $user
	 */
	public function update($data,$where) {
		return InitPHP::getDao("adminPriv")->update($data,$where);
	}
	
	/**
	 * 新增菜单
	 * @param $user
	 */
	public function create($data) {
		return InitPHP::getDao("adminPriv")->create($data);
	}
	/**
	 * 删除菜单
	 * @param $ids 一个或者多个值
	 * @param $id_key 上面值的对应的键
	 */
	public function delete($ids){
		return InitPHP::getDao("adminPriv")->delete($ids);
	}


}