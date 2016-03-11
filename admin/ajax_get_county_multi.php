<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$display = '';

$obj_getcounty = new admin;
$stateId = $_POST['state_id'];
$venue_county_multi = $_POST['venue_county_multi'];
?>		
  
<select name="venue_county_multi" id="venue_county_multi" class="state selectbg12" onchange="getCity_multi(this.value,'');">
<option value="">County</option>
<?php
$obj_getcounty->getCountyNameByState($stateId);
while($obj_getcounty->next_record())
{
?>
<option value=<?php echo $obj_getcounty->f("id");?> <?php if($venue_county_multi==$obj_getcounty->f("id")){?> selected="selected"<?php } ?>><?php echo $obj_getcounty->f('county_name')?></option>
<?php
}
?>
</select>	  
		  
