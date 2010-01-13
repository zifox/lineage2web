<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Clans");
include("module/stat-menu.php");
includeLang('module');

  $result = mysql_query("SELECT clan_data.*,char_name,csum,ccount,cavg FROM clan_data INNER JOIN characters ON clan_data.leader_id=characters.charId LEFT JOIN (SELECT clanid, SUM(level) AS csum, count(level) AS ccount, AVG(level) AS cavg FROM characters WHERE clanid GROUP BY clanid) AS levels ON clan_data.clan_id=levels.clanid WHERE !accessLevel ORDER BY clan_level DESC, csum DESC");

	echo '<h1> TOP Clans </h1><hr>';
    echo '<h2>'.$Lang["clantop_total"].': '.mysql_num_rows($result).'</h2>';
	echo '<table border=1><thead><tr style="color: green;"><th><b>Clan Name</b></th>
<th><b>Leader</b></th>
<th><b>Level</b></th>
<th><b>Castle</b></th>
<th><b>Total Level</b></th>
<th><b>Members</b></th>
<th><b>Avg. of Levels</b></th>
</tr></thead>';

  $i=1;
  while ($row=mysql_fetch_array($result))
  {
    switch ($row["hasCastle"])
    {
      case 1: $row["hasCastle"]="Gludio"; break;
      case 2: $row["hasCastle"]="Dion"; break;
      case 3: $row["hasCastle"]="Giran"; break;
      case 4: $row["hasCastle"]="Oren"; break;
      case 5: $row["hasCastle"]="Aden"; break;
      case 6: $row["hasCastle"]="Innadril"; break;
      default: $row["hasCastle"]="No castle";
    }
    print "<tr". (($i++ % 2) ? "" : " class=\"altRow\"") ."><td><a href=\"claninfo.php?clan=". $row["clan_name"]."\">". htmlspecialchars($row["clan_name"]). "</a></td><td><a href=\"user.php?cid={$row['leader_id']}\">". $row["char_name"]. "</a></td><td class=\"numeric sortedColumn\">".$row["clan_level"]. "</td><td>".$row["hasCastle"]. "</td><td class=\"numeric\">".$row["csum"]. "</td><td class=\"numeric\">".$row["ccount"]. "</td><td class=\"numeric\">".$row["cavg"]. "</td></tr>\n";
  }
  print "</tbody>\n</table>\n";
 foot();
mysql_close($link);
?>