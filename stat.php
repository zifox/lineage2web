<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('stat');
$stat = $mysql->escape($_GET['stat']);
if(isset($_GET['page']))
{
    $start = $mysql->escape(0 + $_GET['page']);
}
else
{
    $start = 1;
}
if(!is_numeric($start) || $start==0) {$start = 1;}
$start=abs($start)-1;
$startlimit = $start*$Config['TOP'];

$head = $Lang['head_'.$stat];
if($head == '') {$head = $Lang['home'];}
head("$head");

$parse=$Lang;
$parse['human']     = $Lang['race'][0];
$parse['elf']       = $Lang['race'][1];
$parse['dark_elf']  = $Lang['race'][2];
$parse['orc']       = $Lang['race'][3];
$parse['dwarf']     = $Lang['race'][4];
$parse['kamael']    = $Lang['race'][5];
if(isset($_GET['server']))
{
	$parse['ID'] = "&amp;server=".$_GET['server'];
}
$parse['server_list'] = NULL;
$server_list = $mysql->query("SELECT `ID`, `Name` FROM `$webdb`.`gameservers` WHERE `active`=true");
while($slist = $mysql->fetch_array($server_list))
{
	$selected=($slist['ID']==$_GET['server'])?'selected="selected"':'';
	$parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat='.$_GET['stat'].'&amp;server='.$slist['ID'].'\')" '.$selected.'>'.$slist['Name'].'</option>';
}
$tpl->parsetemplate('stat_menu', $parse);
unset($parse);
if(isset($_GET['server']) && is_numeric($_GET['server']))
{
	$server = 0 + $_GET['server'];
    $s_db = getDBName($server);
}else
{
	$s_db = $Config['DDB'];
}



