<?php
//пароль

if (!logedin())
{
?>
<form action="login.php" method="post">
<?php echo $Lang['account']; ?>: <input type="text" name="account" style="border: 0pt none; background: url(&quot;img/login_text.gif&quot;) no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 129px;" />
<?php echo $Lang['password']; ?>: <input type="password" name="password" style="border: 0pt none; background: url(&quot;img/login_text.gif&quot;) no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 129px;" />
<?php echo $Lang['remember_me']; ?> <input type="checkbox" name="rememberme" />
<br />
<?php
button($Lang['login']);
?>
</form>
<?php
}
else
{
?>
<table border="0" cellpadding="0">
<tr><td><?php echo sprintf($Lang['welcome'], $_SESSION['account']);?></td></tr>
<?php
if(is_admin()){ ?>
<tr><td><center><a href="admin.php"><font color="red"><?php echo $Lang['admin'];?></font></a></center></td></tr>
<tr><td><center><a href="contact.php?action=read"><font color="red"><?php echo $Lang['contact'];?></font></a></center></td></tr>
<?php }
$time=$_SESSION['vote_time']+60*60*12;
?><tr><td align="center"><font color="red"><?php
if($time > time())
{

echo $Lang['vote_after'].'<br />';
}
?>
<script language="JavaScript" type="text/javascript">
<!--
TimeFormat = "%%H%% <?php echo $Lang['hours'];?>, %%M%% <?php echo $Lang['minutes'];?>, %%S%% <?php echo $Lang['seconds'];?>.";
endmsg = "<a href=vote.php><?php echo $Lang['vote'];?></a>";
secs = "<?php echo $time;?>";
var date = new Date();
var time = date.getTime()/1000;
secs = Math.floor(secs - time);
//-->
</script>
<script type="text/javascript" src="http://l2.pvpland.lv/scripts/clock.js"></script>
<span id="vote">&nbsp;</span><script type="text/javascript">Clock(secs.valueOf());</script>
</font></td></tr>
    <tr><td><center><a href="myacc.php"><?php echo $Lang['my_account'];?></a></center></td></tr>
    <tr><td><center><a href="logout.php"><?php echo $Lang['logout'];?></a></center></td></tr>
    </table>
    <?php
}
?>