<?php
if (!defined('IN_BLOCK')) {
    Header("Location: ../index.php");
}
$tpl->parsetemplate('blocks/vote', NULL);
?>