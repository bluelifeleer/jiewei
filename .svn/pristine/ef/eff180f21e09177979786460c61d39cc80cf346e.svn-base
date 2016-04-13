<?php

/**
 * @Author: 翁昌华
 * @description: 红包管理
 * @Date: 2015-12-22
 *
 */
class indexController extends Controller
{
    // Action白名单
    public $initphp_list = array(
        'init',
        'lists',
        'create',
        'edit',
        'success',
        'delete',
        'detail',
        'createRedpacket'
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

    /**
     * 红包管理主页面
     */
    public function init()
    {
        include V('redPacket', 'init');
    }

    /**
     * 红包详情
     */
    public function detail()
    {

        include V('redPacket','detail');
    }
    /**
     * 新建红包
     */
    public function createRedpacket(){
        include V('redPacket','createRedpacket');
    }

    /**
     * 红包列表
     */
    public function lists()
    {
        $fileds = array(
            'userid',
            'pro_id',
            'status',
            'type'
        );
        $data = $this->controller->get_gp($fileds);
        $data = array_filter($data);
        $where = $data;
        $offset = 15;
        $page = max((int) $_GET['page'], 1);
        $limit = ($page - 1) * $offset;
        $order = 'id';
        $sort = 'desc';

        $lists = InitPHP::getRemoteService('redPacket','lists',array($where,$offset,$limit,$order,$sort));

        $info = array();
        $tatol = 0;
        if ($lists['code'] == 0) {
            $info = $lists['data'][0];
            $tatol = $lists['data'][1];
        }

        $useType = $this->getUsetype();
        $typeArr = $this->getType();
        $statusArr = $this->getStatus();

        $pages = pages($tatol, $page, $offset);

        include V('redPacket', 'list');
    }

    /**
     * 创建红包
     */
    public function create()
    {

        $fileds = array(
            'id',
            'red_no',
            'title',
            'remark',
            'amount',
            'addtime',
            'endtime',
            'userid',
            'status',
            'admin_note',
            'type',
            'pro_id',
            'number'

        );
        if (intval($_POST['dosubmit']) > 0) {
            $data_gp = $this->controller->get_gp($fileds);
            $data = array_filter($data_gp);
            $where = $data;
            unset($where['number']);
            $where['addtime'] = time();
            $where['status'] = 0; //0 未分发，1 已分发，2 已激活，3已使用
            // 保存到数据库
            $Res = InitPHP::getRemoteService('redPacket', 'transactionCreate',array($where,$data['number']));
            if ($Res) {
                showmessage('添加成功', '/index.php?m=redPacket&c=index&a=lists');
            } else {
                showmessage('添加失败','/index.php?m=redPacket&c=index&a=create&type='.$data['type']);
            }
        } else {
           $fileds = array('type');
           $data_gp = $this->controller->get_gp($fileds);
           $data = array_filter($data_gp);

           $type = $data['type'];

           if(!isset($type) && $type == '')   showmessage('参数错误', '/index.php?m=redPacket&c=index&a=lists');

           $useType = $this->getUsetype();
           include V('redPacket', 'create');
        }

    }

    /**
     * 编辑红包信息
     */
    public function edit()
    {
        $fileds = array(
            'id',
            'type'
        );
        $data_gp = $this->controller->get_gp($fileds);
        $data = array_filter($data_gp);
        $id = $data['id'];
        $type = $data['type'];
        if(!isset($id) && $id == '' && isset($type) && $type == '')   showmessage('参数错误', '/index.php?m=redPacket&c=index&a=lists');

        $where = $data;
        $info = InitPHP::getRemoteService('redPacket', 'get', array(
            $where
        ));
        $useType = $this->getUsetype();
        $typeArr = $this->getType();
        $statusArr = $this->getStatus();

        $pro_id = $info['pro_id'];
        if(isset($pro_id) && $pro_id != '') {
          $res = InitPHP::getRemoteService('product','get',array(array('id'=>$pro_id)));
          $title =$res['title'];
        }
        if (intval($_POST['dosubmit']) > 0) {
          $fileds = array(
              'id',
              'red_no',
              'title',
              'remark',
              'mount',
              'endtime',
              'admin_note',
              'pro_id'
          );
            $data_gp = $this->controller->get_gp($fileds);
            $data = array_filter($data_gp);
            $updateWhere['id'] = $data['id']; // 更新数据的ｉｄ

            // 保存到数据库
            $Res = InitPHP::getRemoteService('redPacket', 'update', array($data,$updateWhere));

            if ($Res) {
                showmessage('更新成功', '/index.php?m=redPacket&c=index&a=lists');
            } else {
                showmessage('更新失败','/index.php?m=redPacket&c=index&a=edit&id='.$data['id']);
            }
        }
       include V('redPacket', 'edit');
    }

    /**
     * 删除　
     */
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

        $Res = InitPHP::getRemoteService('redPacket', 'delete', array(
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
    /**
     * 获取使用限制
     */
    private function getUsetype(){
      $userType = array('1'=>'仅能使用一次','2'=>'全站会员均可使用一次');
      return $userType;
    }
    /**
     * 获取红包类型
     */
    private function getType(){
      $typeArr = array('1'=>'现金红包','2'=>'商品红包');
      return $typeArr;
    }
    /**
     * 获取红包状态
     */
    private function getStatus(){
      $statusArr = array('0'=>'未分发','1'=>'已分发','2'=>'已激活','3'=>'已使用');//0 未分发，1 已分发，2 已激活，3已使用
      return $statusArr;
    }

    /**
     * 成功页面
     */
    public function success()
    {
        $fileds = array(
            'info'
        );
        $data_gp = $this->controller->get_gp($fileds);
        $data = array_filter($data_gp);
        $info = $data['info'];
        if (! isset($info) && $info == '')
            $info = '操作成功';
        　showmessage($info, '/index.php?m=product&c=product&a=lists');
    }
}
