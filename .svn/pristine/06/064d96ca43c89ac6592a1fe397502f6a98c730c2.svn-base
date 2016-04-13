<?php
class indexController extends Controller {
  /**
   * 物流接口
   * @Author: 明艺
   * @Date:   2016-1-1 16:14:20
   * @Last Modified time: 2016-1-1 16:14:20
   */

  public $initphp_list = array(
    'lists'
  );

  public function __construct(){
    parent::__construct();
  }

  /**
   * 物流记录
   * @param $order_id 订单id
   * @return $logisticsList:json 添加结果
   * @author 明艺
   * @date 2016-1-1
   */
  public function lists(){
    $fileds = array(
      'order_id'
    );
    $where = $this->controller->get_gp($fileds);

    $logisticsList = InitPHP::getRemoteService('logistics', 'search', array($where));

    echo json_encode(array('code' => 200,'data' => $logisticsList));
  }
}