<?php 
$gmt = 60*60*2;
$time=1259754624+60*60*12-$gmt-time();
$targettime = time() + $time;
$targetdate = date('m/d/Y h:i:s A' , $targettime);
echo "<table border=1><tr><td>";
echo $targetdate."<br /></td></tr><tr><td>";
//echo date('H:i:s', $time);
 ?>
<script language="JavaScript">
TargetDate = "<?php echo $targetdate;?>";
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = "%%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
FinishMessage = "<a href=index.php?id=vote>Vote for Server!</a>";
</script>
<script language="JavaScript" src="scripts/clock.js" type="text/javascript"></script>
</td></tr></table>
http://lineage2.rochand.com//images/top_bar.png