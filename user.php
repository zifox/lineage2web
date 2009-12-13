<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("UserInfo");
if ($_GET['cid'])
{
    $id=0+$_GET['cid'];
    includeLang('user');
    
    $sql=mysql_query("SELECT `characters`.`account_name`, `characters`.`charId`, `characters`.`char_name`, `characters`.`level`,
`characters`.`maxHp`, `characters`.`maxCp`, `characters`.`maxMp`, `characters`.`sex`, `characters`.`karma`, `characters`.`fame`,
`characters`.`pvpkills`, `characters`.`pkkills`, `characters`.`clanid`, `characters`.`race`, `characters`.`classid`, `characters`.`base_class`, `characters`.`title`, `characters`.`rec_have`, `characters`.`accesslevel`, `characters`.`online`, `characters`.`onlinetime`, `characters`.`lastAccess`, `characters`.`nobless`, `characters`.`vitality_points`, `char_templates`.`ClassName`
FROM `characters` , `char_templates`
WHERE `characters`.`classid` = `char_templates`.`ClassId` AND `characters`.`charId` = '".mysql_real_escape_string($id)."'");

    if(mysql_num_rows($sql)!= 0){
    echo '<table border=1>';
    
    while ($char=mysql_fetch_assoc($sql))
    {
    $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	$clan=mysql_fetch_assoc(mysql_query("SELECT `clan_name` FROM `clan_data` WHERE `clan_id` = '$char[clanid]'"));
    
	if ($clan['clan_name']=='') { $clan['clan_name']="No Clan"; }
	if ($char['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	if ($char['online']) {$online='<font color=green>'.$Lang['online'].'</font>';
    $onoff='on'; } 
	else {$online='<font color=red>'.$Lang['offline'].'</font>'; 
    $onoff='off';} ?>
    <img src="module/face/<?php echo $char['race'];?>_<?php echo $char['sex'];?>.gif"  height="25"/>
    <?php
    echo "<h1><font color=\"$color\"><b>{$char['char_name']}</b></font></h1>";
    ?>
    <tr><td><?php echo $Lang['level'];?>:</td><td><?php echo $char['level'];?></td></tr>
    <tr><td><?php echo $Lang['cp'];?>:</td><td><?php echo '<font color="orange">'.$char['maxCp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['hp'];?>:</td><td><?php echo '<font color="red">'.$char['maxHp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['mp'];?>:</td><td><?php echo '<font color="blue">'.$char['maxMp'].'</font>';?></td></tr>
    <tr><td><?php echo $Lang['class'];?>:</td><td><?php echo $char['ClassName'];?></td></tr>
    <tr><td><?php echo $Lang['clan'];?>:</td><td><?php echo $clan['clan_name'];?></td></tr>
    <tr><td><?php echo $Lang['pvp'];?>/<font color="red"><?php echo $Lang['pk'];?></font>:</td><td><b><?php echo $char['pvpkills'];?></b>/<b><font color="red"><?php echo $char['pkkills'];?></font></b></td></tr>
     <tr><td><?php echo $Lang['online_time'];?>:</td><td><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></td></tr>
    <tr><td><?php echo $online;?>:</td><td><img src="img/<?php echo $onoff;?>line.png" title="<?php echo $online;?>" alt="<?php echo $online;?>" /></td></tr></table>
    <?

$sql2=mysql_query("SELECT `characters`.`account_name`, `characters`.`charId`, `characters`.`char_name`, `characters`.`level`,
`characters`.`maxHp`, `characters`.`maxCp`, `characters`.`maxMp`, `characters`.`sex`, `characters`.`karma`, `characters`.`fame`,
`characters`.`pvpkills`, `characters`.`pkkills`, `characters`.`clanid`, `characters`.`race`, `characters`.`classid`, `characters`.`base_class`, `characters`.`title`, `characters`.`rec_have`, `characters`.`accesslevel`, `characters`.`online`, `characters`.`onlinetime`, `characters`.`lastAccess`, `characters`.`nobless`, `characters`.`vitality_points`, `char_templates`.`ClassName`
FROM `characters` , `char_templates`
WHERE `characters`.`classid` = `char_templates`.`ClassId` AND `characters`.`charId` != '{$char['charId']}' AND `account_name` = '{$char['account_name']}'");
if (mysql_num_rows($sql2) != 0){
    echo "<br /><br /><h1><center>{$Lang['otherchars']}</center></h1><table border=1>";
            includeLang('table');
    echo '<tr><td>'.$Lang['face'].'</td><td><center>'.$Lang['nick'].'</center></td><td>'.$Lang['level'].'</td><td><center>'.$Lang['proffesion'].'</center></td><td><center>'.$Lang['cp'].'</center></td><td><center>'.$Lang['hp'].'</center></td><td><center>'.$Lang['mp'].'</center></td><td><center>'.$Lang['clan'].'</center></td><td>'.$Lang['pvp_pk'].'</td><td><center>'.$Lang['time_in_game'].'</center></td><td>'.$Lang['status'].'</td></tr>';
    while ($otherchar=mysql_fetch_assoc($sql2))
    {
$onlinetimeH=round(($otherchar['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($otherchar['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	$clan2=mysql_fetch_assoc(mysql_query("select clan_name from clan_data where clan_id=$otherchar[clanid]"));
	if ($clan2['clan_name']=='') { $clan2['clan_name']="No Clan"; }
	if ($otherchar['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }

	if ($otherchar['online']) {$online='<img src="img/online.png" />';} 
	else {$online='<img src="img/offline.png" />';} 
echo "<tr><td><img src=\"./module/face/".$otherchar['race']."_".$otherchar['sex'].".gif\"></td><td><a href=index.php?id=user&cid={$otherchar['charId']}><font color=\"$color\">$otherchar[char_name]</font></a></td><td><center> $otherchar[level]</center></td><td><center>$otherchar[ClassName]</center></td><td><center>$otherchar[maxCp]</center></td><td><center>$otherchar[maxHp]</center></td><td><center>$otherchar[maxMp]</center></td><td><center><a href=index.php?id=stat&stat=clantop>$clan2[clan_name]</a></center></td><td><center><b>$otherchar[pvpkills]</b>/<b><font color=red>$otherchar[pkkills]</font></b></center></td><td><center>$onlinetimeH {$Lang['hours']} $onlinetimeM {$Lang['min']}.</center></td><td>$online</td>";
        }
        
            echo '</table>';
            }
    }
}else{echo $Lang['not_found'];}
}
foot();
mysql_close($link);
?>