<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if ($_POST['account'] && $_POST['password'])
{
    $login = mysql_fetch_array(mysql_query("SELECT * FROM accounts WHERE `login` = '" . mysql_real_escape_string($_POST['account'])."' AND `password`='".encodePassword($_POST['password'])."'"));
    if ($login) 
    {
        if (isset($_POST["rememberme"]))
            {
				$rememberme=1;
            } 
            else 
            {
				$rememberme=0;
        }
    logincookie(mysql_real_escape_string($_POST['account']), md5(encodePassword(($_POST['password']))), $rememberme);
    header('Location:index.php');
    }  
    else 
    { 
        error('1'); 
    }
}
head("");
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
mysql_close($link);
?>