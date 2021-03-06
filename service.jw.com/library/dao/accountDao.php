<?php
class accountDao extends Dao {
	private $table_name = 'member_info';
	private $fields = 'userid,nickname,password,encrypt,sex,avarat,qq_openid,wechat_openid,sina_openid,phone,email,parentid,levels,layer,qq,wechat,create_time,is_has_shop';
	
	/**
	 * 获取用户总数量
	 * @return [type] [description]
	 */
	public function get_count(){
		return $this->dao->db->get_count($this->table_name,array());
	}
	/**
	 * 添加条帐号信息
	 * @param  [array] $data [要添加的帐号数据]
	 * @return [integer || blooean]       [添加成功时的自增id || 失败时false]
	 * @author 李鹏
	 * @date 2016-03-01
	 */
	public function create($data) {
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

	/**
	 * 获取一条数据
	 * @param  [array] $where [获取数据条件]
	 * @return [array] $result [查询一组数据]
	 * @author 李鹏
	 * @date 2016-03-01
	 */
	public function get($where) {
		$where = $this->dao->db->build_key($where, $this->fields);
		return $this->dao->db->get_one_by_field($where, $this->table_name);
	}

	/**
	 * 更新一条数据
	 * @param  [array] $data  [要更新的数据]
	 * @param  [array] $where [更新数据的条件]
	 * @return [blooean]        [是否更新成功]
	 * @author 李鹏
	 * @date 2016-03-01
	 */
	public function update($data, $where) {
		return $this->dao->db->update_by_field($data, $where, $this->table_name);
	}

	/**
	 * 获取一组数据
	 * @param  array   $where  [查询条件]
	 * @param  integer $num    [查询数量]
	 * @param  integer $offset [查询偏移量]
	 * @param  string  $is_key [排序关键字]
	 * @param  string  $sort   [排序方式]
	 * @param  array   $field  [要查询的字段]
	 * @return [array] $collection [查询的集合]
	 * @author 李鹏
	 * @date 2016-03-01
	 */
	public function lists($where = array(''), $num = 20, $offset = 0, $is_key = 'userid', $sort = 'DESC', $field = array('*')) {
		$where = $this->dao->db->build_key($where, $this->fields);
		$where = $this->dao->db->build_where($where);
		$field = arrToStr($field);
		$limit = $this->dao->db->build_limit($num, $offset);
		$sql = 'SELECT ' . $field . ' FROM ' . $this->table_name . ' ' . $where . ' ORDER BY ' . $is_key . ' ' . $limit;
		$lists[0] = $this->dao->db->get_all_sql($sql);
		$lists[1] = $this->dao->db->get_count($this->table_name);
		return $lists;
	}

	/**
	 * 删除一条记录
	 * @param Array $where
	 */
	public function delete($userid) {
		$userid = trim($userid);
		if (!$userid) {
			return false;
		}

		$where = array('userid' => $userid);
		$status = $this->dao->db->delete_by_field($where, $this->table_name);
		if ($status) {
			//同步注册钱包账户
			$wallet = InitPHP::getDao('wallet');
			$wallet->delete(array('userid' => $userid));
		}
		return $status;
	}

	/**
	 * get Wally
	 * @param [array] $where [$where = array('userid' => )]
	 */
	public function getWallet($where) {
		$wallet = InitPHP::getDao('wallet');
		return $wallet->get($where);
	}

	/**
	 * 获取一组资金流动记录
	 * @param  array   $where  [description]
	 * @param  integer $num    [description]
	 * @param  integer $offset [description]
	 * @param  string  $is_key [description]
	 * @param  string  $sort   [description]
	 * @param  string  $field  [description]
	 * @return [type]          [description]
	 */
	public function consumLists($where = array('*'), $num = 20, $offset = 0, $is_key = 'id', $sort = 'DESC', $field = '*') {
		$fileds = 'userid,shop_id,title,content,amount,make,create_time,status,type';
		$table = 'capital_transactions';
		$where = $this->dao->db->build_key($where, $fileds);
		$limit = $this->dao->db->build_limit($offset, $num);
		if($where['type'] == 5){
			unset($where['type']);
		}
		$sql = 'SELECT ' . $field . ' FROM ' . $table . $this->dao->db->build_where($where) . 'ORDER BY ' . $is_key . ' ' . $sort . ' ' . $limit;
		$collection[0] = $this->dao->db->get_all_sql($sql);
		$collection[1] = $this->dao->db->get_count($table, $where);
		return $collection;
	}

	/**
	 * 获取用户的所的消费额度
	 * @param  [string] $userid [用户id]
	 * @return [type]         [description]
	 * @author 李鹏
	 * @date 2016-03-11
	 */
	public function getAllConsumptionQuota($userid) {
		$temp = 0;
		$table = 'capital_transactions';
		$sql = 'SELECT amount FROM ' . $table . ' WHERE userid = ' . $userid;

		$quota = $this->dao->db->get_all_sql($sql);

		for ($i = 0; $i < count($quota); $i++) {
			$temp += sprintf('%01.2f', $quota[$i]['amount']);
		}
		return sprintf('%01.2f', $temp);
	}

	/**
	 * 获取用户等级
	 * @param  [array] $where [数组形式的用户id,如：array('userid' => $userid)]
	 * @return [type]        [description]
	 */
	public function getLevels($userid) {
		$result = $this->get(array('userid' => $userid));
		$this->getRedis('default')->redis()->hmset('userinfo:' . $result['userid'], $result);
		return intval($result['levels']);
	}
	/**
	 * 获取用户等级
	 * @param  [array] $where [数组形式的用户id,如：array('userid' => $userid)]
	 * @return [type]        [description]
	 */
	public function getParentId($userid) {
		$result = $this->get(array('userid' => $userid));
		$this->getRedis('default')->redis()->hmset('userinfo:' . $result['userid'], $result);
		return $result['parentid']?$result['parentid']:1;
	}

	/**
	 * 根据sql语句查询
	 * @param [array] $where [$where = array('userid' => )]
	 */
	public function query_select($where, $limit, $offset) {
		// return "select * from `".$this->table_name."` where ".$where.' ORDER BY userid desc limit '.$limit.','.$offset;
		$info[0] = (array) $this->dao->db->get_all_sql("select * from `" . $this->table_name . "` where " . $where . ' ORDER BY userid desc limit ' . $limit . ',' . $offset);
		$count = $this->dao->db->get_all_sql("SELECT COUNT(*) as count FROM `" . $this->table_name . "` WHERE " . $where);
		$info[1] = intval($count[0]['count']);
		return $info;
	}

	//开启事务
	public function transaction_start() {
		$this->dao->db->transaction_start();
	}
	//提交事务
	public function transaction_commit() {
		$this->dao->db->transaction_commit();
	}
	//回滚事务
	public function transaction_rollback() {
		$this->dao->db->transaction_rollback();
	}
}