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

    $sql=mysql_query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`, `pvpkills`, `pkkills`, `race`, `characters`.`classid`, `base_class`, `title`, `rec_have`, `accesslevel`, `online`, `onlinetime`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, clan_id, clan_name
FROM `characters` INNER JOIN `char_templates`
ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE `characters`.`charId` = '$id'");

    if(mysql_num_rows($sql)!= 0){
    echo '<table border=1>';

    $char=mysql_fetch_assoc($sql);
    $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
    
	if ($char['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$char['clan_id']}\">{$char['clan_name']}</a>";}else{$clan_link = "No Clan";}
	if ($char['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	if ($char['online']) {$online=$Lang['online'];
    $onoff='on'; } 
	else {$online=$Lang['offline']; 
    $onoff='off';} ?>
    <img src="img/face/<?php echo $char['race'];?>_<?php echo $char['sex'];?>.gif"  height="25"/>
    <?php
    echo "<h1><font color=\"$color\"><b>{$char['char_name']}</b></font></h1>";
    ?>
    <tr><td><?php echo $Lang['level'];?>:</td><td><?php echo $char['level'];?></td></tr>
    <tr><td><?php echo $Lang['cp'];?>:</td><td><?php echo '<font color="orange">'.$char['maxCp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['hp'];?>:</td><td><?php echo '<font color="red">'.$char['maxHp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['mp'];?>:</td><td><?php echo '<font color="#0099FF">'.$char['maxMp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['class'];?>:</td><td><?php echo $char['ClassName'];?></td></tr>
    <tr><td><?php echo $Lang['clan'];?>:</td><td><?php echo $clan_link;?></td></tr>
    <tr><td><?php echo $Lang['pvp'];?>/<font color="red"><?php echo $Lang['pk'];?></font>:</td><td><b><?php echo $char['pvpkills'];?></b>/<b><font color="red"><?php echo $char['pkkills'];?></font></b></td></tr>
     <tr><td><?php echo $Lang['online_time'];?>:</td><td><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></td></tr>
    <tr><td><?php echo $online;?>:</td><td><img src="img/status/<?php echo $onoff;?>line.png" title="<?php echo $online;?>" alt="<?php echo $online;?>" /></td></tr></table>
    <?

$sql2=mysql_query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`, `pvpkills`, `pkkills`, `clanid`, `race`, `characters`.`classid`, `base_class`, `title`, `rec_have`, `accesslevel`, `online`, `onlinetime`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, clan_id, clan_name FROM `characters` LEFT OUTER JOIN `char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE `characters`.`charId` != '{$char['charId']}' AND `account_name` = '{$char['account_name']}' ORDER by characters.level ASC");
if (mysql_num_rows($sql2)){
    echo "<br /><br /><h1><center>{$Lang['otherchars']}</center></h1><table border=1>";
            includeLang('table');
    echo '<tr><td>'.$Lang['face'].'</td><td><center>'.$Lang['nick'].'</center></td><td>'.$Lang['level'].'</td><td><center>'.$Lang['proffesion'].'</center></td><td><center>'.$Lang['cp'].'</center></td><td><center>'.$Lang['hp'].'</center></td><td><center>'.$Lang['mp'].'</center></td><td><center>'.$Lang['clan'].'</center></td><td>'.$Lang['pvp_pk'].'</td><td><center>'.$Lang['time_in_game'].'</center></td><td>'.$Lang['status'].'</td></tr>';
    while ($otherchar=mysql_fetch_assoc($sql2))
    {
$onlinetimeH=round(($otherchar['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($otherchar['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	if ($otherchar['clan_id']) {$clan_link = "<a href=claninfo.php?clan=\"{$otherchar['clan_id']}\">{$otherchar['clan_name']}</a>";}else{$clan_link = "No Clan";}
	if ($otherchar['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }

	if ($otherchar['online']) {$online='<img src="img/online.png" />';} 
	else {$online='<img src="img/status/offline.png" />';} 
echo "<tr><td><img src=\"./img/face/".$otherchar['race']."_".$otherchar['sex'].".gif\"></td><td><a href=user.php?cid={$otherchar['charId']}><font color=\"$color\">$otherchar[char_name]</font></a></td><td><center> $otherchar[level]</center></td><td><center>$otherchar[ClassName]</center></td><td><center>$otherchar[maxCp]</center></td><td><center>$otherchar[maxHp]</center></td><td><center>$otherchar[maxMp]</center></td><td><center>$clan_link</center></td><td><center><b>$otherchar[pvpkills]</b>/<b><font color=red>$otherchar[pkkills]</font></b></center></td><td><center>$onlinetimeH {$Lang['hours']} $onlinetimeM {$Lang['min']}.</center></td><td>$online</td>";
        }
        
            echo '</table>';
            }
    }else{echo msg('Error',$Lang['not_found'], 'error', false);}
}else{echo msg('Error',$Lang['not_found'], 'error', false);}
foot();
mysql_close($link);
?>