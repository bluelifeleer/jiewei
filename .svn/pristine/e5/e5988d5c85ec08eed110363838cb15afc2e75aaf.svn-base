<?php
/**
 * 财务管理
 * --分红记录
 * @Author: 刘波
 * @Date:   2016-01-11 00:59:45
 * @Last Modified time: 2016-01-11 01:08:50
 */
class spendController extends Controller {
    private $db;
    private $status_arr;
    //Action白名单
    public $initphp_list = array(
        'init',//
        'manage',//
        'recycleManage',//
        'left',//
        'listing',//
        'recycleLists',//
        );
  
    function __construct() {
    
    }
    /**
     * 支付列表
     */
    public function init() {
        
        include V('pay','spend_init');
    }
   
}