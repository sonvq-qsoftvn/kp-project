<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getcity = new admin;
$countyId = $_POST['county_id'];
$multi_venue_city = $_POST['multi_venue_city'];
?>		
  
<select name="multi_venue_city" id="multi_venue_city" class="state selectbg12" onchange="getVenue_multi(this.value,'');">
<option value="">City</option>
<?php
$obj_getcity->getCityNameByCounty($countyId);
while($obj_getcity->next_record())
{
?>
<option value=<?php echo $obj_getcity->f("id")?> <?php if($multi_venue_city==$obj_getcity->f("id")){?> selected="selected"<?php } ?>><?php echo $obj_getcity->f('city_name')?></option>
<?php
}
?>
</select>	  
		  
