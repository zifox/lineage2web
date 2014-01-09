<?php
if(!defined('IN_BLOCK'))
{
	header("Location: ../index.php");
	exit();
}

$par['lang'] = getLangName();
$par['use_cookie'] = isset($_COOKIE['lang']) ? 'true' : 'false';
$cachefile = 'bMenu';
$params = implode(';', $par);
if($cache->needUpdate($cachefile, $params))
{
	$parse = getLang();
	$parse['home'] = menuButton(getLang('home'));
	$parse['reg'] = menuButton(getLang('reg'));
	$parse['connect'] = menuButton(getLang('connect'));
	$parse['market'] = menuButton(getLang('market'));
	$parse['forum'] = menuButton(getLang('forum'));
	$parse['statistic'] = menuButton(getLang('statistic'));
	$parse['rules'] = menuButton(getLang('rules'));
	$parse['donate'] = menuButton(getLang('donate'));
	$parse['skin'] = skinSelector(selectSkin(), true);
	$parse['langpath'] = $langPath;
	#TODO: build it dynamicly
	$parse['lv_border'] = $_COOKIE['lang'] == 1 ? '1' : '0';
	$parse['en_border'] = $_COOKIE['lang'] == 2 ? '1' : '0';
	$parse['ru_border'] = $_COOKIE['lang'] == 3 ? '1' : '0';
	$parse['img_link'] = 'skins/' . selectSkin();
	$content = $tpl->parseTemplate('blocks/menu', $parse, true);
	$cache->updateCache($cachefile, $content, $params);

	global $content;
}
else
{
	$content = $cache->getCache($cachefile, $params);
	global $content;
}
?>