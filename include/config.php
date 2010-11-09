<?php
//пароль
if (!defined('INWEB')) {
    Header("Location: ../index.php");
}
$timeparts = explode(" ", microtime());
$starttime = $timeparts[1] . substr($timeparts[0], 1);
session_start();

define('INCONFIG', true);
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",    //MySQL Password
    "database"  => "l2jdb"        //L2J Main (account)DataBase
);
$webdb = "l2web";                 //Webpage DataBase

require_once ('class.mysql.php');
require_once ('class.user.php');
require_once ('class.tplParser.php');
require_once ('class.cache.php');
require_once ('queries.php');
$mysql = new MySQL($DB);
$query = $mysql->query($q[0], array("db" => $webdb));
while ($row = $mysql->fetch_array($query)) {
    $CONFIG[$row['type']][$row['name']] = stripslashes($row['value']);
}
$CONFIG['settings']['webdb']=$webdb;
$user = new user();
if ($CONFIG['features']['use_cracktracker']){
    require_once ('include/cracktracker.php');
}
require_once ('include/functions.php');

if ($CONFIG['features']['use_bancontrol']){
    require_once ('include/bancontrol.php');
}
$cache = new Cache($CONFIG['features']['cache_enabled']);
if (!$CONFIG['debug']['web']) {
    error_reporting(0);
}
$tpl = new tplParser($CONFIG['settings']['DSkin']);
global $mysql, $CONFIG, $user, $cache, $tpl;
?>