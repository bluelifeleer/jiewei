<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>
            云兆●云商城
        </title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
        <link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
        <link rel="stylesheet" href="/sources/css/demos.css"/>
        <link rel="stylesheet" type="text/css" href="/sources/js/simditor/styles/simditor.css" />
    </head>
    <body>
      <!-- page 容器 -->
      <div class="page" id="page-shop-product-add-detail">

       <style type="text/css">
        
       .webuploader-container {
        position: relative;
        text-align: center;
       }
       .webuploader-element-invisible {
        position: absolute !important;
        clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
           clip: rect(1px,1px,1px,1px);
       }
       .webuploader-pick {
        margin:8px auto; 
        position: relative;
        display: inline-block;
        cursor: pointer;
        background: #00b7ee;
        color: #fff;
        text-align: center;
        border-radius: 3px;
        overflow: hidden;
       }
       .webuploader-pick-hover {
        background: #00a2d4;
       }

       .webuploader-pick-disable {
        opacity: 0.6;
        pointer-events:none;
       }

      </style>
       <!-- 配置文件 -->
     
      <!-- 标题栏 -->
      <header class="bar bar-nav">
          <a class="pull-left back" href="shop_product_create.php">
              <i class="icon iconfont mar0 white">
                  &#xe61b;
              </i>
          </a>
          <h1 class="title">
              图文详情
          </h1>

        <a class="pull-right submit-product-detail external" href="javascript:void(0);">
            <i class="icon iconfont mar0 white" style="font-size: 14px;cursor: pointer;">完成</i>
         </a>
              
      </header>

       <!-- 这里是页面内容区 -->
    <div class="content" style="padding-bottom: 80px;">
       <div class="content-block-title" style="margin-top: .75rem;">完善产品图文详情信息</div>
       <div class="card list-block pad1">
           <!-- 加载编辑器的容器 -->
         <textarea id="editor" placeholder="请长按后输入内容！" autofocus></textarea>

        
          <div class="item-content padt20 padb20">
            <div class="item-inner">
              <div class="item-input w100b">
               <input type="hidden" class="input-product-detail" name="thumb" >
                 <div class="card-content detail-img-List" style="position:relative;">
                
                   <!--  <img class="input-product-detail-img"  id="input-product-detail-img" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="100" height="100" style="border:1px #ccc solid;"> -->
                 </div>
              
              </div>
            </div>
          </div>

          <div  class="" id="uploaderDetail" style="width: 120px;line-height: 30px;">上传详情图片</div>
          
          <div class="content-block-title" style="margin-top: .75rem;">产品属性</div>
          <ul class="product-params-list">
          <input type="hidden" class="input-product-id" value="">
          
           <li>
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label w20b fs07">属性名</div>
                    <div class="item-input w70b">
                       <div class="item-title label  fs07">属性值</div>
                    </div>
                    <div class="item-input w10b" id="add-product-params">
                       <i class="icon iconfont mar0 c666">
                           &#xe603;
                       </i>
                    </div>
                  </div>
                </div>
              </li>
            
             
            </ul>
       </div>
       
    </div>

  
    </div>
    </body>


    <script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
    <script type="text/javascript" src="/sources/js/zepto.picLazyLoad.min.js"></script>
    <script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/module/public.js"></script>
    <script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>
    
    <script type="text/javascript" src="/sources/js/simditor/scripts/jquery.min.js"></script>
    <script type="text/javascript" src="/sources/js/simditor/scripts/module.js"></script>
    <script type="text/javascript" src="sources/js/simditor/scripts/hotkeys.js"></script>
    <script type="text/javascript" src="sources/js/simditor/scripts/uploader.js"></script>
    <script type="text/javascript" src="/sources/js/simditor/scripts/simditor.js"></script>
    <script type="text/javascript">
      var editor;
      jQuery.noConflict();
      jQuery(function($){
        
        editor = new Simditor({
             textarea: $('#editor'),
             placeholder: '',
             defaultImage: 'images/image.png',
             params: {},
             upload: false,
             tabIndent: true,
             toolbar: [
                      // 'title',
                      // 'bold',
                      // 'italic',
                      // 'underline',
                      // 'strikethrough',
                      // 'fontScale',
                      // 'ul'
                      // 'blockquote',
                      // 'hr',
                      // 'indent',
                      // 'outdent',
                      // 'alignment'
                    ],
             toolbarFloat: true,
             toolbarFloatOffset: 0,
             toolbarHidden: false,
             pasteImage: false,
             cleanPaste: false
          });
      });


     //$.init();
    </script>

    
    <script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>



    </html>