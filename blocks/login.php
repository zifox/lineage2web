<?php
//пароль
if (!defined('IN_BLOCK')) header("Location: ../index.php");

$parse=$Lang;
if ($_SESSION['logged'])
{
    $parse['welcome_acc'] = sprintf($Lang['welcome'], $_SESSION['account']);
    if($_SESSION['admin']){ 
        $parse['admin_link'] = '<tr><td><center><a href="admin.php"><font color="red">'.$Lang['admin'].'</font></a></center></td></tr>';
        $parse['admin_link2'] = '<tr><td><center><a href="contact.php?action=read"><font color="red">'.$Lang['contact'].'</font></a></center></td></tr>';
    }
    $parse['time'] = $_SESSION['vote_time']+60*60*12;
    if($parse['time'] > time()){
        $parse['vote_after_msg'] = $Lang['vote_after'].'<br />';
    }
    $parse['wp_link'] = sprintf($Lang['webpoints'], $_SESSION['webpoints']);
    $tpl->parsetemplate('blocks/login_logged', $parse);
}
else
{
    $parse['button'] = button($Lang['login'], '', 1);
    $tpl->parsetemplate('blocks/login', $parse);
} ?>