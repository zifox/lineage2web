<hr />

<?php
$skinurl = 'skins/'.getConfig('settings', 'DTHEME', 'l2f');
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
<td align="center" valign="middle"><b>Lineage II</b> is a trademark of NCsoft Corporation. Copyright © <b>NCsoft Corporation</b>. All rights reserved.<br /><?php echo getConfig('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> &copy; LineageII PvP Land'); ?><br /><?php echo sprintf($Lang['page_generated'], bcsub($endtime,$starttime,6), $sql->totalsqltime, $sql->querycount);?>
</td>
</tr>
</table><br />
<?php
if (getConfig('debug', 'sql', '0'))
    $sql->debug();
if (getConfig('debug', 'user', '0'))
    $user->debug();
?>
<br />
</body></html>