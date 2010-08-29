<?php
define('INWEB', True);
require_once("include/config.php");
//пароль

includeLang('user');
if ($_GET['cid'] && is_numeric($_GET['cid']))
{
    if(is_int(0+$_GET['cid'])){
    $id=0+$_GET['cid'];}else{header('Location: index.php'); die();}

    $srv = $mysql->escape(0 + $_GET['server']);
    if($srv == null || !is_int($srv) || $srv == ''){//$srv=$Config['DDB'];
    }
    $dbname = getDBName($srv);
    //die($dbname);
    $sql=$mysql->query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `pvpkills`, `pkkills`, `race`, `characters`.`classid`, `base_class`, `online`, `ClassName`, `clan_id`, `clan_name` FROM `$dbname`.`characters` INNER JOIN `$dbname`.`char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `$dbname`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `characters`.`charId` = '$id'");

    if($mysql->num_rows($sql)!= 0){
    $char=$mysql->fetch_array($sql);
    head("User {$char['char_name']} Info");
    if ($char['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
    echo "<h1 style=\"color: $color; font-weight: bold;\">{$char['char_name']}</h1>";
    ?><table border="0"><tr><td>
    <img src="img/face/<?php echo $char['race'];?>_<?php echo $char['sex'];?>.png" alt="" /></td><td><?php
    $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	if ($char['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$char['clan_id']}&amp;server=$srv\">{$char['clan_name']}</a>";}else{$clan_link = "No Clan";}
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
    <tr><td><?php echo $online;?>:</td><td><img src="img/status/<?php echo $onoff;?>line.png" title="<?php echo $online;?>" alt="<?php echo $online;?>" /></td></tr></table></td><td>
    <table>
    <?php
    $skill_list = $mysql->query("SELECT * FROM `$dbname`.`character_skills` WHERE `charId`='$id' AND `class_index`='0'");
    $i=0;
    while($skill=$mysql->fetch_array($skill_list))
    {
        echo ($i==0)? '<tr>':'';
        $skill_id=($skill[skill_id]<1000)? '0'.$skill[skill_id]:$skill[skill_id];
        echo '<td><img src="img/skills/skill'.$skill_id .'.png" /></td>';
        if($i==4)
        {
            echo '</tr>';
            $i=0;
        }
        else
        {
            $i++;
        }
    }
    ?>
    </table>
    </td></tr></table>
    <h1><?php echo $Lang['otherchars'];?></h1>
    <?php
    $dbq = $mysql->query("SELECT `ID`, `Name`, `DataBase` FROM `$webdb`.`gameservers` WHERE `active` = 'true'");
    while($dbs = $mysql->fetch_array($dbq))
    {
    	$dbn = $dbs['DataBase'];
        
$sql2=$mysql->query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `pvpkills`, `pkkills`, `clanid`, `race`, `characters`.`classid`, `base_class`, `online`, `ClassName`, clan_id, clan_name FROM `$dbn`.`characters` LEFT OUTER JOIN `$dbn`.`char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `$dbn`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `characters`.`charId` != '{$char['charId']}' AND `account_name` = '{$char['account_name']}' ORDER by `characters`.`level` ASC");
if ($mysql->num_rows($sql2)){
	?>
    <hr/><h1><?php echo $dbs['Name'];?></h1><br /><table border="1">
    <tr><td><?php echo $Lang['face'];?></td><td><center><?php echo $Lang['name'];?></center></td><td><?php echo $Lang['level'];?></td><td><center><?php echo $Lang['class'];?></center></td><td class="maxCp" align="center"><?php echo $Lang['cp'];?></td><td class="maxHp" align="center"><?php echo $Lang['hp'];?></td><td class="maxMp" align="center"><?php echo $Lang['mp'];?></td><td><center><?php echo $Lang['clan'];?></center></td><td><?php echo $Lang['pvp_pk'];?></td><td><?php echo $Lang['status'];?></td></tr>
    <?php
    while ($otherchar=$mysql->fetch_array($sql2))
    {

	if ($otherchar['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$otherchar['clan_id']}&amp;server={$dbs['ID']}\">{$otherchar['clan_name']}</a>";}else{$clan_link = $Lang['no_clan'];}
	if ($otherchar['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }

	if ($otherchar['online']) {$online='<img src="img/online.png" alt="'.$Lang['online'].'" />';} 
	else {$online='<img src="img/status/offline.png" alt="'.$Lang['offline'].'"/>';} 
	?>
<tr><td><img src="img/face/<?php echo $otherchar['race'];?>_<?php echo $otherchar['sex'];?>.gif" alt="" /></td><td><a href="user.php?cid=<?php echo $otherchar['charId'];?>&amp;server=<?php echo $dbs['ID'];?>"><font color="<?php echo $color;?>"><?php echo $otherchar['char_name'];?></font></a></td><td align="center"><?php echo $otherchar['level'];?></td><td align="center"><?php echo $otherchar['ClassName'];?></td><td class="maxCp" align="center"><?php echo $otherchar['maxCp'];?></td><td class="maxHp" align="center"><?php echo $otherchar['maxHp'];?></td><td class="maxMp" align="center"><?php echo $otherchar['maxMp'];?></td><td align="center"><?php echo $clan_link;?></td><td align="center"><b><?php echo $otherchar['pvpkills'];?></b>/<b><font color="red"><?php echo $otherchar['pkkills'];?></font></b></td><td><?php echo $online;?></td></tr>
 <?php       }
        
            echo '</table>';
            }//$mysql->num_rows(other chars)
    }//while
    }//$mysql->num_rows(main user)
    else
    {
        head($Lang['not_found']);
        echo msg('Error',$Lang['not_found'], 'error', false);
    }
}
else
{
    head($Lang['not_found']);
    echo msg('Error',$Lang['not_found'], 'error', false);
}
foot();
?>