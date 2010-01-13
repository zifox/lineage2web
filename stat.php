<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("{$Lang['statistic']}");
includeLang('stat');

//////////////////////////MENU
?>
<center>
<h4><?php echo $Lang['server_stat'];?></h4><hr />
 | <a href="stat.php"><?php echo $Lang['home'];?></a>
 | <a href="stat.php?stat=online"><?php echo $Lang['online'];?></a> 
 | <a href="module/onlinemap/index.php"target= "_blank"><?php echo $Lang['map'];?></a> 
 | <a href="module/castles/index.php "target= "_blank"><?php echo $Lang['castles_map'];?></a> 
 | <a href="stat.php?stat=castles"><?php echo $Lang['castles'];?></a> 
 | <a href="clantop.php"><?php echo $Lang['top_clans'];?></a> |<br /><hr />
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
 | <a href="stat.php?stat=dark_elf"><?php echo $Lang['race'][1];?></a>
 | <a href="stat.php?stat=elf"><?php echo $Lang['race'][2];?></a>
 | <a href="stat.php?stat=orc"><?php echo $Lang['race'][3];?></a>
 | <a href="stat.php?stat=dwarf"><?php echo $Lang['race'][4];?></a>
 | <a href="stat.php?stat=kamael"><?php echo $Lang['race'][5];?></a> |<br /><hr />
   </center>  
   <?php
   //////////////////////////////MENU

$stat = mysql_real_escape_string($_GET['stat']);

