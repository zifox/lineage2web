<html><head><title>Item paster</title></head>
<body>
<?php
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",    //MySQL Password
    "database"  => "l2j"        //L2J Main (account)DataBase
);
//$db = $DB['database'];
//$webdb='l2web';
//mysql_connect($DB['host'],$DB['user'],$DB['password']);
//mysql_select_db($db);
/*
function str_replace_once($search, $replace, $subject) {
    $firstChar = strpos($subject, $search);
    if($firstChar !== false) {
        $beforeStr = substr($subject,0,$firstChar);
        $afterStr = substr($subject, $firstChar + strlen($search));
        return $beforeStr.$replace.$afterStr;
    } else {
        return $subject;
    }
}
*/
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
/*$query = mysql_query("SELECT `id`, `desc` FROM `$webdb`.`all_items`") OR mysql_error();
$i=0;

while($r=mysql_fetch_assoc($query))
{
    //$icon = $r['icon'];
    //$icon = str_replace('BranchSys.icon.', '', $icon);
    //$icon = str_replace('BranchSys2.icon.', '', $icon);
    //$icon = str_replace('br_cashtex.item.', '', $icon);
    //$icon = str_replace('icon.', '', $icon);
    //$icon = str_replace('item.', '', $icon);
    //$icon = str_replace('BranchSys.', '', $icon);
    //$icon = str_replace('BranchSys2.', '', $icon);
    $desc = $r['desc'];
    $desc = str_replace(' \\0', '', $desc);
    $desc = str_replace('\\0', '', $desc);
    $desc = str_replace('\\\n', '', $desc);
    $desc = str_replace('a,', '', $desc);
    mysql_query("UPDATE `$webdb`.`all_items` SET `desc`= '$desc' WHERE `id`='{$r['id']}';") OR mysql_error();

        $i++;
}*/
#missing incons from sql
/*
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
*/

#useless icons
/*
if ($handle = opendir('img/iconsall/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $file = str_replace('.png', '', $file);
            $file = addslashes($file);
            $query = mysql_query("SELECT id FROM $webdb.all_items WHERE icon='$file'") OR mysql_error();
            if(!mysql_num_rows($query))
            {
            echo "$file<br />";
            $file=stripslashes($file);
            unlink("img/iconsall/$file.png");
            }
            //else
            //echo $file;
        }
    }
    closedir($handle);
}
*/
//echo $err.' missing icons<br />';
//echo $i.' items updated';
//mysql_close();
$file = file_get_contents('sql.sql');
$file=str_replace('\\\\0', '', $file);
file_put_contents('sql.sql', $file);
echo 'done';
?>


</body>
</html>