<?
require_once('include/config.php');
$map_size="normal";		      // map_size posible values are : "small" , "normal", "big" and "very_big"
$online_players_toggle="on";
$online_raidbosses_toggle="on";
$rb_status="all";                  // raid boss advanced config, posible values:
$hide_options="0";
$r_boss_help="1";

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
  	$data_red=0;
  	break;
  }

    $imgsize['aden']=getimagesize("images/map_aden_".$map_size.".jpg");
    $map['aden_x']=$imgsize['aden'][0] / 100;
    $map['aden_y']=$imgsize['aden'][1] / 100;
    
 
$rb_stat="";

 $get_config_data="SELECT count(online) FROM characters WHERE online";
 $config_data=mysql_query($get_config_data);
 $config['num_online']=mysql_result($config_data, 0, 0);
 
 if ($online_players_toggle == "on")
 {$plyr_on="<font color=green>Enabled</font>";
 
}else{$plyr_on="<font color=red>Disabled</font>";}
if ($online_raidbosses_toggle == "on")
{$boss_on="<font color=green>Enabled</font>";

  $get_boss_data="SELECT npc.id, npc.name, npc.title, npc.class, npc.level, npc.sex, npc.type, npc.aggro, npc.isUndead, raidboss_spawnlist.boss_id, raidboss_spawnlist.currentHp, raidboss_spawnlist.currentMp, raidboss_spawnlist.loc_x, raidboss_spawnlist.loc_y, raidboss_spawnlist.loc_z FROM npc,raidboss_spawnlist WHERE npc.id=raidboss_spawnlist.boss_id ".$rb_stat." AND npc.type = 'L2RaidBoss'";
  $boss_data=mysql_query($get_boss_data);
  

    while($boss=mysql_fetch_assoc($boss_data))
  {
  
  
  
    $data['loc_x']=($boss['loc_x'] + 130000) / 3600;
    $data['loc_y']=($boss['loc_y'] + 0) / 5250;
    $data['loc_x']=$map['aden_x'] * $data['loc_x'];
    $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;
    
    
    
   if($boss['aggro'] == 0)
   {$boss['aggro']="no";}else{$boss['aggro']="yes";}

   
   if($boss['isUndead']== 0)
   {$boss['isUndead']="no";}else{$boss['isUndead']="yes";}
  }
  }
      else
  {$boss_on="<font color=red>Disabled</font>";}
  
   ?>
    <font size="5"><b><u><? echo $Config['ServerName'];?> Server Online players Map:</u></b><br /></font>
    <br />
    <table width="" border="1" cellpadding="0" cellspacing="0" class="main-tables" bgcolor="black">
     <tr>
      <td class="sTable-titles" colspan="2"><center><font color="white"><? echo $config['num_online'];?> Online Players </font></center></td>
     </tr>
     </table>
     <br />
     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-tables">
     <tr>
      <td class="widelist-txt">
       <div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('images/map_aden_<? echo $map_size;?>.jpg'); z-index: 1;">
        <?
         $count=0;
         
         $get_char_data="SELECT `charId`, `char_name`, `x`, `y`, `z`, `race`, `level`, `sex`, `clan_id`, `clan_name` FROM characters LEFT OUTER JOIN `clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `online`";
  $char_data=mysql_query($get_char_data);

  while($char=mysql_fetch_assoc($char_data))
  {
?>
<div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('images/pin_<? echo $char['race']; ?>.gif'); background-repeat: no-repeat; background-position: <? echo $char['img_x_px']; ?>px <? echo $char['img_y_px']; ?>px; z-index: <? echo $count+2; ?>;">
           <?
           $count++; 
         }

         $count=0;
         foreach($R_boss as $value)
         {
           ?>
            <div style="width: <? echo $imgsize['aden'][0]; ?>px; height: <? echo $imgsize['aden'][1]; ?>px; background-image: url('images/bug3.png'); background-repeat: no-repeat; background-position: <? echo $value['img_x_px']; ?>px <? echo $value['img_y_px']; ?>px; z-index: <? echo $count+2; ?>;">
           <?
           $count++; 
         }
         ?>

          <map name="Map-Aden">
           <?
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
               <area shape="rect" coords="<? echo $value['img_x_px']; ?>,<? echo $value['img_y_px']; ?>,<? echo $value['img_x_px'] + 20; ?>,<? echo $value['img_y_px'] + 20; ?>"<? echo $value['CharId']; ?>" title="<? echo $value['accesslevel']." Name: ".$value['char_name']." , Sex: ".$value['sex']." , lvl: ".$value['level']." , clan: ".$value['clan_name']." , Loc: [x:".$value['x']." y:".$value['y']." z:".$value['z']."]."; ?>">
              <?
             } 
             
           ?>
           
           <?
            foreach($R_boss as $value)
            {

              ?>
               <area shape="rect" coords="<? echo $value['img_x_px']; ?>,<? echo $value['img_y_px']; ?>,<? echo $value['img_x_px'] + 20; ?>,<? echo $value['img_y_px'] + 20; ?>"<? echo $value['id']; ?>" title="<? echo $value['title']."Name: ".$value['name']." , Class:".$value['Class']." , Sex: ".$value['sex']." , lvl: ".$value['level']." , undead: ".$value['isUndead'].", Aggro:".$value['aggro'].", Current_HP: ".$value['currentHp']." , Current_MP: ".$value['currentMp']." , Loc: [x:".$value['loc_x']."y:".$value['loc_y']."z:".$value['loc_z']."]."; ?>" />
              <?
             } 
             
           ?>
          </map>
          <img src="images/leer.gif" border="0" width="<?php echo $imgsize['aden'][0]; ?>" height="<?php echo $imgsize['aden'][1]; ?>" usemap="#Map-Aden" />
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
    </table>
<?php
mysql_close($link);
?>