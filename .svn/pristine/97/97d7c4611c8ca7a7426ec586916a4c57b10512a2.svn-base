<?
class indexController extends Controller{
	public $initphp_list = array('lists','detail');

	public function __construct(){
		parent::__construct();
	}

	public function init(){

	}


	public function lists(){
		$value = array('type');
		$data = $this->controller->get_gp($value,'G');
		switch(trim($data['type'])){
			case 'new' ://最新消息
				$mesgCollections = InitPHP::getRemoteService('message','lists',array(array('to_userid' => '1', 'type'=>1, 'is_read' => '')));
				$title = '最新消息';
			break;
			case 'not_read' ://未读消息
				$mesgCollections = InitPHP::getRemoteService('message','lists',array(array('to_userid' => '1', 'type'=>1, 'is_read' => 0)));
				$title = '未读消息';
			break;
			case 'is_read' ://已读消息
				$mesgCollections = InitPHP::getRemoteService('message','lists',array(array('to_userid' => '1', 'type'=>1, 'is_read' => 1)));
				$title = '已读消息';
			break;
			default ://全部消息
				$mesgCollections = InitPHP::getRemoteService('message','lists',array(array('to_userid' => '1', 'type'=>1)));
				$title = '全部消息';
			break;
		}

		if($mesgCollections['code'] == 0){
			$lists = $mesgCollections['data'][0];
		}else{
			$lists = '没有消息';
		}

		include V('message','lists');
	}




	public function detail(){
		$value = array('id');
		$data = $this->controller->get_gp($value,'G');

		$msg = InitPHP::getRemoteService('message','get',array(array('id' => $data['id'])));

		include V('message','detail');
	}
}