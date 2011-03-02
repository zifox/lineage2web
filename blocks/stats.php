<?php
//пароль
if (! defined('IN_BLOCK'))
{
	header("Location: ../index.php");
    exit();
}
$par['lang']=getLang();
$par['mod']=$user->mod()==true?'true':'false';
$params = implode(';', $par);
$content = '';
$cachefile='blocks/stats';
if($cache->needUpdate($cachefile, $params))
{
    $parse = $Lang;
    $imgoffline = '<img src="img/status/offline.png" border="0" alt="' . $Lang['offline'] . '" title="' . $Lang['offline'] . '" />';
    $imgonline = '<img src="img/status/online.png" border="0" alt="' . $Lang['online'] . '" title="' . $Lang['online'] . '" />';
    if(getConfig('server', 'show_LS', '1'))
    {
	   $fp = @fsockopen(getConfig('server', 'LS_ip', '127.0.0.1'), getConfig('server', 'LS_port', '2106'), $errno, $errstr, 2);
	   if ($fp) $loginonline = $imgonline;
	   else $loginonline = $imgoffline;

	   $parse['login_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['login_server'] . ':</td><td align="left">' . $loginonline . '</td></tr>';
    }

    if(getConfig('server', 'show_CS', '1'))
    {
	   $fp = @fsockopen(getConfig('server', 'CS_ip', '127.0.0.1'), getConfig('server', 'LS_port', ''), $errno, $errstr, 2);
	   if ($fp) $comunityonline = $imgonline;
	   else $comunityonline = $imgoffline;

	   $parse['community_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $Lang['community_server'] . ':</td><td align="left">' . $comunityonline . '</td></tr>';
    }

    #Total accounts
    $parse['acc_count'] = $sql->result($sql->query(100, array('db' => getConfig('settings', 'DDB', 'l2jdb'))));
    $content.=$tpl->parsetemplate('blocks/stats', $parse, 1);

    $serverlist = $sql->query(2, array('db' => getConfig('settings', 'webdb', 'l2jweb')));
    while ($server = $sql->fetch_array($serverlist))
    {
	   $parse = $Lang;
	   #Total clans
	   $parse['clan_count'] = $sql->result($sql->query(201, array('db' => $server['DataBase'])));

	   #Total characters
	   $parse['char_count'] = $sql->result($sql->query(202, array('db' => $server['DataBase'])));

        #Players Online
	   $parse['online_count'] = $sql->result($sql->query(203, array('db' => $server['DataBase'])));
    
        if($user->logged() && $user->mod())
        {
            $real=$sql->result($sql->query(219, array('db' => $server['DataBase'])));
            $offline=$sql->result($sql->query(220, array('db' => $server['DataBase'])));
            $parse['on_off'] = "Tip('(&lt;font color=\'green\'>$real&lt;/font> / &lt;font color=\'red\'>$offline&lt;/font>)', FONTCOLOR, '#FFFFFF',BGCOLOR, '#AAAA00', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold', WIDTH, 50, ABOVE, true)";
        }

        #GM Online
        $parse['online_gm_count'] = $sql->result($sql->query(204, array('db' => $server['DataBase'])));

        $fp = @fsockopen($server['IP'], $server['Port'], $errno, $errstr, 0.5);
        if ($fp)
            $gameonline = $imgonline;
        else
            $gameonline = $imgoffline;

        $parse['game_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $server['Name'] . ':</td><td align="left">' . $gameonline . '</td></tr>';
        $parse['br'] = '<br />';
        $parse['ID'] = $server['ID'];
        $content .=$tpl->parsetemplate('blocks/stats_serverlist', $parse, 1);
    }
    $cache->updateCache($cachefile, $content, $params);
    
    echo $content;
}
else
{
    echo $cache->getCache($cachefile, $params);
}
?>