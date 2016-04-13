<?php

/**
 * @Author: 翁昌华
 * @description: 产品（商品）等级管理
 * @Date: 2015-12-22
 *
 */
class proLevelController extends Controller
{
    // Action白名单
    public $initphp_list = array(
        'lists',
        'create',
        'update',
        'delete',
        'public_cache',
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
     * 商品等级列表
     */
    public function lists()
    {
        $fileds = array(
            'name',
            'value'
        );
        $data = $this->controller->get_gp($fileds);
        $data = array_filter($data);

        $where = $data;
        $offset = 15;
        $page = max((int) $_GET['page'], 1);
        $num = ($page - 1) * $offset;
        $order = 'id';
        $sort = 'asc';
        $levelRes = InitPHP::getRemoteService('proLevel', 'lists', array(
            $where,
            $num,
            $offset,
            $order,
            $sort
        ));
        $info = array();
        $tatol = 0;
        if($levelRes['code'] == 0){
            $info = $levelRes['data'][0];
            $tatol = $levelRes['data'][1];

        }

        $pages = pages($tatol, $page, $offset);

        include V('product', 'proLevelList');
    }

    /**
     * 添加商品等级
     */
    public function create()
    {
        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'name',
                'value',
                'tA',
                'tB',
                'tC',
            );
            $data = $this->controller->get_gp($fileds);
            $data = array_filter($data);
            $where = $data;
            $where['inputtime'] = time();

            if (InitPHP::getRemoteService('proLevel', 'create', array($where))) {
                $this->_cache();
                showmessage('添加成功', '/index.php?m=product&c=proLevel&a=lists');
            }
        } else {

            include V('product', 'createProLevel');
        }
    }

    /**
     * 更新商品（产品）数据信息
     */
    public function update()
    {
        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'id',
                'name',
                'value',
                'tA',
                'tB',
                'tC',
            );
            $data = $this->controller->get_gp($fileds);
            $data = array_filter($data);
            $where = $data;
            $where['inputtime'] = time();

            if (InitPHP::getRemoteService('proLevel', 'update', array($where,array('id'=>$where['id'])))) {
                $this->_cache($where['id']);
                showmessage('更新成功', '/index.php?m=product&c=proLevel&a=lists');
            }
        } else {
            $fileds = array(
                'id'
            );
            $data = $this->controller->get_gp($fileds);
            $data = array_filter($data);

            $where = $data;
            if ($where['id']) {
                $info = InitPHP::getRemoteService('proLevel', 'get', array(
                    $where
                ));
            }
            include V('product', 'createProLevel');
        }
    }

    /**
     * 删除商品等级
     */
    public function delete()
    {
        $fileds = array(
            'id'
        );
        $data = $this->controller->get_gp($fileds);
        $data = array_filter($data);
        $where = $data;
        if (InitPHP::getRemoteService('proLevel', 'delete', array($where))) {
            $this->_cache();
            echo json_encode(array(
                'code' => 200,
                'msg' => '删除成功'
            ));
        } else {
            echo json_encode(array(
                'code' => 300,
                'msg' => '删除失败'
            ));
        }
    }
    /**
     * 更新缓存
     * @return [type] [description]
     */
    public function public_cache(){
        $this->_cache();
        showmessage('更新成功', '/index.php?m=product&c=proLevel&a=lists');
    }
    /**
     * 更新指定ＬＥＶＥＬ
     * @param  boolean $id [description]
     * @return [type]      [description]
     */
    private function _cache($id=false){
        $where = array();
        if($id)$where['id']=max((int)$id,1);
        $levelRes = InitPHP::getRemoteService('proLevel', 'lists', array($where,0,100,'id','asc'));
        if($levelRes['code'] == 0){
            foreach ($levelRes['data'][0] as $key => $value) {
                $this->getRedis('default')->redis()->hmset('proLevel:'.$value['name'],$value);
            }
        }
    }

}
