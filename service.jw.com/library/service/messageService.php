<?php
class messageService extends Service {
	public function __construct() {
		parent::__construct();
		$this->DB = InitPHP::getDao('message');
	}

	/**
	 * 添加一条数据
	 * @param [array] $data [要添加的数据，包括：array('to_useris' => ,'from_userid' => ,'title' => ,'contents' => ,'type' => ,'is_read' => ,'create_time' => )]
	 * @return [integer] $isertId [返回添加成功的自增id]
	 * @author 李鹏
	 * @date 2016-01-10
	 */
	public function create($data) {
		$insertId = InitPHP::getDao('message')->create($data);
		if ($insertId) {
			return InitPHP::Encode(0, 'Success', $insertId, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $insertId, 1);
		}
	}

	/**
	 * [send_one 发送单条消息服务]
	 * @param  [type]  $to_userid [description]
	 * @param  [type]  $content      [消息内容]
	 * @param  integer $type      [description]
	 * @param  [type]  $from_userid    [description]
	 * @return [bool]             [返回类型为true or false]
	 * @author [李昊] <[<email address>]>
	 */
	public function send_one($to_userid,$contents,$type=1,$from_userid=1){
		// 检查是否有 收件者id 和 发送内容
		if(!isset($to_userid) || !isset($contents)) return false;
		
		if (!in_array($type, array(1,2,3,4,5))) {
			return false;
		}
		if($from_userid < 1){
			return false;
		}
		// 判断消息类型
		switch ($type) {
			case '1':
				# code...
				$title = '系统消息';
				break;
			case '2':
				# code...
				$title = '订单生成提醒';
				break;
			case '3':
				# code...
				$title = '开通店铺提醒消息';
				break;
			case '4':
				# code... 奖金提醒消息
				$title = '退货申请';
				break;
			case '5':
			# code...奖金提醒消息
				$title = '奖金提醒消息';
			break;
			
		}
		$data['to_userid'] = $to_userid;
		$data['from_userid'] = $from_userid;
		$data['title'] = $title;
		$data['contents'] = $contents;
		$data['type'] = $type;
		$data['create_time'] = time();
		// to_userid,from_userid,title,contents,type,is_read,create_time
		if( $this->DB->create($data) ) return true;
		
		return false;
	}
	/**
	 * 获取一条消息
	 * @using http://api.jw.com/message/index/get
	 * @param [string] $userid [用户id]
	 * @param [integer] $msgid [消息id]
	 * @return [array] $result [消息详情]
	 * @author 李鹏
	 * @date 2016-01-10
	 */
	public function get($where) {
		$result = InitPHP::getDao('message')->get($where);
		$result['create_time'] = date('Y-m-d H:i:s', $result['create_time']);
		$result['contents'] = htmlspecialchars_decode($result['contents']);
		if ($result) {
			return InitPHP::Encode(0, 'Success', $result, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $result, 1);
		}
	}

	/**
	 * 获取用户所有的信息列表
	 * @using htt://api.jw.com/message/index/lists
	 * @method [string] GET [请求方式]
	 * @param [string] $userid [会员id,必须]
	 * @param [integer] $offset [数据偏移量，可选]
	 * @param [integer] $num [数据数量，可选]
	 * @param [array] $field [数据字段，可选]
	 * @param [string] $is_key [排序关键字，可先]
	 * @param [string] $sort [数据排序方式,可选]
	 * @return [array] $msgLists [所有的消息列表]
	 * @athor 李朋
	 * @date 2016-01-10
	 */
	public function lists($where = array(''), $num = 10, $offset = 0, $is_key = 'to_userid', $sort = 'DESC') {
		$lists = InitPHP::getDao('message')->lists($where, $num, $offset, $is_key, $sort);
		for ($i = 0; $i < count($lists[0]); $i++) {
			$lists[0][$i]['create_time'] = date('Y-m-d H:i:s', $lists[0][$i]['create_time']);
			$lists[0][$i]['contents'] = htmlspecialchars_decode($lists[0][$i]['contents']);
		}
		if ($lists) {
			return InitPHP::Encode(0, 'Success', $lists, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $lists, 1);
		}
	}

	/**
	 * 删除消息
	 * @param [array] $where [要删除的条件，如果$where = arrray('to_userid' => )]
	 * @param [string || array] $ids [要删除的数据的id，可以是一个或多个]
	 * @param [string] $del_key [要删除的关键字,默认以id为关键字]
	 * @author 李鹏
	 * @date 2015-01-10
	 */
	public function delete($where, $ids) {
		$dele = InitPHP::getDao('message')->delete($where, $ids);
		if ($dele) {
			return InitPHP::Encode(0, 'Success', $dele, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $dele, 1);
		}
	}

	/**
	 * 更新数据
	 * @param [array] $where [更新数据条件,如：$where = array('id' => ,'to_userid' => )]
	 * @param [array] $data [要更新的数据,如：$data = array('title' => ,'contents' => )]
	 * @return [boolean || integer] $updateStatus [更新状态，是否成功]
	 * @author 李鹏
	 * @date 2015-01-10
	 */
	public function update($date, $where) {
		$update = InitPHP::getDao('message')->update($data, $where);
		if ($update) {
			return InitPHP::Encode(0, 'Success', $update, 1);
		} else {
			return InitPHP::Encode(1, 'Error', $update, 1);
		}
	}

}
