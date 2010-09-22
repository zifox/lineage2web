<?php
define('INWEB', True);
require_once("include/config.php");
//пароль

function CountFormat($num)
{
    return $num>1?" (" . number_format($num, 0, ".", ",") . ")":"";
}
includeLang('user');
if ($_GET['cid'] && is_numeric($_GET['cid']))
{
    if(is_int(0+$_GET['cid'])){
    $id=0+$_GET['cid'];}else{header('Location: index.php'); die();}

    $srv = $mysql->escape(0 + $_GET['server']);
//  if($srv == null || !is_int($srv) || $srv == ''){//$srv=$Config['DDB'];
//  }
    $dbname = getDBName($srv);

    $sql=$mysql->query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `pvpkills`, `pkkills`, `race`, `characters`.`classid`, `base_class`, `online`, `ClassName`, `clan_id`, `clan_name` FROM `$dbname`.`characters` INNER JOIN `$dbname`.`char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `$dbname`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `characters`.`charId` = '$id'");

    if($mysql->num_rows($sql)!= 0){
        $char=$mysql->fetch_array($sql);
        head("User {$char['char_name']} Info");
        $page='user';
        $par['lang']=getLang();
        $par['id']=$char['charId'];
        $sec=86400;
        $params = implode(';', $par);
        if($cache->needUpdate($page, $params, $sec))
        {
            $parse=$Lang;
            $char['sex']==0?$parse['color']='#8080FF':$parse['color']='#FF8080';
            $parse['c_race'] = $char['race'];
            $parse['c_sex'] = $char['sex'];
    
            $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
            $onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
            if ($char['clan_id']) {$parse['clan_link'] = "<a href=\"claninfo.php?clan={$char['clan_id']}&amp;server=$srv\">{$char['clan_name']}</a>";}else{$parse['clan_link'] = "No Clan";}
            if ($char['online']) {
                $parse['onoff']='on'; } 
            else {
                $parse['online']=$Lang['offline']; 
                $parse['onoff']='off';
            } 
            $parse['c_level'] = $char['level'];
            $parse['maxCp']=$char['maxCp'];
            $parse['maxHp']=$char['maxHp'];
            $parse['maxMp']=$char['maxMp'];
            $parse['ClassName']=$char['ClassName'];
            $parse['pvpkills']=$char['pvpkills'];
            $parse['pkkills']=$char['pkkills'];

    /*$skill_list = $mysql->query("SELECT * FROM `$dbname`.`character_skills` WHERE `charId`='$id' AND `class_index`='0'");
    $i=0;
    while($skill=$mysql->fetch_array($skill_list))
    {
        echo ($i==0)? '<tr>':'';
        $skill_id=($skill[skill_id]<1000)? '0'.$skill[skill_id]:$skill[skill_id];
        echo '<td><img src="img/skills/skill'.$skill_id .'.png" /></td>';
        if($i==4)
        {
            echo '</tr>';
            $i=0;
        }
        else
        {
            $i++;
        }
    }*/
            $query_paperdoll = $mysql->query($q[667], array("db" => $dbname, "charID" => $id, "loc" => "PAPERDOLL"));
            $parse['eq_items'] ='';
            while ($paperdoll_data = $mysql->fetch_array($query_paperdoll))
            {
                $qry=$mysql->query($q[668], array("webdb" => $webdb, "itemid" => $paperdoll_data['item_id']));
                $item=$mysql->fetch_array($qry);
                $name = $item["name"];
                $name = str_replace("'", "\\'", $name);
                $addname = $item["addname"];
                $addname = $addname!=''?' - &lt;font color=#333333>'. str_replace("'", "\\'", $addname).'&lt;/font>':'';
                $desc = htmlentities($item["desc"]);
                $specdesc = $item["specdesc"];
                $set = $item["set_bonus"];
                $set_extra = $item["set_extra_desc"];
                $desc = str_replace("'", "\\'", $desc);
                $grade = $item["grade"];
                $grade = (!empty($grade) || $grade!="none") ? "&lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />" : "";
                $enchant = $item["enchant_level"] > 0 ? " +" . $item["enchant_level"] : "";
                $img = (is_file('img/iconsall/'.$item["icon"].'.png')) ? $item["icon"] : "blank";
                $type = $q[666][$paperdoll_data["loc_data"]];
        
                $parse['eq_items'] .= "<div style='position: absolute; width: 32px; height: 32px; padding: 0px;' class='{$type}'><img border='0' src='img/iconsall/$img.png' onmouseover=\"Tip('{$name} {$addname} {$grade} {$enchant}&lt;br /> {$desc}&lt;br /> {$specdesc}&lt;br /> {$set}&lt;br /> {$set_extra}', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" alt=\"\" /></div>";
                        
            }
    
            $query = $mysql->query($q[667], array("db" => $dbname, "charID" => $id, "loc" => "INVENTORY"));
            $parse['inv_items'] = '';
            while ($inv_data = $mysql->fetch_array($query))
            {
                $qry=$mysql->query($q[668], array("webdb" => $webdb, "itemid" => $inv_data['item_id']));
                $item=$mysql->fetch_array($qry);
                $name = $item["name"];
                $name = str_replace("'", "\\'", $name);
                $addname = $item["addname"];
                $addname = ' - &lt;font color="#333333">'. str_replace("'", "\\'", $addname).'&lt;/font>';
                $desc = htmlentities($item["desc"]);
                $specdesc = $item["specdesc"];
                $set = $item["set_bonus"];
                $set_extra = $item["set_extra_desc"];
                $desc = str_replace("'", "\\'", $desc);

                $grade = $item["grade"];
                $grade = (!empty($grade) || $grade!="none") ? "&lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />" : "";
                $enchant = $item["enchant_level"] > 0 ? " +" . $item["enchant_level"] : "";
                $count = CountFormat($item["count"]);
                $img = (is_file('img/iconsall/'.$item["icon"].'.png')) ? $item["icon"] : "blank";
                $parse['inv_items'] .= "<img class='floated' border='0' src=\"img/iconsall/{$img}.png\" onmouseover=\"Tip('{$name} {$count} {$grade} {$enchant}&lt;br /> {$desc}', FONTCOLOR, '#333333',BGCOLOR, '#FFFFFF', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" alt=\"\" />";
            }

            $dbq = $mysql->query("SELECT `ID`, `Name`, `DataBase` FROM `$webdb`.`gameservers` WHERE `active` = 'true'");
            $parse['charlist'] = '';
            while($dbs = $mysql->fetch_array($dbq))
            {
                $dbn = $dbs['DataBase'];
        
                $sql2=$mysql->query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `pvpkills`, `pkkills`, `clanid`, `race`, `characters`.`classid`, `base_class`, `online`, `ClassName`, clan_id, clan_name FROM `$dbn`.`characters` LEFT OUTER JOIN `$dbn`.`char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `$dbn`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `characters`.`charId` != '{$char['charId']}' AND `account_name` = '{$char['account_name']}' ORDER by `characters`.`level` ASC");
                if ($mysql->num_rows($sql2)){
                    $oparse=$Lang;
                    $oparse['Name'] = $dbs['Name'];
                    $oparse['char_rows'] = '';
                    while ($otherchar=$mysql->fetch_array($sql2))
                    {

                        if ($otherchar['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$otherchar['clan_id']}&amp;server={$dbs['ID']}\">{$otherchar['clan_name']}</a>";}else{$clan_link = $Lang['no_clan'];}
                        $otherchar['sex']==0?$color='#8080FF':$color='#FF8080';

                        $otherchar['online']?$online='<img src="img/online.png" alt="'.$Lang['online'].'" />':$online='<img src="img/status/offline.png" alt="'.$Lang['offline'].'"/>';
                        $oparse['char_rows'].="<tr><td><img src=\"img/face/{$otherchar['race']}_{$otherchar['sex']}.gif\" alt=\"\" /></td><td><a href=\"user.php?cid={$otherchar['charId']}&amp;server={$dbs['ID']}\"><font color=\"$color\">{$otherchar['char_name']}</font></a></td><td align=\"center\">{$otherchar['level']}</td><td align=\"center\">{$otherchar['ClassName']}</td><td class=\"maxCp\" align=\"center\">{$otherchar['maxCp']}</td><td class=\"maxHp\" align=\"center\">{$otherchar['maxHp']}</td><td class=\"maxMp\" align=\"center\">{$otherchar['maxMp']}</td><td align=\"center\">{$clan_link}</td><td align=\"center\"><b>{$otherchar['pvpkills']}</b>/<b><font color=\"red\">{$otherchar['pkkills']}</font></b></td><td>{$online}</td></tr>";
                        $parse['charlist'].=$tpl->parsetemplate('user_other', $oparse, 1);
                    }
                }//$mysql->num_rows(other chars)
            }//while
            $content = $tpl->parsetemplate('user', $parse, 1);
            $cache->updateCache($page, $params, $content);
            echo $content;
        }
        else
        {
            echo $cache->getCache($page, $params);
        } //cache  
    }//$mysql->num_rows(main user)
    else
    {
        head($Lang['not_found']);
        echo msg('Error',$Lang['not_found'], 'error', false);
    }
}
else
{
    head($Lang['not_found']);
    echo msg('Error',$Lang['not_found'], 'error', false);
}

foot();
?>