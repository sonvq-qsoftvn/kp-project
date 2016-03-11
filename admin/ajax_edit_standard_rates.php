<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_ticket = new admin;

$unique_id = $_SESSION['unique_id'];
$performer_rates_id = $_POST['performer_rates_id'];

$obj_ticket->getStandardRateById($performer_rates_id);
$obj_ticket->next_record();

$arr = array('rate_name_en' => $obj_ticket->f('rate_name_en'), 'rate_name_sp' => $obj_ticket->f('rate_name_sp'),'description_sp' => $obj_ticket->f('description_sp'),'description_en' => $obj_ticket->f('description_en'),'price_mx' => $obj_ticket->f('price_mx'),'price_us' => $obj_ticket->f('price_us'));

echo json_encode($arr);

?>
   
 


