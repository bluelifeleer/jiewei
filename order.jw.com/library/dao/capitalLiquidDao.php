<?php
class capitalLiquidDao extends Dao {
	private $table_name = 'capital_transactions';
	private $fields = 'userid,shop_id,title,content,amount,make,status,type,create_time,action';

	/**
	 * 添加一条资金流动信息数据
	 * @param  [array] $data [数据]
	 * @return [blooean or integer] $addid [添加成功(自增id)或失败(fasle)]
	 * @author 李鹏
	 * @date 2016-02-25
	 */
	public function insert($data) {
		//return true;
		$data = $this->dao->db->build_key($data, $this->fields);
		return $this->dao->db->insert($data, $this->table_name);
	}

}
