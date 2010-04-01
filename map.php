<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['char']) && is_numeric($_GET['char']))
{
	$srv = $mysql->escape(0 + $_GET['server']);
	$char = $mysql->escape(0 + $_GET['char']);
	
	$dbname = getDBName($srv);
	//echo $srv;
	$checkchar = $mysql->query("SELECT `account_name`, `charId`, `onlinemap` FROM `$dbname`.`characters` WHERE `charId` = '$char'");
	if($mysql->num_rows($checkchar))
	{
		$char = $mysql->fetch_array($checkchar);
		if(strtolower($char['account_name'])!=strtolower($_SESSION['account']))
		{
			echo "nav tavs chars";
			die();
		}
		if($char['onlinemap'])
		{
			$mysql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='0' WHERE `charId` = '{$char['charId']}'");
		}
		else
		{
			$mysql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='1' WHERE `charId` = '{$char['charId']}'");
		}
	}
}
header("Location: myacc.php");
?>