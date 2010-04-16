<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("How to connect");
$parse['static'] = $staticurl;
$tpl->parsetemplate('connect', $parse);
foot();
?>