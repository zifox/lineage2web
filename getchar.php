<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['server']) && is_numeric($_GET['server']) && $user->logged())
{
	//$srvid=0+$_GET['server'];
	$srvdb = getDBName($_GET['server']);
	$charquery=$mysql->query("SELECT `charId`, `char_name` FROM `$srvdb`.`characters` WHERE `account_name`='{$_SESSION['account']}'");
	if($mysql->num_rows($charquery))
	{
		while($option = $mysql->fetch_array($charquery))
		{
			echo "obj.options[obj.options.length] = new Option('{$option['char_name']}','{$option['charId']}');\n";
		}
	}
}
else
{
	die();
}
?>