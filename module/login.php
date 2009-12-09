<?php
//Пожалуйста, введите своё имя и пароль
/*
if ($_POST) {
Define('INWEB', True);
require_once('./../include/config.php');
		$login = mysql_fetch_array(mysql_query("SELECT * FROM accounts WHERE `login` = '" . mysql_real_escape_string($_POST['account'])."'"));

		if ($login) {
			$epassword = encodePassword($_POST['password']);
			if ($login['password'] == $epassword) {
				if (isset($_POST["rememberme"])) {
					$rememberme=1;

				} else {
					$rememberme=0;
				}
			logincookie(mysql_real_escape_string($_POST['account']), md5(encodePassword(($_POST['password']))), $rememberme);

                header('Location:'.$Config['url'].'/index.php');

			} else {
				echo('parole nepareiza ');
			}
		} else {
			echo('lietotaajs neeksistee');
		}

	} */
?>