<?php
includeLang('myacc');

if (logedin()){
    echo sprintf($Lang['welcome'], $CURUSER['login']);
    echo '<br />';

$timevoted = $CURUSER['voted'];
$now = time();

if ($timevoted <= ($now-60*60*12))
{
    echo "<a href=\"index.php?id=vote\"><font color=\"red\">{$Lang['vote']}</font></a><br />";
}else{
    echo "<font color=\"red\">You can vote again after ". date('H:i:s', $timevoted -($now-60*60*12)-60*60*2) ."<br />";
}
    echo "<a href=\"index.php?id=changepass\">{$Lang['changepass']}</a>";
    
    
}else {echo '<h1>'.$Lang['login'].'</h1>';}
?>