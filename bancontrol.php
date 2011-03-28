<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
loggedInOrReturn('bancontrol.php');
if(!$user->mod())
{
    die();
}
head("BanList");

echo "<center><a href='bancontrol.php?page=index'>Banu saraksts</a> | <a href='bancontrol.php?page=control'>Pievienot</a>";




$page = getVar('page');
if($page== "index")
{
echo "<table cellpadding='4' cellspacing='1' border='0' style='width:100%' class='tableinborder'";
echo "<tr>";
echo " <td class='tabletitle' valign='top'><b>#</b></td>";
echo " <td class='tabletitle' valign='top'><b>IP-adresse</b></td>";
echo " <td class='tabletitle' valign='top'><b>Sākas</b></td>";
echo " <td class='tabletitle' valign='top'><b>Beidzas</b></td>";
echo " <td class='tabletitle' valign='top'><b>Iemesls</b></td>";
echo " <td class='tabletitle' valign='top'><b>Darbība</b></td>";
echo "</tr>";
$data = @file("include/bancontrol.txt");
for($i=1; $i<sizeof($data); $i++)
{
$info = explode("||", $data[$i]);
$date = $info[0];
$ip = $info[1];
$op = $info[2];
$end_ban = $info[3];
$convert = date("d.m.y ( H:m )",$end_ban);
echo "<tr>";
echo " <td class='tablea' valign='top' ><b>$i</b></td>";
echo " <td class='tablea' valign='top' >$ip</td>";
echo " <td class='tablea' valign='top' >$date</td>";
echo " <td class='tablea' valign='top' >$convert</td>";
echo " <td class='tablea' valign='top' >$op</td>";
echo " <td class='tablea' valign='top' ><a href='bancontrol.php?delete=$i'>Dzēst</a></td>";
echo "</tr>";
}
echo "</table>";
}

if($page == "control")
{

echo "
<form action='bancontrol.php' method='post'>
<table border='0'>
<tr>
<td width='109' height='19' valign='top'>IP-adresse</td>
<td height='22' colspan='2' valign='top'><input name='addr' type='text' id='addr' size='50' maxlength='16'></td>
</tr>

<tr>
<td height='19' valign='top'>Iemesls</td>
<td height='22' colspan='2' valign='top'><input name='op' type='text' id='op' size='50' maxlength='50'></td>
</tr>

<tr>
<td align='center' height='32' colspan='2' valign='top'>
<input type='submit' name='Submit' value='Banot'></td>
</tr>
</table>
</form>";
}
$addr = getVar('addr');
$op = getVar('op');
if($addr)
{
$addr = strip_tags(stripslashes(trim($addr)));
$op = strip_tags(stripslashes(trim($op)));
$date = date("d.m.y ( H:i )");
$unix_time = time()+3600*24;
$data = @fopen("include/bancontrol.txt", "a+");
fputs($data, "$date||$addr||$op||$unix_time||\n");
fclose($data);
//stdmsg("Veiksmīgi nobanots", "<font color=red> IP adrese: <b>$addr</b> ir atvienota, iemesls ir: <b>$op</b><br><a href='simplban.php'><b>Atpakaļ uz baniem</a><br>");
//write_log("IP adresi $addr nobanoja lietotājs $CURUSER[username]. Iemesls: $op. Laiks 24 stundas", "F25B61", "bans");
}
$delete = $_REQUEST['delete'];
$delete = strip_tags(stripslashes(trim($delete)));
if($delete=$delete)
{
$rem = $delete;
$fstr=@file("include/bancontrol.txt");
unset($fstr[$rem]);
$fp=@fopen("include/bancontrol.txt","w");
fwrite($fp,implode("",$fstr));
fclose($fp);
//stdmsg("Bans dzēsts", "<a href='simplban.php?page=index'>Uz banu sarakstu</a>");
}
foot();
?>