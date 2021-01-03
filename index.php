<?php
header("Content-type: image/JPEG");
use UAParser\Parser;
require_once 'vendor/autoload.php';
$im = imagecreatefromjpeg("https://p.pstatp.com/origin/13767000190085f3094e3"); 
$ip = $_SERVER["REMOTE_ADDR"];
if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
}
//$ua = $_SERVER['HTTP_USER_AGENT'];
$get = $_GET["s"];
$get = base64_decode(str_replace(" ","+",$get));
$weekarray = array("日","一","二","三","四","五","六"); 
//os
$parser = Parser::create();
$result = $parser->parse($ua);
$os = $result->os->toString(); // Mac OS X
//$browser = $result->device->family.'-'.$result->ua->family;// Safari 6.0.2
//ua
//$data = json_decode(curl_get('https://api.hanada.info/ua/'), true);
//$ua = $data['useragent']; 
//地址、温度
$data = json_decode(curl_get('https://api.hanada.info/ip/?ip='.$ip), true);
$country = $data['location']['country']; 
$region = $data['location']['province']; 
$isp = $data['location']['isp'];
//定义颜色
$black = ImageColorAllocate($im, 0,0,0);//定义黑色的值
$red = ImageColorAllocate($im, 0,150,238);//字体颜色
$font = 'msyh.ttf';//加载字体
//输出
imagettftext($im, 16, 0, 10, 40, $red, $font,'Address '.$country.' '.$region.' '.$ip);
imagettftext($im, 16, 0, 10, 72, $red, $font, 'Date '.date('Y年n月j日').' 星期'.$weekarray[date("w")]);//当前时间添加到图片
imagettftext($im, 16, 0, 10, 104, $red, $font,'OS '.$os.' Author:@BlueSkyXN');
imagettftext($im, 16, 0, 10, 140, $red, $font,'Mail:BlueSky@000714.xyz');
imagettftext($im, 16, 0, 10, 175, $red, $font,'Blog:blog.000714.xyz'.'|HomePage:000714.xyz');
imagettftext($im, 13, 0, 10, 200, $black, $font,$get); 
ImageGif($im);
ImageDestroy($im);


function curl_get($url, array $params = array(), $timeout = 6){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}
?>


