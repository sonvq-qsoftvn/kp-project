<?php
include('include/user_inc.php');

$obj_getcity = new user;
$countyId = $_POST['county_id'];
$evnt_city = $_POST['evnt_city'];
?>		
  
<div class="styled_select" style="height: 32px;">
<select name="event_cities" id="event_cities" style="width: 180px;" onchange="getVenue(this.value);">
<option value=""><?=DROPDOWN_ALL_EVENT_CITIES?></option>
<?php
$obj_getcity->getCityNameByCounty($countyId);
while($obj_getcity->next_record())
{
?>
<option value="<?php echo $obj_getcity->f("id")?>" <?php if($evnt_city == $obj_getcity->f("id")) { echo 'selected'; } ?>><?php echo $obj_getcity->f('city_name');?></option>
<?php
}
?>
</select>
</div>
	  
		  
