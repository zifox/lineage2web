<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Vote");
includeLang('vote');
if (!$user->logged())
{
    msg('Error', 'You need to login', 'error'); 
}

if ($user->logged())
{
$action = $_GET['action'];

$timevoted = $_SESSION['vote_time'];
$now = time();

if ($timevoted >= ($now-60*60*12))
{
msg($Lang['thank_you'], $Lang['vote_tommorow']);
}
if ($action == "vote" && $timevoted < ($now-60*60*12))
{
if(!$_SESSION['vote_rnd']<time() && !$_SESSION['vote_rnd']>=time()-60*5) die();
$_SESSION['vote_time']=$now;
$_SESSION['webpoints']+=$Config['vote_reward'];
$mysql->query("UPDATE `accounts` SET `voted`='$now', `webpoints`=`webpoints`+'".$Config['vote_reward']."' WHERE `login` = '{$_SESSION['account']}'");
$mysql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', 'Voting', 'Success', 'WebPoint Count=\"{$Config['vote_reward']}\"');");
msg($Lang['thank_you'], $Lang['thank_for_voting']);

}elseif($action == "vote" && $timevoted >= ($now-60*60*12))
{
    $mysql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', 'Voting', 'Error', 'Link ByPass');");
    error('8');
}
}
$parse = $Lang;
$parse['vote_reward'] = $Config['vote_reward'];
if($user->logged())
{
    $_SESSION['vote_rnd']=time();
    if($timevoted < ($now-60*60*12)) $parse['button'] = button($Lang['get_reward'], 'go', 1, true, 'go');
}
$tpl->parsetemplate('vote', $parse);
foot();
?>