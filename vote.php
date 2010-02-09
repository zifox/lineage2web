<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Vote");
includeLang('vote');
if (!logedin())
{
    msg('Error', 'You need to login', 'error'); 
}

if (logedin())
{
$action = $_GET['action'];
$hidden = $HTTP_POST_VARS['secrethiddenfromyou'];

 
$timevoted = $_SESSION['vote_time'];
$now = time();

if ($timevoted >= ($now-60*60*12))
{
msg($Lang['thank_you'], $Lang['vote_tommorow']);
}
if ($action == "vote" && $timevoted <= ($now-60*60*12))
{
if($hidden!=1 || !$_SESSION['vote_rnd']<time() && !$_SESSION['vote_rnd']>=time()-60*5){die();}
//$charid=mysql_real_escape_string($_POST['char']);
$_SESSION['vote_time']=$now;
mysql_query("UPDATE `accounts` SET `voted`='$now', `webpoints`='".$Config['vote_reward']."' WHERE `login` = '{$_SESSION['account']}'");
msg($Lang['thank_you'], $Lang['thank_for_voting']);

}elseif($action == "vote" && $timevoted >= ($now-60*60*12))
{
    error('8');
}
}
?>
<b><?php echo $Lang['vote_for_server'];?></b><br />

<script language="javascript" src="scripts/vote.js" type="text/javascript"></script>
<form name="vote" method="post" action="vote.php?action=vote">
<table border="1" cellspacing="0" cellpadding="5">
<tr><td><img src="http://www.xtremeTop100.com/votenew.jpg" alt="xtremeTop100" /></td><td><input type="button" onclick="one()" value="xtremetop" /></td></tr>

<tr><td><img src="http://www.gamingsites100.com/imgs/button_14.jpg" alt="gamingsites100" /></td><td><input type="button" onclick="two()" disabled="disabled" value="gamingsites" /></td></tr>

<tr><td><img src="http://www.gtop100.com/images/votebutton.jpg" alt="gtop100" /></td><td><input type="button" onclick="finish()" disabled="disabled" value="gtop100" /></td></tr>
</table>
<br />
<table border="1" cellspacing="0" cellpadding="5">
<tr><td>
<center><script src="http://wos.lv/v.php?11603" type="text/javascript"></script></center></td></tr><tr><td>
<script language="javasript" src="http://wos.lv/a.php?b=180x250&amp;c=11603" type="text/javascript"></script> 
</td></tr></table><br />

<?php
if(logedin())
{
    $_SESSION['vote_rnd']=time();
    ?>
    <div align="center">From now for voting you will receive <?php echo $Config['vote_reward'];?> webpoints</div>
    <?php
/*
<table border="1" cellspacing="0" cellpadding="5">
<tr><td><select id="reward" name="reward">
<option value="vitality" id="vitality"><?php echo $Lang['vitality_4lvl'];?></option>
<option value="gold" id="gold"><?php echo $Lang['gold_einhasad'];?></option>
</select>

<select id="char" name="char">
<?php
$query=mysql_query("SELECT `charId`, `char_name` FROM `characters` WHERE `account_name`='{$_SESSION['account']}'");
while($row=mysql_fetch_assoc($query))
{
    echo "<option value=\"{$row['charId']}\">{$row['char_name']}</option>";
}
?>
</select></td></tr>
<tr><td align="center"><input type="hidden" value="1" name="secrethiddenfromyou" />
<input name="go" type="submit" disabled="disabled" value="<?php echo $Lang['get_reward'];?>" />
</td></tr></table>
*/?>
<input name="go" type="submit" disabled="disabled" value="<?php echo $Lang['get_reward'];?>" />
<?php }
?>
</form>
<?php
foot();
?>