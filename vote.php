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

 
$timevoted = $CURUSER['voted'];
$now = time();

if ($timevoted >= ($now-60*60*12))
{
msg($Lang['thank_you'], $Lang['vote_tommorow']);
}
if ($action == "vote" && $timevoted <= ($now-60*60*12))
{
if($hidden!=1){die();}
$charid=mysql_real_escape_string($_POST['char']);
if ($_POST['reward']=='vitality'){
    
mysql_query("UPDATE `accounts` SET `voted`='$now' WHERE `login` = '{$CURUSER['login']}'");
mysql_query("UPDATE `characters` SET `vitality_points`='20000' WHERE `charId`='$charid'");
    msg($Lang['thank_you'], $Lang['thank_for_voting']);
 }elseif ($_POST['reward']=='gold')
{

    mysql_query("UPDATE `accounts` SET `voted`='$now' WHERE `login` = '{$CURUSER['login']}'");
    $query=mysql_query("SELECT `object_id` FROM `items` WHERE `owner_id`='$charid' AND `item_id` = '4356' AND `loc` = 'INVENTORY'") OR mysql_error();
    if(mysql_num_rows($query))
    {
        mysql_query("UPDATE `items` SET `count` = `count` + '4' WHERE `owner_id`='$charid' AND `item_id` = '4356' AND `loc` = 'INVENTORY'");
    }else{
        $maxloc=mysql_query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$charid' AND `items`.`loc` = 'INVENTORY'") OR mysql_error();
        $itemloc=mysql_result($maxloc,0,0)+1;
        mysql_query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`,`time`) VALUES ('$charid','4356','4','INVENTORY','$itemloc','-1')") OR mysql_error();
        
    }
    msg($Lang['thank_you'], $Lang['thank_for_voting']);
}else
{
    error('2');
}
}elseif($action == "vote" && $timevoted >= ($now-60*60*12))
{
    error('8');
}
}
?>
<b><?php echo $Lang['vote_for_server'];?></b><br /></center>

<script language="javascript" src="scripts/vote.js"></script>
<form name="vote" method="post" action="vote.php?action=vote">
<table border="1" cellspacing="0" cellpadding="5">
<tr><td><img src="http://www.xtremeTop100.com/votenew.jpg" /></td><td><input type="button" onclick="one()" value="xtremetop" /></td></tr>

<tr><td><img src="http://www.gamingsites100.com/imgs/button_14.jpg" /></td><td><input type="button" onclick="two()" disabled="true" value="gamingsites" /></td></tr>

<tr><td><img src="http://www.gtop100.com/images/votebutton.jpg" /></td><td><input type="button" onclick="finish()" disabled="true" value="gtop100" /></td></tr>
</table>
<br />
<table border="1" cellspacing="0" cellpadding="5">
<tr><td>
<center><script src="http://wos.lv/v.php?11603"></script></center></td></tr><tr><td>
<script src="http://wos.lv/a.php?b=180x250&c=11603"></script> 
</tr></td></table><br />

<?php
if(logedin())
{
?>
<table border="1" cellspacing="0" cellpadding="5">
<tr><td><select id="reward" name="reward">
<option value="vitality" id="vitality"><?php echo $Lang['vitality_4lvl'];?></option>
<option value="gold" id="gold"><?php echo $Lang['gold_einhasad'];?></option>
</select>

<select id="char" name="char">
<?php
$query=mysql_query("SELECT `charId`, `char_name` FROM `characters` WHERE `account_name`='{$CURUSER['login']}'");
while($row=mysql_fetch_assoc($query))
{
    echo "<option value=\"{$row['charId']}\">{$row['char_name']}</option>";
}
?>
</select>
<tr><td align="center"><input type="hidden" value="1" name="secrethiddenfromyou" /><input name="go" type="submit" disabled="true" value="<?php echo $Lang['get_reward'];?>" /></tr></td></table>
<?php
}
?>
</form>
<?php
foot();
mysql_close($link);
?>