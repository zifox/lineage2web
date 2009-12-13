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

<SCRIPT language=javascript>

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
</SCRIPT>

<TABLE style="MARGIN-TOP:0px; width:500px;" cellSpacing=0 cellPadding=0 border=0 align=center>
                          <TBODY>
                            <TR vAlign=top>
                              <TD style="BACKGROUND: url(/module/ss/ssqViewBg.jpg)" height=225><TABLE>
                                  <TBODY>
                                    <TR vAlign=top>
                                      <TD><TABLE style="MARGIN: 18px 0px 0px 54px" cellSpacing=0 cellPadding=0 border=0 width=141>
                                          <TBODY>
                                            <TR align=middle height=26>
                                              <TD style="BACKGROUND: url(/module/ss/ssqViewimg1.gif); COLOR:#fff; font-size:11px;"><!-- Subject selection + number of day Start -->
                                                <SCRIPT language=javascript>

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
					</SCRIPT>
                                                <!-- Subject selection + number of day E n d -->
                                              </TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE>
                                        <TABLE style="MARGIN: 3px 0px 0px 10px"
                              cellSpacing=0 cellPadding=0 width=141 border=0>
                                          <TBODY>
                                            <TR>
                                              <TD></TD>
                                              <TD><IMG height=16 src="/module/ss/timeBox1.jpg" width=140 border=0></TD>
                                              <TD></TD>
                                            </TR>
                                            <TR>
                                              <TD vAlign=bottom rowSpan=2><IMG height=125 src="/module/ss/timeBox2.jpg" width=45 border=0></TD>
                                              <TD><!-- Clock Image Start
											--><SCRIPT language=javascript>
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
													document.write('<img src="/module/ss/time/'+ timeImage +'" width="140" height="139" border="0">');
												</SCRIPT><!--
												Clock Image E n d --></TD>
                                              <TD vAlign=bottom rowSpan=2><IMG height=125 src="/module/ss/timeBox3.jpg" width=66 border=0></TD>
                                            </TR>
                                            <TR>
                                              <TD><IMG height=12 src="/module/ss/timeBox4.jpg" width=140 border=0></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                      <TD><TABLE style="MARGIN: 27px 0px 0px 22px" cellSpacing=0 cellPadding=0 width=200 border=0>
                                          <TBODY>
                                            <TR align=middle bgColor=#606d6f height=17>
                                              <TD style="COLOR:#fff; font-size:11px;"><!-- Current Time start - Not Real Time but the time of query -->
                                                <?php
$timezone  = 3; //(GMT -5:00) EST (U.S. & Canada)
echo gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
?>
                                                <!-- Current Time E n d -->
                                              </TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE>
                                        <TABLE style="MARGIN: 21px 0px 0px 22px" cellSpacing=0 cellPadding=0 border=0>
                                          <COLGROUP>
                                          <COL width=74>
                                          <COL width=*>
                                          <TBODY>
                                            <TR>
                                              <TD style="font-size:11px; color:#000;"><IMG style="MARGIN: 0px 6px 5px 0px" height=1 src="/ssq/ssq_image/dot.gif" width=1 border=0>Dawn</TD>
                                              <TD style="COLOR: #000; font-size:11px;"><!-- Twilight Bar Graph Start -->
                                                <SCRIPT language=javascript>

						var twilPointWidth = maxPointWidth * twilPoint / 100;
						document.write('<img src="/module/ss/ssqbar2.gif" width="' + twilPointWidth + '" height="9" border="0"> ' + twilPoint);

					</SCRIPT>
                                                <!-- Twilight Bar Graph E n d -->
                                              </TD>
                                            </TR>
                                            <TR>
                                              <TD colSpan=2 height=7></TD>
                                            </TR>
                                            <TR>
                                              <TD style="font-size:11px; color:#000;"><IMG style="MARGIN: 0px 6px 5px 0px" height=1 src="/ssq/ssq_image/dot.gif" width=1 border=0>Dusk</TD>
                                              <TD style="COLOR: #000; font-size:11px;"><!-- Dawn Bar Graph Start -->
                                                <SCRIPT language=javascript>

						var dawnPointWidth = maxPointWidth * dawnPoint / 100;
						document.write('<img src="/module/ss/ssqbar1.gif" width="' + dawnPointWidth + '" height="9" border="0"> ' + dawnPoint);

					</SCRIPT>
                                                <!-- Dawn Bar Graph E n d -->
                                              </TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE>
                                        <TABLE cellSpacing=0 cellPadding=0 border=0>
                                          <TBODY>
                                            <TR vAlign=bottom align=middle height=95>
                                              <TD><!-- It not 3 then seal must be shown as grey.Seal Status 0 = closed, 1 or 2 = opened  -->
                                                <!-- Seal #1 -->
                                                <SCRIPT language=javascript>
						if (3 == ssStatus) {
							if (0 == seal1)
								document.write('<img src="/module/ss/Seals/SOA/bongin1close.gif" width="85" height="86" border="0">');
							else
								document.write('<img src="/module/ss/Seals/SOA/bongin1open.gif" width="85" height="86" border="0">');
						}   else {
							document.write('<img src="/module/ss/Seals/SOA/bongin1.gif" width="85" height="86" border="0">');
						}
					</SCRIPT>
                                              </TD>
                                              <TD><!-- Seal #2 -->
                                                <SCRIPT language=javascript>
						if (3 == ssStatus) {
							if (0 == seal2)
								document.write('<img src="/module/ss/Seals/SOG/bongin2close.gif" width="85" height="86" border="0">');
							else
								document.write('<img src="/module/ss/Seals/SOG/bongin2open.gif" width="85" height="86" border="0">');
						}   else {
							document.write('<img src="/module/ss/Seals/SOG/bongin2.gif" width="85" height="86" border="0">');
						}

					</SCRIPT>
                                              </TD>
                                              <TD><!-- Seal #3 -->
                                                <SCRIPT language=javascript>
						if (3 == ssStatus) {
							if (0 == seal3)
								document.write('<img src="/module/ss/Seals/SOS/bongin3close.gif" width="85" height="86" border="0">');
							else
								document.write('<img src="/module/ss/Seals/SOS/bongin3open.gif" width="85" height="86" border="0">');
						}   else {
							document.write('<img src="/module/ss/Seals/SOS/bongin3.gif" width="85" height="86" border="0">');
						}

					</SCRIPT>
                                              </TD>
                                            </TR>
                                            <TR>
                                              <TD colSpan=3><div align="center" style="margin-left:10px;"><IMG height=16 src="/module/ss/bonginName.gif" width=258 border=0> </div></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                    </TR>
                                  </TBODY>
                                </TABLE></TD>
                            </TR>
                          </TBODY>
                        </TABLE>
 <?php
  foot();
mysql_close($link);
?>