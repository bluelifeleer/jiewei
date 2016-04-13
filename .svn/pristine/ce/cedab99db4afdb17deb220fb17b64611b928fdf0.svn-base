<?php 
/**
 * 短信平台API接口类
* 尊敬的用户！验证码是******,请尽快完成操作。
* 恭喜您已注册成功！密码是 ************* 请妥善保管！谨防他人使用！
* 恭喜您密码重置成功!新密码是 ************* 请妥善保管！谨防他人使用！
* 恭喜您夺宝成功！您在***********期夺宝活动中成功夺得***人次;
* 尊敬的用户，您的账户资金在**月**日**时**分**秒支付***元，交易后余额为******元，积分*****分。
* 尊敬的用户！您在***********期夺宝活动中成功夺冠.获得产品为< ************* > 总计1份;
* 尊敬的用户！您在***********期夺宝活动中成功夺冠.获得由<*******>提供的产品< ************* > 总计1份，欢迎莅临<*******>消费/兑换;
* 尊敬的用户！您在***********期夺宝活动中成功夺冠.获得由<*******>提供的产品< ************* > 总计1份，已于**年**月**日**时**分**秒消费/兑换;
 */
class smsNApiService {
	public $statuscode;
	private $api_account, $api_password, $api_send_url;
	
	/**
	 * 
	 * 初始化接口类
	 * @param int $api_account 产品id
	 * @param string $api_password 密钥
	 */
	public function __construct($api_account = 'jieweikj', $api_password = 'Jiewei123') {
		$this->api_send_url = 'http://222.73.117.158/msg/HttpBatchSendSM';
		$this->api_balance_query_url = 'http://222.73.117.158/msg/QueryBalance';
		$this->api_account = $api_account;
		$this->api_password = $api_password;
		
	}
	
	/**
	 * 
	 * 批量发送短信
	 * @param array $mobile 手机号码
	 * @param string $content 短信内容
	 * @param string $content 文本内容
	 * @param string $id_code 唯一值 、可用于验证码
	 * @param string $siteid 使用的站点
	 */
	public function send_sms($mobile='', $content='',$id_code='', $siteid=1) {
		//短信发送状态
		// $status = $this->_sms_status();
		// return $status;

		if(is_array($mobile)){
			$mobile = implode(",", $mobile);
		}

		$send_content = safe_replace($content);
	
		$data = array(
						'account' => $this->api_account,
						'pswd' => $this->api_password,
						'msg' => urlencode($send_content),
						'mobile' => $mobile,
						'needstatus' => 'true',
					);
		$post = '';
		foreach($data as $k=>$v) {
			$post .= $k.'='.$v.'&';
		}
		//http://222.73.117.158/msg/HttpBatchSendSM?
		//account=mayiduobao&
		//pswd=COMsensadmin888&
		//mobile=13777795925&
		//msg=%E4%BD%A0%E5%A5%BD%EF%BC%8C%E6%82%A8%E7%9A%84%E9%AA%8C%E8%AF%81%E7%A0%81%E5%86%85%E5%AE%B9%E6%98%AF990099&
		//needstatus=true
		$smsapi_senturl = $this->api_send_url;
		$return = $this->_post($smsapi_senturl, 0, $post);
		$arr = explode(',',$return);
		$this->statuscode = $arr[1];
		// $arr = explode(',',$return);
		//resptime,respstatus,msgid
		// $this->statuscode = $arr[1];
		// $this->statuscode = $arr[1];
		//增加到本地数据库
		// $sms_report_db = pc_base::load_model('sms_report_model');
		// $send_userid = param::get_cookie('_userid') ? intval(param::get_cookie('_userid')) : 0;
		// $ip = ip();
		
		// $new_content = $content;
		// if(isset($this->statuscode)) {
 			// $sms_report_db->insert(array('mobile'=>$mobile,'posttime'=>SYS_TIME,'id_code'=>$id_code,'status'=>$this->statuscode,'msg'=>$new_content,'return_id'=>$return,'ip'=>$ip,'siteid'=>$siteid));
		// } else {
			// $sms_report_db->insert(array('mobile'=>$mobile,'posttime'=>SYS_TIME,'status'=>'-2','msg'=>$new_content,'ip'=>$ip));
		// }
		//end
		return  $arr[1];
	}
	

	/**
	 *  post数据
	 *  @param string $url		post的url
	 *  @param int $limit		返回的数据的长度
	 *  @param string $post		post数据，字符串形式username='dalarge'&password='123456'
	 *  @param string $cookie	模拟 cookie，字符串形式username='dalarge'&password='123456'
	 *  @param string $ip		ip地址
	 *  @param int $timeout		连接超时时间
	 *  @param bool $block		是否为阻塞模式
	 *  @return string			返回字符串
	 */
	
	private function _post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 30, $block = true) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
		$siteurl = $this->_get_url();
		if($post) {
			$out = "POST $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n" ;
			$out .= 'Content-Length: '.strlen($post)."\r\n" ;
			$out .= "Connection: Close\r\n" ;
			$out .= "Cache-Control: no-cache\r\n" ;
			$out .= "Cookie: $cookie\r\n\r\n" ;
			$out .= $post ;
		} else {
			$out = "GET $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) return '';
	
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
	
		if($status['timed_out']) return '';	
		while (!feof($fp)) {
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
		}
		
		$stop = false;
		while(!feof($fp) && !$stop) {
			$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
			$return .= $data;
			if($limit) {
				$limit -= strlen($data);
				$stop = $limit <= 0;
			}
		}
		@fclose($fp);
		
		//部分虚拟主机返回数值有误，暂不确定原因，过滤返回数据格式
		$return_arr = explode("\n", $return);
		if(isset($return_arr[1])) {
			$return = trim($return_arr[1]);
		}
		unset($return_arr);
		
		return $return;
	}

	/**
	 * 获取当前页面完整URL地址
	 */
	private function _get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? $this->_safe_replace($_SERVER['PHP_SELF']) : $this->_safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? $this->_safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? $this->_safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$this->_safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
	
	/**
	 * 安全过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	private function _safe_replace($string) {
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}
	
	/**
	 * 
	 * 接口短信状态
	 */
	private function _sms_status() {
		pc_base::load_app_func('global','sms');
		return sms_status(0,1);
	}
	
}



?>