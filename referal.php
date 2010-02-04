<?php
//??????
define('INWEB', True);
require_once("include/config.php");
if(!logedin())
{
    //error('9');
    exit();
}else{
head('Referals');
/*
$query=mysql_query("SELECT `login`, `webpoints` FROM `accounts` WHERE login='".mysql_real_escape_string($_POST['ref'])."'");
                if(mysql_num_rows($query))
                {
                    mysql_query("UPDATE `accounts` SET `webpoints`=`webpoints`+'".$Config['reg_reward']."' WHERE `login`='".mysql_result($query,0,'login')."'");
                }*/
foot();
}
?>