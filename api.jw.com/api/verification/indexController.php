<?php
class indexController extends Controller {
  public $initphp_list = array('get');
  public function __construct(){
    parent::__construct();
  }
  public function get(){
    $phone = $this->controller->get_get('phone');
    echo $phone;
  }
}
