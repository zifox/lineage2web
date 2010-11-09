<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}

class Cache{
    private $folder = "cache";
    var $use_cache=NULL;
    function __construct($use_cache){
        $this->use_cache=$use_cache;
    }

    function needUpdate($page, $params=NULL)
    {
        global $CONFIG, $mysql;
        if($this->use_cache)
        {
            $page=$this->validatePage($page);
            $seconds=$this->getCacheUpdateTime($page);
            $time = time()-$seconds;
            $qry=$mysql->query("SELECT * FROM `{webdb}`.`cache` WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $CONFIG['settings']['webdb'], 'page'=> $page, 'params'=>$params));
            if($mysql->num_rows($qry))
            {
                $cch=$mysql->fetch_array($qry);
                if($cch['time']>$time && $cch['recache']=='0')
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                $mysql->query("INSERT INTO `{webdb}`.`cache` (`page`, `params`) VALUES ('{page}', '{params}');", array('webdb'=> $CONFIG['settings']['webdb'], 'page'=> $page, 'params'=>$params));
                return true;
            }
        }
        else
            return true;
    }
    
    function updateCache($page, $content, $params=NULL)
    {
        global $CONFIG, $mysql;
        $page=$this->validatePage($page);
        $mysql->query("UPDATE `{webdb}`.`cache` SET `time`='{time}', `recache`='0' WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $CONFIG['settings']['webdb'], 'page'=> $page, 'params'=>$params, 'time'=>time()));
        if(file_exists($this->folder.'/'.$this->getCacheID($page, $params).'.html'))
            unlink($this->folder.'/'.$this->getCacheID($page, $params).'.html');
        file_put_contents($this->folder.'/'.$this->getCacheID($page, $params).'.html', $content);
        $this->cache_updated=true;
    }
    
    function getCache($page, $params=NULL)
    {
        $page=$this->validatePage($page);
        return file_get_contents($this->folder.'/'.$this->getCacheID($page, $params).'.html');
    }
    
    function getCacheID($page, $params)
    {
        global $CONFIG, $mysql;
        return $mysql->result($mysql->query("SELECT `id` FROM `{webdb}`.`cache` WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $CONFIG['settings']['webdb'], 'page'=> $page, 'params'=>$params)),0 ,0);
        
    }
    function validatePage($page)
    {
        $page=explode("\\", $page);
        $length=count($page);
        if($page[$length-2]!='')
            $page=$page[$length-2]."/".$page[$length-1];
        else
            $page=$page[$length-1];
        $page=explode(".",$page);
        $page=$page[0];
        return $page;
    }
    function getCacheUpdateTime($page)
    {
        global $CONFIG, $mysql;
        if(isset($CONFIG['cache'][$page]))
            return $CONFIG['cache'][$page];
        else
        {
            $mysql->query("INSERT INTO `{$CONFIG['settings']['webdb']}`.`config` VALUES('$page', 'cache','{$CONFIG['cache']['default']}');");
            return $CONFIG['cache']['default'];
        }
            
    }
}
?>