$(function() {
  'use strict';
  //------------------------------------------------------------------------------------------------------------------------------
  $(document).on('pageInit', '#page-user-info', function(e, id, page) {
    var user = checkLogin('1');
    if (!user) {
      $.router.loadPage('login.php');
      return false;
    }

    var nickname = user['nickname'] == '' ? user['phone'] : user['nickname'];
    $('#page-user-info .nickname').html(nickname);
    var sex = user['sex'] == 1 ? '男' : '女';
    $('#page-user-info #sex').html(sex);
    var avarat = user['avarat'] == '' ? '/sources/images/default_40x40.jpg' : user['avarat'];
    $('#page-user-info .avarat').attr('src', avarat);
    var email = user['email'] == '' ? '' : user['email'];
    $('#page-user-info .email').html(email);
    var qq = user['qq'] == '' ? '' : user['qq'];
    $('#page-user-info .qq').html(qq);
    //判断是否微信
    if(user['is_wechat_login'] && user['is_wechat_login'] == 1){//微信登录
      $('#modify-wchat-link-block').css('display','none');
    }else{//非微信登录[手机]
      var wechat = user['wechat'] == '' ? '' : user['wechat'];
      $('#page-user-info .wechat').html(wechat);
    }
    var isVip = '';
    $('#page-user-info .is-vip').html(isVip);

    //------------------------------------------------------------------------------------------------------------------------------

    $(page).on('click', '#show-select-sex-but', function() {
      if ($(this).attr('data-is-open') == 'false') {
        $(this).attr('data-is-open', true);
        $('#show-select-sex-block').css('display', 'block');
      } else {
        $(this).attr('data-is-open', false);
        $('#show-select-sex-block').css('display', 'none');
      }
    });

    //------------------------------------------------------------------------------------------------------------------------------
    $(page).on('click', '.select-sex-buts', function() {
      $.showIndicator();
      $('#sex').text($(this).html());
      var url = encodeURI(apiUrl + '/account/index/modifyInfo');

      $.ajax({
        url: url,
        async: false,
        type: 'POST',
        data: {
          'modifType': 'sex',
          'modifData': parseInt($(this).attr('data-value'))
        },
        headers: {
          "Token": sso_Token
        },
        success: function(status) {
          status = JSON.parse(status);
          if (status['code'] == 0) {
            $.hideIndicator();
            $('#show-select-sex-but').attr('data-is-open', false);
            $('#show-select-sex-block').css('display', 'none');
          }
        }

      });
    });



    //------------------------------------------------------------------------------------------------------------------------------


    uploadAvarat();

    function uploadAvarat() {
      var uploader = WebUploader.create({
        swf: mediasUrl + 'Uploader.swf',
        server: 'http://res.zj3w.net/upload.php?root=user/' + user['userid'],
        pick: '#uploader',
        resize: false
      });


      uploader.on('fileQueued', function(file) {
        $('#avarat-block').html('<img class="w40 h40 borrad50 avarat" src="' + imgUrl + 'loading.gif" alt="" />');
        this.upload();


        this.on('uploadSuccess', function(file, response) {
          
          if (response.thumb && response.thumb != '') {

            var url = encodeURI(apiUrl + 'account/index/modifyAvatar');
            var data = {
              'avarat': response.thumb
            }

            $.ajax({
              url: url,
              async: false,
              type: 'POST',
              data:data,
              headers: {
                "Token": sso_Token
              },
              success: function(respoe) {
                respoe = JSON.parse(respoe);
                if (respoe['code'] == 0) {
                  $('#avarat-block').html('<img class="w40 h40 borrad50 avarat" src="' + response.thumb + '" alt="" />');
                } else {
                  $.toast('头像上传失败，请稍后再试');
                }
              },
              error:function(err){
                $.toast(err);
              }

            });

          }
        });
      });



    }
    //------------------------------------------------------------------------------------------------------------------------------
    //
  });



  //
});

/**
 *
 *
 *

$(function() {
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: 'http://www.my.cn/assets/js/Uploader.swf',
        // 文件接收服务端。
        server: '/api.php?op=app_Update_Avatar',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on('fileQueued', function(file) {
        var $li = $('<div id="' + file.id + '" class="file-item thumbnail">' + '<img>' + '<div class="info">' + file.name + '</div>' + '</div>'),
            $img = $li.find('img');
        // $list为容器jQuery实例
        $list.append($li);
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function(error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
        }, thumbnailWidth, thumbnailHeight);
    });
});



 *
 *
 *
 *
 *
 *
 *
 *
 *
 */