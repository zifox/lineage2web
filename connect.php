<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("How to connect");
?>
<b><h2>
1.  <a title="DOWNLOAD L2.Fantazy PATCH" target="_blank" href="http://l2.pvpland.lv/system.rar">DOWNLOAD PATCH FROM OUR SERVER</a><br /><br />
2.  Run LineageII.exe and do full check<br /><br />
3.  Extract patch into LineAgeII folder<br /><br />
4.  Download our hosts patch - rared version <a href="hosts.rar">Hosts.rar</a><br /><br />
5.1 Extract it to "<font color="red">C:\Windows\System32\Etc\Drivers\</font>"<br />
5.2 Or open "<font color="red">C:\Windows\System32\Etc\Drivers\</font>" and add these lines manualy -<br />
    <font color="red">85.25.76.160 nProtect.lineage2.com<br />
    87.110.204.53 L2authd.lineage2.com</font><br />
5.3 It should look like this - <br />
    <font color="red">127.0.0.1 localhost<br />
    85.25.76.160 nProtect.lineage2.com<br />
    87.110.204.53 L2authd.lineage2.com</font><br /><br />
 
4. Launch game using l2.exe<br /><br />
5. If you get gameguard error then open LineAge2/system and delete folder <font color="red">GameGuard</font> and try to connect now.
</h2>
<?php
foot();
mysql_close($link);
?>