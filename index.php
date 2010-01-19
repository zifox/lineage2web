<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if (isset($_POST['account']) && isset($_POST['password'])){
    $account=mysql_real_escape_string($_POST['account']);
    $pass=encodePassword($_POST['password']);
    $login = mysql_fetch_array(mysql_query("SELECT * FROM `accounts` WHERE `login` = '" . $account."' AND `password`='".$pass."'"));
    unset($account);
    unset($pass);
    if ($login) 
    {
        $_SESSION['account']=$login['login'];
        $_SESSION['IP']=$_SERVER['REMOTE_ADDR'];
        $_SESSION['last_act']=time();
        $_SESSION['vote_time']=$login['voted'];
        
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
        unset($login);
    //header('Location:index.php');
    }  
    else 
    { 
        error('1'); 
    }
}
head("Home");
includeLang('start');
?>

<br/>
<h1>
<?php echo $Lang['rates'];?></h1>
<table border="1"><tr class="header"><td class="header">Server</td><td class="header">Exp</td><td class="header">SP</td><td class="header">Adena</td><td class="header">Items</td><td class="header">Spoil</td></tr>
<tr class="content"><td class="content"><?php echo $Config['ServerName'];?>:</td><td class="content"><?php echo $Config['Exp'];?></td><td class="content"><?php echo $Config['SP'];?></td><td class="content"><?php echo $Config['Adena'];?></td><td class="content"><?php echo $Config['Items'];?></td><td class="content"><?php echo $Config['Spoil'];?></td></tr>
</table><br /><font size="3">
<?php echo $Lang['events'];?>: <font color="green"><?php echo $Config['Events'];?></font><br />
<?php echo $Lang['addinfo'];?>: <font color="blue"><?php echo $Config['Features'];?></font><br /></font>

<br/>
<font color="#ff9900" face="arial black,avant garde" size="3"><?php echo $Lang['Desc'];?></font>
<hr />
<br/>
<a href="vote.php"><font size="3"><?php echo $Lang['vote_and_receive'];?></font></a>

<?php
foot();
?>