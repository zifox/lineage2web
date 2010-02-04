<?php
//пароль
$imgoffline = '<img src="img/status/offline.png" border="0" alt="'.$Lang['offline'].'" title="'.$Lang['offline'].'" />';
$imgonline = '<img src="img/status/online.png" border="0" alt="'.$Lang['online'].'" title="'.$Lang['online'].'" />';

# LS
$fp = @fsockopen($Config['LServerIP'], $Config['LServerPort'], $errno, $errstr, 1);
If($fp >= 1){
$loginonline = $imgonline;}
else{ $loginonline = $imgoffline; }

# CS
$fp = @fsockopen($Config['CServerIP'], $Config['CServerPort'], $errno, $errstr, 1);
if($fp >= 1){
$comunityonline = $imgonline;}
else{ $comunityonline = $imgoffline; }

# GS
$fp = @fsockopen($Config['GServerIP'], $Config['GServerPort'], $errno, $errstr, 1);
if($fp >= 1){
$gameonline = $imgonline;}
else{ $gameonline = $imgoffline; }

#Players Online
$query='SELECT count(charId) FROM `characters` WHERE `online` = \'1\' AND !`accesslevel`;';
$result = mysql_query($query);
$onlineplayers=mysql_result($result, 0, 0);
if( $onlineplayers <= 80){
$playsonline = "<a href=\"stat.php?stat=online\"><font color=\"green\">" . $onlineplayers . "</font></a>";}
elseif( mysql_result($result, 0, 0) >= 80 AND mysql_result($result, 0, 0) <= 150){
$playsonline = "<a href=\"stat.php?stat=online\"><font color=\"orange\">" . mysql_result($result, 0, 0) . "</font></a>";}
elseif( mysql_result($result, 0, 0) > 150){
$playsonline = "<a href=\"stat.php?stat=online\"><font color=\"red\">" . mysql_result($result, 0, 0) . "</font></a>";}

#GM Online
$sql = mysql_query('SELECT count(charId) FROM `characters` WHERE `online` = \'1\' AND `accesslevel`;');
$gmonline = mysql_result($sql, 0, 0);

#Total accounts
$sql = mysql_query('SELECT count(login) FROM `accounts`;');
$accountsnum = mysql_result($sql, 0, 0);

#Total characters
$sql = mysql_query("SELECT count(charId) FROM `characters`;");
$charnum = mysql_result($sql, 0, 0);

#Total clans
$sql = mysql_query("SELECT count(clan_id) FROM `clan_data`;");
$clannum = mysql_result($sql, 0, 0);
?>

<table align="center">
<tr><td align="left">Login Server:</td><td align="left"><?php echo $loginonline;?></td></tr>
<tr><td align="left">Community Server:</td><td align="left"><?php echo $comunityonline;?></td></tr>
<tr><td align="left"><?php echo $Config['ServerName']; ?>:</td><td align="left"><?php echo $gameonline; ?></td></tr>
<tr><td align="left">Accounts:</td><td align="left"><?php echo $accountsnum;?></td></tr>
<tr><td align="left">Clans: <?php echo $clannum; ?></td></tr>
<tr><td align="left">Chars: <?php echo $charnum; ?></td></tr>
<tr><td align="left">Online: <?php echo $playsonline;
if ($gmonline) echo ' / <a href="stat.php?stat=gm"><font color="green">'.$gmonline.'</font></a>'; ?></td></tr>
</table>