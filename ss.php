<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Seven Signs");
include("module/stat-menu.php");?>
<table>
<?php
$dawn=0;
$dusk=0;

$query_chars = "select * from seven_signs where cabal like '%dusk%' limit 0,1200;";
$link = mysql_query($query_chars);
while ( $row=mysql_fetch_row($link) )
{
$dawn++;
}


$query_chars = "select * from seven_signs where cabal like '%dawn%' limit 0,1200;";
$link = mysql_query($query_chars);
while ( $row=mysql_fetch_row($link) )
{
$dusk++;
}

$query_status = "select * from seven_signs_status";
$link = mysql_query($query_status);
$row=mysql_fetch_row($link);

$current_cycle = $row[1];
$festivall_cycle = $row[2];
$active_period = $row[3];
$date = $row[4];
$avarice = $row[13]+$row[16];
$gnosis = $row[14]+$row[17];
$strife = $row[15]+$row[18];

?>



<title>Seven Signs Status</title>

<script language="javascript">

var nthDay = 8;
var currTime = 'we are at work ...';
var ssStatus = 1;
var dawnPoint = <?php echo $dawn ?>;
var twilPoint = <?php echo $dusk ?>;
var maxPointWidth = 300;
var seal1 = 2;
var seal2 = 2;
var seal3 = 0;
var seal4 = 0;
var seal5 = 0;
var seal6 = 0;
var seal7 = 1;
</script>

<table style="MARGIN-TOP:0px; width:500px;" cellspacing="0" cellpadding="0" border="0" align="center">
                          <tbody>
                            <tr valign="top">
                              <td style="background: url(img/ss/ssqViewBg.jpg)" height="225"><table>
                                  <tbody>
                                    <tr valign="top">
                                      <td><table style="MARGIN: 18px 0px 0px 54px" cellspacing="0" cellpadding="0" border="0" width="141">
                                          <tbody>
                                            <tr align="middle" height="26">
                                              <td style="BACKGROUND: url(img/ss/ssqViewimg1.gif); COLOR:#fff; font-size:11px;"><!-- Subject selection + number of day Start -->
                                                <script language="javascript">

						if (0 == ssStatus) {
							document.write('Start');
						}
						else if (1 == ssStatus) {
							document.write('Competition <b style="color:#E10000"> day ' + nthDay + '</b>');
						}
						else if (2 == ssStatus) {
							document.write('Result');
						}
						else if (3 == ssStatus) {
							document.write('ss result<b style="color:#E10000"> day ' + nthDay + '</b>');
						}
					//-->
					</script>
                                                <!-- Subject selection + number of day E n d -->
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <table style="MARGIN: 3px 0px 0px 10px"
                              cellspacing="0" cellpadding="0" width="141" border="0">
                                          <tbody>
                                            <tr>
                                              <td></td>
                                              <td><img height="16" src="img/ss/timeBox1.jpg" width="140" border="0" /></td>
                                              <td></td>
                                            </tr>
                                            <tr>
                                              <td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox2.jpg" width="45" border="0" /></td>
                                              <td><!-- Clock Image Start
											--><script language="javascript">
													var timeImage;
													var tempImageNum;

													if (1 == ssStatus) {
														tempImageNum = nthDay;
													}
													else if (0 == ssStatus) {
														tempImageNum = 0;
													}
													else if (3 == ssStatus || 2 == ssStatus) {
														tempImageNum = nthDay + 7;   <!-- Adding one week to show img with seal effect -->
													}
													timeImage = 'time'+tempImageNum+'.jpg';
													document.write('<img src="img/ss/time/'+ timeImage +'" width="140" height="139" border="0" />');
												</script><!--
												Clock Image E n d --></td>
                                              <td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox3.jpg" width="66" border="0" /></td>
                                            </tr>
                                            <tr>
                                              <td><img height="12" src="img/ss/timeBox4.jpg" width="140" border="0" /></td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                      <td><table style="MARGIN: 27px 0px 0px 22px" cellspacing="0" cellpadding="0" width="200" border="0">
                                          <tbody>
                                            <tr align="middle" bgcolor="#606d6f" height="17">
                                              <td style="COLOR:#fff; font-size:11px;"><!-- Current Time start - Not Real Time but the time of query -->
                                                <?php
