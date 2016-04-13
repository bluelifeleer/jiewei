<?php

/**
 * @Author: 刘波
 * @description: 系统设置
 * @Date:   2015-07-23 10:26:49
 * @Last Modified time: 2015-07-23 10:36:38
 */
class settingController extends Controller
{
    // Action白名单
    public $initphp_list = array(
        'init',
        'dump',
        'message',
        'message_tpl',
        'taobao_api'
    );

    public function __construct()
    {
        parent::__construct();
        // 判断是否登入状态
        InitPHP::getService("admin")->check_admin();
    }

    /**
     * 系统基本设置
     */
    function init()
    {
        if (intval($_POST['dosubmit']) == 1) {
            $fileds = array(
                'site_name',
                'site_keywords',
                'site_description',
                'site_icp'
            );
            
            $data = $this->controller->get_gp($fileds);
            $res = setting($data, 'set');
            if ($res) {
                showmessage('更新成功');
            } else {
                showmessage('更新失败');
            }
        } else {
            $setting_basic = setting(array(
                'site_name',
                'site_keywords',
                'site_description',
                'site_icp'
            ), 'get');
            include V("system", "setting_base");
        }
    }

    /**
     * 防灌水设置
     */
    function dump()
    {
        if (isset($_POST['dosubmit'])) {} else {
            include V("system", "setting_dump");
        }
    }


    /**
     * 淘宝API
     */
    function taobao_api()
    {
        if (intval($_POST['dosubmit']) == 1) {
            $fileds = array(
                'test_price',
                'public_dividedInto',
                'weike_dividedInto',
                'zhihui_dividedInto'
            );
            $data = $this->controller->get_gp($fileds);
            $data = array_filter($data);
            $res = setting($data, 'set');
            if ($res) {
                showmessage('更新成功');
            } else {
                showmessage('更新失败');
            }
        } else {
            $info = setting(array(
                'public_dividedInto',
                'test_price',
                'weike_dividedInto',
                'zhihui_dividedInto'
            ), 'get');
            // $test_price = setting();
            include V("system", "setting_pay");
        }
    }
}