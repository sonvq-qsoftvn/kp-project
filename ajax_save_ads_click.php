<?php
include('include/user_inc.php');

$obj_ads_click = new user;

$ip_address = $_REQUEST['ip_address'];
$city = $_REQUEST['city'];
$country_code = $_REQUEST['country_code'];
$country_name = $_REQUEST['country_name'];
$ad_id = $_REQUEST['ad_id'];

$obj_ads_click->add_ads_click_tracker($ip_address, $city, $country_code, $country_name, $ad_id);

?>		
  
	  