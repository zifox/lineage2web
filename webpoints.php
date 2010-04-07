<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('webpoints');
head($Lang['webpoint_exchange']);

if($user->logged())
{
    if($_POST)
    {
    	$srvdb = getDBName($_POST['server']);
    	
        $char=$mysql->escape($_POST['char']);
        //$reward=0+$_POST['reward'];
        if(!is_numeric($_POST['multiplier']) || $_POST['multiplier']==0){$_POST['multiplier']=1;}
        //if(!is_numeric($_POST['reward'])){$_POST['reward']=1;}
        if(!is_numeric($_POST['char'])){$_POST['char']=1;}
        if($_POST['multiplier']<0){$_POST['multiplier']=abs($_POST['multiplier']);}
        //if($_POST['reward']==3){$_POST['multiplier']=1;}
        $multi=0+$_POST['multiplier'];
        
        $check = $mysql->result($mysql->query("SELECT `webpoints` FROM `accounts` WHERE `login`='{$_SESSION['account']}'"));
        if($check < $_POST['multiplier'])
        {
            msg('Error', 'Not enought webpoints', 'error');
        }else{
        	
            $checkonline= $mysql->query("SELECT `account_name`, `online` FROM `$srvdb`.`characters` WHERE `charId`='".$char."'");
           // echo $char;
            if($mysql->num_rows($checkonline))
            {
                $chon=$mysql->fetch_array($checkonline);
                if($chon['online']==0 && $chon['account_name']==strtolower($_SESSION['account']))
                {
            $_SESSION['webpoints'] -= $multi; 

            $indb=$multi*4;
            $mysql->query("UPDATE `accounts` SET `webpoints` = `webpoints`-'$multi' WHERE `login`='{$_SESSION['account']}';");
            $query=$mysql->query("SELECT `object_id` FROM `$srvdb`.`items` WHERE `owner_id`='$char' AND `item_id` = '4356' AND `loc` = 'INVENTORY'") OR mysql_error();
            if($mysql->num_rows($query))
            {
                $mysql->query("UPDATE `$srvdb`.`items` SET `count` = `count` + '$indb' WHERE `owner_id`='$char' AND `item_id` = '4356' AND `loc` = 'INVENTORY'");
            }else{
                $maxloc=$mysql->query("SELECT Max(`loc_data`) FROM `$srvdb`.`items` WHERE `items`.`owner_id` = '$char' AND `items`.`loc` = 'INVENTORY'") OR mysql_error();
                $itemloc=$mysql->result($maxloc)+1;
                 $mysql->query("INSERT INTO `$srvdb`.`items` (`owner_id`,`item_id`,`count`,`loc`,`loc_data`,`time`) VALUES ('$char','4356','$indb','INVENTORY','$itemloc','-1')") OR mysql_error();
            }
            $mysql->query("INSERT INTO `$webdb`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$char', 'WebPointExchange', 'Success', 'WebPoint Count=\"$multi\", Reward=\"Gold Einhasad\" ');");
        msg('Success', $$Lang['webpoints_exchanged']);
        }else{
            $mysql->query("INSERT INTO `$webdb`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$char', 'WebPointExchange', 'Error', 'WebPoint Count=\"$multi\", Reason=\"Char is Online or Not owned by this account\" ');");
            msg('Error', 'Character is online or this is not your character', 'error');
        }
        }
        }
    }else{
        $parse = $Lang;
        $parse['server_list'] = NULL;
	$srv = $mysql->query($q[1], $webdb);
	while($srname = $mysql->fetch_array($srv))
	{
		$parse['server_list'] .= '<option value="'.$srname['ID'].'">'.$srname['Name'].'</option>';
	}
	$parse['b_exchange'] = button($Lang['exchange'], $Lang['exchange'],1);
    $tpl->parsetemplate('webpoints', $parse);
    }
}else {
    msg($Lang['error'], $Lang['need_to_login'], 'error');
}
foot();
?>