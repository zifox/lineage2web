<?php
define('INWEB', True);
require_once("include/config.php");
//пароль

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Author" content="80MXM08" />
<meta name="Copyright" content="2009 - 2011 Lineage II Fantasy World. All rights reserved." />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM" />
 <title>View Image</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />
</head>
<body bgcolor="#406072" style="margin-top: 0; margin-bottom: 0; margin-left: 0; margin-right: 0;" >
<table width="425px" border="0" style="color: white;"><tr><td>
<font color="#FFFFFF">
<?php
if($_GET['id'])
{
    $id=0+$mysql->escape($_GET['id']);
    if(!is_numeric($id) || !is_int($id))
        die();
    $item=$mysql->query("SELECT * FROM `$webdb`.`all_items` WHERE `id`='$id'");
    $i=$mysql->fetch_array($item);
    ?>
    <table cellpadding="5" cellspacing="5" border="2" width="425px">
    <tr><td><img src="img/icons/<?php echo $i['icon1'];?>.png" alt="<?php echo $i['name'];?>" title="<?php echo $i['name'];?>" width="64" height="64"/></td>
    <td>
    <table border="1" width="315px">
    <tr><td>Name</td><td><?php echo $i['name'];?></td></tr>
    <tr><td>Additional name</td><td><?php echo $i['add_name'];?></td></tr>
    <tr><td>Type</td><td><?php echo $i['type'];?></td></tr>
    <tr><td>Body Part</td><td><?php echo $i['bodypart'];?></td></tr>
    <?php
    $grade=($i['grade']!='none')?"<img src=\"img/grade/{$i['grade']}-grade.png\" alt=\"{$i['grade']}\" title=\"{$i['grade']}\" />":"none";
    ?>
    <tr><td>Grade</td><td><?php echo $grade;?></td></tr>
    </table>
    </td></tr>
    </table>
    <br />
    <?php
    if($i['desc']!="" || $i['grade']=="none")
    {
        if($i['desc']!="")
        {
        ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc'];?></td></tr></table>
    
    <?php
    }
    }
    else
    {
        if($i['bodypart']=="lhand")
            $i['bodypart']="shield";
        //try to find chest from armorsets
        $c=$mysql->query("SELECT `chest` FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
        if($mysql->num_rows($c))
        {
            $chest_id=$mysql->result($c);
            $i['desc']=$mysql->result($mysql->query("SELECT `desc` FROM `$webdb`.`all_items` WHERE `id`='$chest_id'"));
           ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc'];?></td></tr></table>
    <?php 
        }
    }
    
    //check set items
    if($i['bodypart']=="fullarmor")
        $i['bodypart']="chest";
//    if($i['bodypart']=="lhand")
//        $i['bodypart']="shield";
    if($i['bodypart']=="chest" || $i['bodypart']=="legs" || $i['bodypart']=="head" || $i['bodypart']=="gloves"
    || $i['bodypart']=="feet" || $i['bodypart']=="shield")
    {
    $set=$mysql->query("SELECT * FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
    if($mysql->num_rows($set))
    {
    
    ?>
    <br />
    Set items
    <br />
    <?php
    while($i2=$mysql->fetch_row($set))
    {
    ?>
    <table border="1" cellpadding="5" cellspacing="5">
    <tr>
    <?php
    for($n=1;$n<8;$n++)
    {
        if($n==6 || $i2[$n]=="0")
            continue;
        $query=$mysql->query("SELECT `name`, `icon1` FROM `$webdb`.`all_items` WHERE `id`='{$i2[$n]}'");
        $i3=$mysql->fetch_array($query);
        if($id!=$i2[$n])
            echo "<td><a href=\"item.php?id={$i2[$n]}\"><img src=\"img/icons/{$i3['icon1']}.png\" alt=\"{$i3['name']}\" title=\"{$i3['name']}\" border=\"0\"/></a></td>";
        else
            echo "<td><img src=\"img/icons/{$i3['icon1']}.png\" alt=\"{$i3['name']}\" title=\"{$i3['name']}\" border=\"0\"/></td>";
    }
    ?>
    </tr>
    </table>
    <?php
}
    }
}
}
//foot(0);
?></font></td></tr></table>
</body>
</html>