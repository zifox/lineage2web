<?php
define('INWEB', True);
chdir('..');
require_once("include/config.php");
//пароль
loggedInOrReturn();
$q=getVar('q');
$server=getVar('server');
$limit=getVar('limit');

if (!empty($q) && !empty($limit) && !empty($server)) {
	$query = '%' . strtr(
		$q,
		' ',
		'%'
	) . '%';
	$db=getDBInfo($server);
	$sql->query("
SELECT charId,char_name,account_name,level
FROM `{$db['DataBase']}`.`characters`
WHERE `char_name` LIKE '$query'
LIMIT 0, $limit ");
$data=$sql->fetch_array();
}

echo json_encode($data);
?>
