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
            head("Login", 1, 'index.php', 5);
            msg("Success", "You have been successfully loged in");
            foot();
            exit();
        }else{
            head("Login", 1, 'index.php', 5);
            msg("Error", "You have failed to log in", 'error');
            foot();
            exit();
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
        head("Login", 1, 'index.php', 5);
        msg("Error", "You are already logged in", 'error');
    }
foot();
}
?>