$timezone  = 2; //(GMT -5:00) EST (U.S. & Canada)
echo gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
?>
                                                <!-- Current Time E n d -->
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <table style="MARGIN: 21px 0px 0px 22px" cellspacing="0" cellpadding="0" border="0">
                                          <colgroup>
                                          <col width="74" />
                                          <col width="*" />
                                          <tbody>
                                            <tr>
                                              <td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" />Dawn</td>
                                              <td style="COLOR: #000; font-size:11px;"><!-- Twilight Bar Graph Start -->
                                                <script language="javascript">

						var twilPointWidth = maxPointWidth * twilPoint / 100;
						document.write('<img src="img/ss/ssqbar2.gif" width="' + twilPointWidth + '" height="9" border="0" /> ' + twilPoint);

					</script>
                                                <!-- Twilight Bar Graph E n d -->
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" height="7"></td>
                                            </tr>
                                            <tr>
                                              <td style="font-size:11px; color:#000;"><img style="MARGIN: 0px 6px 5px 0px" height="1" src="/ssq/ssq_image/dot.gif" width="1" border="0" />Dusk</td>
                                              <td style="COLOR: #000; font-size:11px;"><!-- Dawn Bar Graph Start -->
                                                <script language="javascript">

						var dawnPointWidth = maxPointWidth * dawnPoint / 100;
						document.write('<img src="img/ss/ssqbar1.gif" width="' + dawnPointWidth + '" height="9" border="0" /> ' + dawnPoint);

					</script>
                                                <!-- Dawn Bar Graph E n d -->
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <table cellspacing="0" cellpadding="0" border="0">
                                          <tbody>
                                            <tr valign="bottom" align="middle" height="95">
                                              <td><!-- It not 3 then seal must be shown as grey.Seal Status 0 = closed, 1 or 2 = opened  -->
                                                <!-- Seal #1 -->
                                                <script language="javascript">
						if (3 == ssStatus) {
							if (0 == seal1)
								document.write('<img src="img/ss/Seals/SOA/bongin1close.gif" width="85" height="86" border="0" />');
							else
								document.write('<img src="img/ss/Seals/SOA/bongin1open.gif" width="85" height="86" border="0" />');
						}   else {
							document.write('<img src="img/ss/Seals/SOA/bongin1.gif" width="85" height="86" border="0" />');
						}
					</script>
                                              </td>
                                              <td><!-- Seal #2 -->
                                                <script language="javascript">
						if (3 == ssStatus) {
							if (0 == seal2)
								document.write('<img src="img/ss/Seals/SOG/bongin2close.gif" width="85" height="86" border="0" />');
							else
								document.write('<img src="img/ss/Seals/SOG/bongin2open.gif" width="85" height="86" border="0" />');
						}   else {
							document.write('<img src="img/ss/Seals/SOG/bongin2.gif" width="85" height="86" border="0" />');
						}

					</script>
                                              </td>
                                              <td><!-- Seal #3 -->
                                                <script language="javascript">
						if (3 == ssStatus) {
							if (0 == seal3)
								document.write('<img src="img/ss/Seals/SOS/bongin3close.gif" width="85" height="86" border="0" />');
							else
								document.write('<img src="img/ss/Seals/SOS/bongin3open.gif" width="85" height="86" border="0" />');
						}   else {
							document.write('<img src="img/ss/Seals/SOS/bongin3.gif" width="85" height="86" border="0" />');
						}

					</script>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="3"><div align="center" style="margin-left:10px;"><img height="16" src="img/ss/bonginName.gif" width="258" border="0" /> </div></td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table>
 <?php
  foot();
  mysql_close($link);
?>