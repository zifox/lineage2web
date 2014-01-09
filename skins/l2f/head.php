<?php
if(!defined('INSKIN'))
{
	header("Location: ../../index.php");
	die();
}

//$expires = 60*60*24*14;
$expires = 0;

includeLang('skin');
$parse = getLang();
if($url != '')
	$parse['refresh'] = '<meta http-equiv="refresh" content="' . $time . ' URL=' . $url . '" />';
$parse['metad'] = getConfig('head', 'MetaD', 'Fantasy World x50');
$parse['metak'] = getConfig('head', 'MetaK', 'Lineage, freya, high, five, mid-rate, pvp');
$parse['copy'] = '2009 - ' . date('Y') . ' © Lineage II Fantasy World. All rights reserved.';
$parse['gsv'] = getConfig('head', 'google_site_ver', 'OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM');
$parse['title'] = $title;
$parse['page_tracker'] = getConfig('head', 'page_tracker', 'UA-11986252-1');
$parse['lang_confirm_vit'] = sprintf(getLang('confirm_vit'), getConfig('voting', 'vitality_cost', '1'));
$parse['title_desc'] = 'LineAge II Fantasy World High Five';
$parse['bg_nr'] = isset($_GET['bg']) ? $_GET['bg'] : date('w');
$parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;

$parse['skinurl'] = 'skins/l2f';
$skinurl = 'skins/l2f';

if($head)
{
	$parse1 = $parse;
	$parse1['blocks_left'] = includeBlock('login', (!$user->logged()) ? getLang('login') : $_SESSION['account'], true, true);
	$parse1['blocks_left'] .= includeBlock('menu', getLang('menu'), true, true);
	//$parse['blocks_left'].=includeBlock('donate', 'Donate',true,true);
	//$parse['blocks_left'].=includeBlock('vote', $Lang['vote'],true,true);
	if(getConfig('news', 'show_announcement', '1'))
		$parse1['announcements'] = '<h1>' . getConfig('news', 'announcement', 'Welcome to Fantasy World Freya x50') . '</h1>';
	if($user->logged())
	{
		$sql->query("SELECT Count(*) AS new FROM l2web.messages WHERE receiver='{$_SESSION['account']}' AND unread='yes'");
		$msg = $sql->fetchArray();
		$_SESSION['new'] = $msg['new'];
	}
	if($user->logged() && $_SESSION['new'] > 0)
		$parse1['messages'] = msg('', '<a href="message.php?viewmailbox&amp;box=1">' . sprintf(getLang('unread_msg'), $_SESSION['new'], ($_SESSION['new'] == '1' ? '' : $Lang['s'])) . '</a>', 'success', true);
	$parse['head'] = $tpl->parseTemplate('skin/head_head', $parse1, true);
}

header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=" . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
//header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
header('Content-Type: application/xhtml+xml');

echo $tpl->parseTemplate('skin/head', $parse, true);
?>