<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="2009 - 2011 Lineage II Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
 <title>View Image</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />

 <script language="javascript" type="text/javascript">
   var arrTemp=self.location.href.split("?");
   var picUrl = (arrTemp.length>0)?arrTemp[1]:"";
   var NS = (navigator.appName=="Netscape")?true:false;

     function FitPic() {
       iWidth = (NS)?window.innerWidth:document.body.clientWidth;
       iHeight = (NS)?window.innerHeight:document.body.clientHeight;
       iWidth = document.images[0].width - iWidth;
       iHeight = document.images[0].height - iHeight;
       window.resizeBy(iWidth, iHeight);
       self.focus();
     };
 </script>
</head>
<body bgcolor="#406072" onload="FitPic();" style="margin-top: 0; margin-bottom: 0; margin-left: 0; margin-right: 0;">
 <script language="javascript" type="text/javascript">
 <!--
 document.write( "<img src='news/" + picUrl + "' border=0 alt='' />" );
 // -->
 </script>
</body>
</html>