<?php
/**
 * @Author: anchen
 * @Date:   2016-01-04 11:41:15 提现方式增删改查
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-04-09 21:14:32
 * manner 是提现记录　record　是提现方式
 */
class indexController extends Controller
{
    public $initphp_list = array(
        'add_prerecords',
        'up_prerecords',
        'modify_prerecords',
        'del_prerecords',
        'show_prerecords',
        'def_prerecords',
        'get_prerecords',
        'get_def_add',
        'show_mannerlist',
        'add_mannerlist',
        'get_user_account'
   );

    private $session;
    public function __construct() {
        parent::__construct();
        $this->session = $this->getUtil('session');
    }
    /**
     * 显示多个提现方式
     * @return [type] [description]
     */
    public function show_prerecords(){
        $userid = $this->session->get('_userid');
        if(!$userid){
            InitPHP::Encode(1,'','');// no login
        }else{
            $userid = $userid;
        }
        $page = max(intval($_GET['page']),1);
        $page = $page - 1;
        $offset =  isset($_GET['offset']) ? intval($_GET['offset']) : 20;
        if(!$userid){
            $code = 1;
            $msg = '没有该用户';
            $data = array();
            InitPHP::Encode($code,$msg,$data);
            exit();
        }
        $where = array('userid' => $userid);
        $result = InitPHP::getRemoteService('presentRecord', 'lists', array($where,$offset,$page,'id','desc'));
       
        if($result[1] == 0){
            $code = 2;
            $msg = '请添加您的提现方式';
            $data = array();
            InitPHP::Encode($code,$msg,$data);
        }
        //var_dump($result);die;
        $return = array();
        if(is_array($result[0]))
        foreach ($result[0] as $key => $value) {
            $return["{$key}"] = $value;
        }
        $code = 0;
        $msg = '';
        $data = $return;
        InitPHP::Encode($code,$msg,$data);
    }
    //添加提现方式
    public function add_prerecords(){
        $userid = $this->session->get('_userid');
        $where['userid'] = $userid;
        $where['bank_name'] = trim($_POST['bank_name']);
        $where['bank_address'] = trim($_POST['bank_address']);
        $where['card_number'] = trim($_POST['card_number']);
        $where['contact_way'] = $_POST['contact_way'];
        $where['account_name'] = $_POST['account_name'];
        $where['defaultv'] = intval($_POST['defaultvalue']);
        //var_dump($where);die();
        if(empty($where['bank_name']) || empty($where['bank_address']) || empty($where['account_name']) || empty($where['contact_way'])|| empty($where['card_number']) || empty($where['userid'])) {
            $code = 1;
            $msg = '添加失败,请添加您的完整信息。';
            $data = '';
            InitPHP::Encode($code,$msg,$data);        
        }
        if($where['defaultv'] == 1){

            InitPHP::getRemoteService('presentRecord', 'update_filed', array(array('defaultv'=>0),array('userid'=>$userid)));
           
        }
        $result = InitPHP::getRemoteService('presentRecord', 'create', array($where));
        if($result){
            $code = 0;
            $msg = '添加成功';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }else{
            $code = 2;
            $msg = '添加失败';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        //$lists = InitPHP::getRemoteService('presentRecord', 'lists', array(array('userid'=>$where['userid'])));
        //var_dump($lists);die();
        // if($lists[1] < 20){
        //     
        //     if($where['defaultv'] == 1){
        //         InitPHP::getRemoteService('presentRecord','updateDef',array($result,$where['userid']));
        //     }
        //     $code = 0;
        //     $msg = '';
        //     $data = $result;
        //     InitPHP::Encode($code,$msg,$data);
        // }else{
        //     $code = 3;
        //     $msg = '您的提现方式已经达到上限。';
        //     $data = '';
        //     InitPHP::Encode($code,$msg,$data);
        // }
    }

    public function up_prerecords(){
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少用户';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }  
        $data = InitPHP::getRemoteService('presentRecord','get',array(array('id'=>$aid)));
        if($data){
            $code = 0;
            $msg = '';
        }else{
            $code = 2;
            $msg = '显示失败';
            $data = '';
        }
        InitPHP::Encode($code,$msg,$data);
    }

    public function modify_prerecords(){
        $aid = intval($_POST['aid']);

        $userid = $this->session->get('_userid');
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少用户';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        $where['bank_name'] = trim($_POST['bank_name']);
        $where['bank_address'] = trim($_POST['bank_address']);
        $where['card_number'] = trim($_POST['card_number']);
        $where['contact_way'] = trim($_POST['contact_way']);
        $where['account_name'] = trim($_POST['account_name']);
        $data = InitPHP::getRemoteService('presentRecord','update',array($where,$aid));
       
        if($data){
            $code = 0;
            $msg = '';
        }else{
            $code = 2;
            $msg = '显示失败';
            $data = '';
        }
        InitPHP::Encode($code,$msg,$data);
    }


    public function del_prerecords(){
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少id';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        $data = InitPHP::getRemoteService('presentRecord','delete',array(array('id'=>$aid)));
        if($data){
            $code = 0;
            $msg = '删除成功';
        }else{
            $code = 2;
            $msg = '删除失败';
            $data = '';
        }
        InitPHP::Encode($code,$msg,$data);
    }

    public function def_prerecords(){
        $userid = $this->session->get('_userid');
        // if(!$userid){
        //     InitPHP::Encode(1,'','');// no login
        // }else{
        //     $userid = $userid;
        // }
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少id';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        $defaultvalue = intval($_POST['defaultvalue']);
        if($defaultvalue == 1){
            InitPHP::getRemoteService('presentRecord','updateDef',array($aid,$userid));
            $data = InitPHP::getRemoteService('presentRecord','update',array(array('defaultv'=>1),$aid));
            if($data){
                $code = 0;
                $msg = '修改成功';
            }else{
                $code = 2;
                $msg = '修改失败';
                $data = '';
            }
            $a = InitPHP::Encode($code,$msg,$data);
        }else{
            $data = InitPHP::getRemoteService('presentRecord','update',array(array('defaultv'=>0),$aid));
            if($data){
                $code = 0;
                $msg = '修改成功';
            }else{
                $code = 2;
                $msg = '修改失败';
                $data = '';
            }
            InitPHP::Encode($code,$msg,$data);
        }
    }

    /**
     * 根据usrid 获取收货地址
     * @link http://api.jw.com/address/index/get_address/userid/1
     */
    public function get_prerecords(){
       $userid = $this->session->get('_userid');

       if(empty($userid)){
        $code = 1;
        $msg = '参数错误';
        $data = '';
        InitPHP::Encode($code,$msg,$data);
        exit();
       }

       $data = InitPHP::getRemoteService('presentRecord','lists',array(array('userid'=>$userid,'defaultv'=>1)));

       if($data[1]>0){
            foreach ($data[0] as $value) {
                $data = $value;
            }
            $code = 1;
            $msg = '默认方式';
            $data = $data;
            InitPHP::Encode($code,$msg,$data);
            exit();
       }

       $data = InitPHP::getRemoteService('presentRecord','lists',array(array('userid'=>$userid)));

       if($data[1]>0){
            foreach ($data[0] as $value) {
                $data = $value;
            }
            $code = 2;
            $msg = '选择方式';
            $data = $data;
            InitPHP::Encode($code,$msg,$data);
            exit();
       }

    }

    /**
     * 获取默认提现方式
     * http://api.jw.com/address/index/get_def_add
     */

    public function get_def_add()
    {
         $userid = $this->session->get('_userid');
         $where['userid'] = $userid;
         $where['defaultv'] = 1;
         $data = InitPHP::getRemoteService('presentRecord','get',array($where));
         //var_dump($data);die();
         if(count($data)>0){
              $code = 0;
              $msg = '默认提现方式';
              $data = $data;
              InitPHP::Encode($code,$msg,$data);
              exit();
         }else{
             $code = 1;
             $msg = '无提现方式';
             $data = '';
             InitPHP::Encode($code,$msg,$data);
             exit();
         }

    }


    /*
     *获取提现记录列表
     */
    public function show_mannerlist(){
        $userid = $this->session->get('_userid');
        if(!$userid){
            InitPHP::Encode(1,'','');// no login
        }
        $page = max(intval($_GET['page']),1);
        $page = $page - 1;
        $offset =  isset($_GET['offset']) ? intval($_GET['offset']) : 20;
        if(!$userid){
            $code = 1;
            $msg = '没有该用户';
            $data = array();
            InitPHP::Encode($code,$msg,$data);
            exit();
        }
        $where = array('userid' => $userid);
        $data = InitPHP::getRemoteService('presentManner','lists',array($where,$offset,$page,'apply_time','desc'));
        foreach ($data[0] as $key => $value) {
            $data[0][$key]['apply_time'] = date('Y-m-d',$value['apply_time']);
        }
        $return = array();
        if(is_array($data[0])){
            foreach ($data[0] as $key => $value) {
                $return["{$key}"] = $value;
            }
        }
        $code = 0;
        $msg = '';
        $data = $return;
        InitPHP::Encode($code,$msg,array_values($data));
    }

    /**
     * 添加提现记录
     */
    public function add_mannerlist(){
        $userid = $this->session->get('_userid');
        if(!$userid){
            $msg = '您未登录,请重新登录!';
            InitPHP::Encode(1,$msg,'');
        }
        $value = array('record_id','cash');
        $data = $this->controller->get_gp($value);
       
        $apply = InitPHP::getRemoteService('presentManner','sum_appleying',array($userid));
        if($apply){
            $apply_amount = $data['cash'] + $apply;
        }else{
            $apply_amount = $data['cash'] ;
        }
       
        $cash = InitPHP::getRemoteService('presentRecord','getWallet',array($userid,$apply_amount));

        if(!$cash){
            $msg = '您的金额不够提现!';
            InitPHP::Encode(2,$msg,'');
        }
        
        
        $where['record_id'] = $data['record_id'];
        $record_info = InitPHP::getRemoteService('presentRecord','get',array(array('id'=>$where['record_id'])));
        if(count($record_info) != 0){
            $where['bank_name'] = $record_info['bank_name'];
            $where['card_number'] = $record_info['card_number'];
            $where['account_name'] = $record_info['account_name'];
            $where['bank_address'] = $record_info['bank_address'];
        }else{
            return false;
        }
        $where['cash'] = $data['cash'];
        $where['userid'] = $userid;
        $where['apply_time'] = time();
        $where['is_success'] = 1;
        $data = InitPHP::getRemoteService('presentManner','create',array($where));
        if($data){
            $code = 0;
            $msg = '申请成功！';
        }else{
            $code = 3;
            $msg = '申请失败！';
            $data = '';
        }
        InitPHP::Encode($code,$msg,$data);
    }

    /**
     * 
     */
    public function get_user_account(){
        $userid = $this->session->get('_userid');
        $data = InitPHP::getRemoteService('presentRecord','get_account',array($userid));
        if($data){
            $apply = InitPHP::getRemoteService('presentManner','sum_appleying',array($userid));
            if($apply){
                $data['apply_amount_frozen'] = $apply;
                $data['apply_amount'] = $data['amount']-$apply;
            }
            $code = 0;
            $msg = '查询成功！';
        }else{
            $code = 3;
            $msg = '查询失败！';
            $data = '';
        }
        InitPHP::Encode($code,$msg,$data);
    }
}