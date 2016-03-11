<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getcounty = new admin;
$stateId = $_POST['state_id'];
?>		
  
<select name="venue_county" class="selectbg12" onchange="getCity(this.value);" onblur="saveAutoEvent();">
<option value="">County</option>
<?php
$obj_getcounty->getCountyNameByState($stateId);
while($obj_getcounty->next_record())
{
?>
<option value=<?php echo $obj_getcounty->f("id")?>><?php echo $obj_getcounty->f('county_name')?></option>
<?php
}
?>
</select>	  
		  
