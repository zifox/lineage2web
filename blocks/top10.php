<?php
$parse['server_name'] = $Config['ServerName'];

$topchar=$mysql->query("SELECT `charId`, `char_name`, `sex` FROM `characters` WHERE `accesslevel`='0'  ORDER BY `exp` DESC LIMIT {$Config['TOP']};");
$n=1;
$parse['rows'] = '';
while($top=$mysql->fetch_array())
{
$row_parse['nr'] = $n;
$row_parse['charId'] = $top['charId'];
$row_parse['sex'] = ($top['sex']==0)?'male':'female';
$row_parse['char_name'] = $top['char_name'];
$parse['rows'] .= $tpl->parsetemplate('blocks/top10_row', $row_parse, 1);
$n++;
}
unset($row_parse);

$tpl->parsetemplate('blocks/top10', $parse);
unset($parse);
?>
