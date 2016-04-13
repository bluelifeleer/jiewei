<?php

/**
 * @Author: 明艺
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-25 00:30:37
 */
class categoryController extends Controller
{

    //Action白名单
    public $initphp_list = array('init', 'leftbar', 'catList', 'catCreate', 'catDelete', 'catUpdate');

    public function __construct() {
        parent::__construct();

        //可以在构造函数中初始化
        $this->adminService = InitPHP::getService("admin");

        //判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }

    /**
     * [init 框架]
     * @return [type] [description]
     */
    public function init() {
        $types = array('列表', '单网页', '外链');
        $where = "`module`='content'";
        $RemoteResult = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 2000));
        if ($RemoteResult['code'] == 0) {
            $data = $RemoteResult['data'][0];
            $result = array();
            foreach ($data as $r) {
                $cid = $r['catid'];
                $result[$cid] = $r;
                $result[$cid]['str_manage'] = '<a class="btn btn-default btn-xs" href="?m=content&f=category&v=add&pid=' . $r['catid'] . '">添加子栏目</a> <a class="btn btn-primary btn-xs" href="?m=content&f=category&v=edit&cid=' . $r['catid'] . '">修改</a> <a class="btn btn-danger btn-xs" href="javascript:makedo(\'?m=content&f=category&v=delete&catid=' . $r['catid'] . '\', \'确认删除该记录？\')">删除</a>';
                $result[$cid]['ctype'] = $types[$r['type']];
                $result[$cid]['module'] = $r['module'];
                $result[$cid]['url'] = '<a href="' . $r['url'] . '" target="_blank">访问</a>';
            }
            // echo '<pre>';
            // var_dump($result);
            $treeUnity = $this->getLibrary('tree');
            $treeUnity->init($result);
            $treeUnity->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');

            $tree_data = '';

            //格式字符串
            $str = "<tr><td class='categorytd'><div><input class='center'style='padding:3px' name='sorts[\$catid]' type='text' size='3' value='\$listorder'></div></td><td>\$catid</td><td id='\$catid' \$selected>\$spacer\$catname</td><td>\$ctype</td><td>\$module</td><td>\$url</td><td>\$str_manage</td></tr>";

            //返回树
            $tree_data.= $treeUnity->create(0, $str);

            $tree_data.= "";
            $show_dialog = 1;
        }

        $tree_data.= "";
        $show_dialog = 1;
        include V('category', 'init');
    }

    /**
     * [leftbar 侧边栏属性]
     * @return [type] [description]
     */
    public function leftbar() {
        include V('category', 'leftbar');
    }

    // InitPHP::getRemoteService();



    /**
     * 分类列表
     */
    public function catList() {
        $fileds = array('cat_id');
        $cat_id = $this->controller->get_gp($fileds);

        $where = InitPHP::getRemoteService('Categories', 'get', array($cat_id));

        // var_dump($where);

        $offset = 10;
        $page = max((int)$_GET['page'], 1);
        $limit = ($page - 1) * $offset;
        $data = InitPHP::getRemoteService('Categories', 'lists', array(array('parent_id' => $where['cat_id']), $offset, $limit, 'cat_id', 'asc'));

        // if($where['sysadd'] == '2'){
        //     $where['sysadd'] = '0';
        // }
        // $offset = 10;
        // $page = max((int)$_GET['page'], 1);
        // $limit = ($page - 1) * $offset;
        // if ($where['like'] == "" && $where['inputtime'] == "") {
        //     $data = InitPHP::getRemoteService('miniVideo', 'lists', array($where, $offset, $limit, 'courseid', 'asc'));
        // }else{
        //     if($where['inputtime'] == ""){
        //         $data = InitPHP::getRemoteService('miniVideo', 'query_select', array(' where `courseid` = ' . intval($where['like']) . ' or `course_title` like "%' . $where['like'] . '%"'));
        //     }else{
        //         $data = InitPHP::getRemoteService('miniVideo', 'query_select', array('ORDER BY `inputtime` '.$where['inputtime']));
        //     }
        //     $like = $where['like'];
        // }

        $info = $data[0];
        $total = $data[1];
        $pages = pages($total, $page, $offset);

        $module = array(1 => '产品', 2 => '文章', 3 => '其他');
        $cat_name = $where['cat_id'] ? $where['cat_name'] : '顶级';
        include V('category', 'list');
    }

    /**
     * 添加分类
     */
    public function catCreate() {
        if (isset($_POST['dosubmit'])) {
            $fileds = array('cat_id', 'cat_name', 'parent_id', 'path', 'module');
            $data = $this->controller->get_gp($fileds);
            $parent_id = $data['parent_id'];
            $data['parent_id'] = $data['cat_id'] ? $data['cat_id'] : 0;
            $data['path'] = trim($data['path'] . ',' . $data['parent_id'], ',');
            unset($data['cat_id']);

            // var_dump($data);die();
            if (!trim($data['cat_name'])) {
                showmessage('带*的为必填项，请填写完整', 'goback');
            }
            else {
                if (InitPHP::getRemoteService('Categories', 'create', array($data))) {
                    showmessage('添加成功', '/index.php?m=system&c=category&a=catList&cat_id=' . $parent_id);
                }
                else {
                    showmessage('添加失败', '/index.php?m=system&c=category&a=catList&cat_id=' . $parent_id);
                }
            }
        }
        else {
            $fileds = array('cat_id');
            $where = $this->controller->get_gp($fileds);

            if ($where['cat_id']) {
                $data = InitPHP::getRemoteService('Categories', 'get', array($where));
            }

            include V('category', 'cat_create');
        }
    }

    /**
     * 删除分类
     */
    public function catDelete() {
        $fileds = array('cat_id');
        $where = $this->controller->get_gp($fileds);

        $data = InitPHP::getRemoteService('Categories', 'query_select', array($where['cat_id']));

        foreach ($data as $key => $value) {
            $cat_id[] = $value['cat_id'];
        }
        $cat_id[] = $where['cat_id'];

        $result = InitPHP::getRemoteService('Categories', 'delete', array(array('cat_id' => $cat_id)));

        if ($result) {
            echo json_encode(array('code' => 200));
        }
        else {
            echo json_encode(array('code' => 300));
        }
    }

    /**
     * 添加分类
     */
    public function catUpdate() {
        if (isset($_POST['dosubmit'])) {
            $fileds = array('cat_id', 'cat_name', 'parent_id', 'path', 'module');
            $data = $this->controller->get_gp($fileds);
            $parent_id = $data['parent_id'];

            // var_dump($data);die();
            if (!trim($data['cat_name'])) {
                showmessage('带*的为必填项，请填写完整', 'goback');
            }
            else {
                if (InitPHP::getRemoteService('Categories', 'update', array(array('cat_name' => $data['cat_name']), array('cat_id' => $data['cat_id'])))) {
                    showmessage('修改成功', '/index.php?m=system&c=category&a=catList&cat_id=' . $parent_id);
                }
                else {
                    showmessage('修改失败', '/index.php?m=system&c=category&a=catList&cat_id=' . $parent_id);
                }
            }
        }
        else {
            $fileds = array('cat_id');
            $where = $this->controller->get_gp($fileds);

            if ($where['cat_id']) {
                $data = InitPHP::getRemoteService('Categories', 'get', array($where));
            }

            include V('category', 'cat_update');
        }
    }
}
