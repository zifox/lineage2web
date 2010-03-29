<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}
class MySQL{
    private $DBInfo;
    private $link = NULL;
    private $query = array();
    public $querycount = 0;
    public $totalsqltime = 0;

    function __construct($DBInfo){
        $this->DBInfo = $DBInfo;
        unset($DBInfo);
        $this->connect();
    }
    
    function __destruct()
    {
        $this->close();
        //msg('MySQL', 'MySQL Destruction Success');
    }
    function __wakeup()
    {
        $this->connect();
    }
    public function return_result($res)
    {
        return $this->query[$res]['result'];
    }
    private function connect() {
        $this->link=mysql_pconnect($this->DBInfo['host'],$this->DBInfo['user'],$this->DBInfo['password']);
        if (!$this->link)
            $this->err("Could not connect to server: <b>{$this->DBInfo['host']}</b>.");

        if(!mysql_select_db($this->DBInfo['database'], $this->link))
            $this->err("Could not open database: <b>{$this->DBInfo['database']}</b>.");
        unset($this->DBInfo);
    }


    public function close() {
        if(!@mysql_close($this->link))
            $this->err("Could not close MySQL.");
    }

    public function escape($string) {
        if(get_magic_quotes_runtime()) $string = stripslashes($string);
        return mysql_real_escape_string($string, $this->link);
    }

    public function query($sql) {
        $sql = trim($sql);

        $querytime = explode(" ", microtime());
        $querystart = $querytime[1] . substr($querytime[0], 1);

        $result = mysql_query($sql, $this->link) OR $this->err("<b>MySQL Query error: </b> $sql");

        $querytime = explode(" ",microtime());
        $queryend = $querytime[1].substr($querytime[0],1);
        $time = bcsub($queryend,$querystart,6);
        $this->totalsqltime+=$time;
        array_push($this->query, array(
            "query" => $sql,
            "result" => $result,
            "time" => $time
        ));

        $this->querycount++;
        end($this->query);
        return key($this->query);
    }

    public function result($res = null, $row=0, $field=0 ){
        if ($res === null) {
            end($this->query);
            $res = key($this->query);
        }
        return mysql_result($this->query[$res]['result'], $row, $field);
    }

    public function num_rows($res = null) {
        if ($res === null) {
            end($this->query);
            $res = key($this->query);
        }
        return mysql_num_rows($this->query[$res]['result']);
    }

    public function num_rows2($res = null) {
        return $this->num_rows($res);
    }

	public function fetch_array($res = null) {
		if ($res === null) {
			end($this->query);
			$res = key($this->query);
		}
		return mysql_fetch_assoc($this->query[$res]['result']);
	}
    
    public function free($res = null)
    {
  		if ($res === null) {
			end($this->query);
			$res = key($this->query);
		}
		return mysql_free_result($this->query[$res]['result']);
    }
    
    private function err($msg='') {
        if($this->link>0){
            $error=mysql_error($this->link);
            $errno=mysql_errno($this->link);
        }else{
            $error=mysql_error();
            $errno=mysql_errno();
        }
        ?>
		<table align="center" border="0" cellspacing="0" style="color : #990000; padding : 7px; margin-top : 5px; margin-bottom : 10px; border : 1px dashed #990000;">
		<tr><th colspan="2">Database Error</th></tr>
		<tr><td align="right" valign="top">Message:</td><td><?php echo $msg; ?></td></tr>
		<?php if(strlen($error)>0) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.$error.'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<tr><td align="right">Script:</td><td><a href="<?php echo @$_SERVER['REQUEST_URI']; ?>"><?php echo @$_SERVER['REQUEST_URI']; ?></a></td></tr>
		<?php if(strlen(@$_SERVER['HTTP_REFERER'])>0) echo '<tr><td align="right">Referer:</td><td><a href="'.@$_SERVER['HTTP_REFERER'].'">'.@$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
		</table>
        <?php
        //$this->close();
        //die();
    }

    public function debug() {
        ?>
        <table border="0">
        <?php
        foreach ($this->query as $key => $value) { 
            if ($value['time'] <= 0.01) {
                $report = '<font color="green" title="Query doesn\'t need optimization. Execution time is acceptable">';
            } elseif ($value["time"] > 0.01 && $value["time"] < 0.1) {
                $report = '<font color="orange" title="Perhaps this Query can execute faster. Execution time is normal but you should check it anyway">';
            } else {
                $report = '<font color="red" title="Query needs optimization. Execution time is unacceptable">';
            }
            ?>
            <tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td width="20%">[<?php echo $key+1;?>]&nbsp;&nbsp;&nbsp;&nbsp;=&gt;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $report.$value['time'].'</font>';?></b></td><td>[<?php echo $value['query'];?>]<?php echo $value['result'];?></td></tr>
<?php   } ?>
        </table>
<?php
    }
}
?>