<?php
if(!defined('INCONFIG'))
{
	header("Location: ../index.php");
	die();
}
includeLang('functions');

function includeLang($file)
{
	global $langName, $Lang;
	$langName = getLangName();
	define('INLANG', true);
	if(file_exists('lang/' . $langName . '/' . $file . '.php'))
	{
		require_once ("lang/{$langName}/{$file}.php");
	}
}
function getLangName()
{
	switch (isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 2)
	{
		case 1:
			return 'lv';
			break;
		case 2:
			return 'en';
			break;
		case 3:
			return 'ru';
			break;
	}
}
function includeBlock($file, $blockTitle = 'Menu', $frame = true, $return = false)
{
	global $sql, $user, $tpl, $cache, $q, $langPath, $Lang, $content, $webdb;
	define('IN_BLOCK', true);
	$imgLink = 'skins/'.selectSkin();
	$cnt = '';
	if($frame)
	{
		$parse['blockTitle']=$blockTitle;
		$parse2=$parse;
		$cnt.=$tpl->parseTemplate('blocks/block_t', $parse,true);
	}

	if(file_exists('blocks/' . $file . '.php'))
	{
		includeLang('blocks/' . $file);
		require_once ('blocks/' . $file . '.php');
		$cnt .= $content;
	}
	else
		$cnt .= msg('Error', 'Failed to get block ' . $file, 'error', 1);
	if($frame)
	{
		$cnt.=$tpl->parseTemplate('blocks/block_b', $parse2,true);
	}
	if($return)
		return $cnt;
	else
		echo $cnt;
}

function msg($heading = '', $text = '', $div = 'success', $return = false)
{
	$content = '';
	$content .= '<table width="90%" border="0"><tr><td>';
	$content .= '<div align="center" class="' . $div . '">' . ($heading ? '<b>' . $heading . '</b><br />' : '') . $text . '</div></td></tr></table>';
	if($return)
		return $content;
	else
		echo $content;
}

function head($title = "", $head = true, $url = '', $time = 0)
{
	global $user, $sql, $tpl, $cache, $Lang;
	DEFINE('INSKIN', true);
	$title = getConfig('head', 'title', 'Lineage II Fantasy World') . " :: " . $title;
	
	require_once ("skins/" . selectSkin() . "/head.php");
}

function foot($foot = true)
{
	global $user, $sql, $tpl, $cache, $startTime, $Lang;
	require_once ("skins/" . selectSkin() . "/foot.php");
}
function button($text = '  ', $name = 'Submit', $return = true, $disabled = false, $id = null)
{
	global $tpl;
	$parse['text'] = $text;
	$parse['name'] = $name;
	if($id == null)
	{
		$parse['id'] = "bt_" . rand(20, 99);
	}
	else
	{
		$parse['id'] = $id;
	}
	if($disabled)
		$parse['disabled'] = 'disabled="disabled"';
	return $tpl->parseTemplate('button', $parse, $return);
}
function menuButton($text)
{
	return '<img src="./button.php?text=' . $text . '" title="' . $text . '" alt="' . $text . '" border="0" width="138" height="34" />';
}
function prettyTime($seconds)
{
	$day = floor($seconds / (24 * 3600));
	$hs = floor($seconds / 3600 % 24);
	$ms = floor($seconds / 60 % 60);
	$sr = floor($seconds / 1 % 60);

	if($hs < 10)
	{
		$hh = "0" . $hs;
	}
	else
	{
		$hh = $hs;
	}
	if($ms < 10)
	{
		$mm = "0" . $ms;
	}
	else
	{
		$mm = $ms;
	}
	if($sr < 10)
	{
		$ss = "0" . $sr;
	}
	else
	{
		$ss = $sr;
	}

	$time = '';
	if($day != 0)
	{
		$time .= $day . 'd ';
	}
	if($hs != 0)
	{
		$time .= $hh . 's ';
	}
	else
	{
		$time .= '00s ';
	}
	if($ms != 0)
	{
		$time .= $mm . 'm ';
	}
	else
	{
		$time .= '00m ';
	}
	$time .= $ss . 's';

	return $time;
}

