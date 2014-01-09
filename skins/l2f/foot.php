<?php
$parse=getLang();
$parse['skinurl'] = 'skins/'.selectSkin();
$parse['foot'] = '';
$parse['blocks_right'] = includeBlock('stats', getLang('stats'), 1, true);
$parse['blocks_right'] .= includeBlock('top10', getLang('top10'), 1, true);
//$parse['blocks_right'].=includeBlock('vote', getLang('vote'),1,true);
$parse['foot'] = $tpl->parseTemplate('skin/foot_foot' . ((!$foot) ? '_e' : ''), $parse, true);

//$timeParts = explode(" ", microtime());
//$endTime = $timeParts[1] . substr($timeParts[0], 1);
$parse['copyrights'] = (getLang('l2_trademark') . getConfig('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> (c) LineageII PvP Land') . '<br />' . sprintf(getLang('page_generated'), bcsub($endTime, $startTime, 6), $sql->totalSqlTime, $sql->queryCount));
$parse['debugs'] = '';
//if(getConfig('debug', 'sql', '0'))
//	$parse['debugs'] .= $sql->debug();
//if(getConfig('debug', 'user', '0'))
//	$parse['debugs'] .= $user->debug();
	
	
if(getConfig('debug', 'sql', '0') /*&& $user->logged() /*&& $user->hasAccess('admin')*/)
{
    $tp = explode(" ", microtime());
    $endTime = $tp[1] . substr($tp[0], 1);
    $totalTime = round(bcsub($endTime,$startTime,6),4);
    $avgqt=round($sql->totalSqlTime/$sql->queryCount,4);
    $tsqlt=round($sql->totalSqltime,4);
    $qc=round($sql->queryCount,4);
    $parse2=$parse;
    $parse2['timeString']=sprintf(getLang('page_generated'),$totalTime, $tsqlt, $qc, $avgqt);  
	//$parse2['debugDisplay']=!$user->getVar('debug_menu')? 'block':'none'; 
	$parse2['debugDisplay']='block';
    
	$parse['debugs'].=$sql->debug($parse2);

}
if(getConfig('debug','user',0))
{
    //$parse['debugs'] .= $user->debug();
}


$tpl->parseTemplate('skin/foot', $parse, false);
?>