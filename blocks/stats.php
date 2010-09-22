<?php
//пароль
if (! defined('IN_BLOCK'))
{
	Header("Location: ../index.php");
}
$page='blocks/stats';
$par['lang']=getLang();
$par['mod']=$user->mod()==true?'true':'false';
$sec=600;
$params = implode(';', $par);
$content = '';
if($cache->needUpdate($page, $params, $sec))
{
    $parse = $Lang;
    $imgoffline = '<img src="img/status/offline.png" border="0" alt="' . $Lang['offline'] . '" title="' . $Lang['offline'] . '" />';
    $imgonline = '<img src="img/status/online.png" border="0" alt="' . $Lang['online'] . '" title="' . $Lang['online'] . '" />';

	$fp = @fsockopen($LS['ip'], $LS['port'], $errno, $errstr, 2);
	if ($fp) $loginonline = $imgonline;
	else  $loginonline = $imgoffline;

	$parse['login_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['login_server'] . ':</td><td align="left">' . $loginonline . '</td></tr>';



//	$fp = @fsockopen($Config['CServerIP'], $Config['CServerPort'], $errno, $errstr, 2);
//	if ($fp)
//	{
//		$comunityonline = $imgonline;
//	}
//	else
//	{
//		$comunityonline = $imgoffline;
//	}
//	$parse['community_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['community_server'] . ':</td><td align="left">' . $comunityonline . '</td></tr>';


#Total accounts
$parse['acc_count'] = $mysql->result($mysql->query($q[100], array('db' => $Config['DDB'])));
$content.=$tpl->parsetemplate('blocks/stats', $parse, 1);

$serverlist = $mysql->query($q[2], array('db' => $webdb));
while ($server = $mysql->fetch_array($serverlist))
{
	$parse = $Lang;
	#Total clans
	$parse['clan_count'] = $mysql->result($mysql->query($q[201], array('db' => $server['DataBase'])));

	#Total characters
	$parse['char_count'] = $mysql->result($mysql->query($q[202], array('db' => $server['DataBase'])));

    #Players Online
	$parse['online_count'] = $mysql->result($mysql->query($q[203], array('db' => $server['DataBase'])));
    
if($user->logged() && $user->mod())
{
     $telnet_q=$mysql->query($q[4], array('db' => $webdb, 'server' => $server['Name']));
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
$parse['on_off'] = "Tip('(&lt;font color=\'green\'>$real&lt;/font> / &lt;font color=\'red\'>$offline&lt;/font>)', FONTCOLOR, '#FFFFFF',BGCOLOR, '#AAAA00', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold', WIDTH, 50, ABOVE, true)";

}


	#GM Online
	$parse['online_gm_count'] = $mysql->result($mysql->query($q[204], array('db' => $server['DataBase'])));

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
	$content .=$tpl->parsetemplate('blocks/stats_serverlist', $parse, 1);
}
$cache->updateCache($page, $params, $content);
echo $content;
}
else
{
    echo $cache->getCache($page, $params);
}
?>