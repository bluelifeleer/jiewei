<?php

/**
 * @Author: 李朋
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-01-10 18:41:45
 */
class transitService extends Service {
	private $DB;

	public function __construct() {
		parent::__construct();
		//获取Dao
		$this->DB = InitPHP::getDao('transit');
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
	 * @return [array]          [description]
	 */
	public function lists($where = array(), $offset = 0, $num = 20, $order = 'id', $sort = 'desc', $key = 'id', $fileds = '*') {
		return $this->DB->lists($where, $offset, $num, $order, $sort, $key, $fileds);
	}

	/**
	 * 更新菜单
	 * @param  [array] $data  [更改的数据]
	 * @param  [array] $where [更改的条件]
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

	public function updateDef($id, $userid) {
		if ($id && $userid) {
			return $this->DB->updateDef("update `address` set defaultv=0 where `id` not in (" . $id . ") and `userid`=" . $userid);
		}
	}
}
