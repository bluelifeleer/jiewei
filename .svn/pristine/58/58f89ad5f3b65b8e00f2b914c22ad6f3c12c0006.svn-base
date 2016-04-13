<?php
include_once('./Common/public.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>云兆●云商城</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/favicon.ico">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/sources/css/sm.min.css"/>
        <link rel="stylesheet" href="/sources/css/sm-extend.min.css"/>
		<link rel="stylesheet" href="/sources/css/demos.css">
		<link rel="stylesheet" type="text/css" href="/sources/css/add.css">
	</head>
	<body>
		<!-- page 容器 -->

		<div class="page" id="page-product-detail-manage">

			<!-- 标题栏 -->
			<header class="bar bar-nav">
				<h1 class="title">商品详情</h1>
				<a class="pull-left back" id="pull-left" href="shop_product_manage.php">
					<i class="icon iconfont mar0 fs13 white">&#xe61b;</i>
				</a>
				
			</header>
		
			<div class="content">
				<div class="card mar0 bgfff">
					<div class="w100b">
						<div class="product_detail" >
							<div  class="pos-r product-banner" >
								<ul class="picitems" style="min-height: 15rem;">
									<div class="infinite-scroll-preloader">
										<div class="preloader" style="margin-top: 6rem" ></div>
										
									</div>
									
									<!-- <li class="w100b"><img class="w100b" src="/sources/images/goods11.jpg"></li> -->
								</ul>
								<div class="pos-a product-banners" style="bottom:5px;left:50%"></div>
							</div>
						</div>
					</div>
					<div class="pad10 fs07">
						<div class="product-title">商品名称....</div>
						
					</div>
				</div>
			
				<div class="card mar0 mart10">
					<div class="card-content form-product c999"  style="padding-bottom: 20px;"> 
                         <form class="product-info" action="#" method="post">
                                   
          				<div class="list-block">
                             
          				      <ul>
          				      	<!-- 产品id -->
          				      	<input type="hidden" class="input_product_id" name="id" readonly="readonly">
                                        <input type="hidden" class="input_fromid" name="fromid" readonly="readonly">
          				        <!-- 产品货号 -->
          				      	  <li>
          				              <div class="item-content">
          				                <div class="item-inner">
          				                  <div class="item-title label w20b fs07">货号</div>
          				                  <div class="item-input w80b">
          				                    <input type="text" class="input_product_sn fs07 c999" name="product_sn"  style="font-size: 0.75rem;color: #999;" readonly="readonly" placeholder="货号">
          				                  </div>
          				                </div>
          				              </div>
          				            </li>
          				      <!-- 产品名称 -->
          				    	  <li>
          				            <div class="item-content">
          				              <div class="item-inner ">
          				                <div class="item-title label w20b fs07">名称</div>
          				                <div class="item-input w80b">
          				                  <input type="text" class="input_title" name="title" readonly="readonly" style="font-size: 0.75rem;color: #999;" placeholder="名称">
          				                </div>
          				              </div>
          				            </div>
          				          </li>
          				           <li>
          				            <div class="item-content">
          				              <div class="item-inner">
          				                <div class="item-title label w20b fs07">栏目</div>
          				                <div class="item-input w80b">
          				                  <select class="input-select-cate" name="catid" style="font-size: 0.75rem;color: #999;">
			                               
			                                </select>
          				                </div>
          				              </div>
          				            </div>
          				          </li>
          				          <!-- 产品描述 -->
          				    	  <li>
          				            <div class="item-content">
          				              <div class="item-inner">
          				                <div class="item-title label w20b fs07">描述</div>
          				                <div class="item-input w80b">
          				                  <textarea name="short_desc" style="font-size: 0.75rem;color: #999;height: 7rem;" class="input_short_desc"></textarea>
          				                </div>
          				              </div>
          				            </div>
          				          </li>
          				           </li>
          				            <!-- 产品价格 -->
          				          	  <li>
          				                  <div class="item-content">
          				                    <div class="item-inner">
          				                      <div class="item-title label w20b fs07">价格</div>
          				                      <div class="item-input w80b">
          				                        <input type="text" class="input_sale_price"  name="sale_price" style="font-size: 0.75rem;color: #999;" readonly="readonly" placeholder="价格">
          				                      </div>
          				                    </div>
          				                  </div>
          				                </li>

          				              <!-- 产品产地 -->
          				          	  <li>
          				                  <div class="item-content">
          				                    <div class="item-inner">
          				                      <div class="item-title label w20b fs07">产地</div>
          				                      <div class="item-input w80b">
          				                        <input type="text" name="input_made" class="input_made" style="font-size: 0.75rem;color: #999;" readonly="readonly" placeholder="产地">
          				                      </div>
          				                    </div>
          				                  </div>
          				                </li>
          				        <!-- Switch (Checkbox) -->
          				        <li>
          				          <div class="item-content">
          				           
          				            <div class="item-inner">
          				              <div class="item-title label w20b fs07">热销</div>
          				              <div class="item-input w80b">
          				                <label class="label-switch">
          				                  <input type="checkbox" name="is_hot" class="input_is_hot">
          				                  <div class="checkbox"></div>
          				                </label>
          				              </div>
          				            </div>
          				          </div>
          				        </li>
          				         <li>
          				          <div class="item-content">
          				           
          				            <div class="item-inner">
          				              <div class="item-title label w20b">推荐</div>
          				              <div class="item-input w80b">
          				                <label class="label-switch">
          				                  <input type="checkbox" name="recommend" class="input_is_recommend">
          				                  <div class="checkbox"></div>
          				                </label>
          				              </div>
          				            </div>
          				          </div>
          				        </li>
                                      <!--  <li>
                                        <div class="item-content">
                                         
                                          <div class="item-inner">
                                            <div class="item-title label w20b">上架</div>
                                            <div class="item-input w80b">
                                              <label class="label-switch">
                                                <input type="checkbox" name="is_up" class="input_is_up">
                                                <div class="checkbox"></div>
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                      </li> -->
          				      </ul>
          				    </div>

          				    <div class="content-block">
          				      <div class="row">
          				        <div class="w50b" style="margin: 10px auto;"><span class="button input_submit button-fill button-success">提交</span></div>
          				      </div>
          				    </div>
                                  </form>
					</div>
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
<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/ueditor.all.js"> </script>

<script type="text/javascript" charset="utf-8" src="/sources/js/ueditor/lang/zh-cn/zh-cn.js"></script>


<script type='text/javascript' data-main="/sources/js/app.js" src='/sources/js/require.js' charset='utf-8'></script>
</html>
