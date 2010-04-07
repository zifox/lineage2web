<?php
if (! defined('IN_BLOCK'))
{
	Header("Location: ../index.php");
}
$server_list = $mysql->query($q[1], $webdb);
while ($slist = $mysql->fetch_array($server_list))
{
	$parse['server_name'] = $slist['Name'];

	$topchar = $mysql->query($q[200], $slist['DataBase'], $Config['TOP']);
	$n = 1;
	$parse['rows'] = '';
	while ($top = $mysql->fetch_array())
	{
		$row_parse['nr'] = $n;
		$row_parse['charId'] = $top['charId'];
		$row_parse['sex'] = ($top['sex'] == 0) ? 'male' : 'female';
		$row_parse['char_name'] = $top['char_name'];
		$parse['rows'] .= $tpl->parsetemplate('blocks/top10_row', $row_parse, 1);
		$n++;
	}

	$tpl->parsetemplate('blocks/top10', $parse);
}
?>