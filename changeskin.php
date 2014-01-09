<?php
define('INWEB', true);
require_once ('include/config.php');
$skin = valString($_GET['skin']);
if(isSkin($skin))
{
	if($user->logged())
		$sql->query(41, array('account' => $_SESSION['accounts'], 'skin' => $skin));
	else
		setcookie('skin', $skin, 9999999999, '');
}
header('Location: ./');
?>