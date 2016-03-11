<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getcity = new admin;
$countyId = $_POST['county_id'];
?>		
  
<select name="venue_city" id="venue_city" class="selectbg12" onchange="getVenue(this.value,'');">
<option value="">City</option>
<?php
$obj_getcity->getCityNameByCounty($countyId);
while($obj_getcity->next_record())
{
?>
<option value=<?php echo $obj_getcity->f("id")?> <?php if($_POST['venue_city_list']==$obj_getcity->f('id')){?> selected="selected"<?php }?>><?php echo $obj_getcity->f('city_name')?></option>
<?php
}
?>
</select>	  
		  
