<?php
//пароль
define('INWEB', True);
require_once("include/config.php");

if ($_POST && !$user->logged()) {
    if (isset($_POST['account']) && isset($_POST['password'])) {
        $account=$_POST['account'];
        $pass=$_POST['password'];
        $remember = $_POST['remember'];
        ($remember == true) ? $remember=true : $remember=false;
        if($user->checkLogin($account, $pass, $remember))
        {
            if(isset($_SESSION['returnto']))
                header ("Refresh: 3; url={$_SESSION['returnto']}");
            else
                header ("Refresh: 3; url=index.php");
            suc("Success", "You have been successfully loged in");

        }else{
            header ("Refresh: 3; url=index.php");
            err("Error", "You have failed to log in");

        }
    }
}else{
    if(!$user->logged()){
        head("Login");
        ?>
        <form action="login.php" method="post">
        <table border="1" cellpadding="0">
        <tr><td><?php echo $Lang['account']; ?>:</td><td align="left"><input type="text" name="account" /></td></tr>
        <tr><td><?php echo $Lang['password']; ?>:</td><td align="left"><input type="password" name="password" /></td></tr>
        <tr><td><?php echo $Lang['remember_me']; ?></td><td align="left"><input type="checkbox" name="remember"/>
        </td></tr>
        <tr><td colspan="2" align="center"><?php button($Lang['login']);?></td></tr>
        </table></form>
        <center><a href="reg.php"><?php echo $Lang['register'];?></a></center>
        <?php
    }else{
        header ("Refresh: 3; url=index.php");
        err("Error", "You are already logged in");
    }
foot();
}
?>