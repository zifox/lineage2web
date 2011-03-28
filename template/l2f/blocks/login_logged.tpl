<table border="0" cellpadding="0">
{admin_link}
<tr><td align="center"><font color="red">{vote_after_msg}
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
    <tr><td><center>{wp_link}</center></td></tr>
    <tr><td><center><a href="message.php?a=viewmailbox&amp;box=1"><img src="img/pn_inbox{new}.gif" alt="{inbox}" title="{in_mes}" border="0" /></a>/<a href="message.php?a=viewmailbox&amp;box=2"><img src="img/pn_sentbox.gif" alt="{outbox}" title="{out_mes}" border="0" /></a></center></td></tr>
    <tr><td><center><a href="logout.php">{logout}</a></center></td></tr>
    </table>