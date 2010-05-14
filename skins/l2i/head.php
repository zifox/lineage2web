<?php
if(!defined('INSKIN')){Header("Location: ../../index.php");}
//$expires = 60*60*24*14;
$expires = 0;
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header('Content-Type: gzip');

//пароль
includeLang('skin');


$parse['title'] = $title;
$parse['skinurl'] = '/skins/l2i';
$skinurl = 'skins/l2i';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php
if ($url != '')
{
    ?>
<meta http-equiv="refresh" content="<?php echo $time;?> URL=<?php echo $url;?>" />
<? } ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $Config['MetaD'];?>" />
<meta name="keywords" content="<?php echo $Config['MetaK'];?>" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="2009 - <?php echo date('Y');?> Lineage II Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title><?php echo $title;?></title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="skins/l2i/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="scripts/show.js"></script>
<script type="text/javascript" language="javascript">
document.write(unescape("%3Cscript src='scripts/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript" src="scripts/ajax.js"></script>
<script type="text/javascript" language="javascript">
function GoTo(url)
{
	window.location.href = url;
}

try {
var pageTracker = _gat._getTracker("UA-11986252-1");
pageTracker._trackPageview();
} catch(err) {
    
}

var ajax = new Array();

function raiseVitality(server, charac)
{

    if(confirm('Are you sure you want to raise your vitality points? It will cost you 1 WebPoint'))
    {
    	var index = ajax.length;
    	ajax[index] = new sack();
		
    	ajax[index].requestFile = 'raisevitality.php?server='+server+'&char='+charac;	
        ajax[index].onCompletion = function(){ evaluateresponse(index) };
    	ajax[index].runAJAX();
    }
}
function evaluateresponse(index)
{
    eval(ajax[index].response);
}
function map(server, charac)
{
	var index = ajax.length;
	ajax[index] = new sack();
		
	ajax[index].requestFile = 'map.php?server='+server+'&char='+charac;	
    ajax[index].onCompletion = function(){ checkMap(index) };
	ajax[index].runAJAX();
}

function checkMap(index)
{
    var obj = document.getElementById('onlinemap');
    eval(ajax[index].response);
}
function getCharList(sel)
{
	var server = sel.options[sel.selectedIndex].value;
	document.getElementById('char').options.length = 0;	
	if(server.length>0){
		var index = ajax.length;
		ajax[index] = new sack();
		
		ajax[index].requestFile = 'getchar.php?server='+server;	
		ajax[index].onCompletion = function(){ createChars(index) };
		ajax[index].runAJAX();
	}
}

function createChars(index)
{
	var obj = document.getElementById('char');
	eval(ajax[index].response);
}	
</script>
<style type="text/css">
body  {
margin : 5px;
font-size : 12px;
font-family : Arial, Helvetica, sans-serif;
color : #ffffff;
background : url('<?php echo $skinurl;?>/img/header.jpg') fixed top center no-repeat #191919;
cursor : url('<?php echo $skinurl;?>/cursors/cursor.cur'), auto;
}
#logoLink {
margin:35px 0 50px;
text-align:center;
}
#logoLink a {
display:block;
height:120px;
left:-300px;
margin-left:auto;
margin-right:auto;
position:relative;
width:450px;
}
.opacity1 {
filter: alpha(opacity=70);
opacity: 0.7;
} 
.opacity2 {
filter: alpha(opacity=85);
opacity: 0.85;
}
</style>
</head>
<body>
<div id="valid">
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-xhtml.png" alt="Valid XHTML 1.0 Transitional" />
</a><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-css.png" alt="Valid CSS!" /></a>
<a href="http://games.top.org/lineage-2/" title="Lineage 2 TOP.ORG"><img style="border:none;" src="http://img1.top.org/toporg_12309.gif" alt="Lineage 2 TOP.ORG" /></a>
</div>
<div id="frm"><img width="150" height="150" border="0" longdesc="/" usemap="#Map" alt="Visit forum" style="" src="img/visit_forum.png" />
<map id="Map" name="Map">
<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77" shape="poly" alt="" />

</map></div>
<div id="logoLink">
<a href="" title="Fantasy World Home">
</a></div>
<?
if($head){
?>

<table width="100%" cellpadding="0" cellspacing="0" align="center">
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
            <table width="99%" cellspacing="0" cellpadding="0" border="0" align="right" class="opacity2" style="height: 100px;">
                <tbody>
                <tr>
                    <td width="40"><img width="40" height="53" alt="" src="<?php echo $skinurl;?>/img/t_h_lc.gif" /></td>
                    <td width="1"><img width="1" height="53" alt="" src="<?php echo $skinurl;?>/img/t_h_l_c.gif" /></td>
                    <td width="335" style="background-image: url(<?php echo $skinurl;?>/img/t_h_cl.gif);">&nbsp;</td>
                    <td width="480" style="">
	                   <table width="100%" style="height:53px;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr>
                            <td height="19" style="background-image: url(<?php echo $skinurl;?>/img/t_h_c.gif); background-repeat: no-repeat; background-position: center center;"><div align="center">Main</div></td>
                        </tr></tbody></table></td>
                    <td width="309" style="background-image: url(<?php echo $skinurl;?>/img/t_h_cr.gif);">&nbsp;</td>
                    <td width="1"><img width="1" height="53" alt="" src="<?php echo $skinurl;?>/img/t_h_r_c.gif" /></td>
                    <td width="40"><img width="40" height="53" alt="" src="<?php echo $skinurl;?>/img/t_h_rc.gif" /></td>
                </tr>
                <tr>
                    <td style="background-image: url(<?php echo $skinurl;?>/img/t_h_l_b.gif);">&nbsp;</td>
                    <td bgcolor="#37301d" colspan="5" align="center">
<?php
echo "<h1>{$Config['news']}</h1>";
?>
<hr />
<?php
}
?>