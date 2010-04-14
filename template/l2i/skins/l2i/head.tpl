<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
{add_meta}
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="{MetaD}" />
<meta name="keywords" content="{MetaK}" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="2009 - {year} Lineage II Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title>{title}</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="{skinurl}/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="{static}/scripts/show.js"></script>
<script type="text/javascript" language="javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript" language="javascript">
try {
var pageTracker = _gat._getTracker("UA-11986252-1");
pageTracker._trackPageview();
} catch(err) {}

function GoTo(url)
{
	window.location.href = url;
}

</script>
<script type="text/javascript" src="{static}/scripts/ajax.js"></script>
<script type="text/javascript">
var ajax = new Array();

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
background : url('{skinurl}/header.jpg') fixed top center no-repeat #191919;
cursor : url('{skinurl}/cursors/cursor.cur'), auto;
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
<img style="border:0;width:88px;height:31px" src="{static}/img/valid-xhtml.png" alt="Valid XHTML 1.0 Transitional" />
</a><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="{static}/img/valid-css.png" alt="Valid CSS!" /></a>
<a href="http://games.top.org/lineage-2/" title="Lineage 2 TOP.ORG"><img style="border:none;" src="http://img1.top.org/toporg_12309.gif" alt="Lineage 2 TOP.ORG" /></a>
</div>
<div id="frm"><img width="150" height="150" border="0" longdesc="/" usemap="#Map" alt="Visit forum" style="" src="{static}/img/visit_forum.png" />
<map id="Map" name="Map">
<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77" shape="poly" alt="" />

</map></div>
<div id="logoLink">
<a href="" title="Fantasy World Home">
</a></div>