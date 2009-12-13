<?php
//пароль

if (!logedin())
{
?>
<form action="index.php" method="post">
<table border="0" cellpadding="0" width="0%">
<tr><td><?php echo $Lang['account']; ?>:</td><td align="left"><input type="text" name="account" class="login" /></td></tr>
<tr><td><?php echo $Lang['password']; ?>:</td><td align="left"><input type="password" name="password" class="pass" /></td></tr>
<tr><td><?php echo $Lang['remember_me']; ?></td><td align="left"><input type="checkbox" name="rememberme"/>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="button" value="<?php echo $Lang['login']; ?>" /></td></tr>
</table></form>
<?php
}
else
{
?>
<table border="0" cellpadding="0">
<tr><td><?php echo sprintf($Lang['welcome'], $CURUSER['login']);?></td></tr>
<?php
if($CURUSER['accessLevel'] == '127'){echo "<tr><td><center><a href=\"admin.php\"><font color=\"red\">{$Lang['admin']}</font></a></center></td></tr>";}

$time=$CURUSER['voted']+60*60*12;
echo "<tr><td align=\"center\"><font color=\"red\">";
if($time > time())
{

echo "{$Lang['vote_after']} <br />";
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
    <tr><td><center><a href="mychars.php"><?php echo $Lang['my_chars'];?></a></center></td></tr>
    <tr><td><center><a href="logout.php"><?php echo $Lang['logout'];?></a></center></td></tr>
    </table>
    <?php
}
?>