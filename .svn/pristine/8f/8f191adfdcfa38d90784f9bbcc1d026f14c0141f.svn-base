

//图片上传及表单及列表自动
function webuploader(pickId,key,root, thumbH,thumbW,isthumb){
    
    var pickName = pickId;
    var pickId = pickId+'-'+key;
    var fileList = pickName+'-List-'+(key|0);
    var thumbH = thumbH || 100;
    var thumbW = thumbW || 100;

    var fileNum = 1;
    var root = root || '';
    if(root != ''){
       var root = '?root='+root+'&isthumb='+isthumb;
    }
        var $ = jQuery,
        $list = $('#'+fileList),

        // 优化retina, 在retina下这个值是2
        //ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = thumbW,// * ratio,
        thumbnailHeight = thumbH,// * ratio,
        // Web Uploader实例
        uploader;
        // 初始化Web Uploader
        uploader = WebUploader.create({
            // 自动上传。
            auto: true,
            //分片上传
            chunked:true,
            //上传数量限制
            fileNumLimit:fileNum,
            // swf文件路径
            swf:'Uploader.swf',
            // 文件接收服务端。
            server: 'http://res.zj3w.net/upload.php'+root,
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#'+pickId,
            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
      uploader.reset();    
      // 当有文件添加进来的时候
     uploader.on( 'fileQueued', function( file ) {

        $( '#'+pickId+' > .webuploader-pick').css('display',"none");
        var $li = $(
                '<div id="' + file.id + '" class="file-item">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
            $img = $li.find('img');
        $list.html( $li );
        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {

            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');
        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
        }
        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,response) {
        $( '#'+file.id ).addClass('upload-state-done');
        var $li = $('<input type="hidden" name="'+pickName+'[]" value="'+response.thumb+'">');
        $list.append( $li );
        uploader.reset();
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');
        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }
        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });

};
