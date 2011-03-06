<?php
define('INWEB', True);
require_once('include/config.php');

if($user->logout())
{
    head('Loging out...',1,'index.php',5);
    msg('Success', 'You have been successfully logged out');
}
else
{
    head('Loging out...',1,'index.php',5);
    msg('Error', 'Failed to log out...');
}
foot();
?>