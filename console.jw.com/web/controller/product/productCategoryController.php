<?php
/**
 * @Author: 翁昌华
 * @description: 产品L栏目管理
 * @Date: 2015-12-22
 *
 */
class productCategoryController extends Controller
{
    // Action白名单
    public $initphp_list = array(
        'lists',
        'create',
        'edit',
        'delete',

    );

    public function __construct()
    {
        parent::__construct();
        $this->userid = $userid = (int) $this->getUtil('session')->get('admin_userid');
        if ($userid) {
            $this->memberinfo = InitPHP::getRemoteService('admin', 'get', array(
                $userid,
            ));
        }
        // 判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }
    /**
     * 商品栏目列表
     */
    public function lists()
    {
        $fileds         = array('module', 'siteid');
        $data_gp        = $this->controller->get_gp($fileds);
        $data           = array_filter($data_gp);
        $data['module'] = $data['module'] ? $data['module'] : 'system';
        if ($data['module'] == 'site') {
            $data['siteid'] = 1;
        }

        $types = array('列表', '单网页', '外链');
        $where = $data;
        //$where['module'] = 'system';

        $RemoteResult = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 2000));
        if ($RemoteResult['code'] == 0) {
            $data   = $RemoteResult['data'][0];
            $result = array();
            foreach ($data as $r) {
                $cid          = $r['catid'];
                $result[$cid] = $r;

                $shopRes = InitPHP::getRemoteService('shop', 'get', array('userid' => $r['siteid']));
                if ($shopRes) {
                    $result[$cid]['siteName'] = $shopRes['name'];
                }
                $result[$cid]['str_manage'] = '<a class="btn btn-default btn-xs" href="?m=product&c=productCategory&a=create&pid=' . $r['catid'] . '">添加子栏目</a>  <a class="btn btn-primary btn-xs" href="?m=product&c=productCategory&a=edit&catid=' . $r['catid'] . '">修改</a> <a class="btn btn-danger btn-xs" href="javascript:makedo(\'?m=product&c=productCategory&a=delete&ids=' . $r['catid'] . '\', \'确认删除该记录？\')">删除</a>';

                $result[$cid]['ctype']  = $types[$r['type']];
                $result[$cid]['module'] = $r['module'];
            }

            $treeUnity = $this->getLibrary('tree');
            $treeUnity->init($result);
            $treeUnity->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');

            $tree_data = '';

            //格式字符串
            $str = "<tr><td class='categorytd'><div><input class='center'style='padding:3px' name='sorts[\$catid]' type='text' size='3' value='\$listorder'></div></td><td>\$catid</td><td id='\$catid' \$selected>\$spacer\$catname</td><td>\$ctype</td><td>\$siteName</td><td>\$module</td><td>\$str_manage</td></tr>";

            //返回树
            $tree_data .= $treeUnity->create(0, $str);

            $tree_data .= "";
            $show_dialog = 1;
        }
        $tree_data .= "";
        $show_dialog = 1;
        $status      = $this->_module('all');
        include V('product', 'product_category_list');
    }

    /**
     * 栏目类型
     * [$module_array description]
     * @var array
     */
    private $module_array = array(
        'all'    => '全部栏目',
        'system' => '平台栏目',
        'site'   => '子站栏目',
    );
    /**
     *
     * @param  [type]
     * @return [type]
     */
    private function _module($selected)
    {
        $module_array = $this->module_array;
        $string       = ' <span class="dropdown examine">';
        foreach ($module_array as $k => $s) {

            if ($k == $selected) {
                $string .= '<a  href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="icon-check btn-icon"></i>' . $s . '<span class="caret"></span></a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach ($module_array as $k => $s) {
            if ($k != $selected) {
                $url = U(1, 'product', 'productCategory', 'lists', array('module' => $k));
                $string .= '<li><a target="iframeid" href="' . $url . '">' . $s . '</a></li>';
            }
        }
        $string .= '</ul> </span>';
        return $string;
    }

    /**
     *创建栏目
     */

    public function create()
    {
        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'catid',
                'catname',
                'parentid',
                'module',
                'letter',
                'image',
            );
            $data_gp             = $this->controller->get_gp($fileds);
            $data                = array_filter($data_gp);
            $data['parentid']    = !isset($parentid) ? $data['parentid'] : 0;
            $parentid            = $data['parentid'];
            $data['arrparentid'] = $parentid != 0 ? '0,' . $data['parentid'] : 0;
            $data['siteid']      = InitPHP::getConfig('userid'); //界微平台商城管理用户ID
            $where['child']      = 0;
            if (!trim($data['catname'])) {
                showmessage('带*的为必填项，请填写完整', 'goback');
            }
            //unset($data['parentid']);
            $where = $data;
            $res   = InitPHP::getRemoteService('categories', 'create', array($where));

            if ($res) {
                $category   = InitPHP::getRemoteService('categories', 'get', array(array('catid' => $parentid)));
                $parentData = array('child' => 1, 'arrchildid' => $category['arrchildid'] . ',' . $res);
                InitPHP::getRemoteService('categories', 'update', array($parentData, array('catid' => $parentid)));
                $updateData = array('arrchildid' => $res, 'listorder' => $res);
                InitPHP::getRemoteService('categories', 'update', array($updateData, array('catid' => $res)));
                showmessage('添加成功', '/index.php?m=product&c=productCategory&a=lists');
            } else {
                showmessage('添加失败', '/index.php?m=product&c=productCategory&a=create');
            }

        } else {

            $fileds               = array('pid');
            $data_gp              = $this->controller->get_gp($fileds);
            $data                 = array_filter($data_gp);
            $category['parentid'] = $data['pid'];
            $modules              = array('system' => '平台商城栏目');
            $categories           = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system'), 0, 2000));
            $categories           = $categories['data'][0];

            include V('product', 'product_category_create');
        }
    }

    public function edit()
    {

        if (isset($_POST['dosubmit'])) {
            $fileds = array(
                'catid',
                'catname',
                'letter',
                'image',
            );
            $data_gp = $this->controller->get_gp($fileds);
            $data    = array_filter($data_gp);
            if (isset($data['image'])) {
                $data['image'] = $data['image'][0];
            }
            $where = $data;
            $res   = InitPHP::getRemoteService('categories', 'update', array($where, array('catid' => $where['catid'])));
            if ($res) {
                showmessage('更新成功', '/index.php?m=product&c=productCategory&a=lists');
            } else {
                showmessage('更新失败', '/index.php?m=product&c=productCategory&a=create');
            }

        } else {
            $fileds     = array('catid', 'pid');
            $data_gp    = $this->controller->get_gp($fileds);
            $data       = array_filter($data_gp);
            $catid      = $data['catid'];
            $category   = InitPHP::getRemoteService('categories', 'get', array(array('catid' => $catid)));
            $modules    = array('system' => '平台商城栏目');
            $categories = InitPHP::getRemoteService('categories', 'lists', array(array('module' => 'system'), 0, 2000));
            $categories = $categories['data'][0];

            include V('product', 'product_category_create');
        }

    }

    public function delete()
    {
        $fileds  = array('ids');
        $data_gp = $this->controller->get_gp($fileds);
        $data    = array_filter($data_gp);
        $ids     = $data['ids'];
        if (isset($ids) && $ids != '') {
            $where = explode(",", $data['ids']);
        } else {
            $where = array();
        }

        $category = InitPHP::getRemoteService('categories', 'get', array(array('catid' => $ids)));
        if ($category['child'] == 1) {
            showmessage('存在子栏目，不能直接删除！', '/index.php?m=product&c=productCategory&a=lists');
        }
        if ($category['parentid'] != 0) {
            $parentCate = InitPHP::getRemoteService('categories', 'get', array(array('catid' => $category['parentid'])));

            $arrchildid = explode(',', str_replace(',' . $ids, '', $parentCate['arrchildid']));

            $isChild = count($arrchildid) == 1 ? 0 : 1;

            $parentData = array('child' => $isChild, 'arrchildid' => str_replace(',' . $ids, '', $parentCate['arrchildid']));
            InitPHP::getRemoteService('categories', 'update', array($parentData, array('catid' => $category['parentid'])));

        }
        $Res = InitPHP::getRemoteService('categories', 'delete', array($where));

        if ($Res) {

            showmessage('删除成功', '/index.php?m=product&c=productCategory&a=lists');
        } else {
            showmessage('删除失败', '/index.php?m=product&c=productCategory&a=lists');
        }
    }

    /**
     * 获取栏目信息类别
     */
    public function getCates()
    {
        $categories = array();

        $catRes = InitPHP::getRemoteService('categories', 'lists', array(array('type' => '0'), 0, 2000));
        if ($catRes['code'] == 0) {
            $catInfo = $catRes['data'][0];
            foreach ($catInfo as $r) {
                $categories[$r['catid']] = $r['catname'];
            }
        }
        return $categories;
    }

}