switch($stat){
	
	Case 'online':
	$data=mysql_query ("SELECT * FROM characters WHERE online ORDER BY exp DESC");
	echo '<h1>'.$Lang['online'].'</h1>';
	break;
	
    Case 'castles':
    $result = mysql_query("SELECT id, name, taxPercent, siegeDate, charId, char_name, clan_id, clan_name FROM castle LEFT OUTER JOIN clan_data ON clan_data.hasCastle=castle.id LEFT OUTER JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC");

$r=0;
echo '<table border="0" cellpadding="3" cellspacing="3">';
while($row = mysql_fetch_array($result)){

if ($r==0){echo '<tr>';}
$r++;
echo '<td><table border = "1"><tr><td class="noborder">';
echo '<h1>'.sprintf($Lang['castle_of'],$row['name'],'%s').'</h1>';
echo $Lang['next_siege'].date('D j M Y H:i',$row['siegeDate']/1000);
echo '<br /><img src = "img/castle/'.$row['name'].'.png" width = "170"';

echo '<table border = "0" width = "170"><tr style="background-color: #2391ab;"><td>'.$Lang['castle'].'</td><td>'.$Lang['details'].'</td></tr>';
echo '<tr><td>'.$Lang['owner_clan'].'</td><td>';
if ($row['clan_id'])
{echo '<a href="claninfo.php?clan='.$row['clan_id'].'">'.$row['clan_name'].'</a>';}
else{echo $Lang['no_owner'];}
echo '</td></tr>';
echo '<tr class="altRow"><td>'.$Lang['lord'].'</td><td>';
if ($row['charId'])
{echo '<a href="user.php?cid='.$row['charId'].'">'.$row['char_name'].'</a>';}
else{echo $Lang['no_lord'];}
echo'</td></tr>';
echo '<tr><td>'.$Lang['tax'].'</td><td>'.$row['taxPercent'].'%</td></tr>';

echo '<tr class="altRow"><td>'.$Lang['attackers'].'</td><td>';
$result1 = mysql_query("SELECT clan_id, clan_name FROM siege_clans INNER JOIN clan_data USING (clan_id)  WHERE castle_id='{$row['id']}' AND type='1'");
if(mysql_num_rows($result1)){
echo '<a href="claninfo.php?clanid='.mysql_result($result1,0,'clan_id').'">'.mysql_result($result1,0,'clan_name').'</a><br />';
}

echo '</td></tr><tr><td>'.$Lang['defenders'].'</td><td>';
$result2 = mysql_query("SELECT clan_id, clan_name FROM siege_clans INNER JOIN clan_data USING (clan_id)  WHERE castle_id='{$row['id']}' AND type='0'");
if(mysql_num_rows($result2)){
echo '<a href="claninfo.php?clanid='.mysql_result($result2,0,'clan_id').'">'.mysql_result($result2,0,'clan_name').'</a><br /> ';
}else echo $Lang['npc'];

echo '</td></tr></table></td></tr></table>';
echo '</td>';
if($r==3)
{
    echo '</tr>';
    $r=0;
}
}
echo '</table>';
    break;
    
	Case 'clantop': //NOTDONE
    break;
	
	Case 'gm':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel>0 ORDER BY accesslevel DESC");
	echo '<h1>'.$Lang['gm'].'</h1>';
	$addheader='<td><b>'.$Lang['send_message'].'</b></td>';
	$addcol=true;
	$addcolcont='<td><a href=index.php?id=msg>'.$Lang['send_message'].'</a></td>';
	break;
    
	Case 'count':
	$data = mysql_query("SELECT `characters`.`char_name`, `characters`.`sex`, `characters`.`pvpkills`, `characters`.`pkkills`, `characters`.`race`, `characters`.`classid`, `characters`.`base_class`, `characters`.`onlinetime`, `characters`.`online`, `characters`.`level`, `characters`.`clanid`, `items`.`count` FROM characters, items WHERE items.item_id = '57' AND characters.charId = items.owner_id AND characters.accesslevel=0 ORDER BY items.count DESC LIMIT {$Config['TOP']}");
	echo'<h1>'.$Lang['rich_players'].'</h1>';
	$addheader='<td><b>'.$Lang['adena'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'top_pvp';
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel AND pvpkills>0 ORDER BY pvpkills DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['pvp'].'</h1>';
	break;
	
	Case 'top_pk':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel=0 AND pkkills>0 ORDER BY pkkills DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['pk'].'</h1>';
	break;
	
	Case 'top_time':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY onlinetime DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['activity'].'</h1>';
	break;
	
	Case 'maxCp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxCp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['cp'].'</h1>';
	$addheader='<td><b>'.$Lang['max_cp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'maxHp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxHp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['hp'].'</h1>';
	$addheader='<td><b>'.$Lang['max_hp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'maxMp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxMp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['mp'].'</h1>';
	$addheader='<td><b>'.$Lang['max_mp'].'</b></td>';
	$addcol=true;
	break;
	
	Case 'top':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel=0  ORDER BY  level  DESC LIMIT {$Config['TOP']} ");
	echo '<h1>'.$Lang['top'].' '.$Config['TOP'].'</h1>';
	break;
	
	Case 'human':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=0 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][0].'</h1>';
	break;
	
    	Case 'dark_elf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=1 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][1].'</h1>';
	break;
    
	Case 'elf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=2 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");

	echo '<h1>'.$Lang['race'][2].'</h1>';
	break;
	
	Case 'orc':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=3 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][3].'</h1>';
	break;
	
	Case 'dwarf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=4 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['race'][4].'</h1>';
	break;
	
	Case 'kamael':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=5 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
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
	echo('<tr><td>'.$Lang['race'][$i].'</td><td><img src="module/stat/sexline.jpg" height="10px" width="'.$tfg .'"px"> '.$tfg .'%</td></tr>');

}
$male = mysql_query("select count(*) from characters where sex = 0");
$mc = round(mysql_result($male, 0, 0)/($tchar/100) , 2);
$female = mysql_query("select count(*) from characters where sex = 1");
$fc = round(mysql_result($female, 0, 0)/($tchar/100) , 2);
echo('<tr><td>'.$Lang['male'].'<img src="module/stat/sex.jpg" /></td><td><img src="module/stat/sexline.jpg" height="10px" width="'.$mc .'"px" /> '.$mc .'%</td></tr>');
echo('<tr><td>'.$Lang['female'].'<img src="module/stat/sex1.jpg" /></td><td><img src="module/stat/sexline.jpg" height="10px" width="'.$fc .'"px" /> '.$fc .'%</td></tr>');
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

<table style="MARGIN-TOP:0px; width:500px;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr valign="top"><td style="background: url(img/ss/ssqViewBg.jpg)" height="225">
<table><tbody><tr valign="top"><td>
<table style="MARGIN: 18px 0px 0px 54px" cellspacing="0" cellpadding="0" border="0" width="141">
<tbody><tr align="middle" style="height: 26px;">
<td style="BACKGROUND: url(img/ss/ssqViewimg1.gif);">
<script language="javascript" type="text/javascript">
if (0 == ssStatus) {
document.write('Start');
}
else if (1 == ssStatus) {
document.write('Competition <b style="color:#E10000"> day ' + nthDay + '</b>');
}
else if (2 == ssStatus) {
document.write('Result');
}
else if (3 == ssStatus) {
document.write('ss result<b style="color:#E10000"> day ' + nthDay + '</b>');
}
</script>
</td></tr></tbody></table>
<table style="MARGIN: 3px 0px 0px 10px" cellspacing="0" cellpadding="0" width="141" border="0">
<tbody><tr><td></td><td><img height="16" src="img/ss/timeBox1.jpg" width="140" border="0" /></td>
<td></td></tr>
<tr>
<td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox2.jpg" width="45" border="0" /></td>
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
document.write('<img src="img/ss/time/'+ timeImage +'" width="140" height="139" border="0" />');
</script>
</td>
<td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox3.jpg" width="66" border="0" /></td></tr><tr>
<td><img height="12" src="img/ss/timeBox4.jpg" width="140" border="0" /></td>
</tr></tbody></table></td>
<td><table style="MARGIN: 27px 0px 0px 22px" cellspacing="0" cellpadding="0" width="200" border="0">
<tbody><tr align="middle" bgcolor="#606d6f" style="height: 17px;">
<td>
<?php
$timezone  = 2;
echo gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
?>
</td></tr></tbody></table>
<table style="MARGIN: 21px 0px 0px 22px" cellspacing="0" cellpadding="0" border="0">
<colgroup><col width="74" /><col width="*" />
<tbody><tr>
<td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" />Dawn</td>
<td style="COLOR: #000;">
<script language="javascript" type="text/javascript">
var twilPointWidth = maxPointWidth * twilPoint / 100;
document.write('<img src="img/ss/ssqbar2.gif" width="' + twilPointWidth + '" height="9" border="0" /> ' + twilPoint);
</script>
</td></tr><tr><td colspan="2" height="7"></td>
</tr><tr>
<td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" />Dusk</td>
<td style="COLOR: #000; font-size:11px;">
<script language="javascript" type="text/javascript">
var dawnPointWidth = maxPointWidth * dawnPoint / 100;
document.write('<img src="img/ss/ssqbar1.gif" width="' + dawnPointWidth + '" height="9" border="0" /> ' + dawnPoint);
</script>
</td></tr></tbody></table>
<table border="0">
<tbody><tr valign="bottom" align="middle" style="height: 95px;">
<td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal1)
document.write('<img src="img/ss/Seals/SOA/bongin1close.gif" width="85" height="86" border="0" />');
else
document.write('<img src="img/ss/Seals/SOA/bongin1open.gif" width="85" height="86" border="0" />');
}   else {
document.write('<img src="img/ss/Seals/SOA/bongin1.gif" width="85" height="86" border="0" />');
}
</script>
</td><td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal2)
document.write('<img src="img/ss/Seals/SOG/bongin2close.gif" width="85" height="86" border="0" />');
else
document.write('<img src="img/ss/Seals/SOG/bongin2open.gif" width="85" height="86" border="0" />');
}   else {
document.write('<img src="img/ss/Seals/SOG/bongin2.gif" width="85" height="86" border="0" />');
}
</script>
</td><td>
<script language="javascript" type="text/javascript">
if (3 == ssStatus) {
if (0 == seal3)
document.write('<img src="img/ss/Seals/SOS/bongin3close.gif" width="85" height="86" border="0" />');
else
document.write('<img src="img/ss/Seals/SOS/bongin3open.gif" width="85" height="86" border="0" />');
}   else {
document.write('<img src="img/ss/Seals/SOS/bongin3.gif" width="85" height="86" border="0" />');
}
</script>
</td></tr>
<tr>
<td colspan="3"><div align="center" style="margin-left:10px;"><img height="16" src="img/ss/bonginName.gif" width="258" border="0" /> </div></td>
</tr>
</tbody></table></td></tr></tbody>
</table></td></tr></tbody></table>
<?php
break;
}
if($stat && $stat != 'castles' && $stat != 'clantop'){
includeLang('table');
echo '<hr /><table border="1"><tr><td>'.$Lang['place'].'</td><td>'.$Lang['face'].'</td><td><center>'.$Lang['nick'].'</center></td><td>'.$Lang['level'].'</td><td><center>'.$Lang['proffesion'].'</center></td><td><center>'.$Lang['clan'].'</center></td><td>'.$Lang['pvp_pk'].'</td><td><center>'.$Lang['time_in_game'].'</center></td><td>'.$Lang['status'].'</td>'.$addheader.'</tr>';

$n=1;
while ($top=mysql_fetch_array($data))
{
	$onlinetimeH=round(($top['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($top['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	$clan=mysql_fetch_array(mysql_query("select clan_name from clan_data where clan_id=$top[clanid]"));
	if ($clan['clan_name']=='') { $clan['clan_name']=$Lang['no_clan']; }
	if ($top['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	$class=mysql_fetch_array(mysql_query("select ClassName from char_templates where ClassId=$top[classid]"));

	if ($top['online']) {$online='<font color=green>'.$Lang['online'].'</font>'; } 
	else {$online='<font color=red>'.$Lang['offline'].'</font>'; } 
	echo "<tr><td><b><center>$n</center></b></td><td><img src=\"./module/face/".$top['race']."_".$top['sex'].".gif\"></td><td><font color=\"$color\">$top[char_name]</font></td><td><center> $top[level]</center></td><td><center>$class[ClassName]</center></td><td><center><a href=index.php?id=stat&stat=clantop>$clan[clan_name]</a></center></td><td><center><b>$top[pvpkills]</b>/<b><font color=red>$top[pkkills]</font></b></center></td><td><center>$onlinetimeH {$Lang['hours']} $onlinetimeM {$Lang['min']}.</center></td><td>$online</td>";
	if($addcol && $addcolcont){echo $addcolcont;}elseif($addcol && !$addcolcont){echo('<td>'.$top[$stat].'</td>');}else{}
	echo('</tr>');
	$n++;
}

?>
</table>
<?php
}
foot();
mysql_close($link);
?>