<?php
//пароль
if(!defined('INCONFIG'))
{
    header("Location: ../index.php");
    exit();
}
$user_ip = $_SERVER['REMOTE_ADDR'];
$data = file("include/bancontrol.txt");
for($i=0; $i<sizeof($data); $i++)
{
$info = explode("||", $data[$i]);
$date = $info[0];
$ip = $info[1];
$op = $info[2];
$end_ban = $info[3];
$real_time = time();
$convert = date("d.m.y ( H:m )",$end_ban);
if($user_ip==$ip)
{
if($real_time>$end_ban)
{
$rem = $i;
$fstr=file("include/bancontrol.txt");
unset($fstr[$rem]);
$fp=fopen("include/bancontrol.txt","w");
fwrite($fp,implode("",$fstr));
fclose($fp);
$sql->query("INSERT INTO `".getConfig('settings', 'webdb', 'l2web')."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('$ip', 'BanControl', 'Succes', 'Reason=\"Ban duration is over\"');");
} else {
    head("You have been BANNED", 0);
?>


<table width="50%" bgcolor="red" align="center"><tr><td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
<tr>
<td height="19" colspan="2" valign="top"><div align="center"><h1><font color="red"><b>Access Denied!</b></font></h1></div></td>
</tr>
<tr align="center">
<td width="30%" height="19" valign="top"><font color="red"><b>Your IP:</b></font></td>
<td width="60%" valign="top"><font color="red"><b><?php echo $ip;?></b></font></td>
</tr>
<tr align="center">
<td height="18" valign="top"><font color="red"><b>Reason:</b></font></td>
<td valign="top"><font color="white"><b><?php echo $op;?></b></font></td>
</tr>
<tr align="center">
<td height="18" valign="top"><font color="red"><b>Banned from: </b></font></td>
<td valign="top"><font color="red"><b><?php echo $date;?></b></font></td>
</tr>
<tr align="center">
<td height="18" valign="top"><font color="red"><b>Banned till:</b></font></td>
<td valign="top"><font color="red"><b><?php echo $convert;?></b></font></td>
</tr>
</table>
</td></tr></table>
<div style="height: 120px;">&nbsp;</div>
<?php
foot(0);
exit;
}
}
}
?>