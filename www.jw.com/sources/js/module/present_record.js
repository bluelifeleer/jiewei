/*
 * @Author: anchen
 * @Date:   2015-12-31 11:03:47
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-29 10:16:38
 */
$(function() {
    'use strict';

    $(document).on("pageInit", "#page-present-record-add", function(e, id, page) {
        //$("#city-picker").cityPicker({});
        var userInfo = sessionStorage.getItem('user_info') || '{}';
        //获取用户信息
        var userInfoStrToJson = JSON.parse(userInfo);

        //var userid = userInfoStrToJson['userid'];
        var aid = getRrlParam('aid');
        if (aid) {
            $('#put-presents').html('删除');
            $('#put-presents').attr('id', 'del-prerecords');
            up_prerecords(aid, page);

        } else {
            $(page).on("click", "#put-presents", function() {
                add_prerecords();
            });
        }
        //删除事件
        $(page).on("click", "#del-prerecords", function() {
            var url = encodeURI(apiUrl + 'paypresent/index/del_prerecords');
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
                                $.router.loadPage('present_record.php');
                            } else {
                                $.toast('删除失败!');
                                return false;
                            }
                        }

                    });
                },
                function() {
                    return false;
                })
        });
    });



    //提现方式列表
    $(document).on("pageInit", "#page-present-record", function(e, id, page) {
        var url = encodeURI(apiUrl + 'paypresent/index/show_prerecords');

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
                    temp += '<a href="present_record_add.php?aid=' + result.data[i]['id'] + '">' +
                        '<div class="pad10 borb1 bce6 c666 bgfff">' +
                        '<div class="marb5">' +
                        '<span>' + result.data[i]['account_name'] + '</span><span class="flr">' + result.data[i]['contact_way'] + '</span>' +
                        '</div><div>' +
                        '<span>' + result.data[i]['bank_name'] + ' ' + result.data[i]['bank_address'] + '</span><span class="flr">' + isDefault + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                }
            } else {
                temp = '<div class="fs07 c666 txac mart20">您还没有添加提现方式.</div>';
            }
            $('#page-present-record .infinite-scroll').html(temp);
          }

        });

    });



    function add_prerecords() {
        var bank_name = $("#bank_name").val();
        var bank_address = $("#bank_address").val();
        var card_number = $("#card_number").val();
        var contact_way = $("#contact_way").val();
        var account_name = $("#account_name").val();
        if ($("#box1").is(':checked')) {
            var defaultvalue = 1;
        } else {
            var defaultvalue = 0;
        }
        if (!bank_name) {
            $.toast('请填写您的开户银行!');
            return false;
        }
        if (!bank_address) {
            $.toast('请填写您的开户行地址!');
            return false;
        }
        if(bank_address.length > 150){
            $.toast('您的开户行地址填写过长！');
            return false;
        }
        if (!card_number) {
            $.toast('请填写您的卡号!');
            return false;
        }
        if (!contact_way) {
            $.toast('请填写您的联系方式!');
            return false;
        }
        if (!account_name) {
            $.toast('请填写您的账号名称!');
            return false;
        }
        var url = encodeURI(apiUrl + 'paypresent/index/add_prerecords');

        $.ajax({
            url: url,
            async: false,
            type: 'POST',
            data: {
                bank_name: bank_name,
                bank_address: bank_address,
                card_number: card_number,
                contact_way: contact_way,
                account_name: account_name,
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
                       $.router.loadPage('present_record.php');
                    }
                   
                } else {
                    $.toast('添加失败!');
                    return false;
                }
            }

        });

    }

    function up_prerecords(aid, page) {
        var url = encodeURI(apiUrl + 'paypresent/index/up_prerecords');
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
                    $("#page-present-record-add .title").html('修改提现方式');
                    $("#bank_name").val(temp.bank_name);
                    $("#bank_address").val(temp.bank_address);
                    $("#card_number").val(temp.card_number);
                    $("#contact_way").val(temp.contact_way);
                    $("#account_name").val(temp.account_name);
                    if (temp.defaultv == 1) {
                        $("#box1").attr('checked', temp.defaultv);
                    }
                    uplink = '<a id="upprerecords" class="button button-link button-nav marr10 flr cdb3652">修改</a>';
                    $('#page-present-record-add .bar').append(uplink);

                    $(page).on("change", "#box1", function() {
                        if ($("#box1").is(':checked')) {
                            var defaultvalue = 1;
                        } else {
                            var defaultvalue = 0;
                        }
                        var url = encodeURI(apiUrl + 'paypresent/index/def_prerecords');


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
                                    $.router.loadPage('present_record.php');
                                } else {
                                    $.toast('修改失败!');
                                    return false;
                                }
                            }

                        });
                    });

                    $(page).on("click", "#upprerecords", function() {
                        var bank_name = $("#bank_name").val();
                        var bank_address = $("#bank_address").val();
                        var card_number = $("#card_number").val();
                        var contact_way = $("#contact_way").val();
                        var account_name = $("#account_name").val();
                        var murl = encodeURI(apiUrl + 'paypresent/index/modify_prerecords');

                        $.ajax({
                          url: murl,
                          async: false,
                          type: 'POST',
                          data:{
                            bank_name: bank_name,
                            bank_address: bank_address,
                            card_number: card_number,
                            contact_way: contact_way,
                            account_name: account_name,
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
                                $.router.loadPage('present_record.php');
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