function prettyTimeHour($seconds)
{
	$min = floor($seconds / 60 % 60);

	$time = '';
	if($min != 0)
	{
		$time .= $min . 'min ';
	}

	return $time;
}

function getDBName($id)
{
	global $sql, $webdb;
	if(is_numeric($id))
	{
		$srv = $sql->escape(0 + $id);
		$srvqry = $sql->query("SELECT `database` FROM `$webdb`.`gameservers` WHERE `id` = '$srv'");
		if($sql->numRows())
		{
			return $sql->result($srvqry);
		}
	}
	return getConfig('settings', 'ddb', 'l2jgs');
}
function getDBInfo($id)
{
	global $sql, $webdb;
	if(is_numeric($id))
	{
		$id = val_int($id);
		if($id)
		{
			$srvqry = $sql->query("SELECT `id`, `name`, `database` FROM `{webdb}`.`gameservers` WHERE `id` = '{id}' AND `active`='true'", array('webdb' => $webdb, 'id' => $id));
		}
	}
	else
	{
		$id = val_string($id);
		if($id)
		{
			$srvqry = $sql->query("SELECT `id`, `name`, `database` FROM `{webdb}`.`gameservers` WHERE `database` = '{db}' AND `active`='true'", array('webdb' => $webdb, 'db' => $id));

		}
	}
	if($sql->numRows())
	{
		return $sql->fetchArray($srvqry);
	}
	msg(getLang('error'), getLang('incorrect_database'),'error');
}

