<?php
/**
 * 物流公司管理
 * @Author: 明艺
 * @Date:   2015-12-30 15:21:40
 * @Last Modified time: 2015-12-30 21:29:09
 */

class indexController extends Controller
{
    //Action白名单
    public $initphp_list = array(
        'init',
        'lists',
        'logisCreate',
        'logisUpdate',
        'logisDelete'
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

    /**
     * 框架
     */
    public function init() {
        include V('logistics', 'init');
    }
    
    /**
     * 物流公司列表
     */
    public function lists() {
        $fileds = array();
        $where = $this->controller->get_gp($fileds);
        $where = array_filter($where);

        $offset = 10;
        $page = max((int)$_GET['page'], 1);
        $limit = ($page - 1) * $offset;

        $data = InitPHP::getRemoteService('logistics', 'lists', array($where, $offset, $limit, 'id', 'asc'));

        $info = $data[0];
        $total = $data[1];
        
        $pages = pages($total, $page, $offset);

        include V('logistics', 'list');
    }

    /**
     * 添加物流公司
     */
    public function logisCreate() {
        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'name',
                'url',
                'com'
            );
            $data = $this->controller->get_gp($fileds);
            
            // var_dump($data);die();

            if (!trim($data['name'])) {
                showmessage('带*的为必填项，请填写完整', 'goback');
            } else {
                if (InitPHP::getRemoteService('logistics', 'create', array($data))) {
                    showmessage('添加成功', '/index.php?m=logistics&c=index&a=lists');
                } 
                else {
                    showmessage('添加失败', '/index.php?m=logistics&c=index&a=lists');
                }
            }
        } else {
            include V('logistics', 'logis_create');
        }
    }

    /**
     * 修改物流公司
     */
    public function logisUpdate() {
        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'name',
                'url',
                'com'
            );
            $data = $this->controller->get_gp($fileds);
            
            // var_dump($data);die();

            if (!trim($data['name'])) {
                showmessage('带*的为必填项，请填写完整', 'goback');
            } else {
                if (InitPHP::getRemoteService('logistics', 'update', array($data,array('id'=>$_POST['id'])))) {
                    showmessage('修改成功', '/index.php?m=logistics&c=index&a=lists');
                } else {
                    showmessage('修改失败', '/index.php?m=logistics&c=index&a=lists');
                }
            }
        } else {
            $fileds = array('id');
            $where = $this->controller->get_gp($fileds);
            $data = InitPHP::getRemoteService('logistics', 'get', array($where));
            
            include V('logistics', 'logis_update');
        }
    }

    /**
     * 删除物流公司
     */
    public function logisDelete() {
        $fileds = array('id');
        $where = $this->controller->get_gp($fileds);
        
        $result = InitPHP::getRemoteService('logistics', 'delete', array(array('id' => $where['id'])));
        
        if ($result) {
            echo json_encode(array('code' => 200));
        } else {
            echo json_encode(array('code' => 300));
        }
    }
}