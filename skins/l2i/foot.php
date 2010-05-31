<hr />
<div align="center">
<table border="0"><tr><td><iframe src="http://wos.lv/d.php?11603f" name="wos_b" width="88" height="53" marginwidth="0" marginheight="0" frameborder="0" scrolling="no"></iframe>
</td><td><a href="http://l2.hopzone.net/vote.php?site=79484" target="_blank"><img width="88" height="30" border="0" alt="Vote for HopZone.Net" src="http://images.hopzone.net/lineage2/votebanners/lineage2-88x30-2.gif" /></a><br/>
<a href="http://la2.mmotop.ru/vote/20088/" target="_blank"><img src="http://la2.mmotop.ru/images/88x31w_la2.png" title="Рейтинг серверов Lineage 2" alt="Рейтинг серверов Lineage 2" border="0" /></a>
</td><td><a href="http://www.topgames.lv/?mode=in&amp;id=1044" target="_blank">
<img src="http://www.topgames.lv/counter/?id=1044" alt="" border="0"/>
</a><br/>
<a href="http://www.topgames.lv/?mode=in&id=1157" target="_blank">
<img src="http://www.topgames.lv/counter/?id=1157" alt="" border="0" />
</a>

</td></tr>
</table>
</div>
<?php
$skinurl = 'skins/l2i';
if($foot){
?>
</td>
<td style="background-image: url(<?php echo $skinurl;?>/img/t_h_r_b.gif); background-repeat: repeat-y;">&nbsp;</td></tr>
<tr>
<td><img width="40" height="28" alt="" src="<?php echo $skinurl;?>/img/t_b_lc.gif" /></td>
<td style="background-image: url(<?php echo $skinurl;?>/img/t_b_c.gif);" colspan="5">&nbsp;</td>
<td><img width="40" height="28" alt="" src="<?php echo $skinurl;?>/img/t_b_rc.gif" /></td>
</tr></tbody></table></td>
<td width="15%" align="center" valign="top">
<?php
//пароль
includeBlock('stats', $Lang['stats']);
includeBlock('top10', $Lang['top10']);
?>
</td></tr></table></td></tr><?php }else{ ?><table align="center"><?php } 
$timeparts = explode(" ",microtime());
$endtime = $timeparts[1].substr($timeparts[0],1);
?>
<tr align="center" valign="bottom">
<td align="center" valign="middle"><b>Lineage II</b> is a trademark of NCsoft Corporation. Copyright © <b>NCsoft Corporation</b>. All rights reserved.<br /><?php echo $Config['CopyRight']; ?><br /><?php echo sprintf($Lang['page_generated'], bcsub($endtime,$starttime,6), $mysql->totalsqltime, $mysql->querycount);?>
</td>
</tr>
</table><br />
<?php
if ($Config['sql_debug'])
    $mysql->debug();
if ($Config['user_debug'])
    $user->debug();
if ($Config['tpl_debug'])
    $tpl->debug();
?>
<br />
</body></html>