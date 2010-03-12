<?php
Define('INWEB', True);
require_once('include/config.php');
$user->logout();
$mysql->close();
header('Location: index.php');
?>