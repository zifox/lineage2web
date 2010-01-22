<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("UserInfo");
includeLang('user');
if ($_GET['cid'] && is_numeric($_GET['cid']))
{
    if(is_int(0+$_GET['cid'])){
    $id=0+$_GET['cid'];}else{header('Location: index.php');}

    $sql=mysql_query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`, `pvpkills`, `pkkills`, `race`, `characters`.`classid`, `base_class`, `title`, `rec_have`, `accesslevel`, `online`, `onlinetime`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, `clan_id`, `clan_name` FROM `characters` INNER JOIN `char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `characters`.`charId` = '$id'");

    if(mysql_num_rows($sql)!= 0){
    $char=mysql_fetch_assoc($sql);
    if ($char['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
    echo "<h1 style=\"color: $color; font-weight: bold;\">{$char['char_name']}</h1>";
    ?>
    <img src="img/face/<?php echo $char['race'];?>_<?php echo $char['sex'];?>.gif"  height="25" alt="" /><?
    $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	if ($char['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$char['clan_id']}\">{$char['clan_name']}</a>";}else{$clan_link = "No Clan";}
	if ($char['online']) {$online=$Lang['online'];
    $onoff='on'; } 
	else {$online=$Lang['offline']; 
    $onoff='off';} ?>
    <table border="1">
    <tr><td><?php echo $Lang['level'];?>:</td><td><?php echo $char['level'];?></td></tr>
    <tr><td class="maxCp"><?php echo $Lang['cp'];?>:</td><td class="maxCp"><?php echo $char['maxCp'];?></td></tr>
    <tr><td class="maxHp"><?php echo $Lang['hp'];?>:</td><td class="maxHp"><?php echo $char['maxHp'];?></td></tr>
    <tr><td class="maxMp"><?php echo $Lang['mp'];?>:</td><td class="maxMp"><?php echo $char['maxMp'];?></td></tr>
    <tr><td><?php echo $Lang['class'];?>:</td><td><?php echo $char['ClassName'];?></td></tr>
    <tr><td><?php echo $Lang['clan'];?>:</td><td><?php echo $clan_link;?></td></tr>
    <tr><td><?php echo $Lang['pvp'];?>/<font color="red"><?php echo $Lang['pk'];?></font>:</td><td><b><?php echo $char['pvpkills'];?></b>/<b><font color="red"><?php echo $char['pkkills'];?></font></b></td></tr>
     <tr><td><?php echo $Lang['online_time'];?>:</td><td><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></td></tr>
    <tr><td><?php echo $online;?>:</td><td><img src="img/status/<?php echo $onoff;?>line.png" title="<?php echo $online;?>" alt="<?php echo $online;?>" /></td></tr></table>
    <?

$sql2=mysql_query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`, `pvpkills`, `pkkills`, `clanid`, `race`, `characters`.`classid`, `base_class`, `title`, `rec_have`, `accesslevel`, `online`, `onlinetime`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, clan_id, clan_name FROM `characters` LEFT OUTER JOIN `char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE `characters`.`charId` != '{$char['charId']}' AND `account_name` = '{$char['account_name']}' ORDER by characters.level ASC");
if (mysql_num_rows($sql2)){
	?>
    <br /><br /><h1><?php echo $Lang['otherchars'];?></h1><table border="1">
    <tr><td><?php echo $Lang['face'];?></td><td><center><?php echo $Lang['name'];?></center></td><td><?php echo $Lang['level'];?></td><td><center><?php echo $Lang['class'];?></center></td><td class="maxCp" align="center"><?php echo $Lang['cp'];?></td><td class="maxHp" align="center"><?php echo $Lang['hp'];?></td><td class="maxMp" align="center"><?php echo $Lang['mp'];?></td><td><center><?php echo $Lang['clan'];?></center></td><td><?php echo $Lang['pvp_pk'];?></td><td><center><?php echo $Lang['online_time'];?></center></td><td><?php echo $Lang['status'];?></td></tr>
    <?php
    while ($otherchar=mysql_fetch_assoc($sql2))
    {
$onlinetimeH=round(($otherchar['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($otherchar['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	if ($otherchar['clan_id']) {$clan_link = "<a href=claninfo.php?clan=\"{$otherchar['clan_id']}\">{$otherchar['clan_name']}</a>";}else{$clan_link = $Lang['no_clan'];}
	if ($otherchar['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }

	if ($otherchar['online']) {$online='<img src="img/online.png" alt="'.$Lang['online'].'" />';} 
	else {$online='<img src="img/status/offline.png" alt="'.$Lang['offline'].'"/>';} 
	?>
<tr><td><img src="/img/face/<?php echo $otherchar['race'];?>_<?php echo $otherchar['sex'];?>.gif\" alt="" /></td><td><a href="user.php?cid=<?php echo $otherchar['charId'];?>"><font color="<?php echo $color;?>"><?php echo $otherchar['char_name'];?></font></a></td><td align="center"><?php echo $otherchar['level'];?></td><td align="center"><?php echo $otherchar['ClassName'];?></td><td class="maxCp" align="center"><?php echo $otherchar['maxCp'];?></td><td class="maxHp" align="center"><?php echo $otherchar['maxHp'];?></td><td class="maxMp" align="center"><?php echo $otherchar['maxMp'];?></td><td align="center"><?php echo $clan_link;?></td><td align="center"><b><?php echo $otherchar['pvpkills'];?></b>/<b><font color="red"><?php echo $otherchar['pkkills'];?></font></b></td><td align="center"><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></td><td><?php echo $online;?></td></tr>
 <?php       }
        
            echo '</table>';
            }
    }else{echo msg('Error',$Lang['not_found'], 'error', false);}
}else{echo msg('Error',$Lang['not_found'], 'error', false);}
foot();
?>