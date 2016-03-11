<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$obj_ticket = new admin;

$venue_rates_id = $_POST['venue_rates_id'];

$obj_ticket->getStanRateByVenueId($venue_rates_id);
$obj_ticket->next_record();

$arr = array('rate_name_en' => $obj_ticket->f('rate_name_en'), 'rate_name_sp' => $obj_ticket->f('rate_name_sp'),'description_sp' => $obj_ticket->f('description_sp'),'description_en' => $obj_ticket->f('description_en'),'price_mx' => $obj_ticket->f('price_mx'),'price_us' => $obj_ticket->f('price_us'));

echo json_encode($arr);

?>
   
 