switch($stat){
	
	Case 'online':
	$data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online`='1' AND `accesslevel`='0' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
    $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `online`='1'");
	echo '<h1>'.$Lang['online'].'</h1>';
	break;
    
    Case 'castles':
    $result = $mysql->query("SELECT `id`, `name`, `taxPercent`, `siegeDate`, `charId`, `char_name`, `clan_id`, `clan_name` FROM `$s_db`.`castle` LEFT OUTER JOIN `$s_db`.`clan_data` ON `clan_data`.`hasCastle`=`castle`.`id` LEFT OUTER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

$r=0;
?><table border="0" cellpadding="3" cellspacing="3">
<?php
while($row = $mysql->fetch_array($result)){

if ($r==0){echo '<tr>';}
$r++;

?>
<td><table border="1"><tr><td class="noborder">
<h1><?php echo sprintf($Lang['castle_of'],$row['name'],'%s');?></h1>
<?php echo $Lang['next_siege'].date('D j M Y H:i',$row['siegeDate']/1000); ?>
<br /><img src = "img/castle/<?php echo $row['name'];?>.png" width = "170" alt="<?php echo $row['name'];?>" />
<table border="0" width="170">
<tr style="background-color: #2391ab;"><td><?php echo $Lang['castle'];?></td><td><?php echo $Lang['details'];?></td></tr>
<tr><td><?php echo $Lang['owner_clan'];?></td><td>
<?php
if ($row['clan_id'])
{echo '<a href="claninfo.php?clan='.$row['clan_id'].'">'.$row['clan_name'].'</a>';}
else{echo $Lang['no_owner'];}
?></td></tr>
<tr class="altRow"><td><?php echo $Lang['lord'];?></td><td>
<?php
if ($row['charId'])
{echo '<a href="user.php?cid='.$row['charId'].'">'.$row['char_name'].'</a>';}
else{echo $Lang['no_lord'];}
?></td></tr>
<tr><td><?php echo $Lang['tax'];?></td><td><?php echo $row['taxPercent'];?>%</td></tr>

<tr class="altRow"><td><?php echo $Lang['attackers'];?></td><td>
<?php
$result1 = $mysql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`siege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `castle_id`='{$row['id']}' AND `type`='1'");
while($attackers=$mysql->fetch_array($result1))
{
echo '<a href="claninfo.php?clanid='.$attackers['clan_id'].'">'.$attackers['clan_name'].'</a><br />';
}
?>
</td></tr><tr><td><?php echo $Lang['defenders'];?></td><td>
<?php
$result2 = $mysql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`siege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `castle_id`='{$row['id']}' AND `type`='0'");
if($mysql->num_rows2($result2)){
while($defenders=$mysql->fetch_array($result2))
{
echo '<a href="claninfo.php?clanid='.$defenders['clan_id'].'">'.$defenders['clan_name'].'</a><br /> ';
}
}else echo $Lang['npc'];
?>
</td></tr></table></td></tr></table>
</td>
<?php if($r==3)
{
    echo '</tr>';
    $r=0;
}

}
?>
</table>
<?php
    break;
    
    Case 'fort':
$result = $mysql->query("SELECT `id`, `name`, `lastOwnedTime`, `clan_id`, `clan_name`, `char_name` FROM `$s_db`.`fort` LEFT OUTER JOIN `$s_db`.`clan_data` ON `clan_data`.`clan_id`=`fort`.`owner` LEFT OUTER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

$r=0;
?><table border="0" cellpadding="3" cellspacing="3">
<?php
while($row = $mysql->fetch_array($result)){

if ($r==0){echo '<tr>';}
$r++;
?>
<td><table border="1"><tr><td class="noborder">
<h1><?php echo sprintf($Lang['fort_of'],$row['name'],'%s');?></h1>
<br /><img src = "img/fort/<?php echo $row['id'];?>.jpg" width = "170" alt="<?php echo $row['name'];?> Fortress" />
<table border="0" width="170">
<tr style="background-color: #2391ab;"><td><?php echo $Lang['fort'];?></td><td><?php echo $Lang['details'];?></td></tr>
<tr><td><?php echo $Lang['owner_clan'];?></td><td>
<?php
if ($row['clan_id'])
{echo '<a href="claninfo.php?clan='.$row['clan_id'].'">'.$row['clan_name'].'</a>';}
else{echo $Lang['no_owner'];}
?></td></tr>
<tr class="altRow"><td><?php echo $Lang['lord'];?></td><td>
<?php
if ($row['charId'])
{echo '<a href="user.php?cid='.$row['charId'].'">'.$row['char_name'].'</a>';}
else{echo $Lang['no_lord'];}
?></td></tr>

<tr><td><?php echo $Lang['attackers'];?></td><td>
<?php
$result1 = $mysql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`fortsiege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `fort_id`='{$row['id']}'");
while($attackers=$mysql->fetch_array($result1))
{
echo '<a href="claninfo.php?clanid='.$attackers['clan_id'].'">'.$attackers['clan_name'].'</a><br />';
}
?>
</td></tr>
<?php
if($row['lastOwnedTime']){
$timeheld=time()-$row['lastOwnedTime']/1000;
$timehour=round($timeheld/60/60);
}else {$timehour=0;}
?>
<tr class="altRow"><td><?php echo $Lang['time_held'];?></td><td><?php echo $timehour.' '.$Lang['hours'];?></td></tr>
</table></td></tr></table>
</td>
<?php if($r==3)
{
    echo '</tr>';
    $r=0;
}
}
?>
</table>
<?
    break;
    
	Case 'clantop':
    $result = $mysql->query("SELECT `clan_id`, `clan_name`, `clan_level`, `reputation_score`, `hasCastle`, `ally_id`, `ally_name`, `char_name`, `ccount`, `name` FROM `$s_db`.`clan_data` INNER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` LEFT JOIN (SELECT clanid, count(`level`) AS `ccount` FROM `$s_db`.`characters` WHERE `clanid` GROUP BY `clanid`) AS `levels` ON `clan_data`.`clan_id`=`levels`.`clanid` LEFT OUTER JOIN `$s_db`.`castle` ON `clan_data`.`hasCastle`=`castle`.`id` WHERE `characters`.`accessLevel`='0' ORDER BY `clan_level`, `reputation_score` DESC LIMIT $startlimit, {$Config['TOP']}");
    $page_foot = $mysql->query("SELECT count(`clan_id`) FROM `$s_db`.`clan_data`, `$s_db`.`characters` WHERE `clan_data`.`leader_id`=`characters`.`charId` AND `characters`.`accessLevel`='0'");
