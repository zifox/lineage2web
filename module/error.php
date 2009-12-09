<?php
if ($_GET['error'])
{
    includeLang('error');
    msg($Lang['error'], $Lang['err'][$_GET['error']], 'error', true);
}
?>