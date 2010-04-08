<?php 
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Heroes");
$class_list=array(

    0=>"Fighter",1=>"Warrior",2=>"Gladiator",3=>"Warlord",4=>"Knight",5=>"Paladin",6=>"Dark Avenger",7=>"Rogue",

    8=>"Treasure Hunter",9=>"Hawkeye",10=>"Mage",11=>"Wizard",12=>"Sorcerer",13=>"Necromancer",14=>"Warlock",15=>"Cleric",

    16=>"Bishop",17=>"Prophet",18=>"Elven Fighter",19=>"Elven Knight",20=>"Temple Knight",21=>"Swordsinger",22=>"Elven Scout",23=>"Plains Walker",

    24=>"Silver Ranger",25=>"Elven Mage",26=>" Elven Wizard",27=>" Spellsinger",28=>"Elemental Summoner ",29=>"Oracle",

    30=>"Elder",31=>"Dark Fighter",32=>"Palus Knightr",33=>"Shillien Knight",34=>"Bladedancer",35=>"Assasin",36=>"Abyss Walker",

    37=>"Phantom Ranger",38=>"Dark Mage",39=>"Dark Wizard",40=>"Spellhowler",41=>"Phantom Summoner",42=>"Shillien Oracle",43=>"Shilien Elder",

    44=>"Orc Fighter",45=>"Orc Raider",46=>"Destroyer",47=>"Orc Monk",48=>"Tyrant",49=>"Orc Mage",50=>"Orc Shaman",51=>"Overlord",

    52=>"Warcryer",53=>"Dwarven Fighter",54=>"Scavenger",55=>"Bounty Hunter",56=>"Artisan", 57=> "Warsmith",

    88=>"Duelist",89=>"Dreadnought",90=>"Phoenix Knight",91=>"Hell Knight",92=>"Sagittarius",93=>"Adventurer",94=>"Archmage",95=>"Soultaker",

    96=>"Arcana Lord",97=>"Cardinal",98=>"Hierophant",99=>"Evas Templar",100=>"Sword Muse",101=>"Wind Rider",102=>"Moonlight Sentinel",

    103=>"Mystic Muse",104=>"Elemental Master",105=>"Evas Saint",106=>"Shillien Templar",107=>"Spectral Dancer",108=>"Ghost Hunter",

    109=>"Ghost Sentinel",110=>"Storm Screamer",111=>"Spectral Master",112=>"Shillien Saint",113=>"Titan",114=>"Grand Khavatari",

    115=>"Dominator",116=>"Doomcryer",117=>"Fortune Seeker",118=>"Maestro",

    123=>"Male Soldier",124=>"Female Soldier",125=>"Trooper",126=>"Warder",127=>"Berserker",

    128=>"Male Soulbreaker",129=>"Female Soulbreaker",130=>"Arbalester",131=>"Doombringer",

    132=>"Male Soulhound",133=>"Female Soulhound",134=>"Trickster",135=>"Inspector",136=>"Judicator"

);
?>
<table><tr bgcolor='333333' align='center'>
  <tr bgcolor='333333' align='center'>
  <td width='24%' align='left'><b>Name</b></td>
  <td width='24%' align='left'><b>Class</b></td>
  <td width='24%' align='left'><b>Clan</b></td>
  <td width='24%' align='left'><b>Alliance</b></td>
  <td width='4%' align='left'><b>Wins</b></td>
  </tr>
<?php
$sql = mysql_query("SELECT char_name,olympiad_nobles.class_id as 'class_id',clan_name as 'pname', ally_name as 'aname', clan_data.crest_id as 'pcrest',ally_crest_id as 'acrest',competitions_won as 'win_count'

FROM characters

LEFT JOIN clan_data ON clan_data.clan_Id = characters.clanId

INNER JOIN olympiad_nobles ON olympiad_nobles.charId = characters.charId

WHERE competitions_won > 0

ORDER BY class_id");

while($hero = mysql_fetch_array($sql))

{
    ?><tr bgcolor='000000' align='center'>

		<td align='left'><?php echo $hero['char_name'];?></td>

    <td align='left'><?php echo $class_list[$hero['class_id']];?></td>

    <td align='left'>
<?php

    if ($hero['pcrest'] != 0) echo "<img height='12' src='crest.php?clan_crest=".$hero['pcrest']."' /> ";

    echo $hero['pname']."</td><td align='left'>";

    if ($hero['acrest'] != 0) echo "<img height='12' src='crest.php?ally_crest=".$hero['acrest']."' /> ";

    echo $hero['aname']."</td><td align='left'>".$hero['win_count']."</td></tr>";
}
?>
</table>
<?php
 foot();
?>