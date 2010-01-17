<?

include("config/config.php");


  
  $data_red=0; //// map redimensionate variable /////////
  
    if ($map_size == "very_big")
    {$data_red=1300;}
    
    if ($map_size == "big")
    {$data_red=970;}
    
    if ($map_size == "normal")
    {$data_red=770;}
    
    if ($map_size == "small")
    {$data_red=642;}
    
   
    $imgsize['aden']=getimagesize("images/map_aden_".$map_size.".jpg");
    $map['aden_x']=$imgsize['aden'][0] / 100;     //1% von der karte aden x
    $map['aden_y']=$imgsize['aden'][1] / 100;     //1% von der karte aden y
    
 
$rb_stat="";
    
    
   
$connection=MYSQL_CONNECT($dbhost,$dbuser,$dbpass) or die ("<Font color='red'>Could not conntect to Database, please , check the server status and/or the DB settings at config.cfg</color>");
mysql_select_db($dbname,$connection);

 $get_config_data="SELECT online FROM characters WHERE online";
 $config_data=MYSQL_QUERY($get_config_data);
 $config['num_online']=mysql_num_rows($config_data);
 
 
 
 

 
   if ($online_players_toggle == "on")
 {$plyr_on="<font color=green>Enabled</font>";
 

  $get_char_data="SELECT characters.charId, characters.char_name, characters.x, characters.y, characters.z, characters.race, characters.level, characters.sex, characters.clanid, characters.accesslevel, clan_data.clan_id, clan_data.clan_name FROM characters,clan_data WHERE characters.clanid in(0,clan_data.clan_id) and online";
  $char_data=MYSQL_QUERY($get_char_data);
  
   if (mysql_num_rows($char_data)!=0)
 {

  while(list($CharId,$char_name,$x,$y,$z,$race,$level,$sex,$clanid,$accesslevel,$clan_id,$clan_name)=mysql_fetch_row($char_data))
  {
    $data['x']=($x + 130000) / 3600;
    $data['y']=($y + 0) / 5250;
    $data['x']=$map['aden_x'] * $data['x'];
    $data['y']=$map['aden_y'] * $data['y'] + $data_red;
    
  
    
    
    

   if($accesslevel >= 100)
   {
    $accesslevel="[GM] ,";
   }else{
    $accesslevel="";
   }
   
   if($sex == 0)
   {$sex="male";}
   
   if($sex == 1)
   {$sex="female";}
   
   if($clanid==0)
   {$clan_name=" [no clan] ";}
  


   $players[]=array(
     "charId"      => $charId,
     "char_name"   => $char_name,
     "race"        => $race,
     "level"       => $level,
     "accesslevel" => $accesslevel,
     "clanid"      => $clanid,
     "sex"         => $sex,
     "img_x_px"    => round($data['x']),
     "img_y_px"    => round($data['y']),
     "x"           => $x,
     "y"           => $y,
     "z"           => $z,
     "clan_id"     => $clan_id,
     "clan_name" => $clan_name
   );
 
 
 }
 
 }
 
 else
 {
 
  $get_char_data="SELECT characters.charId, characters.char_name, characters.x, characters.y, characters.z, characters.race, characters.level, characters.sex, characters.clanid, characters.accesslevel FROM characters WHERE online > 0";
  $char_data=MYSQL_QUERY($get_char_data);
 

  while(list($CharId,$char_name,$x,$y,$z,$race,$level,$sex,$clanid,$accesslevel)=mysql_fetch_row($char_data))
  {
    $data['x']=($x + 130000) / 3600;
    $data['y']=($y + 0) / 5250;
    $data['x']=$map['aden_x'] * $data['x'];
    $data['y']=$map['aden_y'] * $data['y'] + $data_red;
    
  
    
    
    

   if($accesslevel >= 100)
   {
    $accesslevel="[GM] ,";
   }else{
    $accesslevel="";
   }
   
   if($sex == 0)
   {$sex="male";}
   
   if($sex == 1)
   {$sex="female";}
   
   $clan_name="[No Clan]";
   





   $players[]=array(
     "charId"      => $charId,
     "char_name"   => $char_name,
     "race"        => $race,
     "level"       => $level,
     "accesslevel" => $accesslevel,
     "clanid"      => $clanid,
     "sex"         => $sex,
     "img_x_px"    => round($data['x']),
     "img_y_px"    => round($data['y']),
     "clan_name"   => $clan_name,
     "x"           => $x,
     "y"           => $y,
     "z"           => $z
   );
 
 
 
 
 
 }
  
  }

  
  }
  
    else
  {$plyr_on="<font color=red>Disabled</font>";}
  
    if ($online_raidbosses_toggle == "on")
  {$boss_on="<font color=green>Enabled</font>";

  $get_boss_data="SELECT npc.id, npc.name, npc.title, npc.class, npc.level, npc.sex, npc.type, npc.aggro, npc.isUndead, raidboss_spawnlist.boss_id, raidboss_spawnlist.currentHp, raidboss_spawnlist.currentMp, raidboss_spawnlist.loc_x, raidboss_spawnlist.loc_y, raidboss_spawnlist.loc_z FROM npc,raidboss_spawnlist WHERE npc.id=raidboss_spawnlist.boss_id ".$rb_stat." AND npc.type = 'L2RaidBoss'";
  $boss_data=MYSQL_QUERY($get_boss_data);
  

    while(list($id,$name,$title,$class,$level,$sex,$type,$aggro,$isUndead,$boss_id,$currentHp,$currentMp,$loc_x,$loc_y,$loc_z)=mysql_fetch_row($boss_data))
  {
  
  
  
    $data['loc_x']=($loc_x + 130000) / 3600;
    $data['loc_y']=($loc_y + 0) / 5250;
    $data['loc_x']=$map['aden_x'] * $data['loc_x'];
    $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;
    
    
    
   if($aggro == 0)
   {$aggro="no";}
   
   if($aggro == 1)
   {$aggro="yes";}
   
   
   if($isUndead== 0)
   {$isUndead="no";}
   
   if($isUndead== 1)
   {$isUndead="yes";}
    
    
       $R_boss[]=array(
     "id"          => $id,
     "name"        => $name,
     "title"       => $title,
     "class"       => $class,
     "level"       => $level,
     "sex"         => $sex,
     "type"        => $type,
     "img_x_px"    => round($data['loc_x']),
     "img_y_px"    => round($data['loc_y']),
     "aggro"       => $aggro,
     "isUndead"    => $isUndead,
     "boss_id"     => $boss_id,
     "currentHp"   => $currentHp,
     "currentMp"   => $currentMp,
     "loc_x"       => $loc_x,
     "loc_y"       => $loc_y,
     "loc_z"       => $loc_z
   );
  
  }
  }
      else
  {$boss_on="<font color=red>Disabled</font>";}
  
   ?>
    <font size="5"><b><u><? echo $servername;?> Server Online players Map:</u></b><br></font>
    <br>
    <table width="" border="1" cellpadding="0" cellspacing="0" class="main-tables" bgcolor="black">
     <tr>
      <td class="sTable-titles" colspan="2"><nobr><center><font color="white"><? echo $config['num_online'];?> Online Players </font></center></nobr></td>
     </tr>
     <? if ($hide_options=="0")
     { ?>
      <tr>
      <td class="sTable-titles" width="180"><nobr><font color="white">Online Players Location are:   </font></nobr></td><td class="sTable-titles" bgcolor="black"><nobr><b><? echo $plyr_on;?></b></nobr></td>
     </tr>
     
       <tr>
      <td class="sTable-titles"><nobr><font color="white">Raid Boss Locations are:  </font></nobr></td><td class="sTable-titles" bgcolor="black"><nobr><b><? echo $boss_on;?></b></nobr></td>
     </tr> 
     <? }  if ($r_boss_help=="1")
     { ?>
        <tr>
      <td class="sTable-titles" colspan="2"><nobr><center><img src="images/rb.png"></center></nobr></td>
     </tr> <? }?>
     </table>
     <br>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-tables">
     <tr>
      <td class="widelist-txt">
       <div style="
        width: <? echo $imgsize['aden'][0]; ?>px;
        height: <? echo $imgsize['aden'][1]; ?>px;
        background-image: url('images/map_aden_<? echo $map_size;?>.jpg');
        z-index: 1;">
        <?
         $count=0;
         foreach($players as $value)
         {
           ?>
            <div style="
             width: <? echo $imgsize['aden'][0]; ?>px;
             height: <? echo $imgsize['aden'][1]; ?>px;
             background-image: url('images/pin_<? echo $value['race']; ?>.gif');
             background-repeat: no-repeat;
             background-position: <? echo $value['img_x_px']; ?>px <? echo $value['img_y_px']; ?>px;
             z-index: <? echo $count+2; ?>;
            ">
           <?
           $count++; 
         }
         ?>
         
         
         
         
         
          <?
         $count=0;
         foreach($R_boss as $value)
         {
           ?>
            <div style="
             width: <? echo $imgsize['aden'][0]; ?>px;
             height: <? echo $imgsize['aden'][1]; ?>px;
             background-image: url('images/bug3.png');
             background-repeat: no-repeat;
             background-position: <? echo $value['img_x_px']; ?>px <? echo $value['img_y_px']; ?>px;
             z-index: <? echo $count+2; ?>;
            ">
           <?
           $count++; 
         }
         ?>
         
         
         
         
          <map name="Map-Aden">
           <?
            foreach($players as $value)
            {

              ?>
               <area shape="rect" coords="<? echo $value['img_x_px']; ?>,<? echo $value['img_y_px']; ?>,<? echo $value['img_x_px'] + 20; ?>,<? echo $value['img_y_px'] + 20; ?>"<? echo $value['CharId']; ?>" title="<? echo $value['accesslevel']." Name: ".$value['char_name']." , Sex: ".$value['sex']." , lvl: ".$value['level']." , clan: ".$value['clan_name']." , Loc: [x:".$value['x']." y:".$value['y']." z:".$value['z']."]."; ?>">
              <?
             } 
             
           ?>
           
           <?
            foreach($R_boss as $value)
            {

              ?>
               <area shape="rect" coords="<? echo $value['img_x_px']; ?>,<? echo $value['img_y_px']; ?>,<? echo $value['img_x_px'] + 20; ?>,<? echo $value['img_y_px'] + 20; ?>"<? echo $value['id']; ?>" title="<? echo $value['title']."Name: ".$value['name']." , Class:".$value['Class']." , Sex: ".$value['sex']." , lvl: ".$value['level']." , undead: ".$value['isUndead'].", Aggro:".$value['aggro'].", Current_HP: ".$value['currentHp']." , Current_MP: ".$value['currentMp']." , Loc: [x:".$value['loc_x']."y:".$value['loc_y']."z:".$value['loc_z']."]."; ?>">
              <?
             } 
             
           ?>
          </map>
          <img src="images/leer.gif" border="0" width="<? echo $imgsize['aden'][0]; ?>" height="<? echo $imgsize['aden'][1]; ?>" usemap="#Map-Aden">
         <?
         while($count != 0)
         {
          ?></div><?
          $count--;
         }
        ?>
       </div>
      </td>
     </tr>
    </table>
   <?
MYSQL_CLOSE;
?>
