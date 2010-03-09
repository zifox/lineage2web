<?php
//пароль
class MySQL {
    var $DBInfo;
    var $link = 0;
    var $query = array();
    var $querycount = 0;

    function MySQL($DBInfo){
	   $this->DBInfo = $DBInfo;
    }

    function connect() {
	   $this->link=@mysql_connect($this->DBInfo['host'],$this->DBInfo['user'],$this->DBInfo['pass']);

        if (!$this->link)
            $this->err("Could not connect to server: <b>{$this->DBInfo['host']}</b>.");

        if(!@mysql_select_db($this->DBInfo['database'], $this->link))
            $this->err("Could not open database: <b>{$this->DBInfo['database']}</b>.");
            
        unset($this->DBInfo);
    }

    function close() {
        if(!@mysql_close($this->link))
            $this->err("Could not close MySQL.");
    }

    function escape($string) {
        if(get_magic_quotes_runtime()) $string = stripslashes($string);
        return @mysql_real_escape_string($string, $this->link);
    }

    function query($sql) {
        $sql = trim($sql);
        
        $querytime = explode(" ", microtime());
        $querystart = $querytime[1] . substr($querytime[0], 1);
        
        $result = @mysql_query($sql, $this->link) OR $this->err("<b>MySQL Query error:</b> $sql");
        
        $querytime = explode(" ",microtime());
        $queryend = $querytime[1].substr($querytime[0],1);
        
        array_push($this->query, array(
            "query" => $sql,
            "result" => $result,
            "rows" => ((strncasecmp('select', $sql, 6)===0) ? @mysql_num_rows($result) : mysql_affected_rows($this->link)),
            "time" => bcsub($queryend,$querystart,6)
        ));
        
        $this->querycount++;
        end($this->query);
        return key($this->query);
    }
    
    function result($res = null, $row=0, $field=0 ){
        if ($res === null) {
            end($this->query);
            $res = key($this->query);
            //print_r($res);
        }
        return @mysql_result($this->query[$res]['result'], $row, $field);
    }
    
    function num_rows($res = null) {
        if ($res === null) {
            end($this->query);
            $res = key($this->query);
        }
        return @mysql_num_rows($this->query[$res]['result']);
    }
    
    function num_rows2($res = null) {
        if ($res === null) {
            end($this->query);
            $res = key($this->query);
            //return $res;
        }
        return $this->query[$res]['rows'];
    }
    
	function fetch_array($res = null) {
		if ($res === null) {
			end($this->query);
			$res = key($this->query);
		}
		return @mysql_fetch_assoc($this->query[$res]['result']);
	}

    function err($msg='') {
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
        die();
    }

    function mysql_info() {
        return $this->querycount;
    }
    
    function debug()
    {
        if(DEBUG_MODE)
        {
            //print_r($this->query);
            ?>
            <table border="0">
            <?php
            foreach ($this->query as $key => $value) {
                ?>
                <tr onmouseover="this.bgColor = '#505050';" onmouseout="this.bgColor = ''"><td width="20%">[<?php echo $key+1;?>]&nbsp;&nbsp;&nbsp;&nbsp;=&gt;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $value["time"] > 0.01 ? "<font color=\"red\" title=\"Query needs optimization. Execution time is unacceptable\">".$value["time"]."</font>" : "<font color=\"green\" title=\"Query doesn't need optimization. Execution time is acceptable\">".$value["time"]."</font>";?></b></td><td>[<?php echo $value['query'];?>]</td></tr>
                <?php
            }
            ?>
            </table>
            <?php
        }
    }
}
?>