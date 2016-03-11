<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getvenue = new admin;
$cityId = $_POST['city_id'];
?>		
  
<?php /*?><select name="venue" id="venue" class="selectbg12" onchange="displayEvent(2);"><?php */?>
<select name="venue" id="venue" class="selectbg12" onchange="displayEvent(2);">
<option value="">Venue</option>
<?php
$obj_getvenue->getVenueNameByCity($cityId);
while($obj_getvenue->next_record())
{
?>
<option value=<?php echo $obj_getvenue->f("venue_id")?>><?php echo $obj_getvenue->f('venue_name')?></option>
<?php
}
?>
</select>	  
		  
