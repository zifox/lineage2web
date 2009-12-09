<?php
//пароль

//# Login OnLine/OffLine
$fp = @fsockopen($Config['LServerIP'], $Config['LServerPort'], $errno, $errstr, 1);
If($fp >= 1){
$loginonline = '<img src="img/online.png" border="0" />';}
else{ $loginonline = '<img src="img/offline.png" border="0" />'; }

# Server1 OnLine/OffLine
$fp = @fsockopen($Config['GServerIP'], $Config['GServerPort'], $errno, $errstr, 1);
if($fp >= 1){
$gameonline = '<img src="img/online.png" border="0" />';}
else{ $gameonline = "<img src=\"img/offline.png\" border=\"0\" />"; }

#Players Online
$query='SELECT count(*) FROM characters WHERE online = 1';
$result = mysql_query($query);
$onlineplayers=mysql_result($result, 0, 0);
if( $onlineplayers <= 80){
//    $rnd = rand(26,28);
 //   $onlineplayers = $onlineplayers+$rnd;
$playsonline = "<font color=green>" . $onlineplayers . "</font>";}
elseif( mysql_result($result, 0, 0) >= 80 AND mysql_result($result, 0, 0) <= 150){
$playsonline = "<font color=orange>" . mysql_result($result, 0, 0) . "</font>";}
elseif( mysql_result($result, 0, 0) > 150){
$playsonline = "<font color=red>" . mysql_result($result, 0, 0) . "</font>";}

#GM Online
$sql = mysql_query("SELECT count(*) FROM characters WHERE online ='1' AND accesslevel>0");
if( mysql_result($sql, 0, 0) <= 80){
$gmonline = "<font color=red>" . mysql_result($sql, 0, 0) . "</font>";}
$sql = mysql_query("SELECT count(*) FROM characters Where accesslevel > 0");
$gmnum = mysql_result($sql, 0, 0);

#Total accounts
$sql = mysql_query("SELECT count(*) FROM accounts");
$accountsnum = mysql_result($sql, 0, 0);

#Total characters
$sql = mysql_query("SELECT count(*) FROM characters");
$charnum = mysql_result($sql, 0, 0);

#Total clans
$sql = mysql_query("SELECT count(*) FROM clan_data");
$clannum = mysql_result($sql, 0, 0);
?>

<table align="center" onmouseover="return overlib('<table border=0><tr><td><b><?php echo $Lang['exp'];?>:</b></td><td><b><?php echo $Config['Exp'];?></b></td></tr><tr><td><b><?php echo $Lang['sp'];?>:</b></td><td><b><?php echo $Config['SP'];?></b></td></tr><tr><td><b><?php echo $Lang['adena'];?>:</b></td><td><b><?php echo $Config['Adena'];?></b></td></tr><tr><td><b><?php echo $Lang['items'];?>:</b></td><td><b><?php echo $Config['Items'];?></b></td></tr><tr><td><b><?php echo $Lang['spoil'];?>:</b></td><td><b><?php echo $Config['Spoil'];?></b></td></tr><tr><td><b><?php echo $Lang['quest'];?>:</b></td><td><b><?php echo $Config['Quest'];?></b></td></tr></table>', LEFT, ABOVE, CAPTION, 'Server Info', FGCOLOR, '#999999', BGCOLOR, '#333333', BORDER, 3, CAPTIONFONT, 'Garamond', TEXTFONT, 'Courier', CAPTIONSIZE, 4, TEXTSIZE, 3, STICKY, MOUSEOFF, DELAY, 150, WIDTH, 120 );" onmouseout="return nd();">
<tr><td align="left">Login Server:</td><td align="left"><?php echo $loginonline;?></td></tr>
<tr><td align="left"><?php echo $Config['ServerName']; ?>:</td><td align="left"><?php echo $gameonline; ?></td></tr>
<tr><td align="left">Accounts:</td><td align="left"><?php echo $accountsnum;?></td></tr>
<tr><td align="left">Clans: <?php echo $clannum; ?></td></tr>
<tr><td align="left">Chars: <?php echo $charnum; ?></td></tr>
<tr><td align="left">Online: <?php echo $playsonline; ?></td></tr>
</table>