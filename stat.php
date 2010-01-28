<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("{$Lang['statistic']}");
includeLang('stat');
?>

<div align="center">
<h4><?php echo $Lang['server_stat'];?></h4><hr />
 | <a href="stat.php"><?php echo $Lang['home'];?></a>
 | <a href="stat.php?stat=online"><?php echo $Lang['online'];?></a> 
 | <a href="onlinemap.php" target="_blank"><?php echo $Lang['map'];?></a> 
 | <a href="castlesmap.php" target="_blank"><?php echo $Lang['castles_map'];?></a> 
 | <a href="stat.php?stat=castles"><?php echo $Lang['castles'];?></a>
 | <a href="stat.php?stat=fort"><?php echo $Lang['fort'];?></a> 
 | <a href="stat.php?stat=clantop"><?php echo $Lang['top_clans'];?></a> |<br /><hr />
 | <a href="stat.php?stat=gm"><?php echo $Lang['gm'];?></a>
 | <a href="stat.php?stat=count"><?php echo $Lang['rich_players'];?></a> 
 | <a href="stat.php?stat=top_pvp"><?php echo $Lang['pvp'];?></a>  
 | <a href="stat.php?stat=top_pk"><?php echo $Lang['pk'];?></a>
 | <a href="stat.php?stat=top_time"><?php echo $Lang['activity'];?></a> 
 | <a href="stat.php?stat=maxCp"><?php echo $Lang['cp'];?></a>
 | <a href="stat.php?stat=maxHp"><?php echo $Lang['hp'];?></a>
 | <a href="stat.php?stat=maxMp"><?php echo $Lang['mp'];?></a> |<br /><hr />
 | <a href="stat.php?stat=top"><?php echo $Lang['top'].' '.$Config['TOP'];?> <?php echo $top;?></a>
 | <a href="stat.php?stat=human"><?php echo $Lang['race'][0];?></a>
 | <a href="stat.php?stat=elf"><?php echo $Lang['race'][1];?></a>
 | <a href="stat.php?stat=dark_elf"><?php echo $Lang['race'][2];?></a>
 | <a href="stat.php?stat=orc"><?php echo $Lang['race'][3];?></a>
 | <a href="stat.php?stat=dwarf"><?php echo $Lang['race'][4];?></a>
 | <a href="stat.php?stat=kamael"><?php echo $Lang['race'][5];?></a> |<br /><hr />
   </div>  
   <?php

$stat = mysql_real_escape_string(trim($_GET['stat']));

