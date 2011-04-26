<?php
define('INWEB', true);
require_once ("include/config.php");
//пароль

head("Home");
$par['lang']=getLang();
$par['mod']=$user->mod()==true?'true':'false';
$params = implode(';', $par);

if($cache->needUpdate('index', $params))
{
    includeLang('index');
    $parse = $Lang;
    $gsquery = $sql->query($q[3], array("db" => getConfig('settings', 'webdb', 'l2web')));
    $parse['gsrows'] = "";
    while ($gsrow = $sql->fetch_array($gsquery))
    {
	   $parse['gsrows'] .= $tpl->parsetemplate('index_gsrow', $gsrow, 1);
    }
    $newsq=$sql->query($q[5],  array("db" => getConfig('settings', 'webdb', 'l2web'), "limit" => getConfig('news', 'news_in_index', '10')));
    $parse['news'] = '';
    while($news=$sql->fetch_array($newsq))
    {
        $nparse=$news;
        $nparse['desc']=format_body($nparse['desc']);
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
        if(!file_exists('news/'.$md5[0].'.'.$md5[1]))
        {
            $nparse['image']='image.png';
            $nparse['thumb']='image_thumb.png';
        }
        else
        {
            $nparse['thumb']=$md5[0].'_thumb.'.$md5[1];
        }
        $nparse['read_more']='<a href="news.php?id='. $news['news_id'].'">'.$Lang['read_more'].'</a>';
        $parse['news'].=$tpl->parsetemplate('news_row', $nparse, 1);
    }
    if(!$sql->num_rows())
    {
        $parse['news']='Currently there isn\'t any news!';
        if($user->mod())
            $parse['news'].='<br /><a href="news.php?action=add"><img src="img/add.png" alt="'.$Lang['add'].'" title="'.$Lang['add'].'" border="0" /></a>';
    }
    $content=$tpl->parsetemplate('index2', $parse,1);
    $cache->updateCache('index', $content, $params);
    
    echo $content;
}
else
{
    echo $cache->getCache('index', $params);
}
foot();
?>