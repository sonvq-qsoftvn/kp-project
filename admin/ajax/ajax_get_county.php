<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");
include("../../class/merchant_admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$display = '';

$obj_getcounty = new admin;
$stateId = $_POST['state_id'];
?>		
  
<select name="county_id" id="county_id" class="selectbg20">
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
		  
