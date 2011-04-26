<?php
$skinurl = 'skins/scorpion';
if($foot){
    $blckStat=includeBlock('stats','Status',0,true); 
?>
    </td></tr>
    <tr><td width="600px" height="81px" style="background: url('<?php echo $skinurl;?>/img/contbg_bot.png');">&nbsp;</td></tr>
    </table>
    
    </div>
    <div id="info" class="opacity2" style="display: none; width: 300px; height: 194px; position: fixed; left:400px; top: 300px; z-index: 1; background: url('<?php echo $skinurl;?>/img/logo2.png');">
    <div style="position: fixed; left:475px; top:350px; color: white; text-align: justify; max-width: 200px;"><a onclick="document.getElementById('info').style.display='none';">X</a><br />
    
    
    <?php includeBlock('login','Login',0); ?>
    </div></div>
    
    <div id="info2" class="opacity2" style="display: none; width: 300px; height: 400px; position: fixed; left:700px; top: 250px; z-index: 2; background: url('<?php echo $skinurl;?>/img/logo.png');">
    <div style="position: fixed; left:770px; top:300px; color: white; text-align: right; max-width: 220px;"><a onclick="document.getElementById('info2').style.display='none';">X</a><br />
    <?php 
    echo $blckStat; ?>
    </div></div>
    
    <div id="status" style="position: absolute; left:800px; top: 250px; z-index: 1; width: 250px; height: 303px; background: url('<?php echo $skinurl;?>/img/status.png') 250px 303px" onclick="document.getElementById('info2').style.display='block';">
    
    <table width="165px" style="margin-left: 50px; margin-top: 70px;"><tr><td>    <?php echo $blckStat; ?></td></tr></table>


    </div>
    <div id="login" style="position: absolute; left:800px; top: 550px; z-index: 1; width: 250px;"><a href="#" onclick="document.getElementById('info').style.display='block';"><img width="100%" src="<?php echo $skinurl;?>/img/login.png" /></a></div>
    <!--div id="forum" style="position: absolute; left:5px; top: 500px; z-index: 1; width: 200px;"><a href="<?php echo getConfig('head','url');?>/forum" target="_blank"><img width="100%" src="<?php echo $skinurl;?>/img/forum.png" /></a></div -->
    <div id="connect" style="position: absolute; left:800px; top: 775px; z-index: 1; width: 250px;"><a href="connect.php"><img width="100%" src="<?php echo $skinurl;?>/img/connect.png" /></a></div>
    <div style="position: absolute; top: 1000px; left: 100px;">
    <?php echo skin_selector(select_skin(),true); 
    
    ?>
    </div>
    <div style="position: absolute; top: 1000px; left: 300px;">
<table align="center">
    <?php }else{ ?><table align="center"><?php } 
$timeparts = explode(" ",microtime());
$endtime = $timeparts[1].substr($timeparts[0],1);
?>

<tr align="center" valign="bottom">
<td align="center" valign="middle"><b>Lineage II</b> is a trademark of NCsoft Corporation. Copyright © <b>NCsoft Corporation</b>. All rights reserved.<br /><?php echo getConfig('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> &copy; LineageII PvP Land'); ?><br /><?php echo sprintf($Lang['page_generated'], bcsub($endtime,$starttime,6), $sql->totalsqltime, $sql->querycount);?>
</td>
</tr>
</table><br /></div>
<?php
if (getConfig('debug', 'sql', '0'))
    $sql->debug();
if (getConfig('debug', 'user', '0'))
    $user->debug();
?>

</body></html>