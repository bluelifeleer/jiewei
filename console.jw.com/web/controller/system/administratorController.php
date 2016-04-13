<?php
/**
 * @Author: seaven
 * @description: 管理员管理
 * @Date:   2015-06-04 12:14:10
 */
class administratorController extends Controller {
     //Action白名单
    public $userid;
    public $initphp_list = array(
                                 'init',
                                 'create',
                                 'update',
                                 'delete',
                                 'role_init',
                                 'role_create',
                                 'role_update',
                                 'role_delete',
                                 'private_set',
                                );
    public function __construct() {
        parent::__construct();
        $this->userid = (int)$this->getUtil('cookie')->get('admin_userid');
        $this->username = (string)$this->getUtil('cookie')->get('admin_username');
        //判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }

    public function init(){
        $roles =  InitPHP::getRemoteService('adminRole', 'lists');
        $roles = $roles[0];
        $page = max((int)$_GET['page'],1);
        $offset = 12;
        $limit = ($page-1)*$offset;
        $res = InitPHP::getRemoteService('admin', 'lists',array(array(),$limit,$offset));
        $result = $res[0];
        $total = $res[1];
        $pages  = pages($total,$page,$offset,U(1,'system','administrator','init'));
        include V("system","administrator");
    }
    /**
     * 创建管理员
     * @return [type] [description]
     */
    function create(){
        if(isset($_POST['dosubmit'])) {
            $fields = $this->controller->get_gp(array(
                'form'
                ));
            if(empty($fields['form']['username'])) showmessage('账户名称不能为空',HTTP_REFERER);
            $username = $fields['form']['username'];

            $r =InitPHP::getRemoteService('admin','get',array(array('username'=>$username)));
            if($r['userid']) showmessage('账号已存在',HTTP_REFERER);
            $formdata = array();
            if(empty($fields['form']['password']))showmessage('密码不能为空',HTTP_REFERER);
            $password = password($fields['form']['password']);
            $formdata['password'] = $password['password'];
            $formdata['encrypt'] = $password['encrypt'];
            $formdata['role'] = intval($fields['form']['role']);
            $formdata['username'] = $username;
            $formdata['truename'] = $fields['form']['truename'];
            $formdata['email'] = $fields['form']['email'];
            $formdata['tel'] = $fields['form']['tel'];
            $formdata['mobile'] = $fields['form']['mobile'];
            $formdata['remark'] = $fields['form']['remark'];
            
            InitPHP::getRemoteService('admin','create',array($formdata));

            showmessage('操作成功',HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $roles =  InitPHP::getRemoteService('adminRole', 'lists');
            $roles = $roles[0];
            include V("system","administrator_create");
        }
    }
    /**
     * 修复管理员
     * @return [type] [description]
     */
    function update(){
        $userid = (int)$_REQUEST['userid'];
        if(isset($_POST['dosubmit'])) {
            $formdata = array();
            $fields = $this->controller->get_gp(array(
                'form'
                ));
            if(!empty($fields['form']['password'])) {
                $password = password($fields['form']['password']);
                $formdata['password'] = $password['password'];
                $formdata['encrypt'] = $password['encrypt'];
            }
            $formdata['role'] = intval($fields['form']['role']);
            $formdata['truename'] = $fields['form']['truename'];
            $formdata['email'] = $fields['form']['email'];
            $formdata['tel'] = $fields['form']['tel'];
            $formdata['mobile'] = $fields['form']['mobile'];
            $formdata['remark'] = $fields['form']['remark'];
       
            InitPHP::getRemoteService('admin','update',array($formdata,$userid));
            showmessage('修改成功',U(1,'system','administrator','init'));
        } else {
            $show_formjs = 1;
            $roles =  InitPHP::getRemoteService('adminRole', 'lists');
            $roles = $roles[0];
            $r = InitPHP::getRemoteService("admin",'get',array($userid));
            include V("system","administrator_update");
        }
    }

    /**
     * 删除管理员
     * @return [type] [description]
     */
    function delete(){
        $userid = (int)$_REQUEST['userid'];
        if(!$userid) showmessage('操作失败',HTTP_REFERER);
        //不允许删除创始人
        if($userid === 1)showmessage('不能删除创始人',HTTP_REFERER);
        InitPHP::getRemoteService('adminRole', 'lists','delete',array($userid));
        showmessage('操作成功',HTTP_REFERER,500);
    }

    /**
     * 角色列表
     * @return [type] [description]
     */
    function role_init(){
        $roles =  InitPHP::getRemoteService('adminRole', 'lists');
        $roles = $roles[0];
        include V("system","role_init");
    }

    /**
     * 创建角色
     * @return [type] [description]
     */
    function role_create(){
        if(isset($_POST['submit'])) {
            $formdata = array();
            $formdata['name'] = $_POST['form']['name'];
            if(empty($formdata['name'])) showmessage('角色名称不能为空',HTTP_REFERER);
            $formdata['remark'] = $_POST['form']['remark'];
            InitPHP::getRemoteService('adminRole', 'create',array($formdata));
            showmessage('操作成功',U(1,'system','administrator','role_init'),500);
        } else {
            $show_formjs = 1;
            include V("system","role_create");
        }
    }
    /**
     * 修改角色
     * @return [type] [description]
     */
    function role_update(){
        $role =  (int)$_REQUEST['role'];
        if(isset($_POST['dosubmit'])) {
            $formdata = array();
            $formdata['name'] = $_POST['form']['name'];
            if(empty($formdata['name'])) showmessage('角色名称不能为空',HTTP_REFERER);
            $formdata['remark'] = $_POST['form']['remark'];
            InitPHP::getRemoteService('adminRole', 'update',array($formdata,$role));
            showmessage('修改成功',U(1,'system','administrator','role_init'));
        } else {
            $show_formjs = 1;
            $r = InitPHP::getRemoteService("adminRole",'get',array('role'=>$role));
            include V('system','role_update');
        }
    }
    /**
     * 删除权限
     * @return [type] [description]
     */
    function role_delete(){
        $role =  (int)$_REQUEST['role'];
        if(!$role || $role==1) showmessage('操作失败',HTTP_REFERER);
        InitPHP::getRemoteService('adminRole', 'delete',array($role));
        showmessage('删除成功',U(1,'system','administrator','role_init'));
    }

    /**
     * 权限设置
     * @return [type] [description]
     */
    function private_set(){
        $role = intval($_REQUEST['role']);
        if(isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $chk = intval($_POST['chk']);
            $mr = InitPHP::getRemoteService('systemMenu', 'get',array($id));
            $r = InitPHP::getRemoteService('adminPriv', 'get',array('id'=>$id,'role'=>$role));
            $keyid = substr(md5($role.$mr['m'].$mr['c'].$mr['a']),0,16);
            if($r) {
                InitPHP::getRemoteService('adminPriv', 'update',array(array('chk'=>$chk,'keyid'=>$keyid),array('id'=>$id,'role'=>$role)));
            } else {
                InitPHP::getRemoteService('adminPriv', 'create',array(array('id'=>$id,'role'=>$role,'chk'=>$chk,'keyid'=>$keyid)));
            }
            exit('1');
        } else {
            $r_role = InitPHP::getRemoteService('adminRole','get',array($role));
            $parent_top = InitPHP::getRemoteService('systemMenu','lists',array(array('pid'=>0),0,20));
            $parent_top = $parent_top[0];
            $result = InitPHP::getRemoteService('systemMenu','lists',array('',0,20));
            $result = $result[0];
            $privates_rs = InitPHP::getRemoteService('adminPriv','lists',array(array('role'=>$role),0,2000));
            $privates = array();
            foreach($privates_rs[0] as $rs) {
               if($rs['chk']) $privates[] = $rs['id'];
            }
            include V('system','private_set');
        }
    }

}