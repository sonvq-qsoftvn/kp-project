<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getvenue = new admin;
$cityId = $_POST['city_id'];
$multi_venue = $_POST['multi_venue'];
?>		
  
<select name="multi_venue" id="multi_venue" class="state selectbg12" >
<option value="">Venue</option>
<?php
$obj_getvenue->getVenueNameByCity($cityId);
while($obj_getvenue->next_record())
{
?>
<option value=<?php echo $obj_getvenue->f("venue_id")?> <?php if($multi_venue==$obj_getvenue->f("venue_id")){?> selected="selected"<?php } ?>><?php echo $obj_getvenue->f('venue_name')?></option>
<?php
}
?>
</select>	  
		  
