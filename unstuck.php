<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("UnStuck");
if(isset($_GET['cid']))
{
	$charid=0+mysql_real_escape_string($_GET['cid']);
	$query=mysql_query("SELECT `account_name`, online FROM `characters` WHERE `charId`='".$charid."'");
	if(mysql_num_rows($query))
	{
		if(mysql_result($query, 0, 'account_name')==$_SESSION['account'])
		{
			if(mysql_result($query, 0, 'online')==1)
			{
				mysql_query("UPDATE `characters` SET `x`='82698', `y`='148638', `z`='-3473' WHERE `account_name`='{$_SESSION['account']}' AND `charId`='$charid'");
				msg('Success','Character has been unstucked');
			}else
			{
				msg('Error', 'You cannot unstuck character who is online', 'error');
			}
			
			
		}else
		{
			msg('Error', 'You can only unstuck your character', 'error');
		}
	}else
	{
		msg('Error', 'Character NOT Found', 'error');
	}
}
?>

<?php
foot();
?>