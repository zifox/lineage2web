<?php
include("module/stat-menu.php");

$noneed=1;
//include("../../config/config.php");

$result = mysql_query("SELECT castle.name, clan_data.clan_name FROM castle,clan_data WHERE clan_data.hasCastle=castle.id");
while($row= mysql_fetch_assoc($result)){
switch($row['name']){
case 'Giran':$giranOwner=$row['clan_name'];break;
case 'Oren':$orenOwner=$row['clan_name'];break;	
case 'Aden':$adenOwner=$row['clan_name'];break;
case 'Gludio':$gludioOwner=$row['clan_name'];break;
case 'Dion':$dionOwner=$row['clan_name'];break;
case 'Innadril':$innadrilOwner=$row['clan_name'];break;
case 'Goddard':$goddardOwner=$row['clan_name'];break;
case 'Rune':$runeOwner=$row['clan_name'];break;
case 'Schuttgart':$schuttgartOwner=$row['clan_name'];break;
}
}
$result = mysql_query("SELECT name,taxPercent,siegeDate FROM castle");
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
switch($row['name']){
case 'Giran':$giranTax=$row['taxPercent'].'%';
$giranSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Oren':$orenTax=$row['taxPercent'].'%';
$orenSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Aden':$adenTax=$row['taxPercent'].'%';
$adenSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Gludio':$gludioTax=$row['taxPercent'].'%';
$gludioSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Dion':$dionTax=$row['taxPercent'].'%';
$dionSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Innadril':$innadrilTax=$row['taxPercent'].'%';
$innadrilSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
case 'Goddard':$goddardTax=$row['taxPercent'].'%';
$goddardSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;	
case 'Rune':$runeTax=$row['taxPercent'].'%';
$runeSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;	
case 'Schuttgart':$SchuttgartTax=$row['taxPercent'].'%';
$SchuttgartSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;	
}
}
?>
<table cellpadding="0" cellspacing="0" width="588" align="center">
<tr><td><table cellpadding="0" cellspacing="0" width="95%" align="center">
<tr align="center"><td colspan="2"><p class="zag">Aden Castle<br /><br />
<tr valign="top"><td width="200"><img src="module/castle/aden.jpg" /><td>
<table cellpadding="0" cellspacing="7" width="95%" border="0" align="center">
<tr class="date"><td>Siege Date<td>Castle Owner<td>Tax
<tr class="text"><td><?print $adenSiegeDate;?><td><?print$adenOwner;?><td><?print$adenTax;?>
<tr class="text"><td colspan="2"><br />
<tr class="date"><td colspan="2">Attakers<td colspan="2">Defenders
<tr class="text"><td colspan="2">
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='5' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='5' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Dion Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/dion.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $dionSiegeDate;?><td><?php print$dionOwner;?><td><?php print$dionTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='2' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='2' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Giran Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/giran.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $giranSiegeDate;?><td><?php print $giranOwner;?><td><?php print$giranTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='3' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='3' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Gludio Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/gludio.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $gludioSiegeDate;?><td><?php print$gludioOwner;?><td><?php print$gludioTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php 
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='1' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='1' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Goddard Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/goddard.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $goddardSiegeDate;?><td><?php print$goddardOwner;?><td><?php print$goddardTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='7' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='7' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Innadril Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/innadril.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $innadrilSiegeDate;?><td><?php print$innadrilOwner;?><td><?php print$innadrilTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='6' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='6' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Oren Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/oren.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $orenSiegeDate;?><td><?php print$orenOwner;?><td><?php print$orenTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php 
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='4' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='4' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Rune Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/rune.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $runeSiegeDate;?><td><?php print$runeOwner;?><td><?php print$runeTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='8' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='8' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table><br><br><br></td></tr>';
?>
<tr><td><table cellpadding=0 cellspacing=0 width="95%" align=center>
<Tr align=center><td colspan=2><p class=zag>Schuttgart Castle<br><br>
<tr valign=top><td width=200><img src="module/castle/schuttgart.jpg"><td>
<table cellpadding=0 cellspacing=7 width=95% border=0 align=center>
<tr class=date><td>Date of Siege<td>Castle Owner<td>Tax
<tr class=text><td><?php print $SchuttgartSiegeDate;?><td><?php print$schuttgartOwner;?><td><?php print$SchuttgartTax;?>
<tr class=text><td colspan=2><br>
<tr class=date><td colspan=2>Attakers<td colspan=2>Deffenders
<tr class=text><td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='9' AND type='1'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");

while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
}}?>
<td colspan=2>
<?php
$result = mysql_query("SELECT clan_id FROM siege_clans WHERE castle_id='9' AND type='0'");
while($row=mysql_fetch_array($result))
{
$result2 = mysql_query("SELECT clan_name FROM clan_data WHERE clan_id='$row[0]'");
while($row2=mysql_fetch_array($result2))
{
print $row2[0];print'<br>';
if($row2[0]!="")
{$s11="1";break;}
}
}
if($s11=="1"){print '';}
else
print 'NPC</table></table></td></tr>';
?></table>