<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Admin");
includeLang('admin/settings');

if ($user->logged()&& $user->admin()){
    ?>
    <h2><?php echo $Lang['admin_settings']; ?></h2>
    <?php
    if($_POST || $_GET){
    $config_config=$_GET['config'];
    $action=$_GET['action'];
    switch($config_config){
        Case 'telnet':
        if($action=='add')
        {
            if(isset($_POST['server']) && isset($_POST['ip']) && isset($_POST['port']) && isset($_POST['password'])){
            $name=$mysql->escape($_POST['server']);
            $ip=$mysql->escape($_POST['ip']);
            $port=$mysql->escape($_POST['port']);
            $password=$mysql->escape($_POST['password']);
            $mysql->query("INSERT INTO `$webdb`.`telnet` (`Server`, `IP`, `Port`, `Password`) VALUES ('$name', '$ip', '$port', '$password');");
            echo $Lang['saved'];
            }else{
                echo 'Nothing to insert!!!';
            }
            
        }else if($action=='delete')
        {
            if(isset($_GET['server']) && is_numeric($_GET['server'])){
                $name=0+$_GET['server'];
                $mysql->query("DELETE FROM `$webdb`.`telnet` WHERE `ID`='$name';");
            echo $Lang['deleted'];
            }
        }else if($action='execute')
        {
            $mycommand = $_POST['todo'];
            $time=$_POST['time'];
            $password=$mysql->escape($_POST['telnet_password']);
            $serverid=$mysql->escape($_POST['server']);

                $targetserver=$mysql->query('SELECT * FROM `'.$webdb.'`.`telnet` WHERE `Server`=\''.$serverid.'\' ');
                if($mysql->num_rows2($targetserver)){
                    $server_data=$mysql->fetch_array($targetserver);
                    $fp=@fsockopen($server_data['IP'],$server_data['Port'],$errno,$errstr);
                    //$command="$mycommand $time\r";
                    $command="$mycommand\r";
                    fputs($fp,$server_data['Password']."\r");
                    fputs($fp,$command);
                    fputs($fp,"quit\r");
                    while(!feof($fp)){
                        $output.=fread($fp,16);
                    }
                    fclose($fp);
                    $clear_r=array("Password Correct!","Password:","Please Insert Your Password!","\n","Password: Password Correct!","Welcome To The L2J Telnet Session.","[L2J]","Bye Bye!");
                    $output = str_replace($clear_r,"", $output);
                    echo 'Server Response = '.$output;
                }
        }else{}
        break;
        Default:

$sql=$mysql->query("SELECT * FROM `".$webdb."`.`config`");
while ( $row = $mysql->fetch_array($sql) ) {
    $mysql->query("UPDATE `".$webdb."`.`config` SET `value` = '". $mysql->escape($_POST[$row['name']])."' WHERE `name` = '{$row['name']}'");
    }
echo $Lang['saved'];
?> <meta http-equiv="refresh" content="1; URL=admin.php" />
<?php 
break;
}
}
 ?>
<ul id="configtabs" class="shadetabs">
<li><a href="#" rel="config_main" class="selected">Main Config</a></li>
<li><a href="#" rel="config_telnet">Telnet</a></li>
</ul>

<div style="border:1px solid gray; width:100%; margin-bottom: 1em; padding: 10px">

<div id="config_main" class="tabcontent">
<form action="admin.php" method="post">
<table>
<?php
$sql=$mysql->query("SELECT * FROM `".$webdb."`.`config`");

while ( $row = $mysql->fetch_array($sql) ) {
    ?>
    <tr>
	<td><?php echo $Lang[$row['name']];?>:</td>
	<td><input name="<?php echo $row['name'];?>" size="50" value="<?php echo htmlspecialchars(stripslashes($row['value']));?>" type="text" /></td>
    </tr>
    <?php
    }
    ?>
    <tr><td></td><td align="left"><input value="<?php echo $Lang['save'];?>" type="submit" /></td></tr>
</table>
</form>
</div>

<div id="config_telnet" class="tabcontent">
<a href="javascript:showhide('add');">Add/Delete</a>
            <form action="admin.php?config=telnet" method="post">
                <table border="1" align="center"><tr><td>
                    <select name="server">
    <?php
    $servers=$mysql->query('SELECT `Server` FROM `'.$webdb.'`.`telnet`');
    while($slist=$mysql->fetch_array($servers))
    {
      ?>
      <option value="<?php echo $slist['Server'];?>"><?php echo $slist['Server'];?></option>
      <?php  
    }
    ?>
    </select>
    <select name="todo">
    <option value="restart">Restart</option>
    <option value="shutdown">ShutDown</option>
    </select>
    <input type="text" name="time" value="5" size="5" /></td></tr>
    <tr><td>Password: <input type="password" name="telnet_password" value="" />
    <input type="hidden" name="execute" value="yes" /></td></tr><tr><td>
    <?php button('Execute'); ?>
    </td></tr></table></form>
    <div id="add" style="display: none;">
    <table><tr><td>
    <div align="left">
    <form action="admin.php?config=telnet&amp;action=add" method="post">
    <table border="1"><tr><td>Name: </td><td><input name="server" type="text" /></td></tr>
    <tr><td>IP: </td><td><input name="ip" type="text" /></td></tr>
    <tr><td>Port: </td><td><input name="port" type="text" /></td></tr>
    <tr><td>Password: </td><td><input name="password" type="text" /></td></tr>
    <tr><td></td><td><?php button('Add'); ?></td></tr>
    </table>
    </form>
    </div></td><td>
    <div align="right">
    <table border="1">
    <thead><tr><th>Server</th><th>IP</th><th>Port</th><th>Password</th><th>Action</th></tr></thead>
    <tbody>
    <?php
    $servers=$mysql->query('SELECT * FROM `'.$webdb.'`.`telnet`');
    while($slist=$mysql->fetch_array($servers))
    {
      ?>
      <tr><td><?php echo $slist['Server'];?></td><td><?php echo $slist['IP'];?></td><td><?php echo $slist['Port'];?></td><td><?php echo $slist['Password'];?></td><td><a href="admin.php?config=telnet&amp;action=delete&amp;server=<?php echo $slist['ID'];?>">Delete</a></td></tr>
      <?php
    }
    ?>
    </tbody>
    </table>
    </div></td></tr>
    </table>
    </div>
</div>

</div>

<script type="text/javascript">

var tab=new ddtabcontent("configtabs")
tab.setpersist(true)
tab.setselectedClassTarget("link") //"link" or "linkparent"
tab.init()

</script>
<?php
} else { echo $Lang['nothing_here'];}
foot();
?>