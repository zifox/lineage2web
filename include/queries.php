<?php
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}
$q = array(
    0 => 'SELECT * FROM `{db}`.`config`;',
    1 => 'SELECT `ID`, `Name`, `DataBase` FROM `{db}`.`gameservers` WHERE `active` = \'true\'',
    2 => 'SELECT * FROM `{db}`.`gameservers` WHERE `active` = \'true\';',
    3 => 'SELECT * FROM `{db}`.`gameservers` INNER JOIN `{db}`.`gameserver_info` USING (`ID`) WHERE `active` = \'true\';',
    4 => 'SELECT `IP`, `Port`, `Password` FROM `{db}`.`telnet` WHERE `Server`=\'{server}\'',
    5 => 'SELECT * FROM `{db}`.`news` ORDER BY `date` DESC;',
    6 => 'SELECT * FROM `{db}`.`news` WHERE `news_id`={news_id};',
    7 => 'DELETE FROM `{db}`.`news` WHERE `news_id`={news_id};',
    8 => 'UPDATE `{db}`.`news` SET `name`=\'{name}\', `desc`=\'{desc}\', `edited`=\'{date}\', `edited_by`=\'{editor}\' WHERE `news_id`=\'{news_id}\';',
    9 => 'INSERT INTO `{db}`.`news` (`name`, `date`, `author`, `desc`, `image`) VALUES (\'{name}\', \'{date}\', \'{author}\', \'{desc}\', \'{image}\')',
    10 => 'UPDATE `{db}`.`cache` SET `recache`=\'1\' WHERE `page`=\'{page}\';',
    11 => 'SELECT * FROM `{webdb}`.`cache` WHERE `page`=\'{page}\' AND `params`=\'{params}\';',
    12 => 'INSERT INTO `{webdb}`.`cache` (`page`, `params`) VALUES (\'{page}\', \'{params}\');',
    13 => 'UPDATE `{webdb}`.`cache` SET `time`=\'{time}\', `recache`=\'0\' WHERE `id`=\'{id}\';',
    //PM
    30 => 'SELECT * FROM `{webdb}`.`messages` WHERE `receiver`=\'{account}\' AND `location`=\'{loc}\' ORDER BY `id` DESC',
    31 => 'SELECT * FROM `{webdb}`.`messages` WHERE `sender`=\'{account}\' AND saved=\'yes\' ORDER BY id DESC',
    32 => 'SELECT * FROM `{webdb}`.`messages` WHERE `id`=\'{pm_id}\' AND (`receiver`=\'{account}\' OR (`sender`=\'{account}\' AND `saved`=\'yes\')) LIMIT 1',
    33 => 'UPDATE `{webdb}`.`messages` SET `unread`=\'no\' WHERE `id`=\'{pm_id}\' AND `receiver`=\'{account}\' LIMIT 1',
    34 => 'SELECT * FROM `{webdb}`.`messages` WHERE `id`=\'{pm_id}\'',
    35 => 'DELETE FROM `{webdb}`.`messages` WHERE `id`=\'{pm_id}\'',
    36 => 'UPDATE `{webdb}`.`messages` SET `location`=\'0\' WHERE `id`=\'{pm_id}\'',
    37 => 'UPDATE `{webdb}`.`messages` SET `saved`=\'no\' WHERE `id`=\'{pm_id}\'',
    38 => 'UPDATE `{webdb}`.`messages` SET `unread` = \'no\', `location` = \'0\' WHERE `id`=\'{pm_id}\'',
    39 => '',
    40 => '',
    //PM
    100 => 'SELECT count(0) FROM `{db}`.`accounts`;',
    101 => 'SELECT `login` FROM `accounts` WHERE `login`=\'{login}\';',
    200 => 'SELECT `charId`, `char_name`, `sex` FROM `{db}`.`characters` WHERE `accesslevel`=\'0\'  ORDER BY `level` DESC, `pvpkills` DESC, `fame` DESC LIMIT {limit};',
    201 => 'SELECT count(0) FROM `{db}`.`clan_data`;',
    202 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `accessLevel`=\'0\';',
    203 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` != \'0\' AND `accesslevel`=\'0\';',
    204 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` != \'0\' AND `accesslevel`>\'0\';',
    205 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `sex` = \'{sex}\'',
    206 => 'SELECT count(0) FROM `{db}`.`seven_signs` WHERE `cabal` LIKE \'{cabal}\'',
    207 => 'SELECT `current_cycle`, `active_period`, `avarice_dawn_score`, `gnosis_dawn_score`, `strife_dawn_score`, `avarice_dusk_score`, `gnosis_dusk_score`, `strife_dusk_score`, `avarice_owner`, `gnosis_owner`, `strife_owner` FROM `{db}`.`seven_signs_status`',
    208 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `race` = \'{race}\'',
    209 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`=\'0\' AND `race`=\'{race}\' ORDER BY `exp` DESC LIMIT {limit}, {rows}',
    210 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `{order}`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`=\'0\' ORDER BY `{order}` DESC LIMIT {limit}, {rows}',
    211 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`,  `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`=\'0\' AND `{order}`>\'0\' ORDER BY `{order}` DESC LIMIT {limit}, {rows}',
    212 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `accesslevel`>\'0\';',
    213 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `accesslevel`=\'0\' AND `{order}`>\'0\'',
    214 => 'SELECT count(0) FROM `{db}`.`characters`, `{db}`.`items`  WHERE `accesslevel`=\'0\' AND `characters`.`charId`=`items`.`owner_id` AND `items`.`item_id`=\'{item}\'',
    215 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`,  `count`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`items` ON `characters`.`charId`=`items`.`owner_id` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `items`.`item_id`=\'{item}\' AND `accesslevel`=\'0\' ORDER BY `count` DESC LIMIT {limit}, {rows}',
    216 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`>\'0\' LIMIT {limit}, {rows}',
    217 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online`!=\'0\' AND `accesslevel`=\'0\' ORDER BY `exp` DESC LIMIT {limit}, {rows}',
    218 => 'SELECT `charId`, `char_name`, `level`, `sex`, `pvpkills`, `pkkills`, `race`, `online`, `ClassName`, `clanid`, `clan_name` FROM `{db}`.`characters` INNER JOIN `{db}`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` LEFT OUTER JOIN `{db}`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `accesslevel`=\'0\' ORDER BY `exp` DESC LIMIT {limit}, {rows}',
    219 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` = \'1\' AND `accesslevel`=\'0\';',
    220 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` = \'2\' AND `accesslevel`=\'0\';',
    300 => "SELECT items.object_id,items.item_id,items.count,items.enchant_level,items.loc, 
			CASE WHEN armor.name != '' THEN armor.name 
			WHEN weapon.name != '' THEN weapon.name 
			WHEN etcitem.name != '' THEN etcitem.name 
			END AS name, 
			CASE WHEN armor.crystal_type != '' THEN 'armor' 
			WHEN weapon.crystal_type != '' THEN 'weapon' 
			WHEN etcitem.crystal_type != '' THEN 'etc' 
			END AS `type` 
		FROM `{db}`.`items` 
		LEFT JOIN `armor` ON armor.item_id = items.item_id 
		LEFT JOIN weapon ON weapon.item_id = items .item_id 
		LEFT JOIN etcitem ON etcitem.item_id = items.item_id 
		WHERE items.owner_id='{charID}' 
		ORDER BY {order}",
    301 => "SELECT items.object_id,items.item_id,items.count,items.enchant_level,items.loc,items.loc_data,armorName,weaponName,etcName,armorType,weaponType,etcType
		FROM `{db}`.`items` 
		LEFT JOIN (
			SELECT item_id, name AS armorName, crystal_type AS armorType 
			FROM `armor`
			) AS aa ON aa.item_id = items.item_id 
		LEFT JOIN (
			SELECT item_id, name AS weaponName, crystal_type AS weaponType 
			FROM `weapon`
			) AS ww ON ww.item_id = items.item_id
		LEFT JOIN (
			SELECT item_id, name AS etcName, crystal_type AS etcType 
			FROM `etcitem`
			) AS ee ON ee.item_id = items.item_id
		WHERE items.owner_id='{charID}' AND items.loc='{loc}' 
		ORDER BY items.loc_data",
        
        
        
            302 => "SELECT `items`.`item_id`, `items`.`count`, `items`.`enchant_level`, `items`.`loc`, `items`.`loc_data`, `all`.`name`, `all`.`addname`, `all`.`grade`, `all`.`desc`, `all`.`set_bonus`, `all`.`set_extra_desc`, `all`.`icon`
		FROM `{db}`.`items` 
		LEFT JOIN (
			SELECT `all_items`.`id`, `all_items`.`name`, `all_items`.`addname`, `all_items`.`grade`,`all_items`.`icon1`, `all_items`.`desc`, `all_items`.`set_bonus`, `all_items`.`set_extra_desc` FROM `{webdb}`.`all_items`
			) AS `all` ON `all`.`id` = `items`.`item_id`  
		WHERE `items`.`owner_id`='{charID}' AND `items`.`loc`='{loc}' 
		ORDER BY `items`.`loc_data`",
/*    666 => Array(
        0	=> "dress",
        1	=> "leftearring", //helm
		2	=> "rightearring", //righthair
		4	=> "necklace",
		5	=> "leftring", //weapon
		6	=> "rightring", //top
		8	=> "helmet", //leftearing
		9	=> "weapon",
		10	=> "shield", //gloves
		11	=> "gloves", //lower
		12	=> "top", //shoes
		13	=> "lower",
		14	=> "bots",
        15  => "cloak", //ring
		16	=> "weapon", //bracelet
        18  => "", //shield?
		21	=> "righthair",
		22	=> "braslet",
		23	=> "ring",
		30	=> "cloak"
    ),*/
        666 => Array(
        0	=> "dress",
        1	=> "helmet",
		2	=> "leftthair",
        3   => "righthair",
		4	=> "necklace",
		5	=> "weapon",
		6	=> "top",
        7   => "shield",
		8	=> "rightearring",
		9	=> "leftearring",
		10	=> "gloves",
		11	=> "lower",
		12	=> "bots",
		13	=> "rightring",
		14	=> "leftring",
        15  => "ring",
		16	=> "braslet",
        17  => "deco1",
        18  => "deco2",
        19  => "deco3",
        20  => "deco4",
        21  => "deco5",
        22  => "deco6",
        23  => "cloak",
        24  => "belt",
        25  => "total"
    ),

    667 => "SELECT `items`.`item_id`, `items`.`count`, `items`.`enchant_level`, `items`.`loc`, `items`.`loc_data` FROM `{db}`.`items` WHERE `items`.`owner_id`='{charID}' AND `items`.`loc`='{loc}' ORDER BY `items`.`loc_data`",
    668 => "SELECT `name`, `addname`, `grade`, `icon1`, `icon2`, `icon3`, `desc` FROM `{webdb}`.`all_items` WHERE `id`='{itemid}'",
    669 => "INSERT INTO `{webdb}`.`config` (`name`, `type`, `value`) VALUES ('{name}', '{type}', '{val}');",
    670 => "UPDATE `{webdb}`.`config` SET `name`='{name}', `type`='{type}', `value`='{val}' WHERE (`name`='{name}') AND (`type`='{type}') LIMIT 1;",
    671 => "SELECT * FROM `{webdb}`.`config` WHERE (`name`='{name}') AND (`type`='{type}');"
);
//Cleanup queries
$clean=array(
    0=>'TRUNCATE TABLE `{webdb}`.`{table}`;',
    1=>''

);
?>