<?php
/**
 * 财务管理
 * @Author: 刘波
 * @Date:   2016-01-11 00:59:45
 * @Last Modified time: 2016-01-11 01:08:50
 */
class indexController extends Controller {
    private $db;

    function __construct() {
   
    }
    /**
     * 支付列表
     */
    public function init() {
       
        include V('pay','pay_init');
    }
  
}