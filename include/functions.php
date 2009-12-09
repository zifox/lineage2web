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
<td background="skins/'.$skin.'/img/t_h_lc2.gif" width="16" height="48"></td>
<td background="skins/'.$skin.'/img/t_h_rp.gif" width="120" height="48" align="center">
<strong>'.$block_name.'</strong></td>
<td background="skins/'.$skin.'/img/t_h_rc2.gif" width="19" height="48"></td></tr>
<tr><td background="skins/'.$skin.'/img/t_h_bl.jpg" width="16" ></td>
<td background="skins/'.$skin.'/img/t_bg.gif" width="120" align="center" valign="top">
';
includeLang('blocks/'.$file);
require_once('blocks/'.$file.'.php');
echo '
</td>
<td background="skins/'.$skin.'/img/t_h_br.jpg" width="16" ></td>
</tr>
<tr>
<td background="skins/'.$skin.'/img/t_b_lc.gif" width="16" height="22"></td>
<td background="skins/'.$skin.'/img/t_b_c.gif" width="120" height="22"></td>
<td background="skins/'.$skin.'/img/t_b_rc.gif" width="19" height="22"></td>
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
	header('Location: '.$Config['url'].'/index.php?id=logedin');
}

function logout()
{
    setcookie('account', '', 0, '/');
	setcookie('password', '', 0, '/');
    header('Location: '.$Config['url'].'/index.php');
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
    header('Location:'.$Config['url'].'/index.php?id=error&error='.$id);
}

function head()
{
    
}

function foot()
{
    
}
?>