<?php
/**
 * @Author: anchen    d
 * @Date:   2016-01-06 19:28:31
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-04-09 02:24:22
 */
class indexController extends Controller
{
    public $initphp_list = array(
        'add_shopname',
        'getShopInfo',
        'addShop',
        'showProduct',
        'modifyAvatar',
        'getCate',
        'shopInfoUpdate',
        'getShopCate',
        'updateShopCate',
        'addShopCate',
        'addShopProduct',
        'showCateIcon',
        'upCateIcon',
        'showCateImage',
        'getShopClassify',
        'showShopProduct',
        'delShopCate',
        'shoplists',
    );

    private $session;
    public function __construct()
    {
        parent::__construct();
        $this->session = $this->getUtil('session');
    }

    public function modifyAvatar()
    {

        $value  = array('avarat');
        $data   = $this->controller->get_gp($value);
        $updata = array('avatar' => trim($data['avarat']));
        $userid = $this->getUtil('session')->get('_userid');
        // $getSessionPhone = $this->getUtil('session')->get('_phone');
        // $getSessionWechat = $this->getUtil('session')->get('wechat_openid');
        // if ($getSessionPhone && $getSessionPhone != '') {
        //     $redusUserKey = 'user:' . $getSessionPhone;
        //     $where = array('userid' => $getSessionUserId, 'phone' => $getSessionPhone);
        // } else if ($getSessionWechat && $getSessionWechat != '') {
        //     $redusUserKey = 'user:' . $getSessionWechat;
        //     $where = array('userid' => $getSessionUserId, 'wechat_openid' => $getSessionWechat);
        // }
        $updateId = InitPHP::getRemoteService('shop', 'updateField', array($updata, array('userid' => $userid)));
        if ($updateId['code'] == 0) {
            //更新redias中的头像
            //$this->getRedis('default')->redis()->hmset($redusUserKey, $updata);
            InitPHP::Encode(0, 'Success', '');
        } else {
            InitPHP::Encode(1, 'Error', '');
        }
    }
    /**
     * [getShopInfo 根据用户id获取店铺信息
     * @link http://api.jw.com/shop/index/getShopInfo/userid/1
     * @return [json] [json数据]
     */
    public function getShopInfo()
    {
        $uid    = $this->getUtil('session')->get('_userid');
        $result = InitPHP::getRemoteService('shop', 'getshop', array('userid' => $uid));
        if (!$result) {
            $code = 2;
            $msg  = '失败';
            $data = '';
            InitPHP::Encode($code, $msg, $data);
        }
        $code = 0;
        $msg  = '';
        $data = $result;
        InitPHP::Encode($code, $msg, $data);
    }

