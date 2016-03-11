<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$display = '';

$obj_getcounty = new user;
$stateId = $_POST['state_id'];
?>		
  
<select name="county_id[]" id="county_id" class="selectbg12" multiple="multiple" style="width:255px; margin-left:5px; height:94px;"">
<?php
$obj_getcounty->getCountyNameByState($stateId);
while($obj_getcounty->next_record())
{
?>
<option value=<?php echo $obj_getcounty->f("id")?> <?php if($_POST['venue_county']==$obj_getcounty->f('id')){?> selected="selected"<?php }?>><?php echo $obj_getcounty->f('county_name')?></option>
<?php
}
?>
</select>	  
		  
