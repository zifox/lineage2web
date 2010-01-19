<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Admin");
includeLang('admin/settings');

if (logedin() && is_admin()){
?>
<h2><?php echo $Lang['admin_settings']; ?></h2>
<?php
if ($_POST){
    $sql=mysql_query("SELECT * FROM `".$DB['webdb']."`.`config`");

while ( $row = mysql_fetch_assoc($sql) ) {
    mysql_query("UPDATE `".$DB['webdb']."`.`config` SET `config_value` = '". mysql_real_escape_string($_POST[$row['config_name']])."' WHERE `config_name` = '{$row['config_name']}'");
    }
echo $Lang['saved'];
?> <meta http-equiv="refresh" content="1; URL=admin.php" />
<?php }else{ ?>
<form action="admin.php" method="post">
<table width="519">
<?php
$sql=mysql_query("SELECT * FROM `".$DB['webdb']."`.`config`");

while ( $row = mysql_fetch_assoc($sql) ) {
    ?>
    <tr>
	<td><?php echo $Lang[$row['config_name']];?>:</td>
	<td><input name="<?php echo $row['config_name'];?>" size="50" value="<?php echo htmlspecialchars(stripslashes($row['config_value']));?>" type="text" /></td>
    </tr>
    <?php
    }
    ?>
    <tr><td></td><td align="left"><input value="<?php echo $Lang['save'];?>" type="submit" /></td></tr>
</table>
</form>
<?php
}
} else { echo $Lang['nothing_here'];}
foot();
?>