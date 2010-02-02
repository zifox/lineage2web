<table width="100%" align="center">
<tr><td align="center" width="100%"><a href="index.php"><img src="./img/menu/<?php echo $langpath;?>/home.png" border="0" width="150" title="<?php echo $Lang['Home'];?>" alt="<?php echo $Lang['Home'];?>" /></a></td></tr>
<tr><td align="center"><a href="reg.php"><img src="./img/menu/<?php echo $langpath;?>/reg.png" border="0" width="150" title="<?php echo $Lang['Reg'];?>" alt="<?php echo $Lang['Reg'];?>"/></a></td></tr>

<tr><td align="center"><a href="connect.php"><img src="./img/menu/<?php echo $langpath;?>/connect.png" border="0" width="150" title="<?php echo $Lang['connect'];?>" alt="<?php echo $Lang['connect'];?>"/></a></td></tr>

<tr><td align="center"><a href="/forum/" target="_blank"><img src="./img/menu/<?php echo $langpath;?>/forum.png" border="0" width="150" title="<?php echo $Lang['forum'];?>" alt="<?php echo $Lang['forum'];?>"/></a></td></tr>

<tr><td align="center"><a href="stat.php"><img src="./img/menu/<?php echo $langpath;?>/stat.png" border="0" width="150" title="<?php echo $Lang['statistic'];?>" alt="<?php echo $Lang['statistic'];?>"/></a></td></tr>

<tr><td align="center"><a href="rules.php"><img src="./img/menu/<?php echo $langpath;?>/rules.png" border="0" width="150" title="<?php echo $Lang['Rules'];?>" alt="<?php echo $Lang['Rules'];?>"/></a></td></tr>
</table>
<?php 
//пароль
/*
<tr><td align="center"><a href="index.php?id=donate"><img src="./img/menu/<?php echo $langpath;?>/donate.png" border="0" width="120" title="<?php echo $Lang['Donate'];?>" alt="<?php echo $Lang['Donate'];?>"/></a></td></tr>
*/

?><div id="lang2">
<a href="server.php?lang=1"><img src="img/lang/lv.png" border="<?php echo ($_COOKIE['lang']==1)? '1':'';?>" title="Latviski" alt="Latviski"/></a>
<a href="server.php?lang=2"><img src="img/lang/en.png" border="<?php echo ($_COOKIE['lang']==2)? '1':'';?>" title="English" alt="English"/></a>
<a href="server.php?lang=3"><img src="img/lang/ru.png" border="<?php echo ($_COOKIE['lang']==3)? '1':'';?>" title="по-русски" alt="по-русски"/></a>
</div>
<?php
/*
<br />Skin: <form name="skin" action="server.php" method="post">
<select name="skin" onchange="submit();">
<option <?php echo ($_COOKIE['skin']=='l2')? 'selected="" ': '';?>value="l2">Default</option>
<option <?php echo ($_COOKIE['skin']=='l2i')? 'selected="" ': '';?>value="l2i">New</option>
</select></form>
*/
?>