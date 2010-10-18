<html><head><title>Item paster</title></head>
<body>
<?php
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",    //MySQL Password
    "database"  => "l2jdb2"        //L2J Main (account)DataBase
);
$db = $DB['database'];
$webdb='l2web';
$aitable='all_items';
$temp1='temp';
$temp2='temp2';

ini_set('max_execution_time', '180');
mysql_connect($DB['host'],$DB['user'],$DB['password']);
mysql_select_db($db);

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
$a=$_GET['a'];
switch($a)
{
    case 'upgabfai': ###update grade and bodypart for allitems1
    $query = mysql_query("SELECT item_id, bodypart, crystal_type FROM $db.weapon") OR die(mysql_error());
    $i=0;
    while($r=mysql_fetch_assoc($query))
    {
        mysql_query("UPDATE `$webdb`.`$aitable` SET `bodypart`='{$r['bodypart']}', `grade`='{$r['crystal_type']}' WHERE `id`='{$r['item_id']}';") OR die(mysql_error());
        $i++;
    }
    $query = mysql_query("SELECT item_id, bodypart, crystal_type FROM $db.armor") OR die(mysql_error());
    while($r=mysql_fetch_assoc($query))
    {
        mysql_query("UPDATE `$webdb`.`$aitable` SET `bodypart`='{$r['bodypart']}', `grade`='{$r['crystal_type']}' WHERE `id`='{$r['item_id']}';") OR die(mysql_error());
        $i++;
    }
    $query = mysql_query("SELECT item_id, item_type, crystal_type FROM $db.etcitem") OR die(mysql_error());
    while($r=mysql_fetch_assoc($query))
    {
        mysql_query("UPDATE `$webdb`.`$aitable` SET `type`='{$r['item_type']}', `grade`='{$r['crystal_type']}' WHERE `id`='{$r['item_id']}';") OR die(mysql_error());
        $i++;
    }
    break;
################################################################################################
    case 'idiai': #####insert data into all_items1
    //$query = mysql_query("SELECT temp.id AS tid, temp2.f21 AS a2, temp2.f22 AS a3, temp2.f23 AS a4, temp2.f24 AS a5, temp2.f25 AS a6  FROM $webdb.temp INNER JOIN $webdb.temp2 USING (id)") OR die(mysql_error());
$query = mysql_query("SELECT id, f2, f3, f4, f13, f17, f28 FROM $webdb.temp") OR die(mysql_error()) OR die(mysql_error());
$i=0;

while($r=mysql_fetch_assoc($query))
{
    $add_query=mysql_query("SELECT f0, id, f21, f22, f23, f24, f25 FROM $webdb.temp2 WHERE id=$r[id]") OR die(mysql_error());
    if(mysql_num_rows($add_query))
    {
        $s=mysql_fetch_assoc($add_query);
        $type=$s[f0]=="0"?"weapon":$s[f0]=="1"?"armor":"etcitem";
        mysql_query("INSERT INTO `$webdb`.`$aitable` (`id`, `name`, `addname`, `type`, `bodypart`, `grade`, `desc1`, `desc2`, `desc3`, `desc4`, `icon1`, `icon2`, `icon3`, `icon4`, `icon5`) VALUES ('$r[id]', '$r[f2]', '$r[f3]', '$type', '---', '---', '$r[f4]', '$r[f13]', '$r[f17]', '$r[f28]', '$s[f21]', '$s[f22]', '$s[f23]', '$s[f24]', '$s[f25]')") OR die(mysql_error());
    $i++;
    }
    else
    {
        echo 'No data for item'.$r[id];
        $type="---";
        mysql_query("INSERT INTO `$webdb`.`$aitable` (`id`, `name`, `addname`, `type`, `bodypart`, `grade`, `desc1`, `desc2`, `desc3`, `desc4`, `icon1`, `icon2`, `icon3`, `icon4`, `icon5`) VALUES ('$r[tid]', '$r[t2]', '$r[t3]', '$type', '---', '---', '$r[t4]', '$r[t5]', '$r[t6]', '$r[t7]', '---', '---', '---', '---', '---')") OR die(mysql_error());
    $i++;
    }
    //mysql_query("UPDATE `$webdb`.`all_items1` SET `icon1`= '$r[a2]', `icon2`= '$r[a3]', `icon3`= '$r[a4]', `icon4`= '$r[a5]', `icon5`= '$r[a6]' WHERE `id`='$r[tid]';") OR die(mysql_error().$r[tid]);
    
}
    break;
################################################################################################
    case 'sidff': ####strip invalid data from fields
    mysql_query("UPDATE `$webdb`.`all_items3` SET `desc`='';") OR die(mysql_error());
$query = mysql_query("SELECT `id`, `desc1`, `desc2`, `desc3`, `desc4`, `desc` FROM `$webdb`.`$aitable`") OR die(mysql_error());
//$query = mysql_query("SELECT `id`, `icon3` FROM `$webdb`.`$aitable` WHERE `icon3` <> ''");
$i=0;
while($r=mysql_fetch_assoc($query))
{
//    $icon = $r['icon3'];
 //   $s=array("BranchSys.icon.", "BranchSys2.icon.", "br_cashtex.item.", "icon.", "item.", "BranchSys.", "BranchSys2.");
 //   $icon = str_replace($s, '', $icon);
//    mysql_query("UPDATE `$webdb`.`$aitable` SET `icon3`='$icon' WHERE `id`='{$r['id']}';");

    $s=array("\\n", "\0", "\\0");
    $re=array("<br />", "", "");
    $desc1 = $r['desc1'];
    $desc1=substr($desc1, 2, strlen($desc1)-2);
    $desc2 = $r['desc2'];
    $desc2=substr($desc2, 2, strlen($desc2)-2);
    $desc3 = $r['desc3'];
    $desc3=substr($desc3, 2, strlen($desc3)-2);
    $desc4 = $r['desc4'];
    $desc4=substr($desc4, 2, strlen($desc4)-2);
    $desc1=str_replace($s, $re, $desc1);
    $desc2=str_replace($s, $re, $desc2);
    $desc3=str_replace($s, $re, $desc3);
    $desc4=str_replace($s, $re, $desc4);
    $desc=(($desc1=="")?"$desc2":"$desc1<br />$desc2");
    $desc=(($desc3!="")?"$desc<br />$desc3":"$desc");
    $desc=(($desc4!="")?"$desc<br />$desc4":"$desc");
    $desc=mysql_real_escape_string($desc);
    mysql_query("UPDATE `$webdb`.`$aitable` SET `desc`='$desc' WHERE `id`='{$r['id']}';") OR die(mysql_error());
    $i++;  
}
    break;
################################################################################################
    case 'gmdl': ####get max desc length
    $query = mysql_query("SELECT `id`, `desc1`, `desc2`, `desc3`, `desc4` FROM `$webdb`.`$aitable`") OR mysql_error();
$i=0;
$desc1=0;
$desc2=0;
$desc3=0;
$desc4=0;
$desctotal=0;
while($r=mysql_fetch_assoc($query))
{
    if(strlen($r['desc1'])>$desc1)
        $desc1=strlen($r['desc1']);
    if(strlen($r['desc2'])>$desc2)
        $desc2=strlen($r['desc2']);
    if(strlen($r['desc3'])>$desc3)
        $desc3=strlen($r['desc3']);
    if(strlen($r['desc4'])>$desc4)
        $desc4=strlen($r['desc4']);
    if(strlen($r['desc1'].$r['desc2'].$r['desc3'].$r['desc4'])>$desctotal)
        $desctotal=strlen($r['desc1'].$r['desc2'].$r['desc3'].$r['desc4']);
}
echo $desc1.'<br />'; //609
echo $desc2.'<br />'; //337
echo $desc3.'<br />'; //84
echo $desc4.'<br />'; //100
echo '<b>'.$desctotal.'</b><br />'; //615
    break;
################################################################################################
    case 'mifs': #missing incons from sql
    
$query = mysql_query("SELECT id, name, icon1, icon2, icon3 FROM $webdb.$aitable WHERE icon1 <> ''") OR mysql_error();
$i=0;
$err=0;
while($r=mysql_fetch_assoc($query))
{
    $icon1 = $r['icon1'];
    if(!file_exists('img/icons/'.$icon1.'.png'))
    {
        echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon1.'] doesnt exists<br />';
        $err++;
    }
/**
 *     else
 *     {
 *         echo '<img src="img/icon/'.$icon1.'.png" title="'.$r['name'].'" />';
 *     }
 *     $icon2 = $r['icon2'];
 *     if(!file_exists('img/icon/'.$icon2.'.png'))
 *     {
 *         echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon2.'] doesnt exists<br />';
 *         $err++;
 *     }
 *     else
 *     {
 *         echo '<img src="img/icon/'.$icon2.'.png" title="'.$r['name'].'" />';
 *     }
 *     $icon3 = $r['icon3'];
 *     if(!file_exists('img/icon/'.$icon3.'.png'))
 *     {
 *         echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon3.'] doesnt exists<br />';
 *         $err++;
 *     }
 *     else
 *     {
 *         echo '<img src="img/icon/'.$icon3.'.png" title="'.$r['name'].'" />';
 *     }
 */
$i++;
}
    break;
################################################################################################
    case 'uli': #useless icons
    if ($handle = opendir('img/icons/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $file = str_replace('.png', '', $file);
            $file = mysql_real_escape_string($file);
            $query = mysql_query("SELECT id FROM $webdb.all_items3 WHERE icon1='$file' OR icon2='$file' OR icon3='$file'") OR mysql_error();
            if(!mysql_num_rows($query))
            {
                echo "$file<br />";
                $file=stripslashes($file);
                copy("img/icons/$file.png", "img/icon/$file.png");
                unlink("img/icons/$file.png");
            }
            //else
            //echo $file;
        }
    }
    closedir($handle);
}
    break;
