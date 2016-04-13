$(function() {
  'use strict';
  $(document).on('pageInit', '#page-family-list', function(e, id, page) {
    //是否可以加载页面
    var isReload = true;
    $.showIndicator();
    var userInfo = checkLogin('1');
    //获取用户信息
    var userid = userInfo['userid'];


    getFamilyLists();
    //获取会员家族列表
    function getFamilyLists() {
      var url = encodeURI(apiUrl + 'account/index/accountList');

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
            isReload = false;
            $.hideIndicator();
            var is_self = '';
            var avarat = '';
            var levels = '';
            var userFamilyListsHtml = '';
            var userDataLists = JSON.parse(result['data']);
            for (var i = 0; i < userDataLists.length; i++) {
              if (userDataLists[i]['userid'] == userid) {
                is_self = '<span class="inlineblock w5b h30 lh30 mar0 iconfont cCB1408">&#xe64d;</span>';
              } else {
                is_self = '';
              }
              switch (parseInt(userDataLists[i]['levels'])) {
                case 1:
                  levels = '<em class="iconfont cCB1408">&#xe656;</em>'
                  break;
                case 2:
                  levels = '<em class="iconfont cCB1408">&#xe657;</em>'
                  break;
                case 3:
                  levels = '<em class="iconfont cCB1408">&#xe658;</em>'
                  break;
                case 4:
                  levels = '<em class="iconfont cCB1408">&#xe655;</em>'
                  break;
                case 5:
                  levels = '<em class="iconfont cCB1408">&#xe65a;</em>'
                  break;
                case 6:
                  levels = '<em class="iconfont cCB1408">&#xe659;</em>'
                  break;
                default:
                  levels = '<em class="iconfont c5F646E">&#xe65c;</em>'
                  break;
              }
              avarat = userDataLists[i]['avarat'] != '' ? userDataLists[i]['avarat'] : '/sources/images/t017f277b21eb38cb8d.png';
              userFamilyListsHtml += '<li>' +
                '<a href="user_information.php?userid=' + userDataLists[i]['userid'] + '" class="block w100b h80 c3D4145 external">' +
                '<div class="w100b h80 lh80 borb1 bcc1c1c1 ovfh bgfff">' +
                '<div class="fll w15b h80"><img class="block w50 h50 borrad50 mart15 marl20" src="' + avarat + '" /></div>' +
                '<div class="fll w75b h80">' +
                '<span class="inlineblock w20b h25 lh25 txac marl10 borrad5">' + levels + '</span>' +
                '<span class="inlineblock w60b h30 lh30">' + userDataLists[i]['nickname'] + '</span>' + is_self +
                '</div>' +
                '<div class="fll w5b iconfont mar0">&#xe63d;</div>' +
                '</div>' +
                '</a>' +
                '</li>';
            }
            $('#user-family-lists').html(userFamilyListsHtml);
          } else {
            isReload = true;
            $.toast('您还没有家族成员或拉取信息失败,点击重新加载', 3000);
            $.hideIndicator();
          }
        }
      });


    }

    //下拉刷新
    $(document).on('refresh', '.pull-to-refresh-content', function(e) {
      window.location.reload();
    });


    infiniteScroll();
    //页面无限滚动
    function infiniteScroll() {
      //索引计数器
      var index = 0;
      //每次获取10条数据
      var num = 20;

      var winH = document.documentElement.clientHeight || document.body.clientHeight;
      var centH = $('#user-family-lists').height();
      if (centH >= winH) {
        $('.loading').css('display', 'block');
        $(document).on('infinite', '.infinite-scroll-bottom', function() {
          var avarat = '';
          var levels = '';
          var temp = "";
          var skep = 0;
          index++;
          skep = parseInt(index * num);
          var url = encodeURI('http://api.zj3w.net/account/index/accountList/usreid=' + userid + '&skep=' + skep);


          $.ajax({
            url: url,
            async: false,
            type: 'GET',
            headers: {
              "Token": sso_Token
            },
            success: function(lists) {
              lists = JSON.parse(lists);
              //console.log(lists);
              if (lists['code'] == 0) {
                for (var i = 0; i < lists.length; i++) {
                  switch (parseInt(lists[i]['levels'])) {
                    case 1:
                      levels = '<em class="iconfont cCB1408">&#xe656;</em>'
                      break;
                    case 2:
                      levels = '<em class="iconfont cCB1408">&#xe657;</em>'
                      break;
                    case 3:
                      levels = '<em class="iconfont cCB1408">&#xe658;</em>'
                      break;
                    case 4:
                      levels = '<em class="iconfont cCB1408">&#xe655;</em>'
                      break;
                    case 5:
                      levels = '<em class="iconfont cCB1408">&#xe65a;</em>'
                      break;
                    case 6:
                      levels = '<em class="iconfont cCB1408">&#xe659;</em>'
                      break;
                    default:
                      levels = '<em class="iconfont c5F646E">&#xe65c;</em>'
                      break;
                  }
                  avarat = lists[i]['avarat'] != '' ? lists[i]['avarat'] : '/sources/images/t017f277b21eb38cb8d.png';
                  temp += '<li>' +
                    '<a href="user_information.php?userid=' + lists[i]['userid'] + '" class="block w100b h80 c3D4145 external">' +
                    '<div class="w100b h80 lh80 borb1 bcc1c1c1 ovfh bgfff">' +
                    '<div class="fll w15b h80"><img class="block w50 h50 borrad50 mart15 marl20" src="' + avarat + '" /></div>' +
                    '<div class="fll w75b h80">' +
                    '<span class="inlineblock w20b h25 lh25 txac marl10 borrad5">' + levels + '</span>' +
                    '<span class="inlineblock w60b h30 lh30">' + lists[i]['nickname'] + '</span>' +
                    '</div>' +
                    '<div class="fll w5b iconfont mar0">&#xe63d;</div>' +
                    '</div>' +
                    '</a>' +
                    '</li>';
                }
                var html = $('#user-family-lists').html() + temp;
                $('#user-family-lists').html(html);
              } else {
                $.toast('您还没有家族成员或拉取信息失败，下拉刷新重试', 3000);
                //注销无限滚动事件
                $.detachInfiniteScroll($('.infinite-scroll-bottom'));
                // 删除加载提示符
                $('.infinite-scroll-preloader').remove();
                return;
              }
            }

          });

        });
      }
    }
  });
  //
});