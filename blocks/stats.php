<?php
//пароль
$imgoffline = '<img src="img/status/offline.png" border="0" alt="'.$Lang['offline'].'" title="'.$Lang['offline'].'" />';
$imgonline = '<img src="img/status/online.png" border="0" alt="'.$Lang['online'].'" title="'.$Lang['online'].'" />';

if ($Config['show_ls'])
{
    # LoginServer
    $fp = @fsockopen($Config['LServerIP'], $Config['LServerPort'], $errno, $errstr, 1);
    if ($fp >= 1) {
        $loginonline = $imgonline;
    }else{
        $loginonline = $imgoffline;
    }
}

if ($Config['show_cs'])
{
    # CommunityServer
    $fp = @fsockopen($Config['CServerIP'], $Config['CServerPort'], $errno, $errstr, 1);
    if ($fp >= 1){
        $comunityonline = $imgonline;
    }else{
        $comunityonline = $imgoffline;
    }
}

if ($Config['show_gs'])
{
    # GameServer
    $fp = @fsockopen($Config['GServerIP'], $Config['GServerPort'], $errno, $errstr, 1);
    if($fp >= 1){
        $gameonline = $imgonline;
    }else{
        $gameonline = $imgoffline;
    }
}
#Players Online
$online_count = $mysql->query("SELECT count(`online`) FROM `characters` WHERE `online` = '1' AND `accesslevel`='0';");
$online_count = $mysql->result();
if( $online_count < 80){
$online_count = "<a href=\"stat.php?stat=online\"><font color=\"green\">" . $online_count . "</font></a>";}
elseif( $online_count >= 80 AND $online_count <= 150){
$online_count = "<a href=\"stat.php?stat=online\"><font color=\"orange\">" .$online_count . "</font></a>";}
elseif( $online_count > 150){
$online_count = "<a href=\"stat.php?stat=online\"><font color=\"red\">" . $online_count . "</font></a>";}

#GM Online
$gmonline = $mysql->query('SELECT count(`charId`) FROM `characters` WHERE `online` = \'1\' AND `accesslevel`>\'0\';');
$gmonline = $mysql->result();

#Total accounts
$acc_count = $mysql->query('SELECT count(`login`) FROM `accounts`;');
$acc_count = $mysql->result();

#Total characters
$char_count = $mysql->query("SELECT count(`charId`) FROM `characters`;");
$char_count = $mysql->result();

#Total clans
$clan_count = $mysql->query("SELECT count(`clan_id`) FROM `clan_data`;");
$clan_count = $mysql->result();
?>

<table align="center" width="100%">
<?php
if ($Config['show_ls'])
{
?>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Login Server:</td><td align="left"><?php echo $loginonline;?></td></tr>
<?php
}
if ($Config['show_cs'])
{
?>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Community Server:</td><td align="left"><?php echo $comunityonline;?></td></tr>
<?php
}
if ($Config['show_gs'])
{
?>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left"><?php echo $Config['ServerName']; ?>:</td><td align="left"><?php echo $gameonline; ?></td></tr>
<?php
}
?>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Accounts:</td><td align="left"><?php echo $acc_count;?></td></tr>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Clans:</td><td align="left"><?php echo $clan_count; ?></td></tr>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Chars:</td><td align="left"><?php echo $char_count; ?></td></tr>
<tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td align="left">Online:</td><td align="left"><?php echo $online_count;
if ($gmonline) echo ' / <a href="stat.php?stat=gm"><font color="green">'.$gmonline.'</font></a>'; ?></td></tr>
</table>