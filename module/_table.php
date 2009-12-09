<?php
  $result2 = mysql_query("SELECT clan_id,clan_name FROM clan_data", $link)
    or die ("Error: ".mysql_error());
  while ($row2=mysql_fetch_row($result2))
    $clans_array[$row2[0]]=$row2[1];
  $clans_array[0]="";

print '
<thead>
<tr style="vertical-align: bottom;">
 <th class="sortedColumn">'.$L2JBS_lang["_table_position"].' </th>
 <th>Name</th>
 <th>Level</th>
 <th>Genger</th>
 <th>Race</th>
 <th>Class</th>
 <th>Pvp</th>
 <th>PK</th>
 <th>Clan</th>
 
</tr>
</thead>
<tfoot>
 <tr><td colspan="8" style="text-align:right;">'.$L2JBS_lang["_table_total"].': '.mysql_num_rows($result).'</td></tr>
</tfoot>
<tbody id="TblBdy">
';

$i=1;
while ($row=mysql_fetch_array($result))
{
  $row["sex"] = ($row["sex"]) ? $L2JBS_lang["_table_female"] : $L2JBS_lang["_table_male"];
  switch ($row["race"])
  {
    case 1: $row["race"]=$L2JBS_lang["_table_elf"]; break;
    case 2: $row["race"]=$L2JBS_lang["_table_darkelf"]; break;
    case 3: $row["race"]=$L2JBS_lang["_table_orc"]; break;
    case 4: $row["race"]=$L2JBS_lang["_table_dwarf"]; break;
    default: $row["race"]=$L2JBS_lang["_table_human"];
  }

  if ($i%2)
  {
    $rowstyle='';
    if (@$row["online"])
      $rowstyle=' class="online"';
  }

  else
  {
    $rowstyle=' class="alternateRow"';
    if (@$row["online"])
      $rowstyle=' class="alternateRow online"';
  }
  print ' <tr'. $rowstyle .'><td class="numeric sortedColumn">'. $i++ . '</td><td>'. $row["char_name"].'</td><td>'. $row["level"]. '</td><td>'. $row["sex"]. '</td><td>'.$row["race"]. '</td><td>'.$row["classname"]. '</td><td class="numeric">'.$row["pvpkills"]. '</td><td class="numeric">



'.$row["pkkills"].'




</td><td>
  ';
  if ($clan=$clans_array[$row["clanid"]])
    print '<a href="index.php?d=module&p=clantop">'.$clan.'</a>';
  print "</td></tr>\n";
}
print "</tbody>\n</table>\n";
mysql_close($link);
?>
