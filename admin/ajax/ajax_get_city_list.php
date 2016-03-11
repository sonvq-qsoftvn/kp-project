<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$display = '';

$obj_getcity = new admin;
$countyId = $_POST['county_id'];
$city_list = $_POST['city_list'];
?>		
  
<select name="city" id="city" class="selectbg12">
<option value="">City</option>
<?php
$obj_getcity->getCityNameByCounty($countyId);
while($obj_getcity->next_record())
{
?>
<option value=<?php echo $obj_getcity->f("id")?> <?php if($city_list==$obj_getcity->f('id')){?> selected="selected"<?php }?>><?php echo $obj_getcity->f('city_name')?></option>
<?php
}
?>
</select>	  
		  
