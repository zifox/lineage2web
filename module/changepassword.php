<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link href="css/css.css" rel="stylesheet">
<H4>Change Password</h4>
<p><a href="index.php?id=reg ">Register</a></p>          
<br><br>
 <ul>
<LI> Account and password can not be empty .<BR>
<LI> Account and password can not be less than 4  and Over 15 characters .<BR>
<LI>Account and password are written in English letters and numerals.<BR><BR><BR>
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
    alert("Fill all fields of of the form ");
    return false;
  }
  if (!isAlphaNumeric(f.account.value))
  {
    alert("Fill all fields of of the form");
    return false;
  }
  if (f.oldpassword.value=="")
  {
    alert("You didnt put your old password");
    return false;
  }
  if (f.newpassword.value=="")
  {
    alert("No password detected in the field");
    return false;
  }
  if (!isAlphaNumeric(f.newpassword.value))
  {
    alert("44444");
    return false;
  }
  if (f.newpassword2.value=="")
  {
    alert("You didnt type password again");
    return false;
  }
  if (f.newpassword.value!=f.newpassword2.value)
  {
    alert(" Password are not the same  ");
    return false; 
  }
return true;
}
//]]></script>
</head>
<body>
<form method="post" action="index.php?id=changepassword" onsubmit="return checkform(this)">
<table>
 <tr>
  <td>Login</td>
  <td><input maxlength="15" name="account" type="text" /></td>
 </tr>
 <tr>
  <td>Old Password</td>
  <td><input maxlength="15" name="oldpassword" type="password" /></td>
 </tr>
 <tr>
  <td>New Password</td>
  <td><input maxlength="15" name="newpassword" type="password" /></td>
 </tr>
 <tr>
  <td>Repeat password </td>
  <td><input maxlength="15" name="newpassword2" type="password" /></td>
 </tr>
 <tr>
  <td colspan="2" style="text-align: center;"><br /><input type="submit" name="submit" value="Change" /></td>
 </tr>
</table>
</form>

<?php
if(ereg("^([a-zA-Z0-9_-])*$", $_POST['account']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['oldpassword']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['newpassword']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['newpassword2']))
{
	if ($page='index.php' && $_POST['account'] && strlen($_POST['account'])<16 && $_POST['oldpassword'] && $_POST['newpassword'] && $_POST['newpassword']==$_POST['newpassword2'])
	{
  	$result=mysql_query("SELECT login,password FROM accounts WHERE login='".@mysql_real_escape_string($_POST['account'])."' AND password='".base64_encode(pack('H*', sha1($_POST['oldpassword'])))."'", $link)
	    or die ("Error: ".mysql_error());
  	if (mysql_num_rows($result))
  	{
    	mysql_query("UPDATE accounts SET password='".base64_encode(pack('H*', sha1($_POST['newpassword'])))."' WHERE login='".mysql_real_escape_string($_POST['account'])."'", $link)
      	or die ("Error: ".mysql_error());
	    print "<p style=\"font-weight: bold;\"><h2>Password has been changed. </h2></p>";
  	}
  	else
	    print "<p class=\"error\">That's it : ( something went wrong, give another try.  </p>";
  	mysql_close($link);
	}
}
else
{
	echo "Restrictions have not been tested for safety. If you are confident that had the correct information, please refer to the administration .";
}
?><br><br><br><br><br><br><br><br>


    
           
