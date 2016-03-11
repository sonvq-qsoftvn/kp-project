<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
include("language_form.php");

$obj_base_path = new DB_Sql;

$obj_getcity_cal = new user;
$countyId = $_POST['county_id'];
$evnt_ct = $_POST['evnt_ct'];
?>		
  
<div class="styled_select" style="height: 32px;">
<select name="event_cities_cal_rec" id="event_cities_cal_rec" style="width: 180px;" onchange="getVenueCal_rec(this.value);">
<option value=""><?=DROPDOWN_ALL_EVENT_CITIES?></option>
<?php
$obj_getcity_cal->getCityNameByCounty($countyId);
while($obj_getcity_cal->next_record())
{
?>
<option value="<?php echo $obj_getcity_cal->f("id")?>" <?php if($evnt_ct == $obj_getcity_cal->f("id")) { echo 'selected'; }?>><?php echo $obj_getcity_cal->f('city_name');?></option>
<?php
}
?>
</select>
</div>
	  
		  
