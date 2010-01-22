<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("My Characters");
includeLang('user');
if (logedin())
{
    $sql=mysql_query("SELECT `account_name`, `charId`, `char_name`, `level`,
`maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`,
`pvpkills`, `pkkills`, `race`, `online`, `onlinetime`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, `clan_id`, `clan_name` FROM `characters` INNER JOIN `char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `account_name` = '{$_SESSION['account']}'");
    if (mysql_num_rows($sql) != 0)
    {
    	?>
        <table border="1">
        <tr><td><?php echo $Lang['face'];?></td><td><center><?php echo $Lang['name'];?></center></td><td><?php echo $Lang['level'];?></td><td><center><?php echo $Lang['class'];?></center></td><td><center><?php echo $Lang['cp'];?></center></td><td><center><?php echo $Lang['hp'];?></center></td><td><center><?php echo $Lang['mp'];?></center></td><td><center><?php echo $Lang['clan'];?></center></td><td><?php echo $Lang['pvp_pk'];?></td><td><center><?php echo $Lang['online_time'];?></center></td><td><?php echo $Lang['online'];?></td><td><?php echo $Lang['unstuck'];?></td></tr>
<?php
    while($char=mysql_fetch_assoc($sql))
    {
        $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
        if ($char['online']) {$online='<img src="img/status/online.png" />';} 
	else {$online='<img src="img/status/offline.png" />';} 
        if ($char['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$char['clan_id']}\">{$char['clan_name']}</a>";}else{$clan_link = "No Clan";}
 ?>
<tr><td><img src="/img/face/<?php echo $char['race'].'_'.$char['sex'];?>.gif" /></td><td><a href="user.php?cid=<?php echo $char['charId'];?>"><font color="<?php echo $color;?>"><?php echo $char['char_name'];?></font></a></td><td><center><?php echo $char['level'];?></center></td><td><center><?php echo $char['ClassName'];?></center></td><td><center><?php echo $char['maxCp'];?></center></td><td><center><?php echo $char['maxHp'];?></center></td><td><center><?php echo $char['maxMp'];?></center></td><td><center><?php echo $clan_link;?></center></td><td><center><b><?php echo $char['pvpkills'];?><font color="red"><?php echo $char['pkkills'];?></font></b></center></td><td><center><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></center></td><td><?php echo $online;?></td><td><a href="unstuck.php?cid=<?php echo $char['charId'];?>"><?php echo $Lang['unstuck'];?></a></td></tr>
<?php
    }
    echo "</table>";
    } else {echo '<h1>'.$Lang['no_characters'].'</h1>';}
} else {echo '<h1>'.$Lang['login'].'</h1>';}
foot();
?>