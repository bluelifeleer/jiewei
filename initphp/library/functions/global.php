<?php
/**
 * [thumb description]
 * @param  [type]  $picurl [description]
 * @param  integer $width  [description]
 * @param  integer $height [description]
 * @return [type]          [description]
 */
function thumb($picurl, $width = 100, $height = 100)
{
    return $picurl;
}
/**
 * 栏目选择
 * @param string $file 栏目缓存文件名
 * @param intval/array $catid 别选中的ID，多选是可以是数组
 * @param string $str 属性
 * @param string $default_option 默认选项
 * @param intval $onlysub 只可选择子栏目
 */

function select_category($result = '', $catid = 0, $str = '', $default_option = '', $onlysub = 0)
{
    $treeUnity = InitPHP::getLibrarys('tree');

    $string = '<select ' . $str . '>';
    if ($default_option) {
        $string .= "<option value='0'>$default_option</option>";
    }

    if (is_array($result)) {
        foreach ($result as $r) {
            $r['selected'] = '';
            if (is_array($catid)) {
                $r['selected'] = in_array($r['catid'], $catid) ? 'selected' : '';
            } elseif (is_numeric($catid)) {
                $r['selected'] = $catid == $r['catid'] ? 'selected' : '';
            }
            $r['html_disabled'] = "0";
            if (!empty($onlysub) && $r['child'] != 0) {
                $r['html_disabled'] = "1";
            }
            $categorys[$r['catid']] = $r;
        }
    }
    $str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
    $str2 = "<optgroup label='\$spacer \$catname'></optgroup>";
    $treeUnity->init($categorys);
    $string .= $treeUnity->get_tree_category(0, $str, $str2);
    $string .= '</select>';
    return $string;
}

/**
 *    根据需要自己写一个将数组转成字符串的方法,判断数组中的值是否为数字如果是数字则转成整形，如果是字符串则原样返回
 *    @param    array:$arr    要转换的数组
 *    @param    int:$iskey    过滤方式1:过滤值;2:过滤字段;［可选］，如果不填这个参数则默认将数组键值转换成键=值,的方式
 *  @param  string:$separator  分隔符，默认使用','为分隔符。
 *    @return string:$str    返回键=值方式的字符串
 *    @author 李鹏
 *    @date 2016-01-01
 *  @editDate 2016-02-19
 */
function arrToStr($arr, $iskey = 0, $separator = ',')
{
    $tempStr = '';
    if (!is_array($arr) || empty($arr)) {
        return false;
    }

    //判断是索引数组还是关联数组
    if (array_key_exists(0, $arr)) {
        //索引数组
        for ($i = 0; $i < count($arr); $i++) {
            if (is_numeric($arr[$i])) {
                $tempStr .= intval($arr[$i]) . $separator;
            } else {
                $tempStr .= $arr[$i] . $separator;
            }
        }
        return substr($tempStr, 0, intval(strlen($tempStr) - strlen($separator)));
    } else {

        //关联数组
        if (isset($iskey)) {
            switch ($iskey) {
                case 1:
                    foreach ($arr as $key => $value) {
                        $tempStr .= $key . $separator . ' ';
                    }
                    break;
                case 2:
                    foreach ($arr as $key => $value) {
                        if (is_numeric($value)) {
                            $tempStr .= intval($value) . $separator . ' ';
                        } else {
                            $tempStr .= $value . $separator . ' ';
                        }
                    }
                    break;
                default:
                    foreach ($arr as $key => $value) {
                        if (is_numeric($value)) {
    //判断值是否为数字
                            $tempStr .= $key . ' = ' . intval($value) . $separator . ' ';
                        } else {
                            $tempStr .= $key . ' = "' . $value . '"' . $separator . ' ';
                        }
                    }
                    break;
            }
        } else {
            foreach ($arr as $key => $value) {
                if (is_numeric($value)) {
//判断值是否为数字
                    $tempStr .= $key . ' = ' . intval($value) . $separator . ' ';
                } else {
                    $tempStr .= $key . ' = "' . $value . '"' . $separator . ' ';
                }
            }
        }
        return substr($tempStr, 0, intval(strlen($tempStr) - (strlen($separator) + 1)));
    }
}

/**
 * [create_where 自定义创建where语句，去掉框架中的数字，字符串不分的情况，去掉多余的空格]
 * @param  [array] $arr [条件数组]
 * @return [string] $where [返回重组后的where sql语句]
 */
function create_where($arr)
{
    if (!is_array($arr) && empty($arr)) {
        return '';
    }

    $temp = '';
    foreach ($arr as $key => $value) {
        if (is_numeric($value)) {
            $temp .= $key . ' = ' . intval($value) . ' AND ';
        } else {
            $temp .= $key . ' = "' . $value . '" AND ';
        }
    }
    return ' WHERE ' . substr($temp, 0, intval(strlen($temp) - 5));
}

