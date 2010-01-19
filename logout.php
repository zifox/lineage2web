<?php
Define('INWEB', True);
require_once('include/config.php');

if(isset($_SESSION['account'])){
    session_unset();
}
header('Location: index.php');
mysql_close($link);
?>