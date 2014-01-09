<?php
if(!defined('IN_BLOCK'))
{
	header("Location: ../index.php");
	exit();
}
$cachefile = 'blocks/top10';
if($cache->needUpdate($cachefile))
{
	$content = '';
	$server_list = $sql->query(1, array('webdb' => $webdb));
	while ($slist = $sql->fetchArray($server_list))
	{
		$parse['server_name'] = $slist['name'];

		$topchar = $sql->query(200, array("db" => $slist['database'], "limit" => getConfig('settings', 'top', '10')));
		$n = 1;
		$parse['rows'] = '';
		while ($top = $sql->fetchArray())
		{
			$row_parse['nr'] = $n;
			$row_parse['charId'] = $top['charId'];
			$row_parse['sex'] = ($top['sex'] == 0) ? 'male' : 'female';
			$row_parse['char_name'] = $top['char_name'];
			$row_parse['serv_id'] = $slist['ID'];
			$parse['rows'] .= $tpl->parseTemplate($cachefile . '_row', $row_parse, true);
			$n++;
		}

		$content .= $tpl->parseTemplate($cachefile, $parse, true);

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