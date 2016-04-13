<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-２２ 15:21:40
 * @Last Modified time: 2015-12-２２ 15:21:40
 */
class productService extends Service
{

    /**
     *
     * @var product
     */
    private $productDao;
    private $productDetailsDao;
    private $categoriesDao;
    private $productlevelDao;

    public function __construct()
    {
        parent::__construct();
        $this->productDao        = InitPHP::getDao("product");
        $this->productDetailsDao = InitPHP::getDao("productDetails");
        $this->productlevelDao   = InitPHP::getDao('proLevel');
    }

    /**
     * 获取单条数据产品所有详细信息
     *
     * @param string $where  条件
     * @param boolean $content
     * @param boolean $categores
     * @param boolean $level
     * @return array string　　返回一个产品详情信息数组
     */
    public function get($where, $content = false, $categories = false, $level = false)
    {
        // 判断是否存在产品查询条件$where
        if (!is_array($where)) {
            return false;
        }

        // 根据查询条件获取产品的基本信息
        $productInfo = $this->productDao->get($where);
        if ($productInfo) {

            if ($productInfo['fromid']) {
                // 平台导入
                $repProductInfo = $this->productDao->get(array('id' => $productInfo['fromid']));
                //////////////////
                //通过原始ID更换产品的信息 //
                //////////////////
                $repProductInfo['id']           = $productInfo['id'];
                $repProductInfo['catid']        = $productInfo['catid'];
                $repProductInfo['is_hot']       = $productInfo['is_hot'];
                $repProductInfo['is_up']        = $productInfo['is_up'];
                $repProductInfo['is_recycled']  = $productInfo['is_recycled'];
                $repProductInfo['is_recommend'] = $productInfo['is_recommend'];
                $repProductInfo['is_explosion'] = $productInfo['is_explosion'];
                $repProductInfo['is_overseas']  = $productInfo['is_overseas'];
                $repProductInfo['is_real']      = $productInfo['is_real'];
                $repProductInfo['userid']       = $productInfo['userid'];
                $repProductInfo['username']     = $productInfo['username'];
                $repProductInfo['sysadd']       = $productInfo['sysadd'];
                $repProductInfo['fromid']       = $productInfo['fromid'];
                $repProductInfo['sales']       = $productInfo['sales'];
                $productInfo                    = $repProductInfo;
                $productInfo['purchase_price']  = (double) $productInfo['purchase_price'];
                $productInfo['cost_price']      = (double) $productInfo['cost_price'];
                $productInfo['sale_price']      = (double) $productInfo['sale_price'];

            } else {

                $productInfo['purchase_price'] = (double) $productInfo['purchase_price'];
                $productInfo['cost_price']     = (double) $productInfo['cost_price'];
                $productInfo['sale_price']     = (double) $productInfo['sale_price'];
                $productInfo['transit_type']   = $productInfo['transit_type'];
                $productInfo['transit_cost']   = (double) $productInfo['transit_cost'];
            }

        }
        // 判断是否需要获取产品图文信息
        if ($content && $productInfo) {
            if ($productInfo['fromid']) {
                $proId = $productInfo['fromid'];
            } else {

                $proId = $productInfo['id'];
            }
            $contentInfo = InitPHP::getDao("productDetails")->get(array(
                'pro_id' => $proId,
            ));
            if ($contentInfo) {
                $productInfo['content'] = $contentInfo['content'];
                $productInfo['params']  = $contentInfo['params'];
            }
        }
        // 判断是否需要获取产品栏目信息
        if ($categories && $productInfo) {
            $cateId         = $productInfo['catid'];
            $categoriesInfo = InitPHP::getDao("categories")->get(array(
                'id' => $catId,
            ));
            if ($categoriesInfo) {
                $productInfo['catname'] = $categoriesInfo['catname'];
            }

        }
        // 判断是否需要获取产品产品等级信息
        if ($level && $productInfo) {
            $levelId   = $productInfo['level'];
            $levelInfo = InitPHP::getDao('proLevel')->get(array(
                'id' => $levelId,
            ));
            if ($levelInfo) {
                $productInfo['levelId']    = $levelInfo['id'];
                $productInfo['levelName']  = $levelInfo['name'];
                $productInfo['levelValue'] = $levelInfo['value'];
            }
        }

        return $productInfo;
    }

