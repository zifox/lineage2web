<?php
include("module/stat-menu.php");
includeLang('module');
  $result = mysql_query("SELECT clan_data.*,char_name,csum,ccount,cavg FROM clan_data INNER JOIN characters ON clan_data.leader_id=characters.charId LEFT JOIN (SELECT clanid, SUM(level) AS csum, count(level) AS ccount, AVG(level) AS cavg FROM characters WHERE clanid GROUP BY clanid) AS levels ON clan_data.clan_id=levels.clanid WHERE accesslevel < 50 ORDER BY clan_level DESC, csum DESC");

	echo '<br><center><b>..:: GameMasters List ::..</b></center><br><hr>';
	echo '<table border=1><tr><td><b>Clan Name</b></td>
<td><b>Leader</b></td>
<td><b>Level</b></td>
<td><b>Castle</b></td>
<td><b>Total Level</b></td>
<td><b>Members</b></td>
<td><b>Avg. of Levels</b></td>
</tr>
<tr><td colspan="7" style="text-align: center;">'.$Lang["clantop_total"].': '.mysql_num_rows($result).'</td></tr>';

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
    print "<tr". (($i++ % 2) ? "" : " class=\"alternateRow\"") ."><td><a href=\"index.php?d=module&p=clanview&clan_name=". $row["clan_name"]."\">". htmlspecialchars($row["clan_name"]). "</a></td><td>". $row["char_name"]. "</td><td class=\"numeric sortedColumn\">".$row["clan_level"]. "</td><td>".$row["hasCastle"]. "</td><td class=\"numeric\">".$row["csum"]. "</td><td class=\"numeric\">".$row["ccount"]. "</td><td class=\"numeric\">".$row["cavg"]. "</td></tr>\n";
  }
  print "</tbody>\n</table>\n";
 // mysql_close($link);
?>