<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    exit();
}

class Cache{
    private $folder = "cache";
    private $cache_id;
    var $use_cache=NULL;
    
    function __construct($use_cache){
        $this->use_cache=$use_cache;
    }

    function needUpdate($page, $params=NULL)
    {
        global $sql,$q;
        if($this->use_cache)
        {
            $seconds=getConfig('cache', $page, getConfig('cache', 'default', '900'));
            $time = time()-$seconds;
            $qry=$sql->query(11, array('webdb'=> getConfig('settings', 'webdb', 'l2web'), 'page'=> $page, 'params'=>$params));
            if($sql->num_rows())
            {
                $cch=$sql->fetch_array($qry);
                $this->cache_id=$cch['id'];
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
                $sql->query(12, array('webdb'=> getConfig('settings', 'webdb', 'l2web'), 'page'=> $page, 'params'=>$params));
                $this->cache_id=$sql->getId();
                return true;
            }
        }
        else
            return true;
    }
    
    function updateCache($page, $content, $params=NULL)
    {
        global $sql;
        if(!$this->use_cache) return;
        $id=$this->cache_id;
        $sql->query(13, array('webdb'=> getConfig('settings', 'webdb', 'l2web'), 'time'=>time(), 'id'=>$id));
        if(file_exists($this->folder.'/'.$id.'.html'))
            unlink($this->folder.'/'.$id.'.html');
        file_put_contents($this->folder.'/'.$id.'.html', $content);
        $this->cache_updated=true;
    }
    
    function getCache($page, $params=NULL)
    {
        return file_get_contents($this->folder.'/'.$this->cache_id.'.html');
    }
}
?>