<?php 
//пароль
define('INWEB', True);
require_once("include/config.php");
if(logedin())
{
    head("Registration");
    msg('Error', 'You already have account', 'error');
    foot();
    mysql_close($link);
    die();
}

If($_POST)
{
    if(ereg("^([a-zA-Z0-9_-])*$", $_POST['account']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['password']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['password2']))
{
	if ($_POST['account'] && strlen($_POST['account'])<16 && strlen($_POST['account'])>3 && $_POST['password'] && $_POST['password2'] && $_POST['password']==$_POST['password2'])
	{	
		$check=mysql_query("select * from accounts where login='".mysql_real_escape_string($_POST['account'])."'");
		if(mysql_num_rows($check))
		{
			error('6');
		}
		else
		{
	  		mysql_query("INSERT INTO accounts (login, password, accessLevel) VALUES ('".mysql_real_escape_string($_POST['account'])."', '".encodePassword($_POST['password'])."', 0)", $link);

	 		msg('Success', 'Registration successfull');
		}
	}
	else
	{
  	error('5');
	}
}
else
{
	error('4');
}
}
head("Registration");
?>
<h4>Registration</h4>
<br /><br /><ul>
<li> Account and password can not be empty .</li><br />
<li> Account and password can not be less than 4 and Over 15 characters .</li><br />
<li>Account and password are written in English letters and numerals .</li><br /><br /><br />
</ul>

<script type="text/javascript">//<![CDATA[
function isAlphaNumeric(value)
{
  if (value.match(/^[a-zA-Z0-9]+$/))
    return true;
  else
    return false;
}
function checkform(f)
{
  if (f.account.value=="")
  {
    alert("Fill in all fields Please");
    return false;
  }
  if (!isAlphaNumeric(f.account.value))
  {
    alert("Fill in all fields");
    return false;
  }
  if (f.password.value=="")
  {
    alert("No password ");
    return false;
  }
  if (!isAlphaNumeric(f.password.value))
  {
    alert("444444");
    return false;
  }
  if (f.password2.value=="")
  {
    alert("You didnt repeat a password");
    return false;
  }
  if (f.password.value!=f.password2.value)
  {
    alert("Not the same password ");
    return false; 
  }
  return true;
}
//]]></script>
<form method="post" action="reg.php" onsubmit="return checkform(this)">
<table>
 <tr>
  <td>Login</td>
  <td><input type="text" name="account" maxlength="15" /></td>
 </tr>
 <tr>
  <td>Password</td>
  <td><input type="password" name="password" maxlength="15" /></td>
 </tr>
 <tr>
  <td>Repeat Password</td>
  <td><input type="password" name="password2" maxlength="15" /></td>
 </tr>
 <tr>
  <td colspan="2" style="text-align: center;"><br />
  <input type="submit" name="submit" value="Register" /></td>
 </tr>
</table>
</form>
<?php
foot();
mysql_close($link);
die();
?>         