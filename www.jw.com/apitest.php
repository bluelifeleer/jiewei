<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>接口测试</title>
    <style>
      body{width:100%;height:100%;padding:0;margin:0;background:#FFF;}
      .content-block{width:990px;margin:0 auto;}
      .select-method-block{width:100%;}
      .request-url-block{width:100%;height:40px;line-height:40px;margin:8px 0;}
      #request-url{width:580px;height:28px;line-height:28px;border:1px solid #c1c1c1;}
      .content-title{width:100%;height:50px;line-height:50px;font-size:30px;text-align:center;border-bottom:2px soldi #c1c1c1;}
      .content-body{width:100%;}
      .content-body-title{width:100%;height:30px;line-height:30px;margin:20 0;}
      .contnet-body-content{width:100%;height:auto;border:1px solid #c1c1c1;box-sizing:border-box;padding:0;margin:0;}
      #body-content{width:100%;height:300px;padding:0;margin:0;box-sizing:border-box;border:none;}
      .space-line{width:100%;height:1px;background:#c1c1c1}
      .sub-but-block{width:100%;height:50px;margin-top:10px;}
      #submit-but{display:block;width:220px;height:40px;line-height:40px;text-align:center;margin:0 auto;background:#1B63F8;color:#FFF;text-decoration:none;}
    </style>
    <script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
    <!--<script type="text/javascript" src="http://cdn.bootcss.com/zepto/1.1.6/zepto.min.js"></script>-->
  </head>
  <body>
    <div class="content-block">
      <div class="content-title">API接口测试</div>
      <div class="select-method-block">
        <label for="request-method">请求方式：</label><select name="request-method" id="select-method-but">
          <option value="get" selected="selected">GET</option>
          <option value="post">POST</option>
        </select>
      </div>
      <div class="request-url-block">
        <label for="request-url-input">请求地址：</label>
        <input type="text" name="request-url-input" id="request-url" />
      </div>
      <div class="content-body">
        <div class="content-body-title">body:<i style="font-szie:2px;color:#F00">(请求的数据以JSON形式写在下面,如：{"userid":2})</i></div>
        <div class="contnet-body-content">
          <textarea id="body-content" ></textarea>
        </div>
      </div>
      <div class="sub-but-block">
        <a href="javascript:void(0);" id="submit-but">提交</a>
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        $('#submit-but').on('click',function(){
          var method = $('option').not(function(){return !this.selected}).val();
          var url = $('#request-url').val();
          var data = $.parseJSON($('#body-content').val());
          if(method.toLocaleLowerCase() == 'get'){
            var param = '';
            var i='';
            if(data && data !== ''){
              for(i in data){
                param += i+"/"+data[i]+"/";
              }
              url = url+"/"+param.substr(0,parseInt(param.length-1));
            }else{
              url = url;
            }
            $.get(url,function(respos){
              var strToJson = $.parseJSON(respos);
                var newData = jsonDataToHtml(strToJson);

                var html = '<div style="width:100%;">'+
                              '<div style="width:100%;height:30px;line-height:30px;">格式化后的数据：</div>'+
                              '<div style="width:100%;padding:10px 0;">{<br/>'+newData.substr(0,parseInt(newData.length-6))+'<br/>}</div>'+
                           '</div>'+
                           '<div style="width:100%;height:1px;background:#c1c1c1;"></div>'+
                           '<div style="width:100%;">'+
                            '<div style="width:100%;height:30px;line-height:30px;">返回的源数据：</div>'+
                            '<div style="width:100%;padding:10px 0;">'+respos+'</div>'+
                           '</div>';
                $('#body-content').css('display','none');
                $('.contnet-body-content').php(html);
            });
          }else{
            if(data == '') return false;//判断提交的数据是否为空
            $.post(url,data,function(respos){
              var strToJson = $.parseJSON(respos);
                var newData = jsonDataToHtml(strToJson);

                var html = '<div style="width:100%;">'+
                              '<div style="width:100%;height:30px;line-height:30px;">格式化后的数据：</div>'+
                              '<div style="width:100%;padding:10px 0;">{<br/>'+newData.substr(0,parseInt(newData.length-6))+'<br/>}</div>'+
                           '</div>'+
                           '<div style="width:100%;height:1px;background:#c1c1c1;"></div>'+
                           '<div style="width:100%;">'+
                            '<div style="width:100%;height:30px;line-height:30px;">返回的源数据：</div>'+
                            '<div style="width:100%;padding:10px 0;">'+respos+'</div>'+
                           '</div>';
                $('#body-content').css('display','none');
                $('.contnet-body-content').php(html);
            });
          }



          function jsonDataToHtml(json){
            var j='';
            var strHtml = '';
            for(j in json){
              strHtml += '&nbsp;&nbsp;&nbsp;&nbsp;"'+j+'":"'+json[j]+'",</br>';
            }
            return strHtml;
          }

          //将字符串格式的数组转换成数组对象
          function strToArr(str){
            var temp = [];
            var str = str.split(',');
            for(var i=0; i<str.length; i++){
              temp.push(str[i]);
            }
            return temp;
          }
          　
        });
      });
    </script>
  </body>
</html>
