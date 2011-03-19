<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('webpoints');
head("WebShop");

if($user->logged())
{
    $stat = getVar('stat');
    if(isset($_GET['page']))
    {
        $start = getVar('page');
    }
    else
    {
        $start = 1;
    }
    if(!is_numeric($start) || $start==0) {$start = 1;}
    $start=abs($start)-1;
    $startlimit = $start*getConfig('settings', 'TOP', '10');
    $a=getvar('a');
    $par['lang']=getLang();
    $par['a']=$a!=''?$a:'home';
    $par['page']=$start+1;
    $webdb=getConfig('settings','webdb','l2web');
    $params = implode(';', $par);
    echo "<h1>WebShop</h1>";
    echo "<center><a href=\"webshop.php\">All Items</a> | <a href=\"webshop.php?a=add\">Add Item</a> | <a href=\"webshop.php?a=my\">View My Items</a> | <a href=\"webshop.php?a=bought\">Bought Items</a> | <a href=\"webshop.php?a=search\">Search Item</a></center><br />";
    switch($a)
    {
        case "add":
        //INSERT INTO `webshop` (`owner_id`, `object_id`, `item_id`, `count`, `enchant_level`, `loc`, `money`, `money_count`, `sticky`, `added`) VALUES ('268504480', '268480369', '40113', '5', '0', 'WEB', '1', '100', '1', '2010-12-29 16:58:43')
        break;
        case "my":
        case "bought":
        case "search":
        case "edit":
        case "delete":
            echo 'NOT DONE!';
            break;
        case "view":
            $i_id=getVar('id');
            $qry=$sql->query('SELECT * FROM l2web.webshop WHERE object_id=\''.$i_id.'\'');
            $item=$sql->fetch_array();
            $qry=$sql->query('SELECT * FROM l2web.all_items WHERE id=\''.$item['item_id'].'\'');
            $itemi=$sql->fetch_array();
            $addname=($itemi['addname']!='')?' - '.$itemi['adname']:'';
            $qry=$sql->query('SELECT char_name FROM characters WHERE charId=\''.$item['owner_id'].'\'');
            $char=$sql->fetch_array();
            if($char['char_name']=='') $char['char_name']='No Owner';
            ?>
            <table cellpadding="5" cellspacing="5" border="2" width="425px">
    <tr><td><img src="img/icons/<?php echo $itemi['icon1'];?>.png" alt="<?php echo $itemi['name'];?>" title="<?php echo $itemi['name'];?>" width="64" height="64"/></td>
    <td>
    <table border="1" width="315px">
    <tr><td>Name</td><td><?php echo $itemi['name'].$addname;?></td></tr>
    <tr><td>Type</td><td><?php echo $itemi['type'];?></td></tr>
    <tr><td>Body Part</td><td><?php echo $itemi['bodypart'];?></td></tr>
    <?php
    $grade=($itemi['grade']!='none')?"<img src=\"img/grade/{$itemi['grade']}-grade.png\" alt=\"{$itemi['grade']}\" title=\"{$itemi['grade']}\" />":"none";
    ?>
    <tr><td>Grade</td><td><?php echo $grade;?></td></tr>
    <?php
    if($item['enchant_level']!='' && $item['enchant_level']>0)
    {?>
    <tr><td>Enchant</td><td><?php echo $item['enchant_level'];?></td></tr><?php
    }
    ?>
    <tr><td>Count</td><td><?php echo $item['count'];?></td></tr>
    <tr><td>Price<br /> per 1 item</td><td><?php echo $item['money_count'];?> <?php echo ($item['money']==0)?'Adena':'WebPoints';?></td></tr>
    <tr><td>Owner</td><td><?php echo $char['char_name'];?></td></tr>
    </table>
    </td></tr>
    </table>
    <br />
    <?php
    if($itemi['desc']!="" || $itemi['grade']=="none")
    {
        if($itemi['desc']!="")
        {
        ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $itemi['desc'];?></td></tr></table>
    
    <?php
    }
    }
    else
    {
        if($i['bodypart']=="lhand")
            $i['bodypart']="shield";
        //try to find chest from armorsets
        $c=$sql->query("SELECT `chest` FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
        if($sql->num_rows($c))
        {
            $chest_id=$sql->result($c);
            $i['desc']=$sql->result($sql->query("SELECT `desc` FROM `$webdb`.`all_items` WHERE `id`='$chest_id'"));
           ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc'];?></td></tr></table>
    <?php 
        }
    }
    if($item['comment']!='')
    {
        ?>
        Comment:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $item['comment'];?></td></tr></table>
        <?php
    }
    ?>
    <form action="?a=buy" method="POST">
    <table><tr><td><input type="hidden" name="id" id="id" value="<?php echo $item['object_id'];?>" />
    Count: <input type="text" maxlength="3" id="count" name="count" size="3" title="Count" /><br />
    <?php echo button('Buy','submit',1,false,'submit');?>
    </form></td></tr>
    </table>
    <?php
    break;
        case "buy":
            $id=getVar('id');
            $count=getVar('count');
            $qry=$sql->query('SELECT * FROM l2web.webshop WHERE object_id=\''.$id.'\'');
            $item=$sql->fetch_array();
            $qry=$sql->query('SELECT * FROM l2web.all_items WHERE id=\''.$item['item_id'].'\'');
            $itemi=$sql->fetch_array();
            $count=getVar('count');
            $sum=$count*$item['money_count'];
            if($item['money']==0) //adena
            {
                $qry=$sql->query('SELECT `characters`. `char');
                //SELECT characters.charId, characters.char_name, items.object_id, items.`count`,items.loc FROM characters ,items WHERE characters.charId =  items.owner_id AND items.item_id =  '57' AND characters.account_name =  '80mxm08'
                //SELECT characters.account_name, SUM(items.`count`) AS adena FROM characters , items WHERE characters.charId =  items.owner_id AND items.item_id =  '57' AND characters.account_name =  '80mxm08'
            }
            else //webpoints
            {
                if($_SESSION['webpoints']-$sum<0)
                {
                    msg('Error', 'You don\'t have '.$sum.' webpoints <br /> You have '.$_SESSION['webpoints'].' webpoints','error');
                }
                else
                {
                    
                }
            }
            
        break;
        default:
        $type=getVar('type');
        $grade=getVar('grade');
            ?>
            <form action="" method="post">
            <table><tr><td>Name</td><td>Type</td><td>Grade</td><td></td></tr>
            <tr><td><input type="text" id="s" name="s" value="<?php echo getVar('s');?>" /></td>
            <td>
            <select id="type" name="type">
            <option value="all" <?php echo ($type=='all')?'selected="selected"':'';?>>All</option>
            <option value="armor" <?php echo ($type=='armor')?'selected="selected"':'';?>>Armor</option>
            <option value="weapon" <?php echo ($type=='weapon')?'selected="selected"':'';?>>Weapon</option>
            <option value="potion" <?php echo ($type=='potion')?'selected="selected"':'';?>>Potion</option>
            <option value="scroll" <?php echo ($type=='scroll')?'selected="selected"':'';?>>Scroll</option>
            </select></td><td>
            <select id="grade" name="grade">
            <option value="all" <?php echo ($grade=='all')?'selected="selected"':'';?>>All</option>
            <option value="no" <?php echo ($grade=='no')?'selected="selected"':'';?>>No Grade</option>
            <option value="d" <?php echo ($grade=="d")?' selected="selected"':'';?>>D-Grade</option>
            <option value="c" <?php echo ($grade=='c')?'selected="selected"':'';?>>C-Grade</option>
            <option value="b" <?php echo ($grade=='b')?'selected="selected"':'';?>>B-Grade</option>
            <option value="a" <?php echo ($grade=='a')?'selected="selected"':'';?>>A-Grade</option>
            <option value="s" <?php echo ($grade=='s')?'selected="selected"':'';?>>S-Grade</option>
            <option value="s80" <?php echo ($grade=='s80')?'selected="selected"':'';?>>S80-Grade</option>
            <option value="s84" <?php echo ($grade=='s84')?'selected="selected"':'';?>>S84-Grade</option>
            </select></td>
            <td>
            <input type="submit" value="Submit" />
            </td>
            </tr></table></form>
            <?php
        $i=0;
        echo "<table border=\"1\">";
        echo "<tr><th>Icon</th><th>Name</th><th>Price</th><th>Owner</th><th>Action</th></tr>";
        $select=$sql->query("SELECT `owner_id`, `object_id`, `item_id`, `count`, `enchant_level`, `mana_left` , `time`, `money`, `money_count` FROM `{webdb}`.`webshop` WHERE `active`='1' LIMIT $startlimit, {$CONFIG['settings']['TOP']}", array('webdb'=>$webdb));
        while($item=$sql->fetch_array($select))
        {
            $details=$sql->query("SELECT * FROM `{webdb}`.`all_items2` WHERE `id`='{$item['item_id']}'", array('webdb'=>$webdb));
            $item_d=$sql->fetch_array($details);
            $addname=($item_d['addname']=="")?"":" - ".$item_d['addname'];
            $price=($item['money']=="0")?" Adena":" WebPoints";
            $query=$sql->query("SELECT char_name FROM characters WHERE charId='{$item['owner_id']}'");
            if($sql->num_rows($query))
            {
                $fquery=$sql->fetch_array();
                $owner=$fquery['char_name'];
            }
            else
            {
                $owner='No owner';
            }
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