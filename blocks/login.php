<?php
if(!defined('IN_BLOCK'))
{
	header("Location: ../index.php");
	exit();
}

$parse = getLang();
if($user->logged())
{
	$parse['welcome_acc'] = sprintf(getLang('welcome'), $_SESSION['account']);
	if($_SESSION['admin'])
	{
		$parse['admin_link'] = '<tr><td><center><a href="admin.php"><font color="red">' . getLang('admin') . '</font></a></center></td></tr>';
	}
	$parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;
	if($parse['time'] > time())
	{
		$parse['vote_after_msg'] = getLang('vote_after') . '<br />';
	}
	$parse['unread'] = $_SESSION['new'];
	$sql->query(39, array('webdb' => $webdb, 'sender' => $_SESSION['account']));
	$msg = $sql->fetchArray();
	$parse['sent'] = $msg['sent'];
	$sql->query(40, array('webdb' => $webdb, 'sender' => $_SESSION['account']));
	$msg = $sql->fetchArray();
	$parse['rec'] = $msg['rec'];
	$parse['new'] = ($new > 0) ? "new" : "";
	$parse['in_mes'] = sprintf(getLang('in_mes'), $parse['rec'], $parse['unread']);
	$parse['out_mes'] = sprintf(getLang('out_mes'), $parse['sent']);
	$parse['wp_link'] = sprintf(getLang('webpoints'), $_SESSION['webpoints']);
	$content = $tpl->parseTemplate('blocks/login_logged', $parse, true);
	global $content;
}
else
{
	$parse['static'] = $staticurl;
	$parse['button'] = button(getLang('login'), '', true);
	$content = $tpl->parseTemplate('blocks/login', $parse, true);
	global $content;
}
?>