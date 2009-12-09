<?php
define('INWEB', True);
require_once("include/config.php");
//пароль

if (isset($_GET['id']) || isset($_POST['id'])) {
$id = trim(isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
if (preg_match("/[^a-zA-Z0-9_]/", $id)) {
Header("Location: index.php?id=start");
exit;
	}
} else {
	$id = "start";
}

if ($_POST['account'] && $_POST['password'])
{
    $login = mysql_fetch_array(mysql_query("SELECT * FROM accounts WHERE `login` = '" . mysql_real_escape_string($_POST['account'])."' AND `password`='".encodePassword($_POST['password'])."'"));

		if ($login) {

				if (isset($_POST["rememberme"])) {
					$rememberme=1;

				} else {
					$rememberme=0;
				}
			logincookie(mysql_real_escape_string($_POST['account']), md5(encodePassword(($_POST['password']))), $rememberme);

                header('Location:'.$Config['url'].'/index.php');
        }  else { error('1'); }
}


if($_COOKIE['skin']){
$skin = mysql_real_escape_string(isset($_COOKIE['skin']));
}
else
{
	$skin = $Config['DSkin'];
	}
require_once('skins/'.$skin.'/'.$skin.'.php');

mysql_close($link);
?>