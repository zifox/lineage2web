<?php
function RandomGenerator($length=5){
$chars="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
if(!is_int($length)||$length<1){
$length=5;
}
$rndstr='';
$maxvalue=strlen($chars)-1;
for($i=0;$i<$length;$i++){
$rndstr.=substr($chars,rand(0,$maxvalue),1);
}
return $rndstr;
}

session_start();
$random=RandomGenerator(rand(4,6));
$_SESSION['captcha']=$random;
$width=strlen($random);
$imagecreate = imagecreate($width*10+2, 18);
$background = imagecolorallocate($imagecreate, 0, 0, 0);
$textcolor = imagecolorallocate($imagecreate, 255, 255, 255);
imagestring($imagecreate, 5, 3, 1, $random, $textcolor);
header("Content-type: image/png");
$image= imagepng($imagecreate);
?>