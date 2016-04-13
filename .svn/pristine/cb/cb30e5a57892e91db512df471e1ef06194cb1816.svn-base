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
	public function insert($data) {
		//return true;
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}
}
