<?php
/**
 * 设置表
 * @author 　翁昌华
 * @Date 215.5.25
 */
class settingService extends Service {
	/**
	 * @var settingDao
	 */
	private $settingDao;
	public function __construct() {
		parent::__construct();
		$this->settingDao = InitPHP::getDao("setting");
	}
	/**
	 * 获取设置
	 * @author seaven
	 * @param Array or String $where 需要获取的字段;
	 * @Date 215.5.25
	 * @return Array
	 */
	public function get_setting($where) {
		if ($where) {
			if (is_array($where)) {
				$filed = '';
				foreach ($where as $v) {
					$filed .= '"'.$v.'",';
				}
				$filed = rtrim($filed, ',');
			} else {
				$fileds = explode(',', $where);
				foreach ($fileds as $v) {
					$filed .= '"'.$v.'",';
				}
				$filed = rtrim($filed, ',');
			}
		} else {
			$field = '';
		}
		$res = $this->settingDao->get_setting($filed);
		foreach ($res as $k => $v) {
			$data[$v['keys']] = $v['value'];
		}
		return $data;
	}
	/**
	 * 更新数据
	 * @param Array $data 需要更新的数据;
	 * @Date 215.5.25
	 */
	public function update_setting($data) {
		if ($data) {
			$i = true;
			foreach ($data as $k => $v) {
				$r = $this->settingDao->update_setting(array('value' => $v), array('keys' => $k));
				if (!$r) {
					$i = false;
				}
			}
			return $i;
		} else {
			return false;
		}
	}
}