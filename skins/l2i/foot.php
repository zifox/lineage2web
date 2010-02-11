<hr />
<div align="center">
<table border="0"><tr><td><iframe src="http://wos.lv/d.php?11603f" name="wos_b" width="88" height="53" marginwidth="0" marginheight="0" frameborder="0" scrolling="no"></iframe>
</td><td><a href="http://games.top.org/lineage-2/" title="Lineage 2 Private Servers (Downloads) - TOP.ORG"><img style="border:none;" src="http://img1.top.org/toporg_12309.gif" alt="Lineage 2 Private Servers (Downloads) - TOP.ORG" /></a>
<br /><a href="http://la2.mmotop.ru/vote/20088/" target="_blank"><img src="http://la2.mmotop.ru/images/88x31w_la2.png" title="Рейтинг серверов Lineage 2" alt="Рейтинг серверов Lineage 2" border="0" /></a>
</td></tr></table>
</div>
<?php
if($foot){
?>
</td>
<td style="background-image: url(skins/<?php echo $skin;?>/img/t_h_r_b.gif); background-repeat: repeat-y;">&nbsp;</td></tr>
<tr>
<td><img width="40" height="28" alt="" src="skins/<?php echo $skin;?>/img/t_b_lc.gif" /></td>
<td style="background-image: url(skins/<?php echo $skin;?>/img/t_b_c.gif);" colspan="5">&nbsp;</td>
<td><img width="40" height="28" alt="" src="skins/<?php echo $skin;?>/img/t_b_rc.gif" /></td>
</tr></tbody></table></td>
<td width="15%" align="center" valign="top">
<?php
//пароль
includeBlock('stats', $Lang['stats'], true);
includeBlock('top10', $Lang['top10'], true);
?>
</td></tr></table></td></tr><?php }else{ ?><table align="center"><?php } 
$timeparts = explode(" ",microtime());
$endtime = $timeparts[1].substr($timeparts[0],1);
?>
<tr align="center" valign="bottom">
<td align="center" valign="middle"><table border="0" align="center"><tr align="right"><td align="center"><b>Lineage II</b> is a trademark of NCsoft Corporation. Copyright © <b>NCsoft Corporation</b>. All rights reserved.<br /><?php echo $Config['CopyRight']; ?><br /><?php echo sprintf($Lang['page_generated'], bcsub($endtime,$starttime,6));?></td><td width="10%" align="right">
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" />
</a><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="<?php echo $Lang['ValidCSS'];?>!" /></a></td></tr></table>
</td>
</tr>
</table></body></html>