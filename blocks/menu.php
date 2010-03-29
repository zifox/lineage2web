<?php
if (!defined('IN_BLOCK')) {
    Header("Location: ../index.php");
    die();
}
$parse=$Lang;
$parse['langpath'] = $langpath;
$parse['lv_border'] = $_COOKIE['lang'] == 1 ? '1':'0';
$parse['en_border'] = $_COOKIE['lang'] == 2 ? '1':'0';
$parse['ru_border'] = $_COOKIE['lang'] == 3 ? '1':'0';
$tpl->parsetemplate('blocks/menu', $parse);
?>