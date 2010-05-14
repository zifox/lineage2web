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
			die("nav tavs chars");
		}
		if($char['onlinemap']=='true')
		{
			$mysql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='false' WHERE `charId` = '{$char['charId']}'");
            echo "obj.value=false;\n";
		}
		else
		{
			$mysql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='true' WHERE `charId` = '{$char['charId']}'");
            echo "obj.value=true;\n";
		}
	}
}
//header("Location: myacc.php");
?>