/*
 * @Author: anchen
 * @Date:   2015-12-31 11:03:47
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-01-31 19:13:57
 */
$(function() {
    'use strict';

    $(document).on("pageInit", "#page-add-address", function(e, id, page) {
        $("#city-picker").cityPicker({});
        var userInfo = sessionStorage.getItem('user_info') || '{}';
        //获取用户信息
        var userInfoStrToJson = JSON.parse(userInfo);

        //var userid = userInfoStrToJson['userid'];
        var ship_data = {};
        var aid = getRrlParam('aid');
        // var userid = userInfoStrToJson['userid'];
        if (aid) {
            $('#putaddress').html('删除收货地址');
            $('#putaddress').attr('id', 'deladdress');
            up_address(aid, page);
        } else {
            $(page).on("click", "#putaddress", function() {
                add_address();
            });
        }
        //删除事件
        $(page).on("click", "#deladdress", function() {
            var url = encodeURI(apiUrl + 'address/index/del_address');
            $.confirm('是否删除?', function() {
                    $.ajax({
                        url: url,
                        async: false,
                        type: 'POST',
                        data: {
                            aid: aid
                        },
                        headers: {
                            "Token": sso_Token
                        },
                        success: function(result) { 
                            var data = JSON.parse(result);
                            if (data.code == 0) {
                                var info = data.data;
                                $.toast('删除成功!');
                                $.router.loadPage('address.php');
                            } else {
                                $.toast('修改失败!');
                                return false;
                            }
                        }

                    });
                },
                function() {
                    return false;
                })
        });
        //
        //是否默认
    });



    //收货地址列表
    $(document).on("pageInit", "#page-list-address", function(e, id, page) {
        // var chl = new checkLogin();
        // if(!chl.check('user_info')){
        //   window.location.href='login.php';
        // }else{
        //     var userInfoStrToJson = $.parseJSON(chl.check('user_info'));
        // }
        var url = encodeURI(apiUrl + 'address/index/show_address');

        $.ajax({
          url: url,
          async: false,
          type: 'GET',
          headers: {
            "Token": sso_Token
          },
          success: function(result) {
            result = JSON.parse(result);
            if (result['code'] == 0) {
                var i = '';
                var temp = '';
                for (i in result.data) {
                    var isDefault = result.data[i]['defaultv'] && parseInt(result.data[i]['defaultv']) == 1 ? '默认' : '';
                    temp += '<a href="add_address.php?aid=' + result.data[i]['id'] + '">' +
                        '<div class="pad10 borb1 bce6 c666 bgfff">' +
                        '<div class="marb5">' +
                        '<span>' + result.data[i]['username'] + '</span><span class="flr">' + result.data[i]['mobile'] + '</span>' +
                        '</div><div>' +
                        '<span>' + result.data[i]['detail_address'] + ' ' + result.data[i]['code'] + '</span><span class="flr">' + isDefault + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                }
            } else {
                temp = '<div class="fs07 c666 txac mart20">您还没有添加收货地址</div>';
            }
            $('#page-list-address .infinite-scroll').html(temp);
          }

        });

    });



    function add_address() {
        var ship_data = {};
        ship_data.name = $("#city-picker").val();
        var username = $("#username").val();
        var mobile = $("#mobile").val();
        var code = $("#code").val();
        var daddress = $("#daddress").val();
        if ($("#box1").is(':checked')) {
            var defaultvalue = 1;
        } else {
            var defaultvalue = 0;
        }
        //var defaultvalue = $("#box1").val();
        if (!username) {
            $.toast('请填写您的收货人!');
            return false;
        }
        if (!mobile) {
            $.toast('请填写您的手机号码!');
            return false;
        }
        if (!ship_data.name) {
            $.toast('请填写您的地区!');
            return false;
        }
        if (!daddress) {
            $.toast('请填写您的详细地址!');
            return false;
        }
        var url = encodeURI(apiUrl + 'address/index/add_address');

        $.ajax({
            url: url,
            async: false,
            type: 'POST',
            data: {
                dataType: "json",
                ship_data: ship_data,
                username: username,
                mobile: mobile,
                code: code,
                daddress: daddress,
                defaultvalue: defaultvalue
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = $.parseJSON(result);
                if (data.code == 0) {
                    var info = data.data;
                    $.toast('添加成功!');

                    if(!isEmpty(getRrlParam('backPage'))){
                      //返回上一页
                      var form_app_page = getRrlParam('backPage');
                      $.router.loadPage(form_app_page,true);
                    }else{
                       $.router.loadPage('address.php');
                    }
                   
                } else {
                    $.toast('添加失败!');
                    return false;
                }
            }

        });

    }

    function up_address(aid, page) {
        var ship_data = {};
        var url = encodeURI(apiUrl + 'address/index/up_address');
        var uplink = '';

        $.ajax({
            url: url,
            async: false,
            type: 'POST',
            data: {
                dataType: "json",
                aid: aid,
            },
            headers: {
                "Token": sso_Token
            },
            success: function(result) {
                var data = $.parseJSON(result);
                var temp = '';
                if (data.code == 0) {
                    temp = data.data;
                    $("#page-add-address .title").html('修改收货地址');
                    $("#city-picker").val(temp.ship_data);
                    $("#username").val(temp.username);
                    $("#mobile").val(temp.mobile);
                    $("#code").val(temp.code);
                    $("#daddress").val(temp.detail_address);
                    if (temp.defaultv == 1) {
                        $("#box1").attr('checked', temp.defaultv);
                    }
                    uplink = '<a id="upaddress" class="button button-link button-nav marr10 flr cdb3652">修改</a>';
                    $('#page-add-address .bar').append(uplink);

                    $(page).on("change", "#box1", function() {
                        if ($("#box1").is(':checked')) {
                            var defaultvalue = 1;
                        } else {
                            var defaultvalue = 0;
                        }
                        var url = encodeURI(apiUrl + 'address/index/def_address');


                        $.ajax({
                            url: url,
                            async: false,
                            type: 'POST',
                            data: {
                                aid: aid,
                                defaultvalue: defaultvalue
                            },
                            headers: {
                                "Token": sso_Token
                            },
                            success: function(result) {
                                var data = JSON.parse(result);
                                if (data.code == 0) {
                                    $.toast('修改成功!');
                                    $.router.loadPage('address.php');
                                } else {
                                    $.toast('修改失败!');
                                    return false;
                                }
                            }

                        });
                    });

                    $(page).on("click", "#upaddress", function() {
                        ship_data.name = $("#city-picker").val();
                        var username = $("#username").val();
                        var mobile = $("#mobile").val();
                        var code = $("#code").val();
                        var daddress = $("#daddress").val();
                        var murl = encodeURI(apiUrl + 'address/index/modify_address');

                        $.ajax({
                          url: murl,
                          async: false,
                          type: 'POST',
                          data:{
                            dataType: "json",
                            ship_data: ship_data,
                            username: username,
                            mobile: mobile,
                            code: code,
                            daddress: daddress,
                            //defaultvalue: defaultvalue,
                            aid: aid
                          },
                          headers: {
                            "Token": sso_Token
                          },
                          success: function(result) {
                            var data = JSON.parse(result);
                            if (data.code == 0) {
                                var info = data.data;
                                $.toast('修改成功!');
                                $.router.loadPage('address.php');
                            } else {
                                $.toast('修改失败!');
                                return false;
                            }
                          }

                        });

                    })
                }
            }

        });
    }


    function getRrlParam(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }

});