function pageChoose($page, $count = 0, $stat, $server)
{
	$top = getConfig('settings', 'top', '10');
	$content = null;
	$content .= '<div class="page-choose" align="center"><br /><table align="center"><tr>';

	$totalpages = ceil($count / $top);
	if($totalpages == 0)
	{
		$totalpages++;
	}
	if($page > 3)
	{
		$content .= '<td><a href="stat.php?stat='.$stat.'&amp;server='.$server.'&amp;page=1" title="'.getLang('first').'"  class="btn"> &laquo; </a></td>';
	}
	if($page > 1)
	{
		$content .= '<td><a href="stat.php?stat='.$stat.'&amp;server='.$server.'&amp;page="';
		$content .= '' . $page - 1;
		$content .= '" title="'.getLang('prev').'" class="btn"> &lt; </a></td>';
	}
	if($page - 2 > 0)
	{
		$start = $page - 2;
	}
	else
	{
		$start = 1;
	}
	for ($i = $start; $i <= $totalpages && $i <= $page + 2; $i++)
	{

		if($i == $page)
		{
			$content .= '<td>&nbsp;&nbsp;<a href="#" class="btn brown" title="';
			$content .= ' [';
			$content .= ($count != 0) ? $i * $top + 1 - $top : 0;
			$content .= ' - ';
			$content .= ($i * $top > $count) ? $count : $i * $top;
			$content .= ']"> ';
			$content .= $i;
			$content .= ' </a>&nbsp;&nbsp;</td>';
		}
		else
		{
			$content .= '<td>&nbsp;&nbsp;<a href="stat.php?stat=' . $stat;
			$content .= '&amp;server=' . $server;
			$content .= '&amp;page=' . $i;
			$content .= '" title="[';
			$content .= ($count != 0) ? $i * $top + 1 - $top : 0;
			$content .= ' - ';
			$content .= ($i * $top > $count) ? $count : $i * $top;
			$content .= ']" class="btn"> ';
			$content .= $i;
			$content .= ' </a>&nbsp;&nbsp;</td>';
		}

	}
	if($totalpages > $page)
	{

		$content .= '<td><a href="stat.php?stat='.$stat.'&amp;server='.$server.'&amp;page=';
		$content .= $page + 1;
		$content .= '" title="'.getLang('next').'" class="btn"> &gt; </a></td>';
	}
	if($totalpages > $page + 2)
	{
		$content .= '<td><a href="stat.php?stat='.$stat.'&amp;server='.$server.'&amp;page=';
		$content .= $totalpages;
		$content .= '" title="'.getLang('last').'" class="btn"> &raquo; </a></td>';
	}

	$content .= '</tr></table>&nbsp;</div>';
	return $content;

}
function page($page, $count = 0, $link, $server)
{
	$top = getConfig('settings', 'top', '10');
	$content = null;
	$content .= '<div class="page-choose" align="center"><br /><table align="center"><tr>';
	$ps = "?";
	$lnkquest = stripos($link, "?");
	if($lnkquest !== false)
	{
		$ss = '&amp;';
		$ps = '&amp;';
	}
	else
	{
		$ss = "?";
	}
	if($server != '')
	{
		$server = $ss . 'server='.$server;
		$ps = '&amp;';

	}
	$totalpages = ceil($count / $top);
	if($totalpages == 0)
	{
		$totalpages++;
	}
	if($page == 0)
		$page = 1;
	if($page > 3)
	{
		$content .= '<td><a href="'.$link.$server.$ps.'page=1" title="'.getLang('first').'"  class="btn"> &laquo; </a></td>';
	}
	if($page > 1)
	{
		$content .= '<td><a href="'.$link.$server.$ps.'page="';
		$content .= $page - 1;
		$content .= '" title="'.getLang('prev').'" class="btn"> &lt; </a></td>';
	}
	if($page - 2 > 0)
	{
		$start = $page - 2;
	}
	else
	{
		$start = 1;
	}
	for ($i = $start; $i <= $totalpages && $i <= $page + 2; $i++)
	{

		if($i == $page)
		{
			$content .= '<td>&nbsp;&nbsp;<a href="#" class="btn brown" title="';
			$content .= ' [';
			$content .= ($count != 0) ? $i * $top + 1 - $top : 0;
			$content .= ' - ';
			$content .= ($i * $top > $count) ? $count : $i * $top;
			$content .= ']"> ';
			$content .= $i;
			$content .= ' </a>&nbsp;&nbsp;</td>';
		}
		else
		{
			$content .= '<td>&nbsp;&nbsp;<a href="' . $link . $server . $ps;
			$content .= 'page=' . $i;
			$content .= '" title="[';
			$content .= ($count != 0) ? $i * $top + 1 - $top : 0;
			$content .= ' - ';
			$content .= ($i * $top > $count) ? $count : $i * $top;
			$content .= ']" class="btn"> ';
			$content .= $i;
			$content .= ' </a>&nbsp;&nbsp;</td>';
		}

	}
	if($totalpages > $page)
	{

		$content .= '<td><a href="'.$link.$server.$ps.'page=';
		$content .= $page + 1;
		$content .= '" title="'.getLang('next').'" class="btn"> &gt; </a></td>';

	}
	if($totalpages > $page + 2)
	{

		$content .= '<td><a href="'.$link.$server.$ps.'page=';
		$content .= $totalpages;
		$content .= '" title="'.getLang('next').'" class="btn"> &raquo; </a></td>';

	}

	$content .= '</tr></table>&nbsp;</div>';
	return $content;

}
function convertPic($id, $ext, $width, $height)
{
	if(file_exists('news/' . $id . '_thumb.' . $ext))
		unlink('news/' . $id . '_thumb.' . $ext);
	$new_img = 'news/' . $id . '_thumb.' . $ext;

	$file_src = 'news/'.$id.$ext;

	list($w_src, $h_src, $type) = getimagesize($file_src);
	$ratio = $w_src / $h_src;
	if($width / $height > $ratio)
	{
		$width = floor($height * $ratio);
	}
	else
	{
		$height = floor($width / $ratio);
	}

	switch ($type)
	{
		case 1: //   gif -> jpg
			$img_src = imagecreatefromgif($file_src);
			break;
		case 2: //   jpeg -> jpg
			$img_src = imagecreatefromjpeg($file_src);
			break;
		case 3: //   png -> jpg
			$img_src = imagecreatefrompng($file_src);
			break;
	}
	$img_dst = imagecreatetruecolor($width, $height); //  resample
	//$img_dst = imagecreate($width, $height);  //  resample
	imageantialias($img_dst, true);
	imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width, $height, $w_src, $h_src);
	switch ($type)
	{
		case 1:
			imagegif($img_dst, $new_img);
			break;
		case 2:
			imagejpeg($img_dst, $new_img);
			break;
		case 3:
			imagepng($img_dst, $new_img);
			break;
	}
	imagedestroy($img_src);
	imagedestroy($img_dst);
}

