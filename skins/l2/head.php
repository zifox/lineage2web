<?php
if(!defined('INSKIN')){Header("Location: ../../index.php");}
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $Config['MetaD']; ?>" />
<meta name="keywords" content="<?php echo $Config['MetaK']; ?>" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
<title><?php echo $title; ?></title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link href="<?php echo $skindir;?>style.css" type="text/css" rel="stylesheet" />
<?php //<script type="text/javascript" src="scripts/overlib.js"></script>?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11986252-1");
pageTracker._trackPageview();
} catch(err) {}</script>
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
    background-position: center top;
    background-repeat: no-repeat;
}
</style>
</head>
<body style="background-color: #191919;">

<table cellpadding="0" cellspacing="0" id="logo" align="center">
<tr>
<td height="220px"></td>
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
        </td>
        <td id="main" width="648" align="center" valign="top">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="head_left_corner"></td>
                    <td class="head_center_left"></td>
                    <td class="head_center" width="60"></td>
                    <td class="head_center2"></td>
                    <td class="head_center_right"></td>
                    <td class="head_right_corner"></td>
                </tr>
            </table>
            <table width="602"  cellpadding="0" cellspacing="0">
                <tr>
                    <td class="head_left_border"></td>
                    <td class="head_background" width="567" align="center">
<?php
if($Config['enable_news'])
{
    echo "<h1>{$Config['news']}</h1>";
}
?>
<hr />

