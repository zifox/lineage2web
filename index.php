<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if ($_POST['account'] && $_POST['password'])
{
    $login = mysql_fetch_array(mysql_query("SELECT * FROM accounts WHERE `login` = '" . mysql_real_escape_string($_POST['account'])."' AND `password`='".encodePassword($_POST['password'])."'"));

		if ($login) {

				if (isset($_POST["rememberme"])) {
					$rememberme=1;

				} else {
					$rememberme=0;
				}
			logincookie(mysql_real_escape_string($_POST['account']), md5(encodePassword(($_POST['password']))), $rememberme);

                //header('Location:'.$Config['url'].'/index.php');
        }  else { error('1'); }
}
head("");
includeLang('start');
?>
<img src="img/line.png" height="29" width="419" alt="" title="" />
<br/>

<font color="#cc5500" face="arial black,avant garde" size="3">
:<?php echo $Lang['serverinfo'];?>: <br/>
<?php echo $Config['ServerName'];?><br/>
<?php echo $Lang['rates'];?> - Exp:<?php echo $Config['Exp'];?> SP:<?php echo $Config['SP'];?> Adena:<?php echo $Config['Adena'];?> Items:<?php echo $Config['Items'];?> Spoil:<?php echo $Config['Spoil'];?> <br/>
<?php echo $Lang['events'];?>: <font color="green"><?php echo $Config['Events'];?></font><br />
<?php echo $Lang['addinfo'];?>: <font color="blue"><?php echo $Config['Features'];?></font><br />
<img src="img/line.png" height="29" width="419" alt="" title="" /><br />
</font>
<br/>
<font color="#ff9900" face="arial black,avant garde" size="3"><?php echo $Lang['Desc'];?></font>
<hr />
<br/><font color="#cc5500" face="arial black,avant garde" size="3">
<a href="vote.php"><?php echo $Lang['vote_and_receive'];?></a>
</font>
<br />
<hr />
<script src="http://wos.lv/d.php?11603" type="text/javascript"></script>
<br />
<a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" /></a><br />
<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="<?php echo $Lang['ValidCSS'];?>!" /></a>

<?php
foot();
mysql_close($link);
?>