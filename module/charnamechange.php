<?php
include("module/start_lk.php");
$submit = isset($HTTP_POST_VARS['submit'])?$HTTP_POST_VARS['submit']:false;
if ($submit)
{
 $link = mysql_connect($L2JBS_config['mysql_host'].":".$L2JBS_config['mysql_port'], $L2JBS_config['mysql_login'], $L2JBS_config['mysql_password']);
  if (!$link)
    die("Нет конекта с базой MySQL");
  @mysql_select_db($L2JBS_config['mysql_db'], $link)
    or die ('Error '.mysql_errno().': '.mysql_error());
$oldnick = $HTTP_POST_VARS['oldnick'];
$newnick = $HTTP_POST_VARS['newnick'];
$acc_name = $HTTP_POST_VARS['acc_name'];
$pass = $HTTP_POST_VARS['pass'];
$sql = "SELECT * FROM `accounts` WHERE `login` = '$acc_name'";
$res = mysql_query($sql);
$account = mysql_fetch_array($res);
if ($account['password'] != base64_encode(pack('H*',sha1(utf8_encode($pass))))) {die('Пароль неверный<br><br><a href="index.php?id=char-name-change">Назад</a>');}
$res = mysql_query("SELECT `char_name` FROM `characters` WHERE `char_name` = '$oldnick'");
if (!@mysql_num_rows($res)) {die('Вашего перса не существует<br><br><a href="index.php?d=module/lk&p=char-name-change">Назад</a>');}
$res = mysql_query("SELECT `char_name` FROM `characters` WHERE `char_name` = '$newnick'");
if (@mysql_num_rows($res)) {die('Перс с таким именем уже есть<br><br><a href="index.php?d=module/lk&p=char-name-change">Назад</a>');}
$sql = "SELECT `account_name`,`obj_Id`,`online` FROM `characters` WHERE `char_name` = '$oldnick'";
$res = mysql_query($sql);
$nick = mysql_fetch_array($res);
if ($account['login'] != $nick['account_name']) {die('А вы уверены, что это ваш чар? :D<br><br><a href="index.php?d=module/lk&p=char-name-change">Назад</a>');}
$sql = "SELECT `owner_id`,`object_id`,`item_id`,`count` FROM `items` WHERE `item_id` = 57 AND `owner_id` = ${nick['obj_Id']}";
$res = mysql_query($sql);
$money = mysql_fetch_array($res);
if ($money['count'] < $price1) {die('Нехватает бабок<br><br><a href="index.php?id=char-name-change">Назад</a>');}
if ($nick['online']) {die('Ваш перс в игре. Для начала надо выйти.<br><br><a href="index.php?id=char-name-change">Назад</a>');}
$tmp = $money['count'] - $price1;
mysql_query("UPDATE `items` SET `count` = $tmp WHERE `item_id` = 57 AND `owner_id` = ${nick['obj_Id']}");
mysql_query("UPDATE `characters` SET `char_name` = '$newnick' WHERE `obj_Id` = ${nick['obj_Id']}");
?><br>
<br>
 
<form action=index.php?d=module/lk&p=char-name-change method=post onsubmit="return checkform(this)">
  Sorry this option was denied
</form>
<?
}
?>