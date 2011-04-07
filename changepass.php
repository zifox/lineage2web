<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
loggedinOrReturn('changepass.php');
head("Change Password");
includeLang('change_pass');

if($_POST){
    $acc=$_SESSION['account'];
    $old=getVar('oldpassword');
    $pass=getVar('newpassword');
    $pass2=getVar('newpassword2');
    $user->changepass($acc,$old,$pass,$pass2);
}else{
?>
<h1><?php echo $Lang['changepass'];?></h1>
<?php echo $Lang['password_desc'];?>
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
<form method="post" action="changepass.php" onsubmit="return checkform(this)">
<table>
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
  <td colspan="2" style="text-align: center;"><?php button('Change');?></td>
 </tr>
</table>
</form>
<?php
}
foot();
?>