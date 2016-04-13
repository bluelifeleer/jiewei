<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-２２ 15:21:40
 * @Last Modified time: 2015-12-２２ 15:21:40
 */
class iconManageService extends Service
{
    /**
     * @var product_level
     */
    private $iconManageDao;
    public function __construct() {
        parent::__construct();
        $this->iconManageDao = InitPHP::getDao("iconManage");
    }

    /**
     * 获取单条数据
     * @param $iconManage
     */
    public function get($where) {
        return $this->iconManageDao->get($where);
    }
    
    /**
     * 获取子集列表数据
     * @param $iconManage
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function lists($where = array(),$num = 0, $offset = 15,  $order = 'id', $sort = 'asc', $fileds = '*') {
        $data = $this->iconManageDao->lists($where, $offset, $num, $order, $sort, $fileds);
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        }
        else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }
    
    /**
     * 更新数据
     * @param $iconManage
     */
    public function update($data, $where) {
        return $this->iconManageDao->update($data, $where);
    }
    
    /**
     * 新增数据
     * @param $iconManage
     */
    public function create($data) {
        return $this->iconManageDao->create($data);
    }
    
    /**
     * 删除数据
     * @param $ids 一个或者多个值
     */
    public function delete($ids) {
        return $this->iconManageDao->delete($ids);
    }

    /**
     * 根据条件查找子集
     * @param $sql 字符串 sql条件语句
     */
    public function query_select($where) {
        return $this->iconManageDao->query_select($where);
    }
}
