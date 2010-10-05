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
    
    function __destruct()
    {

    }
    function __wakeup()
    {

    }
    function needUpdate($page, $params, $seconds)
    {
        global $mysql, $webdb;
        if($this->use_cache)
        {
            $time = time()-$seconds;
            $qry=$mysql->query("SELECT * FROM `{webdb}`.`cache` WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params));
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
                $mysql->query("INSERT INTO `{webdb}`.`cache` (`page`, `params`) VALUES ('{page}', '{params}');", array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params));
                return true;
            }
        }
        else
            return true;
    }
    
    function updateCache($page, $params, $content)
    {
        global $mysql, $webdb;
        //$filename=md5($page.$params);
        $mysql->query("UPDATE `{webdb}`.`cache` SET `time`='{time}', `recache`='0' WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params, 'time'=>time()));
        if(file_exists($this->folder.'/'.$this->getCacheID($page, $params).'.html'))
            unlink($this->folder.'/'.$this->getCacheID($page, $params).'.html');
        file_put_contents($this->folder.'/'.$this->getCacheID($page, $params).'.html', $content);
        $this->cache_updated=true;
    }
    
    function getCache($page, $params)
    {
        $this->cache_updated=false;
        return file_get_contents($this->folder.'/'.$this->getCacheID($page, $params).'.html');
    }
    
    function getCacheID($page, $params)
    {
        global $mysql, $webdb;
        return $mysql->result($qry=$mysql->query("SELECT `id` FROM `{webdb}`.`cache` WHERE `page`='{page}' AND `params`='{params}';", array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params)));
        
    }
}
?>