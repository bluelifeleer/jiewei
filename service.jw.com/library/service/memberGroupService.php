<?php

/**
 * 用户群组系统服务层
 * @Author: 李鹏
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2015-12-24 21:37:23
 */
class memberGroupService extends Service{
    private $DB;

    public function __construct() {
        parent::__construct();
    }

    /**
     * 添加一个群组
     * @param [integer] $userid [用户ID,表示是哪个用户要创建群组]
     * @Author 李鹏
     * @data 2016-01-14
     */
     public function createGroup($userid){

       return InitPHP::getDao('memberGroup')->create();
     }
}
