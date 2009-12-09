<?php
include 'options.php';
##########    default values   ##########

/********  GIRAN  *************/
$giranOwner = "No Owner";
$giranSiegeDate = " ... ";
$giranTax ="";
/*********  OREN  **************/
$orenOwner = "No Owner";
$orenSiegeDate = " ... ";
$orenTax ="";
/**********  ADEN  **************/
$adenOwner = "No Owner";
$adenSiegeDate = " ... ";
$adenTax ="";
/********  Gludio  **************/
$gludioOwner = "No Owner";
$gludioSiegeDate = "...";
$gludioTax ="";
/**********  DION  ***************/
$dionOwner = "No Owner";
$dionSiegeDate = " ... ";
$dionTax ="";
/********  INNADRIL  *************/
$innadrilOwner = "No Owner";
$innadrilSiegeDate = " ... ";
$innadrilTax ="";
/********  GODDARD  *************/
$godadOwner = "No Owner";
$godadSiegeDate = " ... ";
$godadTax ="";
/*********************************/

	$sql = mysql_query("SELECT castle.name, clan_data.clan_name FROM castle,clan_data WHERE clan_data.hasCastle=castle.id");
	while($row= mysql_fetch_array($sql,MYSQL_ASSOC)){
		switch($row['name']){
			case 'Giran':$giranOwner=$row['clan_name'];break;
			case 'Oren':$orenOwner=$row['clan_name'];break;	
			case 'Aden':$adenOwner=$row['clan_name'];break;
			case 'Gludio':$gludioOwner=$row['clan_name'];break;
			case 'Dion':$dionOwner=$row['clan_name'];break;
			case 'Innadril':$innadrilOwner=$row['clan_name'];break;
			case 'Goddard':$godadOwner=$row['clan_name'];break;
			}
	}
	$sql = mysql_query("SELECT name,taxPercent,siegeDate FROM castle");
	while($row=mysql_fetch_array($sql,MYSQL_ASSOC)){
		switch($row['name']){
			case 'Giran':$giranTax=$row['taxPercent'].'%';
				$giranSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Oren':$orenTax=$row['taxPercent'].'%';
				$orenSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Aden':$adenTax=$row['taxPercent'].'%';
				$adenSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Gludio':$gludioTax=$row['taxPercent'].'%';
				$gludioSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Dion':$dionTax=$row['taxPercent'].'%';
				$dionSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Innadril':$innadrilTax=$row['taxPercent'].'%';
				$innadrilSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;
			case 'Goddard':$godadTax=$row['taxPercent'].'%';
				$godadSiegeDate=date('D\, j M Y H\:i',$row['siegeDate']/1000);break;	

			}
	}	
        
?>
