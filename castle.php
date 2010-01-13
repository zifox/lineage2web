<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Castles");
include("module/stat-menu.php");



$result = mysql_query("SELECT id, name, taxPercent, treasury, siegeDate, regTimeOver, regTimeEnd, showNpcCrest FROM castle ORDER by id ASC");

$r=0;
echo '<table border="0" style="border-color: #FFFFFF" cellpadding="3" cellspacing="3">';
while($row = mysql_fetch_array($result)){

if ($r==0){echo '<tr>'; $r++;}else{$r++;}
echo '<td><table border = "1"><tr><td class="noborder">';
echo '<h1>'.$row['name'].' Castle</h1>';
echo 'Next Siege: '.date('D j M Y H:i',$row['siegeDate']/1000);
echo '<br /><img src = "img/castle/'.$row['name'].'.png" width = "170"';

echo '<table border = "0" width = "170"><tr style="background-color: #2391ab;"><td>Castle</td><td>Details</td></tr>';
$owner = mysql_query("SELECT clan_data.clan_name FROM clan_data, castle WHERE clan_data.hasCastle=".$row['id']);
if(mysql_num_rows($owner))
{
    $owner = mysql_result($owner,0,0);
}else{$owner = 'No Owner';}
echo '<tr"><td>Owner Clan: </td><td>'.$owner.'</td></tr>';
echo '<tr><td>Tax: </td><td>'.$row['taxPercent'].'%</td></tr>';
echo '<tr><td>Attackers: </td><td>';
$result1 = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='{$row['id']}' AND type='1'");
while($row1=mysql_fetch_assoc($result1))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='{$row1['clan_id']}'");
while($row2=mysql_fetch_assoc($result2))
{
    echo '<a href="claninfo.php?clanid='.$row1['clan_id'].'">'.$row2['clan_name'].'</a><br />';
}
}
echo '</td></tr><tr><td>Defenders: </td><td>';
$result1 = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='{$row['id']}' AND type='0'") OR die('Mysql error');
if(mysql_num_rows($result1)==0)
{$mnr="0";}else{$mnr="1";}

while($row1=mysql_fetch_assoc($result1))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='{$row1['clan_id']}'") OR die('Mysql error');
while($row2=mysql_fetch_assoc($result2))
{
    echo '<a href="claninfo.php?clanid='.$row1['clan_id'].'">'.$row2['clan_name'].'</a><br /> ';
    //echo mysql_num_rows($result1);

}
}
if($mnr=="0"){echo 'NPC';}




echo '</td></tr></table></td></tr></table>';
echo '</td>';
if($r==3)
{
    echo '</tr>';
    $r=0;
}
}
?>
</table>
<?php
 foot();
mysql_close($link);
?>