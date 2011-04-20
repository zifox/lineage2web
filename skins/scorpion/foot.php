<?php
$skinurl = 'skins/scorpion';
if($foot){
?>
    </td></tr>
    <tr><td width="600px" height="81px" style="background: url('<?php echo $skinurl;?>/img/contbg_bot.png');">&nbsp;</td></tr>
    </table>
    
    </div>
    <div id="info" style="display: none; width: 300px; height: 194px; position: fixed; left:400px; top: 300px; z-index: 1; background: url('<?php echo $skinurl;?>/img/logo2.png');">
    <div style="position: fixed; left:425px; top:350px; color: white; text-align: right; max-width: 200px;"><a href="#" onclick="document.getElementById('info').style.display='none';">X</a><br />
    <?php
    includeLang('blocks/login');
    $parse=$Lang;
    if(!$user->logged())
    { 
        $parse['static'] = $staticurl;
        $parse['button'] = button( $Lang['login'], '', 1 );
        $tpl->parsetemplate( 'blocks/login', $parse );
    }
    else
    {
        	$parse['welcome_acc'] = sprintf($Lang['welcome'], $_SESSION['account']);
	if ($_SESSION['admin'])
	{
		$parse['admin_link'] = '<tr><td><center><a href="admin.php"><font color="red">' .
			$Lang['admin'] . '</font></a></center></td></tr>';
	}
	$parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;
	if ($parse['time'] > time())
	{
		$parse['vote_after_msg'] = $Lang['vote_after'] . '<br />';
	}
    $sql->query("SELECT Count(*) AS sent FROM l2web.messages WHERE sender='{$_SESSION['account']}'");
    $msg=$sql->fetch_array();
    $parse['sent']=$msg['sent'];
    $sql->query("SELECT Count(*) AS rec FROM l2web.messages WHERE receiver='{$_SESSION['account']}'");
    $msg=$sql->fetch_array();
    $parse['rec']=$msg['rec'];
    $sql->query("SELECT Count(*) AS new FROM l2web.messages WHERE receiver='{$_SESSION['account']}' AND unread='yes'");
    $msg=$sql->fetch_array();
    $parse['unread']=$msg['new'];
    $parse['new']=($msg['new']>0)?"new":"";
    $parse['in_mes']=sprintf($Lang['in_mes'], $parse['rec'], $parse['unread']);
    $parse['out_mes']=sprintf($Lang['out_mes'], $parse['sent']);
	$parse['wp_link'] = sprintf($Lang['webpoints'], $_SESSION['webpoints']);
	$tpl->parsetemplate( 'blocks/login_logged', $parse );
    }?>
    </div></div>
    <div id="status" style="position: absolute; left:800px; top: 250px; z-index: 1;"><img width="100%" src="<?php echo $skinurl;?>/img/status.png" /></div>
    <div id="login" style="position: absolute; left:800px; top: 500px; z-index: 1;"><a href="#" onclick="document.getElementById('info').style.display='block';"><img width="100%" src="<?php echo $skinurl;?>/img/login.png" /></a></div>
    <div id="forum" style="position: absolute; left:5px; top: 500px; z-index: 1; width: 200px;"><a href="<?php echo getConfig('head','url');?>/forum" target="_blank"><img width="100%" src="<?php echo $skinurl;?>/img/forum.png" /></a></div>
    <div id="connect" style="position: absolute; left:800px; top: 675px; z-index: 1;"><a href="connect.php"><img width="100%" src="<?php echo $skinurl;?>/img/connect.png" /></a></div>
    <div>
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