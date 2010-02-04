<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Home");
includeLang('start');
?>

<h1><?php echo $Lang['rates'];?></h1>
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