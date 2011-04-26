<?php
//пароль
if (! defined('IN_BLOCK'))
{
	header("Location: ../index.php");
    exit();
}
$cachefile='blocks/top10';
if($cache->needUpdate($cachefile))
{
    $content ='';
    $server_list = $sql->query(1, array('db' => getConfig('settings', 'webdb', 'l2web')));
    while ($slist = $sql->fetch_array($server_list))
    {
        $parse['server_name'] = $slist['Name'];

        $topchar = $sql->query(200, array("db" => $slist['DataBase'], "limit" => getConfig('settings', 'TOP', '10')));
        $n = 1;
        $parse['rows'] = '';
        while ($top = $sql->fetch_array())
        {
            $row_parse['nr'] = $n;
            $row_parse['charId'] = $top['charId'];
            $row_parse['sex'] = ($top['sex'] == 0) ? 'male' : 'female';
            $row_parse['char_name'] = $top['char_name'];
            $row_parse['serv_id'] = $slist['ID'];
            $parse['rows'] .= $tpl->parsetemplate($cachefile.'_row', $row_parse, 1);
            $n++;
        }

        $content .= $tpl->parsetemplate($cachefile, $parse, 1);

    }
    $cache->updateCache($cachefile, $content);
    global $content;
}
else
{
    $content = $cache->getCache($cachefile);
    global $content;
}
?>