function InsertItem($itemId, $count, $loc, $charId)
{
	global $sql;
	$query = $sql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
	if($sql->numRows())
	{
		$before = $sql->result($query, 0, 1);
		$sql->query("UPDATE `items` SET `count` = `count` + '$count' WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
	}
	else
	{
		$before = 0;
		$maxloc = $sql->query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$charId' AND `items`.`loc` = '$loc'");
		$itemloc = $sql->result($maxloc) + 1;
		$sql->query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`) VALUES ('$charId','$itemId','$count','$loc','$itemloc')");
	}
	$check = $sql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
	if(!$sql->numRows())
		return false;
	if($before + $count == $sql->result($check, 0, 1))
		return true;
	return false;
}

function valInt($string, $default = 0, $min = 0, $max = 999999999)
{
	$options = array('options' => array(
			'default' => $default,
			'min_range' => $min,
			'max_range' => $max), );
	$int = filter_var($string, FILTER_VALIDATE_INT, $options);
	return $int;
}
function valString($string)
{
	global $sql;
	if(!is_array($string))
		$string = trim(htmlentities(str_replace(array(
			"\r\n",
			"\r",
			"\0"), array(
			"\n",
			"\n",
			''), $sql->escape($string)), ENT_QUOTES, 'UTF-8'));
	else
	{
		$strings = array();
		foreach ($string as $key => $value)
		{
			array_push($strings, valString($value));
		}
		$string = $strings;
	}

	return $string;
}
function getLang($name)
{
	global $Lang;
	if($name)
	{
		if(isset($Lang[$name]))
		{
			return $Lang[$name];
		}
		else
		{
			return $name;
		}
	}
	else
	{
		return $Lang;
	}

}
function getConfig($type, $name, $default = '')
{
	global $CONFIG, $sql, $webdb, $q;
	if(isset($CONFIG[$type][$name]))
	{
		return $CONFIG[$type][$name];
	}
	else
	{
		if($default != '')
		{
			setConfig($type, $name, $default);
			return $default;
		}
		return null;
	}
}
function setConfig($type, $name, $val)
{
	global $CONFIG, $sql, $q, $webdb;
	$CONFIG[$type][$name] = $val;
	$qry = $sql->query(672, array("webdb" => $webdb, "type_id" => $type));
	$type = $sql->fetchArray($qry);
	$id = $type['id'];
	$params = array(
		"webdb" => $webdb,
		"name" => $name,
		"type" => $id,
		"val" => $val);
	$sql->query(671, $params);
	if($sql->numRows() > 0)
	{
		$sql->query(670, $params);
	}
	else
	{
		$sql->query(669, $params);
	}
}
function getVar($v)
{
	$var = isset($_REQUEST[$v]) ? $_REQUEST[$v] : $_POST[$v];
	return is_numeric($var) ? valInt($var) : valString($var);

}
function loggedInOrReturn($url='')
{
    global $user, $Lang;
    if(!$user->logged())
    {
        if($url)
            $_SESSION['returnto']=$url;
        //header ("Refresh: 3; url=login.php");
        head(getLang('error'), true, 'login.php',5);
        msg(getLang('error'), getLang('need_to_login'),'error');
        foot();
        die();
    }
}
function get_date_time($timestamp = 0)
{
	if($timestamp)
		return date("Y-m-d H:i:s", $timestamp);
	else
		return date("Y-m-d H:i:s");
}

function drawElement($body, $type, $value)
{
	$elements = array();
	$elements[0] = 'Fire';
	$elements[1] = 'Water';
	$elements[2] = 'Wind';
	$elements[3] = 'Earth';
	$elements[4] = 'Holy';
	$elements[5] = 'Dark';
	$FIRST_WEAPON_BONUS = 20;
	$WEAPON_BONUS = 5;
	$ARMOR_BONUS = 6;
	$WEAPON_VALUES = array(
		0, // Level 1
		25, // Level 2
		75, // Level 3
		150, // Level 4
		175, // Level 5
		225, // Level 6
		300, // Level 7
		325, // Level 8
		375 // Level 9
			);
	$ARMOR_VALUES = array(
		0, // Level 1
		12, // Level 2
		30, // Level 3
		60, // Level 4
		72, // Level 5
		90, // Level 6
		120, // Level 7
		132, // Level 8
		150 // Level 9
			);
	$lvl = 0;
	if($body == 'weapon')
	{
		foreach ($WEAPON_VALUES as $v)
		{
			if($value < $v)
			{
				break;
			}
			$lvl++;
		}
	}
	else
	{
		foreach ($ARMOR_VALUES as $v)
		{
			if($value < $v)
			{
				break;
			}
			$lvl++;
		}
	}
	$name = $elements[$type];
	$rcon = '';
	if($body == 'weapon')
	{
		if($value >= 450)
		{
			$rcon .= $name . ' Lv ' . $lvl . ' (' . $name . ' P. Atk. ' . $value . ') <br />
            <img src=\'img/elementals/' . $name . '/' . $name . '.png\' class=\'ele_full\' /><br />';

		}
		else
			if($value == $WEAPON_VALUES[$lvl - 1])
			{
				$rcon .= $name . ' Lv ' . $lvl . ' (' . $name . ' P. Atk. ' . $value . ') &lt;br />
            &lt;img src=\\\'img/elementals/' . $name . '/' . $name . '_bg.png\\\' class=\\\'ele_full\\\' />&lt;br />';
			}
			else
			{
				$width = ($value - $WEAPON_VALUES[$lvl - 1]) / ($WEAPON_VALUES[$lvl] - $WEAPON_VALUES[$lvl - 1]);
				//$rcon .='&lt;table>&lt;tr>&lt;td> '.$name.' Lv '.$lvl.' ('.$name.' P. Atk. '.$value.')&lt;/td>&lt;/tr>
				//&lt;tr>&lt;td width="235px" style="background-size: 235px 12px; background-image: url(\\\'img/elementals/'.$name.'/'.$name.'_bg.png\\\'); background-repeat: repeat-x; ">&lt;img src="img/elementals/'.$name.'/'.$name.'.png"  style=" height: 12px; width: '.round($width*235,0).'  background-repeat: repeat-x;"/>&lt;br />&lt;/td>&lt;/tr>
				//&lt;/table>';

			}
	}
	else
	{
		$aname = $type % 2 == 0 ? $elements[$type + 1] : $elements[$type - 1];
		$width = ($value - $ARMOR_VALUES[$lvl - 1]) / ($ARMOR_VALUES[$lvl] - $ARMOR_VALUES[$lvl - 1]);

		$rcon .= '&lt;table class=\\\'ele_half\\\' width=\\\'200px\\\'>&lt;tr>&lt;td> ' . $name . ' Lv ' . $lvl . ' (' . $aname . ' P. Def. ' . $value . ')&lt;/td>&lt;/tr>';
		$rcon .= '&lt;tr>&lt;td class=\\\'ele_half_t\\\' style=\\\'background-size: 200px 12px; background-image: url(img/elementals/' . $aname . '/' . $aname . '_bg.png); background-repeat: repeat-x; \\\'>';
		$rcon .= '&lt;img src=\\\'img/elementals/' . $aname . '/' . $aname . '.png\\\' class=\\\'ele_half\\\'  style=\\\'width: ' . round($width * 200, 0) . '\\\' />&lt;br />&lt;/td>&lt;/tr>';
		$rcon .= '&lt;/table>';
	}
	return $rcon;
}
function augColor($lvl)
{
	switch ($lvl)
	{
		case 1:
			return '#D6D378';
			break;
		case 2:
			return '#5ACBED';
			break;
		case 3:
			return '#CC23B3';
			break;
		case 4:
			return '#F75959';
			break;
	}
}
function isSkin($skin)
{
	return file_exists("skins/$skin/head.php") && file_exists("skins/$skin/foot.php");
}
function getSkins()
{
	$handle = opendir("skins");
	$skinlist = array();
	while ($file = readdir($handle))
	{
		if(isSkin($file) && $file != "." && $file != "..")
		{
			$skinlist[] = $file;
		}
	}
	closedir($handle);
	sort($skinlist);
	return $skinlist;
}
function skinSelector($sel_skin = "", $js = false)
{
	$skins = getSkins();
	$cnt = "<select name=\"skin\"" . ($js ? " onchange=\"window.location='changeskin.php?skin='+this.options[this.selectedIndex].value\"" : "") . ">\n";
	foreach ($skins as $skin)
	{
		$cnt .= "<option value=\"$skin\"" . ($skin == $sel_skin ? " selected=\"selected\"" : "") . ">$skin</option>\n";
	}
	$cnt .= "</select>";
	return $cnt;
}

function selectSkin()
{
	global $user;
	if($user->logged())
		$skin = $_SESSION['skin'];
	elseif (isset($_COOKIE['skin']))
		$skin = $_COOKIE['skin'];
	else
		$skin = getConfig('settings', 'dtheme');
	if(!isSkin($skin))
		$skin = getConfig('settings', 'dtheme');
	return $skin;
}
function getGrade($g)
{
	switch ($g)
	{
		case 0:
			return 'no';
		case 1:
			return 'd';
		case 2:
			return 'c';
		case 3:
			return 'b';
		case 4:
			return 'a';
		case 5:
			return 's';
		case 6:
			return 's80';
		case 7:
			return 's84';
		case 8:
			return 'r85';
		case 9:
			return 'r95';
		case 10:
			return 'r99';
	}
}
function buildEtcItem($inv, $item)
{
	global $q;

	$type = $q[666][$inv["loc_data"]];
	$name = $item["name"];
	$name = str_replace("'", "\\'", $name);
	$addname = str_replace("'", "\\'", $item["addname"]);
	$addname = $addname != '' ? ' - &lt;font color=#333333>' . $addname . '&lt;/font>' : '';
	if($item["grade"] != 0)
	{
		$grade = getGrade($item["grade"]);
		$grade = " &lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />";
	}
	$enchant = $inv["enchant_level"] > 0 ? "+" . $inv["enchant_level"] . " " : "";
	return "<div style='position: absolute; width: 32px; height: 32px; padding: 0px;' class='{$type}'><img border='0' src='img/icons/{$item["icon"]}.png' onmouseover=\"Tip('{$enchant}{$name} {$addname}{$count} {$grade} &lt;br /> {$desc}', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" alt=\"\" /></div>";
}
function buildWeapon($inv, $item)
{
	global $q, $sql, $webdb;
	print_r($inv);
	echo '<br />';
	print_r($item);
	$type = $q[666][$inv["loc_data"]];
	$enchant = $inv["enchant_level"] > 0 ? "+" . $inv["enchant_level"] . " " : "";
	$sql->query("SELECT * FROM item_attributes WHERE itemId='{$inv['item_id']}';");
	if($sql->num_rows())
	{
		$augmented = "Augmeneted ";
	}
	else
	{
		$augmented = "";
	}
	$name = $item["name"];
	$name = str_replace("'", "\\'", $name);
	$addname = str_replace("'", "\\'", $item["addname"]);
	$addname = $addname != '' ? ' - &lt;font color=#333333>' . $addname . '&lt;/font>' : '';
	if($item["grade"] != 0)
	{
		$grade = getGrade($item["grade"]);
		$grade = " &lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />";
	}
	$item_type = $q[665]['w'][$item['item_type']];
	$sql->query("SELECT * FROM {webdb}.weapongrp WHERE id='{$inv['item_id']}';", array("webdb" => $webdb));
	$grp = $sql->fetch_array();
	$hands = $q[665]['body'][$grp['body_part']];
	$element = '';
	return "<div style='position: absolute; width: 32px; height: 32px; padding: 0px;' class='{$type}'><img border='0' src='img/icons/{$item["icon"]}.png' onmouseover=\"Tip('{$enchant}{$augmented}{$name} {$addname}{$count} {$grade} &lt;br />{$item_type} / {$hands}&lt;br /> &lt;Weapon Specifications>&lt;br />P. Atk. : {$grp['patt']}&lt;br />M. Atk. : {$grp['matt']}&lt;br />Atk. Spd. : {$grp['speed']}&lt;br />Soulshot Used : X {$grp['SS_count']}&lt;br />Spiritshot Used : X {$grp['SPS_count']}&lt;br />&lt;Augmentation Effects>&lt;br />{$augment_effect}&lt;br /> {$desc}&lt;br />$element', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" alt=\"\" /></div>";
}
function buildArmor($inv, $item)
{
	global $q, $sql, $webdb;
	$type = $q[666][$inv['loc_data']];
	$enchant = $inv['enchant_level'] > 0 ? '+' . $inv['enchant_level'] . ' ' : '';
	$sql->query("SELECT * FROM item_attributes WHERE itemId='{$inv['item_id']}';");
	if($sql->num_rows())
	{
		$augmented = "Augmeneted ";
		$effects = "&lt;Augmentation Effects>&lt;br />{$augment_effect}";
	}
	else
	{
		$augmented = "";
	}
	$name = str_replace('\'', '\\\'', $item['name']);
	$addname = str_replace('\'', '\\\'', $item['addname']);
	$addname = $addname != '' ? ' - &lt;font color=#333333>' . $addname . '&lt;/font>' : '';
	if($item["grade"] != 0)
	{
		$grade = getGrade($item['grade']);
		$grade = ' &lt;img border=\\\'0\\\' src=\\\'img/grade/' . $grade . '-grade.png\\\' />';
	}
	$item_type = $item['item_type'] != 0 ? ' / ' . $q[665]['a'][$item['item_type']] : '';
	$sql->query('SELECT * FROM {webdb}.armorgrp WHERE id=\'{item_id}\';', array('webdb' => $webdb, 'item_id' => $item['id']));
	$grp = $sql->fetchArray();
	$hands = $q[665]['body'][$grp['body_part']];
	$desc = ($item['desc'] != '') ? '&lt;br />' . str_replace(array("'", "<"), array("\\'", "&lt;"), $item['desc']) : '';

	$mpbonus = $grp['mpbonus'] > 0 ? '&lt;br /> MP Increase : ' . $grp['mpbonus'] : '';
	$pdef = $grp['pdef'] > 0 ? '&lt;br /> P. Def. : ' . $grp['pdef'] : '';
	$mdef = $grp['mdef'] > 0 ? '&lt;br /> M. Def. : ' . $grp['mdef'] : '';
	$weight = '&lt;br />Weight : ' . $item['weight'];
	$element = '';
	$sql->query("SELECT * FROM item_elementals WHERE itemId='{$inv['object_id']}'");
	while ($ele = $sql->fetchArray())
	{
		$element .= drawElement("armor", $ele['elemType'], $ele['elemValue']) . '&lt;br />';
	}
	return "<div style='position: absolute; width: 32px; height: 32px; padding: 0px;' class='{$type}'><img border='0' src='img/icons/{$item["icon"]}.png' onmouseover=\"Tip('{$enchant}{$name} {$addname}{$count} {$grade}&lt;br />{$hands}{$item_type}{$mpbonus}{$pdef}{$mdef}{$weight}{$desc}$element', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FONTWEIGHT, 'bold')\" alt=\"\" /></div>";
}
function buildMainArmor($inv, $item, $other)
{

}
?>