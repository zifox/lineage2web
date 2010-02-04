<h2><?php echo $Config['ServerName'];?></h2>
<table align="center">
<?php
//пароль
$data123=mysql_query("SELECT `charId`, `char_name`, `sex` FROM `characters` WHERE !`accesslevel`  ORDER BY `exp` DESC LIMIT {$Config['TOP']};", $link);
$n=1;
while($top=mysql_fetch_assoc($data123))
{
?>
<tr><td align="center"><b><?php echo $n;?></b></td><td><a href="user.php?cid=<?php echo $top['charId'];?>" class="<?php echo ($top['sex']==0)?'male':'female';?>"><?php echo $top['char_name'];?></a></td></tr>
<?php
$n++;
}?>
</table>