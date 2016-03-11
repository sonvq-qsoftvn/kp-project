<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");
	

$obj_add = new admin;
$obj_temp_tickets = new admin;
$obj_edit_tic = new admin;
$obj_checkVenue = new admin;
$obj_update_st_rt = new admin;


//echo $_SESSION['venue_unique_id'];exit;


$exit_rate_id = $_POST['exit_rate_id'];
$rate_name_en = addslashes($_POST['rate_name_en']);
$rate_name_sp = addslashes($_POST['rate_name_sp']);
$description_en = addslashes($_POST['description_en']);
$description_sp = addslashes($_POST['description_sp']);
$price_mx = $_POST['price_mx'];
$price_us = $_POST['price_us'];

if($_POST['edit_rate']==0){
	$obj_add->addStandardRatesVenue($_SESSION['venue_unique_id'],$rate_name_en,$rate_name_sp,$description_en,$description_sp,$price_mx,$price_us);
	
	$obj_checkVenue->checkVenue($_SESSION['venue_unique_id']);
	if($obj_checkVenue->num_rows()){
		$obj_checkVenue->next_record();
		$obj_update_st_rt->updateVenStanRt($_SESSION['venue_unique_id'],$obj_checkVenue->f('venue_id'));
	}
}
else
{
	$exit_rate_id = $_POST['exit_rate_id'];
	$obj_edit_tic->editStandardRatesVenue($rate_name_en,$rate_name_sp,$description_en,$description_sp,$price_mx,$price_us,$exit_rate_id);
}

echo ' <div style=" max-height:95px; over flow:auto;">';
 //Fetch records from temp table
$obj_temp_tickets->getVenueStandardRate($_SESSION['venue_unique_id']);
if($obj_temp_tickets->num_rows()){
	while($obj_temp_tickets->next_record()){
?>
<div class="event_ticketbox" style="border-bottom:1px dashed #CCC;">
    <ul>
        <li><?php echo $obj_temp_tickets->f('rate_name_en');?></li>
        <li><?php echo $obj_temp_tickets->f('rate_name_sp');?></li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_mx'),2);?> MXP </li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_us'),2);?> USD </li>
        <li style="margin-right: 0;">
            <span class="tic_edit">
                <span style="cursor:pointer;" onclick="edit_rates(<?php echo $obj_temp_tickets->f('venue_rates_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit </span>
                <span style="cursor:pointer;" onclick="delStandVen(<?php echo $obj_temp_tickets->f('venue_rates_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete </span>
            </span>
        </li>
    </ul>
</div>
    
 <?php
	}
}
echo '</div>';

 ?>