switch($stat){
	
	Case 'online':
	$data=mysql_query ("SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `onlinetime`, `ClassName`, `clanid`, `clan_name` FROM `characters` INNER JOIN `char_templates` ON `characters`.`classid`=`char_templates`.`ClassId` LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online` AND !`accesslevel` ORDER BY `exp` DESC");
	echo '<h1>'.$Lang['online'].'</h1>';
	break;
    
    Case 'castles':
    $result = mysql_query("SELECT `id`, `name`, `taxPercent`, `siegeDate`, `charId`, `char_name`, `clan_id`, `clan_name` FROM `castle` LEFT OUTER JOIN `clan_data` ON `clan_data`.`hasCastle`=`castle`.`id` LEFT OUTER JOIN `characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

$r=0;
?><table border="0" cellpadding="3" cellspacing="3">
<?php
while($row = mysql_fetch_array($result)){

($r==0)? '<tr>': '';
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
$result1 = mysql_query("SELECT clan_id, clan_name FROM siege_clans INNER JOIN clan_data USING (clan_id)  WHERE castle_id='{$row['id']}' AND type='1'");
while($attackers=mysql_fetch_assoc($result1))
{
echo '<a href="claninfo.php?clanid='.$attackers['clan_id'].'">'.$attackers['clan_name'].'</a><br />';
}
?>
</td></tr><tr><td><?php echo $Lang['defenders'];?></td><td>
<?php
$result2 = mysql_query("SELECT clan_id, clan_name FROM siege_clans INNER JOIN clan_data USING (clan_id)  WHERE castle_id='{$row['id']}' AND type='0'");
if(mysql_num_rows($result2)){
while($defenders=mysql_fetch_assoc($result2))
{
echo '<a href="claninfo.php?clanid='.mysql_result($result2,0,'clan_id').'">'.mysql_result($result2,0,'clan_name').'</a><br /> ';
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
$result = mysql_query("SELECT `id`, `name`, `lastOwnedTime`, `clan_id`, `clan_name`, `char_name` FROM `fort` LEFT OUTER JOIN `clan_data` ON `clan_data`.`clan_id`=`fort`.`owner` LEFT OUTER JOIN `characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

$r=0;
?><table border="0" cellpadding="3" cellspacing="3">
<?php
while($row = mysql_fetch_assoc($result)){

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
$result1 = mysql_query("SELECT clan_id, clan_name FROM fortsiege_clans INNER JOIN clan_data USING (clan_id)  WHERE fort_id='{$row['id']}'");
while($attackers=mysql_fetch_assoc($result1))
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
<tr class="altRow"><td></td><?php echo $Lang['time_held'];?><td><?php echo $timehour.' '.$Lang['hours'];?></td></tr>
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
    $result = mysql_query("SELECT `clan_id`, `clan_data`.*, `char_name`, `csum`, `ccount`, `cavg`, `name` FROM `clan_data` INNER JOIN `characters` ON `clan_data`.`leader_id`=`characters`.`charId` LEFT JOIN (SELECT `clanid`, SUM(`level`) AS `csum`, count(`level`) AS `ccount`, AVG(`level`) AS `cavg` FROM `characters` WHERE `clanid` GROUP BY `clanid`) AS `levels` ON `clan_data`.`clan_id`=`levels`.`clanid` LEFT OUTER JOIN `castle` ON `clan_data`.`hasCastle`=`castle`.`id` WHERE !`accessLevel` ORDER BY `clan_level` DESC, `csum` DESC");

	echo '<h1> TOP Clans </h1><hr>';
    echo '<h2>'.$Lang["clantop_total"].': '.mysql_num_rows($result).'</h2>';
	echo '<table border=1><thead><tr style="color: green;"><th><b>Clan Name</b></th>
<th><b>Leader</b></th>
<th><b>Level</b></th>
<th><b>Castle</b></th>
<th><b>Total Level</b></th>
<th><b>Members</b></th>
<th><b>Avg. of Levels</b></th>
</tr></thead>';

  $i=1;
  while ($row=mysql_fetch_array($result))
  {
    if($row['hasCastle']!=0){$castle=$row['name'];}else{$castle='No castle';}
    echo "<tr". (($i++ % 2) ? "" : " class=\"altRow\"") ."><td><a href=\"claninfo.php?clan=". $row["clan_id"]."\">". $row["clan_name"]. "</a></td><td><a href=\"user.php?cid={$row['leader_id']}\">". $row["char_name"]. "</a></td><td class=\"numeric sortedColumn\">".$row["clan_level"]. "</td><td>".$castle. "</td><td class=\"numeric\">".$row["csum"]. "</td><td class=\"numeric\">".$row["ccount"]. "</td><td class=\"numeric\">".$row["cavg"]. "</td></tr>\n";
  }
  echo "</tbody>\n</table>\n";
    break;
	
	Case 'gm':
    $data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel>0 ORDER BY accesslevel DESC");
	echo '<h1>'.$Lang['gm'].'</h1>';
	$addheader='<td><b>'.$Lang['send_message'].'</b></td>';
	$addcol=true;
	$addcolcont='<td><a href="contact.php">'.$Lang['send_message'].'</a></td>';
	break;
    
	Case 'count':
    	$data = mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, count, ClassName, clanid, clan_name FROM characters INNER JOIN items ON characters.charId=items.owner_id INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE items.item_id='57' AND !accesslevel ORDER BY count DESC LIMIT {$Config['TOP']}");
	echo'<h1>'.$Lang['rich_players'].'</h1>';
	$addheader='<td><b>'.$Lang['adena'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'top_pvp';
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND pvpkills>0 ORDER BY pvpkills DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['pvp'].'</h1>';
	break;
	
	Case 'top_pk':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND pkkills>0 ORDER BY pkkills DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['pk'].'</h1>';
	break;
	
	Case 'top_time':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel ORDER BY onlinetime DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['activity'].'</h1>';
	break;
	
	Case 'maxCp':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, maxCp, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel ORDER BY maxCp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['cp'].'</h1>';
	$addheader='<td class="maxCp"><b>'.$Lang['max_cp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'maxHp':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, maxHp, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel ORDER BY maxHp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['hp'].'</h1>';
	$addheader='<td class="maxHp"><b>'.$Lang['max_hp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'maxMp':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, maxMp, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel ORDER BY maxMp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['mp'].'</h1>';
	$addheader='<td class="maxMp"><b>'.$Lang['max_mp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'top':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['top'].' '.$Config['TOP'].'</h1>';
	break;
	
	Case 'human':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=0 ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][0].'</h1>';
	break;
	
    	Case 'elf':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=1 ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][1].'</h1>';
	break;
    
	Case 'dark_elf':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=2 ORDER BY exp DESC LIMIT {$Config['TOP']}");

	echo '<h1>'.$Lang['race'][2].'</h1>';
	break;
	
	Case 'orc':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=3 ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][3].'</h1>';
	break;
	
	Case 'dwarf':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=4 ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][4].'</h1>';
	break;
	
	Case 'kamael':
	$data=mysql_query("SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, onlinetime, ClassName, clanid, clan_name FROM characters INNER JOIN char_templates ON characters.classid=char_templates.ClassId LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE !accesslevel AND race=5 ORDER BY exp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][5].'</h1>';
	break;
	
	Default: 
    echo '<h1>'.$Lang['home'].'</h1><hr />';

echo '<table border="1" width="50%">';
$tchar=mysql_result(mysql_query("SELECT Count(*) FROM characters"), 0, 0);
for($i=0; $i<6; $i++)
{
	$sql = mysql_query("SELECT Count(*) FROM characters WHERE race = ".$i);
	$tfg = round(mysql_result($sql, 0, 0)/($tchar/100), 2);
	echo('<tr><td>'.$Lang['race'][$i].'</td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$tfg .'px" alt="'.$tfg.'%" title="'.$tfg.'%" /> '.$tfg .'%</td></tr>');

}
$male = mysql_query("select count(*) from characters where sex = 0");
$mc = round(mysql_result($male, 0, 0)/($tchar/100) , 2);
$female = mysql_query("select count(*) from characters where sex = 1");
$fc = round(mysql_result($female, 0, 0)/($tchar/100) , 2);
echo('<tr><td>'.$Lang['male'].'<img src="img/stat/sex.jpg" alt="'.$Lang['male'].'" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$mc .'px" alt="'.$mc.'px" /> '.$mc .'%</td></tr>');
echo('<tr><td>'.$Lang['female'].'<img src="img/stat/sex1.jpg" alt="'.$Lang['female'].'" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$fc .'px" alt="'.$fc.'px" /> '.$fc .'%</td></tr>');
echo '</table><hr />';

echo '<h1>Seven Signs</h1>';
$query1 = "SELECT count(charId) FROM seven_signs WHERE cabal like '%dusk%'";
$result1 = mysql_query($query1);
$dawn =mysql_result($result1,0,0);


$query2 = "SELECT count(charId) FROM seven_signs WHERE cabal like '%dawn%'";
$result2 = mysql_query($query2);
$dusk = mysql_result($result2,0,0);

$query3 = "SELECT current_cycle, festival_cycle, active_period, date, avarice_dawn_score, avarice_dusk_score, gnosis_dawn_score, gnosis_dusk_score, strife_dawn_score, strife_dusk_score FROM seven_signs_status";
$result3 = mysql_query($query3);
$row=mysql_fetch_assoc($result3);

$current_cycle = $row['current_cycle'];
$festivall_cycle = $row['festival_cycle'];
$active_period = $row['active_period'];
$date = $row['date'];
$avarice = $row['avarice_dawn_score']+$row['avarice_dusk_score'];
$gnosis = $row['gnosis_dawn_score']+$row['gnosis_dusk_score'];
$strife = $row['strife_dawn_score']+$row['strife_dusk_score'];
?>
<script language="javascript" type="text/javascript">
var nthDay = 8;
var currTime = 'we are at work ...';
var ssStatus = 1;
var dawnPoint = <?php echo $dawn; ?>;
var twilPoint = <?php echo $dusk; ?>;
var maxPointWidth = 300;
var seal1 = 2;
var seal2 = 2;
var seal3 = 0;
var seal4 = 0;
var seal5 = 0;
var seal6 = 0;
var seal7 = 1;
</script>

<table style="MARGIN-TOP:0px; width:500px;" cellspacing="0" cellpadding="0" border="0" align="center"><tr valign="top"><td style="background: url(img/ss/ssqViewBg.jpg)" height="225">
<table><tr valign="top"><td>
<table style="MARGIN: 18px 0px 0px 54px" cellspacing="0" cellpadding="0" border="0" width="141">
<tr align="center" style="height: 26px;">
<td style="BACKGROUND: url(img/ss/ssqViewimg1.gif);">
<script language="javascript" type="text/javascript">
if (0 == ssStatus) {
document.write('Start');
}
else if (1 == ssStatus) {
document.write("Competition day <b> " + nthDay + " </b>");
}
else if (2 == ssStatus) {
document.write('Result');
}
else if (3 == ssStatus) {
document.write('ss result day ' + nthDay);
}
</script>
</td></tr></table>
<table style="MARGIN: 3px 0px 0px 10px" cellspacing="0" cellpadding="0" width="141" border="0">
<tr><td></td><td><img height="16" src="img/ss/timeBox1.jpg" width="140" border="0" alt="" /></td>
<td></td></tr>
<tr>
<td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox2.jpg" width="45" border="0" alt="" /></td>
<td>
<script language="javascript" type="text/javascript">
var timeImage;
var tempImageNum;

if (1 == ssStatus) {
tempImageNum = nthDay;
}
else if (0 == ssStatus) {
tempImageNum = 0;
}
else if (3 == ssStatus || 2 == ssStatus) {
tempImageNum = nthDay + 7;
}
timeImage = 'time'+tempImageNum+'.jpg';
document.write('<img src="img/ss/time/'+ timeImage +'" width="140" height="139" border="0" alt="" />');
</script>
</td>
<td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox3.jpg" width="66" border="0" alt="" /></td></tr><tr>
<td><img height="12" src="img/ss/timeBox4.jpg" width="140" border="0" alt="" /></td>
</tr></table></td>
<td><table style="MARGIN: 27px 0px 0px 22px" cellspacing="0" cellpadding="0" width="200" border="0">
<tr align="center" bgcolor="#606d6f" style="height: 17px;">
<td>
<?php
$timezone  = 2;
echo gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
?>
</td></tr></table>
<table style="MARGIN: 21px 0px 0px 22px" cellspacing="0" cellpadding="0" border="0">
<colgroup><col width="74" /><col width="*" /></colgroup>
<tr>
<td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" alt="" />Dawn</td>
<td style="COLOR: #000;">
<script language="javascript" type="text/javascript">
var twilPointWidth = maxPointWidth * twilPoint / 100;
document.write('<img src="img/ss/ssqbar2.gif" width="' + twilPointWidth + '" height="9" border="0" alt="" /> ' + twilPoint);
</script>
</td></tr><tr><td colspan="2" height="7"></td>
</tr><tr>
<td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" alt="" />Dusk</td>
<td style="COLOR: #000; font-size:11px;">
<script language="javascript" type="text/javascript">
var dawnPointWidth = maxPointWidth * dawnPoint / 100;
document.write('<img src="img/ss/ssqbar1.gif" width="' + dawnPointWidth + '" height="9" border="0" alt="" /> ' + dawnPoint);
</script>
</td></tr></table>
<table border="0">
<tr valign="bottom" align="center" style="height: 95px;">
<td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal1)
document.write('<img src="img/ss/Seals/SOA/bongin1close.gif" width="85" height="86" border="0" alt="" />');
else
document.write('<img src="img/ss/Seals/SOA/bongin1open.gif" width="85" height="86" border="0" alt="" />');
}   else {
document.write('<img src="img/ss/Seals/SOA/bongin1.gif" width="85" height="86" border="0" alt="" />');
}
</script>
</td><td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal2)
document.write('<img src="img/ss/Seals/SOG/bongin2close.gif" width="85" height="86" border="0" alt="" />');
else
document.write('<img src="img/ss/Seals/SOG/bongin2open.gif" width="85" height="86" border="0" alt="" />');
}   else {
document.write('<img src="img/ss/Seals/SOG/bongin2.gif" width="85" height="86" border="0" alt="" />');
}
</script>
</td><td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal3)
document.write('<img src="img/ss/Seals/SOS/bongin3close.gif" width="85" height="86" border="0" alt="" />');
else
document.write('<img src="img/ss/Seals/SOS/bongin3open.gif" width="85" height="86" border="0" alt="" />');
}   else {
document.write("<img src='img/ss/Seals/SOS/bongin3.gif' width='85' height='86' border='0' alt='' />");
}
</script>
</td></tr>
<tr>
<td colspan="3"><div align="center" style="margin-left:10px;"><img height="16" src="img/ss/bonginName.gif" width="258" border="0" alt="" /> </div></td>
</tr>
</table></td></tr>
</table></td></tr></table>
<?php
break;
}
if($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop'){
includeLang('user');
?>
<hr /><table border="1"><tr><td><?php echo $Lang['place'];?></td><td><?php echo $Lang['face'];?></td><td><center><?php echo $Lang['name'];?></center></td><td><?php echo $Lang['level'];?></td><td><center><?php echo $Lang['class'];?></center></td><td><center><?php echo $Lang['clan'];?></center></td><td><?php echo $Lang['pvp_pk'];?></td><td><center><?php echo $Lang['online_time'];?></center></td><td><?php echo $Lang['status'];?></td><?php echo $addheader;?></tr>
<?php
$n=1;
while ($top=mysql_fetch_assoc($data))
{
	$onlinetimeH=round(($top['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($top['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	if ($top['clan_name']) { $clan_link='<a href="claninfo.php?clan='.$top['clanid'].'">'.$top['clan_name'].'</a>'; }else{$clan_link='No Clan';}
	if ($top['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	if ($top['online']) {$online='<font color="green">'.$Lang['online'].'</font>'; } 
	else {$online='<font color="red">'.$Lang['offline'].'</font>'; } 
    ?>
	<tr <?php echo ($n%2==0)? 'class="altRow"': '';?>><td align="center"><b><?php echo $n;?></b></td><td><img src="./img/face/<?php echo $top['race'].'_'.$top['sex'];?>.gif" alt="" /></td><td><a href="user.php?cid=<?php echo $top['charId'];?>"><font color="$color"><?php echo $top['char_name'];?></font></a></td><td><center> <?php echo $top['level'];?></center></td><td><center><?php echo $top['ClassName'];?></center></td><td><?php echo $clan_link;?></td><td><center><b><?php echo $top['pvpkills'];?></b>/<b><font color="red"><?php echo $top['pkkills'];?></font></b></center></td><td><center><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></center></td><td><?php echo $online;?></td>
    <?php
	if($addcol && $addcolcont){echo $addcolcont;}elseif($addcol && !$addcolcont){echo('<td class="'.$stat.'">'.$top[$stat].'</td>');}else{}
	echo('</tr>');
	$n++;
}
?>
</table>
<?php
}
foot();
?>