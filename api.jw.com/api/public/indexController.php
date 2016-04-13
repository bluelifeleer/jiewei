<?php

/**
 * 一些公共的方法
 * @Author: 刘波
 * @description: 后台首页
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2015-12-24 12:02:27
 */
class indexController extends Controller
{
    
    //Action白名单
    public $initphp_list = array(
        'userQcode',//获得二维码
        'siteinfo',//获得二维码
    );
    public function __construct() {
        parent::__construct();
    }

    public function init(){
       $session = $this->getUtil('session');
       $session->set('a:a','aaa');
       $res = $session->get('a:a');
       var_dump($res); 
    }
    /**
     *二维码
     */
    public function userQcode() {
      
              // include_once INITPHP_PATH . '/library/phpqrcode/qrlib.php';
        
        //**************************//**************************
        // QRcode::png($text,$outfile,$level,$size,$margin,$saveandprint);
        // 参数$text表示生成二位的的信息文本；
        // 参数$outfile表示是否输出二维码图片 文件，默认否；
        // 参数$level表示容错率，也就是有被覆盖的区域还能识别，分别是
        //              L（QR_ECLEVEL_L，7%），
        //              M（QR_ECLEVEL_M，15%），
        //              Q（QR_ECLEVEL_Q，25%），
        //              H（QR_ECLEVEL_H，30%）；
        // 参数$size表示生成图片大小，默认是3；
        // 参数$margin表示二维码周围边框空白区域间距值；
        // 参数$saveandprint表示是否保存二维码并显示。
        //
        //
        //**************************//**************************
        $filePath = APP_PATH . 'codeImage' . DIRECTORY_SEPARATOR;
        
        $userid = intval($_GET['userid']);
        $isfile = file_exists($filePath . $userid . '.png');
        if(!$isfile){
            if (!file_exists($filePath))mkdir($filePath, true);
            if (!is_writable($filePath))chmod($filePath, 0777);
            $text = 'http://1592292869.qzone.qq.com/';
            QRcode::png($text, $filePath . $userid . '.png', 'H',5,2,true);
            QRtools::buildCache();
        }
        header("content-type: image/png");
        echo file_get_contents($filePath . $userid . '.png');
    }
}