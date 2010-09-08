<?php
//пароль
if(!defined('INLANG')){Header("Location: ../../index.php");}

#Titles
$Lang['statistic'] = 'Statistika';
$Lang['head_online'] = 'Lietotāji tiešsaistē';
$Lang['head_castles'] = 'Pilis';
$Lang['head_fort'] = 'Cietoksnis';
$Lang['head_clantop'] = 'Top Klani';
$Lang['head_gm'] = 'Servera GMi';
$Lang['head_count'] = 'Bagātākie Spēlētāji';
$Lang['head_top_pvp'] = 'Top PvP';
$Lang['head_top_pk'] = 'Top Spēlētāju Slepkavas';
$Lang['head_maxCp'] = 'Augstākais Combat Punktu daudzums';
$Lang['head_maxHp'] = 'Augstākais Hit Punktu daudzums';
$Lang['head_maxMp'] = 'Augstākais Mana Punktu daudzums';
$Lang['head_top'] = 'Top '. $Config['TOP'];
$Lang['head_human'] = 'Top Cilvēki';
$Lang['head_elf'] = 'Top Elfi';
$Lang['head_dark_elf'] = 'Top Tumšie Elfi';
$Lang['head_orc'] = 'Top Orki';
$Lang['head_dwarf'] = 'Top Rūķi';
$Lang['head_kamael'] = 'Top Kamaeli';

#Menu
$Lang['server_stat'] = 'Servera Statistika';
$Lang['home'] = 'Sākums';
$Lang['seven_signs'] = 'Septiņas Zīmes';
$Lang['online'] = 'Tiešsaistē';
$Lang['map'] = 'Karte';
$Lang['castles_map'] = 'Piļu Karte';
$Lang['castles'] = 'Pilis';
$Lang['fort'] = 'Cietokšņi';
$Lang['top_clans'] = 'Top Klani';
$Lang['gm'] = 'GMi';
$Lang['rich_players'] = 'Bagātākie Spēlētāji';
$Lang['adena'] = 'Adena';
$Lang['pvp'] = 'PvP';
$Lang['pk'] = 'PK';
$Lang['cp'] = 'CP';
$Lang['hp'] = 'HP';
$Lang['mp'] = 'MP';
$Lang['top'] = 'TOP';
$Lang['race'] = array(
	0 => "Cilvēki",
	1 => "Elfi",
	2 => "Tumšie Elfi",
	3 => "Orki",
	4 => "Rūķi",
	5 => "Kamaeli"
);

#Table
$Lang['max_cp'] = 'Max CP';
$Lang['max_hp'] = 'Max HP';
$Lang['max_mp'] = 'Max MP';
$Lang["clantop_total"] = 'Kopā Klani';
$Lang['no_clan'] = 'Nav Klans';
$Lang['castle_of'] = '%s Pils';
$Lang['fort_of'] = '%s Cietoksnis';
$Lang['next_siege'] = 'Nākošais Aplenkums: ';
$Lang['castle'] = 'Pils';
$Lang['details'] = 'Detaļas';
$Lang['owner_clan'] = 'Īpašnieku Klans:';
$Lang['no_owner'] = 'Nav Īpašnieks';
$Lang['lord'] = 'Valdnieks:';
$Lang['no_lord'] = 'Nav Valdnieka';
$Lang['tax'] = 'Nodoklis:';
$Lang['attackers'] = 'Uzbrucēji:';
$Lang['defenders'] = 'Sargātāji:';
$Lang['npc'] = 'NPC';
$Lang['male'] = 'Vīrietis';
$Lang['female'] ='Sieviete';
$Lang['players_dusk'] = 'Krēslas Spēlētāji';
$Lang['players_dawn'] = 'Rītausmas Spēlētāji';
$Lang['time_held'] = 'Tur';
$Lang['hour'] = 'Stundas';

$Lang['ward'] = array(
	81 => 'Ward1',
	82 => 'Ward2',
	83 => 'Ward3',
	84 => 'Ward4',
	85 => 'Ward5',
	86 => 'Ward6',
	87 => 'Ward7',
	88 => 'Ward8',
	89 => 'Ward9'
);
$Lang['ward_info'] = array(
	81 => 'Gludio Ward   |   STR +1 / INT +1',
	82 => 'Dion Ward   |   DEX +1 / WIT +1',
	83 => 'Giran Ward   |   STR +1 / MEN +1',
	84 => 'Oren Ward   |   CON +1 / MEN +1',
	85 => 'Aden Ward   |   DEX +1 / MEN +1',
	86 => 'Innadril Ward   |   CON +1 / INT +1',
	87 => 'Goddard Ward   |   DEX +1 / INT +1',
	88 => 'Rune Ward   |   STR +1 / WIT +1',
	89 => 'Schuttgart Ward   |   CON +1 / WIT +1'
);
?>