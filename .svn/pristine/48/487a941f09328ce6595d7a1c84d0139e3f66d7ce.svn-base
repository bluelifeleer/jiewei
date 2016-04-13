<?php

/**
 * @Author: 翁昌华
 * @description: 系统菜单
 * @Date:   2015-１2-29 10:26:49
 */
class systemMenuController extends Controller
{
    
    // Action白名单
    public $initphp_list = array(
        'init',
        'create',
        'delete',
        'update',
        'sort',
        'delete_child'
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
     * 列表
     */
    public function init()
    {
        $pid = (int) $_GET['pid'];
        $where = array(
            'pid' => $pid
        );
        $result = InitPHP::getRemoteService('systemMenu', 'lists', array(
            $where
        ));
        include V("system", "menu_init");
    }
    /**
     * 创建
     */
    public function create()
    {
        if (isset($_POST['dosubmit'])) {
            $formdata = array();
            $formdata['name'] = $_POST['form']['name'];
            $formdata['pid'] = intval($_POST['form']['pid']);
            $formdata['m'] = $_POST['form']['m'];
            $formdata['c'] = $_POST['form']['c'];
            $formdata['a'] = $_POST['form']['a'];
            $formdata['data'] = $_POST['form']['data'];
            $formdata['display'] = $_POST['form']['display'];
            $Res =  InitPHP::getRemoteService('systemMenu', 'create', array(
                $formdata
            ));
            showmessage('操作成功', U(1, 'system', 'systemMenu', 'init',array('pid'=>$_POST['form']['pid'])));
        } else {
            $id = (int) $_GET['id'];
            if ($id) {
                $rs = InitPHP::getRemoteService('systemMenu', 'get', array(
                    $id
                ));
                $parentname = $rs['name'];
            } else {
                $parentname = '一级菜单';
            }
            
            include V("system", "menu_create");
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = (int) $_GET['id'];
        if (! $id)
            showmessage('操作失败');
        $parentid = $this->parentid($id);
        $Res = InitPHP::getRemoteService('systemMenu', 'delete', array(
            $id
        ));
        $this->delete_child($id);
        showmessage('操作成功', U(1, 'system', 'systemMenu', 'init', array(
            'pid' => $parentid
        )));
    }
    /**
     * 递归删除菜单
     */
    public function delete_child($menuid)
    {
        $r = InitPHP::getRemoteService('systemMenu', 'get', array(
           $menuid
        ));
        if ($r) {
            InitPHP::getRemoteService('systemMenu', 'delete', array(
                $r['menuid']
            ));
            $this->delete_child($r['menuid']);
        }
    }
    /**
     * 更新
     */
    public function update()
    {
        $id = (int) $_GET['id'];
        if (! $id)
            showmessage('参数错误');
        if (isset($_POST['dosubmit'])) {
            $formdata = array();
            $formdata['name'] = $_POST['form']['name'];
            $formdata['pid'] = intval($_POST['form']['pid']);
            $formdata['m'] = $_POST['form']['m'];
            $formdata['c'] = $_POST['form']['c'];
            $formdata['a'] = $_POST['form']['a'];
            $formdata['data'] = $_POST['form']['data'];
            $formdata['display'] = $_POST['form']['display'];
            InitPHP::getRemoteService('systemMenu', 'update', array(
                $formdata,
                $id
            ));
            showmessage('操作成功', U(1,'system','systemMenu','init',array('pid'=>$formdata['pid'])));
        } else {
            $r = InitPHP::getRemoteService('systemMenu', 'get', array(
                $id
            ));
            if ($r['pid'])
                $rs = InitPHP::getRemoteService('systemMenu', 'get', array(
                    $r['pid']
                ));
            $parentname = $r['pid'] ? $rs['name'] : '一级菜单';
            include V("system", "menu_update");
        }
    }

    /**
     * 排序
     */
    public function sort()
    {
        if (isset($_POST['dosubmit'])) {
            foreach ($_POST['sorts'] as $cid => $n) {
                $n = intval($n);
                $parentid = $this->parentid($cid);
                InitPHP::getRemoteService('systemMenu', 'update', array(
                    array(
                        'sort' => $n
                    ),
                    $cid
                ));
            }
            showmessage('操作成功', U(1, 'system', 'systemMenu', 'init', array(
                'pid' => $parentid
            )));
        } else {
            showmessage('操作失败');
        }
    }

    /**
     * 获得上级菜单id
     */
    private function parentid($pid)
    {
        $r = InitPHP::getRemoteService('systemMenu', 'get', array(
            $pid
        ));
        return $r['pid'];
    }
}
