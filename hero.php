<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Heroes");
?>
<table width="400" style="font-size:11px; font-family:verdana; color:#999999;" cellspacing="0" cellpadding="0" align="center" border="1">
<tr>
<td style="font-size:12px; border:1px #999999 solid;"><center><b>Name</b></center></td>
<td style="font-size:12px; border:1px #999999 solid;"><center><b>Wins</b></center></td>
<td style="font-size:12px; border:1px #999999 solid;"><center><b>Class</b></center></td>
</tr>
<?php
$sql = mysql_query("SELECT `heroes`.`charId`, `char_name`, `count`, `ClassName`, `char_name` FROM `heroes` INNER JOIN `char_templates` ON `heroes`.`class_id`=`char_templates`.`ClassId` INNER JOIN `characters` ON `heroes`.`charId`=`characters`.`charId` ORDER BY count DESC;");

while($row = mysql_fetch_array($sql))

{
?>
<tr>
    <td style="font-size:10px; font-family:verdana; color:#999999;" class="content" align="center"><a href="user.php?cid=<?php echo $row['charId'];?>"><?php echo $row['char_name'];?></a></td>
	<td style="font-size:10px; font-family:verdana; color:#999999;" class="content" align="center"><?php echo $row['count'];?></td>
    	<td style="font-size:10px; font-family:verdana; color:#999999;" class="content" align="center"><?php echo $row['ClassName'];?></td>
  </tr>
  <?php
}
?>
</table>
<?php
 foot();
?>