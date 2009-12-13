<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php?id=start");}
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

function logincookie($account, $password, $rememberme)
{
	if($rememberme){$expiretime = time() + 31536000;}else{$expiretime=0;}
	setcookie('account', $account, $expiretime, '/', '', '',true);
	setcookie('password', $password, $expiretime, '/', '', '',true);
	header('Location: index.php');
}

function logout()
{
    setcookie('account', '', 0, '/');
	setcookie('password', '', 0, '/');
    header('Location: index.php');
}

function logedin()
{
    $account=mysql_real_escape_string($_COOKIE['account']);
    $password=mysql_real_escape_string($_COOKIE['password']);
    $CUSER=mysql_fetch_array(mysql_query("SELECT * FROM `accounts` WHERE `login` = '".$account."'"));
    if ($CUSER && md5($CUSER['password'])==$password){
  //      global $CUSER;
  $GLOBALS['CURUSER']=$CUSER;
    return true;
        }else{
        //logout();
        return false;
}
}
function msg($heading = '', $text = '', $div = 'success', $return=false) {
    print("<table width=\"90%\" border=\"0\"><tr><td>\n");
    if($return)
    {
        $back="<meta http-equiv=\"refresh\" content=\"3;url={$Config['url']}/index.php\" />";
    }
    print("<div align = \"center\" class=\"$div\">".($heading ? "<b>$heading</b><br />" : "")."$text $back</div></td></tr></table>\n");
}

function error($id){
    header('Location: error.php?error='.$id);
}

function head($title = "")
{
    global $skin, $Config, $Lang;
DEFINE('INSKIN', True);
if($_COOKIE['skin'])
{
$skin = mysql_real_escape_string(isset($_COOKIE['skin']));
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

function foot()
{
    global $skin, $Config, $Lang;
    require_once("skins/" . $skin . "/foot.php");
}
?>