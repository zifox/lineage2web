<?php
if (!defined('IN_BLOCK')) {
    Header("Location: ../index.php");
}

if($cache->needUpdate(__FILE__))
{
    $content = $tpl->parsetemplate('blocks/vote', NULL, 1);
    $cache->updateCache(__FILE__, $content);
    
    echo $content;
}
else
{
    echo $cache->getCache(__FILE__);
}
?>