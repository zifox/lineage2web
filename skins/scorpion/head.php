<?php
if(!defined('INSKIN'))header("Location: ../../index.php");
//$expires = 60*60*24*14;
$expires = 0;
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
header('Content-Type: gzip');
//пароль
includeLang('skin');

$parse['title'] = $title;
$parse['skinurl'] = '/skins/scorpion';
$skinurl = 'skins/scorpion';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php if ($url != ''){ ?><meta http-equiv="refresh" content="<?php echo $time;?> URL=<?php echo $url;?>" /> <?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo getConfig('head', 'MetaD', 'Fantasy World x50');?>" />
<meta name="keywords" content="<?php echo getConfig('head', 'MetaK', 'Lineage, freya, high, five, mid-rate, pvp');?>" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="2009 - <?php echo date('Y');?> Lineage II Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title><?php echo $title;?></title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="skins/l2f/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="scripts/show.js"></script>
<script type="text/javascript" language="javascript">
document.write(unescape("%3Cscript src='scripts/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript" src="scripts/ajax.js"></script>
<script type="text/javascript" language="javascript">
<!--
function ViewPic(img) {
    window.open( "viewimg.php?"+img, "", "resizable=0,HEIGHT=200,WIDTH=200");
} 
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

function raiseVitality(server, charac, id)
{

    if(confirm('<?php echo sprintf($Lang['confirm_vit'], getConfig('voting', 'vitality_cost', '1'));?>'))
    {
    	var index = ajax.length;
    	ajax[index] = new sack();
		
    	ajax[index].requestFile = 'raisevitality.php?server='+server+'&char='+charac+'&id='+id;	
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
// -->
</script>

<style type="text/css">
body  {
margin : 0px;
font-size : 14px;
font-family : Arial;
background-color: #000000;


cursor : url('<?php echo $skinurl;?>/cursors/cursor.cur'), auto;

}
#menu
{
    width: 800px;
    height: 86px;
    padding-top: 20px;
    padding-left: 25px;
    padding-right: 25px;
    font-size: 18px;
    font-weight: bold;
    font-family: cursive;
    text-align: center;
}
.opacity1 {
filter: alpha(opacity=70);
opacity: 0.7;
} 
.opacity2 {
filter: alpha(opacity=85);
opacity: 0.85;
}
#status, #sstatus {
    font-size:  5px !important;
    line-height: 3px;
    margin: 0px;
}
#info2 {
    font-size: 12px !important;
}
</style>
</head>
<body>
<script type="text/javascript" src="scripts/wz_tooltip.js"></script>
<div id="bg" style="z-index: -1;"><img src="<?php echo $skinurl;?>/img/background.jpg" width="100%" height="100%" alt="" /></div>
<div id="frm"><img width="150" height="150" border="0" longdesc="/" usemap="#Map" alt="Visit forum" style="" src="img/visit_forum.png" />
<map id="Map" name="Map">
<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77,3,119" shape="poly" alt="" />
</map></div>
<?php
if($head){
    ?>
    <div id="menu" class="opacity2" style="position: absolute; left: 200px; top: 120px; z-index: 1; background: url('<?php echo $skinurl;?>/img/menu3.png') 850px 106px;">
    <a href="index.php">Home</a> | <a href="reg.php">Registration</a> | <a href="connect.php">Connect</a> | <a href="webshop.php">WebShop</a> | <a href="/forum" target="_blank">Forum</a> | <a href="stat.php">Stats</a> | <a href="rules.php">Rules</a> | <a href="donate.php">Donate</a>
    </div>
    <div id="content" class="opacity2" style="position: absolute; left: 200px; top: 220px; z-index: 1;">
    <table>
    <tr><td width="600px" height="69px" style="background: url('<?php echo $skinurl;?>/img/contbg_top.png');">&nbsp;</td></tr>
    <tr><td align="center" width="600px" height="auto" style="background: url('<?php echo $skinurl;?>/img/contbg_mid.png');">
    
    <?php
if(getConfig('news', 'show_announcement', '1'))
    echo "<h1>".getConfig('news', 'announcement', 'Welcome to Fantasy World Freya x50')."</h1>";
$sql->query("SELECT Count(*) AS new FROM l2web.messages WHERE receiver='{$_SESSION['account']}' AND unread='yes'");
$msg=$sql->fetch_array();
if($user->logged() && $msg['new']>0)
{
    $title=sprintf($Lang['unread_msg'], $msg['new'], $msg['new']=='1'?'':$Lang['s']);
    msg('','<a href="message.php?viewmailbox&amp;box=1">'.$title.'</a>');
}
}

?>