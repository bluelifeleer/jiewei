<?php

/**
 * 获取用户二维码
 * @Author: 邵博
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2016-03-11 10:07:25
 */
class indexController extends Controller
{
    
    //Action白名单
    public $initphp_list = array(
        'userQcode',//获得用户二维码
        'shareProduct',//获得商品二维码
        'shopQcode'//获得店铺二维码
    );
    public function __construct() {
        parent::__construct();
    }
    /**
     * 个人中心，我的二维码
     * @return [type] [description]
     */
    public function userQcode(){
        $fileds = array(
          'siteid'
        );
        $uid = $this->getUtil('session')->get('_userid');
        $data = $this->controller->get_gp($fileds);

        $where['siteid'] = $data['siteid'];

        if($this->checkShop($uid)){
            $where['siteid'] = $uid;
        }else{
            $memberinfo = InitPHP::getRemoteService('account','get',array(array('userid'=>$uid)));

            $parentid= $memberinfo['data']['parentid'];
            
            if($this->checkShop($parentid)){
                $where['siteid'] = $parentid;
            }
        }

        $share = InitPHP::getRemoteService('share', 'userQcode', array($where['siteid'],$uid));

        echo json_encode(array('code' => 200,'data' => $share));
    }
    /**
     * 判断是否开店
     */
    public function checkShop($userid){
        
        $where['userid'] = $userid;
        $res = InitPHP::getRemoteService('shop','get',array($where));
        
        if($res) return true;
        
        return false;
    }
    /**
     * 分享商品
     * @return [type] [description]
     */
    public function shareProduct(){
        $productInfo = InitPHP::getRemoteService('product', 'get', array(array('id'=>(int)$_POST['id'])));
        $share = InitPHP::getRemoteService('share', 'proQcode', array((int)$_POST['id'],$productInfo['userid']));
        //$res = file_get_contents('http://Qr.code/api.php?userid='.$productInfo['userid'].'&siteid='.$productInfo['userid'].'&action=2');
        if($share != 300){
            echo json_encode(array('code' => 200,'data' => $share));
        }else{
            echo json_encode(array('code' => 300,'error' => '二维码生成失败'));
        }
    }
    /**
     * 分享店铺
     * @return [type] [description]
     */
    public function shopQcode(){
        $fileds = array(
          'siteid',
          'userid'
        );
        $where = $this->controller->get_gp($fileds);

        $share = InitPHP::getRemoteService('share', 'storeQcode', array($where['siteid'],$where['userid']));

        echo json_encode(array('code' => 200,'data' => $share));
    }

}
