<?php
//пароль
define('INWEB', True);
require_once("include/config.php");

if ($_POST)
{
    if (isset($_POST['account']) && isset($_POST['password'])){
    $account=mysql_real_escape_string($_POST['account']);
    $pass=encodePassword($_POST['password']);
    $login = mysql_fetch_array(mysql_query("SELECT * FROM `accounts` WHERE `login` = '" . $account."' AND `password`='".$pass."'"));

    if ($login) 
    {
        $_SESSION['account']=$login['login'];
        $_SESSION['IP']=$_SERVER['REMOTE_ADDR'];
        $_SESSION['last_act']=time();
        $_SESSION['vote_time']=$login['voted'];
        $_SESSION['webpoints']=$login['webpoints'];
        
        if ($login['accessLevel']==127){
            $_SESSION['admin']=true;
        }else{
            $_SESSION['admin']=false;
        }
        
        if (isset($_POST["rememberme"]) && $_POST['rememberme'] == true)
            {
                $_SESSION['remember']=true;
            } 
            else 
            {
                $_SESSION['remember']=false;
        }
    header('Location:index.php');
    }  
    else 
    { 
        error('1'); 
    }
}
}
    head("Login");
    if(!logedin()){
?>
<form action="login.php" method="post">
<table border="1" cellpadding="0">
<tr><td><?php echo $Lang['account']; ?>:</td><td align="left"><input type="text" name="account" /></td></tr>
<tr><td><?php echo $Lang['password']; ?>:</td><td align="left"><input type="password" name="password" /></td></tr>
<tr><td><?php echo $Lang['remember_me']; ?></td><td align="left"><input type="checkbox" name="rememberme"/>
</td></tr>
<tr><td colspan="2" align="center"><?php button($Lang['login']);?></td></tr>
</table></form>
<center><a href="reg.php"><?php echo $Lang['register'];?></a></center>
<?php
}else{error('10');}
foot();
?>