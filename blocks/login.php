<?php
//пароль
if ($_SESSION['logged']){
	$parse = $Lang;
	$parse['welcome_user']=sprintf($Lang['welcome'], $_SESSION['account']);
	if($_SESSION['admin']){
		$parse['admin_link'] = "<tr><td><center><a href=\"admin.php\"><font color=\"red\">{$Lang['admin']}</font></a></center></td></tr>";
		$parse['admin_link2'] = "<tr><td><center><a href=\"contact.php?action=read\"><font color=\"red\">{$Lang['contact']}</font></a></center></td></tr>";
	}
	$parse['time'] = $_SESSION['vote_time']+60*60*12;
 	if($time > time()){
		$parse['vote_after'] = $Lang['vote_after'].'<br />';
	}
	$parse['wp_link'] = sprintf($Lang['webpoints'], $_SESSION['webpoints']);
	$tpl->parsetemplate('blocks/login_logged', $parse);
}
else{
    ?>
    <form action="login.php" method="post">
    <?php echo $Lang['account']; ?>: <input type="text" name="account" style="border: 0pt none; background: url(&quot;img/login_text.gif&quot;) no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 129px;" />
    <?php echo $Lang['password']; ?>: <input type="password" name="password" style="border: 0pt none; background: url(&quot;img/login_text.gif&quot;) no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 129px;" />
    <?php echo $Lang['remember_me']; ?> <input type="checkbox" name="remember" />
    <br />
    <?php
    button($Lang['login']);
    ?>
    </form>
    <?php
} ?>