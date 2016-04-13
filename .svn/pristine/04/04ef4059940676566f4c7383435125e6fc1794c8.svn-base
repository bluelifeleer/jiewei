<?php
if (!defined('IS_INITPHP')) {
	exit('Access Denied!');
}

$InitPHP_conf = InitPHP::getConfig();
define(THEME_PATH, InitPHP::getAppPath($InitPHP_conf['template']['template_path']));
define(THEME_CACHE_PATH, InitPHP::getAppPath($InitPHP_conf['template']['template_c_path']));
define(TEMPLATE_TYPE, $InitPHP_conf['template']['template_type']);
define(TEMPLATE_CACHE_TYPE, $InitPHP_conf['template']['template_c_type']);
define(THEME, $InitPHP_conf['template']['theme']);
/*********************************************************************************
 * Yun-Soft.COM    View-view 模板核心文件类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By yun-soft.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * Author:liubo  Datetime:2015-3-15
 ***********************************************************************************/
class viewInit {

	/**
	 * 编译模板
	 *
	 * @param $module	模块名称
	 * @param $template	模板文件名
	 * @param $istag	是否为标签模板
	 * @return unknown
	 */

	public function template_compile($module, $template) {
		$fileinfo    = pathinfo($template);
		$filename    = $fileinfo['basename'];
		$fileprepath = $fileinfo['dirname'];
		if ($fileprepath == '.') {
			$fileprepath = '';
		}

		if (strpos($module, '/') === false) {
			$tplfile = $_tpl = THEME_PATH.DIRECTORY_SEPARATOR.$module.$fileprepath.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$filename.TEMPLATE_TYPE;
		}
		if (!file_exists($tplfile)) {
		
			$tplfile = THEME_PATH.DIRECTORY_SEPARATOR.$module.$fileprepath.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$filename.TEMPLATE_TYPE;
		}
		if (!file_exists($tplfile)) {

			InitPHP::initError("templates:".THEME_PATH.DIRECTORY_SEPARATOR.$module.$fileprepath.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$filename.TEMPLATE_TYPE." is not exists!");
		}
		$content  = @file_get_contents($tplfile);
		$filepath = THEME_CACHE_PATH.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$fileprepath;
		if (!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
		}
		$compiledtplfile = $filepath.DIRECTORY_SEPARATOR.$filename.TEMPLATE_CACHE_TYPE;
		$content         = $this->template_parse($content);
		$strlen          = file_put_contents($compiledtplfile, $content);
		chmod($compiledtplfile, 0777);
		return $strlen;
	}

	/**
	 * 更新模板缓存
	 *
	 * @param $tplfile	模板原文件路径
	 * @param $compiledtplfile	编译完成后，写入文件名
	 * @return $strlen 长度
	 */
	public function template_refresh($tplfile, $compiledtplfile) {
		$str    = @file_get_contents($tplfile);
		$str    = $this->template_parse($str);
		$strlen = file_put_contents($compiledtplfile, $str);
		chmod($compiledtplfile, 0777);
		return $strlen;
	}

