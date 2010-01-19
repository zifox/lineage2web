<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Donate");
includeLang('donate');
?>
<table border="0" width="470" cellspacing="0" cellpadding="0" class="btb" style="background-color: #f0f0f0" valign="top">
<tr class="colhead"><td width="300"><?php echo $Lang['Donate'];?></td></tr>

<?php
	$error=0;
	If($_POST['nick']){
		$charid=mysql_result(mysql_query("SELECT charId FROM {$DBconfig['mysql_db']}.`characters` WHERE `char_name` = '".mysql_real_escape_string($_POST['nick'])."' LIMIT 1"), 0, 0);
		If(!$charid){
			echo sprintf($Lang['notfound'], $_POST['nick']);
			$error++;
		}
	}
    if (isset($_POST['code']) && isset($_POST['vertiba']) && !$error) {
    $code = 0 + $_POST['code'];
    $id = 92;
    $price = $_POST['vertiba'];
    $answer = @file_get_contents("http://sms.solarf.lv/confirm.php?code=$code&id=$id&price=$price",FALSE,NULL,0,140);
	function SF($price) {

 $slr = array("slr","slrlt","slree");
 $cena = array("","","");

 $newprice = str_replace($slr, $cena, $price);

 return $newprice;
}
$newprice = SF($price);
    if ($answer && $answer == 'key_ok') {
      $nick = isset($_POST['nick']) ? $_POST['nick'] : 'Anonymous';
      $nicks = mysql_real_escape_string(substr($nick, 0, 45));
      $time = time();
      $ip = $_SERVER['REMOTE_ADDR'];
      
      ################################## REWARD ####################################
  //    $chardid=mysql_query("SELECT charId FROM characters WHERE char_name=".mysql_real_escape_string($_POST['nick']));
 //     mysql_query("INSERT INTO items (owner_id, item_id, count) values ('$nicks', '$newprice', '$time', '$code', '$ip')");
      //mysql_query("INSERT INTO donates (name, price, time, code, ip) values ('$nicks', '$newprice', '$time', '$code', '$ip')");
      ################################## REWARD ####################################
      echo sprintf($Lang['ty_for_donate'], $nicks);
    } else {
      echo $Lang['sry_code_incorrect'];
    }
  }
?>
<tr colspan="2"><td>
<script type="text/javascript">
function show(ele) {
	document.getElementById('vert0').style.display='none';
	document.getElementById('vert1').style.display='none';
	document.getElementById('vert2').style.display='none';
	document.getElementById('vert3').style.display='none';
	document.getElementById('vert4').style.display='none';
	document.getElementById('vert5').style.display='none';
	document.getElementById('vert6').style.display='none';
	document.getElementById('vert7').style.display='none';
	document.getElementById('vert8').style.display='none';
	document.getElementById('vert9').style.display='none';
	document.getElementById('vert10').style.display='none';
	document.getElementById('vert11').style.display='none';
	document.getElementById('vert12').style.display='none';
	document.getElementById('vert13').style.display='none';
	document.getElementById('vert14').style.display='none';
	document.getElementById('vert15').style.display='none';
	document.getElementById('vert16').style.display='none';
	document.getElementById('smsform').style.display='block';
	document.getElementById(ele).style.display='block';
	return false;
}
</script>

<div align="center">
<table width="100%" align="left">
	<tr>
		<td width="250" align="left" valign="top">
		<div class="block">

					<form id="smsdonate" action="" method="POST">
