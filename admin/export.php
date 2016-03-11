<?php
include('../include/admin_inc.php');
$objlist = new admin;
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=event_list.csv");

			/*require_once("../includes/configuration.php");
			require_once("../includes/dbcon.php");
			require_once("../includes/functions.php");
			require_once("../includes/function_search.php");*/
			
//echo "xxxxxxxxxxxxxxxxxxxxxxxx"; exit;
$text1="";
$heading="";
$i=0;
$objlist->allEventList();
while($res = $objlist->next_record())
{

	$text1.= stripslashes($objlist->f('event_name_en'));
	$text1.=",".stripslashes($objlist->f('event_start_date_time'));
	
	$text1.=",".stripslashes($objlist->f('venue_name'));
	
	$text1.=",".stripslashes($objlist->f('city_name'));
	$text1.=",".stripslashes($objlist->f('county_name'));
	//$text1.=",".stripslashes($row['name']);	

	$text1.="\015\012";
	$i++;

}

$heading.="Event Name";
$heading.=",Date & Time";
$heading.=",Venue";
$heading.=",City";
$heading.=",County";

$heading.="\015\012";
$somecontent=$heading.$text1;


//header("Content-type: application/x-msdownload");

//header("Pragma: no-cache");
//header("Expires: 0");
print $somecontent;
?>
