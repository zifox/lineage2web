<?php
if (! defined('IN_BLOCK'))
{
	Header("Location: ../index.php");
}
$page='blocks/top10';
$sec=7200;
if($cache->needUpdate($page, NULL, $sec))
{
$server_list = $mysql->query($q[1], array('db' => $webdb));
while ($slist = $mysql->fetch_array($server_list))
{
	$parse['server_name'] = $slist['Name'];

	$topchar = $mysql->query($q[200], array("db" => $slist['DataBase'], "limit" => $Config['TOP']));
	$n = 1;
	$parse['rows'] = '';
	while ($top = $mysql->fetch_array())
	{
		$row_parse['nr'] = $n;
		$row_parse['charId'] = $top['charId'];
		$row_parse['sex'] = ($top['sex'] == 0) ? 'male' : 'female';
		$row_parse['char_name'] = $top['char_name'];
        $row_parse['serv_id'] = $slist['ID'];
		$parse['rows'] .= $tpl->parsetemplate('blocks/top10_row', $row_parse, 1);
		$n++;
	}

	$content = $tpl->parsetemplate('blocks/top10', $parse, 1);
    $cache->updateCache($page, $params, $content);
    echo $content;
}
}
else
{
    echo $cache->getCache($page, NULL);
}

?>