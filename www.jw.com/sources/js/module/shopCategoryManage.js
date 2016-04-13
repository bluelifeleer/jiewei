$(function() {
    'use strict';
        //删除空的栏目
        function delShopCate(catid){
            var url = encodeURI(apiUrl + 'shop/index/delShopCate');
            $.ajax({
                    url: url,
                    async: false,
                    type: 'POST',
                    data: {
                        catid: catid,
                    },
                    headers: {
                        "Token": sso_Token
                    },
                    success: function(result) {
                        var data = $.parseJSON(result);
                        if (data.code == 0) {
                            $.toast('删除成功!');
                            // $.router.loadPage('');
                            window.location.reload();
                        } else {
                            $.toast('删除失败!');
                            return false;
                        }

                    }
            });
        }

        $(document).on('pageInit', '#page-category-manage', function(e, id, page) {
        //显示栏目列表
            var proCount = 0;
            var category = '';
            var url = encodeURI(apiUrl + 'shop/index/getShopCate');
            $.ajax({
                url: url,
                async: false,
                type: 'GET',
                data: {
                    module:'site',
                },
                headers: {
                    "Token": sso_Token
                },
                success: function(result) {
                    var data = $.parseJSON(result);
                    console.log(data);
                    $.each(data, function(catid, cat) {
                        if(cat.parentid == 0){
                            category += '<div class="add_category w100b h50 lh50 borb1 bce6">';
                            category += '<div class="padl20 w100b h40 mart5 flr">';
                            category += '<input type="text" class="add-create-cate bor0 w40b cate-'+catid+'"  data-parentid="0" value="' +cat.catname+ '">';
                            category += '<a href="addSonCate.php?catid='+catid+'" class="p_cate_add c666" data-parentid="0" type="text"><i class="icon iconfont mar0  padd0 padr10 c666">&#xe603;</i></a>';
                            category += '<a href="javascript:void(0);" data-catname="' + cat.catname + '" data-catid="' + catid + '" class="update-but external marr10" data-but-fn="update" ><i class="icon iconfont mar0 marl4 padd0  padr10 c666">&#xe680;</i></a>';
                            category += '<a href="selectCateIcon.php?catid='+catid+'"  class="selectIcon   marr10" data-but-fn="update"><i class="icon  iconfont mar0 marl4 padd0  padr10 c666">&#xe685;</i></a>';
                            if(cat.procounts == 0 && cat.sonids == 0){
                                category += '<a href="javascript:void(0);" data-catname="' + cat.catname + '" data-catid="' + catid + '" class="del-but external marr10" data-but-fn="del-parent"><i class="icon iconfont mar0 marl4 padd0  padr10 c666">&#xe602;</i></a>';
                            }

                            category += '</div>';
                            category += '<div class="clear"></div>';
                            category += '</div>';
                           
                            var parid = cat.arrchildid.split(',');
                            parid.shift();
                            if(parid.length != 0){
                                $.each(parid, function(index, value) {
                                    var catitems = data[value] || {};
                                  
                                    category += '<div data-parentid="0" class="add_category w100b h50 lh50 borb1 bce6">';
                                    category += '<div class="w100b h40 mart5 flr" style="padding-left:40px">';
                                    category += '<input type="text" class="add-create-cate bor0 w40b cate-'+data[value].catid+'"  data-parentid="0" value="' +data[value].catname+ '">';
                                    
                                    category += '<a href="javascript:void(0);" data-catname="' + data[value].catname + '" data-catid="' + data[value].catid + '" class="update-but external marr10" data-but-fn="update"><i class="icon iconfont mar0 marl4 padd0 padr10  c666">&#xe680;</i></a>';
                                    if(data[value].procounts == 0){
                                        category += '<a href="javascript:void(0);" data-catname="' + data[value].catname + '" data-catid="' + data[value].catid + '" class="del-but external marr10" data-but-fn="del-child"><i class="icon iconfont mar0 marl4 padd0  padr10 c666">&#xe602;</i></a>';
                                    }
                                    category += '<a href="selectCateIcon.php?catid='+data[value].catid+'"  class="selectIcon   marr10" data-but-fn="update"><i class="icon  iconfont mar0 marl4 padd0  padr10 c666">&#xe685;</i></a>';
                                   
                                    category += '</div>';
                                    category += '<div class="clear"></div>';
                                    category += '</div>';
                                })
                            }
                            
                        }
                    })

                    $('#cate-list-block').html(category);
                    $('.page-current #pro_number').html('0');
                }
            })
            //编辑栏目
            $(page).on('click','.update-but',function(){
                if($(this).attr('data-but-fn') == 'update'){
                    var catid = $(this).attr('data-catid');
                    var catname = $('.cate-'+catid).val();
                    var url = encodeURI(apiUrl + 'shop/index/updateShopCate');
                    $.confirm('确认保存修改?',
                        function () {
                            $.ajax({
                                url: url,
                                async: false,
                                type: 'GET',
                                data: {
                                    module:'site',
                                    catid: catid,
                                    catname: catname
                                },
                                headers: {
                                    "Token": sso_Token
                                },
                                success:function(result){
                                    var res = $.parseJSON(result);
                                    if(res['code'] == 0){
                                        $.alert('修改成功！');
                                    }else{
                                        $.alert('修改失败！');
                                    }
                                }
                            })
                        },
                        function () {
                          $.alert('修改未保存。');
                        }
                    );
                    // 
                }
            });
            //删除子分类
            $(page).on('click', '.del-but', function() {
                var catid = $(this).attr('data-catid');
                if ($(this).attr('data-but-fn') == 'del-child') {
                    var parent = $(this).parent().parent().parent();
                    $.confirm('确认删除此分类？',
                        function (){
                            delShopCate(catid);
                            parent.remove();
                        },
                        function (){
                            $.alert('取消删除。');
                            return false;
                        }
                    );
                    
                } else {
                    var parent = $(this).parent().parent();
                    $.confirm('确认删除此分类？',
                        function(){
                            delShopCate(catid);
                            parent.remove();
                        },
                        function(){
                            $.alert('取消删除。');
                            return false;
                        }
                    );
                    
                }
            });

        })

        

        //添加分类开始
        $(document).on('pageInit','#shop-category-add',function(e, id, page){
            var count = 1;
            var catid = 1;
            $(page).on('click', '#fenlei', function() {
                    catid += 1;
                    var category = '';
                    category += '<div data-parentid="0" data-catid="' + catid + '" id="category_' + catid + '" class="add_category w100b h50 lh50 borb1 bce6">';
                    category += '<div class="padl20 w100b h40 mart5 flr">';
                    category += '分类：　<input type="text" class="add-create-categories bor0"  data-parentid="0" data-catid="' + catid + '"  placeholder="请在这里填写您的分类">';
                    category += '<a href="#" class="p_cate c666" data-parentid="0"  data-catid="' + catid + '" type="text"><i class="icon iconfont c666">&#xe612;</i></a>';
                    category += '<a href="javascript:void(0);" data-catid="' + catid + '" class="dele-but external marr10" data-but-fn="del-parent"><i class="icon iconfont c666">&#xe621;</i></a>';
                    //category += '<a href="#" class="marr10 del">删除</a>';
                    category += '</div>';
                    category += '<div class="clear"></div>';
                    category += '</div>';
                    $('#classify').append(category);
            })
           
            //添加栏目
            $(page).on('click','#confirm-but',function(){
                //var catid = $('.add-create-categories').data('catid');
                var catname = $('.add-create-categories').val();
                if (!catname) {
                    $.toast('请填写您的栏目名称!');
                    return false;
                }
                var url = encodeURI(apiUrl + 'shop/index/addShopCate');
                $.ajax({
                    url: url,
                    async: false,
                    type: 'POST',
                    data: {
                        module: 'site',
                        catid: catid,
                        catname: catname,
                        child: 0,
                        arrparentid: 0,
                        parentid: 0,
                    },
                    headers: {
                        "Token": sso_Token
                    },
                    success: function(result) {
                        var data = $.parseJSON(result);
                        if (data.code == 0) {
                            $.toast('添加成功!');
                            $.router.loadPage('shop_category_manage.php');
                        } else {
                            $.toast('添加失败!');
                            return false;
                        }

                    }
                });
            })
        });
        //添加栏目结束
        
        
        
})