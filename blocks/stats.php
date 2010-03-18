<?php
//пароль
$parse = $Lang;
$imgoffline = '<img src="img/status/offline.png" border="0" alt="'.$Lang['offline'].'" title="'.$Lang['offline'].'" />';
$imgonline = '<img src="img/status/online.png" border="0" alt="'.$Lang['online'].'" title="'.$Lang['online'].'" />';

if ($Config['show_ls'])
{
    $fp = @fsockopen($Config['LServerIP'], $Config['LServerPort'], $errno, $errstr, 0.5);
    if ($fp) {
        $loginonline = $imgonline;
    }else{
        $loginonline = $imgoffline;
    }
    $parse['login_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">'.$Lang['login_server'].':</td><td align="left">'.$loginonline.'</td></tr>';
}

if ($Config['show_cs'])
{
    $fp = @fsockopen($Config['CServerIP'], $Config['CServerPort'], $errno, $errstr, 0.5);
    if ($fp){
        $comunityonline = $imgonline;
    }else{
        $comunityonline = $imgoffline;
    }
    $parse['community_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">'.$Lang['community_server'].':</td><td align="left">'.$comunityonline.'</td></tr>';

}

if ($Config['show_gs'])
{
    $fp = @fsockopen($Config['GServerIP'], $Config['GServerPort'], $errno, $errstr, 0.5);
    if($fp){
        $gameonline = $imgonline;
    }else{
        $gameonline = $imgoffline;
    }
    $parse['game_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">'.$Config['ServerName'].':</td><td align="left">'.$gameonline.'</td></tr>';

}

#Players Online
$online_count = $mysql->query("SELECT count(`online`) FROM `characters` WHERE `online` = '1' AND `accesslevel`='0';");
$parse['online_count'] = $mysql->result();

#GM Online
$gmonline = $mysql->query('SELECT count(`charId`) FROM `characters` WHERE `online` = \'1\' AND `accesslevel`>\'0\';');
$parse['online_gm_count'] = $mysql->result();

#Total accounts
$acc_count = $mysql->query('SELECT count(`login`) FROM `accounts`;');
$parse['acc_count'] = $mysql->result();

#Total characters
$char_count = $mysql->query("SELECT count(`charId`) FROM `characters`;");
$parse['char_count'] = $mysql->result();

#Total clans
$clan_count = $mysql->query("SELECT count(`clan_id`) FROM `clan_data`;");
$parse['clan_count'] = $mysql->result();

$tpl->parsetemplate('blocks/stats', $parse);
?>