<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 2.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml2.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
{refresh}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="{metad}" />
<meta name="keywords" content="{metak}" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="{copy}" />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="{gsv}" />

<title>{title}</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="{skinurl}/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="scripts/show.js"></script>
<script type="text/javascript" language="javascript">//<![CDATA[ 
//document.write(unescape("%3Cscript src='scripts/ga.js' type='text/javascript'%3E%3C/script%3E")); //]]></script>
<script type="text/javascript" src="scripts/ajax.js"></script>
<script type="text/javascript" language="javascript">
//<![CDATA[
var active = true;
var step = -1;
step = Math.ceil(step);
if (step == 0)
  active = false;
var TimeFormat = "%%H%% {hours}, %%M%% {minutes}, %%S%% {seconds}.";
var endmsg = "<a href=\"vote.php\">{vote}</a>";
var secs = "{time}";
var date = new Date();
var time = date.getTime()/1000;
secs = Math.floor(secs - time);
function calctime(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}

function Clock(secs) {
  if (secs < 0) {
  	if(document.getElementById("vote")!=null)
  	{
    	document.getElementById("vote").innerHTML = endmsg;
    }
    return;
  }
  ShowTime = TimeFormat.replace(/%%D%%/g, calctime(secs,86400,100000));
  ShowTime = ShowTime.replace(/%%H%%/g, calctime(secs,3600,24));
  ShowTime = ShowTime.replace(/%%M%%/g, calctime(secs,60,60));
  ShowTime = ShowTime.replace(/%%S%%/g, calctime(secs,1,60));

  document.getElementById("vote").innerHTML = ShowTime;
  if (active)
    setTimeout("Clock(" + (secs+step) + ")", (Math.abs(step)-1)*1000 + 990);
}
function getEle(name)
{
    return document.getElementById(name);
}
function onLoad()
{
	var width = document.documentElement.clientWidth-482;
	var width2 = width-2;
	var ele=document.getElementById('main_top_center');
	var ele2=document.getElementById('main_bot_center');
	var ele3=document.getElementById('content');
	if(ele!=null&&ele2!=null)
	{
		ele.setAttribute('style', 'width: '+width+'px;');
		ele2.setAttribute('style', 'width: '+width+'px;');
		ele3.setAttribute('style', 'width: '+width2+'px;');
		ele.width=width;
		ele2.width=width;
		ele3.width=width2;
		window.onresize = function()
		{
			var width = document.documentElement.clientWidth-482;
			var width2 = width-2;
			var ele=document.getElementById('main_top_center');
			var ele2=document.getElementById('main_bot_center');
			var ele3=document.getElementById('content');
			if(ele!=null&&ele2!=null)
			{
				ele.setAttribute('style', 'width: '+width+'px;');
				ele2.setAttribute('style', 'width: '+width+'px;');
				ele3.setAttribute('style', 'width: '+width2+'px;');
				ele.width=width;
				ele2.width=width;
				ele3.width=width2;
			}
		};
	}
}
function resizeBlocks()
{
		var sizeX = window.innerWidth;
	document.getElementById('main_top_center').style.width=sizeX-480;
	alert('window resized!');
}
function ViewPic(img)
{
	window.open( "viewimg.php?"+img, "", "resizable=0,HEIGHT=200,WIDTH=200");
} 
function GoTo(url)
{
	window.location.href = url;
}

try {
var pageTracker = _gat._getTracker("{page_tracker}");
pageTracker._trackPageview();
} catch(err) { }

var ajax = new Array();

function raiseVitality(server, charac, id)
{
	
	if(confirm('{lang_confirm_vit}'))
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
	if(server.length>0)
	{
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
function toogleDebugBar()
{
    var ele=getEle('debug-bar');
    var ele2=getEle('show_debug_bar');
    var var_value;
    if(ele.style.display=='block')
    {
        ele.style.display='none';
        ele2.style.display='block';
        var_value=0;
    }
    else
    {
        ele.style.display='block';
        ele2.style.display='none';
        var_value=1;
    }
    var index = ajax.length;
    ajax[index] = new sack();
    ajax[index].requestFile = 'ajax/var.php?var=debug_menu&value='+var_value;
    ajax[index].runAJAX();
}
function toogle_Debug()
{
    var cont=getEle('debug-bar-content');
    var img=getEle('img_debug_toogle');
    if(cont.style.display=='none')
    {
        cont.style.display='block';
        img.src='img/down.png';
    }
    else
    {
        cont.style.display='none';
        img.src='img/up.png';
    }
}
//]]>
</script>
<style type="text/css">
table
{
	border-spacing: 0px;
}
body
{
	margin : 0px;
	font-size : 14px;
	font-family : Arial;
	color : #ffffff;

	cursor : url('{skinurl}/cursors/cursor.cur'), auto;
	background: #406072;
}
#logo
{
	display:block;
	z-index: 0;
	/*left:125px;*/
	top:0px;
	position: absolute;
	text-align: center;
	width: auto;
}
#freya
{
	display:block;
	z-index: 0;
	right:0px;
	top:30px;
	position: absolute;
	text-align: center;
}
#header
{
	height: 300px;
	right: 50px;
	top: 50px;
	text-align: right;
}
.opacity1
{
	/*filter: alpha(opacity=70);*/
	opacity: 0.7;
} 
.opacity2
{
	/*filter: alpha(opacity=85);*/
	opacity: 0.85;
}
.block_top
{
	background:url({skinurl}/img/block_head.gif) 0 0 no-repeat;
	width:200px;
	height:50px;
	display: block;
	text-align: center;
}
.block_title
{
	padding-top:15px;
}

.block_bot
{
	display: block;
	width:200px;
	height:26px;
	background:url({skinurl}/img/block_foot.gif) 0 0 no-repeat;
}
.block_mid
{
	display: block;
	background:url({skinurl}/img/block_mid.gif) 0 0 repeat-y;
	width:200px;
}

table.c11 { height: 100px; }
td.c10 {  }
td.c9 { background-image: url({skinurl}/img/t_h_cr.gif); }
td.c7 {  }
div.c6 { height:53px; text-align: center; display:block; background-image: url({skinurl}/img/t_h_c.gif); background-repeat: no-repeat; background-position: center center; }
td.c5 { background-image: url({skinurl}/img/t_h_cl.gif); }
div.c4 { position: right; }
div.c3 { position: center; }
img.c2 { border: 0px; }
div.c1 { position: absolute;z-index: -1; }
</style>
</head>
<body onload="onLoad();">
<script type="text/javascript" src="scripts/wz_tooltip.js"></script>
<!--<div id="valid">
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-xhtml.png" alt="Valid XHTML 1.0 Transitional" />
</a><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-css.png" alt="Valid CSS!" /></a>
<a href="http://games.top.org/lineage-2/" title="Lineage 2 TOP.ORG"><img style="border:none;" src="http://img1.top.org/toporg_12309.gif" alt="Lineage 2 TOP.ORG" /></a>
</div>-->

<div id="bg" class="c1">
    <img src="{skinurl}/bg/bg.jpg" width="100%" alt="" title="{title_desc}" />
</div>

<div id="frm">
	<img width="150" height="150" usemap="#Map" alt="{visit_forum}" class="c2" src="img/visit_forum.png" />
	<map id="Map" name="Map">
		<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77,3,119" shape="poly" alt="" />
	</map>
</div>

<div id="logo" class="c3" align="center">
	<img alt="" width="100%" class="c2" src="{skinurl}/bg/{bg_nr}.png" />
</div>

<div id="freya" class="c4">
	<img alt="" class="c2" src="img/image.png" />
</div>

<div id="header"></div>
{head}