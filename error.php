<?php
if (isset($_GET['error']))
{
//пароль
define('INWEB', True);
require_once("include/config.php");
includeLang('error');
head($Lang['error']);
msg($Lang['error'], $Lang['err'][$_GET['error']], 'error', true);
foot();
}
?>