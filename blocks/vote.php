<?php
if (!defined('IN_BLOCK')) {
    header("Location: ../index.php");
    exit();
}
$cachefile='blocks/vote';
if($cache->needUpdate($cachefile))
{
    $content = $tpl->parsetemplate('blocks/vote', NULL, 1);
    $cache->updateCache($cachefile, $content);
    
    global $content;
}
else
{
    $content = $cache->getCache($cachefile);
    global $content;
}
?>