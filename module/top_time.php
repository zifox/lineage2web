<?php
include("module/stat-menu.php");

$data=mysql_query("SELECT * FROM characters WHERE accesslevel<50 ORDER BY onlinetime DESC LIMIT $top") or die('Error (DB info).');


echo '<br><center><b>..:: TOP Activity ::..</b></center><br><hr>';
include("module/table.php");
?>