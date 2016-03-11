<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_multi_temp = new admin;

$unique_id = $_SESSION['unique_id'];
$temp_multi_event_id = $_POST['temp_multi_event_id'];

$obj_multi_temp->getTempMultiEvents($temp_multi_event_id);
$obj_multi_temp->next_record();

list($event_date_start,$event_time_start) = explode(" ",$obj_multi_temp->f('event_start_date_time'));
list($multi_year_start,$milti_mon_start,$multi_day_start) = explode("-",$event_date_start);
list($multi_tm_hr_start,$multi_tm_min_start,$multi_tm_se_start) = explode(":",$event_time_start);

list($event_date_end,$event_time_end) = explode(" ",$obj_multi_temp->f('event_end_date_time'));
list($multi_year_end,$milti_mon_end,$multi_day_end) = explode("-",$event_date_end);
list($multi_tm_hr_end,$multi_tm_min_end,$multi_tm_se_end) = explode(":",$event_time_end);


$arr = array('multi_year_start' => $multi_year_start, 'milti_mon_start' => $milti_mon_start,'multi_day_start' => $multi_day_start,'multi_tm_hr_start' => $multi_tm_hr_start,'multi_tm_min_start' => $multi_tm_min_start,'event_start_ampm' => $obj_multi_temp->f('event_start_ampm'),'multi_year_end' => $multi_year_end, 'milti_mon_end' => $milti_mon_end,'multi_day_end' => $multi_day_end,'multi_tm_hr_end' => $multi_tm_hr_end,'multi_tm_min_end' => $multi_tm_min_end,'event_end_ampm' => $obj_multi_temp->f('event_end_ampm'),'multi_venue_state' => $obj_multi_temp->f('multi_venue_state'),'venue_county_multi' => $obj_multi_temp->f('venue_county_multi'),'multi_venue_city' =>$obj_multi_temp->f('multi_venue_city'),'multi_venue' => $obj_multi_temp->f('multi_venue'));

echo json_encode($arr);
?>
   
 


