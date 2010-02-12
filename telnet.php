<?php
define('INWEB', True);
require_once("include/config.php");


if (logedin() && is_admin()){
head('Telnet');
$execs = $_POST['execute'];
$mycommand = $_POST['todo'];
$time=$_POST['time'];
$password=mysql_real_escape_string($_POST['telnet_password']);
$serverid=mysql_real_escape_string($_POST['server']);

if ($execs == "yes") {
    $targetserver=mysql_query('SELECT * FROM `'.$DB['webdb'].'`.`telnet` WHERE `Server`=\''.$serverid.'\' ');
    if(mysql_num_rows($targetserver)){
        $server_data=mysql_fetch_assoc($targetserver);
        if($password!=$server_data['Password']){
            echo $password;
            echo '<br />';
            echo $server_data['Password'];
            die();}
    $fp=@fsockopen($server_data['IP'],$server_data['Port'],$errno,$errstr);
    $command="$mycommand*$time\r";
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
}else{
    ?>
    <form action="telnet.php" method="post">
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
    <?php
}
foot();

}else{Header('Location:index.php');}
?>