<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$obj_user = new admin;

$selected_venue = $_POST['selected_venue'];
$selected_venue_state = $_POST['selected_venue_state'];
$selected_venue_county = $_POST['selected_venue_county'];
$selected_venue_city = $_POST['selected_venue_city'];
$user_id = $_POST['user_id'];

$obj_user->update_user_venue($selected_venue, $selected_venue_state, $selected_venue_county, $selected_venue_city, $user_id);

echo "updated";

?>		
  
		  
