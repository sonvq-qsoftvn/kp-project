<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");
include("../../class/merchant_admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

//print_r($_POST);exit;

$obj_state = new merchant_admin;


$country_id = $_POST['country_id'];
?>		
  
<select name="state" id="state" class="selectbg20" onchange="getCounty(this.value);">
<option value="">State</option>
<?php
$obj_state->getStateByCountry($country_id);
while($obj_state->next_record())
{
?>
<option value=<?php echo $obj_state->f("id")?>><?php echo $obj_state->f('state_name')?></option>
<?php
}
?>
</select>	  
		  
