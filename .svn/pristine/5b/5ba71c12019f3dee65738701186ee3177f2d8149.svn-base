<?php

class userDao extends Dao
{

    private $tb_name;

    private $tb_fileds;

    public function __construct()
    {
        parent::__construct();
        $this->tb_name = 'users';
        $this->tb_fileds = '';
    }

    /**
     * 添加数据
     *
     * @param
     *            fileds;
     * @return status
     * @author bluelife
     *         @date 2015-12-21
     */
    public function create($data)
    {
        return $this->dao->db->insert($data, $this->tb_name);
    }

    /**
     * 根据条件查找一条数据数据
     *
     * @param
     *            fileds;
     * @return status
     * @author bluelife
     *         @date 2015-12-21
     */
    public function find_one($data)
    {
        return $this->dao->db->get_one_by_field($data, $this->tb_name);
    }

    /**
     * 获取所有数据
     *
     * @param
     *            fileds;
     * @return status
     * @author bluelife
     *         @date 2015-12-21
     */
    public function get()
    {}

    /**
     * 更新数据
     *
     * @param
     *            fileds;
     * @return status
     * @author bluelife
     *         @date 2015-12-21
     */
    public function update()
    {}

    /**
     * 删除数据
     *
     * @param
     *            fileds;
     * @return status
     * @author bluelife
     *         @date 2015-12-21
     */
    public function delete()
    {}
    
    // 获取数据个数
    public function get_count($data)
    {
        return $this->dao->db->get_count($this->tb_name, $data);
    }
}
