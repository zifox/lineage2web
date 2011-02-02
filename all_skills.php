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
$aitable='skill_temp';


ini_set('max_execution_time', '180');
mysql_connect($DB['host'],$DB['user'],$DB['password']);
mysql_select_db($db);

$qry=mysql_query("SELECT * FROM `character_pccafe_points`") OR die(mysql_error());
$less=0;
$more=0;
$upd=0;
while($r=mysql_fetch_assoc($qry))
{
    $points=($r['points']>200000)?'200000':$r['points'];
    $char_points=mysql_result(mysql_query("SELECT `pccafe_points` FROM `characters` WHERE `charId`='{$r['objectId']}'") OR die(mysql_error()));
    if($char_points<=200000)
    {
        $points=($points>$char_points)?$points:$char_points;
        $less++;
    }
    else
    {
        $points='200000';
        $more++;
    }
    mysql_query("UPDATE `characters` SET `pccafe_points`='$points' WHERE `charId`='{$r['charId']}'");
    $upd++;
}
echo $less."<br />";
echo $more."<br />";
echo $upd."<br />";
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
##Column max lenght

   $query = mysql_query("SELECT * FROM `$webdb`.`$aitable`") OR mysql_error();
$i=0;
$f1=0;
$f2=0;
$f3=0;
$f4=0;
$f5=0;
$f6=0;
while($r=mysql_fetch_assoc($query))
{
    if(strlen($r['f1'])>$f1)
        $f1=strlen($r['f1']);
    if(strlen($r['f2'])>$f2)
        $f2=strlen($r['f2']);
    if(strlen($r['f3'])>$f3)
        $f3=strlen($r['f3']);
    if(strlen($r['f4'])>$f4)
        $f4=strlen($r['f4']);
    if(strlen($r['f5'])>$f5)
        $f5=strlen($r['f5']);
    if(strlen($r['f6'])>$f6)
        $f6=strlen($r['f6']);
}
echo $f1.'<br />'; //5
echo $f2.'<br />'; //3
echo $f3.'<br />'; //82/78
echo $f4.'<br />'; //597/593
echo $f5.'<br />'; //44/40
echo $f6.'<br />'; //94/90
*/
#strip invalid data from fields
/*
$query = mysql_query("SELECT * FROM `$webdb`.`$aitable`") OR die(mysql_error());
$i=0;
while($r=mysql_fetch_assoc($query))
{

    $s=array("\\n", "\0", "\\0");
    $re=array("<br />", "", "");
    $f3 = $r['f3'];
    $f3=substr($f3, 2, strlen($f3)-2);
    $f4 = $r['f4'];
    $f4=substr($f4, 2, strlen($f4)-2);
    $f5 = $r['f5'];
    $f5=substr($f5, 2, strlen($f5)-2);
    $f6 = $r['f6'];
    $f6=substr($f6, 2, strlen($f6)-2);
    $f3=str_replace($s, $re, $f3);
    $f4=str_replace($s, $re, $f4);
    $f5=str_replace($s, $re, $f5);
    $f6=str_replace($s, $re, $f6);
    $f3=mysql_real_escape_string($f3);
    $f4=mysql_real_escape_string($f4);
    $f5=mysql_real_escape_string($f5);
    $f6=mysql_real_escape_string($f6);
    mysql_query("UPDATE `$webdb`.`$aitable` SET f3='$f3', f4='$f4', f5='$f5', f6='$f6' WHERE `f1`='{$r['f1']}' AND `f2`='{$r['f2']}';") OR die(mysql_error());
    $i++;  
}
echo $i;
*/



?>