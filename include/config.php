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
require_once ('queries.php');
require_once ('class.mysql.php');
require_once ('class.user.php');
require_once ('class.tplParser.php');
require_once ('class.cache.php');
require_once ('include/functions.php');
$sql = new MySQL($DB);
$query = $sql->query($q[0], array("db" => $webdb));
while ($row = $sql->fetch_array($query)) {
    $CONFIG[$row['type']][$row['name']] = stripslashes($row['value']);
}
$webdb=getConfig('settings','webdb','l2web');
$user = new user();

if (getConfig('features','use_cracktracker','0')){
    //require_once ('include/cracktracker.php');
}


if (getConfig('features','use_bancontrol','0')){
    require_once ('include/bancontrol.php');
}

$cache = new Cache(getConfig('features','cache_enabled','1'));
if (!getConfig('debug','web','0')) {
    error_reporting(0);
}
//$tpl = new tplParser(getConfig('settings','DTHEME','l2f'));
$tpl = new tplParser('l2f');
?>