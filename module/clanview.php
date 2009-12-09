<?php
include("module/stat-menu.php");
?> 
<center><br><b>..:: Clan ::..</b><br><br><hr></center>
<?php
  $result = mysql_query("SELECT clan_data.*,char_name FROM clan_data,characters WHERE clan_name='".@mysql_escape_string($_REQUEST["clan_name"])."' AND leader_id=obj_Id", $link)
    or die ("Error: ".mysql_error());
$show=mysql_fetch_array($result);
$result = mysql_query("SELECT characters.*,classname FROM characters,char_templates WHERE clanid='".$show['clan_id']."' AND char_templates.ClassId=characters.classid AND clanid ORDER BY exp DESC", $link)
    or die ("Error: ".mysql_error());
    
  switch ($show["hasCastle"])
  {
    case 1: $show["hasCastle"]=$L2JBS_lang["clantop_gludiocastle"]; break;
    case 2: $show["hasCastle"]=$L2JBS_lang["clantop_dioncastle"]; break;
    case 3: $show["hasCastle"]=$L2JBS_lang["clantop_girancastle"]; break;
    case 4: $show["hasCastle"]=$L2JBS_lang["clantop_orencastle"]; break;
    case 5: $show["hasCastle"]=$L2JBS_lang["clantop_adencastle"]; break;
    case 6: $show["hasCastle"]=$L2JBS_lang["clantop_innadrilcastle"]; break;
    default: $show["hasCastle"]=$L2JBS_lang["clantop_nocastle"];
  }

  @eval('print "<table>\n<caption>".'.$L2JBS_lang["clanview_captiontemplate"].'."</caption>";');
  include("module/_table.php");
?>
