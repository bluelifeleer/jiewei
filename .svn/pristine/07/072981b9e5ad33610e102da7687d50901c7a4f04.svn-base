<?php
class upLoadFileService extends Service {
  private $files = 'file';
  private $upload;
  private $image;
  private $newFileName;
  private $path;
  private $isThubm = array();

  /**
   * 上传文件
   */
  public function upload($newFileName,$path,$isThubm,$thubmSize = array()){
    //获取upload对象
    $this->upload = $this->getLibrary('upload');
    //获取image对象
    $this->image = $this->getLibrary('image');


    $this->newFileName = isset($newFileName) && $newFileName != '' ? $newFileName : md5(uniqid()) ;
    $this->files = 'file';
    $this->path = isset($path) && $path != '' ? $path : 'upload/images/' ;

    //上传图片
    $newFile = $this->upload->upload($this->files,$this->newFileName,$this->path);

    //判断是否需要缩略图
    if($isThubm && !empty($thubmSize)){
      $this->image->createFolder($this->path);
      for($i=0; $i < count($thubmSize); $i++){
        array_push($this->isThubm,$this->image->make_thumb($newFile['source'],$this->newFileName . $thubmSize[$i][0] .'_'. $thubmSize[$i][1] . '.'.$newFile['ext'],$thubmSize[$i][0],$thubmSize[$i][1],false));
      }

      //返回上传后的图片名
      if(!empty($this->isThubm) && count($this->isThubm)>0){
        return $newFile['source'];
      }

    }


  }


}
