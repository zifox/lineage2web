<?php
//пароль
if (!defined('IN_BLOCK'))
{
    header("Location: ../index.php");
    exit();
}

$parse = $Lang;
if ($user->logged())
{
	$parse['welcome_acc'] = sprintf($Lang['welcome'], $_SESSION['account']);
	if ($_SESSION['admin'])
	{
		$parse['admin_link'] = '<tr><td><center><a href="admin.php"><font color="red">' .
			$Lang['admin'] . '</font></a></center></td></tr>';
	}
	$parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;
	if ($parse['time'] > time())
	{
		$parse['vote_after_msg'] = $Lang['vote_after'] . '<br />';
	}
    $sql->query("SELECT Count(*) AS sent FROM l2web.messages WHERE sender='{$_SESSION['account']}'");
    $msg=$sql->fetch_array();
    $parse['sent']=$msg['sent'];
    $sql->query("SELECT Count(*) AS rec FROM l2web.messages WHERE receiver='{$_SESSION['account']}'");
    $msg=$sql->fetch_array();
    $parse['rec']=$msg['rec'];
    $sql->query("SELECT Count(*) AS new FROM l2web.messages WHERE receiver='{$_SESSION['account']}' AND unread='yes'");
    $msg=$sql->fetch_array();
    $parse['unread']=$msg['new'];
    $parse['new']=($msg['new']>0)?"new":"";
    $parse['in_mes']=sprintf($Lang['in_mes'], $parse['rec'], $parse['unread']);
    $parse['out_mes']=sprintf($Lang['out_mes'], $parse['sent']);
	$parse['wp_link'] = sprintf($Lang['webpoints'], $_SESSION['webpoints']);
	$tpl->parsetemplate( 'blocks/login_logged', $parse );
}
else
{
    $parse['static'] = $staticurl;
	$parse['button'] = button( $Lang['login'], '', 1 );
	$tpl->parsetemplate( 'blocks/login', $parse );
}

?>