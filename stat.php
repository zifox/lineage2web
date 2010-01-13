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
 | <a href="ss.php"><?php echo $Lang['seven_signs'];?></a> 
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
    $result = mysql_query("SELECT id, name, taxPercent, treasury, siegeDate, regTimeOver, regTimeEnd, showNpcCrest FROM castle ORDER by id ASC");

$r=0;
echo '<table border="0" style="border-color: #FFFFFF" cellpadding="3" cellspacing="3">';
while($row = mysql_fetch_array($result)){

if ($r==0){echo '<tr>'; $r++;}else{$r++;}
echo '<td><table border = "1"><tr><td class="noborder">';
echo '<h1>'.$row['name'].' Castle</h1>';
echo 'Next Siege: '.date('D j M Y H:i',$row['siegeDate']/1000);
echo '<br /><img src = "img/castle/'.$row['name'].'.png" width = "170"';

echo '<table border = "0" width = "170"><tr style="background-color: #2391ab;"><td>Castle</td><td>Details</td></tr>';
$owner = mysql_query("SELECT clan_data.clan_name FROM clan_data, castle WHERE clan_data.hasCastle=".$row['id']);
if(mysql_num_rows($owner))
{
    $owner = mysql_result($owner,0,0);
}else{$owner = 'No Owner';}
echo '<tr"><td>Owner Clan: </td><td>'.$owner.'</td></tr>';
echo '<tr><td>Tax: </td><td>'.$row['taxPercent'].'%</td></tr>';
echo '<tr><td>Attackers: </td><td>';
$result1 = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='{$row['id']}' AND type='1'");
while($row1=mysql_fetch_assoc($result1))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='{$row1['clan_id']}'");
while($row2=mysql_fetch_assoc($result2))
{
    echo '<a href="claninfo.php?clanid='.$row1['clan_id'].'">'.$row2['clan_name'].'</a><br />';
}
}
echo '</td></tr><tr><td>Defenders: </td><td>';
$result1 = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='{$row['id']}' AND type='0'") OR die('Mysql error');
if(mysql_num_rows($result1)==0)
{$mnr="0";}else{$mnr="1";}

while($row1=mysql_fetch_assoc($result1))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='{$row1['clan_id']}'") OR die('Mysql error');
while($row2=mysql_fetch_assoc($result2))
{
    echo '<a href="claninfo.php?clanid='.$row1['clan_id'].'">'.$row2['clan_name'].'</a><br /> ';
}
}

if($mnr=="0"){echo 'NPC';}
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
    Case 'ss': //NOTDONE
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
	$addheader='<td><b>Adena</b></td>';
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
	$addheader='<td><b>Max CP</b></td>';
	$addcol=true;
	break;
	
	Case 'maxHp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxHp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['hp'].'</h1>';
	$addheader='<td><b>Max HP</b></td>';
	$addcol=true;
	break;
	
	Case 'maxMp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxMp DESC LIMIT {$Config['TOP']}");
	echo '<h1>'.$Lang['mp'].'</h1>';
	$addheader='<td><b>Max MP</b></td>';
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

echo '<table border="0" width="90%"><tr><td><table border="1" width="90%">';
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
echo('<tr><td>Male<img src="module/stat/sex.jpg" /></td><td><img src="module/stat/sexline.jpg" height="10px" width="'.$mc .'"px" /> '.$mc .'%</td></tr>');
echo('<tr><td>Female<img src="module/stat/sex1.jpg" /></td><td><img src="module/stat/sexline.jpg" height="10px" width="'.$fc .'"px" /> '.$fc .'%</td></tr>');


echo ('</table></td><td><table border="1" width="90%">');
$dusk=mysql_num_rows(mysql_query('SELECT cabal FROM `seven_signs` WHERE `cabal` = \'dusk\''));
$dawn=mysql_num_rows(mysql_query('SELECT cabal FROM `seven_signs` WHERE `cabal` = \'dawn\''));
$total=$dusk+$dawn+1;
echo "<tr><td>Players for dusk: ".$dusk."</td>";
echo "<td><img src=\"module/stat/sexline.jpg\" height=\"10px\" width=\"".$dusk/$total*100 ."px\"> ".$dusk/$total*100 ."%</td></tr>";
echo "<tr><td>Players for dawn: " . $dawn . "</td>";
echo "<td><img src=\"module/stat/sexline.jpg\" height=\"10px\" width=\"".$dawn/$total*100 ."px\"> ".$dawn/$total*100 ."%</td></tr></table></td></tr></table>";

?>
<br />
<h1>Castles</h1>
<br /><hr />

<table width="90%" border="1"><tr><td width="20%"><b>Castle</b></td><td width="30%"><b>Owners</b></td><td width="35%"><b>Siege Date</b></td><td width="15%"><b>Tax Rate</b></td></tr>
<?php
$sql="SELECT * FROM `castle` ORDER BY `id` ASC LIMIT 10";
$result=mysql_query($sql);
while($row=mysql_fetch_assoc($result))
{
	$result2=mysql_query("SELECT clan_name FROM `clan_data` WHERE `hasCastle`='{$row['id']}'");
	If(!mysql_num_rows($result2)){$c_name="No Owner";}else{$c_name="<b>".mysql_result($result2, 0, 0)."</b>";}
	echo("<tr><td>". $row['name']."</td><td>".$c_name."</td><td>".date('D\, j M Y H\:i',$row['siegeDate']/1000)."</td><td>".$row['taxPercent']."%</td></tr>");

}
?>
</table>
<hr />
<?php
break;
}
if($stat && $stat != 'castles' && $stat != 'clantop' && $stat != 'ss'){
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