<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Admin");
includeLang('admin/settings');

if (logedin() && $CURUSER['accessLevel'] == '127'){
?>
<h2><?php echo $Lang['admin_settings']; ?></h2>
<?php
if ($_POST){
    $sql=mysql_query("SELECT * FROM ".$DB['webdb'].".config");

while ( $row = mysql_fetch_assoc($sql) ) {
    mysql_query("UPDATE `".$DB['webdb']."`.`config` SET `config_value` = '". mysql_real_escape_string($_POST[$row['config_name']])."' WHERE `config_name` = '{$row['config_name']}'") OR mysql_error();
    }
echo $Lang['saved'];
echo "<meta http-equiv=\"refresh\" content=\"1; URL=admin.php\" />";
}else{
    ?>
<form action="admin.php" method="post">
<table width="519" style="color:#FFFFFF">
<tbody>
<?php
$sql=mysql_query("SELECT * FROM ".$DB['webdb'].".config");

while ( $row = mysql_fetch_assoc($sql) ) {
    echo "<tr>
	<td>".$Lang[$row['config_name']].":</td>
	<td><input name=\"{$row['config_name']}\" size=\"50\" value=\"{$row['config_value']}\" type=\"text\"></td>
</tr>";
    }
    echo "<tr><td></td><td align = left><input value=\"{$Lang['save']}\" type=\"submit\"></td></tr>";

?>
</tbody>
</table>
</form>
<?php
}
} else { die('nothing here!!!');}
foot();
mysql_close($link);
?>