    /**
     * 获取子集列表数据
     *
     * @param
     *            $product
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     *            LIMIT $num,$offset
     */
    public function lists($where = array(), $offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*')
    {

        // if ($where['userid'] != 1 && is_array($where) && $where['siteid'] != 1) {
        if ($where['userid'] != 1 && is_array($where)) {
            // 
            if (isset($where['catid'])) {
                $this->categoriesDao = InitPHP::getDao("categories");
                $catRes              = $this->categoriesDao->get(array('catid' => $where['catid']));
                $catArr              = explode(',', $catRes['arrchildid']);
                $where['catid']      = $catArr;
            }

            $cate = $this->productDao->lists($where);
            //return $cate;
            foreach ($cate[0] as $key => $value) {
                //去重开始　判断是否有shopfromids　邵博
                // if(isset($where['shopfromids'])){
                //     if(!is_array($where['shopfromids'])){
                //        $where['shopfromids'] = array($where['shopfromids']);
                //     }
                //     foreach ($where['shopfromids'] as $keysvalue) {
                //         if(in_array($keysvalue,$value['id'])){
                //             unset($value);
                //         }
                //     }
                // }
                //去重结束
                if ($value['fromid'] > 0) {
                    $shopProid[$key]                = $value['fromid'];
                    $shopTemid[$key]                = $value['fromid'];
                    $shopCatid[$value['fromid']]    = $value['catid'];
                    $shopSaleid[$value['fromid']]   = $value['sales'];
                    $shopSysaddid[$value['fromid']] = $value['sysadd'];
                    $shopHostid[$value['fromid']] = $value['is_host'];
                    $shopRecommendid[$value['fromid']] = $value['is_recommend'];
                } else {
                    $shopProid[$key] = $value['id'];
                }
            }
            $wherePro['id'] = array_values($shopProid);
            
            $data           = $this->productDao->lists($wherePro, $offset, $num, $order, $sort, $fileds);

            $shopRid = array_flip($shopTemid);
            if ($data) {
                foreach ($data[0] as $key => $value) {
                    if (in_array($value['id'], $shopTemid)) {
                        $data[0][$key]['id']     = $shopRid[$key];
                        $data[0][$key]['fromid'] = $key;
                        $data[0][$key]['catid']  = $shopCatid[$key];
                        $data[0][$key]['sales']  = $shopSaleid[$key];
                        $data[0][$key]['sysadd'] = $shopSysaddid[$key];
                        $data[0][$key]['is_host'] = $shopHostid[$key];
                        $data[0][$key]['is_recommend'] = $shopRecommendid[$key];
                    }
                }
                // $data[1] =  $count[1];
                return InitPHP::Encode(0, 'Success', $data, 1);
            } else {
                return InitPHP::Encode(3, 'Error', '', 1);
            }
        } else {
            $data = $this->productDao->lists($where, $offset, $num, $order, $sort, $fileds);
           
            if ($data) {
                return InitPHP::Encode(0, 'Success', $data, 1);
            } else {
                return InitPHP::Encode(3, 'Error', '', 1);
            }

        }
        
    }

    /**
     * 获取子集列表数据
     *
     * @param
     *            $product
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     *            LIMIT $num,$offset
     */
    public function indexLists($where = array(), $offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*')
    { 
        $data = $this->productDao->lists($where, $offset, $num, $order, $sort, $fileds);
        if ($data) {

            $info = $data[0];
          
            foreach ($info as $key => $value) {
                //去重开始　判断是否有shopfromids　邵博
                // if(isset($where['shopfromids'])){
                //     if(!is_array($where['shopfromids'])){
                //        $where['shopfromids'] = array($where['shopfromids']);
                //     }
                //     //return $where['shopfromids'];
                //     // return $where['shopfromids'];
                //     foreach ($where['shopfromids'] as $keysvalue) {
                //         $a = array($keysvalue);
                //         if(in_array($keysvalue,$value['id'])){
                //             unset($value);
                //         }
                //     }

                // }
                // return $a;
                //去重结束
                //////////////////
                //通过原始ID更换产品的信息 //
                //////////////////
                if($value['fromid']){
                    $repProductInfo = $this->productDao->get(array('id'=>$value['fromid']));
                    $repProductInfo['id'] = $value['id'];
                    $repProductInfo['catid'] = $value['catid'];
                    $repProductInfo['is_hot'] = $value['is_hot'];
                    $repProductInfo['is_explosion'] = $value['is_explosion'];
                    $repProductInfo['userid'] = $value['userid'];
                    $repProductInfo['username'] = $value['username'];
                    $repProductInfo['sysadd'] = $value['sysadd'];
                    $repProductInfo['fromid'] = $value['fromid'];
                    $repProductInfo['sales'] = $value['sales'];


                    unset($repProductInfo['cost_price']);
                    unset($repProductInfo['create_time']);
                    unset($repProductInfo['is_explosion']);
                    unset($repProductInfo['is_hot']);
                    unset($repProductInfo['is_overseas']);
                    unset($repProductInfo['is_real']);
                    unset($repProductInfo['is_recommend']);
                    unset($repProductInfo['level']);
                    unset($repProductInfo['product_sn']);
                    unset($repProductInfo['purchase_price']);
                    unset($repProductInfo['status']);
                    unset($repProductInfo['userid']);
                    unset($repProductInfo['pictures']);
                    unset($repProductInfo['short_desc']);
                    unset($repProductInfo['update_time']);
                    unset($repProductInfo['keywords']);
                    unset($repProductInfo['username']);

                    $info[$key] = $repProductInfo;
                }
            }
            $data[0] = $info;
            return InitPHP::Encode(0, 'Success', $data, 1);
        } else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

    /**
     * 更新数据
     *
     * @param
     * $product
     */
    public function update($data, $where)
    {
        return $this->productDao->update($data, $where);
    }

    /**
     * 以事务的方式一同更新产品基本信息和图文详情信息，
     *
     * @param $infoData 产品基本信息的更新数据
     * @param $infoWhere 产品基本信息更新条件
     * @param $detailData 产品图文详情更新数据
     * @param $detailWhere 产品图文详情更新条件
     * @return boolean 200 参数错误 300 更新成功 500 更新失败
     */
    public function transactionUpdate($infoData, $infoWhere, $detailData, $detailWhere)
    {
        //判断参数
        if (!isset($infoData) || !isset($infoWhere) || !isset($detailData) || !isset($detailWhere)) {
            return array('code' => 500, 'msg' => 'Error'); //参数错误
        }
        //开启事务
        $this->productDao->transaction_start();
        //产品基本信息更新
        $infoRes = $this->productDao->update($infoData, $infoWhere);
        //产品图文信息更新
        $detailRes = $this->productDetailsDao->update($detailData, $detailWhere);

        if ($infoRes && $detailRes) {
            //提交事务
            $this->productDao->transaction_commit();
            return array('code' => 200, 'msg' => 'Success'); //更新成功
        } else {
            //事务回滚
            $this->productDao->transaction_rollback();
            return array('code' => 300, 'msg' => 'Error'); //更新失败
        }
    }

    /**
     * 新增数据
     * @param  $data　添加数据
     * ＠return boolen
     */
    public function create($data)
    {
        if(isset($data['fromid']) && $this->productDao->get(array('catid'=>$data['catid'],'userid'=>$data['userid'],'fromid'=>$data['fromid']))){
            return 0;
        }
        return $this->productDao->create($data);
    }
    /**
     * 事务方式同时插入产品基本信息和图文信息
     * @param unknown $infoData　基本信息
     * @param unknown $detailData　图文信息
     * @return boolean 200 参数错误 300 新增成功 500 新增失败
     */
    public function transactionCreate($infoData, $detailData)
    {
        //判断参数
        if (!isset($infoData) || !isset($detailData)) {
            return json_encode(array('code' => 500, 'msg' => 'Error')); //参数错误
        }
        //开启事务
        $this->productDao->transaction_start();
        //插入基本信息

        $infoRes = $this->productDao->create($infoData);

        $detailData['pro_id'] = $infoRes;
        //插入图文信息
        $detailRes = $this->productDetailsDao->create($detailData);

        if ($infoRes && $detailRes) {
            //提交事务
            $this->productDao->transaction_commit();
            return array('code' => 200, 'msg' => 'Success'); //更新成功
        } else {
            //事务回滚
            $this->productDao->transaction_rollback();
            return array('code' => 300, 'msg' => 'Error'); //更新失败
        }
    }
    /**
     *
     * 产品移动到回收站中和从回收站移动到仓库中
     * @param array $where 多个id 组成的数组　array(1,2,3)
     * @param bool $in　true 移入　　false 移出
     */
    public function recycle($where, $in = true)
    {
        return $this->productDao->recycle($where, $in);
    }
    /**
     * 更新产品的r热门属性
     * @param array $where 多个id 组成的数组　array(1,2,3)
     * @param array $attr  [is_hot]  是否热门  1,热门，99：非热门，
     */
    public function updateAttritute($where, $attr)
    {
        if (isset($attr)) {
            $data['is_hot'] = $attr;
        } else {
            return false;
        }

        return $this->productDao->updateAttr($where, $data, 'id');
    }

    /**
     * 审核产品
     * @param array $where  多个id 组成的数组　array(1,2,3)
     * @param string $status 商品审核状态 0：未审核处理状态，1,未通过审核，99;通过审核（平台发布不需审核）
     */
    public function approval($where, $status)
    {
        if (isset($status)) {
            $data['status'] = $status;
        } else {
            return false;
        }

        return $this->productDao->updateAttr($where, $data, 'id');
    }

    /**
     * 删除数据
     * @param　array|string $where 多个id 组成的数组　array(1,2,3) 单个id字符串　‘３’；
     *
     */
    public function delete($where)
    {
        return $this->productDao->deleteBatch($where);
    }

    /**
     * 更新库存
     * [updateInventory] 更新库存
     * @param  [string] $id [更新ｉｄ]
     * @param  [string] $num [库存减少量]
     * @return [boolen]     [true 更新成功 false 更新失败]
     */
    public function updateInventory($id, $num)
    {
        if (!isset($id)) {
            return false;
        }

        $where['id']       = $id;
        $res               = $this->productDao->get($where, 'inventory');
        $data['inventory'] = $res['inventory'] - $num;
        return $this->productDao->update($data, $where);

    }

    /**
     *  产品上下架状态
     * @param Array $where 多个id 组成的数组　array(1,2,3)
     * @param boolean $up  true 上架　　false 下架
     */
    public function updateStatus($where, $up)
    {
        return $this->productDao->updateStatus($where, $up);
    }

    /**
     * 根据条件查找子集
     *
     * @param $sql 字符串
     *            sql条件语句
     */
    public function query_select($where)
    {
        return $this->productDao->query_select($where);
    }

    /**
     * /根据fromid辨识商铺产品
     * @param  [type] $catid  [description]
     * @param  [type] $siteid [description]
     * @param  [type] $search [description]
     * @return [type]         [description]
     */
    public function query_search_null($siteid, $search)
    {
        $data = $this->productDao->query_search_null($siteid, $search);
        if (count($data) != 0) {
            foreach ($data as $key => $value) {
                if ($value['fromid']) {
                    $repProductInfo                 = $this->productDao->get(array('id' => $value['fromid']));
                    $levelnfo                       = $this->productlevelDao->get(array('id' => $repProductInfo['level']));
                    $repProductInfo['id']           = $value['id'];
                    $repProductInfo['catid']        = $value['catid'];
                    $repProductInfo['is_hot']       = $value['is_hot'];
                    $repProductInfo['is_explosion'] = $value['is_explosion'];
                    $repProductInfo['userid']       = $value['userid'];
                    $repProductInfo['username']     = $value['username'];
                    $repProductInfo['sysadd']       = $value['sysadd'];
                    $repProductInfo['fromid']       = $value['fromid'];
                    $repProductInfo['level']        = $levelnfo['name'];

                    //$repProductInfo['level'] = $value['level'];

                    unset($repProductInfo['cost_price']);
                    unset($repProductInfo['create_time']);
                    unset($repProductInfo['is_explosion']);
                    unset($repProductInfo['is_hot']);
                    unset($repProductInfo['is_overseas']);
                    unset($repProductInfo['is_real']);
                    unset($repProductInfo['is_recommend']);
                    //unset($repProductInfo['level']);
                    unset($repProductInfo['product_sn']);
                    unset($repProductInfo['purchase_price']);
                    unset($repProductInfo['status']);
                    unset($repProductInfo['userid']);
                    unset($repProductInfo['sysadd']);
                    unset($repProductInfo['pictures']);
                    unset($repProductInfo['short_desc']);
                    unset($repProductInfo['update_time']);
                    unset($repProductInfo['keywords']);
                    unset($repProductInfo['username']);

                    $data[$key] = $repProductInfo;
                }
            }
        }
        return $data;
    }

    /**
     *  传入catid 取得商品信息
     */
    public function getProductInfoFromCatid($where)
    {
        return $this->productDao->getProductInfoFromCatid($where);
    }

    /**
     * 获取商品的数量
     * @param  [string] $shop_id [商铺用户的id]
     * @return [integer] $counts   [商品的个数]
     * @author 李鹏
     * @date 2016-03-16
     */
    public function getCounts($shop_id)
    {
        $where = array('userid' => $shop_id);
        $count = $this->productDao->getCounts($where);
        if ($count) {
            return InitPHP::Encode(0, 'Success', $count, 1);
        } else {
            return InitPHP::Encode(1, 'Error', $count, 1);
        }
    }

    /**
     * 删除一条商品数据
     * @param  [string] $userid    [店铺用户的id]
     * @param  [integer] $productId [商品id]
     * @return [blooean] $dele [删除是否成功]
     * @author 李鹏
     * @date 2016-03-16
     */
    public function deleteProduct($userid, $productId)
    {
        $where = array('userid' => $userid, 'id' => $productId);
        $dele  = $this->productDao->delete($where);
        if ($dele) {
            return InitPHP::Encode(0, 'Success', $dele, 1);
        } else {
            return InitPHP::Encode(1, 'Error', $dele, 1);
        }
    }

    /**
     * 查找开店时候的fromid
     */
    public function get_fromid_by_field($where){
        return $this->productDao->get_fromid_by_field($where);
    }
}
