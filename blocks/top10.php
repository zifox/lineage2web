<?php
//Пожалуйста, введите своё имя и пароль
echo "<table><center><h2>{$Config['ServerName']}</h2>\n";
$data123=mysql_query("SELECT charId, char_name, sex FROM characters WHERE accesslevel=0  ORDER BY level DESC LIMIT {$Config['TOP']}", $link);
$n=1;
while($top=mysql_fetch_assoc($data123))
{
	
if ($top['sex']==0)
{ 
	$name='<font color=#8080FF>'.$top['char_name'].'</font>'; 
} 
else 
{ 
	$name='<font color=#FF8080>' .$top['char_name'].'</font>'; 
}

echo "<tr><td><b><center>$n</center></b></td><td><a href=\"index.php?id=user&cid={$top['charId']}\">$name</a></td></tr>\n";
$n++;

}
echo '</table>';
?>