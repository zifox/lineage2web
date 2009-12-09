<?php
//Пожалуйста, введите своё имя и пароль
if(!defined('INLANG')){Header("Location: ../../index.php?id=start");}
$Lang['changepass'] = 'Change Password';
$Lang['password_desc'] = 'Password cannot be empty.<br />Password should be between 6 and 16 characters.<br />Password must contain only alphanumerical chars.<br />';
$Lang['incorrect_chars'] = 'Incorrect chars entered in one of fields';
$Lang['passwords_no_match'] = 'Passwords do not match';
$Lang['old_password_incorret'] = 'Old password isn\'t correct';
$Lang['password_changed'] = 'Password has been changed!';
?>