    public function addShopGoods()
    {
        if ($data) {
            $code = 0;
            $msg  = '';
        } else {
            $code = 2;
            $msg  = '显示失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    /**
     * 区分产品
     */
    public function showShopProduct()
    {
        $fields  = array('siteid', 'fromid');
        $data_gp = $this->controller->get_gp($fields);
        $data    = array_filter($data_gp);
        $where   = $data;
        if ($where['fromid'] != 0) {
            $search = 'IS NOT NULL';
            //$where['fromid'] = $where['fromid'];
        } else {
            $search = 'IS NULL';
            //$where['fromid'] = '';
        }
        $res = InitPHP::getRemoteService('product', 'query_search_null', array($where['siteid'], $search));
        if (count($res) != 0) {
            $code = 0;
            $msg  = '';
            $data = $res;
        } else {
            $code = 2;
            $msg  = '';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }
    /**
     * [productLists 产品列表]
     * @link http://api.jw.com/shop/index/showProduct/
     * @method productLists
     * @return array 商品列表
     */
    public function showProduct()
    {
        $fields  = array('catid', 'siteid');
        $data_gp = $this->controller->get_gp($fields);
        $data    = array_filter($data_gp);
        //查询条件
        $where = $data;
        //is_recycled = 1存在仓库中 99 存在于回收站
        $where['is_recycled'] = 1;
        $where['userid']      = !empty($where['siteid']) ? $where['siteid'] : 1;
        //分页量
        unset($where['siteid']);
        $offset = $_GET['offset'];
        //页码
        $page = max((int) $_GET['pages'], 1);
        //sql limit 限制
        $limit = ($page - 1) * $offset;
        //排序字段
        $order = 'id';
        //排序方式
        $sort = 'desc';
        //调用产品服务list
        $res = InitPHP::getRemoteService('product', 'lists', array(
            $where,
            $offset,
            $limit,
            $order,
            $sort,
        ));
        $total = '0';
        $code  = '0';
        if ($res['code'] == 0) {
            $info  = $res['data'][0];
            $total = $res['data'][1];
            $code  = '1';
        }
        if (empty($info)) {
            $code = '0';
        }

        $echoJson = array('code' => $code, 'data' => $info, 'total' => $total);

        //输出json数据
        echo jsonEncode($echoJson);
        exit();
    }

    /**
     * [getCate 获取产品栏目信息]
     * @method getCate
     * @link http://api.jw.com/shop/index/getCate/
     * @return [type]  [description]
     */
    public function getCate()
    {
        $where['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        //module　　：　　system　共享商品库，store为店铺的栏目分类
        $where['module'] = isset($_GET['module']) ? trim($_GET['module']) : 'system';
        $res             = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 200));
        if ($res['code'] == 0) {
            $echoJson = $res['data'][0];
        }

        //输出json数据
        echo jsonEncode($echoJson);
        exit();
    }

    /**
     * 添加商铺方法
     */
    public function addShop()
    {
        //$fields = array('userid','sex','wechat','username','name','catid');//最后一个name是店铺名称
        $userid      = $this->getUtil('session')->get('_userid');
        $shopInfo    = isset($_POST['shopinfo']) ? $_POST['shopinfo'] : '';
        $cateInfo    = isset($_POST['cateinfo']) ? $_POST['cateinfo'] : '';
        $productInfo = isset($_POST['productinfo']) ? $_POST['productinfo'] : '';
        $res         = InitPHP::getRemoteService('shop', 'transactionCreate', array($userid, $shopInfo, $cateInfo[0]['children'], $productInfo));
        if ($res['code'] == 200) {
            $editData = array('is_has_shop' => 1);

            $sessionUserPhone = $this->getUtil('session')->get('_phone');
            $redisKey         = 'user:' . $sessionUserPhone;

            $this->getRedis('default')->redis()->hmset($redisKey, $editData);
            $code = 0;
            $msg  = '您已成功开通店铺！';
            $data = $userid;
        } else {
            $code = 2;
            $msg  = '开通失败!';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    public function shopInfoUpdate()
    {
        $userid = $this->getUtil('session')->get('_userid');
        $data   = array('name', 'wechat', 'qq', 'phone', 'address', 'username');
        $where  = $this->controller->get_gp($data);
        $result = InitPHP::getRemoteService('shop', 'queryUp', array($where, $userid));
        //var_dump($result);die();
        if ($result) {
            $code = 0;
            $msg  = '更新成功';
            $data = $result;
        } else {
            $code = 2;
            $msg  = '更新失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);

    }

    //获得商铺栏目
    public function getShopCate()
    {
        $userid = $this->getUtil('session')->get('_userid');
        //$where['siteid'] = isset($_GET['siteid'])?intval($_GET['siteid']):1;
        //module　　：　　system　共享商品库，store为店铺的栏目分类
        $where['siteid'] = $userid;
        $where['module'] = isset($_GET['module']) ? trim($_GET['module']) : 'system';

        $res = InitPHP::getRemoteService('categories', 'lists', array($where, 0, 200));

        foreach ($res['data'][0] as $key => $value) {
            $productCount['catid'][] = $value['catid'];
            //如果有子类产品 不允许删除父类
            $productCount['sonid'][$key] = explode(',', $value['arrchildid']);
        }
        $productCount['proCount'] = InitPHP::getRemoteService('product', 'getProductInfoFromCatid', array($productCount['catid']));
        foreach ($res['data'][0] as $key => $value) {
            foreach ($productCount['proCount'] as $k => $v) {
                if ($key == $v['catid']) {
                    $res['data'][0][$key]['procount'][] = $v;
                }
            }
            $res['data'][0][$key]['procounts'] = count($res['data'][0][$key]['procount']);
        }

        foreach ($productCount['sonid'] as $keys => $values) {
            foreach ($values as $ks => $vs) {
                $res['data'][0][$keys]['sonids'] += intval($res['data'][0][$vs]['procounts']);
            }
        }
        //var_dump($productCount['sonid']);die();
        //var_dump($res['data'][0]);die();
        if ($res['code'] == 0) {
            $echoJson = $res['data'][0];
        }

        //输出json数据
        echo jsonEncode($echoJson);
        exit();
    }

    //修改商铺栏目名称
    public function updateShopCate()
    {
        $value = array('catid', 'catname', 'module');
        $where = $this->controller->get_gp($value);
        $res   = InitPHP::getRemoteService('categories', 'update', array(array('catname' => $where['catname']), array('catid' => $where['catid'])));
        if ($res) {
            $code = 0;
            $msg  = '更新成功';
            $data = $res;
        } else {
            $code = 2;
            $msg  = '更新失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    //添加商铺栏目
    public function addShopCate()
    {
        $value          = array('catname', 'parentid', 'module', 'child', 'arrparentid');
        $data           = $this->controller->get_gp($value);
        $siteid         = $this->getUtil('session')->get('_userid');
        $data['siteid'] = $siteid;
        $res            = InitPHP::getRemoteService('shop', 'createShopCate', array($data));
        if ($res) {
            $code = 0;
            $msg  = '添加成功';
            $data = $result;
        } else {
            $code = 2;
            $msg  = '添加失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    //添加商铺产品
    public function addShopProduct()
    {
        $userid          = $this->getUtil('session')->get('_userid');
        $where['userid'] = $userid;
        $where['status'] = 99;
        $productlist     = isset($_POST['product_info']) ? $_POST['product_info'] : '';
        $affred_rows = 0;
        //data = $this->controller->get_gp($value);
        foreach ($productlist as $catid => $_productList) {
            foreach ($_productList as $goods_id) {
                $where['is_up']  = 99;
                $where['fromid'] = $goods_id;
                $where['catid']  = $catid;
                $insertid   = InitPHP::getRemoteService('product', 'create', array($where));
                if($insertid)$affred_rows+=1;
            }
        }
        if ($affred_rows > 0 ) {
            $code = 0;
            $msg  = '添加成功'.$affred_rows.'条';
            $data = $result;
        } else {
            $code = 2;
            $msg  = '添加失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    public function showCateIcon()
    {
        $where = array();
        $res   = InitPHP::getRemoteService('iconManage', 'lists', array($where, 0, 200));

        $total = '0';
        $code  = '0';
        if ($res['code'] == 0) {
            $info  = $res['data'][0];
            $total = $res['data'][1];
            $code  = '1';
        }
        if (empty($info)) {
            $code = '0';
        }

        $echoJson = array('code' => $code, 'data' => $info, 'total' => $total);

        //输出json数据
        echo jsonEncode($echoJson);
        exit();
    }

    public function upCateIcon()
    {
        $value  = array('image', 'catid');
        $where  = $this->controller->get_gp($value);
        $result = InitPHP::getRemoteService('categories', 'update', array(array('image' => $where['image']), array('catid' => $where['catid'])));
        if ($result) {
            $code = 0;
            $msg  = '更新成功';
            $data = $result;
        } else {
            $code = 1;
            $msg  = '更新失败';
            $data = '';
        }
        InitPHP::Encode($code, $msg, $data);
    }

    public function showCateImage()
    {
        $value = array('catid');
        $where = $this->controller->get_gp($value);

        $result = InitPHP::getRemoteService('categories', 'get', array($where));
        if (empty($result)) {
            $code = '1';
        } else {
            $code = '0';
        }
        $echoJson = array('code' => $code, 'data' => $result);
        echo jsonEncode($echoJson);
        exit();
    }

    public function getShopClassify()
    {
        $value = array('uid');
        $where = $this->controller->get_gp($value);
        $res   = InitPHP::getRemoteService('product', 'indexLists', array(array('userid' => $where['uid']), 2000, 0, 'id', 'desc', '*'));
        foreach ($res['data'][0] as $key => $value) {
            if ($value['fromid'] == '') {
                $Shopcount[] = $value;
            } else {
                $platform[] = $value;
            }
        }
        $Shopcounts = count($Shopcount);
        $platforms  = count($platform);
        if ($res['data'][1] == 0) {
            $code = '1';
        } else {
            $code = '0';
        }
        $echoJson = array('code' => $code, 'data1' => $Shopcounts, 'data2' => $platforms);
        echo jsonEncode($echoJson);
        exit();
    }

    //删除产品为0的店铺栏目
    public function delShopCate()
    {
        $value = array('catid');
        $where = $this->controller->get_gp($value);
        if (!$where['catid']) {
            return false;
        }
        $catelist = InitPHP::getRemoteService('categories', 'get', array($where));
        //如果是子分类　更新父分类　如果是父分类　清空子分类
        if ($catelist['parentid'] != 0) {
            $fatherCate    = InitPHP::getRemoteService('categories', 'get', array(array('catid' => $catelist['parentid'])));
            $fatherChild   = explode(',', $fatherCate['arrchildid']);
            $fatherChild   = array_merge(array_diff($fatherChild, $where));
            $fatherChildid = implode(',', $fatherChild);
            $result        = InitPHP::getRemoteService('categories', 'delete', array($where));
            if ($result) {
                InitPHP::getRemoteService('categories', 'update', array(array('arrchildid' => $fatherChildid), array('catid' => $catelist['parentid'])));
                $code = '0';
                $msg  = '删除成功';
                $data = $result;
            } else {
                $code = '1';
                $msg  = '删除失败';
                $data = '';
            }
        } else {
            $sonids = explode(',', $catelist['arrchildid']);
            $result = InitPHP::getRemoteService('categories', 'delete', array($sonids));
            if ($result) {
                $code = '0';
                $msg  = '删除成功';
                $data = $result;
            } else {
                $code = '1';
                $msg  = '删除失败';
                $data = '';
            }
        }
        InitPHP::Encode($code, $msg, $data);
    }
    //返回剩余的数组元素
    public function returnNewDef($arr)
    {
        $firstElement = array_shift($arr);
        $newArr       = $arr;
        return $newArr;
    }


    /**
     * [lists] 获取商铺产品列表信息
     * @link http://api.jw.com/shop/index/lists
     * @param [catid] 栏目id
     * @param [keywords]  搜索关键字
     * @return [echoJson] 查询结果array 组成的json数据
     *
     */
    public function shoplists() {
        //过滤请求参数
        $fileds = array('catid', 'keywords', 'siteid', 'sysadd', 'is_up', 'order','sort');
        $data_gp = $this->controller->get_gp($fileds);

        $uid  = $this->getUtil('session')->get('_userid');
        $fromid = InitPHP::getRemoteService('product','get_fromid_by_field',array($uid));
        if($fromid){
            foreach ($fromid as $key => $value) {
                $where['shopfromids'][] = $value['fromid'];
            }
        }
        
        $data = array_filter($data_gp);
        $where = $data;
        if(isset($data['catid']) && (bool)$data['catid']){
            $catRes = InitPHP::getRemoteService('categories', 'get', array(array('catid'=>$data['catid'])));
            $catArr = explode(',',$catRes['arrchildid']);
            $where['catid'] = $catArr;
        }
        $where['userid'] = $data['siteid'];
        $where['status'] = 99;
        $where['is_up'] = 99;

        //查询条件

        unset($where['siteid']);
        unset($where['order']);
        unset($where['sort']);
        //is_exist = 1存在仓库中
        // $where['is_recycled'] = 1;
        // //上架属性 99 为上架  1下架
        // $where['is_up'] = 99;
        //分页量
        $offset = $_GET['offset'];
        //页码
        $page = max((int) $_GET['page'], 1);
        //sql limit 限制
        $limit = ($page - 1) * $offset;
        //排序字段
        $order = isset($data['order']) && intval($data['order']) != 1 ? trim($data['order']) : 'id';

        //排序方式
        $sort = $data['sort'];

        switch ($order) {
            case 'id':
            case 'sales':
                //调用产品服务list
                $res = InitPHP::getRemoteService('product', 'indexLists', array(
                    $where,
                    $offset,
                    $limit,
                    $order,
                    $sort,
                    'id,title,catid,thumb,sale_price,sales,fromid,is_up,is_recycled,fromid,level',
                ));
               // var_dump($res);die();
                break;
            case 'sale_price':
                //调用产品服务list
                $res = InitPHP::getRemoteService('product', 'lists', array(
                    $where,
                    $offset,
                    $limit,
                    $order,
                    $sort,
                    'id,title,catid,thumb,sale_price,sales,fromid,is_up,is_recycled,fromid,level',
                ));
                //var_dump($res);die();
                break;
            default:
                # code...
                break;
        }
        
        $proLevel = InitPHP::getRemoteService('proLevel', 'lists', array(array(), 0, 1000));

        foreach ($proLevel['data'][0] as $key => $value) {
            $prokey[] = $value['id'];
            $provalue[] = $value['name'];
        }
        $prol = array_combine($prokey, $provalue);
        foreach ($res['data'][0] as $k => $v) {
            $res['data'][0][$k]['level'] = $prol[$v['level']];
        }

        $total = '0';
        $code = '0';
        if ($res['code'] == 0) {
            $info = $res['data'][0];

            foreach ($info as $key => $value) {
                if ($value['is_up'] != 99 && $value['is_recycled'] != 1) {
                    unset($info[$key]);
                }
            }

            $total = $res['data'][1];
            $code = '1';
        }
        foreach ($info as $key => $value) {
            $info[$key]['thumb'] = picThumbSrc($value['thumb'], 200, 200);
        }
        if (empty($info)) {
            $code = '0';
        }

        $echoJson = array('code' => $code, 'data' => array_values($info), 'total' => $total);

        

        //输出json数据
        echo jsonEncode($echoJson);
        exit();
    }
}
