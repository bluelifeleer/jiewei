$(function(){
  'use strict';
  $(document).on('pageInit','#page-account-list',function(e,id,page){
    //判断是否登录
    var loginInfo = checkLogin();
    if(!loginInfo){
      $.router.loadPage('login.php');
    }

    $.showIndicator();
    var url = encodeURI(apiUrl+'pay/index/paySpend/num/20/offset/0');

    $.ajax({
        url: url,
        async: false,
        type: 'GET',
        headers: {
          "Token": sso_Token
        },
        success: function(lists) {
            lists = JSON.parse(lists);
            // console.log(lists.data);
            if(lists.code == 0){
              $.hideIndicator();
              if(lists.data[1] == 0 ){
                $('.infinite-scroll-preloader').css('display','none');
              }else{
                var html = '';
                for(var i=0; i<lists.data[0].length; i++){
                  html += '<!--a class="c666 external" href="pay_list.php?id='+lists.data[0][i]['id']+'"-->'+
                    '<li class="item-content borb1 bce6 padt5 padb5">'+
                      '<div class="item-inner">'+
                        '<div class="item-title">'+
                          '<div>'+lists.data[0][i]['creat_at']+'</div>'+
                          '<div>'+lists.data[0][i]['msg']+'</div>'+
                        '</div>'+
                        '<div class="item-after">-'+lists.data[0][i]['value']+'</div>'+
                        '<div class="item-media">'+
                          '<i class="flr icon iconfont mar0 cCB1408" style="margin:0 0.6rem 0 0.4rem">&#xe681;</i>'+
                        '</div>'+
                      '</div>'+
                    '</li>'+
                  '<!--/a-->';
                }
                $('#account-list-block').html(html);
                var contentH = parseInt($('#account-list-block').height());
                //如果加载的数据高度小于一屏则隐藏加载提示
                if(contentH < screenH){
                  $('.infinite-scroll-preloader').css('display','none');
                }
              }
            }else if(lists['code'] ==2){
              $.hideIndicator();
              $.toast('你尚未登陆',2000);
            }else{
              $.hideIndicator();
              $.toast('获取信息失败',2000);
            }
          },
          error:function(err){
            $.hideIndicator();
            $.toast('请求出错，请稍后再试！');
          }

      });


    //下拉刷新
    $(page).on('refresh', '.pull-to-refresh-content',function(e){
      window.location.reload();
      $.hideIndicator();
    });


    infiniteScroll();
    //无限滚动
    function infiniteScroll(){
      //是否正在加载数据
      var isLoading = false;
      //计数器
      var index = 0;
      //每次请求数据
      var num = 20;

      $(page).on('infinite', '.infinite-scroll',function(){
        //如果正在加载，退出
        if(isLoading){return false;}
        isLoading = true;
        index++;
        var offset = index*num;
        var url = encodeURI(apiUrl+'pay/index/paySpend/num/'+num+'/offset/'+offset);

        $.ajax({
          url: url,
          async: false,
          type: 'GET',
          headers: {
            "Token": sso_Token
          },
          success: function(result) {
            result = JSON.parse(result);
            if(result.code == 0){
              isLoading = false;
              if(parseInt(result.data[1]) < offset){
                isLoading = false;
                var html = '';
                for(var i=0; i<result.data[0].length; i++){
                  html += '<!--a class="c666 external" href="pay_list.php?id='+result.data[0][i]['id']+'"-->'+
                    '<li class="item-content borb1 bce6 padt5 padb5">'+
                      '<div class="item-inner">'+
                        '<div class="item-title">'+
                          '<div>'+result.data[0][i]['creat_at']+'</div>'+
                          '<div>'+result.data[0][i]['msg']+'</div>'+
                        '</div>'+
                        '<div class="item-after">-'+result.data[0][i]['value']+'</div>'+
                        '<div class="item-media">'+
                          '<i class="flr icon iconfont mar0 cCB1408" style="margin:0 0.6rem 0 0.4rem">&#xe681;</i>'+
                        '</div>'+
                      '</div>'+
                    '</li>'+
                  '<!--/a-->';
                }

                $('#account-list-block').html($('account-list-block').html()+html);
                isLoading = false;
              }else{
                isLoading = false;
                $.toast('没有更多数据可加载',2000);
                //注销无限滚动事件
                $.detachInfiniteScroll($('.infinite-scroll'));
                // 删除加载提示符
                $('.infinite-scroll-preloader').remove();
                return;
              }

            }else{
              $.toast('加载失败，请重试',2000);
              isLoading = false;
              //注销无限滚动事件
              $.detachInfiniteScroll($('.infinite-scroll'));
              // 删除加载提示符
              $('.infinite-scroll-preloader').remove();
              return;
            }
          },
          error:function(err){
            $.toast('请求出错，请稍后再试！');
            //注销无限滚动事件
            $.detachInfiniteScroll($('.infinite-scroll'));
            // 删除加载提示符
            $('.infinite-scroll-preloader').remove();
            return;
          }

        });

      });
    }



  });
});
