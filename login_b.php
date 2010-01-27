<?php
//пароль
header("Content-type: image/png");
$text=$_GET['text'];
if($_GET['style']=="normal"){
$button_img=imagecreatefrompng("./img/buttons/normal.png");
}elseif($_GET['style']=="hover"){
$button_img=imagecreatefrompng("./img/buttons/hover.png");
}elseif($_GET['style']=="press"){
$button_img=imagecreatefrompng("./img/buttons/pressed.png");
}
$izq_img=imagecreate(9,26);
$cen_img=imagecreate(1,26);
$der_img=imagecreate(9,26);
$button_complete=imagecreate((9+(strlen($text)*7)+9),26);
$color  = imagecolorallocate($button_complete,210,210,210);
//$lt_grey  = imagecolorallocate($der_img,210,210,210); 
 
imagecopy($izq_img,$button_img,0,0,0,0,9,26);
imagecopy($cen_img,$button_img,0,0,10,0,1,26);
imagecopy($der_img,$button_img,0,0,85,0,9,26);
imagecopy($button_complete,$izq_img,0,0,0,0,9,26);
$i=0;
while($i<=(strlen($text)*7)){
imagecopy($button_complete,$cen_img,(9+$i),0,0,0,1,26);
$i++;
}
imagecopy($button_complete,$der_img,(9+(strlen($text)*7)),0,0,0,9,26);
imagettftext($button_complete,(9),0,ceil(((9+(strlen($text)*7)+9)/2)-(strlen($text)*3.5)),17,$lt_grey,"./img/buttons/verdana.ttf",$text); 
imagepng($button_complete);
imagedestroy($button_complete);
imagedestroy($izq_img);
imagedestroy($cen_img);
imagedestroy($der_img);
imagedestroy($button_img);
?>