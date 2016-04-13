<?php

/**
 *管理员控制类
 */
class adminService extends Service
{
    
    /**
     * @var userDao
     */
    private $userDao;
    
    /**
     * 验证帐号及密码   username & password
     * @param username  用户帐号
     * @param password  用户密码
     */
    final public function CheckPasswd($username, $password) {
        $username = trim($username);
        $password = trim($password);
        $this->adminDao = InitPHP::getDao("admin");
        $userInfo = $this->adminDao->get_User_by_field(array('username' => $username));
        if (!$userInfo) return 1;
        if ($userInfo['password'] === md5(md5($password) . $userInfo['encrypt'])) return $userInfo;
        return 2;
    }
    
    /**
     * 记录用户登入时间及IP
     */
    final public function updateUser($userid, $info = false) {
        $this->adminDao = InitPHP::getDao("admin");
        if (!$info) {
            $info['lastlogin'] = SYS_TIME;
            $info['ip'] = $this->getLibrary('ip')->get_ip();
        }
        return $this->adminDao->update($info, $userid);
    }
    
    /**
     * 获取单条菜单
     * @param $user
     */
    public function get($where) {
        return InitPHP::getDao("admin")->get($where);
    }
    
    /**
     * 获取子集列表菜单
     * @param $user
     */
    public function lists($where = array(), $offset = 0, $num = 15, $order = 'userid', $sort = 'asc', $key = 'userid', $fileds = '*') {
        return InitPHP::getDao("admin")->lists($where, $offset, $num, $order, $sort, $key, $fileds);
    }
    
    /**
     * 更新菜单
     * @param $user
     */
    public function update($data, $where) {
        return InitPHP::getDao("admin")->update($data, $where);
    }
    
    /**
     * 新增菜单
     * @param $user
     */
    public function create($data) {
        return InitPHP::getDao("admin")->create($data);
    }
    
    /**
     * 删除菜单
     * @param $ids 一个或者多个值
     * @param $id_key 上面值的对应的键
     */
    public function delete($ids) {
        return InitPHP::getDao("admin")->delete($ids);
    }
}
