<?php
/**
 * @Author: 明艺
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-02-25 17:16:35
 */
class categoriesService extends Service
{
    /**
     * @var mini_video
     */
    private $CategoriesDao;
    public function __construct() {
        parent::__construct();
        $this->CategoriesDao = InitPHP::getDao("categories");
    }

    /**
     * 获取单条数据
     * @param $user
     */
    public function get($where) {
        return $this->CategoriesDao->get($where);
    }

    /**
     * 获取子集列表数据
     * @param $user
     */
    public function lists($where = array(), $offset = 0, $num = 15, $order = 'catid', $sort = 'asc', $key = 'catid', $fileds = '*') {
        $data = $this->CategoriesDao->lists($where, $num, $offset, $order, $sort, $key, $fileds);
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        }
        else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

    /**
     * 更新数据
     * @param $user
     */
    public function update($data, $where) {
        return $this->CategoriesDao->update($data, $where);
    }

    /**
     * 新增数据
     * @param $user
     */
    public function create($data) {
        return $this->CategoriesDao->create($data);
    }

    /**
     * 删除数据
     * @param　array|string $where 多个id 组成的数组　array(1,2,3) 单个id字符串　‘３’；
     *
     */
    public function delete($where)
    {
        return $this->CategoriesDao->deleteBatch($where);
    }
    /**
     * 根据条件查找子集
     * @param $sql 字符串 sql条件语句
     */
    public function query_select($where) {
        return $this->CategoriesDao->query_select($where);
    }
}
