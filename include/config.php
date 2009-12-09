<?php
//ss
if(!defined('INWEB')){Header("Location: ../index.php?id=start");}
define('INCONFIG', True);
require_once('functions.php');
####################      DB CONFIG         ##########################################
$DB = Array(
        "host"        	=> 		"localhost", 	//MySQL Host
        "login"         => 		"root", 	//MySQL User
        "password"      => 		"",		//MySQL Password
	"db"		=> 		"l2jdb",	//L2J DataBase
	"webdb"		=>		"web"		//Webpage DataBase
); 

############################################# DO NOT MODIFY #################################

  $link = mysql_connect($DB['host'], $DB['login'], $DB['password']);
//  if (!$link) die("Couldn't connect to MySQL");
  @mysql_select_db($DB['db'], $link);
//mysql_query("INSERT INTO `".$DB['webdb']."`.`config` VALUES ('CopyRight', '<a href=mailto:antons007@gmail.com>80MXM08</a> © LineageII Fantasy World <br />2009');") OR die(mysql_error());
    $query = mysql_query("SELECT * FROM ".$DB['webdb'].".config");
    while ( $row = mysql_fetch_assoc($query) ) {
	    $Config[$row['config_name']] = $row['config_value'];
    }
//error_reporting(0);
?>