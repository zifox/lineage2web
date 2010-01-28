<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['clan'])){
    $clanid=0+$_GET['clan'];  
    $query=mysql_query('SELECT `clan_id`, `clan_name`, `clan_level`, `reputation_score`, `charId`, `char_name` FROM `clan_data` INNER JOIN `characters` ON `clan_data`.`leader_id`=`characters`.`charId` WHERE `clan_id`='.$clanid);
    if(mysql_num_rows($query))
    {
        includeLang('clan_info');
        head($Lang['clan_info']);
        $clan_data=mysql_fetch_assoc($query);
        ?>
        <div align="left">
        <table border="0">
        <tr><td><?php echo $Lang['clan'];?>: </td><td><?php echo $clan_data['clan_name'];?></td></tr>
        <tr><td><?php echo $Lang['leader'];?>: </td><td><a href="user.php?cid=<?php echo $clan_data['charId'];?>"><?php echo $clan_data['char_name'];?></a></td></tr>
        <tr><td><?php echo $Lang['lvl'];?>: </td><td><?php echo $clan_data['clan_level'];?></td></tr>
        <tr><td><?php echo $Lang['rep'];?>: </td><td><?php echo $clan_data['reputation_score'];?></td></tr>
        </table>
        </div>
        <div align="center"><h1><?php echo $Lang['clan_members'];?></h1>
        <table border="1" align="center"><thead><th><?php echo $Lang['nr'];?></th><th><?php echo $Lang['name'];?></th><th><?php echo $Lang['sex'];?></th><th><?php echo $Lang['class'];?></th><th><?php echo $Lang['pvp_pk'];?></th></thead>
        <tbody>
        <?php
        $query=mysql_query('SELECT `charId`, `char_name`, `sex`, `pvpkills`, `pkkills`, `ClassName` FROM `characters` INNER JOIN `char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId`  WHERE `clanid`='.$clan_data['clan_id'].' AND charId!='.$clan_data['charId'].' ORDER BY `pvpkills` DESC');
        $i=0;
        while($clan_char=mysql_fetch_assoc($query))
        {
            $i++;
            ?>
            <tr><td><?php echo $i;?></td><td><a href="user.php?cid=<?php echo $clan_char['charId'];?>"><?php echo $clan_char['char_name'];?></a></td><td><?php ($clan_char['sex']==0)? '<img src="img/stat/sex.jpg" alt="'.$Lang['male'].'" />':'<img src="img/stat/sex1.jpg" alt="'.$Lang['female'].'" />';?></td><td><?php echo $clan_char['ClassName'];?></td><td><?php echo $clan_char['pvpkills'].' / '.$clan_char['pkkills'];?></td></tr>
            <?php
        }
        unset($i);
        unset($clan_char);
        unset($query);
        ?>
        </tbody>
        </table>
        </div>
        <?php
        foot();
    }else
    {
        header('Location:index.php');
    }
}else{
    header('Location:index.php');
}
?>