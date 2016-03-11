<?php
include('include/user_inc.php');

$obj_getvenue_cal = new user;
$cityId = $_POST['city_id'];
$evnt_ven = $_POST['evnt_ven'];
?>		
  
<div class="styled_select" style="height: 32px;">
<select name="event_venues_cal" id="event_venues_cal" style="width: 180px;">
<option value=""><?=DROPDOWN_ALL_EVENT_VENUES?></option>
<?php
$obj_getvenue_cal->getVenueNameByCity($cityId);
while($obj_getvenue_cal->next_record())
{
?>
<option value="<?php echo stripslashes($obj_getvenue_cal->f('venue_id'));?>" <?php if($evnt_ven== $obj_getvenue_cal->f("venue_id")) { echo 'selected'; } ?>><?php echo stripslashes($obj_getvenue_cal->f('venue_name'));?></option>
<?php
}
?>
</select>
</div>
	  
		  
