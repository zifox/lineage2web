<?php
if(!defined('INWEB'))
{
	header("Location: ../index.php");
	die();
}

$timeParts = explode(" ", microtime());
$startTime = $timeParts[1] . substr($timeParts[0], 1);
session_start();
define('INCONFIG', true);

####################      DATABASE CONFIG     ####################
$DB = array
(
	"host" => "localhost",	//MySQL Host
	"user" => "root",		//MySQL User
	"password" => "",		//MySQL Password
	"database" => "l2jdb"	//L2J Main (account)DataBase
);
$webdb = "l2web"; //Webpage DataBase
####################   DATABASE CONFIG END    ####################

require_once ('queries.php');
require_once ('class.tplParser.php');

$tpl = new TplParser('l2f');
require_once ('class.mysql.php');
require_once ('class.user.php');

require_once ('class.cache.php');
require_once ('functions.php');
$sql = new MySQL($DB);

$query = $sql->query($q[0], array("webdb" => $webdb));
while ($row = $sql->fetchArray($query))
{
	$CONFIG[$row['type']][$row['name']] = stripslashes($row['value']);
}
//$tpl = new TplParser(getConfig('settings','dtheme','l2f'));
$user = new User();

if(getConfig('features', 'cracktracker', '0'))
{
	require_once ('include/cracktracker.php');
}

if(getConfig('features', 'bancontrol', '0'))
{
	require_once ('include/bancontrol.php');
}

//$cache = new Cache(getConfig('cache','enabled','1'));
$cache = new Cache(false);
if(!getConfig('debug', 'web', '0'))
{
	error_reporting(0);
}

?>