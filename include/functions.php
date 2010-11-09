<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php");}
includeLang('functions');

function includeLang($file)
{
	global $langpath, $Lang;
	$langpath=getLang();
	define('INLANG', True);
	if(file_exists('lang/'.$langpath.'/'.$file.'.php'))
	{
	require_once("lang/{$langpath}/{$file}.php");	
	}
}
function getLang()
{
    switch ($_COOKIE['lang'])
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
        default:
            return 'en';
        break;
    }
}
function includeBlock($file, $block_name='Menu')
{
	global $CONFIG, $mysql, $user, $tpl, $cache, $q, $Lang, $langpath;
    DEFINE('IN_BLOCK', True);
    $img_link = 'skins/'.$CONFIG['settings']['DSkin'];
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
    global $CONFIG, $user, $mysql, $tpl, $cache, $Lang;
    DEFINE('INSKIN', True);
	$skin = $CONFIG['settings']['DSkin'];
    $title = $CONFIG['head']['Title']." :: ".$title;
    //echo $skin;
	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $CONFIG, $user, $mysql, $tpl, $cache, $Lang, $starttime;
    if(isset($_COOKIE['skin']))
    {
        $skin = trim($_COOKIE['skin']);
    }
    else
    {
	   $skin = $CONFIG['settings']['DSkin'];
    }
    require_once("skins/" . $skin . "/foot.php");
}
function button($text='  ', $name = 'Submit', $return = 0, $disabled=false, $id = NULL)
{
    global $tpl;
    $parse['text'] = $text;
    $parse['name'] = $name;
    if($id == NULL) { $parse['id'] = "bt_".rand(20,99); } else { $parse['id'] = $id; }
    if ($disabled) $parse['disabled'] = 'disabled="disabled"';
    if ($return)
        return $tpl->parsetemplate('button', $parse, 1);
    else
        $tpl->parsetemplate('button', $parse);
}
function menubutton($text)
{
    return '<img src="./button.php?text='.$text.'" title="'.$text.'" alt="'.$text.'" border="0" width="138" height="34" />';
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
    global $CONFIG, $mysql;
	if(is_numeric($id))
	{
		$srv = $mysql->escape(0 + $id);
		$srvqry = $mysql->query("SELECT `DataBase` FROM `{$CONFIG['settings']['webdb']}`.`gameservers` WHERE `ID` = '$srv'");
		if($mysql->num_rows($srvqry))
		{
			return $mysql->result($srvqry);
 		}
  	}
  	return $CONFIG['settings']['DDB'];
}

function pagechoose($page, $count=0, $stat, $server)
{
    global $CONFIG, $Lang;;
    $content=NULL;
    $content.='<div class="page-choose" align="center"><br /><table align="center"><tr>';
    
    $totalpages = ceil($count/$CONFIG['settings']['TOP']);
    if($totalpages==0)
    {
        $totalpages++;
    }
    if($page>3)
    {
        $content.="<td><a href=\"stat.php?stat=$stat&amp;server=$server&amp;page=1\" title=\"{$Lang['first']}\"  class=\"btn\"> &laquo; </a></td>";
    }
    if($page>1)
    {
        $content.="<td><a href=\"stat.php?stat=$stat&amp;server=$server&amp;page=\"";
        $content.="".$page-1;
        $content.="\" title=\"{$Lang['prev']}\" class=\"btn\"> &lt; </a></td>";
    }
    if($page-2>0){$start=$page-2;}else{$start=1;}
    for($i=$start; $i<=$totalpages && $i<=$page+2; $i++)
    {

        if($i==$page)
        {
            $content.= '<td>&nbsp;&nbsp;<a href="#" class="btn brown" title="';
            $content.= ' [';
            $content.= ($count!=0) ? $i*$CONFIG['settings']['TOP']+1-$CONFIG['settings']['TOP'] : 0;
            $content.= ' - ';
            $content.= ($i*$CONFIG['settings']['TOP']>$count)? $count: $i*$CONFIG['settings']['TOP'];
            $content.= ']"> ';
            $content.= $i;
            $content.= ' </a>&nbsp;&nbsp;</td>';
        }
        else
        {
            $content.= '<td>&nbsp;&nbsp;<a href="stat.php?stat='.$stat;
            $content.= '&amp;server='.$server;
            $content.= '&amp;page='.$i;
            $content.= '" title="[';
            $content.= ($count!=0) ? $i*$CONFIG['settings']['TOP']+1-$CONFIG['settings']['TOP'] : 0;
            $content.= ' - ';
            $content.= ($i*$CONFIG['settings']['TOP']>$count)? $count: $i*$CONFIG['settings']['TOP'];
            $content.= ']" class="btn"> ';
            $content.= $i;
            $content.= ' </a>&nbsp;&nbsp;</td>';
        }

    }
    if($totalpages > $page)
    {
        
        $content.="<td><a href=\"stat.php?stat=$stat&amp;server=$server&amp;page=";
        $content.= $page+1;
        $content.="\" title=\"{$Lang['next']}\" class=\"btn\"> &gt; </a></td>";
        
    }
    if($totalpages > $page+2)
    {
        
        $content.="<td><a href=\"stat.php?stat=$stat&amp;server=$server&amp;page=";
        $content.= $totalpages;
         $content.="\" title=\"{$Lang['last']}\" class=\"btn\"> &raquo; </a></td>";
         
    }

    $content.='</tr></table>&nbsp;</div>';
    return $content;

}
function convertPic($id, $ext, $width, $height)
{
    ini_set('memory_limit', '100M');
    if(file_exists('news/'.$id.'_thumb.'.$ext))
    unlink('news/'.$id.'_thumb.'.$ext);
    $new_img = 'news/'.$id.'_thumb.'.$ext;

    $file_src = "news/$id.$ext";

    list($w_src, $h_src, $type) = getimagesize($file_src);
    $ratio = $w_src/$h_src;
    if ($width/$height > $ratio) {$width = floor($height*$ratio);} else {$height = floor($width/$ratio);}

    switch ($type)
    {
        case 1:   //   gif -> jpg
            $img_src = imagecreatefromgif($file_src);
        break;
        case 2:   //   jpeg -> jpg
            $img_src = imagecreatefromjpeg($file_src);
        break;
        case 3:  //   png -> jpg
            $img_src = imagecreatefrompng($file_src);
        break;
    }
    $img_dst = imagecreatetruecolor($width, $height);  //  resample
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
    global $mysql;
    $query=$mysql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'") OR mysql_error();
    if($mysql->num_rows($query))
    {
        $before=$mysql->result($query,0,1);
        $mysql->query("UPDATE `items` SET `count` = `count` + '$count' WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
    }else{
        $before=0;
        $maxloc=$mysql->query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$charId' AND `items`.`loc` = '$loc'") OR mysql_error();
        $itemloc=$mysql->result($maxloc)+1;
        $mysql->query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`) VALUES ('$charId','$itemId','$count','$loc','$itemloc')") OR mysql_error();
    }
    $check=$mysql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'") OR mysql_error();
    if(!$mysql->num_rows($check))
        return false;
    if($before+$count==$mysql->result($check,0,1))
        return true;
    return false;
}
?>