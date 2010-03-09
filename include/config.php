<?php
//пароль
if (!defined('INWEB')) {
    Header("Location: ../index.php");
}
$timeparts = explode(" ", microtime());
$starttime = $timeparts[1] . substr($timeparts[0], 1);
session_start();
if (isset($_SESSION['last_act'])) {
    $_SESSION['last_act'] = time();
}
define('INCONFIG', true);
define ("DEBUG_MODE", 1);
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",          //MySQL Password
    "database"  => "l2j",       //L2J DataBase
    "webdb"     => "web"        //Webpage DataBase
    );

require_once ('class.mysql.php');

$mysql = new MySQL($DB);
$mysql->connect();
$query = $mysql->query("SELECT * FROM `" . $DB['webdb'] . "`.`config`;");
while ($row = $mysql->fetch_array($query)) 
    $Config[$row['config_name']] = stripslashes($row['config_value']);
if ($Config['use_cracktracker'])
    require_once ('include/cracktracker.php');
require_once ('include/functions.php');
require_once ('include/bancontrol.php');
if (!$Config['debug'])
    error_reporting(0);
?>