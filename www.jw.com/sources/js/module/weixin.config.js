var url = location.href;
$.ajax({
  type: "get",
  url: "http://api.zj3w.net/index.php?m=wechat&c=index&a=weixinJs&url=" + (url),
  dataType: "jsonp",
  jsonp: "callback",
  jsonpCallback: "success_jsonpCallback",
  headers: {
    "Token": sso_Token
  },
  success: function(data) {
    wx.config({
      appId: data.appId,
      timestamp: data.timestamp,
      nonceStr: data.nonceStr,
      signature: data.signature,
      jsApiList: [
        "onMenuShareTimeline",
        "onMenuShareAppMessage"
      ]
    });
  },
  error: function(data) {
    // alert("连接失败！");
  }
});



wx.ready(function() {

  //alert('第一个页面');
  //进入首页时初始化分享数据。
  // var shareData = {
  //   title: $("#shareData").attr('data-title'),
  //   desc: $("#shareData").attr('data-desc'),
  //   link: $("#shareData").attr('data-link'),
  //   imgUrl: $("#shareData").attr('data-thumb')
  // }
   var shareData = {
      title: JSON.parse(sessionStorage.getItem('shareData_info')).title,
      desc: JSON.parse(sessionStorage.getItem('shareData_info')).desc,
      link: JSON.parse(sessionStorage.getItem('shareData_info')).link,
      imgUrl:JSON.parse(sessionStorage.getItem('shareData_info')).thumb
    };
  wx.onMenuShareAppMessage(shareData);
  wx.onMenuShareTimeline(shareData);

  //新页面中的组件初始化完毕 ,初始化分享数据
  $(document).on("pageInit", function(e, pageId, $page) {
  
    //alert('第二个页面');
    var shareData = {
      title: JSON.parse(sessionStorage.getItem('shareData_info')).title,
      desc: JSON.parse(sessionStorage.getItem('shareData_info')).desc,
      link: JSON.parse(sessionStorage.getItem('shareData_info')).link,
      imgUrl:JSON.parse(sessionStorage.getItem('shareData_info')).thumb
    };
    wx.onMenuShareAppMessage(shareData);
    wx.onMenuShareTimeline(shareData);

  });

});