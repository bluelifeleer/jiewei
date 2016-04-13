<?php
/**
 * @Author: 翁昌华
 * @Date:   2015-12-２２ 15:21:40
 * @Last Modified time: 2015-12-２２ 15:21:40
 */


class redPacketService extends Service{

    /**
     * @var redPacketDao
     *
     */
    private $redPacketDao;
    public function __construct()
    {
        parent::__construct();
        $this->redPacketDao = InitPHP::getDao("redPacket");
    }

    /**
     * 获取单条数据
     * @param 
     */
    public function get($where) {
        return $this->redPacketDao->get($where);
    }
    /**
     * 获取子集列表数据
     * @param
     * $product
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     *  LIMIT $num,$offset
     */
    public function lists($where = array(), $offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*')
    {
        $data = $this->redPacketDao->lists($where, $offset, $num, $order, $sort, $fileds);

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
        return $this->redPacketDao->update($data, $where);
    }
    /**
     * 新增数据
     * @param  $data　添加数据
     * ＠return boolen
     */
    public function create($data)
    {
        return $this->redPacketDao->create($data);
    }




    /**
     * 新增多条红包相同数据
     * @param  $data　添加数据
     * @param  $unm　 新增数量
     * ＠return boolen
     */
    public function transactionCreate($data,$num = 0){
        if($num < 1){
            return array('code' => 500, 'msg' => 'Error');//参数错误
        }
        $blag = true;
        $red_no = $data['red_no'];
         //开启事务
        $this->redPacketDao->transaction_start();
        for($i = 0; $i < $num; $i++){
          $insertRes = $this->redPacketDao->create($data);
          $card_no = $red_no.date('YmdHis',time()).$insertRes;
          $data['red_no'] = $card_no;
          $where['id'] = $insertRes;
          $updateRes = $this->redPacketDao->update($data,$where);
          if(!$insertRes ||!$updateRes) {
              $blag = false;
              return $blag;
          }
        }
      if ($blag) {
          //提交事务
          $this->redPacketDao->transaction_commit();
          return array('code' => 200, 'msg' => 'Success');//更新成功
      } else {
          //事务回滚
          $this->redPacketDao->transaction_rollback();
          return array('code' => 300, 'msg' => 'Error');//更新失败
      }

    }



    /**
     * 更新红包状态
     * @param array $where  多个id 组成的数组　array(1,2,3)
     * @param string $status 　使用状态　１：已使用２：已过期，　99:未使用（有效期内且未被使用）
     */
    public function updateStatus($where,$status){
        if(isset($status))  $data['status'] = $status;
        else return false;
        return  $this->redPacketDao->updateAttr($where,$data,'id');
    }


    /**
     * 通过用户id，返回与用户关联的红包信息
     * @param string $userid 用户id
     * @param string $stusts　　使用状态　１：已使用２：已过期，　99:未使用（有效期内且未被使用）
     * @param string $type　红包类型：１：现金红包：２：商品红包
     * @param $num 每次查询偏移量
     * @param $offset 分页量
     * LIMIT $num,$offset
     */
    public function listByUserid($userid,$status,$type,$offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*'){

        $where = array();
        if(isset($userid))   $where['userid'] = $userid;
        if(isset($status))   $where['status'] = $status;
        if(isset($type))     $where['type']   = $type;

        $data = $this->redPacketDao->lists($where, $offset, $num, $order, $sort, $fileds);
        if ($data) {
            return InitPHP::Encode(0, 'Success', $data, 1);
        } else {
            return InitPHP::Encode(3, 'Error', $data, 1);
        }
    }

     /**
     * 获取不同类型
     * @param unknown $type  红包类型：１：现金红包：２：商品红包
     */
    public  function listByType($type,$offset = 0, $num = 15, $order = 'id', $sort = 'asc', $fileds = '*'){
        $where = array();
        if(isset($type)) $where['type'] = $type;
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
        return $this->redPacketDao->deleteBatch($where);
    }
    /**
     * 根据条件查找子集
     * @param $sql 字符串
     * sql条件语句
     */
    public function query_select($where)
    {
        return $this->redPacketDao->query_select($where);
    }

}
