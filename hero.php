
<table width="100%" border="0">
  <tr bgcolor="#1E1A11" class="style5" align="center" height="30">
    <td>Nome char:</td>
    <td>Level:</td>
    <td>Classe:</td>
    <td>Clan:</td>
    <td>Count:</td>
  </tr>
<?

$sql = mysql_query("SELECT * FROM heroes ORDER BY char_name") or die(mysql_error());
$cor = 0;
while($c = mysql_fetch_array($sql)) {
      $cor = $cor + 1;
      $bg  = $cor % 2 == 0 ? '#F1F1F1' : '#E8E8E8';

      $h = mysql_query("SELECT * FROM characters WHERE charId = '".$c['char_id']."'") or die(mysql_error());
      $n = mysql_fetch_array($h);
      $l = mysql_query("SELECT * FROM class_list WHERE id = '".$n['base_class']."'") or die(mysql_error());
      $g = mysql_fetch_array($l);
      $i = mysql_query("SELECT * FROM clan_data WHERE clan_id = '".$n['clanid']."'") or die(mysql_error());
      $j = mysql_fetch_array($i);
      $g['class_name'] = explode("_", $g['class_name']);
      $j['clan_name'] = empty($n['clanid']) ? 'Sem Clan.' : $j['clan_name'];

?>

  <tr bgcolor="<?php echo $bg; ?>" class="style8" align="center" height="23">
    <td><?php echo $n['char_name']; ?></td>
    <td><?php echo $n['level']; ?></td>
    <td><?php echo ucwords($g['class_name'][1]); ?></td>
    <td><?php echo $j['clan_name']; ?></td>
    <td><?php echo $c['count']; ?></td>
  </tr>
<?
}
?>
