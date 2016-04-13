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
        <link rel="stylesheet" href="/sources/css/add.css"/>
       
    </head>
    <body>
        <!-- page 容器 -->
        <div class="page" id="page-product-create">


         <style type="text/css">
          
          .webuploader-container {
            position: relative;
          }
          .webuploader-element-invisible {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
              clip: rect(1px,1px,1px,1px);
          }
          .webuploader-pick {
            position: relative;
            display: inline-block;
            cursor: pointer;
            background: #00b7ee;
            padding: 15px 20px;
            color: #fff;
            text-align: center;
            border-radius: 3px;
            overflow: hidden;/*
            width:176px;
            height:176px;*/
            opacity:0;
            filter:alpha(opacity=0);
          }
          .webuploader-pick-hover {
            background: #00a2d4;
          }

          .webuploader-pick-disable {
            opacity: 0.6;
            pointer-events:none;
          }
          #filePicker{
            position: absolute;
            top:0;
            right:0;
            opacity: 0;
            height: 45px;
          }
        </style>
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <a class="pull-left back" href="shop_product_add.php">
                    <i class="icon iconfont mar0 white">
                        &#xe61b;
                    </i>
                </a>
                <h1 class="title">
                创建产品
                </h1>
                <a class="pull-right external shop-product-detail disn" href="shop_product_detail.php">
                    <i class="icon iconfont mar0 white" style="font-size: 14px;cursor: pointer;">详情</i>
                 </a>
                      
            </header>
           
            <!-- 这里是页面内容区 -->
            <div class="content bgEEEEEE">

                <div class="content-block-title" style="margin-top: .75rem;">填写产品信息</div>
                <form action="#" method="post">
                  
                <!-- 产品id -->
                <input type="hidden" class="input-product-id" name="id" readonly="readonly">

                <div class="list-block">
                    <ul>
                        <!-- product_sn 货号 -->
                        <li>
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">货号</div>
                              <div class="item-input w80b">
                                <input type="text" class="input-product-sn" style="font-size: 0.75rem;color: #999;"  placeholder="如：hd00004">
                              </div>
                            </div>
                          </div>
                        </li>
                        <!-- title 标题 -->
                        <li class="align-top">
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">标题</div>
                              <div class="item-input w80b">
                                 <input type="text" class="input-product-title"  style="font-size: 0.75rem;color: #999;" placeholder="标题">
                              </div>
                            </div>
                          </div>
                        </li>
                         <!-- short_desc 描述 -->
                        <li class="align-top">
                          <div class="item-content">
                            <div class="item-inner">
                              <div class="item-title label w20b fs07">描述</div>
                              <div class="item-input w80b">
                                <textarea class="input-product-short-desc"  style="font-size: 0.75rem;color: #999;" placeholder="请输入商品短描述"></textarea>
                              </div>
                            </div>
                          </div>
                      </li>

                      <!-- keywords 关键字 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">关键字</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-keywords"  style="font-size: 0.75rem;color: #999;" placeholder="用','分隔，如：云兆,界微">
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- sale_price 销售价格 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">价格</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-sale-price" style="font-size: 0.75rem;color: #999;"  placeholder="价格">
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- stock 库存 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">库存</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-stock" style="font-size: 0.75rem;color: #999;" placeholder="库存">
                            </div>
                          </div>
                        </div>
                      </li>

                      <!-- thumb 封面 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">封面</div>
                            <div class="item-input w80b">
                             <input type="hidden" class="input-product-thumb" name="thumb" >
                               <div class="card-content" style="position:relative;">
                              
                                  <img class="input-product-thumb-img"  id="input-product-thumb-img" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="200" height="200" style="border:1px #ccc solid;">

                                   <div  class="" id="uploaderThumb" style="position:absolute;left:11px;top:11px; z-index:1100"></div>
                               </div>
                            
                            </div>
                          </div>
                        </div>
                      </li>
                     
                      <!-- pictures 图组 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">图组</div>
                            <div class="item-input w80b">
                               <input type="hidden" class="input-product-pic input-product-pictures-1" name="pictures" readonly="readonly">
                               <input type="hidden" class="input-product-pic input-product-pictures-2" name="pictures" readonly="readonly">
                               <input type="hidden" class="input-product-pic input-product-pictures-3" name="pictures" readonly="readonly">
                               <input type="hidden" class="input-product-pic input-product-pictures-4" name="pictures" readonly="readonly">
                               <input type="hidden" class="input-product-pic input-product-pictures-5" name="pictures" readonly="readonly">

                            </div>
                          </div>
                        </div>
                        <li class="align-top">
                          <div class="item-content">
                            <div class="item-inner">
                             <div class="facebook-avatar">
                                 <img class="input-product-pictures-img fll" id="input-product-pic-1"  src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="64" height="64" style="margin-right: 2px;border:1px #ccc solid;">
                                  <div  class="" id="uploaderPic-1" style="position:absolute;left:4px;top:8px;z-index:1100"></div>
                                 <img class="input-product-pictures-img fll" id="input-product-pic-2" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="64" height="64" style="margin-right: 2px;border:1px #ccc solid;">
                                 <div  class="" id="uploaderPic-2" style="position:absolute;left:68px;top:8px;z-index:1100"></div>
                                 <img class="input-product-pictures-img fll" id="input-product-pic-3" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="64" height="64" style="margin-right: 2px;border:1px #ccc solid;">
                                 <div  class="" id="uploaderPic-3" style="position:absolute;left:132px;top:8px;z-index:1100"></div>
                                 <img class="input-product-pictures-img fll" id="input-product-pic-4" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="64" height="64" style="margin-right: 2px;border:1px #ccc solid;">
                                 <div  class="" id="uploaderPic-4" style="position:absolute;left:196px;top:8px;z-index:1100"></div>
                                 <img class="input-product-pictures-img fll" id="input-product-pic-5" src="http://console.zj3w.net/resource/js/webuploader/images/uploadImg.png" width="64" height="64" style="margin-right: 2px;border:1px #ccc solid;">
                                 <div  class="" id="uploaderPic-5" style="position:absolute;left:260px;top:8px;z-index:1100"></div>
                             </div>
                            </div>
                          </div>
                        </li>
                      </li>
                      <!-- catid 栏目 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">栏目</div>
                            <div class="item-input w80b">
                                <select class="input-select-product-cate" name="catid" style="font-size: 0.75rem;color: #999;">                              
                                </select>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- made 产地 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">产地</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-made" style="font-size: 0.75rem;color: #999;"  placeholder="产地">
                            </div>
                          </div>
                        </div>
                      </li>
          
          
                      <!-- transit_type 物流方式 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">物流方式</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-transit-type"  style="font-size: 0.75rem;color: #999;" placeholder="如：包邮，快递">
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- transit_cost 物流费 -->
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">物流费</div>
                            <div class="item-input w80b">
                               <input type="text" class="input-product-transit-cost"  style="font-size: 0.75rem;color: #999;" placeholder="如：10">
                            </div>
                          </div>
                        </div>
                      </li>

                      <!-- 上架 is_up(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">上架</div>
                            <div class="item-input w80b">
                              <label class="label-switch">
                                <input type="checkbox" name="is_up" class="input-product-is-up">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- 热销 is_hot(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">热销</div>
                            <div class="item-input w80b">
                              <label class="label-switch">
                                <input type="checkbox" name="is_hot" class="input-product-is-hot">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- 是否虚拟产品 is_real(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">虚拟</div>
                            <div class="item-input w80b">
                              <label class="label-switch">
                                <input type="checkbox" name="is_real" class="input-product-is-real">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- 爆款 is_explosion(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label  w20b fs07">爆款</div>
                            <div class="item-input w80b">
                              <label class="label-switch">
                                <input type="checkbox" name="is_explosion" class="input-product-is-explosion">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>
                       <!-- 进口 is_overseas(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b fs07">进口</div>
                            <div class="item-input w80b">
                              <label class="label-switch">
                                <input type="checkbox" name="is_overseas" class="input-product-is-overseas">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>
                       <!-- 推荐 is_recommend(Checkbox) -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title label w20b  fs07">推荐</div>
                            <div class="item-input w80b ">
                              <label class="label-switch">
                                <input type="checkbox" name="is_recommend"  class="input-product-is-recommend">
                                <div class="checkbox"></div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </li>

                    </ul>
                </div>

                <div class="content-block">
                  <div class="row">
                    <div class="w50b" style="margin: 10px auto;"><span class="button input-product-submit button-fill button-success">提交</span></div>
                  </div>
                </div>
              </form>
             
            </div>
            
        </div>
     
    </body>
    <script type="text/javascript" src="/sources/js/zepto-full.1.1.6.min.js"></script>
    <script type="text/javascript" src="/sources/js/sm.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/sm-extend.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/sources/js/module/public.js"></script>
    <script type="text/javascript" src="/sources/js/module/jweixin-1.0.0.js"></script>
    
    <script type="text/javascript" src="/sources/js/webuploader.js" charset="utf-8"></script>

   
    <script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>

</html>
