<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Admin");
includeLang('admin/settings');

if (logedin() && is_admin()){
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
            $name=mysql_real_escape_string($_POST['server']);
            $ip=mysql_real_escape_string($_POST['ip']);
            $port=mysql_real_escape_string($_POST['port']);
            $password=mysql_real_escape_string($_POST['password']);
            mysql_query("INSERT INTO `{$DB['webdb']}`.`telnet` (`Server`, `IP`, `Port`, `Password`) VALUES ('$name', '$ip', '$port', '$password');");
            echo $Lang['saved'];
            }else{
                echo 'Nothing to insert!!!';
            }
            
        }else if($action=='delete')
        {
            if(isset($_GET['server']) && is_numeric($_GET['server'])){
                $name=0+$_GET['server'];
                mysql_query("DELETE FROM `{$DB['webdb']}`.`telnet` WHERE `ID`='$name';");
            echo $Lang['deleted'];
            }
        }else if($action='execute')
        {
            $mycommand = $_POST['todo'];
            $time=$_POST['time'];
            $password=mysql_real_escape_string($_POST['telnet_password']);
            $serverid=mysql_real_escape_string($_POST['server']);

                $targetserver=mysql_query('SELECT * FROM `'.$DB['webdb'].'`.`telnet` WHERE `Server`=\''.$serverid.'\' ');
                if(mysql_num_rows($targetserver)){
                    $server_data=mysql_fetch_assoc($targetserver);
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

$sql=mysql_query("SELECT * FROM `".$DB['webdb']."`.`config`");
while ( $row = mysql_fetch_assoc($sql) ) {
    mysql_query("UPDATE `".$DB['webdb']."`.`config` SET `config_value` = '". mysql_real_escape_string($_POST[$row['config_name']])."' WHERE `config_name` = '{$row['config_name']}'");
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
$sql=mysql_query("SELECT * FROM `".$DB['webdb']."`.`config`");

while ( $row = mysql_fetch_assoc($sql) ) {
    ?>
    <tr>
	<td><?php echo $Lang[$row['config_name']];?>:</td>
	<td><input name="<?php echo $row['config_name'];?>" size="50" value="<?php echo htmlspecialchars(stripslashes($row['config_value']));?>" type="text" /></td>
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
    $servers=mysql_query('SELECT `Server` FROM `'.$DB['webdb'].'`.`telnet`');
    while($slist=mysql_fetch_assoc($servers))
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
    $servers=mysql_query('SELECT * FROM `'.$DB['webdb'].'`.`telnet`');
    while($slist=mysql_fetch_assoc($servers))
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