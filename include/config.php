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
    "password"  => "agagag",      //MySQL Password
    "database"  => "l2j"        //L2J Main (account)DataBase
);
$webdb = "web";                 //Webpage DataBase

$static = array(
0 => 'http://static1.sytes.net',
1 => 'http://static2.sytes.net',
);
//do
//{
//    $staticurl = $static[rand(0, count($static))];
//}
//while($staticurl == NULL);
$staticurl = $static[0];
require_once ('class.mysql.php');
require_once ('class.user.php');
require_once ('class.tplParser.php');
require_once ('queries.php');
$mysql = new MySQL($DB);

$query = $mysql->query($q['0'], $webdb);
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
$tpl = new tplParser($Config['DSkin']);
?>