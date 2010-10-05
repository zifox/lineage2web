<h1>{home}</h1><hr />
<table border="1" width="50%">
{race_rows}
<tr><td>{male}<img src="img/stat/sex.jpg" alt="{male}" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="{mc}px" alt="" /> {mc}%</td></tr>
<tr><td>{female}<img src="img/stat/sex1.jpg" alt="{female}" /></td><td><img src="img/stat/sexline.jpg" height="10px" width="{fc}px" alt="" /> {fc}%</td></tr>
</table><hr />

<h1>{seven_signs}</h1>

<script language="javascript" type="text/javascript">
<!--
var nthDay = {current_cycle};
var currTime = "{date}";
var ssStatus = {active_period};
var dawnPoint = {dawnScore};
var twilPoint = {twilScore};
var maxPointWidth = 300;
var seal1 = {aowner};
var seal2 = {gowner};
var seal3 = {sowner};

// -->
</script>

<table border="0" cellpadding="0" cellspacing="0" width="569">
<tbody>
  <tr valign="top">
    <td style="background: url(img/ss/ssqViewBg.jpg) no-repeat" height="225"><table>
        <tbody>
          <tr valign="top">
            <td><table style="margin: 18px 0px 0px 54px" cellspacing="0" cellpadding="0" border="0" width="141">
                <tbody>
                  <tr align="center" style="height:26px;">
                    <td style="background: url(img/ss/ssqViewimg1.gif) no-repeat; COLOR:#FFF; font-size:11px;">
						<script language="JavaScript" type="text/javascript">
                        <!--
						if (0 == ssStatus) {
						document.write('Preparation');
						}
						else if (1 == ssStatus) {
						document.write('Competition <b style="color:#E10000"> Day ' + nthDay + '</b>');
						}
						else if (2 == ssStatus) {
						document.write('Calculation');
						}
						else if (3 == ssStatus) {
						document.write('Seal Effect <b style="color:#E10000"> Day ' + nthDay + '</b>');
						}
                        // -->
						</script>
					</td>
                  </tr>
                </tbody>
              </table>
              <table style="margin: 3px 0px 0px 10px" cellspacing="0" cellpadding="0" width="141" border="0">
                <tbody>
                  <tr>
                    <td></td>
                    <td><img height="16" src="img/ss/timeBox1.jpg" width="140" border="0" alt="" /></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox2.jpg" width="45" border="0" alt="" /></td>
                    <td>
						<script language="JavaScript" type="text/javascript">
                        <!--
						var timeImage;
						var tempImageNum;
						
						if (1 == ssStatus) {
							tempImageNum = nthDay;
						}
						else if (0 == ssStatus) {
							tempImageNum = 0;
						}
						else if (3 == ssStatus || 2 == ssStatus) {
							tempImageNum = nthDay + 7;
						}
						
						timeImage = 'time'+tempImageNum+'.jpg';
						document.write('<img src="img/ss/time/'+ timeImage +'" width="140" height="139" border="0" alt="" />');									
						// -->
                        </script>
					</td>
                    <td valign="bottom" rowspan="2"><img height="125" src="img/ss/timeBox3.jpg" width="66" border="0" alt="" /></td>
                  </tr>
                  <tr> 
                    <td><img height="12" src="img/ss/timeBox4.jpg" width="140" border="0" alt="" /></td>
                  </tr>
                </tbody>
              </table></td>
            <td><table style="margin: 27px 0px 0px 22px" cellspacing="0" cellpadding="0" width="200" border="0">
                <tbody>
                  <tr align="center" style="height:27px;" bgcolor="#606d6f">
                    <td style="color:#FFF; font-size:11px;">
						<script language="JavaScript" type="text/javascript">
                        <!--
						document.write (currTime);
                        // -->
						</script>
					</td>
                  </tr>
                </tbody>
              </table>
              <table style="margin: 21px 0px 0px 22px" cellspacing="0" cellpadding="0" border="0">
                <colgroup>
                <col width="74" />
                <col width="*" />
                </colgroup>
                <tbody>
                  <tr>
                    <td style="font-size:11px; color:#000;"><img style="margin: 0px 6px 5px 0px" height="1" src="img/ss/dot.gif" width="1" border="0" alt="" />Dawn</td>
                    <td style="color: #000; font-size:11px;">
						<script language="JavaScript" type="text/javascript">
                        <!--
						var dawnPointWidth = maxPointWidth * dawnPoint / 1000;
						document.write('<img src="img/ss/ssqbar2.gif" width="' + dawnPointWidth + '" height="9" border="0" alt="" /> ' + dawnPoint);
						// -->
                        </script>
					</td>
                  </tr>
                  <tr>
                    <td colspan="2" height="7"></td>
                  </tr>
                  <tr> 
                    <td style="font-size:11px; color:#000;"><img style="margin: 0px 6px 5px 0px" height="1" src="img/ss/dot.gif" width="1" border="0" alt="" />Dusk</td>
                    <td style="color: #000; font-size:11px;">
						<script language="JavaScript" type="text/javascript">
                        <!--
						var twilPointWidth = maxPointWidth * twilPoint / 1000;
						document.write('<img src="img/ss/ssqbar1.gif" width="' + twilPointWidth + '" height="9" border="0" alt="" /> ' + twilPoint);
						// -->
                        </script>
					</td>
                  </tr>
                </tbody>
              </table>
              <table cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                  <tr valign="bottom" align="center" style="height:95px;">
                    <td>
						<script language="JavaScript" type="text/javascript">
                        <!--
						if (3 == ssStatus)
						{
							if (0 == seal1)
								document.write('<img src="img/ss/seals/bongin1close.gif" width="85" height="86" border="0" alt="" />');
							else
								document.write('<img src="img/ss/seals/bongin1open.gif" width="85" height="86" border="0" alt="" />');
						}else{
							document.write('<img src="img/ss/seals/bongin1.gif" width="85" height="86" border="0" alt="" />');
						}
                        // -->
						</script>
					</td><td>
						<script language="JavaScript" type="text/javascript">
                        <!--
						if (3 == ssStatus)
						{
							if (0 == seal2)
								document.write('<img src="img/ss/seals/bongin2close.gif" width="85" height="86" border="0" alt="" />');
							else
								document.write('<img src="img/ss/seals/bongin2open.gif" width="85" height="86" border="0" alt="" />');
						}else{
							document.write('<img src="img/ss/seals/bongin2.gif" width="85" height="86" border="0" alt="" />');
						}
                        // -->
						</script>
					</td><td>
						<script language="JavaScript" type="text/javascript">
                        <!--
						if (3 == ssStatus)
						{
							if (0 == seal3)
								document.write('<img src="img/ss/seals/bongin3close.gif" width="85" height="86" border="0" alt="" />');
							else
								document.write('<img src="img/ss/seals/bongin3open.gif" width="85" height="86" border="0" alt="" />');
						}else{
							document.write('<img src="img/ss/seals/bongin3.gif" width="85" height="86" border="0" alt="" />');
						}
                        // -->
						</script>
					</td> 
                  </tr> 
                  <tr> 
                    <td colspan="3"><div align="center" style="margin-left:10px;"><img height="16" src="img/ss/bonginName.gif" width="258" border="0" alt="" /> </div></td> 
                  </tr> 
                </tbody> 
              </table></td> 
          </tr> 
        </tbody> 
      </table> 
</td></tr></tbody></table>