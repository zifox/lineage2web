<? include 'cfg/castle.php'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>..:: <? echo $htitle; ?> ::..</title>
<style type="text/css">
<!--
body {margin:0px}

#castleinfo{ 
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000000; 
	visibility:visible;
	position:absolute; 
	width:160px; 
	height:347px; 
	z-index:8; 
	left: 40px; 
	top: 200px;
	overflow:auto;
}

#adeninfo{visibility:hidden;}
#dioninfo{visibility:hidden;}
#giraninfo{visibility:hidden;}
#gludioinfo{visibility:hidden;}
#innadrilinfo{visibility:hidden;}
#oreninfo{visibility:hidden;}
#godadinfo{visibility:hidden;}
#castleinfo strong{font-family:Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">


oreninfo = '<strong>Oren Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $orenOwner;?><br/><strong>Tax:</strong><br/><? echo $orenTax;?><br/><strong>Siege:</strong><br/><? echo $orenSiegeDate;?><br/>';
adeninfo =  '<strong>Aden Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $adenOwner;?><br/><strong>Tax:</strong><br/><? echo $adenTax;?><br/><strong>Siege:</strong><br/><? echo $adenSiegeDate;?><br/>';
innadrilinfo =  '<strong>Innadril Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $innadrilOwner;?><br/><strong>Tax:</strong><br/><? echo $innadrilTax;?><br/><strong>Siege:</strong><br/><? echo $innadrilSiegeDate;?><br/>';
dioninfo = '<strong>Dion Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $dionOwner;?><br/><strong>Tax:</strong><br/><? echo $dionTax;?><br/><strong>Siege:</strong><br/><? echo $dionSiegeDate;?><br/>';
giraninfo =   '<strong>Giran Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $giranOwner;?><br/><strong>Tax:</strong><br/><? echo $giranTax;?><br/><strong>Siege:</strong><br/><? echo $giranSiegeDate;?><br/>';
gludioinfo= '<strong>Gludio Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $gludioOwner;?><br/><strong>Tax:</strong><br/><? echo $gludioTax;?><br/><strong>Siege:</strong><br/><? echo $gludioSiegeDate;?><br/>';
godadinfo= '<strong>Goddard Castle</strong><br/><br/><strong>Owner:</strong><br/><?echo $godadOwner;?><br/><strong>Tax:</strong><br/><? echo $godadTax;?><br/><strong>Siege:</strong><br/><? echo $godadSiegeDate;?><br/>';
function displayControlText (name, state) {
	var object = "castleinfo";
	var innertext;
	switch (name){
		case 'oren': innertext=oreninfo;break;
		case 'aden': innertext=adeninfo;break;
		case 'innadril': innertext=innadrilinfo;break;
		case 'dion': innertext = dioninfo;break;
		case 'giran': innertext=giraninfo;break;
		case 'gludio': innertext=gludioinfo;break;
		case 'godad': innertext=godadinfo;break;
		}	
	if (state == "show"){
		//alert('showing');
    	if (document.getElementById && document.getElementById(object) != null) {
		 document.getElementById(object).innerHTML = innertext;		
         document.getElementById(object).style.visibility='visible';
         document.getElementById(object).style.display='block';
		}		
	} else {
		//alert('hiding');
    	if (document.getElementById && document.getElementById(object) != null) {
         document.getElementById(object).style.visibility='hidden';
         document.getElementById(object).style.display='none';
		}			
	}
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0

  var argv = MM_showHideLayers.arguments;
  var name = argv[0]; 
  var state = argv[2]; 
  
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
	
	displayControlText(name, state);

}


</script>

</head>
<body bgcolor="#111111"  >

