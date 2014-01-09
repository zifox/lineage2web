<?php
if (! defined('IN_BLOCK'))
{
	header("Location: ../index.php");
    exit();
}
$par['lang']=getLangName();
$par['mod']=$user->mod()==true?'true':'false';
$params = implode(';', $par);
$content = '';
$cachefile='bStats';
if($cache->needUpdate($cachefile, $params))
{
    $parse = getLang();
    $imgoffline = '<img src="img/status/offline.png" border="0" alt="' .getLang('offline') . '" title="' . getLang('offline') . '" />';
    $imgonline = '<img src="img/status/online.png" border="0" alt="' . getLang('online') . '" title="' . getLang('online') . '" />';
    if(getConfig('server', 'show_ls', '1'))
    {
	   $fp = @fsockopen(getConfig('server', 'ls_ip', '127.0.0.1'), getConfig('server', 'ls_port', '2106'), $errno, $errstr, 2);
	   if ($fp) $loginonline = $imgonline;
	   else $loginonline = $imgoffline;

	   $parse['login_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . getLang('bStats', 'login_server') . ':</td><td align="left">' . $loginonline . '</td></tr>';
    }

    if(getConfig('server', 'show_cs', '1'))
    {
	   $fp = @fsockopen(getConfig('server', 'cs_ip', '127.0.0.1'), getConfig('server', 'cs_port', ''), $errno, $errstr, 2);
	   if ($fp) $comunityonline = $imgonline;
	   else $comunityonline = $imgoffline;

	   $parse['community_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . getLang('community_server') . ':</td><td align="left">' . $comunityonline . '</td></tr>';
    }

    #Total accounts
    $parse['acc_count'] = $sql->result($sql->query(100, array('db' => getConfig('settings', 'ac_db', 'l2jls'))));
    $content.=$tpl->parseTemplate('blocks/stats', $parse, 1);

    $serverlist = $sql->query(2, array('webdb' => $webdb));
    while ($server = $sql->fetchArray($serverlist))
    {
	   $parse = getLang();
	   #Total clans
	   $parse['clan_count'] = $sql->result($sql->query(201, array('db' => $server['database'])));

	   #Total characters
	   $parse['char_count'] = $sql->result($sql->query(202, array('db' => $server['database'])));

        #Players Online
	   $parse['online_count'] = $sql->result($sql->query(203, array('db' => $server['database'])));
    
        if($user->logged() && $user->mod())
        {
            $real=$sql->result($sql->query(219, array('db' => $server['database'])));
            $offline=$sql->result($sql->query(220, array('db' => $server['database'])));
            $parse['on_off'] = "Tip('(&lt;font color=\'green\'>$real&lt;/font> / &lt;font color=\'red\'>$offline&lt;/font>)', FONTCOLOR, '#FFFFFF',BGCOLOR, '#AAAA00', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold', WIDTH, 50, ABOVE, true)";
        }

        #GM Online
        $parse['online_gm_count'] = $sql->result($sql->query(204, array('db' => $server['database'])));

        $fp = @fsockopen($server['ip'], $server['port'], $errno, $errstr, 0.5);
        if ($fp)
            $gameonline = $imgonline;
        else
            $gameonline = $imgoffline;

        $parse['game_server_status'] = '<tr onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td align="left">' . $server['name'] . ':</td><td align="left">' . $gameonline . '</td></tr>';
        $parse['br'] = '<br />';
        $parse['ID'] = $server['id'];
        $content .=$tpl->parseTemplate('blocks/stats_serverlist', $parse, 1);
    }
    $cache->updateCache($cachefile, $content, $params);
    global $content;
}
else
{
    $content= $cache->getCache($cachefile, $params);
    global $content;
}
?>