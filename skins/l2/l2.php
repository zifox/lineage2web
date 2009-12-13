<?php
DEFINE('INSKIN', True);
require_once('skins/l2/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $Config['MetaD']; ?>" />
<meta name="keywords" content="<?php echo $Config['MetaK']; ?>" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title><?php echo $Config['Title']; ?></title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="<?php echo $skindir;?>style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="scripts/overlib.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11986252-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</head>
<body style="background-color: #191919;">


<div align="center" >
<?php
//пароль
$rnd = rand(1,10);
includeLang('skin');

?>
<style type="text/css">
#logo
{
    width: auto;
    border: 0;
    background-color: #000;
    background-image: url('<?php echo $skindir.'bg/'.$rnd;?>.jpg');
    background-position: left top;
    background-repeat: no-repeat;
}
</style>
<table cellpadding="0" cellspacing="0" id="logo">
<tr>
<td height="220px"></td>
</tr>
<tr>
	<td width="100%" height="48" align="center">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="19" height="48" background="<?php echo $img;?>t_h_lc.gif"></td>
				<td width="106" height="48" background="<?php echo $img;?>t_h_c_l.gif"></td>
				<td width="60" height="48" background="<?php echo $img;?>t_h_rp.gif"></td>
				<td width="232" height="48" background="<?php echo $img;?>t_h_c.gif"></td>
				<td width="60" height="48" background="<?php echo $img;?>t_h_c.gif"></td>
				<td width="106" height="48" background="<?php echo $img;?>t_h_c_r.gif"></td>
				<td width="19" height="48" background="<?php echo $img;?>t_h_rc.gif"></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td width="100%" >
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>

				<td width="189" height="600" valign="top" align="center">

<?php
includeBlock('login', $Lang['login']);
includeBlock('menu', $Lang['menu']);
includeBlock('vote', $Lang['vote']);
?>

<td id="main" width="648" align="center" valign="top">
<table width="602"  cellpadding="0" cellspacing="0">
<tr>
<td background="<?php echo $img;?>t_h_bl.jpg" width="16" ></td>
<td background="<?php echo $img;?>t_bg.gif" width="567" valign="top" align="center">
<?php
if($Config['enable_news'])
{
    echo "<h1><font color=\"#7ba813\"><b>{$Config['news']}</b></font></h1>";
}
?>
								<hr /><br /><br /><br />
<?php
if($id && file_exists('module/'.$id . '.php'))
	{
	require_once('module/'.$id . '.php');
	}
	else
	{
	require_once('module/start.php');
}
?>

											</td>
							<td background="<?php echo $img;?>t_h_br.jpg" width="19"></td>
						</tr>
						<tr>
							<td background="<?php echo $img;?>t_b_lc.gif" width="16" height="22"></td>
							<td background="<?php echo $img;?>t_b_c.gif" width="567" height="22"></td>
							<td background="<?php echo $img;?>t_b_rc.gif" width="19" height="22"></td>

						</tr>
					</table>

						  <td align="center" valign="top">
								<?php
								includeBlock('stats', $Lang['stats'], true);
								includeBlock('top10', $Lang['top10'], true);
                                if($id=='vote'){
                                includeBlock('wos', 'Vote', false);
                                }
								?>
						        </td>
						</tr>
						
					</table>
				</td>
			</tr>
			<tr align="center" valign="top">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						 
							<td align="center" valign="middle"><?php echo $Config['CopyRight']; ?></td>
							
						</tr>
                        <tr>
						 <?php includeLang('Langinfo');?>
							<td align="center" valign="middle"><?php echo $Lang['Language'].": <a href=\"#\" onmouseover=\"return overlib('<table border=0><tr><td>{$Lang['translater']}:</td><td>{$Lang['translated_by']}</td></tr><tr><td>{$Lang['last_updated']}:</td><td>{$Lang['last_updated_date']}</td></tr></table>', LEFT, ABOVE, CAPTION, 'Language Info', FGCOLOR, '#999999', BGCOLOR, '#333333', BORDER, 3, CAPTIONFONT, 'Garamond', TEXTFONT, 'Courier', CAPTIONSIZE, 3, TEXTSIZE, 2, STICKY, MOUSEOFF, DELAY, 150, WIDTH, 150 );\" onmouseout=\"return nd();\">{$Lang['language']}</a>"; ?></td>
							
						</tr>
					</table>
				</td>
			</tr>
		</table>
</div>
	</body>
</html>