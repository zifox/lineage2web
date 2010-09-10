<html><head><title>Item paster</title></head>
<body>
<?php
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",    //MySQL Password
    "database"  => "l2j"        //L2J Main (account)DataBase
);
$db = $DB['database'];
$webdb='web';
mysql_connect($DB['host'],$DB['user'],$DB['password']);
mysql_select_db($db);
###query1
/*$query = mysql_query("SELECT item_id, name, additionalname, bodypart, crystal_type FROM $db.weapon") OR mysql_error();
$i=0;

while($r=mysql_fetch_assoc($query))
{
    mysql_query("UPDATE `$webdb`.`all_items` SET `name`= '{$r['name']}', `addname`='{$r['additionalname']}', type='weapon', `bodypart`='{$r['bodypart']}', `grade`='{$r['crystal_type']}' WHERE `id`='{$r['item_id']}';") OR mysql_error();
    $i++;
}*/
#####query2

/*
$query = mysql_query("SELECT id, f21 FROM $webdb.test_copy") OR mysql_error();
$i=0;

while($r=mysql_fetch_assoc($query))
{
    mysql_query("UPDATE `$webdb`.`all_items` SET `icon`= '{$r['f21']}' WHERE `id`='{$r['id']}';") OR mysql_error();
    $i++;
}*/
####query3
/*$query = mysql_query("SELECT id, icon FROM $webdb.all_items") OR mysql_error();
$i=0;

while($r=mysql_fetch_assoc($query))
{
    $icon = $r['icon'];
    //$icon = str_replace('BranchSys.icon.', '', $icon);
    //$icon = str_replace('BranchSys2.icon.', '', $icon);
    //$icon = str_replace('br_cashtex.item.', '', $icon);
    //$icon = str_replace('icon.', '', $icon);
    //$icon = str_replace('item.', '', $icon);
    //$icon = str_replace('BranchSys.', '', $icon);
    //$icon = str_replace('BranchSys2.', '', $icon);
    mysql_query("UPDATE `$webdb`.`all_items` SET `icon`= '$icon' WHERE `id`='{$r['id']}';") OR mysql_error();
    $i++;
}*/
$query = mysql_query("SELECT id, name, icon FROM $webdb.all_items") OR mysql_error();
$i=0;
$err=0;
while($r=mysql_fetch_assoc($query))
{
    $icon = $r['icon'];
    if(!file_exists('img/iconsall/'.$icon.'.png'))
    {
        echo 'Item ['.$r['id'].' - '.$r['name'].'] icon doesnt exists<br />';
        $err++;
    }
$i++;
}
echo $err.' missing icons<br />';
echo $i.' items updated';
mysql_close();
?>
</body>
</html>