?>
<h1> TOP Clans </h1><hr />
<h2><?php echo $Lang["clantop_total"];?>: <?php echo $mysql->num_rows($result);?></h2>
<table border="1"><thead><tr style="color: green;"><th><b>Clan Name</b></th>
<th><b>Leader</b></th>
<th><b>Level</b></th>
<th><b>Reutation</b></th>
<th><b>Castle</b></th>
<th><b>Members</b></th>
</tr></thead>
<tbody>
<?php
  $i=1;
  while ($row=$mysql->fetch_array($result))
  {
    if($row['hasCastle']!=0){$castle=$row['name'];}else{$castle='No castle';}
    echo "<tr". (($i++ % 2) ? "" : " class=\"altRow\"") ." onmouseover=\"this.bgColor = '#505050';\" onmouseout=\"this.bgColor = ''\"><td><a href=\"claninfo.php?clan=". $row["clan_id"]."\">". $row["clan_name"]. "</a></td><td><a href=\"user.php?cid={$row['leader_id']}\">". $row["char_name"]. "</a></td><td class=\"numeric sortedColumn\">".$row["clan_level"]. "</td><td>{$row['reputation_score']}</td><td>".$castle. "</td><td class=\"numeric\">".$row["ccount"]. "</td></tr>";
  }
  echo "</tbody></table>";
    break;
	
	Case 'gm':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`>'0' LIMIT $startlimit, {$Config['TOP']}");
       $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`>'0'");
	   echo '<h1>'.$Lang['gm'].'</h1>';
	break;
    
	Case 'count':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`,  `count`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`items` ON `characters`.`charId`=`items`.`owner_id` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `items`.`item_id`='57' AND `accesslevel`='0' ORDER BY `count` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters`, `$s_db`.`items`  WHERE `accesslevel`='0' AND `characters`.`charId`=`items`.`owner_id` AND `items`.`item_id`='57'");
        echo'<h1>'.$Lang['rich_players'].'</h1>';
        $addheader='<td><b>'.$Lang['adena'].'</b></td>';
        $addcol=true;
	break;
	
	Case 'top_pvp';
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`,  `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `pvpkills`>'0' ORDER BY `pvpkills` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `pvpkills`>'0'");
        echo '<h1>'.$Lang['pvp'].'</h1>';
	break;
	
	Case 'top_pk':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`,  `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `pkkills`>'0' ORDER BY 'pkkills' DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `pkkills`>'0'");
        echo '<h1>'.$Lang['pk'].'</h1>';
	break;
	
	Case 'maxCp':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `maxCp`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' ORDER BY `maxCp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0'");
        echo '<h1>'.$Lang['cp'].'</h1>';
        $addheader='<td class="maxCp"><b>'.$Lang['max_cp'].'</b></td>';
        $addcol=true;
	break;
	
	Case 'maxHp':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `maxHp`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' ORDER BY `maxHp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0'");
        echo '<h1>'.$Lang['hp'].'</h1>';
        $addheader='<td class="maxHp"><b>'.$Lang['max_hp'].'</b></td>';
        $addcol=true;
	break;
	
	Case 'maxMp':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `maxMp`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' ORDER BY `maxMp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0'");
        echo '<h1>'.$Lang['mp'].'</h1>';
        $addheader='<td class="maxMp"><b>'.$Lang['max_mp'].'</b></td>';
        $addcol=true;
	break;
	
	Case 'top':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot = $mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0'");
        echo '<h1>'.$Lang['top'].' '.$Config['TOP'].'</h1>';
	break;
	
	Case 'human':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='0' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='0'");
        echo '<h1>'.$Lang['race'][0].'</h1>';
	break;
	
	Case 'elf':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='1' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='1'");
        echo '<h1>'.$Lang['race'][1].'</h1>';
	break;
    
	Case 'dark_elf':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='2' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='2'");
        echo '<h1>'.$Lang['race'][2].'</h1>';
	break;
	
	Case 'orc':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='3' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='3'");
        echo '<h1>'.$Lang['race'][3].'</h1>';
	break;
	
	Case 'dwarf':
        $data = $mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='4' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='4'");
        echo '<h1>'.$Lang['race'][4].'</h1>';
	break;
	
	Case 'kamael':
        $data=$mysql->query("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `$s_db`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`='0' AND `race`='5' ORDER BY `exp` DESC LIMIT $startlimit, {$Config['TOP']}");
        $page_foot=$mysql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `accesslevel`='0' AND `race`='5'");
        echo '<h1>'.$Lang['race'][5].'</h1>';
	break;
	
	Default: 
    echo '<h1>'.$Lang['home'].'</h1><hr />';

