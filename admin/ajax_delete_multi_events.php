<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_multi_temp = new admin;
$obj_temp_mulEve = new admin;

$unique_id = $_SESSION['unique_id'];
$temp_multi_event_id = $_POST['temp_multi_event_id'];

//if($_POST['event_id']!="")
//	$event_id = $_POST['event_id'];
//else
//	$event_id = $temp_multi_event_id;

$obj_multi_temp->deleteTempMultiEvent($temp_multi_event_id);

//if($_POST['event_id']!="")
	$event_id = $_POST['event_id'];
//else
//	$event_id = $temp_multi_event_id;

//echo $event_id; 
//echo $event_id =3;
echo ' <div style=" max-height:95px; over flow:auto;">';
 //Fetch records from temp table
$obj_temp_mulEve->get_temp_MultiEvent($event_id);
if($obj_temp_mulEve->num_rows()){
	while($obj_temp_mulEve->next_record()){
// Event Date
list($event_date_start,$event_time_start) = explode(" ",$obj_temp_mulEve->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$obj_temp_mulEve->f('event_end_date_time'));

?>

<div id="<?php echo $obj_temp_mulEve->f('multi_id');?>">
   <div style="float: left; width: 420px;">
     <?php /*?> <p style="float: left; margin:0 auto;"><?php echo $obj_temp_mulEve->f('venue_name_multi').". ".$obj_temp_mulEve->f('city_name_multi').". ".$obj_temp_mulEve->f('state_name_multi')?></p><?php */?>
    <span style="float: right; margin: 0 auto; padding: 5px 0 0 0;"><?php echo date("D",strtotime($event_date_start))." ".date("M",strtotime($event_date_start))." ".date("d",strtotime($event_date_start)).", ".date("Y",strtotime($event_date_start));?> at <?php echo date('g:i A',strtotime($event_time_start)); ?></span>
    </div>
    <!--<div class="clear"></div>-->
    <div style="float: right; width: 420px;">
        <span class="edit_del">
            <span style="cursor:pointer;" onclick="edit_multipleEvents(<?php echo $obj_temp_mulEve->f('multi_id');?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit</span> 
            <span style="cursor:pointer;" onclick="delete_multipleEvents('<?php echo $obj_temp_mulEve->f('multi_id');?>','<?php echo $_POST['event_id'];?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete</span>
         </span>
    </div>
    </div>
 <?php
	}
}
echo '</div>';


?>
   
 


