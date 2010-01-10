<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("How to connect");
?>
<b>
<ol class="left">
	<li>If you have LineAgeII client (game) then go to step 2<br /> otherwise download <b>Gracia Epilogue</b> client from:
    <ul><li><a href="http://www.gamershell.com/download_53076.shtml">GamersHell.com</a></li>
    <li><a href="http://www.fileplanet.com/promotions/lineage2/gracia-epilogue/">FilePlanet.com</a></li>
    <li><a href="files/LineAgeII.rar">LineAgeII.exe ONLY</a></li>
    <li><a href="files/torrent.torrent">LineAgeII.exe + Patch.torrent Using P2P (BitTorrent)</a></li>
    </ul></li>
    <li>Run LineAgeII.exe and do full check</li>
    <li>Download our patch <a href="files/hosts.exe">Hosts.exe</a></li>
    <li>Instal it in "<font color="red">Lineage II folder</font>"</li>
    <li>If you get gameguard error then open LineAge2/system and delete folder <font color="red">GameGuard</font> and try to connect now</li>

</ol>
<?php
foot();
mysql_close($link);
?>