<?php
/**
 * @Author: anchen
 * @Date:   2016-01-04 11:41:15
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-10 18:46:29
 */
class indexController extends Controller
{
    public $initphp_list = array(
        'add_address',
        'up_address',
        'modify_address',
        'del_address',
        'show_address',
        'def_address',
        'get_address',
        'get_def_add'
   );

    private $session;
    public function __construct() {
        parent::__construct();
        $this->session = $this->getUtil('session');
    }
    /**
     * 显示多个收货地址
     * @return [type] [description]
     */
    public function show_address(){
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
        $result = InitPHP::getRemoteService('address', 'lists', array($where,$page,$offset,'defaultv','asc'));
       
        if($result[1] == 0){
            $code = 2;
            $msg = '请添加您的收货地址';
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

    public function add_address(){
        $userid = $this->session->get('_userid');
        $where['userid'] = $userid;
        $where['mobile'] = trim($_POST['mobile']);
        $where['ship_data'] = trim($_POST['ship_data']['name']);
        $where['detail_address'] = trim($_POST['daddress']);
        $where['username'] = trim($_POST['username']);
        $where['code'] = trim($_POST['code']);
        $where['defaultv'] = intval($_POST['defaultvalue']);
        //var_dump($where);die();
        if(empty($where['mobile']) || empty($where['ship_data']) || empty($where['detail_address']) || empty($where['username']) || empty($where['userid'])) {
            $code = 1;
            $msg = '添加失败';
            $data = '';
            InitPHP::Encode($code,$msg,$data);        
        }
        $lists = InitPHP::getRemoteService('address', 'lists', array(array('userid'=>$where['userid'])));
        if($lists[1] < 20){
            $result = InitPHP::getRemoteService('address', 'create', array($where));
            if(!$result){
                $code = 2;
                $msg = '添加失败';
                $data = '';
                InitPHP::Encode($code,$msg,$data);
            }
            if($where['defaultv'] == 1){
                InitPHP::getRemoteService('address','updateDef',array($result,$where['userid']));
            }
            $code = 0;
            $msg = '';
            $data = $result;
            InitPHP::Encode($code,$msg,$data);
        }else{
            $code = 3;
            $msg = '您的收货地址已经达到上限。';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
    }

    public function up_address(){
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少用户';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }  
        $data = InitPHP::getRemoteService('address','get',array('id'=>$aid));
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

    public function modify_address(){
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少用户';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        $where['mobile'] = trim($_POST['mobile']);
        $where['ship_data'] = trim($_POST['ship_data']['name']);
        $where['detail_address'] = trim($_POST['daddress']);
        $where['username'] = trim($_POST['username']);
        $where['code'] = trim($_POST['code']);
        $data = InitPHP::getRemoteService('address','update',array($where,'id'=>$aid));
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


    public function del_address(){
        $aid = intval($_POST['aid']);
        if (empty($aid)) {
            $code = 1;
            $msg = '缺少id';
            $data = '';
            InitPHP::Encode($code,$msg,$data);
        }
        $data = InitPHP::getRemoteService('address','delete',array('id'=>$aid));
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

    public function def_address(){
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
            InitPHP::getRemoteService('address','updateDef',array($aid,$userid));
            $data = InitPHP::getRemoteService('address','update',array(array('defaultv'=>1),'id'=>$aid));
            if($data){
                $code = 0;
                $msg = '修改成功';
            }else{
                $code = 2;
                $msg = '修改失败';
                $data = '';
            }
            InitPHP::Encode($code,$msg,$data);
        }else{
            $data = InitPHP::getRemoteService('address','update',array(array('defaultv'=>0),'id'=>$aid));
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
    public function get_address(){
       $userid = $this->session->get('_userid');

       if(empty($userid)){
        $code = 1;
        $msg = '参数错误';
        $data = '';
        InitPHP::Encode($code,$msg,$data);
        exit();
       }

       $data = InitPHP::getRemoteService('address','lists',array(array('userid'=>$userid,'defaultv'=>1)));

       if($data[1]>0){
            foreach ($data[0] as $value) {
                $data = $value;
            }
            $code = 1;
            $msg = '默认地址';
            $data = $data;
            InitPHP::Encode($code,$msg,$data);
            exit();
       }

       $data = InitPHP::getRemoteService('address','lists',array(array('userid'=>$userid)));

       if($data[1]>0){
            foreach ($data[0] as $value) {
                $data = $value;
            }
            $code = 2;
            $msg = '选择地址';
            $data = $data;
            InitPHP::Encode($code,$msg,$data);
            exit();
       }

    }

    /**
     * 获取默认地址
     * http://api.jw.com/address/index/get_def_add
     */

    public function get_def_add()
    {
         $userid = $this->session->get('_userid');

         
         $data = InitPHP::getRemoteService('address','lists',array(array('userid'=>$userid,'defaultv'=>1)));

         if($data[1]>0){
              foreach ($data[0] as $value) {
                  $data = $value;
              }
              $code = 0;
              $msg = '默认地址';
              $data = $data;
              InitPHP::Encode($code,$msg,$data);
              exit();
         }else{
             $code = 1;
             $msg = '没默认地址';
             $data = '';
             InitPHP::Encode($code,$msg,$data);
             exit();
         }

    }

    
}