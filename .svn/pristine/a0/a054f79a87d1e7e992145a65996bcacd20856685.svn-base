<?php
$da = file_get_contents('http://www.youbicard.com/plus/data/validator.php?method=fB3Yt7hZ0E1nIDRt');
//初始化
$curl = curl_init();
$url = 'http://www.youbicard.com/plus/data/ECardRanks.php?method=exchangeInfo&eid=2';
//设置抓取的url
curl_setopt($curl, CURLOPT_URL, $url);

//设置头文件的信息作为数据流输出
curl_setopt($curl, CURLOPT_HEADER, 1);

//设置获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($curl,CURLOPT_HTTPHEADER,array('Host'=>'www.youbicard.com'));

$data = curl_exec($curl);

//$data = curl_getinfo($curl);
//关闭URL请求
curl_close($curl);
echo '<pre>';
//显示获得的数据
print_r($da);

