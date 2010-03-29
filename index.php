<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Home");
includeLang('index');
$parse = $Lang;
$gsquery = $mysql->query("SELECT * FROM `{$DB['webdb']}`.`gameservers` INNER JOIN `{$DB['webdb']}`.`gameserver_info` USING (`ID`);");
$parse['gsrows'] = "";
while($gsrow = $mysql->fetch_array($gsquery))
{
	$parse['gsrows'] .= $tpl->parsetemplate('index_gsrow', $gsrow, 1);
}
$parse['Events'] = $Config['Events'];
$parse['Features'] = $Config['Features'];
$tpl->parsetemplate('index', $parse);

foot();
?>