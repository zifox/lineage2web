<?php
//пароль
if (!defined('IN_BLOCK')) {
    header("Location: ../index.php");
    exit();
}

$par['lang']=getLang();
$par['use_cookie']=isset($_COOKIE['lang'])?'true':'false';
$cachefile='blocks/menu';
$params = implode(';', $par);
if($cache->needUpdate($cachefile, $params))
{
    $parse=$Lang;
    $parse['home']=menubutton($Lang['home']);
    $parse['reg']=menubutton($Lang['reg']);
    $parse['connect']=menubutton($Lang['connect']);
    $parse['market']=menubutton($Lang['market']);
    $parse['forum']=menubutton($Lang['forum']);
    $parse['statistic']=menubutton($Lang['statistic']);
    $parse['rules']=menubutton($Lang['rules']);
    $parse['donate']=menubutton($Lang['donate']); #NOT YET FINISHED
    $parse['skin']=skin_selector(select_skin(),true); 
    $parse['langpath'] = $langpath;
    $parse['lv_border'] = $_COOKIE['lang'] == 1 ? '1':'0';
    $parse['en_border'] = $_COOKIE['lang'] == 2 ? '1':'0';
    $parse['ru_border'] = $_COOKIE['lang'] == 3 ? '1':'0';
    $parse['img_link'] =  'skins/'.$skin;
    $content = $tpl->parsetemplate('blocks/menu', $parse, 1);
    $cache->updateCache($cachefile, $content, $params);
    
    global $content;
}
else
{
    $content = $cache->getCache($cachefile, $params);
    global $content;
}
?>