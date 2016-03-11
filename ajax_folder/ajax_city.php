<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_getcity = new user;
$countyId = $_POST['county_id'];
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<select name="city" class="selectbg12" style="width:205px; margin-left:5px;">
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
		  
