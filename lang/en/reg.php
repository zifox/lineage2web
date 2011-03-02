<?php
//пароль
if(!defined('INLANG')){header("Location: ../../index.php"); exit();}
$Lang['registration'] = 'Registration';
$Lang['notice1'] = 'Account and password can not be empty.';
$Lang['notice2'] = 'Account and password can not be less than 6 and Over 15 characters.';
$Lang['notice3'] = 'Account and password are written in English letters and numerals.';
$Lang['notice4'] = 'Verification code is case in-sensitive and contains leters and digits.';
$Lang['fill_fields'] = 'Fill in all fields!';
$Lang['pass_no_match'] = 'Passwords doesn\'t match';
$Lang['login'] = 'Login';
$Lang['password'] = 'Password';
$Lang['r_password'] = 'Repeat Password';
$Lang['ver_img'] = 'Verification Image';
$Lang['ver_code'] = 'Verification Code';
$Lang['reg_me'] = 'Register';
$Lang[''] = '';
$Lang[''] = '';

//Errors/Messages
$Lang['error'] = 'Error';
$Lang['success'] = 'Success';
$Lang['already_reg'] = 'You already have account';
$Lang['code_incorrect'] = 'Verification code incorrect';
$Lang['already_exists'] = 'Account already exists';
$Lang['success_logged'] = 'Registration successfull<br />You have been logged in';
$Lang['success_failed'] = 'Registration successfull<br />There was a problem with autologin';
$Lang['too_short'] = 'Login or password is too short';
$Lang['invalid_chars'] = 'Login or password contains invalid chars';
?>