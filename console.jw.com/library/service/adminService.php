<?php

/**
 *管理员控制类
 */
class adminService extends Service
{
    public function __construct(){
         $_menuid = isset($GLOBALS['_menuid']) ? $GLOBALS['_menuid'] : (isset($_GET['_menuid'])?(int)$_GET['_menuid']:0);
         $GLOBALS['_menuid'] = $_menuid;
    }
    
    /**
     * 判断用户是否已经登陆
     */
    final public function check_admin() {
        
        if (coreInit::getM() == 'system' && coreInit::getC() == 'index' && in_array(coreInit::getA(), array('login', 'public_captcha'))) {
            $this->getUtil('session')->expire();
            return true;
        } 
        else {
            $userid = $this->getUtil('session')->get('admin_userid');
            $_userid = $this->getUtil('cookie')->get('admin_userid');
            //var_dump($userid);
            if (!$userid || $userid != $_userid || !$_userid) {
                showmessage('登录超时,请重新登录!', 'index.php?m=system&c=index&a=login');
            } 
            else {
                //$this->getUtil('session')->expire();
                $this->_s_role = (int)$this->getUtil('cookie')->get('admin_role');
                $admin_private = $this->check_admin_menu();
                if (!$admin_private) showmessage('您没有访问权限,请重新登录!', 'index.php?m=system&c=index&a=init');
                return true;
            }
        }
    }
    
    final public function check_admin_menu() {
        $keyid = substr(md5($this->_s_role . coreInit::getM() . coreInit::getC() . coreInit::getA()), 0, 16);
        $_s_role = $this->_s_role;
        //限制非超管用户的访问菜单
        if (1 != $_s_role) {
            $admin_private = InitPHP::getRemoteService('adminPriv', 'get', array(array('keyid' => $keyid)));
        }
        
        return true;
    }
    
    /**
     * 子菜单列表
     */
    final public function menu($pid, $apend_str = '', $append_menu = '') {
        $pid = intval($pid);
        $cookie_time = SYS_TIME + 86400 * 30;
        if (!$pid) $pid = $this->getUtil('cookie')->get('menuid');
        if ($pid) $this->getUtil('cookie')->set('menuid', $pid, $cookie_time);
        
        if (!$pid) return '';
        
        $result = InitPHP::getRemoteService('systemMenu', 'lists', array(array('pid'=>(int)$pid,'display'=>'1')));
        if ($result[1] < 1) return '';
        $GLOBALS['_submenuid'] = isset($_GET['_submenuid']) ? $_GET['_submenuid'] : $pid;
        
        $rs = InitPHP::getRemoteService('systemMenu', 'get', array($pid));
        
        $rs = array(0 => $rs);
        $result = array_merge($rs, $result[0]);
        $str = '<header class="panel-heading">';
        $objid = '';
        $j = 2;
        $apend_str.= '&_menuid=' . $pid;
        
        foreach ($result as $r) {
            $button = 'default';
            $id = $r['menuid'];
            if ($id == $GLOBALS['_submenuid']) {
                $button = 'info';
            }
            $tmpid = $r['c'] . '-' . $r['a'];
            if ($objid == $tmpid) {
                $objid = $objid . $j;
                $j++;
            } 
            else {
                $objid = $tmpid;
            }
            $icon = strpos($r['v'], 'add') === false ? '<i class="icon-gears2 btn-icon"></i>' : '<i class="icon-plus btn-icon"></i>';
            $str.= '<a href="?m=' . $r['m'] . '&c=' . $r['c'] . '&a=' . $r['a'] . '&' . $r['data'] . '&_submenuid=' . $id . $apend_str . '" class="btn btn-' . $button . ' btn-sm" id="' . $objid . '">' . $icon . $r['name'] . '</a> ';
        }
        $str.= $append_menu;
        $str.= '</header>';
        return $str;
    }
}
