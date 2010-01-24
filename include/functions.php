<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php");}
includeLang('system');
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

function includeBlock($file, $block_name='Menu', $link=false)
{
	if($link){global $link;}
	global $langpath, $skin, $Lang, $Config, $CURUSER;
	echo '
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td class="head_left_corner2"></td>
<td class="head_center" align="center" width="120"><strong>'.$block_name.'</strong></td>
<td class="head_right_corner2"></td></tr>
<tr><td class="head_left_border"></td>
<td class="head_background" align="center" valign="top" width="120">
';
includeLang('blocks/'.$file);
require_once('blocks/'.$file.'.php');
echo '
</td>
<td class="head_right_border"></td>
</tr>
<tr>
<td class="bottom_left_corner"></td>
<td class="bottom_center" width="122"></td>
<td class="bottom_right_corner"></td>
</tr>
</table>';
}

function encodePassword($password)
{
	return base64_encode(pack('H*', sha1(mysql_real_escape_string($password))));
}

function logedin()
{
    global $Config;
    if(isset($_SESSION['account']) && $_SESSION['IP']==$_SERVER['REMOTE_ADDR'])
    {
        if(!$_SESSION['remember'] && $_SESSION['last_act']<(time()-$Config['session_expire_time'])){
            //session_unset();
            return false;
        }else{
            return true;
        }
    }else{
        //session_unset();
        return false;
    }
}

function is_admin(){
    if($_SESSION['admin']==true){
        return true;
    }else{
        return false;
    }
}

function msg($heading = '', $text = '', $div = 'success', $return=false) {
     if($return)
    {
        $back="<meta http-equiv=\"refresh\" content=\"3;url={$Config['url']}/l2/index.php\" />";
    }
    echo '<table width="90%" border="0"><tr><td>';
    echo '<div align="center" class="'.$div.'">'.($heading ? '<b>'.$heading.'</b><br />' : '').$text.$back.'</div></td></tr></table>';
}

function error($id){
    header('Location: error.php?error='.$id);
}

function head($title = "", $head=1)
{
    global $skin, $Config, $Lang;
DEFINE('INSKIN', True);
if(isset($_COOKIE['skin']))
{
$skin = mysql_real_escape_string($_COOKIE['skin']);
}
else
{
	$skin = $Config['DSkin'];
}
		if ($title == "")
			$title = $Config['Title'];
		else
			$title = $Config['Title']." :: ".$title;
    require_once("skins/" . $skin . "/config.php");
	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $link, $skin, $Config, $Lang, $starttime;
    if(isset($_COOKIE['skin']))
{
$skin = mysql_real_escape_string($_COOKIE['skin']);
}
else
{
	$skin = $Config['DSkin'];
}
    require_once("skins/" . $skin . "/foot.php");
    mysql_close($link);
}
?>