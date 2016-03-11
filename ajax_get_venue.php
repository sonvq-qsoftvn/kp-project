<?php
include('include/user_inc.php');

$obj_getvenue = new user;
$cityId = $_POST['city_id'];
$event_venue = $_POST['event_venue'];
?>		
  
<div class="styled_select" style="height: 32px;">
<select name="event_venues" id="event_venues" style="width: 180px;">
<option value=""><?=DROPDOWN_ALL_EVENT_VENUES?></option>
<?php
$obj_getvenue->getVenueNameByCity($cityId);
while($obj_getvenue->next_record())
{
?>
<option value="<?php echo stripslashes($obj_getvenue->f('venue_id'));?>" <?php if($event_venue== $obj_getvenue->f("venue_id")) { echo 'selected'; } ?>><?php echo stripslashes($obj_getvenue->f('venue_name'));?></option>
<?php
}
?>
</select>
</div>
	  
		  
