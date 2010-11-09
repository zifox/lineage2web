<?php
define('INWEB', true);
require_once ("include/config.php");
//пароль
head("Home");
$par['lang']=getLang();
$par['mod']=$user->mod()==true?'true':'false';
$params = implode(';', $par);
if($cache->needUpdate(__FILE__, $params))
{
    includeLang('index');
    $parse = $Lang;
    $gsquery = $mysql->query($q[3], array("db" => $webdb));
    $parse['gsrows'] = "";
    while ($gsrow = $mysql->fetch_array($gsquery))
    {
	   $parse['gsrows'] .= $tpl->parsetemplate('index_gsrow', $gsrow, 1);
    }
    $newsq=$mysql->query($q[5],  array("db" => $webdb, "limit" => $CONFIG['news']['news_in_index']));
    $parse['news'] = '';
    while($news=$mysql->fetch_array($newsq))
    {
        $nparse=$news;
        //$nparse['desc']=trim($nparse['desc']);
        if($news['edited_by']!='')
        {
            $nparse['edited']='Last edited <strong>'.$news['edited'].'</strong> by <strong>'.$news['edited_by'].'</strong>';
        }
        if($user->mod())
        {
            $nparse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="'.$Lang['add'].'" title="'.$Lang['add'].'" border="0" /></a>';
            $nparse['edit'] = '<a href="news.php?action=edit&amp;id='.$news['news_id'].'"><img src="img/edit.png" alt="'.$Lang['edit'].'" title="'.$Lang['edit'].'" border="0" /></a>';
            $nparse['delete'] = '<a href="news.php?action=delete&amp;id='.$news['news_id'].'"><img src="img/delete.png" alt="'.$Lang['delete'].'" title="'.$Lang['delete'].'" border="0" /></a>';
        }
        else
        {
            $nparse['add'] = '';
            $nparse['edit'] = '';
            $nparse['delete'] = '';
        }
        $md5=explode(".",$news['image']);
        $nparse['thumb']=$md5[0].'_thumb.'.$md5[1];
        $nparse['read_more']='<a href="news.php?id='. $news['news_id'].'">'.$Lang['read_more'].'</a>';
        $parse['news'].=$tpl->parsetemplate('news_row', $nparse, 1);
    }

    $content=$tpl->parsetemplate('index2', $parse,1);
    $cache->updateCache(__FILE__, $content, $params);
    
    echo $content;
}
else
{
    echo $cache->getCache(__FILE__, $params);
}
foot();
?>