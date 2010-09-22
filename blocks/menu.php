<?php
//пароль
if (!defined('IN_BLOCK')) {
    Header("Location: ../index.php");
    die();
}
$page='blocks/menu';
$par['lang']=getLang();
$par['use_cookie']=isset($_COOKIE['lang'])?'true':'false';
$sec=600;
$params = implode(';', $par);
if($cache->needUpdate($page, $params, $sec))
{
$parse=$Lang;
$parse['Home']=menubutton($Lang['Home']);
$parse['Reg']=menubutton($Lang['Reg']);
$parse['Connect']=menubutton($Lang['connect']);
$parse['forum']=menubutton($Lang['forum']);
$parse['statistic']=menubutton($Lang['statistic']);
$parse['Rules']=menubutton($Lang['Rules']);
//$parse['Donate']=menubutton($Lang['Donate']); #NOT YET FINISHED
$parse['langpath'] = $langpath;
$parse['lv_border'] = $_COOKIE['lang'] == 1 ? '1':'0';
$parse['en_border'] = $_COOKIE['lang'] == 2 ? '1':'0';
$parse['ru_border'] = $_COOKIE['lang'] == 3 ? '1':'0';
$parse['img_link'] =  'skins/'.$skin;
$content = $tpl->parsetemplate('blocks/menu', $parse, 1);
$cache->updateCache($page, $params, $content);
echo $content;
}
else
{
    echo $cache->getCache($page, $params);
}
?>