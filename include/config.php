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
    "database"  => "l2j"        //L2J Main (account)DataBase
);
$webdb = "l2web";                 //Webpage DataBase

require_once ('class.mysql.php');
require_once ('class.user.php');
require_once ('class.tplParser.php');
require_once ('queries.php');
$mysql = new MySQL($DB);

$query = $mysql->query($q[0], array("db" => $webdb));
while ($row = $mysql->fetch_array($query)) {
    $Config[$row['name']] = stripslashes($row['value']);
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
//$tpl = new tplParser($Config['DSkin']);
$tpl = new tplParser('l2f');
?>