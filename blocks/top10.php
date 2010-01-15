<?php
//пароль
echo "<h2>{$Config['ServerName']}</h2>";
echo "<table align=\"center\">";
$data123=mysql_query("SELECT charId, char_name, sex FROM characters WHERE accesslevel=0  ORDER BY exp DESC LIMIT {$Config['TOP']}", $link);
$n=1;
while($top=mysql_fetch_assoc($data123))
{

if ($top['sex']==0)
{ 
	$class='male'; 
} 
else 
{ 
	$class='female';
}

echo "<tr><td align=\"center\"><b>$n</b></td><td><a href=\"user.php?cid={$top['charId']}\" class=\"$class\">{$top['char_name']}</a></td></tr>\n";
$n++;

}
echo '</table>';
?>