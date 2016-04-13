<?php
class messageDao extends Dao {
	private $table_name = 'message';
	private $fields = 'id,to_userid,from_userid,title,contents,type,is_read,create_time';

	/**
	 * 添加一条数据
	 * @param [array] $data [要添加的数据，包括：array('to_useris' => ,'from_userid' => ,'title' => ,'contents' => ,'type' => ,'is_read' => ,'create_time' => )]
	 * @return [integer] $isertId [返回添加成功的自增id]
	 * @author 李鹏
	 * @date 2016-01-10
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	public function get($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$mesg = $this->dao->db->get_one_by_field($where, $this->table_name);
		if (intval($mesg['is_read']) == 0) {
			//如果消息状态为未读则更改消息状态为已读
			$status = $this->dao->db->update_by_field(array('is_read' => 1), $where, $this->table_name);
			if ($status) {
				return $mesg;
			}
		} else {
			return $mesg;
		}
	}

	/**
	 * 获取组数据
	 * @using htt://api.jw.com/message/index/lists
	 * @method [string] GET [请求方式]
	 * @param [string] $userid [会员id,必须]
	 * @param [integer] $offset [数据偏移量，可选]
	 * @param [integer] $num [数据数量，可选]
	 * @param [array] $field [数据字段，可选]
	 * @param [string] $is_key [排序关键字，可先]
	 * @param [string] $sort [数据排序方式,可选]
	 * @return [array] $Lists [所有的消息列表]
	 * @athor 李朋
	 * @date 2016-01-10
	 */
	public function lists($where = array(''), $num = 10, $offset = 0, $is_key = 'to_userid', $sort = 'DESC') {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_all($this->table_name, $num, $offset, $where, $is_key, $sort);
	}

	/**
	 * 删除数据
	 */
	public function delete($where, $ids, $del_key = 'id') {
		$where = $this->dao->db->build_key($where, $this->fields);
		$where = $this->dao->db->build_where($where);
		//数据表中有没有跟要删除的用户id关联的
		$is_has = $this->dao->db->get_count($this->table_name, $where);
		if ($is_has && $is_has > 0) {
			return $this->dao->db->delete($ids, $table_name, $del_key);
		} else {
			return $is_has;
		}
	}

	/**
	 * 更新数据
	 */
	public function update($data, $where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

}
