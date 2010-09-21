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
    9 => 'INSERT INTO `{db}`.`news` (`name`, `date`, `author`, `desc`) VALUES (\'{name}\', \'{date}\', \'{author}\', \'{desc}\')',
    100 => 'SELECT count(0) FROM `{db}`.`accounts`;',
    101 => '',
    200 => 'SELECT `charId`, `char_name`, `sex` FROM `{db}`.`characters` WHERE `accesslevel`=\'0\'  ORDER BY `exp` DESC LIMIT {limit};',
    201 => 'SELECT count(0) FROM `{db}`.`clan_data`;',
    202 => 'SELECT count(0) FROM `{db}`.`characters`;',
    203 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` = \'1\' AND `accesslevel`=\'0\';',
    204 => 'SELECT count(0) FROM `{db}`.`characters` WHERE `online` = \'1\' AND `accesslevel`>\'0\';',
    205 => '',
    206 => 'SELECT count(0) FROM `{db}`.`seven_signs` WHERE `cabal` LIKE \'{{limit}}\'',
    207 => 'SELECT `current_cycle`, `active_period`, `avarice_dawn_score`, `gnosis_dawn_score`, `strife_dawn_score`, `avarice_dusk_score`, `gnosis_dusk_score`, `strife_dusk_score`, `avarice_owner`, `gnosis_owner`, `strife_owner` FROM `{db}`.`seven_signs_status`',
    208 => '',
    209 => '',
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
			SELECT `all_items`.`id`, `all_items`.`name`, `all_items`.`addname`, `all_items`.`grade`,`all_items`.`icon`, `all_items`.`desc`, `all_items`.`set_bonus`, `all_items`.`set_extra_desc` FROM `{webdb}`.`all_items`
			) AS `all` ON `all`.`id` = `items`.`item_id`  
		WHERE `items`.`owner_id`='{charID}' AND `items`.`loc`='{loc}' 
		ORDER BY `items`.`loc_data`",
    666 => Array(
        0	=> "dress",
        1	=> "leftearring",
		2	=> "rightearring",
		4	=> "necklace",
		5	=> "leftring",
		6	=> "rightring",
		8	=> "helmet",
		9	=> "weapon",
		10	=> "shield",
		11	=> "gloves",
		12	=> "top",
		13	=> "lower",
		14	=> "bots",
        15  => "cloak", //cloak
		16	=> "weapon", //two handed
        18  => "",
		21	=> "righthair",
		22	=> "braslet",
		23	=> "ring",
		30	=> "cloak"
    ),
    667 => "SELECT `items`.`item_id`, `items`.`count`, `items`.`enchant_level`, `items`.`loc`, `items`.`loc_data`
		FROM `{db}`.`items` 
		WHERE `items`.`owner_id`='{charID}' AND `items`.`loc`='{loc}' 
		ORDER BY `items`.`loc_data`",
    668 => "SELECT `name`, `addname`, `grade`, `icon`, `desc`, `set_bonus`, `set_extra_desc` FROM `{webdb}`.`all_items` 
		WHERE `id`='{itemid}'"
);
?>