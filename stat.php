<?php
define('INWEB', True);
require_once ("include/config.php");
//пароль
includeLang('stat');
$stat = getVar('stat');
if(isset($_GET['page'])) {
	$start = getVar('page');
} else {
	$start = 1;
}
if(!is_numeric($start) || $start == 0) {
	$start = 1;
}
$start = abs($start) - 1;
$startlimit = $start * getConfig('settings', 'TOP', '10');

$head = $Lang['head_'.$stat];
if($head == '') {
	$head = $Lang['home'];
}
head("$head");
$par['lang'] = getLang();
$par['stat'] = $stat != ''?$stat:'home';
$par['page'] = $start + 1;
$par['server'] = getVar('server')!=''?getVar('server'):'1';
$params = implode(';', $par);
if($cache->needUpdate('stat', $params)) {
	$content = '';
	$parse = $Lang;
	$parse['human'] = $Lang['race'][0];
	$parse['elf'] = $Lang['race'][1];
	$parse['dark_elf'] = $Lang['race'][2];
	$parse['orc'] = $Lang['race'][3];
	$parse['dwarf'] = $Lang['race'][4];
	$parse['kamael'] = $Lang['race'][5];
	if(isset($_GET['server'])) {
		$parse['ID'] = "&amp;server=".getVar('server');
	}
	$parse['server_list'] = NULL;
	$server_list = $sql->query(2, array('db' => getConfig('settings', 'webdb', 'l2web')));
	while($slist = $sql->fetch_array($server_list)) {
		$selected = ($slist['ID'] == getVar('server'))?'selected="selected"':'';
		$parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat='.getVar('stat').
			'&amp;server='.$slist['ID'].'\')" '.$selected.'>'.$slist['Name'].'</option>';
	}
	$content .= $tpl->parsetemplate('stat_menu', $parse, 1);
	unset($parse);
	if(isset($_GET['server'])) {
		$server = getVar('server');
		$s_db = getDBName($server);
	} else {
		$server = 1;
		$s_db = getConfig('settings', 'DDB', 'l2jdb');
	}

	switch($stat) {

		case 'online':
			$data = $sql->query(217, array('db' => $s_db, 'limit' => $startlimit, 'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(203, array('db' => $s_db));
			$content .= '<h1>'.$Lang['online'].'</h1>';
			break;

		case 'castles':
			$result = $sql->query("SELECT `id`, `name`, `taxPercent`, `siegeDate`, `charId`, `char_name`, `clan_id`, `clan_name` FROM `$s_db`.`castle` LEFT OUTER JOIN `$s_db`.`clan_data` ON `clan_data`.`hasCastle`=`castle`.`id` LEFT OUTER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

			$r = 0;
            $content .='<table border="0" cellpadding="3" cellspacing="3">';
            while($row = $sql->fetch_array($result))
            {
                unset($rowparse);
                $rowparse=array();
                $rowparse['tr1']=($r==0)?'<tr>':'';
				$r++;
                $rowparse['castle_of_name'] = sprintf($Lang['castle_of'], $row['name'], '%s');
                $rowparse['ward_imgs']='';
                $ter = $sql->query("SELECT `ownedWardIds` FROM `$s_db`.`territories` WHERE `castleId`='{$row['id']}'");
				$ter_res = $sql->result($ter);
				if($ter_res != '') {
					$wards = explode(';', $ter_res);
					foreach($wards as $key => $value) {
						$rowparse['ward_imgs'] .='<img src="img/territories/'.$value.'.png" alt="'.$Lang['ward_info'][$value].'" title="'.$Lang['ward_info'][$value].'" />';
					}
				} else {
					$rowparse['ward_imgs'] .='<br />';
				}
                $rowparse['siege_date'] =$Lang['next_siege'].date('D j M Y H:i', $row['siegeDate'] / 1000);
                $rowparse['castle_name'] = $row['name'];
                $rowparse['castle'] = $Lang['castle'];
                $rowparse['details'] = $Lang['details'];
                $rowparse['owner_clan'] = $Lang['owner_clan'];
                $rowparse['owner_clan_leader'] = $Lang['lord'];                
                $rowparse['owner_clan_link']=($row['clan_id'])?'<a href="claninfo.php?clan='.$row['clan_id'].'">'.$row['clan_name'].'</a>':$Lang['no_owner'];
                $rowparse['owner_clan_leader_link']=($row['charId'])?'<a href="user.php?cid='.$row['charId'].'">'.$row['char_name'].'</a>':$Lang['no_lord'];
                $rowparse['tax'] = $Lang['tax'];
                $rowparse['tax_percent']=$row['taxPercent'];
                $rowparse['attackers']=$Lang['attackers'];
                $rowparse['attackers_link']='';
                $result1 = $sql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`siege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `castle_id`='{$row['id']}' AND `type`='1'");
				while($attackers = $sql->fetch_array($result1)) {
					$rowparse['attackers_link'].='<a href="claninfo.php?clanid='.$attackers['clan_id'].'">'.$attackers['clan_name'].
						'</a><br />';
				}
                $rowparse['defenders']=$Lang['defenders'];
                $rowparse['defenders_link']='';
                $result2 = $sql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`siege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `castle_id`='{$row['id']}' AND `type`='0'");
				if($sql->num_rows($result2)) {
					while($defenders = $sql->fetch_array($result2)) {
						$rowparse['defenders_link'] .='<a href="claninfo.php?clanid='.$defenders['clan_id'].'">'.$defenders['clan_name'].
							'</a><br /> ';
					}
				}
                else
                {
					$rowparse['defenders_link'] .=$Lang['npc'];
                }

                if($r==3)
                {
                    $rowparse['tr2']='</tr>';
                    $r=0;
                }
                $content.=$tpl->parsetemplate('stat_castles', $rowparse,1);
			} 
            $content .="</table>";
            
            break;

		case 'fort':
			$result = $sql->query("SELECT `id`, `name`, `lastOwnedTime`, `clan_id`, `clan_name`, `char_name` FROM `$s_db`.`fort` LEFT OUTER JOIN `$s_db`.`clan_data` ON `clan_data`.`clan_id`=`fort`.`owner` LEFT OUTER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` ORDER by `id` ASC");

			$r = 0; 
            
            $content.='<table border="0" cellpadding="3" cellspacing="3">';
            while($row = $sql->fetch_array($result)) {

                unset($rowparse);
                $rowparse=array();
                $rowparse['tr1']=($r==0)?'<tr>':'';
				$r++;
                $rowparse['fort_of_name'] = sprintf($Lang['fort_of'], $row['name'], '%s');
                $rowparse['ward_imgs']='';
                $ter = $sql->query("SELECT `ownedWardIds` FROM `$s_db`.`territories` WHERE `fortId`='{$row['id']}'");

				($sql->num_rows($ter))?$ter_res = $sql->result($ter):$ter_res = '';
				if($ter_res != '') {
					$wards = explode(';', $ter_res);
					foreach($wards as $key => $value) {
						$rowparse['ward_imgs'] .='<img src="img/territories/'.$value.'.png" alt="'.$Lang['ward_info'][$value].'" title="'.$Lang['ward_info'][$value].'" /> ';
					}
				} else {
					$rowparse['ward_imgs'] .='<br />';
				} 
                $rowparse['id']=$row['id'];
                
                $rowparse['fort_name'] = $row['name'];
                $rowparse['fort'] = $Lang['fort'];
                $rowparse['details'] = $Lang['details'];
                $rowparse['owner_clan'] = $Lang['owner_clan'];
                $rowparse['lord'] = $Lang['lord'];                
                $rowparse['owner_link']=($row['clan_id'])?'<a href="claninfo.php?clan='.$row['clan_id'].'">'.$row['clan_name'].'</a>':$Lang['no_owner'];
                $rowparse['lord_link']=($row['charId'])?'<a href="user.php?cid='.$row['charId'].'">'.$row['char_name'].'</a>':$Lang['no_lord'];
                $rowparse['tax'] = $Lang['tax'];
                $rowparse['tax_percent']=$row['taxPercent'];
                $rowparse['attackers']=$Lang['attackers'];
                $rowparse['attackers_link']='';
                $rowparse['time_held']=$Lang['time_held'];
                $result1 = $sql->query("SELECT `clan_id`, `clan_name` FROM `$s_db`.`fortsiege_clans` INNER JOIN `clan_data` USING (`clan_id`)  WHERE `fort_id`='{$row['id']}'");
				while($attackers = $sql->fetch_array($result1)) {
					$rowparse['attackers_link'].='<a href="claninfo.php?clanid='.$attackers['clan_id'].'">'.$attackers['clan_name'].'</a><br />';
				} 
                if($row['lastOwnedTime']) {
					$timeheld = time() - $row['lastOwnedTime'] / 1000;
					$timehour = round($timeheld / 60 / 60);
				} else {
					$timehour = 0;
				}
                $rowparse['fort_hold_time']=$timehour.' '.$Lang['hours'];
                if($r==3)
                {
                    $rowparse['tr2']='</tr>';
                    $r=0;
                }
                $content.=$tpl->parsetemplate('stat_forts', $rowparse,1);
			}
            $content.='</table>';
            break;

		case 'clantop':
			$result = $sql->query("SELECT `clan_id`, `clan_name`, `clan_level`, `reputation_score`, `hasCastle`, `ally_id`, `ally_name`, `charId`, `char_name`, `ccount`, `name` FROM `$s_db`.`clan_data` INNER JOIN `$s_db`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` LEFT JOIN (SELECT clanid, count(`level`) AS `ccount` FROM `$s_db`.`characters` WHERE `clanid` GROUP BY `clanid`) AS `levels` ON `clan_data`.`clan_id`=`levels`.`clanid` LEFT OUTER JOIN `$s_db`.`castle` ON `clan_data`.`hasCastle`=`castle`.`id` WHERE `characters`.`accessLevel`='0' ORDER BY `clan_level` DESC, `reputation_score` DESC LIMIT $startlimit, ".getConfig('settings','TOP','10').";");
			$page_foot = $sql->query("SELECT count(`clan_id`) FROM `$s_db`.`clan_data`, `$s_db`.`characters` WHERE `clan_data`.`leader_id`=`characters`.`charId` AND `characters`.`accessLevel`='0'");
			$content .= "<h1> TOP Clans </h1><hr />";
			$content .= "<h2>{$Lang["clantop_total"]}: ".$sql->result($page_foot)."</h2>";
			$content .= "<table border=\"1\" align=\"center\"><thead><tr style=\"color: green;\"><th><b>Clan Name</b></th>";
			$content .= "<th><b>Leader</b></th>";
			$content .= "<th><b>Level</b></th>";
			$content .= "<th><b>Reputation</b></th>";
			$content .= "<th><b>Castle</b></th>";
			$content .= "<th><b>Members</b></th>";
			$content .= "</tr></thead>";
			$content .= "<tbody>";

			$i = 1;
			while($row = $sql->fetch_array($result)) {
				if($row['hasCastle'] != 0) {
					$castle = $row['name'];
				} else {
					$castle = 'No castle';
				}
				$content .= "<tr".(($i++ % 2)?"":" class=\"altRow\"")." onmouseover=\"this.bgColor = '#505050';\" onmouseout=\"this.bgColor = ''\"><td><a href=\"claninfo.php?clan=".
					$row["clan_id"]."&server=$server \">".$row["clan_name"]."</a></td><td><a href=\"user.php?cid={$row['charId']}&server=$server \">".
					$row["char_name"]."</a></td><td class=\"numeric sortedColumn\">".$row["clan_level"].
					"</td><td>{$row['reputation_score']}</td><td>".$castle."</td><td class=\"numeric\">".
					$row["ccount"]."</td></tr>";
			}
			$content .= "</tbody></table>";
			break;

		case 'gm':
			$data = $sql->query(216, array('db' => $s_db, 'limit' => $startlimit, 'rows' =>
				getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(212, array('db' => $s_db));
			$content .= '<h1>'.$Lang['gm'].'</h1>';
			break;

		case 'count':
			$data = $sql->query(215, array('db' => $s_db, 'item' => '57', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(214, array('db' => $s_db, 'item' => '57'));
			$content .= '<h1>'.$Lang['rich_players'].'</h1>';
			$addheader = '<td><b>'.$Lang['adena'].'</b></td>';
			$addcol = true;
			break;

		case 'top_pvp';
			$data = $sql->query(211, array('db' => $s_db, 'order' => 'pvpkills', 'limit' =>
				$startlimit, 'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(213, array('db' => $s_db, 'order' => 'pvpkills'));
			$content .= '<h1>'.$Lang['pvp'].'</h1>';
			break;

		case 'top_pk':
			$data = $sql->query(211, array('db' => $s_db, 'order' => 'pkkills', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(213, array('db' => $s_db, 'order' => 'pkkills'));
			$content .= '<h1>'.$Lang['pk'].'</h1>';
			break;

		case 'maxCp':
			$data = $sql->query(210, array('db' => $s_db, 'order' => 'maxCp', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(202, array('db' => $s_db));
			$content .= '<h1>'.$Lang['cp'].'</h1>';
			$addheader = '<td class="maxCp"><b>'.$Lang['max_cp'].'</b></td>';
			$addcol = true;
			break;

		case 'maxHp':
			$data = $sql->query(210, array('db' => $s_db, 'order' => 'maxHp', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(202, array('db' => $s_db));
			$content .= '<h1>'.$Lang['hp'].'</h1>';
			$addheader = '<td class="maxHp"><b>'.$Lang['max_hp'].'</b></td>';
			$addcol = true;
			break;

		case 'maxMp':
			$data = $sql->query(210, array('db' => $s_db, 'order' => 'maxMp', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(202, array('db' => $s_db));
			$content .= '<h1>'.$Lang['mp'].'</h1>';
			$addheader = '<td class="maxMp"><b>'.$Lang['max_mp'].'</b></td>';
			$addcol = true;
			break;

		case 'top':
			$data = $sql->query(218, array('db' => $s_db, 'race' => '*', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(202, array('db' => $s_db));
			$content .= '<h1>'.$Lang['top'].' '.getConfig('settings', 'TOP', '10').'</h1>';
			break;

		case 'human':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '0', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '0'));
			$content .= '<h1>'.$Lang['race'][0].'</h1>';
			break;

		case 'elf':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '1', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '1'));
			$content .= '<h1>'.$Lang['race'][1].'</h1>';
			break;

		case 'dark_elf':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '2', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '2'));
			$content .= '<h1>'.$Lang['race'][2].'</h1>';
			break;

		case 'orc':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '3', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '3'));
			$content .= '<h1>'.$Lang['race'][3].'</h1>';
			break;

		case 'dwarf':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '4', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '4'));
			$content .= '<h1>'.$Lang['race'][4].'</h1>';
			break;

		case 'kamael':
			$data = $sql->query(209, array('db' => $s_db, 'race' => '5', 'limit' => $startlimit,
				'rows' => getConfig('settings', 'TOP', '10')));
			$page_foot = $sql->query(208, array('db' => $s_db, 'race' => '5'));
			$content .= '<h1>'.$Lang['race'][5].'</h1>';
			break;

		default:
			$parse = array();
			$parse['home'] = $Lang['home'];
			$parse['male'] = $Lang['male'];
			$parse['female'] = $Lang['female'];
			$parse['seven_signs'] = $Lang['seven_sins'];
			$tchar = $sql->result($sql->query(202, array('db' => $s_db)), 0, 0);
			$parse['race_rows'] = '';
			for($i = 0; $i < 6; $i++) {
				$sqlq = $sql->query(208, array('db' => $s_db, 'race' => $i));
				$tfg = round($sql->result($sqlq) / ($tchar / 100), 2);
				$parse['race_rows'] .= '<tr><td>'.$Lang['race'][$i].
					'</td><td><img src="img/stat/sexline.jpg" height="10px" width="'.$tfg.
					'px" alt="" title="'.$tfg.'%" /> '.$tfg.'%</td></tr>';

			}
			$male = $sql->query(205, array('db' => $s_db, 'sex' => '0'));
			$parse['mc'] = round($sql->result($male) / ($tchar / 100), 2);
			$female = $sql->query(205, array('db' => $s_db, 'sex' => '1'));
			$parse['fc'] = round($sql->result($female) / ($tchar / 100), 2);

			$result1 = $sql->query(206, array('db' => $s_db, 'cabal' => '%dusk%'));
			$dawn = $sql->result($result1);

			$result2 = $sql->query(206, array('db' => $s_db, 'cabal' => '%dawn%'));
			$dusk = $sql->result($result2);

			$result3 = $sql->query(207, array('db' => $s_db));
			$row = $sql->fetch_array($result3);
			$parse['twilScore'] = $row['avarice_dusk_score'] + $row['gnosis_dusk_score'] + $row['strife_dusk_score'];
			$parse['dawnScore'] = $row['avarice_dawn_score'] + $row['gnosis_dawn_score'] + $row['strife_dawn_score'];
			$parse['date'] = date('m/d/Y H:i');
			$parse['current_cycle'] = $row['current_cycle'];
			$parse['active_period'] = $row['active_period'];
			$parse['aowner'] = $row['avarice_owner'];
			$parse['gowner'] = $row['gnosis_owner'];
			$parse['sowner'] = $row['strife_owner'];

			$content .= $tpl->parsetemplate('seven_signs', $parse, 1);

			break;
	}
	if($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop') {

		includeLang('user');
		$parse = array();
		$parse['place'] = $Lang['place'];
		$parse['face'] = $Lang['face'];
		$parse['name'] = $Lang['name'];
		$parse['level'] = $Lang['level'];
		$parse['class'] = $Lang['class'];
		$parse['clan'] = $Lang['clan'];
		$parse['pvp_pk'] = $Lang['pvp_pk'];
		$parse['status'] = $Lang['status'];
		$parse['addheader'] = isset($addheader)?$addheader:'';
		$parse['char_rows'] = '';

		if($startlimit != 0 || $startlimit != null) {
			$n = $startlimit + 1;
		} else {
			$n = 1;
		}
		while($top = $sql->fetch_array($data)) {
			if($top['clan_name']) {
				$clan_link = '<a href="claninfo.php?clan='.$top['clanid'].'&amp;server='.$server.
					'">'.$top['clan_name'].'</a>';
			} else {
				$clan_link = 'No Clan';
			}
			if($top['sex'] == 0) {
				$color = '#8080FF';
			} else {
				$color = '#FF8080';
			}
			if($top['online'] != 0) {
				$online = '<font color="green">'.$Lang['online'].'</font>';
			} else {
				$online = '<font color="red">'.$Lang['offline'].'</font>';
			}
			$altrow = ($n % 2 == 0)?' class="altRow"':'';
			$parse['char_rows'] .= '<tr'.$altrow.' onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="center"><b>'.
				$n.'</b></td><td><img src="./img/face/'.$top['race'].'_'.$top['sex'].
				'.gif" alt="" /></td><td><a href="user.php?cid='.$top['charId'].'&amp;server='.
				$server.'"><font color="'.$color.'">'.$top['char_name'].
				'</font></a></td><td><center> '.$top['level'].'</center></td><td><center>'.$top['ClassName'].
				'</center></td><td>'.$clan_link.'</td><td><center><b>'.$top['pvpkills'].
				'</b>/<b><font color="red">'.$top['pkkills'].'</font></b></center></td><td>'.$online.
				'</td>';

			if($addcol && $addcolcont) {
				$parse['char_rows'] .= $addcolcont;
			} elseif($addcol && !$addcolcont) {
				$parse['char_rows'] .= '<td class="'.$stat.'">'.$top[$stat].'</td>';
			} else {
			}
			$parse['char_rows'] .= '</tr>';
			$n++;
		}
		$content .= $tpl->parsetemplate('stat', $parse, 1);

	}
	$content .= '<br />';
	if($stat && $stat != 'castles' && $stat != 'fort') {
		$page_foot = $sql->result($page_foot);
		$content .= pagechoose($start + 1, $page_foot, $stat, $server);
	}
	$content .= '<br />';
	$cache->updateCache('stat', $content, $params);
	echo $content;
} else {
	echo $cache->getCache('stat', $params);
}
foot();
?>