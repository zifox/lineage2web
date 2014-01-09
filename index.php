<?php
define('INWEB', true);
require_once ("include/config.php");

head("Home");
$par['lang']=getLangName();
$par['mod']=$user->mod()==true?'true':'false';
$params = implode(';', $par);

if($cache->needUpdate('index', $params))
{
    includeLang('index');
    $parse = getLang('main');
    $gsquery = $sql->query($q[2], array("webdb" => $webdb));
    $parse['gsrows'] = "";
    while ($gsrow = $sql->fetchArray($gsquery))
    {
	   $parse['gsrows'] .= $tpl->parseTemplate('index_gsrow', $gsrow, 1);
    }
    $newsq=$sql->query($q[5],  array("webdb" => $webdb, "limit" => getConfig('news', 'news_in_index', '10')));
    $parse['news'] = '';
    while($news=$sql->fetchArray($newsq))
    {
        $nparse=$news;
        $nparse['desc']=format_body($nparse['desc']);
        if($news['edited_by']!='')
        {
            $nparse['edited']=sprintf(getLang('main','last_edit_by'),$news['edited'], $news['edited_by']);
        }
        if($user->mod())
        {
            $nparse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="'.getLang('main','add').'" title="'.getLang('main','add').'" border="0" /></a>';
            $nparse['edit'] = '<a href="news.php?action=edit&amp;id='.$news['news_id'].'"><img src="img/edit.png" alt="'.getLang('main','edit').'" title="'.getLang('main','edit').'" border="0" /></a>';
            $nparse['delete'] = '<a href="news.php?action=delete&amp;id='.$news['news_id'].'"><img src="img/delete.png" alt="'.getLang('main','delete').'" title="'.getLang('main','delete').'" border="0" /></a>';
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
        $nparse['read_more']='<a href="news.php?id='. $news['news_id'].'">'.getLang('main','read_more').'</a>';
        $parse['news'].=$tpl->parseTemplate('news_row', $nparse, true);
    }
    if(!$sql->numRows())
    {
        $parse['news']=getLang('main','no_news');
        if($user->mod())
            $parse['news'].='<br /><a href="news.php?action=add"><img src="img/add.png" alt="'.getLang('main','add').'" title="'.getLang('main','add').'" border="0" /></a>';
    }
    $content=$tpl->parseTemplate('index2', $parse,true);
    $cache->updateCache('index', $content, $params);
    
    echo $content;
}
else
{
    echo $cache->getCache('index', $params);
}
foot();
?>