<?php

/**
 * 分享服务，系统服务层
 * @Author: liubo
 * @Date:   2015-12-19 15:21:40
 * @Last Modified time: 2016-03-09 22:05:49
 */
class shareService extends Service{
    /**
     * 获取用户邀请二维码
     * @param  [int]        $siteid     [当前店铺的ID]
     * @param  [int]        $userid     [推荐人ID]
     * @return [string]     $return     [二维码地址]
     */
    public function userQcode($siteid,$userid) {
        //return $siteid.'--'.$userid;
        $res = file_get_contents('http://Qr.code/api.php?userid='.$userid.'&siteid='.$siteid.'&action=1');
        return $res;
    }

    /**
     * 获取用户店铺分享二维码
     * @param  [int]        $siteid    [店铺id]
     * @param  [int]        $userid     [推荐人ID]
     * @return [string]     $return     [二维码地址]
     */
    public function storeQcode($siteid, $userid) {
        $res = file_get_contents('http://Qr.code/api.php?userid='.$userid.'&siteid='.$siteid.'&action=2');
        return $res;
    }
  
    /**
     * 获取商品分享二维码
     * @param  [int]        $goodsid    [商品ID]
     * @param  [int]        $userid     [用户ID]
     * @return [string]     $return     [二维码地址]
     */
    public function proQcode($goodsid,$userid) {
        $res = file_get_contents('http://Qr.code/api.php?userid='.$userid.'&productId='.$goodsid.'&action=3');
        return $res;
    }

    
}