<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['clan'])){
    $clanid=0+$_GET['clan'];  
    $srv=0+$_GET['server'];
    $dbname = getDBName($srv);
    $query=$mysql->query('SELECT `clan_id`, `clan_name`, `clan_level`, `reputation_score`, `charId`, `char_name` FROM `'.$dbname.'`.`clan_data` INNER JOIN `'.$dbname.'`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` WHERE `clan_id`='.$clanid);
    if($mysql->num_rows($query))
    {
        includeLang('clan_info');
        head($Lang['clan_info']);
        $clan_data=$mysql->fetch_array($query);
        ?>
        <div align="left">
        <table border="0">
        <tr><td><?php echo $Lang['clan'];?>: </td><td><?php echo $clan_data['clan_name'];?></td></tr>
        <tr><td><?php echo $Lang['leader'];?>: </td><td><a href="user.php?cid=<?php echo $clan_data['charId'];?>&amp;server=<?php echo $srv;?>"><?php echo $clan_data['char_name'];?></a></td></tr>
        <tr><td><?php echo $Lang['lvl'];?>: </td><td><?php echo $clan_data['clan_level'];?></td></tr>
        <tr><td><?php echo $Lang['rep'];?>: </td><td><?php echo $clan_data['reputation_score'];?></td></tr>
        </table>
        </div>
        <div align="center"><h1><?php echo $Lang['clan_members'];?></h1>
        <table border="1" align="center"><thead><tr><th><?php echo $Lang['nr'];?></th><th><?php echo $Lang['name'];?></th><th><?php echo $Lang['sex'];?></th><th><?php echo $Lang['class'];?></th><th><?php echo $Lang['pvp_pk'];?></th></tr></thead>
        <tbody>
        <?php
        $query=$mysql->query('SELECT `charId`, `char_name`, `sex`, `pvpkills`, `pkkills`, `ClassName` FROM `'.$dbname.'`.`characters` INNER JOIN `'.$dbname.'`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId`  WHERE `clanid`='.$clan_data['clan_id'].' AND charId!='.$clan_data['charId'].' ORDER BY `pvpkills` DESC');
        $i=0;
        while($clan_char=$mysql->fetch_array($query))
        {
            $i++;
            ?>
            <tr><td><?php echo $i;?></td><td><a href="user.php?cid=<?php echo $clan_char['charId'];?>&amp;server=<?php echo $srv;?>"><?php echo $clan_char['char_name'];?></a></td><td><?php echo ($clan_char['sex']==0)? '<img src="img/stat/sex.jpg" alt="'.$Lang['male'].'" />':'<img src="img/stat/sex1.jpg" alt="'.$Lang['female'].'" />';?></td><td><?php echo $clan_char['ClassName'];?></td><td><?php echo $clan_char['pvpkills'].' / '.$clan_char['pkkills'];?></td></tr>
            <?php
        }
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