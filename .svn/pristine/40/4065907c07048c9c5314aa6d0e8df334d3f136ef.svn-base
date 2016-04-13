<?php
/**
 * @Author: 翁昌华
 * @description: 产品（商品）管理
 * @Date: 2015-12-22
 *
 */

class indexController extends Controller
{
    //Action白名单
    public $initphp_list = array('init', 'manage', 'recycleManage', 'left', 'listing', 'recycleLists');

    private $status_array = array(
        9 => '审核通过',
        0 => '回收站',
        7 => '退稿',
        6 => '草稿',
    );
    public function __construct()
    {
        parent::__construct();
        $this->userid = $userid = (int) $this->getUtil('session')->get('admin_userid');
        if ($userid) {
            $this->memberinfo = InitPHP::getRemoteService('admin', 'get', array($userid));
        }
        //判断是否登入状态
        InitPHP::getService("admin")->check_admin();

    }

    public function manage()
    {
        $modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
        include V('product', 'content_manage');
    }

    public function recycleManage()
    {
        $modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
        include V('product', 'recycle_content_manage');
    }

    /**
     * 初始化主界面
     */
    public function init()
    {
        include V('product', 'init');
    }

    public function left()
    {
        $where  = array('module' => 'system', 'siteid' => 1);
        $result = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 2000, 'listorder', 'ASC', 'catid', '*'));
        if ($result['code'] == 0 && $result['data'][1] > 0) {

            $datas = $result['data'];
            $data  = $datas['0'];
            $tree  = $this->getLibrary('tree');

            $tree->init($data);

            $category_tree = $tree->get_treeview(0, 'tree', "<li><a href='javascript:w(\$catid);' onclick='o_p(\$catid,this)' class='i-t'>\$catname</a></li>", "<li><a href='javascript:w(\$catid);' onclick='o_p(\$catid,this)' class='i-t'>\$catname</a>");

        } else {
            $category_tree = '';
        }

        include V('product', 'content_left');
    }

    public function listing()
    {
        //默认显示共享模型数据，即modelid为0.
        //默认status为9 通过审核
        $title     = isset($_GET['title']) ? sql_replace($_GET['title']) : '';
        $status    = isset($_GET['status']) ? intval($_GET['status']) : 99;
        $catid     = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
        $categorys = array();
        $_result   = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system', 'siteid' => InitPHP::getConfig('userid')), 0, 2000, 'listorder', 'ASC', 'catid', '*'));
        if ($_result['code'] == 0) {
            $categorys = $_result['data']['0'];
        }

        $where = "`is_recycled`='1' AND `sysadd`=1 AND ";
        if ($catid) {
            $where .= "`catid`='$catid' AND `status`='$status'";
            if ($title) {
                $where .= " AND `title` LIKE '%$title%'";
            }

        } else {
            $where .= "`status`='$status'";

            if ($title) {
                $where .= " AND `title` LIKE '%$title%'";
            }

            $cids = array();
            if (!empty($categorys)) {
                foreach ($categorys as $_cid => $_res) {
                    $cids[] = $_cid;
                }
            }

            if (!empty($cids)) {
                $cids = implode(',', $cids);
                $where .= " AND `catid` IN($cids)";
            }
        }

        $offset = 15;
        $page   = max((int) $_GET['page'], 1);
        $limit  = ($page - 1) * $offset;
        $order  = 'id';
        $sort   = 'desc';
        $result = InitPHP::getRemoteService('product', 'lists', array($where, $offset, $limit, $order, $sort));
        $datas  = $result['code'] == 0 ? $result['data']['0'] : array();

        $tatol = (int) $result['data']['1'];

        $pages = pages($tatol, $page, $offset);

        include V('product', 'content_listing');
    }
    /**
     * 回收站管理列表
     * @return [type]
     */
    public function recycleLists()
    {
        //默认显示共享模型数据，即modelid为0.
        //默认status为9 通过审核
        $title     = isset($_GET['title']) ? sql_replace($_GET['title']) : '';
        $status    = isset($_GET['status']) ? intval($_GET['status']) : 99;
        $catid     = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
        $categorys = array();
        $_result   = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system', 'siteid' => InitPHP::getConfig('userid')), 0, 2000, 'listorder', 'ASC', 'catid', '*'));
        if ($_result['code'] == 0) {
            $categorys = $_result['data']['0'];
        }

        $where = "`is_recycled`='99' AND";
        if ($catid) {
            $where .= "`catid`='$catid' AND `status`='$status'";
            if ($title) {
                $where .= " AND `title` LIKE '%$title%'";
            }

        } else {
            $where .= "`status`='$status'";

            if ($title) {
                $where .= " AND `title` LIKE '%$title%'";
            }

            $cids = array();
            if (!empty($categorys)) {
                foreach ($categorys as $_cid => $_res) {
                    $cids[] = $_cid;
                }
            }

            if (!empty($cids)) {
                $cids = implode(',', $cids);
                $where .= " AND `catid` IN($cids)";
            }
        }

        $offset = 15;
        $page   = max((int) $_GET['page'], 1);
        $limit  = ($page - 1) * $offset;
        $order  = 'id';
        $sort   = 'desc';
        $result = InitPHP::getRemoteService('product', 'lists', array($where, $offset, $limit, $order, $sort));
        $datas  = $result['code'] == 0 ? $result['data']['0'] : array();

        $tatol = (int) $result['data']['1'];
        $pages = pages($tatol, $page, $offset);

        include V('product', 'product_recycle_list');
    }

    /**
     * 审核所有待审内容，根据模型
     */
    public function allcheck()
    {
        $categorys = get_cache('category', 'content');
        $status    = isset($_GET['status']) ? intval($_GET['status']) : '10';
        $models    = get_cache('model_content', 'model');
        if ($status == '10') {
            $where = "`status` IN(1,2,3)";
        } else {
            $where = "`status`='$status'";
        }
        $siteid = get_cookie('siteid');

        $cids = array();
        foreach ($categorys as $_cid => $_res) {
            if ($_res['siteid'] == $siteid) {
                $cids[] = $_cid;
            }

        }
        $cids = implode(',', $cids);
        $where .= " AND `cid` IN($cids)";

        $result    = array();
        $result[0] = $this->db->get_list('content_share', $where, '*', 0, 20, 0, 'id DESC');
        foreach ($models as $key => $model) {
            $master_table = $model['master_table'];
            if ($master_table == 'content_share') {
                continue;
            }

            $result[$key] = $this->db->get_list($master_table, $where, '*', 0, 20, 0, 'id DESC');
        }
        //print_r($result);
        include V('product', 'content_allcheck');
    }

    private function _status($status)
    {
        $status_array = $this->status_array;
        $string       = '';
        foreach ($status_array as $k => $s) {
            if ($k == $status) {
                $string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="icon-check btn-icon"></i>' . $s . '<span class="caret"></span></a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach ($status_array as $k => $s) {
            if ($k != $status) {
                $url = URL() . '&status=' . $k;
                $url = url_unique($url);
                $string .= '<li><a href="?' . $url . '">' . $s . '</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }
}
