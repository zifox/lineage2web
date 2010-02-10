<?php
if(!defined('INSKIN')){Header("Location: ../../index.php");}
header("Cache-control: private");
header("Expires: -1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $Config['MetaD']; ?>" />
<meta name="keywords" content="<?php echo $Config['MetaK']; ?>" />
<meta name="Author" content="Artūrs Grinbergs" />
<meta name="Date" content="<?php date("M")?> <?php date("j")?>, <?php date("Y")?>" />
<meta name="Copyright" content="2009-<?php date("Y")?> L2 Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title><?php echo $title; ?></title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="skins/<?php echo $skin;?>/style.css" type="text/css" rel="stylesheet" />
<?php //<script type="text/javascript" src="scripts/overlib.js"></script>?>
<script type="text/javascript" language="javascript" src="scripts/show.js"></script>
<script type="text/javascript" language="javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript" language="javascript">
try {
var pageTracker = _gat._getTracker("UA-11986252-1");
pageTracker._trackPageview();
} catch(err) {}
</script>

<?php
//пароль
$rnd = rand(1,10);
includeLang('skin');
?>
<style type="text/css">
body  {
margin : 5px;
font-size : 12px;
font-family : Arial, Helvetica, sans-serif;
color : #ffffff;
background : #191919;
background-color : #191919;
background-image : url('skins/l2i/bg/<?php echo $rnd;?>.jpg');
background-position: top;
background-repeat : no-repeat;
cursor : url('cursors/cursor.cur'), auto;
}
<?php
if ($head){?>
.opacidad1 {
-moz-opacity:0.7;
filter: alpha(opacity=70);
 opacity: 0.7;
} 
.opacidad2 {
-moz-opacity:0.85;
filter: alpha(opacity=85);
 opacity: 0.85;
}<?php } ?>
</style>
</head>
<body>
<?php
if($head){
?>

<div id="frm"><img width="150" height="150" border="0" longdesc="/" usemap="#Map" alt="Visit forum" style="" src="img/visit_forum.png" />
<map id="Map" name="Map">
<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77" shape="poly" alt="" />
<area href="./" coords="145,114,10,116,88,37,146,37" shape="poly" alt="" />
<area href="./" coords="13,62,43,37,13,37" shape="poly" alt="" />
</map></div>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<tr>
<td height="200px"></td>
</tr>
<tr>
	<td width="100%" >
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td width="15%" valign="top" align="center">
        
<?php
includeBlock('login', $Lang['login']);
includeBlock('menu', $Lang['menu']);
includeBlock('vote', $Lang['vote']);
?>
        </td>
        <td id="main" width="70%" align="center" valign="top">
            <table width="99%" cellspacing="0" cellpadding="0" border="0" align="right" id="Tabla_01" class="opacidad2" style="height: 100px;">
                <tbody>
                <tr>
                    <td width="40"><img width="40" height="53" alt="" src="skins/<?php echo $skin;?>/img/t_h_lc.gif" /></td>
                    <td width="1"><img width="1" height="53" alt="" src="skins/<?php echo $skin;?>/img/t_h_l_c.gif" /></td>
                    <td width="335" style="background-image: url(skins/<?php echo $skin;?>/img/t_h_cl.gif);">&nbsp;</td>
                    <td width="480" style="">
	                   <table width="100%" style="height:53px;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr>
                            <td height="19" style="background-image: url(skins/<?php echo $skin;?>/img/t_h_c.gif); background-repeat: no-repeat; background-position: center center;"><div align="center">Main</div></td>
                        </tr></tbody></table></td>
                    <td width="309" style="background-image: url(skins/<?php echo $skin;?>/img/t_h_cr.gif);">&nbsp;</td>
                    <td width="1"><img width="1" height="53" alt="" src="skins/<?php echo $skin;?>/img/t_h_r_c.gif" /></td>
                    <td width="40"><img width="40" height="53" alt="" src="skins/<?php echo $skin;?>/img/t_h_rc.gif" /></td>
                </tr>
                <tr>
                    <td style="background-image: url(skins/<?php echo $skin;?>/img/t_h_l_b.gif);">&nbsp;</td>
                    <td bgcolor="#37301d" colspan="5" align="center">
<?php
if($Config['enable_news'])
{
    echo "<h1>{$Config['news']}</h1>";
}
?>
<hr />
<?php
}
?>