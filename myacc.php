<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("My Account");
includeLang('myacc');

if (logedin()){
    echo sprintf($Lang['welcome'], $CURUSER['login']);
    echo '<br />';

$timevoted = $CURUSER['voted'];
$now = time();

if ($timevoted <= ($now-60*60*12))
{
    echo "<a href=\"vote.php\"><font color=\"red\">{$Lang['vote']}</font></a><br />";
}else{
    echo "<font color=\"red\">You can vote again after ". date('H:i:s', $timevoted -($now-60*60*12)-60*60*2) ."<br />";
}
    echo "<a href=\"changepass.php\">{$Lang['changepass']}</a>";
    
    
}else {echo '<h1>'.$Lang['login'].'</h1>';}
foot();
mysql_close($link);
?>