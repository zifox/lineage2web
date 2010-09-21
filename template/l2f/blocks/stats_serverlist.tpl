<table align="center" width="100%">
{game_server_status}
<tr class="row"><td align="left" width="75%">{clans}:</td><td align="left" width="25%">{clan_count}</td></tr>
<tr class="row"><td align="left" width="75%">{chars}:</td><td align="left" width="25%">{char_count}</td></tr>
<tr class="row"><td align="left" width="75%">{online}:</td>
<td align="left" width="25%"><a href="stat.php?stat=online&amp;server={ID}" onmouseover="Tip('{on_off}', FONTCOLOR, '#FFFFFF',BGCOLOR, '#AAAA00', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold', WIDTH, 50, ABOVE, true)"><font color="green">{online_count}</font></a> / <a href="stat.php?stat=gm&amp;server={ID}"><font color="green">{online_gm_count}</font></a></td></tr>
</table><br />