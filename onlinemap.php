<?
define('INWEB', true);
require_once('include/config.php');
header("Cache-Control: no-cache");
header("Expires: -1");
head('Online Map',0);
if(isset($_GET['type']))
{
	$map_size=mysql_real_escape_string($_GET['type']);
}else
{
	$map_size="small";
}
  switch($map_size){
  	case 'very_big':
  	$data_red=1300;
  	break;
  	case 'big':
  	$data_red=970;
  	break;
  	case 'normal':
  	$data_red=770;
  	break;
  	case 'small':
  	$data_red=642;
  	break;
  	default:
  	$data_red=642;
  	break;
  }

    $imgsize['aden']=getimagesize("img/onlinemap/map_aden_".$map_size.".jpg");
    $map['aden_x']=$imgsize['aden'][0] / 100;
    $map['aden_y']=$imgsize['aden'][1] / 100;
   ?>
    <table><tr><td><h1><? echo $Config['ServerName'];?> Server Online players Map:</h1>
    <br />
    <a href="onlinemap.php?type=small">Small</a><a href="onlinemap.php?type=normal">Normal</a><a href="onlinemap.php?type=big">Big</a><a href="onlinemap.php?type=large">Large</a>
   
     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-tables">
     <tr>
      <td class="widelist-txt">
       <div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/map_aden_<? echo $map_size;?>.jpg'); z-index: 1;">
        <?
         $count=0;
         
         $get_char_data="SELECT `charId`, `char_name`, `x`, `y`, `z`, `race`, `level`, `sex`, `clan_id`, `clan_name` FROM characters LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online`";
  $char_data=mysql_query($get_char_data);

  while($char=mysql_fetch_assoc($char_data))
  {
  	$data['x']=($char['x'] + 130000) / 3600;
    $data['y']=($char['y'] + 0) / 5250;
    $data['x']=$map['aden_x'] * $data['x'];
    $data['y']=$map['aden_y'] * $data['y'] + $data_red;
?>
<div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/pin_<? echo $char['race']; ?>.gif'); background-repeat: no-repeat; background-position: <? echo round($data['x']); ?>px <? echo round($data['y']); ?>px; z-index: <? echo $count+2; ?>;">
           <?
           $count++; 
         }

        // $count=0;
           $get_boss_data="SELECT `id`, `name`, `title`, `level`, `sex`, `aggro`, `isUndead`, `boss_id`, `currentHp`, `currentMp`, `loc_x`, `loc_y`, `loc_z` FROM `npc` INNER JOIN `raidboss_spawnlist` ON `npc`.`id`=`raidboss_spawnlist`.`boss_id` WHERE `npc`.`type` = 'L2RaidBoss'";
  $boss_data=mysql_query($get_boss_data);
        while($rboss=mysql_fetch_assoc($boss_data))
         {
         	
  
    $data['loc_x']=($rboss['loc_x'] + 130000) / 3600;
    $data['loc_y']=($rboss['loc_y'] + 0) / 5250;
    $data['loc_x']=$map['aden_x'] * $data['loc_x'];
    $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;    
    
           ?>
            <div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/bug3.png'); background-repeat: no-repeat; background-position: <? echo $data['loc_x']; ?>px <? echo $data['loc_y']; ?>px; z-index: <? echo $count+2; ?>;">
           <?
           $count++; 
         }
         ?>

          <map name="Map-Aden" id="Map-Aden">
           <?
           //$get_char_data="SELECT `charId`, `char_name`, `x`, `y`, `z`, `race`, `level`, `sex`, `clan_id`, `clan_name` FROM characters LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online`";
  $char_data=mysql_query($get_char_data);
  while($char=mysql_fetch_assoc($char_data))
  {
$data['x']=($char['x'] + 130000) / 3600;
    $data['y']=($char['y'] + 0) / 5250;
    $data['x']=$map['aden_x'] * $data['x'];
    $data['y']=$map['aden_y'] * $data['y'] + $data_red;
    

   if($char['sex'] == 0)
   {$char['sex']="male";}else{$char['sex']="female";}
   
   if($char['clan_id']==0)
   {$char['clan_name']="No Clan";}
              ?>
               <area shape="rect" coords="<? echo round($data['x']); ?>,<? echo round($data['y']); ?>,<? echo round($data['x']) + 20; ?>,<? echo round($data['y']) + 20; ?>,<? echo $char['CharId']; ?>" title="<? echo " Name: ".$char['char_name']." , Sex: ".$char['sex']." , lvl: ".$char['level']." , clan: ".$char['clan_name']." , Loc: [x:".$char['x']." y:".$char['y']." z:".$char['z']."]."; ?>" alt="" />
              <?
   } 
            // $get_boss_data="SELECT `id`, `name`, `title`, `level`, `sex`, `aggro`, `isUndead`, `boss_id`, `currentHp`, `currentMp`, `loc_x`, `loc_y`, `loc_z` FROM `npc` INNER JOIN `raidboss_spawnlist` ON `npc`.`id`=`raidboss_spawnlist`.`boss_id` WHERE `npc`.`type` = 'L2RaidBoss'";
  $boss_data=mysql_query($get_boss_data);
            while($rboss=mysql_fetch_assoc($boss_data))
		{
			$data['loc_x']=($rboss['loc_x'] + 130000) / 3600;
    $data['loc_y']=($rboss['loc_y'] + 0) / 5250;
    $data['loc_x']=$map['aden_x'] * $data['loc_x'];
    $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;
    
    
    
   if($rboss['aggro'] == 0)
   {$rboss['aggro']="no";}else{$rboss['aggro']="yes";}

   
   if($rboss['isUndead']== 0)
   {$rboss['isUndead']="no";}else{$rboss['isUndead']="yes";}
  
              ?>
               <area shape="rect" coords="<? echo $data['loc_x']; ?>,<? echo $data['loc_y']; ?>,<? echo $data['loc_x'] + 20; ?>,<? echo $data['loc_y'] + 20; ?><? echo $rboss['id']; ?>" title="<? echo $rboss['title']." Name: ".$rboss['name']." , Sex: ".$rboss['sex']." , lvl: ".$rboss['level']." , undead: ".$rboss['isUndead'].", Aggro:".$rboss['aggro'].", Current_HP: ".$rboss['currentHp']." , Current_MP: ".$rboss['currentMp']." , Loc: [x:".$rboss['loc_x']."y:".$rboss['loc_y']."z:".$rboss['loc_z']."]."; ?>" alt="" />
              <?
             } 
             
           ?>
          </map>
          <img src="img/onlinemap/leer.gif" border="0" width="<?php echo $imgsize['aden'][0]; ?>" height="<?php echo $imgsize['aden'][1]; ?>" usemap="#Map-Aden" alt="" />
         <?php
         while($count != 0)
         {
          ?></div><?php
          $count--;
         }
        ?>
       </div>
      </td>
     </tr>
    </table></td></tr><tr><td align="center">
<?php
foot(0);
?>