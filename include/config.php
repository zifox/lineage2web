<?php
//пароль
if(!defined('INWEB')){Header("Location: ../index.php?id=start");}
define('INCONFIG', True);
require_once('functions.php');
####################      DB CONFIG         ##########################################
$DB = Array(
        "host"        	=> 		"localhost",//MySQL Host
        "login"         => 		"root", 	//MySQL User
        "password"      => 		"832620i",	//MySQL Password
        "db"		    => 		"l2",		//L2J DataBase
        "webdb"		    =>		"web"		//Webpage DataBase
); 

############################################# DO NOT MODIFY #################################

  $link = mysql_connect($DB['host'], $DB['login'], $DB['password']);
  @mysql_select_db($DB['db'], $link) OR die('Cannot connect to DataBase!!!');
    $query = mysql_query("SELECT * FROM ".$DB['webdb'].".config");
    while ( $row = mysql_fetch_assoc($query) ) {
	    $Config[$row['config_name']] = stripslashes($row['config_value']);
    }
//error_reporting(0);
?>