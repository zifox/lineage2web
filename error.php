<?php
if ($_GET['error'])
{
//пароль
define('INWEB', True);
require_once("include/config.php");
head($Lang['error']);
    includeLang('error');
    msg($Lang['error'], $Lang['err'][$_GET['error']], 'error', true);
foot();
mysql_close($link);
die();
}
?>