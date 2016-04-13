<?php
/**
 * 财务管理
 * --分红记录
 * @Author: 刘波
 * @Date:   2016-01-11 00:59:45
 * @Last Modified time: 2016-01-11 01:08:50
 */
class shareController extends Controller
{
    private $db;
    private $status_arr;
    //Action白名单
    public $initphp_list = array(
        'init', //
        'copyit', //
    );

    public function __construct()
    {

    }
    /**
     * 支付列表
     */
    public function init()
    {
        //$ordergoodinfo = InitPHP::getRemoteService('orderGoods', 'lists', array('from_id=1', 1000, 0, 'og_id', 'desc', 'og_id', '*'));

        // foreach ($ordergoodinfo[0] as $val):
        //     echo '<a href="?m=pay&c=share&a=copyit&id=' . $val['order_id'] . '">' . $val['order_id'] . '</a><br>';
        // endforeach;
        // echo ';';
        // exit;
        $where = '';
        $type  = (int) $_GET['type'];
        switch ($type) {
            case '1':    //昨日
                $_starttime = strtotime("-1 day");
                $starttime  = strtotime(date("Y-m-d 00:00:00", $_starttime));
                $endtime    = strtotime(date("Y-m-d 23:59:59", $_starttime));
                $where      = 'pay_time between ' . $starttime . ' and ' . $endtime;
                break;
            case '2':    //今日
                $where = '';
                break;
            case '3':    //本月
                $where = '';
                break;
        }
        $page   = (int) $_GET['page'];
        $offset = 100;

        $limit = $page * $offset;
        $data  = InitPHP::getRemoteService('Bonus', 'lists', array($where, $limit, $offset));
        $info  = $data[0];
        $total = $data[1];
        $pages = pages($total, $page, $offset);
        include V('pay', 'share_init');
    }
    /**
     * [copyit description]
     * @return [type] [description]
     */
    public function copyit()
    {
        echo $id = (string) $_GET['id'];
        echo '<br>';
        $ordergoodinfo = InitPHP::getRemoteService('Bonus', 'CopyOrder', array($id));
        var_dump($ordergoodinfo);
    }

}