echo '<table border="1" width="50%">';
$tchar=$mysql->result($mysql->query("SELECT count(*) FROM `$s_db`.`characters`"));
for($i=0; $i<6; $i++)
{
	$sql = $mysql->query("SELECT count(*) FROM `$s_db`.`characters` WHERE `race` = '".$i."'");
	$tfg = round($mysql->result($sql)/($tchar/100), 2);
	echo('<tr><td>'.$Lang['race'][$i].'</td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$tfg .'px" alt="'.$tfg.'%" title="'.$tfg.'%" /> '.$tfg .'%</td></tr>');

}
$male = $mysql->query("SELECT count(*) FROM `$s_db`.`characters` WHERE `sex` = '0'");
$mc = round($mysql->result($male)/($tchar/100) , 2);
$female = $mysql->query("SELECT count(*) FROM `$s_db`.`characters` WHERE `sex` = '1'");
$fc = round($mysql->result($female)/($tchar/100) , 2);
echo('<tr><td>'.$Lang['male'].'<img src="img/stat/sex.jpg" alt="'.$Lang['male'].'" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$mc .'px" alt="'.$mc.'px" /> '.$mc .'%</td></tr>');
echo('<tr><td>'.$Lang['female'].'<img src="img/stat/sex1.jpg" alt="'.$Lang['female'].'" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$fc .'px" alt="'.$fc.'px" /> '.$fc .'%</td></tr>');
echo '</table><hr />';

echo '<h1>Seven Signs</h1>';

$result1 = $mysql->query($q[206], $s_db, '%dusk%');
$dawn =$mysql->result($result1);

$result2 = $mysql->query($q[206], $s_db, '%dawn%');
$dusk = $mysql->result($result2);

$result3 = $mysql->query($q[207], $s_db);
$row=$mysql->fetch_array($result3);

$twilScore = $row['avarice_dusk_score'] + $row['gnosis_dusk_score'] + $row['strife_dusk_score'];
$dawnScore = $row['avarice_dawn_score'] + $row['gnosis_dawn_score'] + $row['strife_dawn_score'];
$totalScore = $twilScore + $dawnScore;

$dawnPoint = ($totalScore == 0) ? 0 : round(($dawnScore / $totalScore) * 1000);
$twilPoint = ($totalScore == 0) ? 0 : round(($twilScore / $totalScore) * 1000);

?>

<script language="javascript" type="text/javascript">
<!--
var nthDay = <?php echo $row['current_cycle'];?>;
var currTime = "<?php echo date('m/d/Y H:i'); ?>";
var ssStatus = <?php echo $row['active_period'];?>;
var dawnPoint = <?php echo $dawnScore; ?>;
var twilPoint = <?php echo $twilScore; ?>;
var maxPointWidth = 300;
var seal1 = <?php echo $row['avarice_owner']; ?>;
var seal2 = <?php echo $row['gnosis_owner']; ?>;
var seal3 = <?php echo $row['strife_owner']; ?>;

// -->
</script>

<?php

$tpl->parsetemplate('seven_signs', NULL);
break;
}
if($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop'){
includeLang('user');
?>
<hr /><table border="1"><tr><td><?php echo $Lang['place'];?></td><td><?php echo $Lang['face'];?></td><td><center><?php echo $Lang['name'];?></center></td><td><?php echo $Lang['level'];?></td><td><center><?php echo $Lang['class'];?></center></td><td><center><?php echo $Lang['clan'];?></center></td><td><?php echo $Lang['pvp_pk'];?></td><td><?php echo $Lang['status'];?></td><?php echo $addheader;?></tr>
<?php
if($startlimi!=0 || $startlimit!=null)
{
    $n=$startlimit+1;
}
else
{
    $n=1;
}
while ($top=$mysql->fetch_array($data))
{
	if ($top['clan_name']) { $clan_link='<a href="claninfo.php?clan='.$top['clanid'].'">'.$top['clan_name'].'</a>'; }else{$clan_link='No Clan';}
	if ($top['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	if ($top['online']) {$online='<font color="green">'.$Lang['online'].'</font>'; } 
	else {$online='<font color="red">'.$Lang['offline'].'</font>'; } 
    ?>
	<tr<?php echo ($n%2==0)? ' class="altRow"': '';?> onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="center"><b><?php echo $n;?></b></td><td><img src="./img/face/<?php echo $top['race'].'_'.$top['sex'];?>.gif" alt="" /></td><td><a href="user.php?cid=<?php echo $top['charId'];?>"><font color="$color"><?php echo $top['char_name'];?></font></a></td><td><center> <?php echo $top['level'];?></center></td><td><center><?php echo $top['ClassName'];?></center></td><td><?php echo $clan_link;?></td><td><center><b><?php echo $top['pvpkills'];?></b>/<b><font color="red"><?php echo $top['pkkills'];?></font></b></center></td><td><?php echo $online;?></td>
    <?php
	if($addcol && $addcolcont){echo $addcolcont;}elseif($addcol && !$addcolcont){echo('<td class="'.$stat.'">'.$top[$stat].'</td>');}else{}
	echo('</tr>');
	$n++;
}
?>
</table>
<?php
}
echo '<br />';
if($stat && $stat != 'castles' && $stat != 'fort'){
    $page_foot=$mysql->result($page_foot);
    pagechoose($start+1, $page_foot, $stat, $server);
}
echo '<br />';
foot();
?>