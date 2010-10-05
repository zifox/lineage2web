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
$page='stat';
$par['lang']=getLang();
$par['stat']=$stat!=''?$stat:'home';
$par['page']=$start+1;
$sec=1800;
$params = implode(';', $par);
if($cache->needUpdate($page, $params, $sec))
{
    $content='';
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
$server_list = $mysql->query($q[2], array('db'=>$webdb));
while($slist = $mysql->fetch_array($server_list))
{
	$selected=($slist['ID']==$_GET['server'])?'selected="selected"':'';
	$parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat='.$_GET['stat'].'&amp;server='.$slist['ID'].'\')" '.$selected.'>'.$slist['Name'].'</option>';
}
$content .= $tpl->parsetemplate('stat_menu', $parse, 1);
unset($parse);
if(isset($_GET['server']) && is_numeric($_GET['server']))
{
	$server = 0 + $_GET['server'];
    $s_db = getDBName($server);
}else
{
	$server = 1;
	$s_db = $Config['DDB'];
}



switch($stat){
	
	case 'online':
	$data = $mysql->query($q[217], array('db'=>$s_db, 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
    $page_foot = $mysql->query($q[203], array('db'=>$s_db));
	$content.= '<h1>'.$Lang['online'].'</h1>';
	break;
    
    case 'castles':
    $result = $mysql->query("SELECT `id`, `name`, `taxPercent`, `siegeDate`, `charId`, `char_name`, `clan_id`, `clan_name` FROM `$s_db`.`castle` LEFT OUTER JOIN `$s_db`.`clan_data` ON `clan_data`.`hasCastle`=`castle`.`id` LEFT OUTER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

$r=0;
?><table border="0" cellpadding="3" cellspacing="3">
<?php
while($row = $mysql->fetch_array($result)){

if ($r==0){echo '<tr>';}
$r++;

?>
<td><table border="1"><tr><td class="noborder">
<h1><?php echo sprintf($Lang['castle_of'],$row['name'],'%s');?></h1><center>
<?php 
$ter = $mysql->query("SELECT `ownedWardIds` FROM `$s_db`.`territories` WHERE `castleId`='{$row['id']}'");
$ter_res = $mysql->result($ter);
if($ter_res!='')
{
	$wards=explode(';', $ter_res);
	foreach($wards as $key=>$value)
	{
		echo ' <img src="img/territories/'.$value.'.png" alt="'.$Lang['ward_info'][$value].'" title="'.$Lang['ward_info'][$value].'" /> ';
	}
}
else
{
	echo '<br />';
}
?></center><br />
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
<center>
<?php 
$ter = $mysql->query("SELECT `ownedWardIds` FROM `$s_db`.`territories` WHERE `fortId`='{$row['id']}'");

($mysql->num_rows($ter))?$ter_res = $mysql->result($ter):$ter_res = '';
if($ter_res!='')
{
	$wards=explode(';', $ter_res);
	foreach($wards as $key=>$value)
	{
		echo ' <img src="img/territories/'.$value.'.png" alt="'.$Lang['ward_info'][$value].'" title="'.$Lang['ward_info'][$value].'" /> ';
	}
}
else
{
	echo '<br />';
}
?></center><br />
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
    
	case 'clantop':
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
	
	case 'gm':
        $data = $mysql->query($q[216], array('db'=>$s_db, 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
       $page_foot = $mysql->query($q[212], array('db'=>$s_db));
	   $content.= '<h1>'.$Lang['gm'].'</h1>';
	break;
    
	case 'count':
        $data = $mysql->query($q[215], array('db'=>$s_db, 'item'=>'57', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[214], array('db'=>$s_db, 'item'=>'57'));
        $content.='<h1>'.$Lang['rich_players'].'</h1>';
        $addheader='<td><b>'.$Lang['adena'].'</b></td>';
        $addcol=true;
	break;
	
	case 'top_pvp';
        $data = $mysql->query($q[211], array('db'=>$s_db, 'order'=>'pvpkills', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[213], array('db'=>$s_db, 'order'=>'pvpkills'));
        $content.= '<h1>'.$Lang['pvp'].'</h1>';
	break;
	
	case 'top_pk':
        $data = $mysql->query($q[211], array('db'=>$s_db, 'order'=>'pkkills', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[213], array('db'=>$s_db, 'order'=>'pkkills'));
        $content.= '<h1>'.$Lang['pk'].'</h1>';
	break;
	
	case 'maxCp':
        $data = $mysql->query($q[210], array('db'=>$s_db, 'order'=>'maxCp', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[202], array('db'=>$s_db));
        $content.= '<h1>'.$Lang['cp'].'</h1>';
        $addheader='<td class="maxCp"><b>'.$Lang['max_cp'].'</b></td>';
        $addcol=true;
	break;
	
	case 'maxHp':
        $data = $mysql->query($q[210], array('db'=>$s_db, 'order'=>'maxHp', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[202], array('db'=>$s_db));
        $content.= '<h1>'.$Lang['hp'].'</h1>';
        $addheader='<td class="maxHp"><b>'.$Lang['max_hp'].'</b></td>';
        $addcol=true;
	break;
	
	case 'maxMp':
        $data = $mysql->query($q[210], array('db'=>$s_db, 'order'=>'maxMp', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[202], array('db'=>$s_db));
        $content.= '<h1>'.$Lang['mp'].'</h1>';
        $addheader='<td class="maxMp"><b>'.$Lang['max_mp'].'</b></td>';
        $addcol=true;
	break;
	
	case 'top':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'*', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot = $mysql->query($q[202], array('db'=>$s_db));
        $content.= '<h1>'.$Lang['top'].' '.$Config['TOP'].'</h1>';
	break;
	
	case 'human':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'0', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'0'));
        $content.= '<h1>'.$Lang['race'][0].'</h1>';
	break;
	
	case 'elf':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'1', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'1'));
        $content.= '<h1>'.$Lang['race'][1].'</h1>';
	break;
    
	case 'dark_elf':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'2', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'2'));
        $content.= '<h1>'.$Lang['race'][2].'</h1>';
	break;
	
	case 'orc':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'3', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'3'));
        $content.= '<h1>'.$Lang['race'][3].'</h1>';
	break;
	
	case 'dwarf':
        $data = $mysql->query($q[209], array('db'=>$s_db, 'race'=>'4', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'4'));
        $content.= '<h1>'.$Lang['race'][4].'</h1>';
	break;
	
	case 'kamael':
        $data=$mysql->query($q[209], array('db'=>$s_db, 'race'=>'5', 'limit'=>$startlimit, 'rows'=>$Config['TOP']));
        $page_foot=$mysql->query($q[208], array('db'=>$s_db, 'race'=>'5'));
        $content.= '<h1>'.$Lang['race'][5].'</h1>';
	break;
	
	default: 
    $parse = array();
    $parse['home']=$Lang['home'];
    $parse['male']=$Lang['male'];
    $parse['female']=$Lang['female'];
    $parse['seven_signs']=$Lang['seven_sins'];
$tchar=$mysql->result($mysql->query($q[202], Array('db'=>$s_db)));
$parse['race_rows']='';
for($i=0; $i<6; $i++)
{
	$sql = $mysql->query($q[208], array('db'=>$s_db, 'race'=>$i));
	$tfg = round($mysql->result($sql)/($tchar/100), 2);
	$parse['race_rows'].='<tr><td>'.$Lang['race'][$i].'</td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$tfg .'px" alt="" title="'.$tfg.'%" /> '.$tfg .'%</td></tr>';

}
$male = $mysql->query($q[205], array('db'=>$s_db, 'sex'=>'0'));
$parse['mc'] = round($mysql->result($male)/($tchar/100) , 2);
$female = $mysql->query($q[205], array('db'=>$s_db, 'sex'=>'1'));
$parse['fc'] = round($mysql->result($female)/($tchar/100) , 2);


$result1 = $mysql->query($q[206], array('db'=>$s_db, 'cabal'=>'%dusk%'));
$dawn =$mysql->result($result1);

$result2 = $mysql->query($q[206], array('db'=>$s_db, 'cabal'=>'%dawn%'));
$dusk = $mysql->result($result2);

$result3 = $mysql->query($q[207], array('db'=>$s_db));
$row=$mysql->fetch_array($result3);
$parse['twilScore'] = $row['avarice_dusk_score'] + $row['gnosis_dusk_score'] + $row['strife_dusk_score'];
$parse['dawnScore'] = $row['avarice_dawn_score'] + $row['gnosis_dawn_score'] + $row['strife_dawn_score'];
$parse['date']=date('m/d/Y H:i');
$parse['current_cycle']=$row['current_cycle'];
$parse['active_period']=$row['active_period'];
$parse['aowner']=$row['avarice_owner'];
$parse['gowner']=$row['gnosis_owner'];
$parse['sowner']=$row['strife_owner'];

//$totalScore = $twilScore + $dawnScore;

//$dawnPoint = ($totalScore == 0) ? 0 : round(($dawnScore / $totalScore) * 1000);
//$twilPoint = ($totalScore == 0) ? 0 : round(($twilScore / $totalScore) * 1000);



$content.=$tpl->parsetemplate('seven_signs', $parse, 1);

break;
}
if($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop'){

includeLang('user');
    $parse=array();
    $parse['place']=$Lang['place'];
    $parse['face']=$Lang['face'];
    $parse['name']=$Lang['name'];
    $parse['level']=$Lang['level'];
    $parse['class']=$Lang['class'];
    $parse['clan']=$Lang['clan'];
    $parse['pvp_pk']=$Lang['pvp_pk'];
    $parse['status']=$Lang['status'];
    $parse['addheader']=isset($addheader)?$addheader:'';
    $parse['char_rows']='';

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
	if ($top['clan_name']) { $clan_link='<a href="claninfo.php?clan='.$top['clanid'].'&amp;server='.$server.'">'.$top['clan_name'].'</a>'; }else{$clan_link='No Clan';}
	if ($top['sex']==0) { $color='#8080FF'; } else { $color='#FF8080'; }
	if ($top['online']) {$online='<font color="green">'.$Lang['online'].'</font>'; } 
	else {$online='<font color="red">'.$Lang['offline'].'</font>'; }
    $altrow=($n%2==0)? ' class="altRow"': '';
    $parse['char_rows'].='<tr'.$altrow.' onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="center"><b>'.$n.'</b></td><td><img src="./img/face/'.$top['race'].'_'.$top['sex'].'.gif" alt="" /></td><td><a href="user.php?cid='.$top['charId'].'&amp;server='.$server.'"><font color="'.$color.'"'.$top['char_name'].'</font></a></td><td><center> '.$top['level'].'</center></td><td><center>'.$top['ClassName'].'</center></td><td>'.$clan_link.'</td><td><center><b>'.$top['pvpkills'].'</b>/<b><font color="red">'.$top['pkkills'].'</font></b></center></td><td>'.$online.'</td>';

	if($addcol && $addcolcont){$parse['char_rows'].=$addcolcont;}elseif($addcol && !$addcolcont){$parse['char_rows'].='<td class="'.$stat.'">'.$top[$stat].'</td>';}else{}
	$parse['char_rows'].='</tr>';
	$n++;
}
$content.=$tpl->parsetemplate('stat', $parse, 1);

}
$content.= '<br />';
if($stat && $stat != 'castles' && $stat != 'fort'){
    $page_foot=$mysql->result($page_foot);
    $content.=pagechoose($start+1, $page_foot, $stat, $server);
}
$content.= '<br />';
$cache->updateCache($page, $params, $content);
echo $content;
}
else
{
    echo $cache->getCache($page, $params);
}
foot();
?>