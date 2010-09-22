<table border="0">
    <tr><td><img src="img/face/{c_race}_{c_sex}.png" alt="" /></td><td>
    <table border="1">
    <tr><td>{level}:</td><td>{c_level}</td></tr>
    <tr><td class="maxCp">{cp}:</td><td class="maxCp">{maxCp}</td></tr>
    <tr><td class="maxHp">{hp}:</td><td class="maxHp">{maxHp}</td></tr>
    <tr><td class="maxMp">{mp}:</td><td class="maxMp">{maxMp}</td></tr>
    <tr><td>{class}:</td><td>{ClassName}</td></tr>
    <tr><td>{clan}:</td><td>{clan_link}</td></tr>
    <tr><td>{pvp}/<font color="red">{pk}</font>:</td><td><b>{pvpkills}</b>/<b><font color="red">{pkkills}</font></b></td></tr>
    <tr><td>{online}:</td><td><img src="img/status/{onoff}line.png" title="{online}" alt="{online}" /></td></tr></table></td></tr></table>

    <table border="0" cellpadding="0" cellspacing="0" ><tr><td>
    <div id='paperdoll' align="left">
	<div id='paperdoll_items' align="left">
    {eq_items}
   	</div>
</div></td></tr><tr><td>
<div id='inventory' align="left">
	<div id='inventory_items' class='flexcroll'>
    {inv_items}
    		<div class='clearfloat'></div>
	</div>
</div>
</td></tr></table>
    <h1>{otherchars}</h1>
{charlist}