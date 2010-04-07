<?php
define('INWEB', true);
require_once ("include/config.php");
//пароль
head("Home");
includeLang('index');
$parse = $Lang;
$gsquery = $mysql->query($q[3], $webdb);
$parse['gsrows'] = "";
while ($gsrow = $mysql->fetch_array($gsquery))
{
	$parse['gsrows'] .= $tpl->parsetemplate('index_gsrow', $gsrow, 1);
}
$parse['Events'] = $Config['Events'];
$parse['Features'] = $Config['Features'];
$tpl->parsetemplate('index', $parse);

foot();
?>