<?php
//пароль
if (! defined('IN_BLOCK'))
{
	Header("Location: ../index.php");
}
$parse = $Lang;
$imgoffline = '<img src="img/status/offline.png" border="0" alt="' . $Lang['offline'] . '" title="' . $Lang['offline'] . '" />';
$imgonline = '<img src="img/status/online.png" border="0" alt="' . $Lang['online'] . '" title="' . $Lang['online'] . '" />';

if ($Config['show_ls'])
{
	$fp = @fsockopen($Config['LServerIP'], $Config['LServerPort'], $errno, $errstr, 0.5);
	if ($fp) $loginonline = $imgonline;
	else  $loginonline = $imgoffline;

	$parse['login_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['login_server'] . ':</td><td align="left">' . $loginonline . '</td></tr>';
}

if ($Config['show_cs'])
{
	$fp = @fsockopen($Config['CServerIP'], $Config['CServerPort'], $errno, $errstr, 0.5);
	if ($fp)
	{
		$comunityonline = $imgonline;
	}
	else
	{
		$comunityonline = $imgoffline;
	}
	$parse['community_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['community_server'] . ':</td><td align="left">' . $comunityonline . '</td></tr>';

}
#Total accounts
$parse['acc_count'] = $mysql->result($mysql->query($q[100]));
$tpl->parsetemplate('blocks/stats', $parse);

$serverlist = $mysql->query($q[2], $webdb);
while ($server = $mysql->fetch_array($serverlist))
{
	$parse = $Lang;
	#Total clans
	$parse['clan_count'] = $mysql->result($mysql->query($q[201], $server['DataBase']));

	#Total characters
	$parse['char_count'] = $mysql->result($mysql->query($q[202], $server['DataBase']));

    #Players Online
	$parse['online_count'] = $mysql->result($mysql->query($q[203], $server['DataBase']));
    
if($user->logged() && $user->mod())
{
     $telnet_q=$mysql->query('SELECT `IP`, `Port`, `Password` FROM `'.$webdb.'`.`telnet` WHERE `Server`=\''.$server['Name'].'\' ');
     $telnet = $mysql->fetch_array($telnet_q);
    $usetelnet = @fsockopen($telnet['IP'], $telnet['Port'], $errno, $errstr, 0.5);
if($usetelnet) {
   fputs($usetelnet, $telnet['Password']);
   fputs($usetelnet, "\r\n");
   fputs($usetelnet, "status");
   fputs($usetelnet, "\r\n");
   fputs($usetelnet, "exit\r\n");
   while (!feof($usetelnet)) {
      $line = fgets($usetelnet, 2000);
      if( preg_match('/Player Count: (.*)\/([0-9]{1,9})/i', $line, $matches)) {
         $online = $matches[1];
      }
      if( preg_match('/Offline Count: (.*)\/([0-9]{1,9})/i', $line, $matches)) {
         $offline = $matches[1];
      }
   }
   $real = ($online-$offline);
   fclose($usetelnet);
}
else 
{
   $real = "-";
   $offline = "-";
}
$parse['online_count'] .= "($real)";
//echo "Online players: {$real}";
//echo "Offline stores: {$offline}";

}


	#GM Online
	$parse['online_gm_count'] = $mysql->result($mysql->query($q[204], $server['DataBase']));

	$fp = @fsockopen($server['IP'], $server['Port'], $errno, $errstr, 0.5);
	if ($fp)
		$gameonline = $imgonline;
	else
	{
		$gameonline = $imgoffline;
	}
	$parse['game_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $server['Name'] . ':</td><td align="left">' . $gameonline . '</td></tr>';
	$parse['br'] = '<br />';
	$parse['ID'] = $server['ID'];
	$tpl->parsetemplate('blocks/stats_serverlist', $parse);
}
?>