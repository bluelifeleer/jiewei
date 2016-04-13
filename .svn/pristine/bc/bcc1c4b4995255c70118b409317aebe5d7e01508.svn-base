<?php
/**
 * @Author: seaven
 * @Date:   2015-12-31 15:30:33
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-04-07 11:20:13
 */


class indexController extends Controller
{
	//Action  白名单
	 public $initphp_list = array('getSearchRes');
	 //初始化继承父类
	 private $session;
	 public function __construct() {
	      parent::__construct();
	      $this->session = $this->getUtil('session');
	 }

	 /**
	  * 返回产品搜索结果
  	  * @link http://api.jw.com/search/index/getSearchRes/siteid/1
   	  * @return [json] [json数据]
	  */
	 public function getSearchRes(){
	 	$fields = array('siteid','keywords');
	    $data_gp = $this->controller->get_gp($fields);
	    $data = array_filter($data_gp);
	    // $where = $data;
	    
	    if($data['siteid'] != 1){
	    	// 如果是分站的产品
	    	$idwhere['userid'] = $data['siteid'];
		    //调用产品服务list
		   
		    $idres = InitPHP::getRemoteService('product', 'indexLists', array(
		        $idwhere,
		        1500
		        
		    ));
			
		    foreach ($idres['data'][0] as $idkey => $idvalue) {
		    	if(isset($idvalue['fromid']) && $idvalue['fromid'] > 0 ){
		    		$ids[$idkey] = $idvalue['fromid'];
		    	}else{
		    		$ids[$idkey] = $idvalue['id'];
		    	}
		    }
		    $idss = array_keys(array_flip($ids));
		   $where['id'] = $idss;
	    }else{

	    	$where['userid'] = $data['siteid'];
	    	$where['sysadd'] = 1;
	    }
	    // unset($where['siteid']);
	    //is_recycled = 1存在仓库中 99 存在于回收站
	    $where['is_up'] = 99;
	    $where['title'] = array('like' => '%'.$data['keywords'].'%');
	    // unset($where['keywords']);
	    //分页量
	    $offset = $_GET['offset'];
	    //页码
	    $page = max((int) $_GET['pages'], 1);
	    //sql limit 限制
	    $limit = ($page - 1) * $offset;
	    //排序字段
	    $order = 'id';
	    //排序方式
	    $sort = 'desc';
	    //调用产品服务list
	    $res = InitPHP::getRemoteService('product', 'lists', array(
	        $where,
	        $offset,
	        $limit,
	        $order,
	        $sort,
	        'id,title,thumb,sale_price,sales'
	    ));

	    $total = '0';
	    $code = '0';
	    if($res['code'] == 0){
	        $info = $res['data'][0];
	        $total = $res['data'][1];
	        $code = '1';
	    }
	    foreach ($info as $key => $value) {
	      $info[$key]['thumb'] = picThumbSrc($value['thumb'], 200, 200);
	    }
	    if(empty($info)) $code = '0';
	    $echoJson = array('code'=>$code,'data'=>$info,'total'=>$total);

	    //输出json数据
	    echo jsonEncode($echoJson);
	    exit();


	 }
}