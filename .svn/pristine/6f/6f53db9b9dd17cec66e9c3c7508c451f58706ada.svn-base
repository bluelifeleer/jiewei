<?php

/**
 * 商铺广告服务
 * @Author: seaven
 * @Date:   2015-12-２２ 15:21:40
 * @Last Modified time: 2015-12-２２ 15:21:40
 */
class shopAdvertService extends Service
{

    /**
     * @var shopAdvertDao
     */
    private $shopAdvertDao;
    public function __construct()
    {
        parent::__construct();
        $this->shopAdvertDao = InitPHP::getDao("shopAdvert");
    }

    /**
     * 获取单条数据
     * @param $proLevel
     */
    public function get($where) {
        return $this->shopAdvertDao->get($where);
    }

    /**
     * 获取子集列表数据
     * @param
     * $product
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     *  LIMIT $num,$offset
     */
    public function lists($where = array(), $offset = 15, $num = 0, $order = 'id', $sort = 'asc', $fileds = '*')
    {
        $data = $this->shopAdvertDao->lists($where, $offset, $num, $order, $sort, $fileds);

        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        } else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

    /**
     * 更新数据
     * @param array $data 更新数据
     * @param array $where　更新条件
     */
    public function update($data, $where)
    {
        return $this->shopAdvertDao->update($data, $where);
    }

    /**
     * 新增数据
     * @param  $data　添加数据
     * ＠return boolen
     */
    public function create($data)
    {
        return $this->shopAdvertDao->create($data);
    }

    /**
     * 通过商铺id返回广告信息
     * @param string $shopid shopid
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function listByShopId($shopid = '',$offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*'){


      $where['shop_id'] = $shopid;

      $data = $this->redPacketDao->lists($where, $offset, $num, $order, $sort, $fileds);
      if ($data) {
          return InitPHP::Encode(0, 'Success', $data, 1);
      } else {
          return InitPHP::Encode(3, 'Error', $data, 1);
      }

    }

    /**
     * 删除数据
     * @param　array|string $where 多个id 组成的数组　array(1,2,3) 单个id字符串　‘３’；
     *
     */
    public function delete($where)
    {
        return $this->shopAdvertDao->deleteBatch($where);
    }
    /**
     * 根据条件查找子集
     * @param $sql 字符串
     * sql条件语句
     */
    public function query_select($where)
    {
        return $this->shopAdvertDao->query_select($where);
    }
}
