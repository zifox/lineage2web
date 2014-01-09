<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    exit();
}

class Cache{
    private $folder = "cache";
    private $cacheId;
    var $useCache=NULL;
    
    function __construct($useCache){
        $this->useCache=$useCache;
    }

    function needUpdate($page, $params=NULL)
    {
        global $sql,$q,$webdb;
        if($this->useCache)
        {
            $seconds=getConfig('cache', $page, getConfig('cache', 'default', '900'));
            $time = time()-$seconds;
            $qry=$sql->query(11, array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params));
            if($sql->numRows())
            {
                $cch=$sql->fetchArray($qry);
                $this->cacheId=$cch['id'];
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
                $sql->query(12, array('webdb'=> $webdb, 'page'=> $page, 'params'=>$params));
                $this->cacheId=$sql->getId();
                return true;
            }
        }
        else
            return true;
    }
    
    function updateCache($page, $content, $params=NULL)
    {
        global $sql,$webdb;
        if(!$this->useCache) return;
        $id=$this->cacheId;
        $sql->query(13, array('webdb'=> $webdb, 'time'=>time(), 'id'=>$id));
        if(file_exists($this->folder.'/'.$id.'.html'))
            unlink($this->folder.'/'.$id.'.html');
        file_put_contents($this->folder.'/'.$id.'.html', $content);
        $this->cacheUpdated=true;
    }
    
    function getCache($page, $params=NULL)
    {
        return file_get_contents($this->folder.'/'.$this->cacheId.'.html');
    }
}
?>