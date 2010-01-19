<?php
//пароль
define('INWEB', True);
require_once("include/config.php");

if (!logedin())
{
    head("Login");
?>
<form action="index.php" method="post">
<table border="1" cellpadding="0">
<tr><td><?php echo $Lang['account']; ?>:</td><td align="left"><input type="text" name="account" /></td></tr>
<tr><td><?php echo $Lang['password']; ?>:</td><td align="left"><input type="password" name="password" /></td></tr>
<tr><td><?php echo $Lang['remember_me']; ?></td><td align="left"><input type="checkbox" name="rememberme"/>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="button" value="<?php echo $Lang['login']; ?>" /></td></tr>
</table></form>
<center><a href="reg.php"><?php echo $Lang['register'];?></a></center>
<?php
}else{error('10'); exit();}
foot();
?>