/*
 * @Author: anchen
 * @Date:   2015-12-31 11:03:47
 * @Last Modified by:   anchen
 * @Last Modified time: 2016-03-30 15:07:38
 */
$(function() {
    'use strict';

    $(document).on("pageInit", "#page-present-manner", function(e, id, page) {
        $.alert('友情提示:提现到账日期为１到３个工作日,周末、法定节假日顺延。谢谢支持');
        show_def();
        show_cash();
        var userInfo = sessionStorage.getItem('user_info') || '{}';
        //获取用户信息
        var userInfoStrToJson = JSON.parse(userInfo);

        var pageFn = getRrlParam('fn');
        if(pageFn && pageFn != ''){
          $('.total-title').html('550元');
          $('.total-title').attr('data-total-value',550);
        }else{
          $('.total-title').html('500元');
          $('.total-title').attr('data-total-value',500);
        }


        $(page).on('click', '.select-but', function(){
          var task = $('.select-but').attr('data-is-open');
          if(task == 'false'){
            $(this).attr('data-is-open',true);
            // alert($(this).attr('data-is-open'));
            $('.rechager-content-block').css('display','none');
            $('.option-status-icon').html('&#xe600;');
          }else{
            //$(this).attr('data-is-open',true);
            // $('.rechager-content-block').eq(parseInt($(this).attr('data-index'))).css('display','block');
            // $('.option-status-icon').eq(parseInt($(this).attr('data-index'))).html('&#xe658;');
            $(this).attr('data-is-open',false);
            $('.rechager-content-block').css('display','block');
            $('.option-status-icon').html('&#xe658;');
          }  
        });
        /**
        * 选择金额
        * @author 邵博
        * @date 2016-02-17
        */
        // $(page).on('click','.select-total',function(){
        //      $('.select-total').attr('data-is-checked',false);
        //      $(this).attr('is-checked',true);
        //      $('.check-but').html('&#xe61c;');
        //      $('.check-but').eq($(this).index()).html('&#xe626;');
        //      $('.total-title').html($('.total').eq($(this).index()).html());
        //      $('.total-title').attr('data-total-value',$('.total').eq($(this).index()).attr('data-opation-value'));
        // });

        /**
        * 自定义金额
        * @author 邵博
        * @date 2016-02-17
        */
        // $(page).on('focus','#input-total-but',function(){
        //     $('.select-total').attr('data-is-checked',false);
        //     $('.check-but').html('&#xe61c;');
        //     });
        $(page).on('blur','#input-total-but',function(){
            if($(this).val() != ''){
                if(parseInt($(this).val()) == 'NAN'){
                      $.toast('请输入正确的金额');
                      return false;
                // }else{
                //   $('.total-title').html($(this).val()+'元');
                //   $('.total-title').attr('data-total-value',$(this).val());
                }
            }else{
                $.toast('请选择或输入金额');
                return false;
            }
        });

        function show_def(){
          $.ajax({
            url: apiUrl + 'paypresent/index/get_def_add',
            async: false,
            type: 'GET',
            headers: {
              "Token": sso_Token
            },
            success: function(result) {
              var data = JSON.parse(result);
              if (data.code == '0') {
                var info = data.data;
                $("input[name=record_id]").val(info.id);
                $(".account_name").html('账户名:'+info.account_name);
                $(".bank_name").html('银行名称:'+info.bank_name);
                $(".card_number").html('银行卡号:'+info.card_number);
                $(".contact_way").html('联系方式:'+info.contact_way);
              }else{
                $('.record-info-list').html('请添加您的默认提现方式。')
              }
            }
          })
        }


        function show_cash(){
          $.ajax({
            url: apiUrl + 'paypresent/index/get_user_account',
            async: false,
            type: 'GET',
            headers: {
              "Token": sso_Token
            },
            success: function(result) {
              var data = JSON.parse(result);
              if (data.code == '0') {
                var info = data.data;
                $(".Damount").html(info.amount);
                $(".Mamount").html(info.apply_amount);
                $(".amount").html(info.apply_amount_frozen);
                
                //$(".Mamount").html();
                //$(".amount").html();
              }else{
                $(".Damount").html('0');
              }
            }
          })
        }
        //添加提现记录
        $(page).on('click','#submit-but',function(){
            var record_id = $("input[name=record_id]").val();
            //var cash = $('.total-title').attr('data-total-value');
            var cash = $('.total-title').val();
            if(cash < 1){
              $.toast('请填写大于1元的金额!');
              return false;
            }
            var url = apiUrl + 'paypresent/index/add_mannerlist';
            $.ajax({
              url: url,
              type: 'POST',
              async : false,
              data: {
                record_id : record_id,
                cash : cash
              },
              headers: {
              "Token": sso_Token
              },
              success:function(result){
                var data = JSON.parse(result);
                if(data.code == 0){
                  $.toast('申请提现成功！');
                }else if(data.code == 1){
                  $.toast('您未登录,请重新登录！');
                }else if(data.code == 2){
                  $.toast('您的金额不够提现!');
                }else{
                  $.toast('申请提现失败！');
                }
              }
            })  
        })
    });


    $(document).on("pageInit", "#page-present-manner-lists", function(e, id, page) {
        var userInfo = sessionStorage.getItem('user_info') || '{}';
        var userInfoStrToJson = JSON.parse(userInfo);
        var url = encodeURI(apiUrl + 'paypresent/index/show_mannerlist');
        $.ajax({
          url: url,
          async: false,
          type: 'GET',
          headers: {
            "Token": sso_Token
          },
          success: function(result) {
            result = JSON.parse(result);
            //console.log(result);
            if (result['code'] == 0) {
                var i = '';
                var temp = '';
                for (i in result.data) {
                    var isDefault = result.data[i]['defaultv'] && parseInt(result.data[i]['defaultv']) == 1 ? '默认' : '';
                    temp += 
                    // '<a href="present_record.php?aid=' + result.data[i]['id'] + '">' +
                        '<div class="pad10 borb1 bce6 c666 bgfff">' +
                        '<div class="marb5">' +
                        '<span>' + result.data[i]['account_name'] + '</span><span class="flr">' + result.data[i]['apply_time'] + '</span>' +
                        '</div><div>' +
                        '<span>' + result.data[i]['cash'] + ' ' + result.data[i]['bank_name'] + '</span><span class="flr">' + isDefault + '</span>' +
                        '</div>' +
                        '</div>';
                }
            } else {
                temp = '<div class="fs07 c666 txac mart20">您还没有提现记录.</div>';
            }
            $('#page-present-manner-lists .infinite-scroll').html(temp);
          }
        })
    })


    function getRrlParam(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }

});