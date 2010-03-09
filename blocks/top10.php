<h2><?php echo $Config['ServerName'];?></h2>
<table align="center" width="100%">
<?php
//пароль

$topchar=$mysql->query("SELECT `charId`, `char_name`, `sex` FROM `characters` WHERE `accesslevel`='0'  ORDER BY `exp` DESC LIMIT {$Config['TOP']};");
$n=1;
while($top=$mysql->fetch_array())
{
?>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="center" width="25%"><b><?php echo $n;?></b></td><td><a href="user.php?cid=<?php echo $top['charId'];?>" class="<?php echo ($top['sex']==0)?'male':'female';?>"><?php echo $top['char_name'];?></a></td></tr>
<?php
$n++;
}?>
</table>