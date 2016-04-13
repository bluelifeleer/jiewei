<?php
/**
 * 财务管理
 * --提现记录
 * @Author: 邵博
 * @Date:   2016-01-11 00:59:45
 * @Last Modified time: 2016-04-09 21:51:22
 */
class presentController extends Controller
{
    private $db;
    //Action白名单
    public $initphp_list = array(
        'init', //
        'confirm_success', //
        'confirm_success_no'
    );

    public function __construct()
    {
        parent::__construct();
        $this->userid = $userid = (int) $this->getUtil('session')->get('admin_userid');
        if ($userid) {
            $this->memberinfo = InitPHP::getRemoteService('admin', 'get', array($userid));
        }
        //判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }
    /**
     * 提现列表
     */
    public function init()
    {
        $where = '';
        $page   = (int) $_GET['page'];
        $offset = 100;

        $limit = $page * $offset;
        $data  = InitPHP::getRemoteService('presentManner', 'lists', array($where,$offset,$limit));
        $info  = $data[0];
        $total = $data[1];
        $is_success = array('1'=>'申请中','2'=>'不通过','99'=>'提现成功');
        $pages = pages($total, $page, $offset);
        include V('pay', 'present_manner_init');
    }
    /**
     * [回款操作]
     * @return [type] [description]
     */
    public function confirm_success()
    {
        $id = trim($_POST['id']);
        $userid = $_POST['userid'];
        $cash = trim($_POST['cash']);
        $where['payment_time'] = time();
        $usercash = InitPHP::getRemoteService('presentRecord','get_account',array($userid));
        $truecash = $usercash['amount'] - $cash;
        if($truecash < 0){
            echo jsonEncode(array(
                'code' => 400,
                'info' => '账户余额不够！',
            ));
            exit();  
        }
        $where['is_success'] = 99;
        $success = InitPHP::getRemoteService('presentManner', 'update', array($where,$id));
        if($success){
            InitPHP::getRemoteService('presentRecord','update_amount',array(array('amount'=>$truecash),array('userid'=>$userid)));

            echo jsonEncode(array(
                'code' => 200,
                'info' => '操作成功',
            ));
            exit();
        }else{
            echo jsonEncode(array(
                'code' => 300,
                'info' => '操作失败',
            ));
            exit();
        }
        //var_dump($ordergoodinfo);
    }

    /*
     *审核不通过操作
     */
    public function confirm_success_no(){
        $id = trim($_POST['id']);
        $where['payment_time'] = time();
        $where['is_success'] = 2;
        $success = InitPHP::getRemoteService('presentManner', 'update', array($where,$id));
        if($success){
            echo jsonEncode(array(
                'code' => 200,
                'info' => '审核不通过',
            ));
            exit();
        }else{
            echo jsonEncode(array(
                'code' => 300,
                'info' => '操作失败',
            ));
            exit();
        }
    }
}
