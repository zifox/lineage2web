<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('webpoints');
head("WebShop");

if($user->logged())
{
    $stat = $mysql->escape($_GET['stat']);
    if(isset($_GET['page']))
    {
        $start = $mysql->escape(0 + $_GET['page']);
    }
    else
    {
        $start = 1;
    }
    if(!is_numeric($start) || $start==0) {$start = 1;}
    $start=abs($start)-1;
    $startlimit = $start*$CONFIG['settings']['TOP'];
    $action=$_GET['a'];
    $par['lang']=getLang();
    $par['a']=$a!=''?$a:'home';
    $par['page']=$start+1;
    $params = implode(';', $par);
    echo "<h1>WebShop</h1>";
    echo "<center><a href=\"webshop.php?a=add\">Add Item</a> | <a href=\"webshop.php?a=my\">View My Items</a> | <a href=\"webshop.php?a=bought\">Bought Items</a> | <a href=\"webshop.php?a=search\">Search Item</a></center>";
    switch($action)
    {
        case "add":
        //INSERT INTO `webshop` (`owner_id`, `object_id`, `item_id`, `count`, `enchant_level`, `loc`, `money`, `money_count`, `sticky`, `added`) VALUES ('268504480', '268480369', '40113', '5', '0', 'WEB', '1', '100', '1', '2010-12-29 16:58:43')
        break;
        case "my":
        case "bought":
        case "search":
        case "edit":
        case "delete":
        case "view":
        case "buy":
        echo "NOT DONE";
        break;
        default:
        $i=0;
        echo "<table border=\"1\">";
        echo "<tr><th>Icon</th><th>Name</th><th>Price</th><th>Owner</th><th>Action</th></tr>";
        $select=$mysql->query("SELECT `owner_id`, `object_id`, `item_id`, `count`, `enchant_level`, `mana_left` , `time`, `money`, `money_count` FROM `{webdb}`.`webshop` WHERE `active`='1' LIMIT $startlimit, {$CONFIG['settings']['TOP']}", array('webdb'=>$webdb));
        while($item=$mysql->fetch_array($select))
        {
            $details=$mysql->query("SELECT * FROM `{webdb}`.`all_items2` WHERE `id`='{$item['item_id']}'", array('webdb'=>$webdb));
            $item_d=$mysql->fetch_array($details);
            $addname=($item_d['addname']=="")?"":" - ".$item_d['addname'];
            $price=($item['money']=="0")?" Adena":" WebPoints";
            $owner=$mysql->result($mysql->query("SELECT char_name FROM characters WHERE charId='{$item['owner_id']}'"));
            $grade = $item_d["grade"];
            $grade = (!empty($grade) || $grade!="none") ? "&lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />" : "";
            $enchant = $item["enchant_level"] > 0 ? " +" . $item["enchant_level"] : "";
            //print_r($item);
            echo "<tr><td>";
            echo "<img src=\"img/icons/{$item_d['icon']}.png\" alt=\"{$item_d['name']}\" title=\"{$item_d['name']}\" onmouseover=\"Tip('&lt;img src=\'img/icons/{$item_d['icon']}.png\' /&rt;&lt;br /> {$item_d['desc']}',TITLE, '{$enchant} {$item_d['name']}$addname {$grade}', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" />";
            echo "</td><td>";
            
            echo "{$item_d['name']}$addname";
            
            echo "</td><td>";
            echo "{$item['money_count']} $price";
            echo "</td><td>";
            echo "$owner";
            echo "</td><td>";
            echo "<a href=\"webshop.php?a=view&amp;id={$item['object_id']}\">View</a>";
            echo "</td></tr>";
        }
        echo "</table>";
        break;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
else
{
    msg($Lang['error'], $Lang['need_to_login'], 'error');
}
foot();
?>