<table border="0">
	<tr>
		<p><?php echo $Lang['choose_price'];?>:</p>
		<td align="center">
		<span><input onclick="show('vert1')" type="radio" value="slr15" name="vertiba" />0.15 LVL</span><br />
		<span><input onclick="show('vert2')" type="radio" value="slr35" name="vertiba" />0.35 LVL</span><br />
		<span><input onclick="show('vert3')" type="radio" value="slr75" name="vertiba" />0.75 LVL</span><br />
		<span><input onclick="show('vert4')" type="radio" value="slr95" name="vertiba" />0.95 LVL</span><br />
		<span><input onclick="show('vert5')" type="radio" value="slr200" name="vertiba" />2.00 LVL</span><br />
		<span><input onclick="show('vert6')" type="radio" value="slr300" name="vertiba" />3.00 LVL</span><br /></td>
		
		<td align="center">
		<span><input onclick="show('vert7')" type="radio" value="slrlt1" name="vertiba" />1 LTL</span><br />
		<span><input onclick="show('vert8')" type="radio" value="slrlt2" name="vertiba" />2 LTL</span><br />
		<span><input onclick="show('vert9')" type="radio" value="slrlt3" name="vertiba" />3 LTL</span><br />
		<span><input onclick="show('vert10')" type="radio" value="slrlt5" name="vertiba" />5 LTL</span><br />
		<span><input onclick="show('vert11')" type="radio" value="slrlt7" name="vertiba" />7 LTL</span><br />
		<span><input onclick="show('vert12')" type="radio" value="slrlt10" name="vertiba" />10 LTL</span><br />

		</td>
			<td align="center">
		<span><input onclick="show('vert13')" type="radio" value="slree5" name="vertiba" />5 EEK</span><br />
		<span><input onclick="show('vert14')" type="radio" value="slree10" name="vertiba" />10 EEK</span><br />
		<span><input onclick="show('vert15')" type="radio" value="slree25" name="vertiba" />25 EEK</span><br />
		<span><input onclick="show('vert16')" type="radio" value="slree35" name="vertiba" />35 EEK</span><br /></td></tr></table>

						<div id="smsbox">
							<div id="vert0">&nbsp;</div>
							<div id="vert1" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR15', '157', 'LMT/Tele2/Bite', '0.15', 'LVL')?></div>
							<div id="vert2" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR35', '157', 'LMT/Tele2/Bite', '0.35', 'LVL')?></div>
								<div id="vert3" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR75', '157', 'LMT/Tele2/Bite', '0.75', 'LVL')?></div>	
							<div id="vert4" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR95', '157', 'LMT/Tele2/Bite', '0.95', 'LVL')?></div>
							<div id="vert5" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR200', '157', 'LMT/Tele2/Bite', '2.00', 'LVL')?></div>
							<div id="vert6" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR300', '157', 'LMT/Tele2/Bite', '3.00', 'LVL')?></div>
						
							<div id="vert7" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT1', '1337', 'Tele2/Bite/Omnitel', '1.00', 'LTL')?></div>
							<div id="vert8" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT2', '1337', 'Tele2/Bite/Omnitel', '2.00', 'LTL')?></div>
							<div id="vert9" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT3', '1337', 'Tele2/Bite/Omnitel', '3.00', 'LTL')?></div>
							<div id="vert10" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT5', '1337', 'Tele2/Bite/Omnitel', '5.00', 'LTL')?></div>
							<div id="vert11" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT7', '1337', 'Tele2/Bite/Omnitel', '7.00', 'LTL')?></div>
							<div id="vert12" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT10', '1337', 'Tele2/Bite/Omnitel', '10.00', 'LTL')?></div>
						
							<div id="vert13" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE5', '1311', 'EMT/TELE2/Elisa', '5.00', 'EEK')?></div>
							<div id="vert14" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE10', '13011', 'EMT/TELE2/Elisa', '10.00', 'EEK')?></div>
							<div id="vert15" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE25', '13013', 'EMT/TELE2/Elisa', '25.00', 'EEK')?></div>
							<div id="vert16" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE35', '13015', 'EMT/TELE2/Elisa', '35.00', 'EEK')?></div>
						</div>
						
<div id="smsform" style="display: none;">
<table><tbody>
<tr><th><?php echo $Lang['unlock_code'];?>:</th><td><input name="code" /></td></tr>
<tr><th><?php echo $Lang['name'];?>:</th><td><input name="nick" /></td></tr>
<tr><th colSpan="2"><input class="button" type="submit" value="<?php echo $Lang['do_donate'];?>" /></th></tr>
</tbody></table></div></form></div>
				</td>	
				<?php /*
<div id="smslist">
		<td align="left" valign="top" width="160">
		<center><h2><span><?php echo $Lang['ty_donators'];?></span></h2></center>
		<table>
			<tr>
				<td width="20">#</td>
				<td width="80"><?php echo $Lang['nickname'];?></td>
				<td width="40"><?php echo $Lang['value'];?></td>
			</tr>
<?php
  $i = 1;
  $res = mysql_query("select name, time, sum(price) as 'sum' from donates group by name order by sum desc limit 50");
  while ($row = mysql_fetch_assoc($res)) {
  echo "<tr><td>".$i."</td><td>".htmlspecialchars($row['name'])."</td><td>".round($row['sum']/100, 2)." LS</td></tr><br />";
  $i++;
  }
?>
</table>
</td>
</div>*/?>
</tr></table></div>
</td></tr></table>
<?php
foot();
?>