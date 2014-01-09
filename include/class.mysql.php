<?php
if(!defined('INCONFIG'))
{
	header("Location: ../index.php");
	die();
}

class MySQL
{
	private $DBinfo;
	private $link;
	private $query = array();
	public $queryCount = 0;
	public $totalSqlTime = 0;
	public $rowCount = 0;
	public $lastId=0;
	private $pConnect = false;
	function __construct(&$DBinfo, $persistant = true)
	{
		$this->DBinfo = $DBinfo;
		unset($DBinfo);
		$this->connect($persistant);
	}

	function __destruct()
	{
		if(!$this->pConnect && $this->link)
			$this->close();
	}
	function __wakeup()
	{
		$this->connect();
	}
	function return_result($res)
	{
		return $this->query[$res]['result'];
	}
	private function connect($persistant = true)
	{
		$this->pConnect = $persistant;
		if($persistant)
			$this->link = mysql_pconnect($this->DBinfo['host'], $this->DBinfo['user'], $this->DBinfo['password']);
		else
			$this->link = mysql_connect($this->DBinfo['host'], $this->DBinfo['user'], $this->DBinfo['password']);
		if(!$this->link)
		{
			$this->err(sprintf(getLang('system', 'could_not_connect'), $this->DBinfo['host']));
			exit();
		}

		if(!mysql_select_db($this->DBinfo['database'], $this->link))
		{
			$this->err(sprintf(getLang('system', 'could_not_open'),$this->DBinfo['database']));
			exit();
		}
		mysql_set_charset('utf8',$this->link);
		unset($this->DBinfo);
	}

	private function close()
	{
		mysql_close($this->link);
	}
	function escape($string)
	{
		if(get_magic_quotes_runtime())
			$string = stripslashes($string);
		return mysql_real_escape_string($string, $this->link);
	}

	function query($sql, $array = array())
	{
		global $q;
		$querytime = explode(" ", microtime());
		$querystart = $querytime[1] . substr($querytime[0], 1);
		if(is_numeric($sql))
			$sql = $q[$sql];
		$sql = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $sql);

		$result = mysql_query($sql, $this->link) or $this->err(sprintf(getLang('system','mysql_error'),$sql));

		$querytime = explode(" ", microtime());
		$queryend = $querytime[1] . substr($querytime[0], 1);
		$time = bcsub($queryend, $querystart, 6);
		$this->totalSqlTime += $time;
		$this->rowCount = (substr($sql, 0, 6) == "SELECT") ? @mysql_num_rows($result) : @mysql_affected_rows($this->link);
		array_push($this->query, array(
			"query" => $sql,
			"result" => $result,
			"time" => $time,
			"rows" => $this->rowCount));
        if(substr($sql,0,6)=="INSERT")
        {
            $this->lastId=$this->getId();
        }
        else
        {
            $this->lastId=0;
        }
		$this->queryCount++;
		end($this->query);
		return key($this->query);
	}

	function result($res = null, $row = 0, $field = 0)
	{
		if($res === null)
		{
			end($this->query);
			$res = key($this->query);
		}
		return mysql_result($this->query[$res]['result'], $row, $field);
	}

	function numRows()
	{
		if ($res === null) {
			end($this->query);
			$res = key($this->query);
		}
		return $this->query[$res]['rows'];
	}

	function fetchArray($res = null)
	{
		if($res === null)
		{
			end($this->query);
			$res = key($this->query);
		}
		return mysql_fetch_assoc($this->query[$res]['result']);
	}

	function fetchRow($res = null)
	{
		if($res === null)
		{
			end($this->query);
			$res = key($this->query);
		}
		return mysql_fetch_row($this->query[$res]['result']);
	}
	
	function getId()
	{
		if($this->lastId==0)
            return mysql_insert_id($this->link);
        else
            return $this->lastId;
	}
	
	function free($res = null)
	{
		if($res === null)
		{
			end($this->query);
			$res = key($this->query);
		}
		return mysql_free_result($this->query[$res]['result']);
	}
    function reset_query($res=null,$pos=0)
    {
        if($res===null)
        {
            end($this->query);
            $res = key($this->query);
        }
        return mysql_data_seek($this->query[$res]['result'],$pos);
    }
	private function err($msg = '')
	{
		global $tpl;
		if($this->link)
		{
			$error = mysql_error($this->link);
			$errno = mysql_errno($this->link);
		}
		else
		{
			$error = mysql_error();
			$errno = mysql_errno();
		}
		$parse['db_error']=getLang('system','db_error');
		$parse['lMessage']=getLang('system','message');
		$parse['mysql_error']=getLang('system','mysql_error2');
		$parse['lDate']=getLang('system', 'date');
		$parse['script']=getLang('system', 'script');
		$parse['date']=date("l, F j, Y \a\\t g:i:s A");
		$parse['message']=$msg;
		$parse['request_uri']=@$_SERVER['REQUEST_URI'];
		$parse['error']=$error;
		$parse['lReferer']=getLang('system','referer');
		$parse['referer']=@$_SERVER['HTTP_REFERER'];
		$tpl->parseTemplate('mysql_error', $parse);
		die();
	}

	function debug($parse)
	{
		global $tpl;
		$parse['lLink']=getLang('link');
		$parse['link']=$this->link;
		$parse['query_rows']='';
		foreach ($this->query as $key => $value)
		{
			$rParse=$value;
			if($value['time'] <= 0.01)
			{
				$rParse['color']='green';
			}
			elseif ($value["time"] > 0.01 && $value["time"] < 0.1)
			{
				$rParse['color']='orange';
			}
			else
			{
				$rParse['color']='red';
			}
			$rParse['title']=getLang('query_'.$rParse['color']);
			$rParse['key']=$key+1;
			$parse['query_rows'].=$tpl->parseTemplate('mysql_debug_row',$rParse,true);
		}
		return $tpl->parseTemplate('mysql_debug',$parse,true);
	}
}
?>