################################################################################################
    case 'carf': ###Copy and rename files
    if ($handle = opendir('C:\xampp\htdocs\l2web\img\icon')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $newfile='C:\xampp\htdocs\l2web\img\icons\\'.substr($file, 0, strlen($file)-6).'.png';
            if (!copy('C:\xampp\htdocs\l2web\img\icon\\'.$file, $newfile)) {
                echo "failed to copy $file...\n";
            }
            else
            {
                unlink('C:\xampp\htdocs\l2web\img\icon\\'.$file);
            }
        }
    }
    closedir($handle);
    }
    break;
################################################################################################
    case 'ct': ###Create tables
    mysql_query("DROP TABLE IF EXISTS `$webdb`.`$aitable`;") OR die(mysql_error());
    mysql_query("
CREATE TABLE `$webdb`.`$aitable` (
  `id` smallint(6) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `addname` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(32) CHARACTER SET latin1 DEFAULT 'etcitem',
  `bodypart` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `grade` varchar(10) CHARACTER SET latin1 DEFAULT 'no',
  `desc1` varchar(2000) DEFAULT NULL,
  `desc2` varchar(2000) DEFAULT NULL,
  `desc3` varchar(2000) DEFAULT NULL,
  `desc4` varchar(2000) DEFAULT NULL,
  `icon1` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `icon2` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `icon3` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `icon4` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `icon5` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `desc` varchar(650) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;") OR die(mysql_error());
    break;
################################################################################################
    case 'cl2jdb': ###Chech l2jdb table
    $query = mysql_query("SELECT item_id, name FROM $db.weapon") OR mysql_error();
    $i=0;
    while($r=mysql_fetch_assoc($query))
    {
        $sq=mysql_query("SELECT `id` FROM `$webdb`.`$aitable` WHERE `id`='{$r['item_id']}';") OR mysql_error("$i");
        if(!mysql_num_rows($sq))
        {
            echo 'Missing data for weapon '.$r[item_id].'<br />';
            $i++;
        }

    }
    $query = mysql_query("SELECT item_id, name FROM $db.armor") OR mysql_error();
    $i=0;
    while($r=mysql_fetch_assoc($query))
    {
        $sq=mysql_query("SELECT `id` FROM `$webdb`.`$aitable` WHERE `id`='{$r['item_id']}';") OR mysql_error("$i");
        if(!mysql_num_rows($sq))
        {
            echo 'Missing data for armor '.$r[item_id].'<br />';
            $i++;
        }
    }
    $query = mysql_query("SELECT item_id, name FROM $db.etcitem") OR mysql_error();
    $i=0;
    while($r=mysql_fetch_assoc($query))
    {
        $sq=mysql_query("SELECT `id` FROM `$webdb`.`$aitable` WHERE `id`='{$r['item_id']}';") OR mysql_error("$i");
        if(!mysql_num_rows($sq))
        {
            echo 'Missing data for etcitem '.$r[item_id].'<br />';
            $i++;
        }

    }
    break;
################################################################################################
    case 'ctemp2': ###Chech temp2 table
    $query = mysql_query("SELECT f0, id, f21, f22, f23, f24, f25 FROM $webdb.temp2") OR mysql_error();
    $i=0;
    while($r=mysql_fetch_assoc($query))
    {
        $sq=mysql_query("SELECT `id` FROM `$webdb`.`$aitable` WHERE `id`='{$r['id']}';") OR die(mysql_error('Error'));
        if(!mysql_num_rows($sq))
        {
            $query2 = mysql_query("SELECT id, f2, f3, f4, f13, f17, f28 FROM $webdb.temp WHERE `id`='{$r['id']}';") OR die(mysql_error());
            echo 'Missing data for item '.$r[id].'<br />';
            $s=mysql_fetch_assoc($query2);
            $type=$r[f0]=="0"?"weapon":$r[f0]=="1"?"armor":"etcitem";
        mysql_query("INSERT INTO `$webdb`.`$aitable` (`id`, `name`, `addname`, `type`, `bodypart`, `grade`, `desc1`, `desc2`, `desc3`, `desc4`, `icon1`, `icon2`, `icon3`, `icon4`, `icon5`) VALUES ('$r[id]', '".mysql_real_escape_string($s[f2])."', '".mysql_real_escape_string($s[f3])."', '$type', '---', '---', '".mysql_real_escape_string($s[f4])."', '".mysql_real_escape_string($s[f13])."', '".mysql_real_escape_string($s[f17])."', '".mysql_real_escape_string($s[f28])."', '".mysql_real_escape_string($r[f21])."', '$r[f22]', '$r[f23]', '$r[f24]', '$r[f25]')") OR die(mysql_error());
    $i++;
        }

    }

    break;
################################################################################################
    default:
    echo '<a href="?a=upgabfai">update grade and bodypart for allitems1</a><br />';
    echo '<a href="?a=idiai">insert data into all_items1</a><br />';
    echo '<a href="?a=sidff">strip invalid data from fields</a><br />';
    echo '<a href="?a=gmdl">get max desc length</a><br />';
    echo '<a href="?a=mifs">missing incons from sql</a><br />';
    echo '<a href="?a=uli">useless icons</a><br />';
    echo '<a href="?a=carf">Copy and rename files</a><br />';
    echo '<a href="?a=ct">Create tables</a><br />';
    break;
################################################################################################
}

echo $err.' missing icons<br />';
echo $i.' items updated';
mysql_close();
?>
</body>
</html>