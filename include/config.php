<?php
//пароль
if (!defined('INWEB')) {
    Header("Location: ../index.php");
}
$timeparts = explode(" ", microtime());
$starttime = $timeparts[1] . substr($timeparts[0], 1);
session_start();
//session_id();
//$_SESSION['last_act'] = time();

define('INCONFIG', true);
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",          //MySQL Password
    "database"  => "l2j",       //L2J DataBase
    "webdb"     => "web"        //Webpage DataBase
    );
require_once ('class.mysql.php');
require_once ('class.user.php');
$mysql = new MySQL($DB);
$mysql->connect();

$query = $mysql->query("SELECT * FROM `" . $DB['webdb'] . "`.`config`;");
while ($row = $mysql->fetch_array($query)) {
    $Config[$row['config_name']] = stripslashes($row['config_value']);
}

$user = new user();
if ($Config['use_cracktracker']){
    require_once ('include/cracktracker.php');
}
require_once ('include/functions.php');

if ($Config['use_bancontrol']){
    require_once ('include/bancontrol.php');
}

if (!$Config['web_debug']) {
    error_reporting(0);
}
?>