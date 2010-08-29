<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php");}
includeLang('functions');

function includeLang($file)
{
	global $langpath, $Lang, $Config;
	
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
	global $langpath, $skin, $Lang, $Config, $mysql, $tpl, $webdb, $q, $user;
    DEFINE('IN_BLOCK', True);
    $img_link = 'skins/'.$skin;
	?>
    <table width="200" style="height:95px;" border="0" cellpadding="0" cellspacing="0" class="opacity2">
    <tr style="height:48px;">
    <td width="23"><img width="23" height="50" alt="" src="<?php echo $img_link;?>/img/h_l_c.gif" /></td>
    <td width="159" style="background-image: url(<?php echo $img_link;?>/img/h_c.gif); background-repeat: no-repeat;">
    <div align="center" class="block_name"><?php echo $block_name;?></div></td>
    <td width="18"><img width="18" height="50" alt="" src="<?php echo $img_link;?>/img/h_r_c.gif" /></td></tr>

    <tr><td style="background-image: url(<?php echo $img_link;?>/img/h_l_b.gif);">&nbsp;</td>
    <td width="80%" bgcolor="#37301d" align="center">
    <?php
    includeLang('blocks/'.$file);
    require_once('blocks/'.$file.'.php');
    ?>
    </td><td style="background-image: url(<?php echo $img_link;?>/img/h_r_b.gif);">&nbsp;</td></tr>
    <tr><td width="23"><img width="23" height="26" alt="" src="<?php echo $img_link;?>/img/b_l_c.gif" /></td>
    <td width="159"><img width="159" height="26" alt="" src="<?php echo $img_link;?>/img/b_c.gif" /></td>
    <td width="18"><img width="18" height="26" alt="" src="<?php echo $img_link;?>/img/b_r_c.gif" /></td>
    </tr></table>
    <?php
}

function msg($heading = '', $text = '', $div = 'success') {
    echo '<table width="90%" border="0"><tr><td>';
    echo '<div align="center" class="'.$div.'">'.($heading ? '<b>'.$heading.'</b><br />' : '').$text.'</div></td></tr></table>';
}

function error($id){
    header('Location: error.php?error='.$id);
}

function head($title = "", $head=1, $url='', $time=0)
{
    global $skin, $Config, $Lang, $mysql, $tpl, $user;
    DEFINE('INSKIN', True);
	$skin = $Config['DSkin'];

    $title = $Config['Title']." :: ".$title;
    //echo $skin;
	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $mysql, $skin, $Config, $Lang, $starttime, $user, $tpl;
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
	global $mysql, $webdb, $Config;
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

function pagechoose($page, $count=0, $stat, $server)
{
    global $Config, $Lang;
    
    ?>
    <div class="page-choose" align="center"><br /><table align="center"><tr>
    <?php
    $totalpages = ceil($count/$Config['TOP']);
    if($totalpages==0)
    {
        $totalpages++;
    }
    if($page>3)
    {
        ?>
        <td><a href="stat.php?stat=<?php echo $stat;?>&amp;server=<?php echo $server;?>&amp;page=1" title="<?php echo $Lang['first'];?>"  class="btn"> &laquo; </a></td>
        <?php
    }
    if($page>1)
    {
        ?>
        <td><a href="stat.php?stat=<?php echo $stat;?>&amp;server=<?php echo $server;?>&amp;page=<?php
        echo $page-1;
        ?>" title="<?php echo $Lang['prev'];?>" class="btn"> &lt; </a></td>
        <?php
    }
    if($page-2>0){$start=$page-2;}else{$start=1;}
    for($i=$start; $i<=$totalpages && $i<=$page+2; $i++)
    {

        if($i==$page)
        {
            echo '<td>&nbsp;&nbsp;<a href="#" class="btn brown" title="';
            echo ' [';
            echo ($count!=0) ? $i*$Config['TOP']+1-$Config['TOP'] : 0;
            echo ' - ';
            echo ($i*$Config['TOP']>$count)? $count: $i*$Config['TOP'];
            echo ']"> ';
            echo $i;
            echo ' </a>&nbsp;&nbsp;</td>';
        }
        else
        {
            echo '<td>&nbsp;&nbsp;<a href="stat.php?stat='.$stat;
            echo '&amp;server='.$server;
            echo '&amp;page='.$i;
            echo '" title="[';
            echo ($count!=0) ? $i*$Config['TOP']+1-$Config['TOP'] : 0;
            echo ' - ';
            echo ($i*$Config['TOP']>$count)? $count: $i*$Config['TOP'];
            echo ']" class="btn"> ';
            echo $i;
            echo ' </a>&nbsp;&nbsp;</td>';
        }

    }
    if($totalpages > $page)
    {
        ?>
        <td><a href="stat.php?stat=<?php echo $stat;?>&amp;server=<?php echo $server;?>&amp;page=<?php
        echo $page+1;
        ?>" title="<?php echo $Lang['next'];?>" class="btn"> &gt; </a></td>
        <?php
    }
    if($totalpages > $page+2)
    {
        ?>
        <td><a href="stat.php?stat=<?php echo $stat;?>&amp;server=<?php echo $server;?>&amp;page=<?php
        echo $totalpages;
         ?>" title="<?php echo $Lang['last'];?>" class="btn"> &raquo; </a></td>
         <?php
    }
    ?>
    </tr></table>&nbsp;</div>
    <?php
}
?>