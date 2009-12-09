<?php
include_once('module/stat-menu.php');
includeLang('module');


$stat = mysql_real_escape_string($_GET['stat']);

switch($stat){
	
	Case 'online':
	$data=mysql_query ("SELECT * FROM characters WHERE online and !accesslevel ORDER BY exp DESC");
	echo '<br><center><b>'.$Lang['online_users'].'</b></center><br><hr>';
	break;
	
	Case 'clantop':
	
	break;
	
	Case 'gm':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel>0 ORDER BY accesslevel DESC");
	echo '<br><center><b>..:: GameMasters List ::..</b></center><br><hr>';
	$addheader='<td><b>Send Message</b></td>';
	$addcol=true;
	$addcolcont='<td><a href=index.php?id=msg>Message</a></td>';
	break;
	Case 'count':
	$data = mysql_query("SELECT `characters`.`char_name`, `characters`.`sex`, `characters`.`pvpkills`, `characters`.`pkkills`, `characters`.`race`, `characters`.`classid`, `characters`.`base_class`, `characters`.`onlinetime`, `characters`.`online`, `characters`.`level`, `characters`.`clanid`, `items`.`count` FROM characters, items WHERE items.item_id = '57' AND characters.charId = items.owner_id AND characters.accesslevel=0 ORDER BY items.count DESC LIMIT {$Config['TOP']}");
	echo'<br><b><center><b>..:: Rich Players ::..</b></center></b><br><hr>';
	$addheader='<td><b>Adena</b></td>';
	$addcol=true;
	break;
	
	Case 'top_pvp';
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel AND pvpkills>0 ORDER BY pvpkills DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP PVP ::..</b></center><br><hr>';
	break;
	
	Case 'top_pk':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel=0 AND pkkills>0 ORDER BY pkkills DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP PK ::..</b></center><br><hr>';
	break;
	
	Case 'top_time':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY onlinetime DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP Activity ::..</b></center><br><hr>';
	break;
	
	Case 'maxCp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxCp DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP CP ::..</b></center><br><hr>';
	$addheader='<td><b>Max CP</b></td>';
	$addcol=true;
	break;
	
	Case 'maxHp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxHp DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP HP ::..</b></center><br><hr>';
	$addheader='<td><b>Max HP</b></td>';
	$addcol=true;
	break;
	
	Case 'maxMp':
	$data=mysql_query("SELECT * FROM characters WHERE !accesslevel ORDER BY maxMp DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>..:: TOP MP ::..</b></center><br><hr>';
	$addheader='<td><b>Max MP</b></td>';
	$addcol=true;
	break;
	
	Case 'top':
	$data=mysql_query("SELECT * FROM characters WHERE accesslevel=0  ORDER BY  level  DESC LIMIT {$Config['TOP']} ");
	echo '<br><center><b>'.$Lang['top_players'].'</b></center><br><hr>';
	break;
	
	Case 'human':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=0 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>'.$Lang['top_humans'].'</b></center><br><hr>';
	break;
	
	Case 'elf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=1 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");

	echo '<br><center><b>'.$Lang['top_elfs'].'</b></center><br><hr>';
	break;
	
	Case 'dark_elf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=2 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>'.$Lang['top_delfs'].'</b></center><br><hr>';
	break;
	
	Case 'orc':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=3 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>'.$Lang['top_orcs'].'</b></center><br><hr>';
	break;
	
	Case 'dwarf':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=4 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>'.$Lang['top_kamaels'].'</b></center><br><hr>';
	break;
	
	Case 'kamael':
	$data=mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE !accesslevel AND race=5 AND char_templates.ClassId=characters.classid ORDER BY level DESC LIMIT {$Config['TOP']}");
	echo '<br><center><b>'.$Lang['top_kamaels'].'</b></center><br><hr>';
	break;
	
	Default: ?>
<b><center>..:: For all ::..</center></b><br /> 
<?php 
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
<b><center>..:: Castles ::..</center></b>
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
if($stat){
includeLang('table');
echo '<table border="1"><tr><td>'.$Lang['place'].'</td><td>'.$Lang['face'].'</td><td><center>'.$Lang['nick'].'</center></td><td>'.$Lang['level'].'</td><td><center>'.$Lang['proffesion'].'</center></td><td><center>'.$Lang['clan'].'</center></td><td>'.$Lang['pvp_pk'].'</td><td><center>'.$Lang['time_in_game'].'</center></td><td>'.$Lang['status'].'</td>'.$addheader.'</tr>';

/* $result2 = mysql_query("SELECT clan_id,clan_name FROM clan_data");
  while ($row2=mysql_fetch_row($result2))
    $clans_array[$row2[0]]=$row2[1];
  $clans_array[0]=""; */
$n=1;
while ($top=mysql_fetch_array($data))
{
	$onlinetimeH=round(($top['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($top['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
	$clan=mysql_fetch_array(mysql_query("select clan_name from clan_data where clan_id=$top[clanid]"));
	if ($clan['clan_name']=='') { $clan['clan_name']="No Clan"; }
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
</table> <?php }
//}else{
//echo"<h1>{$Lang['selectserv2']}</h1>";}
?>