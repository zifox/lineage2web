<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('webpoints');
head($Lang['webpoint_exchange']);
?>
<script type="text/javascript" language="javascript">
function check(){
    var value = document.webpoint.reward.value;
    if(value == 3){
        document.webpoint.multiplier.value = 1;
        document.webpoint.multiplier.disabled = true;
    }else{
        document.webpoint.multiplier.disabled = false;
    }
}
</script>
<?php
if(logedin())
{
    if($_POST)
    {
        $char=mysql_real_escape_string($_POST['char']);
        $reward=0+$_POST['reward'];
        if(!is_numeric($_POST['multiplier']) || $_POST['multiplier']==0){$_POST['multiplier']=1;}
        if(!is_numeric($_POST['reward'])){$_POST['reward']=1;}
        if(!is_numeric($_POST['char'])){$_POST['char']=1;}
        if($_POST['multiplier']<0){$_POST['multiplier']=abs($_POST['multiplier']);}
        if($_POST['reward']==3){$_POST['multiplier']=1;}
        $multi=0+$_POST['multiplier'];
        
        $check = mysql_result(mysql_query("SELECT `webpoints` FROM `accounts` WHERE `login`='{$_SESSION['account']}'"),0,0);
        if($check < $_POST['multiplier'])
        {
            msg('Error', 'Not enought webpoints', 'error');
        }else{
            $_SESSION['webpoints'] -= $multi; 
        if($reward==3){
            mysql_query("UPDATE `accounts` SET `webpoints` = `webpoints`-'1' WHERE `login`='{$_SESSION['account']}';");
            mysql_query("UPDATE `characters` SET `vitality_points`='20000' WHERE `charId`='$char'");
        }else if($reward==2)
        {
            $indb=$multi*4;
            mysql_query("UPDATE `accounts` SET `webpoints` = `webpoints`-'$multi' WHERE `login`='{$_SESSION['account']}';");
            $query=mysql_query("SELECT `object_id` FROM `items` WHERE `owner_id`='$char' AND `item_id` = '4356' AND `loc` = 'INVENTORY'") OR mysql_error();
            if(mysql_num_rows($query))
            {
                mysql_query("UPDATE `items` SET `count` = `count` + '$indb' WHERE `owner_id`='$char' AND `item_id` = '4356' AND `loc` = 'INVENTORY'");
            }else{
                $maxloc=mysql_query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$char' AND `items`.`loc` = 'INVENTORY'") OR mysql_error();
                $itemloc=mysql_result($maxloc,0,0)+1;
                 mysql_query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`,`time`) VALUES ('$char','4356','$indb','INVENTORY','$itemloc','-1')") OR mysql_error();
            }
        }else{
            $indb=$multi*20000000;
            mysql_query("UPDATE `accounts` SET `webpoints` = `webpoints`-'$multi' WHERE `login`='{$_SESSION['account']}';");
            $query=mysql_query("SELECT `object_id` FROM `items` WHERE `owner_id`='$char' AND `item_id` = '57' AND `loc` = 'INVENTORY'") OR mysql_error();
            if(mysql_num_rows($query))
            {
                mysql_query("UPDATE `items` SET `count` = `count` + '$indb' WHERE `owner_id`='$char' AND `item_id` = '57' AND `loc` = 'INVENTORY'");
            }else{
                $maxloc=mysql_query("SELECT Max(`loc_data`) FROM `items` WHERE `items`.`owner_id` = '$char' AND `items`.`loc` = 'INVENTORY'") OR mysql_error();
                $itemloc=mysql_result($maxloc,0,0)+1;
                 mysql_query("INSERT INTO `items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`,`time`) VALUES ('$char','57','$indb','INVENTORY','$itemloc','-1')") OR mysql_error();
            }
        }
        echo $Lang['webpoints_exchanged'];
        }
    }else{
    ?>
    <div align="center">
    <form name="webpoint" action="webpoints.php" method="post">
    <table border="1">
    <thead><tr><th><?php echo $Lang['char'];?></th><th><?php echo $Lang['exchange_for'];?></th><th><?php echo $Lang['count'];?></th></tr></thead>
    <tbody>
    <tr><td><select id="char" name="char">
    <?php
$query=mysql_query("SELECT `charId`, `char_name` FROM `characters` WHERE `account_name`='{$_SESSION['account']}'");
while($row=mysql_fetch_assoc($query))
{
    echo "<option value=\"{$row['charId']}\">{$row['char_name']}</option>";
}
?>
    </select></td><td><select name="reward" id="reward" onchange="check()"><option value="1">Adena 20kk</option><option value="2">Gold Einhasad x4</option><option value="3">Full Vitality</option></select></td>
    <td>x<input name="multiplier" id="multiplier" type="text" value="1" size="3" maxlength="3" /></td>
    </tr>
    </tbody>
    </table>
    <table border="0"><tr><td><?php echo button($Lang['exchange']);?></td></tr></table>
    </form>
    </div>
    <?php
    }
}else msg($Lang['error'], $Lang['need_to_login'], 'error');
foot();
?>