/**
 * 生成流水号
 */
function create_sn()
{
    mt_srand((double) microtime() * 1000000);
    return date("YmdHis") . str_pad(mt_rand(1, 99999), 5, "0", STR_PAD_LEFT);
}
/**
 * 系统配置
 *  @Author ArPeng
 */
function setting($where, $type = "get")
{
    switch ($type) {
        case 'get':
            return InitPHP::getRemoteService('setting', 'get_setting', array($where));
            break;
        case 'set':
            return InitPHP::getRemoteService('setting', 'update_setting', array($where));
            break;
        default:
            return false;
            break;
    }
}

/**
 *
 * @param string $name 表单名称
 * @param int $id 表单id
 * @param string $value 表单默认值
 * @param string $moudle 模块名称
 * @param int $catid 栏目id
 * @param int $size 表单大小
 * @param string $class 表单风格
 * @param string $ext 表单扩展属性 如果 js事件等
 * @param string $alowexts 允许图片格式
 * @param array $thumb_setting
 * @param int $watermark_setting  0或1
 */
function webuploader($name, $value = '', $module = 'content', $length = 1, $alowexts = '', $setting = array(), $isThumb = false)
{
    $lists = is_json($value) ? (is_array(json_decode($value, true)) ? json_decode($value, true) : range(1, $length))
    : array(
        array('src' => $value),
    );
    $alowexts = !empty($alowexts) ? $alowexts : 'jpg|jpeg|gif|bmp|png';
    if (!defined("INIT_WEBUPLOAD")) {
        define("INIT_WEBUPLOAD", true);

        $html = '
                <link rel="stylesheet" type="text/css"   href="/resource/js/webuploader/webuploader.css">
                <script type="text/javascript" src="/resource/js/webuploader/webuploader.js"></script>
                <script type="text/javascript" src="/resource/js/webuploader/do.webuploader.js"></script>
                ';

    }
    //重组盒子
    $count  = $length;
    $length = $length - count($lists);

    if ($length) {
        for ($i = 0; $i < $count; $i++) {
            !empty($lists[$i]) ? $lists[$i + $count] = array('src' => $lists[$i]) : $lists[$i + $count] = array('src' => '');
        }
        for ($i = 0; $i < $count; $i++) {
            unset($lists[$i]);
        }

    }

    $style = '';
    if (!empty($setting)) {
        $style  = 'style="width:' . $setting['width'] . ';height:' . $setting['height'] . '"';
        $thumbH = intval($setting['height']) - 2;
        $thumbW = intval($setting['width']) - 2;
    } else {
        $thumbH = $thumbW = 100;
    }

    $html .= '
            <div id="pic-list">
                <ul>';
    foreach ($lists as $key => $val) {
        $val   = is_array($val) ? $val : array('src' => '');
        $thumb = !empty($val['src']) ? $val['src']/*picThumbSrc($val['src'], 100, 100)*/ : '/resource/js/webuploader/images/uploadImg.png';
        $html .= '

                    <li ' . $style . ' id="' . create_randomstr(13) . '">
                    		<div id="' . $name . '-List-' . $key . '">

                    			<input type="hidden" id="' . $id . '" name="' . $name . '[]" value="' . $val['src'] . '">

                    		</div>
                    		<div class="add-file" id="' . $name . '-' . $key . '">
                    			<img src="' . $thumb . '" width="' . $thumbW . '" height="' . $thumbH . '">
                    		</div>
                    </li>
                    <script type="text/javascript">

             				 webuploader("' . $name . '","' . $key . '","' . $module . '",' . $thumbH . ',' . $thumbW . ',"' . $isThumb . '");

                        </script>
                    ';
    }

    $html .= '
                </ul>
            </div>
            ';
    return $html;

}

/**
 * 将字符串转换为数组
 *
 * @param    string    $data    字符串
 * @return    array    返回数组格式，如果，data为空，则返回空数组
 */
function jsonDecode($data)
{
    if ($data == '') {
        return array();
    }

    if (!is_json($data)) {
        return array();
    }

    return json_decode($data, true);
}

/**
 * 将数组转换为字符串
 *
 * @param    array    $data        数组
 * @return    string    返回字符串，如果，data为空，则返回空
 */
function jsonEncode($data)
{
    if ($data == '') {
        return '{}';
    }

    if (!is_array($data) || empty($data)) {
        return '{}';
    }

    return json_encode($data);
}

