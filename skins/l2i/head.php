<?php
if(!defined('INSKIN')){Header("Location: ../../index.php");}
$expires = 60*60*24*14;
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header('Content-Type: gzip');

//пароль
includeLang('skin');

if($url!='')
{
    $parse['add_meta'] = '<meta http-equiv="refresh" content="'.$time.'; URL='.$url.'" />';    
}
else
{
    $parse['add_meta'] = ''; 
}
$parse['MetaD'] = $Config['MetaD'];
$parse['MetaK'] = $Config['MetaK'];
$parse['year'] = date('Y');
$parse['title'] = $title;
$parse['skinurl'] = $staticurl.'/skins/'.$skin;
$parse['static'] = $staticurl;

$tpl->parsetemplate('skins/l2i/head', $parse);



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
                    <td width="40"><img width="40" height="53" alt="" src="<?php echo $parse['skinurl'];?>/img/t_h_lc.gif" /></td>
                    <td width="1"><img width="1" height="53" alt="" src="<?php echo $parse['skinurl'];?>/img/t_h_l_c.gif" /></td>
                    <td width="335" style="background-image: url(<?php echo $parse['skinurl'];?>/img/t_h_cl.gif);">&nbsp;</td>
                    <td width="480" style="">
	                   <table width="100%" style="height:53px;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr>
                            <td height="19" style="background-image: url(<?php echo $parse['skinurl'];?>/img/t_h_c.gif); background-repeat: no-repeat; background-position: center center;"><div align="center">Main</div></td>
                        </tr></tbody></table></td>
                    <td width="309" style="background-image: url(<?php echo $parse['skinurl'];?>/img/t_h_cr.gif);">&nbsp;</td>
                    <td width="1"><img width="1" height="53" alt="" src="<?php echo $parse['skinurl'];?>/img/t_h_r_c.gif" /></td>
                    <td width="40"><img width="40" height="53" alt="" src="<?php echo $parse['skinurl'];?>/img/t_h_rc.gif" /></td>
                </tr>
                <tr>
                    <td style="background-image: url(<?php echo $parse['skinurl'];?>/img/t_h_l_b.gif);">&nbsp;</td>
                    <td bgcolor="#37301d" colspan="5" align="center">
<?php
echo "<h1>{$Config['news']}</h1>";
?>
<hr />
<?php
}
?>