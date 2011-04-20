<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
loggedInOrReturn(__FILE__);
head("Admin");
includeLang('admin/settings');
if (!$user->admin()) err('Error',$Lang['nothing_here']);
?>
<h2><?php echo $Lang['admin_settings']; ?></h2><br />
<a href="?config=config">Config</a> | <a href="?config=telnet">Telnet</a> | <a href="?config=trade">Offline Trade</a><br /><?php
$c=getVar('config');
$a=getVar('action');
switch($c){
    case 'telnet':
    if($_POST)
    {
        if($a=='add')
        {
            $name=getVar('server');
            $ip=getVar('ip');
            $port=getVar('port');
            $password=getVar('password');
            if($name!='' && $ip!='' && $port!='' && $password!='')
            {
                $sql->query("INSERT INTO `$webdb`.`telnet` (`Server`, `IP`, `Port`, `Password`) VALUES ('$name', '$ip', '$port', '$password');");
                echo $Lang['saved'];
            }else{
                echo 'Nothing to insert!!!';
            }
            
        }else if($a=='delete')
        {
            $server=getVar('server');
            if($server!=''){
                $sql->query("DELETE FROM `$webdb`.`telnet` WHERE `ID`='$server';");
                echo $Lang['deleted'];
            }
        }else if($a=='execute')
        {
            $mycommand = getVar('todo');
            $time=getVar('time');
            $password=getVar('telnet_password');
            $serverid=getVar('server');

                $targetserver=$sql->query('SELECT * FROM `'.$webdb.'`.`telnet` WHERE `Server`=\''.$serverid.'\' ');
                if($sql->num_rows($targetserver)){
                    $server_data=$sql->fetch_array($targetserver);
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
    }
    else
    {?>
        <a href="javascript:showhide('add');">Add/Delete</a>
        <form action="admin.php?config=telnet" method="post">
        <table border="1" align="center"><tr><td>
        <select name="server">
        <?php
        $servers=$sql->query('SELECT `Server` FROM `'.$webdb.'`.`telnet`');
        while($slist=$sql->fetch_array($servers))
        {?>
            <option value="<?php echo $slist['Server'];?>"><?php echo $slist['Server'];?></option>
  <?php } ?>
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
        $servers=$sql->query('SELECT * FROM `'.$webdb.'`.`telnet`');
        while($slist=$sql->fetch_array($servers))
        {?>
            <tr><td><?php echo $slist['Server'];?></td><td><?php echo $slist['IP'];?></td><td><?php echo $slist['Port'];?></td><td><?php echo $slist['Password'];?></td><td><a href="admin.php?config=telnet&amp;action=delete&amp;server=<?php echo $slist['ID'];?>">Delete</a></td></tr>
  <?php }?>
        </tbody>
        </table>
        </div></td></tr>
        </table>
        </div>
        <?php
    }
    break;
    case "trade":
        if($_POST)
        {
            $items=array(
                0=>'4356',
                1=>'4357',
                2=>'4358'
            );
            $db=getDBInfo(getVar('server'));
            $level=getVar('level');
            $gchance=getVar('chance');
            $i=0;
            $qry=$sql->query("SELECT `charId` FROM `{$db['DataBase']}`.`characters` WHERE `level`>'$level' GROUP BY `account_name`");
            while($char=$sql->fetch_array($qry))
            {
                $chance=rand(0,100);
                if($chance>$gchance) continue;
                $i++;
                $time=time();
                $sql->query("TRUNCATE TABLE `{$db['DataBase']}`.`character_offline_trade`;");
                $sql->query("TRUNCATE TABLE `{$db['DataBase']}`.`character_offline_trade_items`");
                $query="INSERT INTO `{$db['DataBase']}`.`character_offline_trade` (`charId`, `time`, `type`) VALUES ('{$char['charId']}', '$time', '3')";
                $sql->query($query);
                $item=$items[rand(0,2)];
                $query="INSERT INTO `{$db['DataBase']}`.`character_offline_trade_items` (`charId`, `item`, `count`, `price`) VALUES ('{$char['charId']}', '$item', '1', '1')";
                $sql->query($query);
            }
            echo $i." Offliners added!";
        }
        else
        {
            ?>
            <form action="" method="post">
            <table><tr><td>Server</td><td>
            <select name="server">
            <?php
            $sql->query("SELECT * FROM `$webdb`.`gameservers`");
            while($srv=$sql->fetch_array())
            {?>
                <option value="<?php echo $srv['ID'];?>"><?php echo $srv['Name'];?></option>
      <?php }?>
            </select></td></tr>
            <tr><td>Character chance:</td><td><input name="chance" value="50" title="Character Chance" /></td></tr>
            <tr><td>Min Char Level:</td><td><input name="level" value="60" title="Character Minimal Level" /></td></tr>
            <tr><td align="center"><?php button('Go'); ?></td></tr>
            </td></tr></table>
            </form>
            <?php
        }
        break;
        default:
        if($_POST)
        {
            $qry=$sql->query("SELECT * FROM `".$webdb."`.`config`");
            while ( $row = $sql->fetch_array($qry) ) {
                $sql->query("UPDATE `".$webdb."`.`config` SET `value` = '". getVar($row['name'])."' WHERE `name` = '{$row['name']}' AND `type`='{$row['type']}'");
            }
            echo $Lang['saved'];
            ?> <meta http-equiv="refresh" content="1; URL=admin.php" />
            <?php 
        }
        else
        {
            ?>
            <form action="admin.php" method="post">
            <table><?php
            $qry=$sql->query("SELECT * FROM `".$webdb."`.`config` ORDER BY `type`, `name` ASC");
            while ( $row = $sql->fetch_array($qry) )
            {?>
                <tr>
                <td><?php echo $Lang[$row['type']][$row['name']];?>:</td>
                <td><select name="type" disabled="">
                <option value="debug"<?php echo $row['type']=="debug"?' selected="selected"':'';?>>Debug</option>
                <option value="head"<?php echo $row['type']=="head"?' selected="selected"':'';?>>Head</option>
                <option value="features"<?php echo $row['type']=="features"?' selected="selected"':'';?>>Features</option>
                <option value="cache"<?php echo $row['type']=="cache"?' selected="selected"':'';?>>Cache</option>
                <option value="news"<?php echo $row['type']=="news"?' selected="selected"':'';?>>News</option>
                <option value="voting"<?php echo $row['type']=="voting"?' selected="selected"':'';?>>Voting</option>
                <option value="server"<?php echo $row['type']=="server"?' selected="selected"':'';?>>Server</option>
                <option value="webshop"<?php echo $row['type']=="webshop"?' selected="selected"':'';?>>Webshop</option>
                <option value="settings"<?php echo $row['type']=="settings"?' selected="selected"':'';?>>Settings</option>
                </select></td>
                <td><input name="<?php echo $row['name'];?>" size="50" value="<?php echo htmlspecialchars(stripslashes($row['value']));?>" type="text" /></td>
                </tr>
      <?php }?>
            <tr><td></td><td align="left"><input value="<?php echo $Lang['save'];?>" type="submit" /></td></tr>
            </table>
            </form><?php
        }
        break;
}
foot();
?>