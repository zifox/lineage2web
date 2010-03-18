<table border="0" cellpadding="0">
<tr><td>{welcome_user}</td></tr>
{admin_link}
{admin_link2}
<tr><td align="center"><font color="red">{vote_after}<br />
<script language="JavaScript" type="text/javascript">
<!--
TimeFormat = "%%H%% {hours}, %%M%% {minutes}, %%S%% {seconds}.";
endmsg = "<a href=vote.php>{vote}</a>";
secs = "{time}";
var date = new Date();
var time = date.getTime()/1000;
secs = Math.floor(secs - time);
//-->
</script>
<script type="text/javascript" src="scripts/clock.js"></script>
<span id="vote">&nbsp;</span><script type="text/javascript">Clock(secs.valueOf());</script>
</font></td></tr>
<tr><td><center><a href="myacc.php">{my_account}</a></center></td></tr>
<tr><td><center><a href="contact.php">{write_message}</a></center></td></tr>
<tr><td><center>{wp_link}</center></td></tr>
<tr><td><center><a href="logout.php">{logout}</a></center></td></tr>
</table>