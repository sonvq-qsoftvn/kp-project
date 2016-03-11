<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_mulEve = new admin;
$obj_edit_tic = new admin;
$obj_check_saved = new admin;
$obj_event_id = new admin;

if($_REQUEST['edit_event_id']!="")
{
    $event_id = $_REQUEST['edit_event_id'];
}
else
{
	$obj_event_id->fetchEventId($_SESSION['unique_id']);
	$obj_event_id->next_record();
	$event_id = $obj_event_id->f('event_id');
}
$obj_check_saved->checkSavedEvent($event_id);
$obj_check_saved->next_record();


//print_r($_POST);exit;

/*if($_POST['event_start_ampm'] == 'PM'){
    $arrival_time=$_POST['event_hr_st']+12 .".".$_POST['event_min_st'];
}
else
{
    $arrival_time=$_POST['event_hr_st'].".".$_POST['event_min_st'];
}
if($_POST['event_end_ampm'] == 'PM'){
    $departure_time=$_POST['event_hr_end']+12 .".".$_POST['event_min_end'];
}
else
{
    $departure_time=$_POST['event_hr_end'].".".$_POST['event_min_end'];
}

$d1=  strtotime($arrival_time);
$d2=  strtotime($departure_time);

$diff=$d2-$d1;
echo $diff." ";
echo date("h:i:s",$diff);
*/

$date1 = '09-01-2014 19:00:00';
$date2 = '10-01-2014 21:30:00';
$diff = abs( strtotime( $date1 ) - strtotime( $date2 ) )/(60);
//printf("%d days\n", $diff);

//echo $diff;




//echo date("Y-m-d H:i:s", strtotime('+'.printf("%d", $diff).' hours'));strtotime('+'.printf("%d", $diff).' hours'))
//echo date("Y-m-d H:i:s", strtotime('+'.$diff.' hours', '09-01-2014 21:00:00'));


//echo $tomorrow = date('d-m-Y h:ia',strtotime('2014/01/09 21:00:00' . "+".$diff." minutes"));

//exit;

if($_POST['multi_event_start_ampm'] == 'PM'){
	$event_start_hour = $_POST['multi_event_hr_start']+12;
}
else{
	$event_start_hour = $_POST['multi_event_hr_start'];
}
$event_start_date_time = $_POST['multi_event_year_start']."-".$_POST['multi_event_month_start']."-".$_POST['multi_event_day_start']." ".$event_start_hour."-".$_POST['multi_event_min_start']."-00";
$event_start_ampm = $_POST['multi_event_start_ampm'];

if($_POST['multi_event_end_ampm'] == 'PM'){
	$event_end_hour = $_POST['multi_event_hr_end']+12;
}
else{
	$event_end_hour = $_POST['multi_event_hr_end'];
}
$event_end_date_time = $_POST['multi_event_year_end']."-".$_POST['multi_event_month_end']."-".$_POST['multi_event_day_end']." ".$event_end_hour."-".$_POST['multi_event_min_end']."-00";
$event_end_ampm = $_POST['multi_event_end_ampm'];
$multi_venue_state = $_POST['multi_venue_state'];
$venue_county_multi = $_POST['venue_county_multi'];
$multi_venue_city = $_POST['multi_venue_city'];
$multi_venue = $_POST['multi_venue'];

if($_POST['edit_multi_event']==0){
//echo $event_id;exit;
	$obj_add->addTempMultiEvent($event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$_SESSION['unique_id'],$event_id);
}
else
{
	$multi_event_id = $_POST['exit_multi_event'];
	$obj_edit_tic->editTempMultiEvent($event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$event_id,$multi_event_id);
}
//echo '<font color="#FF0000"><strong>Ticket has been created successfully</strong></font>';
//echo $event_id; exit;
echo ' <div style=" max-height:95px; over flow:auto;">';

if($_REQUEST['edit_event_id']!="")
{
	$send_id = $_REQUEST['edit_event_id'];
}
else
{
	$send_id = $event_id;
}

 //Fetch records from temp table
$obj_temp_mulEve->get_temp_MultiEvent($send_id);
if($obj_temp_mulEve->num_rows()){
	while($obj_temp_mulEve->next_record()){
// Event Date
list($event_date_start,$event_time_start) = explode(" ",$obj_temp_mulEve->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$obj_temp_mulEve->f('event_end_date_time'));

?>
<!--<style>
.edit_del{
	margin: 0 6px 0 0; display:inline-block; float: right; width: 114px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
}
</style>-->
<div id="<?php echo $obj_temp_mulEve->f('multi_id');?>">
   <div style="float: left; width: 420px;">
  <?php /*?>  <p style="float: left; margin:0 auto;"><?php echo $obj_temp_mulEve->f('venue_name_multi').". ".$obj_temp_mulEve->f('city_name_multi').". ".$obj_temp_mulEve->f('state_name_multi')?></p><?php */?>
    <span style="float: right; margin: 0 auto; padding: 5px 0 0 0;"><?php echo date("D",strtotime($event_date_start))." ".date("M",strtotime($event_date_start))." ".date("d",strtotime($event_date_start)).", ".date("Y",strtotime($event_date_start));?> at <?php echo date('g:i A',strtotime($event_time_start)); ?></span>
    </div>
    <div class="clear"></div>
    <div style="float: right; width: 420px;">
        <span class="edit_del">
            <span style="cursor:pointer;" onclick="edit_multipleEvents(<?php echo $obj_temp_mulEve->f('multi_id');?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit</span> 
            <span style="cursor:pointer;" onclick="delete_multipleEvents('<?php echo $obj_temp_mulEve->f('multi_id');?>','<?php echo $send_id;?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete</span>
         </span>
    </div>
    </div>
</div>
 <?php
	}
}
echo '</div>';

 ?>


