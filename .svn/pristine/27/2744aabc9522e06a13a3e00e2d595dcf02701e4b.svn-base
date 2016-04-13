<?php
/**
 * 会员管理
 * @Author: 明艺
 * @Date:   2016-1-19 23:04:50
 * @Last Modified time: 2016-1-19 23:04:50
 */

class indexController extends Controller
{
    //Action白名单
    public $initphp_list = array(
        'init',
        'lists',
        'delete',
        'public_cache',
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
        include V('account', 'init');
    }

    /**
     * 会员列表
     */
    public function lists() {
        $fileds = array(
                'levels',
                'wechat_openid',
                'like'
            );

        $where = $this->controller->get_gp($fileds);

        $offset = 11;
        $page = max((int)$_GET['page'], 1);
        $limit = ($page - 1) * $offset;

        if($where['like'] || $where['wechat_openid']){
            if($where['wechat_openid'] == null){
                $wechat_openid = '';
            }elseif($where['wechat_openid'] == 1){
                $wechat_openid = ' wechat_openid != "" ';
            }else{
                $wechat_openid = ' wechat_openid = "" ';
            }
            $like = $where['like'] == null?'':$where['like'];

            $data = InitPHP::getRemoteService('account', 'query_select', array($like,$wechat_openid,$limit,$offset));
        }else{
            if($where['levels'] == null) unset($where['levels']);
            if($where['wechat_openid'] == null) unset($where['wechat_openid']);
            if($where['like'] == null) unset($where['like']);
            $data = InitPHP::getRemoteService('account', 'lists', array($where, $limit, $offset, 'userid', 'desc', array('*')));
        }

        $info = $data['data'][0];
        $total = $data['data'][1];

        $params = $where['levels']?array('like'=>$where['like'],'levels'=>$where['levels']):array('like'=>$where['like']);
        $pages = pages($total, $page, $offset, $urlrule = '', $variables = array(), 10, $params);
        $like = $where['like'];
        $levels = $where['levels'];

        include V('account', 'list');
    }

    /**
     * 添加会员
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
                if (InitPHP::getRemoteService('account', 'create', array($data))) {
                    showmessage('添加成功', '/index.php?m=account&c=index&a=lists');
                }
                else {
                    showmessage('添加失败', '/index.php?m=account&c=index&a=lists');
                }
            }
        } else {
            include V('account', 'logis_create');
        }
    }

    /**
     * 修改会员
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
                if (InitPHP::getRemoteService('account', 'update', array($data,array('id'=>$_POST['id'])))) {
                    showmessage('修改成功', '/index.php?m=account&c=index&a=lists');
                } else {
                    showmessage('修改失败', '/index.php?m=account&c=index&a=lists');
                }
            }
        } else {
            $fileds = array('id');
            $where = $this->controller->get_gp($fileds);
            $data = InitPHP::getRemoteService('account', 'get', array($where));

            include V('account', 'logis_update');
        }
    }

    /**
     * 删除会员
     */
    public function delete() {
        $fileds = array('userid');
        $where = $this->controller->get_gp($fileds);

        $result = InitPHP::getRemoteService('account', 'delete', array($where['userid']));

        if ($result['data']) {
            echo json_encode(array('code' => 200));
        } else {
            echo json_encode(array('code' => 300));
        }
    }
    /**
     * 更新会员REDIS数据
     * @return [type] [description]
     */
    public function public_cache(){
        $memberTotal = InitPHP::getRemoteService('account', 'memberTotal');
        $offset = 100;
        $pages = ceil($memberTotal/$offset);
        $page = (int)$_GET['page'];
        if($page == $pages)showmessage('更新成功', '/index.php?m=account&c=index&a=lists');
        $limit = $page*$offset;
        $page++;
        $data = InitPHP::getRemoteService('account', 'lists', array(array(), $limit, $offset, 'userid', 'desc', array('*')));
        foreach ($data['data'][0] as $key => $value) {
           $name  = trim($value['wechat_openid'])?$value['wechat_openid']:$value['phone'];
           $this->getRedis('default')->redis()->hmset('user:'.$name,$value);
           $this->getRedis('default')->redis()->hmset('userinfo:'.$value['userid'],$value);
        }
        showmessage('更新'.($limit?$limit:$page*$offset).'条成功', '/index.php?m=account&c=index&a=public_cache&page='.$page);
    }
}
