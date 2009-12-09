<?php
//Пожалуйста, введите своё имя и пароль
If($_GET['lang'] OR $_GET['skin']){	

If(is_numeric($_GET['lang'])){
$langid = $_GET['lang'];
	setcookie('lang', $langid, 0, '/', '.pvpland.lv', 0, 0);
	Header("Location: index.php?id=start");
}

If(is_numeric($_GET['skin'])){
$skin = $_GET['skin'];
	setcookie('skin', $skin, 0, '/', '.pvpland.lv', 0, 0);
	//Header("Location: index.php?id=start");
	echo 'Skin '.$_GET['skin'].' set';
}

}else{die();}
?>