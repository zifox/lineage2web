<?php
//пароль
if(!defined('INWEB')){Header("Location: ../index.php");}
$timeparts = explode(" ",microtime());
$starttime = $timeparts[1].substr($timeparts[0],1);
session_start();
if(isset($_SESSION['last_act'])){
    $_SESSION['last_act']=time();
}
define('INCONFIG', true);
require_once('functions.php');
$DB = Array(
	"host"		=>	"localhost",//MySQL Host
	"login"		=>	"root", 	//MySQL User
	"password"	=>	"",	//MySQL Password
	"db"		=>	"l2j",		//L2J DataBase
	"webdb"		=>	"web"		//Webpage DataBase
); 

$link = @mysql_connect($DB['host'], $DB['login'], $DB['password']);
@mysql_select_db($DB['db'], $link) OR die(mysql_error());
$query = mysql_query("SELECT * FROM `".$DB['webdb']."`.`config`");
while ( $row = mysql_fetch_assoc($query) ) {
	$Config[$row['config_name']] = stripslashes($row['config_value']);
}
//error_reporting(0);
?>