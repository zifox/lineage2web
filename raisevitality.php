<?php
define('INWEB', True);
require_once("include/config.php");
//пароль

if(isset($_GET['char']) && is_numeric($_GET['char']))
{
	$srv = $mysql->escape(0 + $_GET['server']);
	$char = $mysql->escape(0 + $_GET['char']);
	$id = $mysql->escape(0 + $_GET['id']);
    if($_SESSION['webpoints']<=0)
    {
        echo "alert('You don\'t have enought webpoints');";
        exit();
    }
    
	$dbname = getDBName($srv);
	$checkchar = $mysql->query("SELECT `account_name`, `charId`, `vitality_points`, `online` FROM `$dbname`.`characters` WHERE `charId` = '$char'");
	if($mysql->num_rows($checkchar))
	{
		$char = $mysql->fetch_array($checkchar);
		if(strtolower($char['account_name'])!=strtolower($_SESSION['account']))
		{
            echo "alert('This is not your character');\n";
			die();
		}
		if($char['online'])
		{
            echo "alert('Please log off character first');\n";
            die();
		}
		if($char['vitality_points']=='20000')
		{
            echo "alert('You have already max vitality points');\n";
            die();
		}
		else
		{
            if($char['vitality_points']+2500<20000)
            {
		          $mysql->query("UPDATE `$dbname`.`characters` SET `vitality_points`=`vitality_points`+'2500' WHERE `charId` = '{$char['charId']}'");
                    echo "alert('Vitality Points successfully exchanged');\n";
            }
            else
            {
                $mysql->query("UPDATE `$dbname`.`characters` SET `vitality_points`='20000' WHERE `charId` = '{$char['charId']}'");
                    echo "alert('Vitality Points successfully exchanged');\n";
            }
            $mysql->query("UPDATE `accounts` SET `webpoints`=`webpoints`-'1' WHERE `login`='{$_SESSION['account']}'");
            echo "document.getElementById('vitality$id').width='";
            echo ($char['vitality_points']+2500)/250;
            echo "';\n";
            echo "document.getElementById('wp').firstChild.nodeValue='";
			echo $_SESSION['webpoints']-1;
			echo "';\n";
		}
	}
}
?>