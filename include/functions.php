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
	global $langpath, $skin, $Lang, $Config, $mysql;
	?>
<table width="200" style="height:95px;" border="0" cellpadding="0" cellspacing="0" class="opacity2"><tr style="height:48px;">
<td width="23"><img width="23" height="50" alt="" src="skins/<?php echo $skin;?>/img/h_l_c.gif" /></td>
<td width="159" style="background-image: url(skins/<?php echo $skin;?>/img/h_c.gif); background-repeat: no-repeat;"><div align="center" class="block_name"><?php echo $block_name;?></div></td>
<td width="18"><img width="18" height="50" alt="" src="skins/<?php echo $skin;?>/img/h_r_c.gif" /></td></tr>

<tr><td style="background-image: url(skins/<?php echo $skin;?>/img/h_l_b.gif);">&nbsp;</td>
<td width="80%" bgcolor="#37301d" align="center">
<?php
includeLang('blocks/'.$file);
require_once('blocks/'.$file.'.php');
?>
</td>
<td style="background-image: url(skins/<?php echo $skin;?>/img/h_r_b.gif);">&nbsp;</td>
</tr>
<tr>
        <td width="23"><img width="23" height="26" alt="" src="skins/<?php echo $skin;?>/img/b_l_c.gif" /></td>
        <td width="159"><img width="159" height="26" alt="" src="skins/<?php echo $skin;?>/img/b_c.gif" /></td>
        <td width="18"><img width="18" height="26" alt="" src="skins/<?php echo $skin;?>/img/b_r_c.gif" /></td>
      </tr>
</table>
<?php
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
    global $skin, $Config, $Lang, $mysql;
    DEFINE('INSKIN', True);
	$skin = $Config['DSkin'];

    $title = $Config['Title']." :: ".$title;
	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $mysql, $skin, $Config, $Lang, $starttime, $user;
    if(isset($_COOKIE['skin']))
{
$skin = trim($_COOKIE['skin']);
}
else
{
	$skin = $Config['DSkin'];
}
    require_once("skins/" . $skin . "/foot.php");
    $mysql->close();
}
function button($text='  ')
{
?>
<label>
    <input type="image" onmouseout="this.src = './login_b.php?text=   <?php echo $text;?>&amp;style=press';" onmousemove="this.src = './login_b.php?text=   <?php echo $text;?>&amp;style=hover';" src="./login_b.php?text=   <?php echo $text;?>&amp;style=normal" value=" " name="Submit" />
</label>
<?php
}
?>