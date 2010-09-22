<?php
if (!defined('IN_BLOCK')) {
    Header("Location: ../index.php");
}
$page='blocks/vote';
$params = null;
$sec=172800; //2 days
if($cache->needUpdate($page, $params, $sec))
{
$content = $tpl->parsetemplate('blocks/vote', NULL, 1);
$cache->updateCache($page, $params, $content);
echo $content;
}
else
{
    echo $cache->getCache($page, $params);
}
?>