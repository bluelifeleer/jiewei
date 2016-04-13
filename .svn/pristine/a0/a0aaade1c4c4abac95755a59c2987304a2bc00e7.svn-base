<?php

/**
 * @Author: sseaven
 * @description: 平台商城广告管理
 * @Date: 2015-12-22
 *
 */

class indexController extends Controller
{
	// Action白名单
	public $initphp_list = array(
	    'lists',
	    'create',
	    'edit',
	    'edit',
	    'delete'
	);

	public function __construct()
	{
	    parent::__construct();
	    $this->userid = $userid = (int) $this->getUtil('session')->get('admin_userid');
	    if ($userid) {
	        $this->memberinfo = InitPHP::getRemoteService('admin', 'get', array(
	            $userid
	        ));
	    }
	    // 判断是否登入状态
	    InitPHP::getService("admin")->check_admin();
	}

	/////////////////
	//----列表------ //
	/////////////////
	public function lists()
	{
		$where = array();
		$offset = 15;
		$page = max((int) $_GET['page'], 1);
		$limit = ($page - 1) * $offset;
		$order = 'id';
		$sort = 'desc';
		$lists = InitPHP::getRemoteService('shopAdvert','lists',array($where,$offset,$limit,$order,$sort));
		$info = array();
		$tatol = 0;
		if ($lists['code'] == 0) {
		    $info = $lists['data'][0];
		    foreach ($info as $key => $value) {
		    	$where['userid'] = $value['userid'];
		    	$res = InitPHP::getRemoteService('shop','get',array($where));
		    	$info[$key]['shopName'] = '店铺不存在';
		    	if($res)
		    	    $info[$key]['shopName'] = $res['name'] ;
		    }
		    $tatol = $lists['data'][1];
		}


		$pages = pages($tatol, $page, $offset);

		include V('shopAdvert', 'list');
	}
	////////////////////
	// -----新建------- //
	////////////////////
	public  function create(){

		$fileds = array(
		    'id',
		    'userid',
		    'title',
		    'link',
		    'enabled',
		    'images'
		);

		if (intval($_POST['dosubmit']) > 0) {
			$data_gp = $this->controller->get_gp($fileds);
			//$data = array_filter($data_gp);

			 $where = $data_gp;
			 $where['images'] = $data['images'][0];

			 // 保存到数据库
			 $Res = InitPHP::getRemoteService('shopAdvert', 'create',array($where));
			 if ($Res) {
			     showmessage('添加成功', '/index.php?m=shopAdvert&c=index&a=lists');
			 } else {
			     showmessage('添加失败','/index.php?m=shopAdvert&c=index&a=create');
			 }
		}else{
			$enabledArr = $this->getEnabled();
			$shopList = $this->getShop();


			
			include V('shopAdvert', 'create');
		}
		
	}




	////////////////////////////
	//--------编辑------------- //
	////////////////////////////
	public function edit(){

		$fileds = array(
		    'id'
		);
		$data_gp = $this->controller->get_gp($fileds);
		$data = array_filter($data_gp);

		$enabledArr = $this->getEnabled();
		$shopList = $this->getShop();

		$where = $data;

		 $info = InitPHP::getRemoteService('shopAdvert', 'get', array(
            $where
        ));


		  if (intval($_POST['dosubmit']) > 0) {
		  	$fileds = array(
		  	    'id',
		  	    'userid',
		  	    'title',
		  	    'link',
		  	    'enabled',
		  	    'images'
		  	);

		  	$data = $this->controller->get_gp($fileds);
		  	//$data = array_filter($data_gp);
		  	$where = $data;
		  	$where['images'] = $data['images'][0];
		  	$updateWhere['id'] = $data['id']; // 更新数据的ｉｄ

		  	// 保存到数据库
		  	$Res = InitPHP::getRemoteService('shopAdvert', 'update', array($where,$updateWhere));

		  	if ($Res) {
		  	    showmessage('更新成功', '/index.php?m=shopAdvert&c=index&a=lists');
		  	} else {
		  	    showmessage('更新失败','/index.php?m=shopAdvert&c=index&a=edit&id='.$data['id']);
		  	}

		  }

		  include V('shopAdvert', 'edit');
	}

	
	////////////////////
	//-----获取产品等级列表信息 //
	////////////////////
	public function getShop(){
	    $shopList = array();
	    $shopListRes = InitPHP::getRemoteService('shop', 'lists', array(
	        array(),
	        2000,
	        0,
	        'userid',
	        'asc'
	    ));

	    if($shopListRes[1] > 0){
	        $shopListInfo = $shopListRes[0];
	        foreach ($shopListInfo as $r) {
	            $shopList[$r['userid']] = $r['name'];
	        }
	    }
	    return $shopList;
	}


	////////////////////////////
	// ------- 删除--------÷  　 //
	////////////////////////////
	
	public function delete()
	{
	    $fileds = array(
	        'ids'
	    );
	    $data_gp = $this->controller->get_gp($fileds);
	    $data = array_filter($data_gp);
	    $ids = $data['ids'];
	    if (isset($ids) && $ids != '')
	        $where = explode(",", $data['ids']);
	    else
	        $where = array();

	    $Res = InitPHP::getRemoteService('shopAdvert', 'delete', array(
	        $where
	    ));

	    if ($Res) {
	        echo jsonEncode(array(
	            'code' => 200,
	            'info' => '删除成功'
	        ));
	        exit();
	    } else {
	        echo jsonEncode(array(
	            'code' => 300,
	            'info' => '操作失败'
	        ));
	        exit();
	    }
	}

	////////////////
	//-----是否显示状态数组 //
	////////////////
	private function getEnabled(){
	  $enabled = array('1'=>'显示','2'=>'不显示');
	  return $enabled;
	}
}