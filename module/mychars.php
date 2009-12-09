<?php
includeLang('mychars');
if (logedin())
{
    $sql=mysql_query("SELECT `characters`.`account_name`, `characters`.`charId`, `characters`.`char_name`, `characters`.`level`,
`characters`.`maxHp`, `characters`.`maxCp`, `characters`.`maxMp`, `characters`.`sex`, `characters`.`karma`, `characters`.`fame`,
`characters`.`pvpkills`, `characters`.`pkkills`, `characters`.`clanid`, `characters`.`race`, `characters`.`classid`, `characters`.`base_class`, `characters`.`title`, `characters`.`rec_have`, `characters`.`accesslevel`, `characters`.`online`, `characters`.`onlinetime`, `characters`.`lastAccess`, `characters`.`nobless`, `characters`.`vitality_points`, `char_templates`.`ClassName`
FROM `characters` , `char_templates`
WHERE `characters`.`classid` = `char_templates`.`ClassId` AND `account_name` = '{$CURUSER['login']}'");
    if (mysql_num_rows($sql) != 0)
    {
        includeLang('user');
        echo "<table border=1>";
        echo '<tr><td>'.$Lang['face'].'</td><td><center>'.$Lang['name'].'</center></td><td>'.$Lang['level'].'</td><td><center>'.$Lang['class'].'</center></td><td><center>'.$Lang['cp'].'</center></td><td><center>'.$Lang['hp'].'</center></td><td><center>'.$Lang['mp'].'</center></td><td><center>'.$Lang['clan'].'</center></td><td>'.$Lang['pvp_pk'].'</td><td><center>'.$Lang['online_time'].'</center></td><td>'.$Lang['online'].'</td><td>'.$Lang['unstuck'].'</td></tr>';
    while($char=mysql_fetch_assoc($sql))
    {
        $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
        if ($char['online']) {$online='<img src="img/online.png" />';} 
	else {$online='<img src="img/offline.png" />';} 
        $clanq=mysql_query("SELECT `clan_name` FROM `clan_data` WHERE `clan_id` = '$char[clanid]'");
        $clan = mysql_fetch_assoc($clanq);
        if(mysql_num_rows($clanq) == 0){
            $clanname= $Lang['no_clan'];
        }else{$clanname="<a href=\"index.php?id=claninfo&clan={$clan['clan_name']}\">{$clan['clan_name']}</a>";}
        echo "<tr><td><img src=\"./module/face/".$char['race']."_".$char['sex'].".gif\"></td><td><a href=index.php?id=user&cid={$char['charId']}><font color=\"$color\">$char[char_name]</font></a></td><td><center> $char[level]</center></td><td><center>$char[ClassName]</center></td><td><center>$char[maxCp]</center></td><td><center>$char[maxHp]</center></td><td><center>$char[maxMp]</center></td><td><center>$clanname</center></td><td><center><b>$char[pvpkills]</b>/<b><font color=red>$char[pkkills]</font></b></center></td><td><center>$onlinetimeH {$Lang['hours']} $onlinetimeM {$Lang['min']}.</center></td><td>$online</td><td><a href=\"index.php?id=unstuck&cid={$char['charId']}\">{$Lang['unstuck']}</a></td></tr>";
        
    }
    echo "</table>";
    } else {echo '<h1>'.$Lang['no_characters'].'</h1>';}
} else {echo '<h1>'.$Lang['login'].'</h1>';}

?>