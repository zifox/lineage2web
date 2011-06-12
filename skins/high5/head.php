<?php
if(!defined('INSKIN'))header("Location: ../../index.php");
//$expires = 60*60*24*14;
$expires = 0;

header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
//header('Content-Type: application/xhtml+xml');
header('Content-Type: gzip');
//пароль
includeLang('skin');

$parse['title'] = $title;
$parse['skinurl'] = '/skins/high5';
$skinurl = 'skins/high5';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

		<link rel="stylesheet" href="<?php echo $skinurl;?>/style.css" type="text/css" />
	</head>
	<body id="main_body"><script type="text/javascript" src="scripts/wz_tooltip.js"></script>
    <div id="logo2">
			<div align="left"><a href="#"><img src="<?php echo $skinurl;?>/img/logo.png" alt="Lineage II Fantasy World High Five" align="top" /></a></div>
	</div>
            <?php
        if($head){
            ?>
<div id="container">
		<!--header-->
		<div id="header"><div id="logo"></div></div>
		<!--/header-->

		<!--main_content-->
			<div id="main_content">
			<!--left_part-->
				<div class="left_part">
					<div class="block"><div class="block_top"><div class="block_bt" style="text-align: center;">
                    <div class="title"><?php echo (!$user->logged()) ? $Lang['login']: $_SESSION['account'];?></div>
						<?php echo includeBlock('login', 'Login',0,'false');?>
					</div></div></div>
					<div class="block1"><div class="block_top"><div class="block_bt" style="text-align: center;">
						<div class="title">Menu</div>
						<?php echo includeBlock('menu', 'Menu',0,'false');?>
					</div>
					</div></div>
				</div>
			<!--/left_part-->
			<!--content-->
				<div class="content">
					<div class="new">
                    	<div class="create" style="text-align: center;" align="center">
                    <?php
                    }
                    if(getConfig('news', 'show_announcement', '1'))
    echo "<h1>".getConfig('news', 'announcement', 'Welcome to Fantasy World High Five x50')."</h1>";
$sql->query("SELECT Count(*) AS new FROM l2web.messages WHERE receiver='{$_SESSION['account']}' AND unread='yes'");
$msg=$sql->fetch_array();
if($user->logged() && $msg['new']>0)
{
    $title=sprintf($Lang['unread_msg'], $msg['new'], $msg['new']=='1'?'':$Lang['s']);
    msg('','<a href="message.php?viewmailbox&amp;box=1">'.$title.'</a>');
}
?>