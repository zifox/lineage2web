<?php
define('INWEB', true);
require_once ("include/config.php");

header("Content-type: image/png");
header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
$text = $_GET['text'];
$skin = selectSkin();
if($_GET['style'] == 'normal')
{
	$button_img = imagecreatefrompng('skins/' . $skin . '/img/normal.png');
}
elseif ($_GET['style'] == 'hover')
{
	$button_img = imagecreatefrompng('skins/' . $skin . '/img/hover.png');
}
elseif ($_GET['style'] == 'press')
{
	$button_img = imagecreatefrompng('skins/' . $skin . '/img/pressed.png');
}
$izq_img = imagecreate(9, 26);
$cen_img = imagecreate(1, 26);
$der_img = imagecreate(9, 26);
$button_complete = imagecreate((9 + (strlen($text) * 7) + 9), 26);
$color = imagecolorallocate($button_complete, 210, 210, 210);
//$color  = imagecolorallocatealpha($button_complete,210,210,210,127);
//$lt_grey  = imagecolorallocate($der_img,210,210,210);

imagecopy($izq_img, $button_img, 0, 0, 0, 0, 9, 26);
imagecopy($cen_img, $button_img, 0, 0, 10, 0, 1, 26);
imagecopy($der_img, $button_img, 0, 0, 85, 0, 9, 26);
imagecopy($button_complete, $izq_img, 0, 0, 0, 0, 9, 26);
$i = 0;
while ($i <= (strlen($text) * 7))
{
	imagecopy($button_complete, $cen_img, (9 + $i), 0, 0, 0, 1, 26);
	$i++;
}
imagecopy($button_complete, $der_img, (9 + (strlen($text) * 7)), 0, 0, 0, 9, 26);
imagettftext($button_complete, (9), 0, ceil(((9 + (strlen($text) * 7) + 9) / 2) - (strlen($text) * 3.5)), 17, $color, 'skins/' . $skin . '/fonts/verdana.ttf', $text);
imagepng($button_complete);
imagedestroy($button_complete);
imagedestroy($izq_img);
imagedestroy($cen_img);
imagedestroy($der_img);
imagedestroy($button_img);
?>