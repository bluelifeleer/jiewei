 /**
  * @Author: liubo
  * Created by bluelife on 16-1-11.
  * @Date:   2016-01-01 21:38:19
  * @Last Modified by:   anchen
  * @Last Modified time: 2016-01-12 00:30:50
  */
 'use strict';
 //-----------------------------------------------------------------------------------------------------
 /**
  * 网站配置
  */
 document.domain = "www.zj3w.net";
 var websiteUrl = 'http://www.zj3w.net/?siteid=1'; //前台站点
 var apiUrl = 'http://api.zj3w.net/'; //ＡＰＩ站点
 // document.domain = "jw.com";
 var APP_PATH = 'http://www.zj3w.net/'; //前台站点
 // var apiUrl = 'http://api.jw.com/'; //ＡＰＩ站点
 var cssUrl = '/sources/css/'; //资源站点
 var jsUrl = '/sources/js/'; //资源站点
 var imgUrl = '/sources/images/'; //资源站点
 var mediasUrl = '/sources/medias/';
 /**
  * 站点信息
  */
 //------------------------------------------------------------------------------------------------------------------------------
  window.apply_shop_select_goods_limit = 30; //注册分站的时候，最少选择产品的数量值
 //获取链接的推荐人
  var _YunUser = getRrlParam('YunUser')  || 0;
     _YunUser = _YunUser =='null' ? 0: _YunUser;
  var YunUser = sessionStorage.getItem('YunUser') || 0;
     YunUser = YunUser =='null' ? 0: YunUser;
  if(_YunUser == YunUser && _YunUser == 0){
      YunUser = 1;
  }else{
    YunUser = _YunUser ? _YunUser : YunUser;
  }

  sessionStorage.setItem('YunUser', YunUser);


 //获取屏幕的高度
 var screenH = $(window).height();


 //------------------------------------------------------------------------------------------------------------------------------
 //记录运行设备
 window.isAndroid = $.device.android;
 window.deviceOS = $.device.os;
 window.osVersion = $.device.osVersion;
 window.isWeixin = isWeiXin();
 window.isIpad = $.device.ipad;
 window.isIphone = $.device.iphone;
 var site_host = window.location.host;
 //------------------------------------------------------------------------------------------------------------------------------


 /**
  * [isWeiXin description]
  * @return {Boolean} [description]
  */
 function isWeiXin() {
   var ua = window.navigator.userAgent.toLowerCase();
   if (ua.match(/MicroMessenger/i) == 'micromessenger') {
     return true;
   } else {
     return false;
   }
 }


 //------------------------------------------------------------------------------------------------------------------------------
 //
 /**
  * 站点信息
  */
 //------------------------------------------------------------------------------------------------------------------------------
 window.apply_shop_select_goods_limit = 30; //注册分站的时候，最少选择产品的数量值
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * [getRrlParam 获取浏览器地址参数
  * @param  {[type]} name 参数名
  */
 function getRrlParam(name) {
   var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
   return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
 }
 //------------------------------------------------------------------------------------------------------------------------------


 /**
  * 初始化WEB APP 应用交互
  * @Author: liubo
  * 
  */
 var sso_Token = (sessionStorage.getItem('sso_session') 
                ? sessionStorage.getItem('sso_session') 
                : (getRrlParam('HTTP_TOKEN') ? getRrlParam('HTTP_TOKEN') : ''));

checkinit();

if(sso_Token == 'null'){
  sessionStorage.removeItem('sso_session');
  checkinit();
}

 function checkinit() {
   var url = apiUrl + 'account/index/init';
   var Token = (sessionStorage.getItem('sso_session') ? sessionStorage.getItem('sso_session') : sso_Token);
   if(Token == 'null')Token = '';
   $.ajax({
     type: 'post',
     url: url,
     aysnc: false,
     headers: {
       "Token": Token
     },
     success: function(session_id) {
       sso_Token = session_id;
       sessionStorage.setItem('sso_session', session_id);
       set_cookie('sso_session', session_id);
       checkLogin(false);
     }
   });
 }
 /**
  * 检测用户是否登录
  * @param login 是否需要跳转登入
  * @Author: liubo
  * 
  */
 function checkLogin(login) {
   var reback = '';
   var login = login || false;
   var url = apiUrl + 'account/index/chechLogin';
   var Token = (sessionStorage.getItem('sso_session') ? sessionStorage.getItem('sso_session') : sso_Token);
   $.ajax({
     type: 'POST',
     url: url,
     timeout: 500,
     async: false,
     data:{YunUser:YunUser},
     headers: {
       "Token": Token
     },
     success: function(succ) {
       var success = succ ? succ : '{}';
       var data = JSON.parse(success);
       if (data.code == 1) {
         reback = data.data;
         sessionStorage.setItem('user_info', JSON.stringify(reback));
         sessionStorage.setItem('YunUser', data.data.YunUser);
         sessionStorage.setItem('userid', data.data.userid);
         // set_cookie('userid', data.data.userid,1,'/','');
       } else {
         sessionStorage.removeItem('user_info');
         if (login == '1') $.router.loadPage('login.php');
       }
       
     }
   });
   return reback;
 }


/**
 * 退出登录
 * @return {null} [description]
 */
function loginOut(){
  $.showIndicator();
  var url = apiUrl + "/account/index/logout";
  $.ajax({
    url: url,
    async: false,
    type: 'GET',
    headers: {
      "Token": sso_Token
    },
    success: function(respose) {
      respose = JSON.parse(respose);
      if(respose.code ==0){
        $.hideIndicator();
        del_cookie('userid');
        $.router.loadPage('login.php');
      }else{
        $.hideIndicator();
        $.toast('退出失败');
      }
    },
    error:function(err){
      $.toast(err,2000);
    }
  });
}

 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 设置cookie
  * @Author: seaven
  */
 function set_cookie(name, value, expires, path, domain, secure) {

   var today = new Date();
   today.setTime(today.getTime());

   if (expires) {
     expires = expires * 1000 * 60 * 60 * 24;
   }
   var expires_date = new Date(today.getTime() + (expires));

   document.cookie = name + "=" + escape(value) +
     ((expires) ? ";expires=" + expires_date.toGMTString() : "") +
     ((path) ? ";path=" + path : ";path=/") +
     ((domain) ? ";domain=" + domain : ";domain=.zj3w.net")+
     ((secure) ? ";secure" : "");
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 获取cookie
  * @Author: seaven
  */
 function get_cookie(name) {
   var start = document.cookie.indexOf(name + "=");
   var len = start + name.length + 1;
   if ((!start) && (name != document.cookie.substring(0, name.length))) {
     return null;
   }
   if (start == -1) return null;
   var end = document.cookie.indexOf(";", len);
   if (end == -1) end = document.cookie.length;
   return (document.cookie.substring(len, end));
 }
/**
  * 删除cookie
  * @Author: baidu
  */
function del_cookie(name)
{
  set_cookie(name, '', -1);
}

 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 判断变是否为空
  * @Author: seaven
  */
 function isEmpty(v) {
   switch (typeof v) {
     case 'undefined':
       return true;
     case 'string':
       if (v.replace(/(^[ \t\n\r]*)|([ \t\n\r]*$)/g, '').length == 0) return true;
       break;
     case 'boolean':
       if (!v) return true;
       break;
     case 'number':
       if (0 === v || isNaN(v)) return true;
       break;
     case 'object':
       if (null === v || v.length === 0) return true;
       for (var i in v) {
         return false;
       }
       return true;
   }
   return false;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**参数说明：
  * 根据长度截取先使用字符串，超长部分追加…
  * str 对象字符串
  * len 目标字节长度
  * 返回值： 处理结果字符串
  * @Author:seaven
  */
 function cutString(str, len) {
   //length属性读出来的汉字长度为1
   if (str.length * 2 <= len) {
     return str;
   }
   var strlen = 0;
   var s = "";
   for (var i = 0; i < str.length; i++) {
     s = s + str.charAt(i);
     if (str.charCodeAt(i) > 128) {
       strlen = strlen + 2;
       if (strlen >= len) {
         return s.substring(0, s.length - 1) + "...";
       }
     } else {
       strlen = strlen + 1;
       if (strlen >= len) {
         return s.substring(0, s.length - 2) + "...";
       }
     }
   }
   return s;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 弹出分享层
  * [sharePopup description]
  * @return {[type]} [description]
  */
 function sharePopup() {
   $.ajax({
     type: "POST",
     url: apiUrl + "userQcode/index/shareProduct",
     data: "id=" + getRrlParam('id'),
     headers: {
       "Token": sso_Token
     },
     success: function(result) {
       var res = JSON.parse(result)
       if (res['code'] == 200) {
         var sharePopupHTML = '<div class="popup mart387 pad10"><header class="bar bar-nav"><h1 class="title" id="order-page-title">分  享</h1><a class=" close-popup"><i class="icon iconfont mar0 fs13 white">&#xe61b;</i></a></header>' + '<div class="txac mart10">分享商品二维码</div>' + '<div class="pad10 mart20"><img class="marauto" src="' + res['data'] + '" /></div>' + '<div class="close-popup mart20 txac c999">返回</div>'
         '</div>';
         $.popup(sharePopupHTML);
       } else {
         $.toast(res['error']);
       }
     }
   });
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 产品收藏
  * [collection description]
  * @return {[type]} [description]
  */
 function collection() {
   // var url = encodeURI(encodeURI('http://www.zj3w.net/addcollection.php?uid=34534543&productid=5463563456'));
   // $.get(url, function(respos) {
   //     if (respos == 0) {
   //         $.toast('收藏成功');
   //     } else {
   //         $.toast('收藏失败');
   //     }
   // });
 }
 //--------------------------------------------------------------------------------------/
 //////////////////////////////////////////////////////////////////////////////////////////
 //
 // 加入购物车 
 // by seaven                                                                                          
 //////////////////////////////////////////////////////////////////////////////////////////
 /////------------------------------------------------------------------------------------
 function addToCart() {

   var userInfo = checkLogin();
   if (!userInfo) {
     var id = JSON.parse(sessionStorage.getItem('product_info')).id;
   
     // $.router.loadPage("login.php?backPage=product.php?id=" + id); //转到登录页
      $.router.loadPage("login.php?backPage="+window.location.href); //转到登录页

     return false;
   } else {
     //商品id
     var pro_id = JSON.parse(sessionStorage.getItem('product_info')).id;
     if (isEmpty(pro_id)) {
       $.toast('参数错误！正在转到首页....', 2000, 'error');

       var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
       $.router.loadPage("index.php?siteid=" + siteid); //转到首页
       return false;
     }

     var productInfo = JSON.parse(sessionStorage.getItem('product_info'));
     if (!$.isEmptyObject(productInfo)) {
       var html = '';
       var product_num = JSON.parse(sessionStorage.getItem('product_info')).stock > 0 ? 1 : 0; //产品在购物车中数量

       html += '<div class="popup popup-add-cart fs06"  style="height:auto;bottom: 0;top:auto;">';

       html += '<div class="content-padded mar0 pad0 padl10 padr10 padb30">';
       html += '<div class="w100b h40 borb1  bc8A8F96 txar"><a href="#" class="iconfont block w30 h30 borrad50 mar0 white txac lh30 floatr close-popup"><i class="iconfont fs06 cc40000 mar0">&#xe604;</i></a></div>';
       html += '<div class="clear"></div>';
       html += '<div class="w100b  padt5 ovfh">';
       html += '<div class="floatl wauto">';
       html += '<img class="w100b w20b fll" src="' + JSON.parse(sessionStorage.getItem('product_info')).thumb + '" alt="">';
       html += '<div class="flr w80b pad0 mar0">';
       html += '<p class="pad0 mar0 marl20">' + cutString(JSON.parse(sessionStorage.getItem('product_info')).title, 100) + '</p>';
       html += '<p class="pad0 mar0 marl20">价格：<span id="product-price" class="cFF4400 fs12 ">&yen;' + parseFloat(JSON.parse(sessionStorage.getItem('product_info')).price).toFixed(2) + '</span></p>';
       html += '</div>';
       html += '<div class="clear"></div>';
       html += '</div>';
       html += '</div>';

       // begin-----------商品属性
       var params = JSON.parse(sessionStorage.getItem('product_info')).params;

       if(params != null){
          $.each(JSON.parse(params), function(param, el) {
            html += '<div class="product-param w100b hauto">'
            html += '<div class="w100b h40 lh40"><span class="paramName">' + param + '</span>:</div>';
            html += '<div class="paramValue w100b hauto">';
            var paramsValue = el.split('、');
            $.each(paramsValue, function(i, item) {
              html += '<a href="javascript:void(0);" class="select-params inlineblock external wauto pad5 borrad5 bgE2E2E2 c3D4145 marr20 marb15" data-is-selected="false">' + item + '</a>';
            });
            html += '</div>';
            html += '</div>';
          });
       }
      

       // end-----商品属性


       html += '<div class="w100b bort1  bc8A8F96 h60">';
       html += '<div class="wauto fll">';
       html += '<span class="inlineblock h60 lh60">选择数量:</span>';
       html += '<a href="javascript:void(0);" class="select-product-number iconfont external inlineblock w30 h30 txac lh30 mar0 bgE2E2E2 c868686 marl40" data-fn="minus">&#xe602;</a>';
       html += '<input type="text" id="product-number" readonly="readonly" class="inlineblock w40 h30 lh30 bor0" value="' + product_num + '" data-product-num="' + product_num + '"  style="text-align: center;"/>';
       html += '<a href="javascript:void(0);" class="select-product-number iconfont external inlineblock w30 h30 txac lh30 mar0 bgE2E2E2 c868686" data-fn="add">&#xe603;</a>';
       html += '</div>'
       html += '<div class="padl20 fll inlineblock h60 lh60">库存：' + JSON.parse(sessionStorage.getItem('product_info')).stock + '件</div>';
       html += '<div class="clear"></div>';
       html += '</div>';
       html += '</div>';
       html += '<a href="javascript:void(0);" id="push-cart" data-id="' + JSON.parse(sessionStorage.getItem('product_info')).id + '" data-price="' + JSON.parse(sessionStorage.getItem('product_info')).price + '" data-title="' + JSON.parse(sessionStorage.getItem('product_info')).title + '" data-thumb="' + JSON.parse(sessionStorage.getItem('product_info')).thumb + '" data-transit-cost="' + JSON.parse(sessionStorage.getItem('product_info')).transit_cost + '" data-product-sn="' + JSON.parse(sessionStorage.getItem('product_info')).product_sn + '" data-is-real="' + JSON.parse(sessionStorage.getItem('product_info')).is_real + '" data-level-id="' + JSON.parse(sessionStorage.getItem('product_info')).levelId + '"  data-stock="' + JSON.parse(sessionStorage.getItem('product_info')).stock + '" class="block external w100b h50 txac lh50 bgFF1700 white fs08">确定</a>';
       html += '</div>';
       $.popup(html);

       //begin -------选择商品属性
       $('.select-params').bind('click', function() {
         var productParamGroups = $(this).parent().find('.select-params');
         $.each(productParamGroups, function(i) {
           $(this).attr('data-is-selected', false);
           $(this).css({
             'background': '#E2E2E2',
             'color': '#3D4145'
           });
         })
         $(this).attr('data-is-selected', true);
         $(this).css({
           'background': '#FF1404',
           'color': '#FFF'
         });
       });
       //end ----------选择商品属性
       //
       //增加和减少商品数量
       $('.select-product-number').bind('click', function() {
         var num = $('#product-number').val();
         var product_num = num;
         var stock = JSON.parse(sessionStorage.getItem('product_info')).stock;
         if ($(this).attr('data-fn') == 'minus') {
           if (num > 1) num--;
           else num = num;
         } else {
           if (parseInt(num) >= parseInt(stock)) {
             $.toast('亲，没有库存了！', 2000, 'error');
             num = stock;
           } else num++;
         }
         $('#product-number').val(num);
         product_num = num;
       });
       //添加到购物车
       $('#push-cart').bind('click', function() {
         product_num = $('#product-number').val();
         if (product_num == 0) {
           $.toast('亲，请选择商品数量！', 2000, 'error');
         } else {

           var product_id = $(this).attr('data-id');
           var product_title = $(this).attr('data-title');
           var product_price = $(this).attr('data-price');
           var product_thumb = $(this).attr('data-thumb');
           var transit_cost = $(this).attr('data-transit-cost');
           var product_stock = $(this).attr('data-stock');
           var product_sn = $(this).attr('data-product-sn');
           var is_real = $(this).attr('data-is-real');
           var level_id = $(this).attr('data-level-id');
           var paramInfo = {};
           var paramName = '';
           var paramValueGroup = '';
           var isSelect = $('.product-param').length == 0 ? true : false; //判断是否选择属性


           //获取产品属性
           var params = '{';
           if ($('.product-param').length> 0) {
             
             $('.product-param').each(function(index, item) {

               paramName = $(this).find('.paramName').html();
               //params.paramName = paramName;
               params += '"'+paramName + '":';
               paramValueGroup = $(this).find('.paramValue').find('.select-params');
               isSelect = false;
               $.each(paramValueGroup, function() {
                 if ($(this).attr('data-is-selected') == 'true') {
                   var paramValue = $(this).html();
                   params += '"'+paramValue + '",';
                   //params.paramValue = paramValue;
                   isSelect = true;
                   return false;
                 }
               });

               if (!isSelect) {
                 $.toast('亲，请选择' + paramName + '！', 1000, 'error');
                 return false;
               }


             });
             params = params.substring(0, params.length - 1);
           }

           params += '}';
           paramInfo = params;
           //begin -----------生成购物车数据
           if (isSelect) {
             //将购物车产品数据存储到购物车的sessionStroage中

             var userid = JSON.parse(sessionStorage.getItem('user_info')).userid;

             var productInfo = {};
             productInfo.id = product_id;
             productInfo.userid = userid;
             productInfo.title = product_title;
             productInfo.price = product_price;
             productInfo.thumb = product_thumb;
             productInfo.num = product_num;
             productInfo.transit_cost = transit_cost;
             productInfo.stock = product_stock;
             productInfo.is_real = is_real;
             productInfo.product_sn = product_sn;
             productInfo.levelId = level_id;
             productInfo.params = paramInfo;
             productInfo.siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';

             var cartJson = JSON.parse(sessionStorage.getItem('cart_info'));

             if ($.isEmptyObject(cartJson)) {
               var cartInfo = {};
               cartInfo['1'] = productInfo;
               sessionStorage.setItem('cart_info', JSON.stringify(cartInfo));
             } else {
               var count = 0;
               var isAdd = false;
               $.each(cartJson, function(index, el) {
                 count = index;
                 if (el.id == product_id && el.userid == userid) {
                   product_num = parseInt(el.num) + parseInt(product_num);
                   var cartInfo = cartJson;
                   cartInfo[index]['num'] = product_num;
                   cartInfo[index]['params'] = paramInfo;
                   sessionStorage.setItem('cart_info', JSON.stringify(cartInfo));
                   isAdd = true;
                 }
               });
               if (!isAdd) {
                 var cartInfo = cartJson;
                 cartInfo[++count] = productInfo;
                 sessionStorage.setItem('cart_info', JSON.stringify(cartInfo));
               }
             }

             $.toast('添加成功！正在购物车等你，亲！', 1000, 'success');
             $.closeModal('.popup-add-cart');
           }
           //begin -----------生成购物车数据

         }

       });

     } else {
       window.location.reload();
       return false;
     }
   }

 };
 //--------------------------------------------------------------------------------------
 //--------------------------------------------------------------------------------------/
 //////////////////////////////////////////////////////////////////////////////////////////
 //
 // 立即购物 
 // by seaven                                                                                          
 //////////////////////////////////////////////////////////////////////////////////////////
 //------------------------------------------------------------------------------------

 function promptlyBuy() {
   var userInfo = checkLogin();
   if (!userInfo) {
     var id = JSON.parse(sessionStorage.getItem('product_info')).id;

     //$.router.loadPage("login.php?backPage=product.php?id=" + id); //转到登录页
       $.router.loadPage("login.php?backPage="+window.location.href); //转到登录页


     return false;
   } else {
     var pro_id = JSON.parse(sessionStorage.getItem('product_info')).id;
     if (isEmpty(pro_id)) {
       $.toast('参数错误！正在转到首页....', 2000, 'error');

       var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
       $.router.loadPage("index.php?siteid=" + siteid); //转到首页
     }

     var productInfo = JSON.parse(sessionStorage.getItem('product_info'));
     if (!$.isEmptyObject(productInfo)) {
       var html = '';
       var product_num = JSON.parse(sessionStorage.getItem('product_info')).stock > 0 ? 1 : 0; //产品在购物车中数量


       html += '<div class="popup popup-buy fs06"  style="height:auto;bottom: 0;top:auto;">';

       html += '<div class="content-padded mar0 pad0 padl10 padr10 padb30">';
       html += '<div class="w100b h40 borb1 bc8A8F96 txar"><a href="#" class="iconfont block w30 h30 borrad50 mar0 white txac lh30 floatr close-popup"><i class="iconfont fs06 cc40000 mar0">&#xe604;</i></a></div>';
       html += '<div class="clear"></div>';
       html += '<div class="w100b  padt5 ovfh">';
       html += '<div class="floatl wauto hauto">';
       html += '<img class="w100b w20b fll" src="' + JSON.parse(sessionStorage.getItem('product_info')).thumb + '" alt="">';
       html += '<div class="flr w80b pad0 mar0">';
       html += '<p class="pad0 mar0 marl20">' + cutString(JSON.parse(sessionStorage.getItem('product_info')).title, 100) + '</p>';
       html += '<p class="pad0 mar0 marl20">价格：<span id="product-price" class="cFF4400 fs12 "><em>&yen;' + parseFloat(JSON.parse(sessionStorage.getItem('product_info')).price).toFixed(2) + '</em></span></p>';
       html += '</div>';
       html += '<div class="clear"></div>';
       html += '</div>';
       html += '</div>';
       // begin-----------商品属性
       var params = JSON.parse(sessionStorage.getItem('product_info')).params;
       if(params != null){
          $.each(JSON.parse(params), function(param, el) {
            html += '<div class="product-param w100b hauto">'
            html += '<div class="w100b h40 lh40"><span class="paramName">' + param + '</span>:</div>';
            html += '<div class="paramValue w100b hauto">';
            var paramsValue = el.split('、');
            $.each(paramsValue, function(i, item) {
              html += '<a href="javascript:void(0);" class="select-params inlineblock external wauto pad5 borrad5 bgE2E2E2 c3D4145 marr20 marb15" data-is-selected="false">' + item + '</a>';
            });
            html += '</div>';
            html += '</div>';
          });
       }
      

       // end-----商品属性
       html += '<div class="w100b bort1 bc8A8F96 h60 fs06">';
       html += '<div class="wauto fll">';
       html += '<span class="inlineblock h60 lh60">选择数量:</span>';
       html += '<a href="javascript:void(0);" class="select-product-number iconfont external inlineblock w30 h30 txac lh30 mar0 bgE2E2E2 c868686 marl10" data-fn="minus">&#xe602;</a>';
       html += '<input type="text" readonly="readonly" id="product-number" class="inlineblock w40 h30 lh30 bor0" value="' + product_num + '" data-product-num="' + product_num + '"  style="text-align: center;"/>';
       html += '<a href="javascript:void(0);"  class="select-product-number iconfont external inlineblock w30 h30 txac lh30 mar0 bgE2E2E2 c868686" data-fn="add">&#xe603;</a>';
       html += '</div>'

       html += '<div class="padl20 fll inlineblock h60 lh60">库存：' + JSON.parse(sessionStorage.getItem('product_info')).stock + '件</div>';
       html += '<div class="clear"></div>';
       html += '</div>';
       html += '</div>';



       html += '<a href="javascript:void(0);" id="push-order" data-id="' + JSON.parse(sessionStorage.getItem('product_info')).id + '" data-price="' + JSON.parse(sessionStorage.getItem('product_info')).price + '" data-title="' + JSON.parse(sessionStorage.getItem('product_info')).title + '" data-thumb="' + JSON.parse(sessionStorage.getItem('product_info')).thumb + '"  data-transit-cost="' + JSON.parse(sessionStorage.getItem('product_info')).transit_cost + '" data-product-sn="' + JSON.parse(sessionStorage.getItem('product_info')).product_sn + '" data-is-real="' + JSON.parse(sessionStorage.getItem('product_info')).is_real + '" data-level-id="' + JSON.parse(sessionStorage.getItem('product_info')).levelId + '" data-stock="' + JSON.parse(sessionStorage.getItem('product_info')).stock + '" class="block external w100b h50 txac lh50 bgFF1700 white fs08">确定</a>';
       html += '</div>';
       $.popup(html);

       //begin -------选择商品属性
       $('.select-params').bind('click', function() {
         var productParamGroups = $(this).parent().find('.select-params');
         $.each(productParamGroups, function(i) {
           $(this).attr('data-is-selected', false);
           $(this).css({
             'background': '#E2E2E2',
             'color': '#3D4145'
           });
         })
         $(this).attr('data-is-selected', true);
         $(this).css({
           'background': '#FF1404',
           'color': '#FFF'
         });
       });
       //end ----------选择商品属性
       //
       //begin ------增加和减少商品数量
       $('.select-product-number').bind('click', function() {
         var num = $('#product-number').val();
         var product_num = num;
         var stock = JSON.parse(sessionStorage.getItem('product_info')).stock;
         if ($(this).attr('data-fn') == 'minus') {
           if (num > 1) num--;
           else num = num;
         } else {
           if (parseInt(num) >= parseInt(stock)) {
             $.toast('亲，没有库存了！', 1000, 'error');
             num = stock;
           } else num++;
         }
         $('#product-number').val(num);
         product_num = num;
       });
       //end ------增加和减少商品数量
       //
       //beign ------生成订单
       $('#push-order').bind('click', function() {
         product_num = $('#product-number').val();
         if (product_num == 0) {
           $.toast('亲，请选择商品数量！', 1000, 'error');
         } else {
           //将需要提交的订单信息存入sessionStorage中
           var product_id = $(this).attr('data-id');
           var product_title = $(this).attr('data-title');
           var product_price = $(this).attr('data-price');
           var product_thumb = $(this).attr('data-thumb');
           var transit_cost = $(this).attr('data-transit-cost');
           var product_stock = $(this).attr('data-stock');
           var product_sn = $(this).attr('data-product-sn');
           var is_real = $(this).attr('data-is-real');
           var level_id = $(this).attr('data-level-id');
           var paramInfo = {};
           var paramName = '';
           var paramValueGroup = '';
           var isSelect = $('.product-param').length == 0 ? true : false; //判断是否选择属性

           //获取产品属性
           
           //获取产品属性
           var params = '{';
           if ($('.product-param').length> 0) {
             
             $('.product-param').each(function(index, item) {

               paramName = $(this).find('.paramName').html();
               //params.paramName = paramName;
               params += '"'+paramName + '":';
               paramValueGroup = $(this).find('.paramValue').find('.select-params');
               isSelect = false;
               $.each(paramValueGroup, function() {
                 if ($(this).attr('data-is-selected') == 'true') {
                   var paramValue = $(this).html();
                   params += '"'+paramValue + '",';
                   //params.paramValue = paramValue;
                   isSelect = true;
                   return false;
                 }
               });

               if (!isSelect) {
                 $.toast('亲，请选择' + paramName + '！', 1000, 'error');
                 return false;
               }
               // else{

               //   //paramInfo[index] = params;
               // }


             });
             params = params.substring(0, params.length - 1);
           }

           params += '}';
           paramInfo = params;
           if (isSelect) {
             var userid = JSON.parse(sessionStorage.getItem('user_info')).userid;

             var productInfo = {};
             productInfo.id = product_id;
             productInfo.userid = userid;
             productInfo.siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
             productInfo.title = product_title;
             productInfo.price = product_price;
             productInfo.thumb = product_thumb;
             productInfo.num = product_num;
             productInfo.transit_cost = transit_cost;
             productInfo.params = paramInfo;
             productInfo.is_real = is_real;
             productInfo.product_sn = product_sn;
             productInfo.stock = product_stock;
             productInfo.levelId = level_id;
             productInfo.params = paramInfo;


             var submitOrder_info = {
               '0': productInfo
             };
             sessionStorage.removeItem("submitOrder_info");

             sessionStorage.setItem('submitOrder_info', JSON.stringify(submitOrder_info));
             $.closeModal('.popup-buy');

             $.router.loadPage("submit_order.php", true);
           }


         }
       });
       //end --------------生成订单
     }

   }
 }

 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * [ajaxRequest ]
  * @method ajaxRequest
  * @return {[type]}    [description]
  */
 function ajaxRequest(type, async, data) {
   var json = '';
   $.ajax({
     type: type,
     url: apiUrl,
     async: async,
     data: data,
     dataType: "json",
     headers: {
       "Token": sso_Token
     },
     success: function(result) {
       json = result;
     }
   });
   return json;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 检查店铺是否存在
  * @param  {[type]} siteid [description]
  * @return {[type]}        [description]
  */
 function checkShop(siteid) {
   var data = {
     m: 'index',
     c: 'index',
     a: 'checkShop',
     siteid: siteid
   };
   var json = '';
   json = ajaxRequest('GET', false, data);
   //返回1 店铺存在  0  店铺不存在
   return json.code;

 }
 //------------------------------------------------------------------------------------------------------------------------------

 /**
  * [getShopInfo 获取店铺信息]
  * @param  {[type]} id [description]
  * @return {[type]}    [description]
  */
 function getShopInfo(siteid) {
   var data = {
     m: 'index',
     c: 'index',
     a: 'getShop',
     siteid: siteid
   };
   var json = '';
   json = ajaxRequest('GET', false, data);
   return json;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * [getAdvert 获取商品广告信息]
  * @param  {[type]} id [用户id]
  * @return {[type]}    [description]
  */
 function getAdvert(siteid) {
   var data = {
     m: 'index',
     c: 'index',
     a: 'getAdvert',
     siteid: siteid
   };
   var json = '';
   json = ajaxRequest('GET', false, data);
   return json;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * [getCategoty 获取栏目信息]
  * @method getCategoty
  * @return {[type]}    [description]
  */
 function getCategoty(siteid) {
   var data = {
     m: 'index',
     c: 'index',
     a: 'getCate',
     siteid: siteid
   };
   var json = '';
   json = ajaxRequest('GET', false, data);
   return json;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * [getHotProduct 获取热门商品]
  * @method getHotProduct
  * @return {[type]}      [description]
  */
 function getHotProduct(siteid) {
   var data = {
     m: 'index',
     c: 'index',
     a: 'getHotProduct',
     siteid: siteid
   };
   var json = '';
   json = ajaxRequest('GET', false, data);
   return json.data;
 }

 //------------------------------------------------------------------------------------------------------------------------------
 /**
  * 定义一个判断函数
  * @param  {[type]} attr   [description]
  * @param  {[type]} arrays [description]
  * @return {[type]}        [description]
  * @Author:seaven
  */
 function in_array(attr, arrays) {
   // 遍历是否在数组中
   var arrays = arrays;
   var k = arrays.length;
   for (var i = 0; i < k; i++) {
     if (attr == arrays[i]) {
       return true;
     }
   }
   // 如果不在数组中就会返回false
   return false;
 }
 //------------------------------------------------------------------------------------------------------------------------------
 /**********************************************************
     图片加载失败，替换图片路径
     @替换的图片路径
     @需替换的图片类名
     @Author: seaven
 ***********************************************************/

 function imgErrorReplace(replace2src, imgClass) {
   var imgObj = $('.' + imgClass);
   imgObj.each(function() {
     var error = false;
     if (!this.complete) {
       error = true;
     }
     if (typeof this.naturalWidth != "undefined" && this.naturalWidth == 0) {
       error = true;
     }
     if (error) {
       $(this).bind('error.replaceSrc', function() {
         this.src = replace2src;
         $(this).unbind('error.replaceSrc');
       }).trigger('load');
     }
   })

 }

 //----------------------------------------------------------------------------------------------
 //**---------工具栏----------**/
 //底部工具栏链接处理
 //@Author: lipeng
 //@Last Modified by:   seaven
 //----------------------------------------------------------------------------------------------
 toolsBar();

 function toolsBar() {
   $(document).on('click', '.toools-bar-but', function() {
     var isLogin = checkLogin();

     switch ($(this).attr('data-but-type')) {
       case 'member':
         if (!isLogin) {
           $.router.loadPage("login.php"); //转到登录页
           return false;
         }
         window.location.href = 'member.php';
         break;
       case 'order':
         if (!isLogin) {
           $.router.loadPage("login.php?backPage=http://www.zj3w.net/order.php"); //转到登录页
           return false;
         }
         // $.router.loadPage('order.php?order_type=');
         window.location.href = 'order.php?order_type=';
         break;
       case 'cart':
         if (!isLogin) {
           $.router.loadPage("login.php?backPage=http://www.zj3w.net/cart.php"); //转到登录页
           return false;
         }
         $.router.loadPage('cart.php');
         break;
       case 'index':
         //$.router.loadPage('index.php',true);
         var siteid = sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
         window.location.href = 'index.php?siteid=' + siteid;
         break;
        default:
        $.router.loadPage("about.php"); //转到登录页
        break;
     }

   });
 }
 //------------------------------------------------------------
 //**
 /**
  * 回到顶部
  */

 function scrollToTop(obj) {

   var n = 0,
     m = 0,
     timer = null,
     that = obj;
   m = n = that.scrollTop();
   var smoothScroll = function(m) {
     var per = Math.round(m / 50);
     n = n - per;
     if (n <= 0) {
       that.scrollTop(0);
       window.clearInterval(timer);
       return false;
     }
     that.scrollTop(n);
   };

   timer = window.setInterval(function() {
     smoothScroll(m);
   }, 20);
 }

 //---------------------------------------------------------------------

 /** 
 * js截取字符串，中英文都能用 
 * @param str：需要截取的字符串 
 * @param len: 需要截取的长度 
 */  
function cutstr(str,len)  
{  
  var str_length = 0;  
  var str_len = 0;  
  str_cut = new String();  
  str_len = str.length;  
  for(var i = 0; i < str_len; i++)  
  {  
    a = str.charAt(i);  
        str_length++;  
        if(escape(a).length > 4)  
        {  
          //中文字符的长度经编码之后大于4  
          str_length++;  
      }  
      str_cut = str_cut.concat(a);  
      if(str_length>=len)  
      {  
        str_cut = str_cut.concat("...");  
          return str_cut;  
        }  
  }  
    //如果给定字符串小于指定长度，则返回源字符串；  
    if(str_length < len){  
      return  str;  
  }  
}  

 //---------------------------------------------------------------------

function urlencode(clearString) 
{
  var output = '';
  var x = 0;
  
  clearString = utf16to8(clearString.toString());
  var regex = /(^[a-zA-Z0-9-_.]*)/;

  while (x < clearString.length) 
  {
    var match = regex.exec(clearString.substr(x));
    if (match != null && match.length > 1 && match[1] != '') 
    {
      output += match[1];
      x += match[1].length;
    } 
    else 
    {
      if (clearString[x] == ' ')
        output += '+';
      else 
      {
        var charCode = clearString.charCodeAt(x);
        var hexVal = charCode.toString(16);
        output += '%' + ( hexVal.length < 2 ? '0' : '' ) + hexVal.toUpperCase();
      }
      x++;
    }
  }

 //---------------------------------------------------------------------

  function utf16to8(str) 
  {
    var out, i, len, c;

    out = "";
    len = str.length;
    for(i = 0; i < len; i++) 
    {
      c = str.charCodeAt(i);
      if ((c >= 0x0001) && (c <= 0x007F)) 
      {
        out += str.charAt(i);
      } 
      else if (c > 0x07FF) 
      {
        out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
        out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
        out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
      } 
      else 
      {
        out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
        out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
      }
    }
    return out;
  }

  return output;
}
// --------------------------
        if(!sessionStorage.getItem('site_info') || getRrlParam('siteid') ){
            var siteid = getRrlParam('siteid') ;
        //判断地址是否有siteid
          siteid = isEmpty(siteid)?'1':siteid;
          //判断是否存在店铺，不存在转平台店铺
          siteid = checkShop(siteid)== 0 ? 1: siteid;
          //sessionStorage 清除浏览器中店铺信息
          sessionStorage.removeItem("site_info");
          sessionStorage.removeItem("categories_info");
          //初始化浏览器中店铺的信息 siteinfo
          var siteinfo = {};
          siteinfo.siteid = siteid;
          sessionStorage.setItem('site_info',JSON.stringify(siteinfo));
        }
        

        /**
        * [默认分享 share]
        * 
        */
        var shareData = sessionStorage.getItem("shareData_info");
         if(isEmpty(shareData) || shareData == 'null' || shareData != 'undefined' ){

        var suse = sessionStorage.getItem('userid') || sessionStorage.getItem('YunUser') ||  sessionStorage.getItem('site_info') != null ? JSON.parse(sessionStorage.getItem('site_info')).siteid : '1';
        sessionStorage.setItem("YunUserId",suse);
        var sdate = sessionStorage.getItem("shareData_info");
        // if(!sdate){
        // var siteid = JSON.parse(sessionStorage.getItem("site_info")).siteid;
        var shopInfo = getShopInfo(suse);
        // if(!shopInfo) shopInfo = getShopInfo(1);
        var shareData = {};
        shareData.title = '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
        shareData.desc = shopInfo.desc || '云兆云商城-'+shopInfo.name || '云兆云商城-云兆商城平台';
        shareData.link = APP_PATH + 'index.php?siteid=' + siteid + '&YunUser=' + sessionStorage.getItem('YunUserId');
        shareData.thumb = shopInfo.avatar || 'http://res.zj3w.net/category/icon/2016/03/11/56e2aa4726f2464.png';
        ;
        sessionStorage.setItem('shareData_info',JSON.stringify(shareData));
        }