/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string)
{
    $string = str_replace('%20', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%2527', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('\\', '', $string);
    return $string;
}

/*
 * 数据加密
 * @author ArPeng
 * @param $data 需要加密的数据
 * @param $key 加密密钥
 */
function encrypt($data, $key)
{
    $prep_code = serialize($data);
    $block     = mcrypt_get_block_size('des', 'ecb');
    if (($pad = $block - (strlen($prep_code) % $block)) < $block) {
        $prep_code .= str_repeat(chr($pad), $pad);
    }
    $encrypt = mcrypt_encrypt(MCRYPT_DES, $key, $prep_code, MCRYPT_MODE_ECB);
    $base64  = base64_encode($encrypt);
    $base64  = str_replace(array('+', '/'), array('-', '_'), $base64);
    return $base64 . '==';
}
/*
 * 数据解密
 * @author ArPeng
 * @param $data 需要解密的数据
 * @param $key 解密密钥
 */
function decrypt($str, $key)
{
    $str   = str_replace(array('-', '_'), array('+', '/'), $str);
    $str   = base64_decode($str);
    $str   = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
    $block = mcrypt_get_block_size('des', 'ecb');
    $pad   = ord($str[($len = strlen($str)) - 1]);
    if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $str)) {
        $str = substr($str, 0, strlen($str) - $pad);
    }
    return unserialize($str);
}
/**
 *  global.php 公共函数库
 *
 * @copyright            (C) 2014-2014  温州云软科技有限公司
 * @author    liubo
 */
//是否是ie如果是则返回版本号
function isIe()
{
    $agent = $_SERVER["HTTP_USER_AGENT"];
    if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) {
        preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs);
        return $regs[1];
    }
    return false;
}
/*
 * Author  Arpeng
 *将无限极分类整理成多维数组
 */
