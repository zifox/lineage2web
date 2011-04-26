<?php
define('INWEB', true);
require_once ("include/config.php");
//??????

//loggedInOrReturn();

$skin = val_string($_GET['skin']);
if (is_skin($skin))
{
    if($user->logged())
	   $sql->query("UPDATE accounts SET skin = '$skin' WHERE id = {$_SESSION['account']}");
    else
        setcookie('skin',$skin, 9999999999, '');
}
header('Location: ./');

?>