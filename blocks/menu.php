<table align="center">
<tr><td align="center"><a href="index.php"><img src="./img/menu/<?php echo $langpath;?>/home.png" border="0" width="120" title="<?php echo $Lang['Home'];?>" alt="<?php echo $Lang['Home'];?>"/></a></td></tr>
<tr><td align="center"><a href="reg.php"><img src="./img/menu/<?php echo $langpath;?>/reg.png" border="0" width="120" title="<?php echo $Lang['Reg'];?>" alt="<?php echo $Lang['Reg'];?>"/></a></td></tr>

<tr><td align="center"><a href="connect.php"><img src="./img/menu/<?php echo $langpath;?>/connect.png" border="0" width="120" title="<?php echo $Lang['connect'];?>" alt="<?php echo $Lang['connect'];?>"/></a></td></tr>

<tr><td align="center"><a href="stat.php"><img src="./img/menu/<?php echo $langpath;?>/stat.png" border="0" width="120" title="<?php echo $Lang['statistic'];?>" alt="<?php echo $Lang['statistic'];?>"/></a></td></tr>

<tr><td align="center"><a href="rules.php"><img src="./img/menu/<?php echo $langpath;?>/rules.png" border="0" width="120" title="<?php echo $Lang['Rules'];?>" alt="<?php echo $Lang['Rules'];?>"/></a></td></tr>
</table>
<?php 
//Пожалуйста, введите своё имя и пароль
/*
<tr><td align="center"><a href="index.php?id=donate"><img src="./img/menu/<?php echo $langpath;?>/donate.png" border="0" width="120" title="<?php echo $Lang['Donate'];?>" alt="<?php echo $Lang['Donate'];?>"/></a></td></tr>
*/

If($langpath=='lv'){
$borderlv=1;
$borderen=0;
$borderru=0;
}elseif($langpath=='en')
{
$borderlv=0;
$borderen=1;
$borderru=0;
}elseif($langpath=='ru')
{
$borderlv=0;
$borderen=0;
$borderru=1;
}else{
$borderlv=0;
$borderen=0;
$borderru=0;
}
?>

<a href="server.php?lang=1"><img src="img/lv.png" border="<?php echo $borderlv;?>" title="Latviski" alt="Latviski"/></a>
<a href="server.php?lang=2"><img src="img/en.png" border="<?php echo $borderen;?>" title="English" alt="English"/></a>
<a href="server.php?lang=3"><img src="img/ru.png" border="<?php echo $borderru;?>" title="по-русски" alt="по-русски"/></a>
