<?php 
//пароль
define('INWEB', True);
require_once("include/config.php");
//head('Registration');
if($user->logged())
{
    head('Registration', 1, 'index.php', 5);
    msg('Error', 'You already have account', 'error');
    foot();
    exit();
}

if($_POST)
{
    if(strtolower($_SESSION['captcha'])!=strtolower($_POST['captcha'])){
        head('Registration', 1, 'index.php', 5);
        msg('Error', 'Verification code incorrect', 'error');
        foot();
        exit();
    }
    $account = $mysql->escape($_POST['account']);
    $password = $mysql->escape($_POST['password']);
    $password2 = $mysql->escape($_POST['password2']);
    $ip = $_SERVER['REMOTE_ADDR'];
    if($_POST['ref']!='')
    {
        $ref=$mysql->escape($_POST['ref']);
    }

    if(ereg("^([a-zA-Z0-9_-])*$", $_POST['account']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['password']) && ereg("^([a-zA-Z0-9_-])*$", $_POST['password2']))
    {
        
        
	   if (strlen($_POST['account'])<16 && strlen($_POST['account'])>4 && $_POST['password'] && $_POST['password2'] && $_POST['password']==$_POST['password2'])
	   {
		  $check=$mysql->query("SELECT `login` FROM `accounts` WHERE `login`='".$account."'");
		  if($mysql->num_rows2($check))
		  {
                head('Registration', 1, 'index.php', 5);
                msg('Error', 'Account already exists', 'error');
                foot();
                exit();
		  }
		  else
		  {
                head('Registration',1, 'index.php',5);
                if($user->reguser($account, $password, $ref))
                {
                    msg('Success', 'Registration successfull<br />You have been logged in');
                }
                else
                {
                    msg('Success', 'Registration successfull<br />There was a problem with autologin');
                }
                foot();
                exit();
		  }
	   }
	   else
	   {
  	         error('5');
            exit();
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
<br /><br />
<ul>
<li> Account and password can not be empty .</li>
<li> Account and password can not be less than 4 and Over 15 characters .</li>
<li> Account and password are written in English letters and numerals .</li>
<li> Verification code is case in-sensitive and contains leters and digits.</li>
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
  <td>Verification Image</td>
  <td><img src="img/captcha.php" alt="" /></td>
 </tr>
  <tr>
  <td>Verification Code</td>
  <td><input type="text" name="captcha" maxlength="10" /></td>
 </tr>
 <tr>
  <td>Referal</td>
  <td><input type="text" name="ref" maxlength="16" value="<?php echo $_GET['ref'];?>" /></td>
 </tr>
 <tr>
  <td colspan="2" style="text-align: center;"><?php button('Reg Me');?></td>
 </tr>
</table>
</form>
<?php
foot();
?>         