<?php
/**
 * 
 * @authors Seaven (seavenoo@sina.com)
 * @date    2016-03-09 12:07:36
 * @version $Id$
 */

class indexController extends Controller
{
	//Action白名单
	 public $initphp_list = array(
        'lists',
        'create',
        'success',
    );

	   public function  __construct(){
        parent::__construct();
        $this->userid = $userid = (int)$this->getUtil('session')->get('admin_userid');
        if ($userid) {
            $this->memberinfo = InitPHP::getRemoteService('admin', 'get', array($userid));
        }
        //判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }

    //lists
     public function lists() {

     	$fileds = array(
     	);
     	$data = $this->controller->get_gp($fileds);
     	$data = array_filter($data);
     	$where = $data;
     	$offset = 15000;
     	$page = max((int) $_GET['page'], 1);
     	$limit = ($page - 1) * $offset;
     	$order = 'id';
     	$sort = 'desc';

     	$lists = InitPHP::getRemoteService('iconManage','lists',array($where,$limit,$offset,$order,$sort));

     	
     	$info = array();
     	$tatol = 0;
     	if ($lists['code'] == 0) {
     	    $info = $lists['data'][0];
     	    $tatol = $lists['data'][1];
     	}

     	include V('iconManage', 'list');
     }

     //create 
     public function create(){
     	$fileds = array(
                'name',
                'desc',
                'path'
            );
        $data_gp = $this->controller->get_gp($fileds);
        $data = array_filter($data_gp);

        $createRes = initPHP::getRemoteService('iconManage', 'create', array($data));


        if($createRes){
            echo jsonEncode(array('code' => 200, 'info' => '添加成功'));
            exit();
        }else{
            echo jsonEncode(array('code' => 300, 'info' => '更新失败'));
            exit();
        }

     }

     /**
      * 成功页面
      */
     public function success(){
        showmessage('添加成功', '/index.php?m=iconManage&c=index&a=lists');
     }
}