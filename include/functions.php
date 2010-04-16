<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php");}
//includeLang('system');

function includeLang($file)
{
	global $langpath, $Lang;
	
	if($_COOKIE['lang']==1){
	$langpath='lv';
	}elseif($_COOKIE['lang']==2){
	$langpath='en';
	}elseif($_COOKIE['lang']==3){
	$langpath='ru';
	}else{
	$langpath='en';		
	}
	define('INLANG', True);
	if(file_exists('lang/'.$langpath.'/'.$file.'.php'))
	{
	require_once("lang/{$langpath}/{$file}.php");	
	}
}

function includeBlock($file, $block_name='Menu')
{
	global $langpath, $skin, $Lang, $Config, $mysql, $tpl, $webdb, $q, $staticurl;
    DEFINE('IN_BLOCK', True);
    $parse['img_link'] = $staticurl.'/skins/'.$skin;
    $parse['block_name'] = $block_name;
	$tpl->parsetemplate('blocks/block_head', $parse);
    includeLang('blocks/'.$file);
    require_once('blocks/'.$file.'.php');
    $tpl->parsetemplate('blocks/block_foot', $parse);
}

function msg($heading = '', $text = '', $div = 'success', $return=false) {
     if($return)
    {
        $back='<meta http-equiv="refresh" content="3;url='.$Config['url'].'/l2/index.php" />';
    }
    echo '<table width="90%" border="0"><tr><td>';
    echo '<div align="center" class="'.$div.'">'.($heading ? '<b>'.$heading.'</b><br />' : '').$text.$back.'</div></td></tr></table>';
}

function error($id){
    header('Location: error.php?error='.$id);
}

function head($title = "", $head=1, $url='', $time=0)
{
    global $skin, $Config, $Lang, $mysql, $staticurl, $tpl;
    DEFINE('INSKIN', True);
	$skin = $Config['DSkin'];

    $title = $Config['Title']." :: ".$title;
	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $mysql, $skin, $Config, $Lang, $starttime, $user, $tpl, $staticurl;
    if(isset($_COOKIE['skin']))
    {
        $skin = trim($_COOKIE['skin']);
    }
    else
    {
	   $skin = $Config['DSkin'];
    }
    require_once("skins/" . $skin . "/foot.php");
}
function button($text='  ', $name = 'Submit', $return = 0, $disabled=false, $id = NULL)
{
    global $tpl;
    $parse['text'] = $text;
    $parse['name'] = $name;
    if($id == NULL) { $parse['id'] = "bt_".rand(20,99); } else { $parse['id'] = $id; }
    //$parse['id'] = "bt_".rand(20,99);
    if ($disabled) $parse['disabled'] = 'disabled="disabled"';
    if ($return)
        return $tpl->parsetemplate('button', $parse, 1);
    else
        $tpl->parsetemplate('button', $parse);
}
function pretty_time ($seconds) {
	$day = floor($seconds / (24 * 3600));
	$hs = floor($seconds / 3600 % 24);
	$ms = floor($seconds / 60 % 60);
	$sr = floor($seconds / 1 % 60);

	if ($hs < 10) { $hh = "0" . $hs; } else { $hh = $hs; }
	if ($ms < 10) { $mm = "0" . $ms; } else { $mm = $ms; }
	if ($sr < 10) { $ss = "0" . $sr; } else { $ss = $sr; }

	$time = '';
	if ($day != 0) { $time .= $day . 'd '; }
	if ($hs  != 0) { $time .= $hh . 's ';  } else { $time .= '00s '; }
	if ($ms  != 0) { $time .= $mm . 'm ';  } else { $time .= '00m '; }
	$time .= $ss . 's';

	return $time;
}

function pretty_time_hour ($seconds) {
	$min = floor($seconds / 60 % 60);

	$time = '';
	if ($min != 0) { $time .= $min . 'min '; }

	return $time;
}

function getDBName($id)
{
	global $mysql, $webdb;
	if(is_numeric($id))
	{
		$srv = $mysql->escape(0 + $id);
		$srvqry = $mysql->query("SELECT `DataBase` FROM `$webdb`.`gameservers` WHERE `ID` = '$srv'");
		if($mysql->num_rows($srvqry))
		{
			return $mysql->result($srvqry);
 		}
  	}
  	return $Config['DDB'];
}
?>