function getCatTree($data, $filed = 'id', $parentFiled = "pid", $childFiled = "child")
{
    $tree = array();
    foreach ($data as $v) {
        if ($data[$v[$parentFiled]]) {
            $data[$v[$parentFiled]][$childFiled][] = &$data[$v[$filed]];
        } else {
            $tree[] = &$data[$v[$filed]];
        }
    }
    return $tree;
}
/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...')
{
    //$string = iconv("UTF-8","GB2312",$string);
    $strlen = strlen($string);
    if ($strlen <= $length) {
        return $string;
    }

    $string = str_replace(array(' ', '&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵', ' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
    $strcut = '';
//    if (strtolower(CHARSET) == 'utf-8') {
    $length = intval($length - strlen($dot) - $length / 3);
    $n      = $tn      = $noc      = 0;
    while ($n < strlen($string)) {
        $t = ord($string[$n]);
        if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
            $tn = 1;
            $n++;
            $noc++;
        } elseif (194 <= $t && $t <= 223) {
            $tn = 2;
            $n += 2;
            $noc += 2;
        } elseif (224 <= $t && $t <= 239) {
            $tn = 3;
            $n += 3;
            $noc += 2;
        } elseif (240 <= $t && $t <= 247) {
            $tn = 4;
            $n += 4;
            $noc += 2;
        } elseif (248 <= $t && $t <= 251) {
            $tn = 5;
            $n += 5;
            $noc += 2;
        } elseif ($t == 252 || $t == 253) {
            $tn = 6;
            $n += 6;
            $noc += 2;
        } else {
            $n++;
        }
        if ($noc >= $length) {
            break;
        }
    }
    if ($noc > $length) {
        $n -= $tn;
    }
    $strcut = substr($string, 0, $n);
    $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
    return $strcut . $dot;
}
/**
 * 字符截取
 * @param $str_cut 需要截取的字符串
 * @param $length 截取数量
 * @param $coding 编码格式 默认utf-8
 * @param $dot 截取后追加的省略符 默认...
 * @author mingyi
 */
function substr_cut($str_cut, $length, $coding = 'utf-8', $dot = '...')
{
    $un = mb_strlen($str_cut, $coding);
    if ($un > $length) {
        return mb_substr($str_cut, 0, $length, $coding) . $dot;
    } else {
        return $str_cut;
    }
}

/**
 * 下拉选择框
 */
function select($array = array(), $id = 0, $str = '', $default_option = '')
{
    $string .= '<select ' . $str . ' class="s-select" >';
    $default_selected = (empty($id) && $default_option) ? 'selected' : '';
    if ($default_option) {
        $string .= "<option value='' $default_selected>$default_option</option>";
    }

    foreach ($array as $key => $value) {
        $selected = $id == $key ? 'selected' : '';
        $string .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    $string .= '</select>';
    return $string;
}

/**
 * 复选框
 *
 * @param $array 选项 二维数组
 * @param $id 默认选中值，多个用 '逗号'分割
 * @param $str 属性
 * @param $defaultvalue 是否增加默认值 默认值为 -99
 * @param $width 宽度
 */
function checkbox($array = array(), $id = '', $str = '', $defaultvalue = '', $width = 0)
{
    $string = '<div class="checkbox">';
    if ($id != '') {
        $id = strpos($id, ',') ? explode(',', $id) : array($id);
    }

    foreach ($array as $key => $value) {
        $checked = ($id && in_array($key, $id)) ? 'checked' : '';
        if ($width) {
            $string .= '<span class="ib" style="width:' . $width . 'px"><label>';
        }

        $string .= '<input type="checkbox" ' . $str . ' ' . $checked . ' value="' . $key . '"> ' . $value;
        if ($width) {
            $string .= '  </label></span>';
        }
    }

    $string .= '</div>';
    return $string;
}

/**
 * 单选框
 *
 * @param $array 选项 二维数组
 * @param $id 默认选中值
 * @param $str 属性
 */
function radio($array = array(), $id = 0, $str = '')
{
    $string = '';
    foreach ($array as $key => $value) {
        $checked = $id == $key ? 'checked' : '';
        $string .= '<label class="radio-inline"><input type="radio" ' . $str . ' ' . $checked . ' value="' . $key . '"> ' . $value . '</label>';
    }
    return $string;
}

/**
 * 时间格式化
 * @param  [type]  $timestamp [description]
 * @param  integer $type      [description]
 * @return [type]             [description]
 */
function time_format($timestamp, $type = 0)
{
    if ($timestamp == 0) {
        return '';
    }

    $types    = array('Y-m-d H:i:s', 'Y-m-d H:i', 'Y-m-d');
    $difftime = SYS_TIME - $timestamp;
    if ($difftime < 5400) {
        $difftime = ceil($difftime / 60);
        return $difftime . '分钟前';
    } else {
        return date($types[$type], $timestamp);
    }
}

/**
 * 日历控件
 *
 * @param $name 控件name，id
 * @param $value 选中值
 * @param $datetype 为TRUE时，同时显示时间
 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
 * @param $showweek 是否显示周，使用，true | false
 */
function calendar($name, $hstr = '', $value = '', $datetype = false, $loadjs = false, $showweek = 'false')
{
    if ($value == '0000-00-00 00:00:00') {
        $value = '';
    }

    $id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
    if ($datetype) {
        $format   = '%Y-%m-%d %H:%M:%S';
        $showtime = 'true';
    } else {
        $format   = '%Y-%m-%d';
        $showtime = 'false';
    }
    $str   = '';
    $_lang = 'cn';

    if ($loadjs || !defined('CALENDAR_INIT')) {
        define('CALENDAR_INIT', 1);
        $str .= '<link rel="stylesheet" type="text/css" href="/resource/js/calendar/css/jscal2.css"/>
            <link rel="stylesheet" type="text/css" href="/resource/js/calendar/css/border-radius.css"/>
            <script type="text/javascript" src="/resource/js/calendar/jscal2.js"></script>
            <script type="text/javascript" src="/resource/js/calendar/lang/' . $_lang . '.js"></script>';
    }
    $str .= '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" ' . $hstr . ' >&nbsp;';
    $str .= '<script type="text/javascript">
            Calendar.setup({
            weekNumbers: ' . $showweek . ',
            inputField : "' . $id . '",
            trigger    : "' . $id . '",
            dateFormat: "' . $format . '",
            showTime: ' . $showtime . ',
            minuteStep: 1,
            onSelect   : function() {
                this.hide();
            }
            });
        </script>';
    return $str;
}

/**
 * 查找数组中是否存在某项，并返回指定的字符串，可用于检查复选，单选等
 * @param $id
 * @param $ids
 * @param string $returnstr
 * @return string
 */
function check_in($id, $ids, $returnstr = 'checked')
{
    if (in_array($id, $ids)) {
        return $returnstr;
    }
}

/**
 * 分页函数
 *
 * @param $num 信息总数
 * @param $current_page 当前分页
 * @param $pagesize 每页显示数
 * @param $urlrule URL规则
 * @param $variables url规则替换变量
 * @param $limit 显示分页数列
 * @param $params 自定义变量
 * @return 分页
 */
function pages($num, $current_page, $pagesize = 20, $urlrule = '', $variables = array(), $limit = 10, $params = array())
{
    $output   = '';
    $num      = intval($num);
    $pagesize = intval($pagesize);
    $maxpage  = ceil($num / $pagesize);
    if ($current_page > $maxpage) {
        $current_page = $maxpage;
    }

    if ($urlrule != '' && isset($_GET['_variables'])) {
        $urlrule = $_GET['_variables'];
    } elseif ($urlrule == '') {
        $par = 'page={$page}';

        if (is_array($params)) {
            foreach ($params as $k => $v) {
                $par = $par . '&' . $k . '=' . $v;
            }

        }
        $url = URL();

        $pos = strpos($url, '?');
        if ($pos === false) {

            $urlrule = $url . '?' . $par;

        } else {
            $querystring = substr(strstr($url, '?'), 1);
            parse_str($querystring, $pars);
            $query_array = array();
            foreach ($pars as $k => $v) {
                if ($k != 'page') {
                    $query_array[$k] = $v;
                }
            }

            $querystring = http_build_query($query_array) . '&' . $par;
            $urlrule     = substr($url, 0, $pos) . '?' . $querystring;
        }
    }

    //上一页
    $pageup = max(($current_page - 1), 1);
    $output .= '<li title="上一页"><a href="' . _pageurl($urlrule, $pageup, $variables) . '">上一页</a></li>';
    //第一页
    $active = '';
    if ($current_page == 1) {
        $active = 'class="active"';
    }

    $output .= '<li ' . $active . '><a ' . $active . ' href="' . _pageurl($urlrule, 1, $variables) . '">1</a></li>';

    $difference  = $limit + 1;
    $difference2 = ceil($limit / 2 - 1);

    $startpage = $current_page - $difference2;
    $endpage   = $current_page + $difference2;
    if ($difference >= $maxpage) {
        $startpage = 2;
        $endpage   = $maxpage - 1;
    } else {
        if ($startpage <= 1) {
            $endpage   = $difference - 1;
            $startpage = 2;
        } elseif ($endpage >= $maxpage) {
            $startpage = $maxpage - ($difference - 2);
            $endpage   = $maxpage - 1;
        }
        if ($current_page <= $difference2 + 1) {
            $endpage += 1;
        }

        if ($maxpage - $current_page <= $difference2) {
            $startpage -= 1;
        }
    }

    for ($i = $startpage; $i <= $endpage; $i++) {
        $active = '';
        if ($current_page == $i) {
            $active = 'class="active"';
        }

        $output .= '<li ' . $active . '><a href="' . _pageurl($urlrule, $i, $variables) . '" ' . $active . '>' . $i . '</a></li>';
    }
    //最后一页
    if ($maxpage > 1) {
        $active = '';
        if ($current_page == $maxpage) {
            $active = 'class="active"';
        }

        $output .= '<li ' . $active . '><a ' . $active . ' href="' . _pageurl($urlrule, $maxpage, $variables) . '">' . $maxpage . '</a></li>';
    }
    //下一页
    $pagedown = $current_page + 1;
    if ($pagedown >= $maxpage) {
        $pagedown = $maxpage;
    }

    //热键
    //$output .= '<input type="hidden" id="page-up" value="'._pageurl($urlrule, $pageup, $variables).'">';
    //$output .= '<input type="hidden" id="page-next" value="'._pageurl($urlrule, $pagedown, $variables).'">';
    //$output .= '<script>$(this).focus();</script>';

    $output .= '<li title="下一页"><a href="' . _pageurl($urlrule, $pagedown, $variables) . '">下一页</a></li>';

    return $output;
}
/**
 * 仅pages函数使用
 *
 * @param $urlrule 分页规则
 * @param $page 当前页
 * @param $variables
 * @return 完整的URL路径
 */
function _pageurl($urlrule, $page, $variables = array())
{
    if (strpos($urlrule, '|')) {
        $urlrules = explode('|', $urlrule);
        $urlrule  = $page < 2 ? $urlrules[0] : $urlrules[1];
    }

    $findme    = array('{$page}');
    $replaceme = array($page);
    if (is_array($variables)) {
        foreach ($variables as $k => $v) {
            $findme[]    = '{$' . $k . '}';
            $replaceme[] = $v;
        }
    }

    $url = str_replace($findme, $replaceme, $urlrule);
    return $url;
}

/**
 * 完整url链接
 * @return string
 */
function URL()
{
    $http_url = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    if (isset($_SERVER['HTTP_HOST'])) {
        $http_url .= $_SERVER['HTTP_HOST'];
    } else {
        $http_url .= $_SERVER["SERVER_NAME"];
    }
    if (isset($_SERVER['REQUEST_URI'])) {
        $http_url .= $_SERVER['REQUEST_URI'];
    } else {
        if (isset($_SERVER['PHP_SELF'])) {
            $http_url .= $_SERVER['PHP_SELF'];
        } else {
            $http_url .= $_SERVER['SCRIPT_NAME'];
        }
        if (isset($_SERVER['QUERY_STRING'])) {
            $http_url .= $_SERVER['QUERY_STRING'];
        } else {
            $http_url .= isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        }
    }
    return $http_url;
}

/**
 * url query string 参数去重
 * @param $url url
 * @return 仅返回querystring 去重后的结果
 */
function url_unique($url)
{
    $string    = parse_url($url, PHP_URL_QUERY);
    $string    = explode('&', $string);
    $new_array = array();
    foreach ($string as $str) {
        $str2 = explode('=', $str);
        if (isset($str2[1])) {
            $new_array[$str2[0]] = $str2[1];
        } else {
            $new_array[$str2[0]] = '';
        }
    }
    return http_build_query($new_array);
}

/**
 * 将多维数组转化为 key＝>value格式
 */
function key_value($array, $key, $value)
{
    if (empty($array)) {
        return '';
    }

    $arr = array();
    foreach ($array as $_value) {
        $arr[$_value[$key]] = $_value[$value];
    }
    return $arr;
}

/**
 * 过滤SQL关键字，mysql入库字段过滤
 */
function sql_replace($val)
{
    $val = str_replace("\t", '', $val);
    $val = str_replace("%20", '', $val);
    $val = str_replace("%27", '', $val);
    $val = str_replace("*", '', $val);
    $val = str_replace("'", '', $val);
    $val = str_replace("\"", '', $val);
    $val = str_replace("/", '', $val);
    $val = str_replace(";", '', $val);
    $val = str_replace("#", '', $val);
    $val = str_replace("--", '', $val);
    $val = addslashes($val);
    return $val;
}

/*
 *    重组图片缩略路径
 *    @Author ArPeng
 *    @Date 2015.4.13
 *    @Param String $src (图片路径)
 *    @Param Int $width (宽度)
 *    @Param Int $height (高度)
 *    return String
 */
function picThumbSrc($src = '', $width = 400, $height = 400)
{
    if (!$src) {
        return '';
    }
    $array  = pathinfo($src);
    $newSrc = $array['dirname'] . '/' . $array['filename'] . '_' . $width . '_' . $height . '.' . $array['extension'];
    return $newSrc;
}
/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
 * showmessage('登录成功', array('默认跳转地址'=>'http://www.yun-soft.com'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $backUrl 跳转地址
 * @param int $timeout 跳转等待时间
 */
function showmessage($msg, $backUrl = '', $timeout = 1250)
{
    include V('system', 'message');
    exit;
}

/**
 * 百度编辑器
 *
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function editor($name = 'content', $id = 'content', $value = '', $height = '400', $toolbars = 'normal', $UPpath = 'datums/content')
{
    // $name = 'content';
    if (!defined('IN_ADMIN')) {
        $toolbars = 'basic';
    }
    $defined = true;
    $str     = '';
    $str .= '<script id="' . $id . '" name="' . $name . '" type="text/plain">' . $value . '</script>';
    if (!defined('UEDITOR')) {
        define('UEDITOR', true);
        $str .= '<script type="text/javascript">var UPpath="' . $UPpath . '";</script>';
        $str .= '<script type="text/javascript" src="/resource/js/ueditor/ueditor.config.js?t=' . time() . '"></script>';
        $str .= '<script type="text/javascript" src="/resource/js/ueditor/ueditor.all.js?t=' . time() . '"></script>';
        $str .= '<script type="text/javascript" src="/resource/js/ueditor/kityformula/addKityFormulaDialog.js"></script>';
        $str .= '<script type="text/javascript" src="/resource/js/ueditor/kityformula/getKfContent.js"></script>';
        $str .= '<script type="text/javascript" src="/resource/js/ueditor/kityformula/defaultFilterFix.js"></script>';

    }

    $str .= '<script type="text/javascript">';

    $str .= 'var ' . $id . ' = UE.getEditor("' . $id . '", {';
    if ($toolbars == 'basic') {
        $str .= 'toolbars: [';
        $str .= "['fullscreen','source','bold','italic','underline','strikethrough','removeformat','formatmatch','forecolor','autotypeset','fontfamily','fontsize','indent','justifyleft','justifycenter','justifyright','justifyjustify','link','unlink','insertimage','inserttable','wordimage','attachment','kityformula']";
        $str .= '],';
    } elseif ($toolbars == 'normal') {
        $str .= 'toolbars: [';
        $str .= "[ 'fullscreen','source','bold', 'italic', 'underline',  'strikethrough', '|','removeformat', 'formatmatch', 'autotypeset', 'blockquote','pasteplain', '|', 'forecolor', 'insertorderedlist', 'insertunorderedlist', 'paragraph','fontfamily', 'fontsize', '|',  'indent','justifyleft', 'justifycenter', 'justifyright',  '|','link', 'unlink',  '|', 'insertimage', 'wordimage','kityformula','attachment']";
        $str .= '],';
    }
    $str .= 'autoHeightEnabled: false,';
    $str .= 'initialFrameHeight: ' . $height . ',';
    $str .= 'autoFloatEnabled: false';
    $str .= '});';
    $str .= '</script>';

    $str .= '<script type="text/javascript" src="/resource/js/ueditor/addCustomizeButton.js"></script>';
    return $str;
}

/**
 * 模板调用
 *
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function V($module = 'content', $template = 'index')
{
    $module         = str_replace('/', DIRECTORY_SEPARATOR, $module);
    $coreInit       = new coreInit();
    $template_cache = $coreInit->load('view', 'v'); //导入View

    $compiledtplfile = THEME_CACHE_PATH . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $template . TEMPLATE_CACHE_TYPE;

    $template_file = THEME_PATH . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $template . TEMPLATE_TYPE;
    if (file_exists($template_file)) {
        if (!file_exists($compiledtplfile) || (@filemtime($template_file) > @filemtime($compiledtplfile))) {

            $template_cache->template_compile($module, $template);
        }

    } else {
        $compiledtplfile = THEME_CACHE_PATH . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $template . TEMPLATE_CACHE_TYPE;
        if (!file_exists($compiledtplfile) || (file_exists($template_file) && filemtime($template_file) > filemtime($compiledtplfile))) {
            $template_cache->template_compile($module, $template);
        } elseif (!file_exists($template_file)) {
            InitPHP::initError($template_file_name . ' is not exist!');
            #showmessage('Template does not exist.'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.'.html');
        }
    }
    return $compiledtplfile;
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt = '')
{
    $pwd             = array();
    $pwd['encrypt']  = $encrypt ? $encrypt : create_randomstr();
    $pwd['password'] = md5(md5(trim($password)) . $pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6)
{
    return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}
/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function random($length, $chars = '0123456789')
{
    $hash = '';
    $max  = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}
/**
 * 重装URL
 * @author ArPeng
 * @date 2015.4.11
 * @param Int $siteId(站点ID)
 * @param String $m(文件夹名称)
 * @param String $c(文件名称)
 * @param String $a(方法名称)
 * @param Array $param(参数)
 * @return uri URL
 */
function U($siteId, $m = '', $c = '', $a = '', $param = array(), $isuri = false)
{
    //加载站点配置
    $dominlist = InitPHP::getConfig('siteDomin');
    if (is_string($siteId)) {
        $domain = $siteId;
    } elseif (is_int($siteId)) {
        $domain = $dominlist[intval($siteId)];
    } else {
        $domain = $_SERVER['HTTP_HOST'];
    }
    $m = urldecode($m);
    $c = urldecode($c);
    $a = urldecode($a);
    switch ($isuri) {
        case 'path':
            if (!empty($param) && is_array($param)) {
                foreach ($param as $k => $v) {
                    if (preg_match_all("/(?:%\w{2})+/", $val, $match)) {
                        $path .= '/' . urldecode($k) . '/' . urldecode($v);
                        //$query_array[urldecode($k)] = urldecode($v);
                    } else {
                        $path .= '/' . urldecode($k) . '/' . $v;
                        //$query_array[urldecode($k)] = $v;
                    }
                }
            } else if (is_string($param) && !empty($param)) {
                ltrim($param, '/');
                $path .= '/' . $param;
            } else {
                $path = '';
            }
            if ($m && $c && !$a) {
                $uri = 'http://' . $domain . '/' . $m . '/' . $c . '/init' . $path;
            } elseif ($m && !$c && !$a) {
                $uri = 'http://' . $domain . '/' . $m . '/index/init' . $path;
            } elseif (!$m && !$c && !$a) {
                $uri = 'http://' . $domain;
            } else {
                $uri = 'http://' . $domain . '/' . $m . '/' . $c . '/' . $a . $path;
            }
            break;

        default:
            if (!empty($param) && is_array($param)) {
                foreach ($param as $k => $v) {
                    if (preg_match_all("/(?:%\w{2})+/", $val, $match)) {
                        $query_array[urldecode($k)] = urldecode($v);
                    } else {
                        $query_array[urldecode($k)] = $v;
                    }
                }
                $querystring = '&' . http_build_query($query_array);
            } else if (is_string($param) && !empty($param)) {
                $querystring = '&' . $param;
            } else {
                $querystring = '';
            }
            if ($m && $c && !$a) {
                $uri = 'http://' . $domain . '/index.php?' . 'm=' . $m . '&c=' . $c . '&a=init' . $querystring;
            } elseif ($m && !$c && !$a) {
                $uri = 'http://' . $domain . '/index.php?' . 'm=' . $m . '&c=index&a=init' . $querystring;
            } elseif (!$m && !$c && !$a) {
                $uri = 'http://' . $domain;
            } else {
                $uri = 'http://' . $domain . '/index.php?' . 'm=' . $m . '&c=' . $c . '&a=' . $a . $querystring;
            }
            break;
    }

    return $uri;
}

/*
 *    前台分页
 *    @Author ArPeng
 *    @Date 2015.4.11
 *    @Param Int $total (数据总条数)
 *    @Param Int $offset (每页显示数量)
 *    @Param Int $limit (当前页码)
 *    @Param String $selected (选中样式)
 *    @Param String $class (节点样式)
 *    @Param String $url (连接)
 */
function page($total, $offset, $limit, $selected, $class = '', $url = '')
{
    //计算分页数量
    $pageTotal = ceil($total / $offset);
    $str       = '';
    if ($pageTotal > 1) {
        $str .= '<a class="' . $class . '" href="javascript:;">' . ($limit + 1) . '/' . $pageTotal . '</a>';
    }

    if ($limit > 0) {
        $str .= '<a class="' . $class . '" href="' . $url . '&page=0">首页</a><a class="' . $class . '" href="' . $url . '&page=' . ($limit - 1) . '">上一页</a>';

    }
    if ($pageTotal <= 10) {
        for ($i = 0; $i <= ($pageTotal - 1); $i++) {
            $uri     = '';
            $classes = '';
            $datas   = '';
            $uri     = $url != '' ? $url . '&page=' . $i : '&page=1';

            if ($i == $limit) {
                $classes = $class . ' ' . $selected;
            } else {
                $classes = $class;
            }
            //$datas = $data?$data.'="'.$i.'"':'';
            $str .= '<a class="' . $classes . '" href="' . $uri . '">' . ($i + 1) . '</a>';
        }
    } elseif ($pageTotal > 10) {
        if ($limit > 5) {
            for ($i = ($limit - 3); $i <= ($limit + 3); $i++) {
                $uri     = '';
                $classes = '';
                $datas   = '';
                $uri     = $url != '' ? $url . '&page=' . $i : '&page=1';

                if ($i == $limit) {
                    $classes = $class . ' ' . $selected;
                } else {
                    $classes = $class;
                }
                //$datas = $data?$data.'="'.$i.'"':'';
                $str .= '<a class="' . $classes . '" href="' . $uri . '">' . ($i + 1) . '</a>';
            }
        } else {
            for ($i = 0; $i <= 6; $i++) {
                $uri     = '';
                $classes = '';
                $datas   = '';
                $uri     = $url != '' ? $url . '&page=' . $i : '&page=1';

                if ($i == $limit) {
                    $classes = $class . ' ' . $selected;
                } else {
                    $classes = $class;
                }
                //$datas = $data?$data.'="'.$i.'"':'';
                $str .= '<a class="' . $classes . '" href="' . $uri . '">' . ($i + 1) . '</a>';
            }
        }
    }
    if ($limit < ($pageTotal - 1) && $total) {
        $str .= '<a class="' . $class . '" href="' . $url . '&page=' . ($limit + 1) . '">下一页</a><a class="' . $class . '" href="' . $url . '&page=' . ($pageTotal - 1) . '">尾页</a> ';

    }
    return $str;
}

/**
 * 判断string 是否为json [is_json description]
 * @param  [type]  $string [description]
 * @return boolean         [description]
 */
function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * 短信相关函数
 */

function sms_status($status = 0, $return_array = 0)
{
    $array = array(
        '0'   => '发送成功',
        '1'   => '手机号码非法',
        '2'   => '用户存在于黑名单列表',
        '3'   => '接入用户名或密码错误',
        '4'   => '产品代码不存在',
        '5'   => 'IP非法',
        '6 '  => '源号码错误',
        '7'   => '调用网关错误',
        '8'   => '消息长度超过60',
        '9'   => '发送短信内容参数为空',
        '10'  => '用户已主动暂停该业务',
        '11'  => 'wap链接地址或域名非法',
        '12'  => '5分钟内给同一个号码发送短信超过10条',
        '13'  => '短信模版ID为空',
        '14'  => '禁止发送该消息',
        '-1'  => '每分钟发给该手机号的短信数不能超过3条',
        '-2'  => '手机号码错误',
        '-11' => '帐号验证失败',
        '-10' => '接口没有返回结果',
    );
    return $return_array ? $array : $array[$status];
}
/**
 * 检查是否是手机号
 * @param  [type] $mobilephone [description]
 * @return [type]              [description]
 */
function checkmobile($mobilephone)
{
    $mobilephone = trim($mobilephone);
    if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[01236789]{1}[0-9]{8}$|18[01236789]{1}[0-9]{8}$/", $mobilephone)) {
        return $mobilephone;
    } else {
        return false;
    }

}

function get_smsnotice($type = '')
{
    $url     = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $urls    = base64_decode('aHR0cDovL3Ntcy5waHBpcC5jb20vYXBpLnBocD9vcD1zbXNub3RpY2UmdXJsPQ==') . $url . "&type=" . $type;
    $content = pc_file_get_contents($urls, 5);
    if ($content) {
        $content = json_decode($content, true);
        if ($content['status'] == 1) {
            return strtolower(CHARSET) == 'gbk' ? iconv('utf-8', 'gbk', $content['msg']) : $content['msg'];
        }
    }
    $urls    = base64_decode('aHR0cDovL3Ntcy5waHBjbXMuY24vYXBpLnBocD9vcD1zbXNub3RpY2UmdXJsPQ==') . $url . "&type=" . $type;
    $content = pc_file_get_contents($urls, 3);
    if ($content) {
        $content = json_decode($content, true);
        if ($content['status'] == 1) {
            return strtolower(CHARSET) == 'gbk' ? iconv('utf-8', 'gbk', $content['msg']) : $content['msg'];
        }
    }
    return '<font color="red">短信通服务器无法访问！您将无法使用短信通服务！</font>';
}