<div id="Background" style="position:relative; width:739px; height:799px; z-index:1; margin:10px 10px -40px 10px; top:-25px; overflow:hidden;"><img src="img/background.jpg" width="739" height="799" border="0" usemap="#Map">

  <div id="adeninfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">aden</div>
  <div id="dioninfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">dion</div>
  <div id="giraninfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">giran</div>
  <div id="gludioinfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">gludio</div>
  <div id="innadrilinfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">innadril</div>
  <div id="oreninfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">oren</div>        
  <div id="godadinfo" style="position:absolute; width:126px; height:122px; z-index:8; left: 33px; top: 46px;">godad</div>         
  
  <div id="castleinfo">To view information Move your pointer over to the Castle</div>          

  <div id="aden" style="position:absolute; width:401px; height:578px; z-index:2; left: 233px; top: 203px; visibility: hidden;"><img src="img/aden.gif" width="401" height="578" border="0" usemap="#Map2"></div>
  <div id="godad" style="position:absolute; width:25px; height:43px; z-index:8; left: 603px; top: 80px; visibility: hidden;"><img src="img/goddard.gif" width="25" height="43" onMouseOver="MM_showHideLayers('godad','','show')" onMouseOut="MM_showHideLayers('godad','','hide')"></div>
  <div id="dion" style="position:absolute; width:85px; height:99px; z-index:3; left: 305px; top: 529px; visibility: hidden;"><img src="img/dion.gif" width="58" height="72" onMouseOver="MM_showHideLayers('dion','','show')" onMouseOut="MM_showHideLayers('dion','','hide')"></div>
  <div id="giran" style="position:absolute; width:131px; height:47px; z-index:4; left: 455px; top: 523px; visibility: hidden;"><img src="img/giran.gif" width="105" height="36" onMouseOver="MM_showHideLayers('giran','','show')" onMouseOut="MM_showHideLayers('giran','','hide')"></div>
  <div id="gludio" style="position:absolute; width:199px; height:349px; z-index:5; left: 92px; top: 445px; visibility: hidden;"><img src="img/gludio.gif" width="179" height="317" onMouseOver="MM_showHideLayers('gludio','','show')" onMouseOut="MM_showHideLayers('gludio','','hide')"></div>
  <div id="innadril" style="position:absolute; width:57px; height:105px; z-index:6; left: 519px; top: 687px; visibility: hidden;"><img src="img/innadril.gif" width="43" height="94" onMouseOver="MM_showHideLayers('innadril','','show')" onMouseOut="MM_showHideLayers('innadril','','hide')"></div>
  <div id="oren" style="position:absolute; width:200px; height:115px; z-index:7; left: 295px; top: 221px; visibility: hidden;"><img src="img/oren.gif" width="195" height="132" border="0" onMouseOver="MM_showHideLayers('oren','','show')" onMouseOut="MM_showHideLayers('oren','','hide')"> </div>
</div>
<map name="Map2">
  <area shape="rect" coords="400,4,438,53" onMouseOver="MM_showHideLayers('aden','','show')" onMouseOut="MM_showHideLayers('aden','','hide')">
</map>
<map name="Map">
  <area shape="rect" coords="552,102,680,150" onMouseOver="MM_showHideLayers('godad','','show')" onMouseOut="MM_showHideLayers('godad','','hide')">
  <area shape="rect" coords="416,263,526,319" onMouseOver="MM_showHideLayers('oren','','show')" onMouseOut="MM_showHideLayers('oren','','hide')">
  <area shape="rect" coords="197,423,300,487" onMouseOver="MM_showHideLayers('gludio','','show')" onMouseOut="MM_showHideLayers('gludio','','hide')">
  <area shape="rect" coords="523,514,660,560" onMouseOver="MM_showHideLayers('giran','','show')" onMouseOut="MM_showHideLayers('giran','','hide')">
  <area shape="rect" coords="328,546,451,589" onMouseOver="MM_showHideLayers('dion','','show')" onMouseOut="MM_showHideLayers('dion','','hide')">
  <area shape="rect" coords="488,725,615,789" onMouseOver="MM_showHideLayers('innadril','','show')" onMouseOut="MM_showHideLayers('innadril','','hide')">
  <area shape="rect" coords="586,203,725,247" onMouseOver="MM_showHideLayers('aden','','show')" onMouseOut="MM_showHideLayers('aden','','hide')">
</map>
</body>
</html>