	/**
	 * 解析模板
	 *
	 * @param $str	模板内容
	 * @return ture
	 */
	public function template_parse($str) {
	
		$str = preg_replace("/\{V\s+(.+)\}/", "<?php include V(\\1);?>", $str);

		$str = preg_replace("/\{include\s+(.+)\}/", "<?php include \\1;?>", $str);

		$str = preg_replace("/\{php\s+(.+)\}/", "<?php \\1?>", $str);
		$str = preg_replace("/\{if\s+(.+?)\}/", "<?php if(\\1){ ?>", $str);
		$str = preg_replace("/\{else\}/", "<?php } else { ?>", $str);
		$str = preg_replace("/\{elseif\s+(.+?)\}/", "<?php } elseif (\\1) {?>", $str);
		$str = preg_replace("/\{\/if\}/", "<?php } ?>", $str);
		//for 循环
		$str = preg_replace("/\{for\s+(.+?)\}/", "<?php for(\\1) { ?>", $str);
		$str = preg_replace("/\{\/for\}/", "<?php } ?>", $str);
		//++ --
		$str = preg_replace("/\{\+\+(.+?)\}/", "<?php ++\\1; ?>", $str);

		$str = preg_replace("/\{\-\-(.+?)\}/", "<?php ++\\1; ?>", $str);

		$str = preg_replace("/\{(.+?)\+\+\}/", "<?php \\1++; ?>", $str);

		$str = preg_replace("/\{(.+?)\-\-\}/", "<?php \\1--; ?>", $str);

		$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/", "<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $str);
		$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php \$n=1; if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $str);
		$str = preg_replace("/\{\/loop\}/", "<?php \$n++;}unset(\$n); ?>", $str);
		$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str);

		$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str);

		$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", "<?php echo \\1;?>", $str);

		$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->addquote('<?php echo \\1;?>')", $str);
		$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $str);

		$str = "<?php defined('IS_INITPHP') or exit('No permission resources.');?>".$str;

		/*
		$str = preg_replace_callback ( "/\{V\s+(.+)\}/", function($match){return "<?php include V($match[1]); ?>";}, $str );

		$str = preg_replace_callback ( "/\{include\s+(.+)\}/",function($match){return "<?php include $match[1]; ?>";}, $str );

		$str = preg_replace_callback ( "/\{php\s+(.+)\}/",function($match){return "<?php $match[1]?>";} , $str );

		$str = preg_replace_callback ( "/\{if\s+(.+?)\}/",function($match){return "<?php if($match[1]) { ?>";}  , $str );
		$str = preg_replace_callback ( "/\{else\}/",function($match){return "<?php } else { ?>";}  , $str );

		$str = preg_replace_callback ( "/\{elseif\s+(.+?)\}/",function($match){return "<?php } elseif ($match[1]) { ?>";}  , $str );

		$str = preg_replace_callback ( "/\{\/if\}/",function($match){return "<?php } ?>";}  , $str );
		//for 循环
		$str = preg_replace_callback("/\{for\s+(.+?)\}/",function($match){return "<?php for($match[1]) { ?>";} ,$str);
		$str = preg_replace_callback("/\{\/for\}/",function($match){return "<?php } ?>";} ,$str);
		//++ --
		$str = preg_replace_callback("/\{\+\+(.+?)\}/",function($match){return "<?php ++$match[1]; ?>";},$str);

		$str = preg_replace_callback("/\{\-\-(.+?)\}/",function($match){return "<?php ++$match[1]; ?>";},$str);

		$str = preg_replace_callback("/\{(.+?)\+\+\}/",function($match){return "<?php $match[1]++; ?>";},$str);

		$str = preg_replace_callback("/\{(.+?)\-\-\}/",function($match){return "<?php $match[1]--; ?>";},$str);

		$str = preg_replace_callback ( "/\{loop\s+(\S+)\s+(\S+)\}/",function($match){return "<?php \$n=1;if(is_array($match[1])) foreach($match[1] AS $match[2]) { ?>";}, $str );
		$str = preg_replace_callback ( "/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", function($match){return "<?php \$n=1; if(is_array($match[1])) foreach($match[1] AS $match[2] => $match[3]) { ?>";}, $str );
		$str = preg_replace_callback ( "/\{\/loop\}/", function($match){return "<?php \$n++;}unset(\$n); ?>";}, $str );
		$str = preg_replace_callback ( "/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", function($match){return "<?php echo $match[1];?>";}, $str );

		$str = preg_replace_callback ( "/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", function($match){return "<?php echo $match[1];?>";}, $str );

		$str = preg_replace_callback ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", function($match){return "<?php echo $match[1];?>";}, $str );

		$str = preg_replace_callback("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", function($match){return "\$this->addquote('<?php echo $match[1];?>')";},$str);
		$str = preg_replace_callback ( "/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", function($match){return "<?php echo $match[1];?>";}, $str );

		$str = "<?php defined('IS_INITPHP') or exit('No permission resources.'); ?>" . $str;

		 */
		return $str;
	}

	/**
	 * 转义 // 为 /
	 *
	 * @param $var	转义的字符
	 * @return 转义后的字符
	 */
	public function addquote($var) {
		return str_replace("\\\"", "\"", preg_replace_callback("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", function ($match) {return $match[1];}, $var));

	}

	/**
	 * 转换数据为HTML代码
	 * @param array $data 数组
	 */
	private static function arr_to_html($data) {
		if (is_array($data)) {
			$str = 'array(';
			foreach ($data as $key => $val) {
				if (is_array($val)) {
					$str .= "'$key'=>" .self::arr_to_html($val).",";
				} else {
					if (strpos($val, '$') === 0) {
						$str .= "'$key'=>$val,";
					} else {
						$str .= "'$key'=>'" .new_addslashes($val)."',";
					}
				}
			}
			return $str.')';
		}
		return false;
	}
}