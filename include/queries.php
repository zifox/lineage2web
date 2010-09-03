<?php
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}
$q = array(
    0 => 'SELECT * FROM `{{table}}`.`config`;',
    1 => 'SELECT `ID`, `Name`, `DataBase` FROM `{{table}}`.`gameservers` WHERE `active` = \'true\'',
    2 => 'SELECT * FROM `{{table}}`.`gameservers` WHERE `active` = \'true\';',
    3 => 'SELECT * FROM `{{table}}`.`gameservers` INNER JOIN `{{table}}`.`gameserver_info` USING (`ID`) WHERE `active` = \'true\';',
    4 => '',
    5 => '',
    6 => '',
    7 => '',
    8 => '',
    9 => '',
    100 => 'SELECT count(0) FROM `accounts`;',
    101 => '',
    102 => '',
    103 => '',
    104 => '',
    105 => '',
    106 => '',
    107 => '',
    108 => '',
    109 => '',
    200 => 'SELECT `charId`, `char_name`, `sex` FROM `{{table}}`.`characters` WHERE `accesslevel`=\'0\'  ORDER BY `exp` DESC LIMIT {{limit}};',
    201 => 'SELECT count(0) FROM `{{table}}`.`clan_data`;',
    202 => 'SELECT count(0) FROM `{{table}}`.`characters`;',
    203 => 'SELECT count(0) FROM `{{table}}`.`characters` WHERE `online` = \'1\' AND `accesslevel`=\'0\';',
    204 => 'SELECT count(0) FROM `{{table}}`.`characters` WHERE `online` = \'1\' AND `accesslevel`>\'0\';',
    205 => '',
    206 => 'SELECT count(0) FROM `{{table}}`.`seven_signs` WHERE `cabal` LIKE \'{{limit}}\'',
    207 => 'SELECT `current_cycle`, `active_period`, `avarice_dawn_score`, `gnosis_dawn_score`, `strife_dawn_score`, `avarice_dusk_score`, `gnosis_dusk_score`, `strife_dusk_score`, `avarice_owner`, `gnosis_owner`, `strife_owner` FROM `{{table}}`.`seven_signs_status`',
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
		FROM `{database}`.`items` 
		LEFT JOIN `armor` ON armor.item_id = items.item_id 
		LEFT JOIN weapon ON weapon.item_id = items .item_id 
		LEFT JOIN etcitem ON etcitem.item_id = items.item_id 
		WHERE items.owner_id='{charID}' 
		ORDER BY {order}",
    301 => "SELECT items.object_id,items.item_id,items.count,items.enchant_level,items.loc,items.loc_data,armorName,weaponName,etcName,armorType,weaponType,etcType
		FROM `{database}`.`items` 
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
		16	=> "weapon", //two handed
		21	=> "righthair",
		22	=> "braslet",
		23	=> "ring",
		30	=> "cloak"
    )
);
?>