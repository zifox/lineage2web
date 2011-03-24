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
	global $sql, $user, $tpl, $cache, $q, $Lang, $langpath;
    DEFINE('IN_BLOCK', True);
    $img_link = 'skins/'.getConfig('settings', 'DTHEME', 'l2f');
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
function err($head, $text)
{
    head($head);
    msg($head,$text,'error');
    foot();
    exit();
}
function suc($head, $text)
{
    head($head);
    msg($head,$text);
    foot();
    exit();
}
function error($id){
    header('Location: error.php?error='.$id);
}

function head($title = "", $head=1, $url='', $time=0)
{
    global $user, $sql, $tpl, $cache, $Lang;
    DEFINE('INSKIN', True);
	$skin = getConfig('settings', 'DTHEME', 'l2f');
    $title = getConfig('head', 'Title', 'Lineage II Fantasy World')." :: ".$title;

	require_once("skins/" . $skin . "/head.php");
}

function foot($foot=1)
{
    global $user, $sql, $tpl, $cache, $Lang, $starttime;
    if(isset($_COOKIE['skin']))
    {
        $skin = trim($_COOKIE['skin']);
    }
    else
    {
	   $skin = getConfig('settings', 'DTHEME', 'l2f');
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
    global $sql;
	if(is_numeric($id))
	{
		$srv = $sql->escape(0 + $id);
		$srvqry = $sql->query("SELECT `DataBase` FROM `".getConfig('settings', 'webdb', 'l2web')."`.`gameservers` WHERE `ID` = '$srv'");
		if($sql->num_rows())
		{
			return $sql->result($srvqry);
 		}
  	}
  	return getConfig('settings', 'DDB', 'l2jdb');
}

function pagechoose($page, $count=0, $stat, $server)
{
    global $Lang;;
    $content=NULL;
    $content.='<div class="page-choose" align="center"><br /><table align="center"><tr>';
    
    $totalpages = ceil($count/getConfig('settings', 'TOP', '10'));
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
            $content.= ($count!=0) ? $i*getConfig('settings', 'TOP', '10')+1-getConfig('settings', 'TOP', '10') : 0;
            $content.= ' - ';
            $content.= ($i*getConfig('settings', 'TOP', '10')>$count)? $count: $i*getConfig('settings', 'TOP', '10');
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
            $content.= ($count!=0) ? $i*getConfig('settings', 'TOP', '10')+1-getConfig('settings', 'TOP', '10') : 0;
            $content.= ' - ';
            $content.= ($i*getConfig('settings', 'TOP', '10')>$count)? $count: $i*getConfig('settings', 'TOP', '10');
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
    //ini_set('memory_limit', '100M');
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
    global $sql;
    $query=$sql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
    if($sql->num_rows())
    {
        $before=$sql->result($query,0,1);
        $sql->query("UPDATE `items` SET `count` = `count` + '$count' WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
    }else{
        $before=0;
        $maxloc=$sql->query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$charId' AND `items`.`loc` = '$loc'");
        $itemloc=$sql->result($maxloc)+1;
        $sql->query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`) VALUES ('$charId','$itemId','$count','$loc','$itemloc')");
    }
    $check=$sql->query("SELECT `object_id`, `count` FROM `items` WHERE `owner_id`='$charId' AND `item_id` = '$itemId' AND `loc` = '$loc'");
    if(!$sql->num_rows())
        return false;
    if($before+$count==$sql->result($check,0,1))
        return true;
    return false;
}
function insertPremiumItem()
{
    
}
function val_int($string, $default=0, $min=0, $max=999999999)
{
    $options = array(
    'options' => array(
        'default' => $default,
        'min_range' => $min,
        'max_range' => $max
    ),
);
    $int = filter_var($string, FILTER_VALIDATE_INT, $options);
    return $int;
}
function val_string($string)
{
    global $sql;
    if(!is_array($string))
        $string = trim(htmlentities(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $sql->escape($string)), ENT_QUOTES, 'UTF-8'));
    else
        {
            $strings = array();
            foreach($string as $key => $value)
            {
                array_push($strings,val_string($value));
            }
            $string=$strings;
        }
        
    return $string;
}
//function conv2html($string)
//{
//    return html_entity_decode(stripslashes($string), ENT_QUOTES, 'UTF-8');
//}

function getConfig($type, $name, $default)
{
    global $CONFIG, $sql, $webdb, $q;
    if(isset($CONFIG[$type][$name]))
    {
        return $CONFIG[$type][$name];
    }
    else
    {
        setConfig($type,$name,$default);
        return $default;
    }
}
function setConfig($type, $name, $val)
{
    global $CONFIG, $sql, $q;
    $params = array("webdb"=>getConfig('settings','webdb','l2web'), "name"=>$name, "type"=> $type, "val"=>$val);
    $sql->query(671, $params);
    if($sql->num_rows()>0)
    {
        $sql->query(670, $params);
    }
    else
    {
        $sql->query(669, $params);
    }
    $CONFIG[$type][$name]=$val;
}
function getVar($v)
{
    $var=isset($_SERVER[$v])?$_SERVER[$v]:(isset($_POST[$v])?$_POST[$v]:(isset($_GET[$v])?$_GET[$v]:""));
    if($var!="")
    {
        return is_numeric($var)?val_int($var):val_string($var);
    }
    return null;
}
function htmlspecialchars_uni($message) {
    $message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $message);
    $message = str_replace("<","&lt;",$message);
    $message = str_replace(">","&gt;",$message);
    $message = str_replace("\"","&quot;",$message);
    $message = str_replace("  ", "&nbsp;&nbsp;", $message);
    return $message;
}
function format_urls($s)
{
	return preg_replace(
    	"/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i",
	    "\\1<a href=\"\\2\">\\2</a>", $s);
}
function format_body($text, $strip_html = true) {
	//global $smilies, $privatesmilies;
	//$smiliese = $smilies;
	$s = $text;

	if ($strip_html)
		$s = htmlspecialchars_uni($s);

	$bb[] = "#\[img\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#i";
	$html[] = "<img class=\"linked-image\" src=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[img\ alt=([a-zA-Zą-˙Ą-ß0-9\_\-\. ]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+) alt=([a-zA-Zą-˙Ą-ß0-9\_\-\. ]+)\](?!javascript:)([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\3\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[kp=([0-9]+)\]#is";
	$html[] = "<a href=\"http://www.kinopoisk.ru/level/1/film/\\1/\" rel=\"nofollow\"><img src=\"http://www.kinopoisk.ru/rating/\\1.gif/\" alt=\"Źčķīļīčńź\" title=\"Źčķīļīčńź\" border=\"0\" /></a>";
	$bb[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url\]((www|ftp)\.([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\2</a>";
	$bb[] = "#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\3</a>";
	$bb[] = "/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\2</a>";
	$bb[] = "/\[url\]([^()<>\s]+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\1</a>";
	$bb[] = "#\[mail\](\S+?)\[/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\1</a>";
	$bb[] = "#\[mail\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\2</a>";
	$bb[] = "#\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[/color\]#si";
	$html[] = "<span style=\"color: \\1\">\\2</span>";
	$bb[] = "#\[(font|family)=([A-Za-z ]+)\](.*?)\[/\\1\]#si";
	$html[] = "<span style=\"font-family: \\2\">\\3</span>";
	$bb[] = "#\[size=([0-9]+)\](.*?)\[/size\]#si";
	$html[] = "<span style=\"font-size: \\1\">\\2</span>";
	$bb[] = "#\[(left|right|center|justify)\](.*?)\[/\\1\]#is";
	$html[] = "<div align=\"\\1\">\\2</div>";
	$bb[] = "#\[b\](.*?)\[/b\]#si";
	$html[] = "<b>\\1</b>";
	$bb[] = "#\[i\](.*?)\[/i\]#si";
	$html[] = "<i>\\1</i>";
	$bb[] = "#\[u\](.*?)\[/u\]#si";
	$html[] = "<u>\\1</u>";
	$bb[] = "#\[s\](.*?)\[/s\]#si";
	$html[] = "<s>\\1</s>";
	$bb[] = "#\[li\]#si";
	$html[] = "<li>";
	$bb[] = "#\[hr\]#si";
	$html[] = "<hr>";

	$s = preg_replace($bb, $html, $s);

	$s = nl2br($s);

	$s = format_urls($s);


	//foreach ($smiliese as $code => $url)
	//	$s = str_replace($code, "<img border=\"0\" src=\"pic/smilies/$url\" alt=\"" . htmlspecialchars_uni($code) . "\">", $s);

	//foreach ($privatesmilies as $code => $url)
	//	$s = str_replace($code, "<img border=\"0\" src=\"pic/smilies/$url\">", $s);

	while (preg_match("#\[quote\](.*?)\[/quote\]#si", $s)) $s = encode_quote($s);
	while (preg_match("#\[quote=(.+?)\](.*?)\[/quote\]#si", $s)) $s = encode_quote_from($s);
	while (preg_match("#\[hide\](.*?)\[/hide\]#si", $s)) $s = encode_spoiler($s);
	while (preg_match("#\[hide=(.+?)\](.*?)\[/hide\]#si", $s)) $s = encode_spoiler_from($s);
	if (preg_match("#\[code\](.*?)\[/code\]#si", $s)) $s = encode_code($s);
	if (preg_match("#\[php\](.*?)\[/php\]#si", $s)) $s = encode_php($s);

	return $s;
}
function encode_code($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"E5EFFF\"><td colspan=\"2\"><font class=\"block-title\">Code</font></td></tr>"
	."<tr class=\"bgcolor1\"><td align=\"right\" class=\"code\" style=\"width: 5px; border-right: none\">{ZEILEN}</td><td class=\"code\">";
	$end_html = "</td></tr></table></div></div>";
	$match_count = preg_match_all("#\[code\](.*?)\[/code\]#si", $text, $matches);
    for ($mout = 0; $mout < $match_count; ++$mout) {
      $before_replace = $matches[1][$mout];
      $after_replace = $matches[1][$mout];
      $after_replace = trim ($after_replace);
      $zeilen_array = explode ("<br />", $after_replace);
      $j = 1;
      $zeilen = "";
      foreach ($zeilen_array as $str) {
        $zeilen .= "".$j."<br />";
        ++$j;
      }
      $after_replace = str_replace ("", "", $after_replace);
      $after_replace = str_replace ("&amp;", "&", $after_replace);
      $after_replace = str_replace ("", "&nbsp; ", $after_replace);
      $after_replace = str_replace ("", " &nbsp;", $after_replace);
      $after_replace = str_replace ("", "&nbsp; &nbsp;", $after_replace);
      $after_replace = preg_replace ("/^ {1}/m", "&nbsp;", $after_replace);
      $str_to_match = "[code]".$before_replace."[/code]";
      $replace = str_replace ("{ZEILEN}", $zeilen, $start_html);
      $replace .= $after_replace;
      $replace .= $end_html;
      $text = str_replace ($str_to_match, $replace, $text);
    }

    $text = str_replace ("[code]", $start_html, $text);
    $text = str_replace ("[/code]", $end_html, $text);
    return $text;
}

function encode_php($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"F3E8FF\"><td colspan=\"2\"><font class=\"block-title\">PHP - Code</font></td></tr>"
	."<tr class=\"bgcolor1\"><td align=\"right\" class=\"code\" style=\"width: 5px; border-right: none\">{ZEILEN}</td><td>";
	$end_html = "</td></tr></table></div></div>";
	$match_count = preg_match_all("#\[php\](.*?)\[/php\]#si", $text, $matches);
    for ($mout = 0; $mout < $match_count; ++$mout) {
        $before_replace = $matches[1][$mout];
        $after_replace = $matches[1][$mout];
        $after_replace = trim ($after_replace);
		$after_replace = str_replace("&lt;", "<", $after_replace);
		$after_replace = str_replace("&gt;", ">", $after_replace);
		$after_replace = str_replace("&quot;", '"', $after_replace);
		$after_replace = preg_replace("/<br.*/i", "", $after_replace);
		$after_replace = (substr($after_replace, 0, 5 ) != "<?php") ? "<?php\n".$after_replace."" : "".$after_replace."";
		$after_replace = (substr($after_replace, -2 ) != "?>") ? "".$after_replace."\n?>" : "".$after_replace."";
        ob_start ();
        highlight_string ($after_replace);
        $after_replace = ob_get_contents ();
        ob_end_clean ();
		$zeilen_array = explode("<br />", $after_replace);
        $j = 1;
        $zeilen = "";
      foreach ($zeilen_array as $str) {
        $zeilen .= "".$j."<br />";
        ++$j;
      }
		$after_replace = str_replace("\n", "", $after_replace);
		$after_replace = str_replace("&amp;", "&", $after_replace);
		$after_replace = str_replace("  ", "&nbsp; ", $after_replace);
		$after_replace = str_replace("  ", " &nbsp;", $after_replace);
		$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);
		$after_replace = preg_replace("/^ {1}/m", "&nbsp;", $after_replace);
		$str_to_match = "[php]".$before_replace."[/php]";
		$replace = str_replace("{ZEILEN}", $zeilen, $start_html);
      $replace .= $after_replace;
      $replace .= $end_html;
      $text = str_replace ($str_to_match, $replace, $text);
    }
	$text = str_replace("[php]", $start_html, $text);
	$text = str_replace("[/php]", $end_html, $text);
    return $text;
}
function encode_quote($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"FFE5E0\"><td><font class=\"block-title\">Quote</font></td></tr><tr class=\"bgcolor1\"><td>";
	$end_html = "</td></tr></table></div></div>";
	$text = preg_replace("#\[quote\](.*?)\[/quote\]#si", "".$start_html."\\1".$end_html."", $text);
	return $text;
}

// Format quote from
function encode_quote_from($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"FFE5E0\"><td><font class=\"block-title\">\\1 quote</font></td></tr><tr class=\"bgcolor1\"><td>";
	$end_html = "</td></tr></table></div></div>";
	$text = preg_replace("#\[quote=(.+?)\](.*?)\[/quote\]#si", "".$start_html."\\2".$end_html."", $text);
	return $text;
}
// Format spoiler
function escape1($matches){
	return "<div class=\"spoiler-wrap\"><div class=\"spoiler-head folded clickable\">Spoiler</div><div class=\"spoiler-body\"><textarea>".htmlspecialchars($matches[1])."</textarea></div></div>";
}

// Format spoiler from
function escape2($matches){
	return "<div class=\"spoiler-wrap\"><div class=\"spoiler-head folded clickable\">".$matches[1]."</div><div class=\"spoiler-body\"><textarea>".htmlspecialchars($matches[2])."</textarea></div></div>";
}
function encode_spoiler($text) {
	$text = preg_replace_callback("#\[hide\](.*?)\[/hide\]#si", 'escape1', $text);
	return $text;
}

// Format spoiler from
function encode_spoiler_from($text) {
	$text = preg_replace_callback("#\[hide=(.+?)\](.*?)\[/hide\]#si", 'escape2', $text);
	return $text;
}
function display_date_time($ts = 0 , $off = 0){
        return date("Y-m-d H:i:s", $ts + ($off * 60));
}
function textbbcode($form, $name, $content="") {
?>
<script type="text/javascript" language="javascript">
function RowsTextarea(n, w) {
	var inrows = document.getElementById(n);
	if (w < 1) {
		var rows = -5;
	} else {
		var rows = +5;
	}
	var outrows = inrows.rows + rows;
	if (outrows >= 5 && outrows < 50) {
		inrows.rows = outrows;
	}
	return false;
}

var SelField = document.<?php echo $form;?>.<?php echo $name;?>;
var TxtFeld  = document.<?php echo $form;?>.<?php echo $name;?>;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

function StoreCaret(text) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
}
function FieldName(text, which) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
	if (which != "") {
		var Field = eval("document.<?php echo $form;?>."+which);
		SelField = Field;
		TxtFeld  = Field;
	}
}
function AddSmile(SmileCode) {
	var SmileCode;
	var newPost;
	var oldPost = SelField.value;
	newPost = oldPost+SmileCode;
	SelField.value=newPost;
	SelField.focus();
	return;
}
function AddSelectedText(Open, Close) {
	if (SelField.createTextRange && SelField.caretPos && Close == '\n') {
		var caretPos = SelField.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? Open + Close + ' ' : Open + Close;
		SelField.focus();
	} else if (SelField.caretPos) {
		SelField.caretPos.text = Open + SelField.caretPos.text + Close;
	} else {
		SelField.value += Open + Close;
		SelField.focus();
	}
}
function InsertCode(code, info, type, error) {
	if (code == 'name') {
		AddSelectedText('[b]' + info + '[/b]', '\n');
	} else if (code == 'url' || code == 'mail') {
		if (code == 'url') var url = prompt(info, 'http://');
		if (code == 'mail') var url = prompt(info, '');
		if (!url) return alert(error);
		if ((clientVer >= 4) && is_ie && is_win) {
			selection = document.selection.createRange().text;
			if (!selection) {
				var title = prompt(type, type);
				AddSelectedText('[' + code + '=' + url + ']' + title + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + '=' + url + ']', '[/' + code + ']');
			}
		} else {
			mozWrap(TxtFeld, '[' + code + '=' + url + ']', '[/' + code + ']');
		}
	} else if (code == 'color' || code == 'family' || code == 'size') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + '=' + info + ']', '[/' + code + ']');
		} else if (TxtFeld.selectionEnd && (TxtFeld.selectionEnd - TxtFeld.selectionStart > 0)) {
			mozWrap(TxtFeld, '[' + code + '=' + info + ']', '[/' + code + ']');
		}
	} else if (code == 'li' || code == 'hr') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + ']', '');
		} else {
			mozWrap(TxtFeld, '[' + code + ']', '');
		}
	} else {
		if ((clientVer >= 4) && is_ie && is_win) {
			var selection = false;
			selection = document.selection.createRange().text;
			if (selection && code == 'quote') {
				AddSelectedText('[' + code + ']' + selection + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + ']', '[/' + code + ']');
			}
		} else {
			mozWrap(TxtFeld, '[' + code + ']', '[/' + code + ']');
		}
	}
}

function mozWrap(txtarea, open, close)
{
        var selLength = txtarea.textLength;
        var selStart = txtarea.selectionStart;
        var selEnd = txtarea.selectionEnd;
        if (selEnd == 1 || selEnd == 2)
                selEnd = selLength;

        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd)
        var s3 = (txtarea.value).substring(selEnd, selLength);
        txtarea.value = s1 + open + s2 + close + s3;
        txtarea.focus();
        return;
}

language=1;
richtung=1;
var DOM = document.getElementById ? 1 : 0, 
opera = window.opera && DOM ? 1 : 0, 
IE = !opera && document.all ? 1 : 0, 
NN6 = DOM && !IE && !opera ? 1 : 0; 
var ablauf = new Date();
var jahr = ablauf.getTime() + (365 * 24 * 60 * 60 * 1000);
ablauf.setTime(jahr);
var richtung=1;
var isChat=false;
NoHtml=true;
NoScript=true;
NoStyle=true;
NoBBCode=true;
NoBefehl=false;

function setZustand() {
	transHtmlPause=false;
	transScriptPause=false;
	transStylePause=false;
	transBefehlPause=false;
	transBBPause=false;
}
setZustand();
function keks(Name,Wert){
	document.cookie = Name+"="+Wert+"; expires=" + ablauf.toGMTString();
}
function changeNoTranslit(Nr){
	if(document.trans.No_translit_HTML.checked)NoHtml=true;else{NoHtml=false}
	if(document.trans.No_translit_BBCode.checked)NoBBCode=true;else{NoBBCode=false}
	keks("NoHtml",NoHtml);keks("NoScript",NoScript);keks("NoStyle",NoStyle);keks("NoBBCode",NoBBCode);
}
function changeRichtung(r){
	richtung=r;keks("TransRichtung",richtung);setFocus()
}
function changelanguage(){  
	if (language==1) {language=0;}
	else {language=1;}
	keks("autoTrans",language);
	setFocus();
	setZustand();
}
function setFocus(){
	TxtFeld.focus();
}
function repl(t,a,b){
	var w=t,i=0,n=0;
	while((i=w.indexOf(a,n))>=0){
		t=t.substring(0,i)+b+t.substring(i+a.length,t.length);	
		w=w.substring(0,i)+b+w.substring(i+a.length,w.length);
		n=i+b.length;
		if(n>=w.length){
			break;
		}
	}
	return t;
}
</script>
<textarea class="editorinput" id="area" name="<?php echo $name;?>" cols="65" rows="10" style="width:400px" onkeypress="" onselect="FieldName(this, this.name)" onclick="FieldName(this, this.name)" onkeyup="FieldName(this, this.name)"><?php echo $content;?></textarea>
<div class="editor" style="background-image: url(img/editor/bg.gif); background-repeat: repeat-x;">
	<div class="editorbutton" onclick="RowsTextarea('area',1)"><img title="Increase size" src="img/editor/plus.gif" /></div>
	<div class="editorbutton" onclick="RowsTextarea('area',0)"><img title="Decrease size" src="img/editor/minus.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('b')"><img title="Bold" src="img/editor/bold.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('i')"><img title="Italic" src="img/editor/italic.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('u')"><img title="Underline" src="img/editor/underline.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('s')"><img title="Strikethrought" src="img/editor/striket.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('li')"><img title="List" src="img/editor/li.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('hr')"><img title="Horizontal Line" src="img/editor/hr.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('left')"><img title="Align left" src="img/editor/left.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('center')"><img title="Align center" src="img/editor/center.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('right')"><img title="Align right" src="img/editor/right.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('justify')"><img title="Align both sides" src="img/editor/justify.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('code')"><img title="Code" src="img/editor/code.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('php')"><img title="PHP-Code" src="img/editor/php.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('hide')"><img title="Hide" src="img/editor/hide.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('url','Link','Link','Input full adress!')"><img title="Link" src="img/editor/url.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('mail','Link','Link','Input full adress!')"><img title="E-Mail" src="img/editor/mail.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('img')"><img title="Image" src="img/editor/img.gif" /></div>
</div>
<div class="editor" style="background-image: url(img/editor/bg.gif); background-repeat: repeat-x;">
	<div class="editorbutton" onclick="InsertCode('quote')"><img title="Quote" src="editor/quote.gif" /></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="family" onchange="InsertCode('family',this.options[this.selectedIndex].value)"><option style="font-family:Verdana;" value="Verdana">Verdana</option><option style="font-family:Arial;" value="Arial">Arial</option><option style="font-family:'Courier New';" value="Courier New">Courier New</option><option style="font-family:Tahoma;" value="Tahoma">Tahoma</option><option style="font-family:Helvetica;" value="Helvetica">Helvetica</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="color" onchange="InsertCode('color',this.options[this.selectedIndex].value)"><option style="color:black;" value="black">Black</option><option style="color:silver;" value="silver">Silver</option><option style="color:gray;" value="gray">Gray</option><option style="color:white;" value="white">White</option><option style="color:maroon;" value="maroon">Maroon</option><option style="color:red;" value="red">Red</option><option style="color:purple;" value="purple">Purple</option><option style="color:fuchsia;" value="fuchsia">Fuchsia</option><option style="color:green;" value="green">Green</option><option style="color:lime;" value="lime">Lime</option><option style="color:olive;" value="olive">Olive</option><option style="color:yellow;" value="yellow">Yellow</option><option style="color:navy;" value="navy">Navy</option><option style="color:blue;" value="blue">Blue</option><option style="color:teal;" value="teal">Teal</option><option style="color:aqua;" value="aqua">Aqua</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="size" onchange="InsertCode('size',this.options[this.selectedIndex].value)"><option value="8">Size 8</option><option value="10">Size 10</option><option value="12">Size 12</option><option value="14">Size 14</option><option value="18">Size 18</option><option value="24">Size 24</option></select></div>
</div>
<?php
}
function get_date_time($timestamp = 0) {
	if ($timestamp)
		return date("Y-m-d H:i:s", $timestamp);
	else
		return date("Y-m-d H:i:s");
}
?>