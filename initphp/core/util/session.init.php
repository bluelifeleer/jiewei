<?php
if (!defined('IS_INITPHP')) {exit('Access Denied!');}
/*
 *用redis实现跨服务器session
 *注意需要安装phpredis模块
 **/
class sessionInit
{
    public $expire = 86400; //过期时间
    public $sso_session; //session id
    public $session_folder; //session目录
    public $cookie_name; //cookie的名字
    public $redis; //redis连接
    public $cache; //缓存session
    public $expireAt; //过期时间

    /*
     *初始化
     *参数
     *$redis:php_redis的类实例
     *$cookie_name:cookie的名字
     *$session_id_prefix:sesion id的前缀
     **/
    public function sessionInit($expire = 6400, $cookie_name = "sso_session", $session_id_prefix = "")
    {
        $conf   = InitPHP::getConfig();
        $config = $conf['session']['redis'];
        $redis  = new Redis();
        $redis->connect($config['server'], $config['port']);
        $redis->auth($config['auth']);
        $redis->select($config['select']);
        $this->redis = $redis;

        $this->cookie_name    = $cookie_name;
        $this->session_folder = "sso_session:";
        //若是cookie已经存在则以它为session的id
        if (isset($_COOKIE[$this->cookie_name])) {
            $this->sso_session = $_COOKIE[$this->cookie_name];
        } else {
            $this->expire   = $expire;
            $this->expireAt = time() + $this->expire;
            //在IE6下的iframe无法获取到cookie,于是我使用了get方式传递了cookie的名字
            if (isset($_SERVER['HTTP_TOKEN']) && $_SERVER['HTTP_TOKEN'] != 'undefined' && $_SERVER['HTTP_TOKEN'] != '' && $_SERVER['HTTP_TOKEN'] != 'null') {
                $this->sso_session = $_SERVER['HTTP_TOKEN'];
            } else {
                if (!session_id()) {
                    session_start();
                }

                $this->sso_session = $this->session_folder . $session_prefix . session_id();
            }
        }
        setcookie($this->cookie_name, $this->sso_session, $this->expireAt, "/", '.zj3w.net');
        $this->expire();
    }

    public function get_session_id()
    {
        return $this->sso_session;
    }

    /*
     *设置过期时间
     *参数
     **/
    public function expire($expire = 6400)
    {
        $this->expire   = $expire;
        $this->expireAt = time() + $this->expire;
        //设置session过期时间
        $this->redis->expireat($this->sso_session, $this->expireAt);
    }

    /*
     *设置多个session的值
     *参数
     *$array:值
     **/
    public function setMutil($array)
    {
        $this->redis->hmset($this->sso_session, $array);
    }
    /*
     *设置session的值
     *参数
     *$key:session的key
     *$value:值
     **/
    public function set($key, $value)
    {
        $this->redis->hset($this->sso_session, $key, $value);
    }
    /*
     *设置session的值为对象
     *参数
     *$key:session的key
     *$object:对象
     **/
    public function setObject($key, $object)
    {
        $this->redis->hset($this->sso_session, $key, serialize($object));
    }

    /*
     *获取全部session的key和value
    @return: array
     **/
    public function getAll()
    {
        return $this->redis->hgetall($this->sso_session);
    }

    /*
     *获取一个session的key和value
    @return: array
     **/
    public function get($key)
    {
        return $this->redis->hget($this->sso_session, $key);
    }

    /*
     *获取session的值为对象
     *参数
     *$key:session的key
     *$value:cookie的名字
     **/
    public function getObject($key)
    {
        return unserialize($this->redis->hget($this->sso_session, $key));
    }
    /*
     *从缓存中获取一个session的key和value
    @return: array
     **/
    public function getFromCache($key)
    {
        if (!isset($this->cache)) {
            $this->cache = $this->getall();
        }
        return $this->cache[$key];
    }

    /*
     *删除一个session的key和value
    @return: array
     **/
    public function del($key)
    {
        return $this->redis->hdel($this->sso_session, $key);
    }
    /*
     *删除所有session的key和value
    @return: array
     **/
    public function delAll()
    {
        return $this->redis->delete($this->sso_session);
    }
}
