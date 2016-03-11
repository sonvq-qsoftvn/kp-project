<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_venuestate = new user;
$country_id = $_POST['country_id'];
?>		
  
<select name="province" id="province" class="selectbg12" style="width:205px; margin-left:5px;">
 <option value="">State</option>
	<?php
      $obj_venuestate->getStateById($country_id);
      while($row = $obj_venuestate->next_record())
      {
      ?>
      <option value="<?php echo $obj_venuestate->f('id');?>">
        <?php echo $obj_venuestate->f('state_name');?></option>
        <?php
      }
      ?>
</select>	  
		  
