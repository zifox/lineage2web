<table align="center">
<tr><td align="center"><a href="index.php?id=start"><img src="./img/menu/<?php echo $langpath;?>/home.png" border="0" width="120" title="<?php echo $Lang['Home'];?>"/></a></td></tr>
<tr><td align="center"><a href="index.php?id=reg"><img src="./img/menu/<?php echo $langpath;?>/reg.png" border="0" width="120" title="<?php echo $Lang['Reg'];?>"/></a></td></tr>

<tr><td align="center"><a href="index.php?id=start_lk"><img src="./img/menu/<?php echo $langpath;?>/connect.png" border="0" width="120" title="<?php echo $Lang['connect'];?>"/></a></td></tr>

<tr><td align="center"><a href="index.php?id=stat"><img src="./img/menu/<?php echo $langpath;?>/stat.png" border="0" width="120" title="<?php echo $Lang['statistic'];?>"/></a></td></tr>

<tr><td align="center"><a href="index.php?id=library"><img src="./img/menu/<?php echo $langpath;?>/rules.png" border="0" width="120" title="<?php echo $Lang['Rules'];?>"/></a></td></tr>
<?php 
//Пожалуйста, введите своё имя и пароль
/*
<tr><td align="center"><a href="index.php?id=donate"><img src="./img/menu/<?php echo $langpath;?>/donate.png" border="0" width="120" title="<?php echo $Lang['Donate'];?>"/></a></td></tr>
*/?>

</table>

<br />
<?php 
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
<a href="server.php?lang=1" title="Latviski"><img src="img/lv.png" border="<?php echo $borderlv;?>" /></a>
<a href="server.php?lang=2" title="English"><img src="img/en.png" border="<?php echo $borderen;?>" /></a>
<a href="server.php?lang=3" title="по-русски"><img src="img/ru.png" border="<?php echo $borderru;?>" /></a>