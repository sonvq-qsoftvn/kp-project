<?php	error_reporting(1);
// home page
session_start();
include('../include/admin_inc.php');

//create object
$obj_ven=new admin;
$obj_insrt_dup_ven=new admin;
$obj_edit_venue=new admin;
$obj_add_standard_rate=new admin;
$obj_ven_st_rt=new admin;
$obj_dup_event_type=new admin;
$obj_dup_cat=new admin;
$obj_add_venue_type=new admin;
$obj_add_venue_cat=new admin;

$_SESSION['venue_unique_id'] = time();

// add duplicate Venue 
$venue_id = $_REQUEST['venue_id'];
$insert_venue_id = $obj_insrt_dup_ven->insrtDuplicateVenue($venue_id);

// Update Venue
$obj_edit_venue->editvenuedate($insert_venue_id,$_SESSION['venue_unique_id']);
 
$obj_ven->get_venue($insert_venue_id);
$obj_ven->next_record();

// Add Venue rate
$obj_ven_st_rt->getStandRtByVenId($venue_id);
if($obj_ven_st_rt->num_rows()){
	while($obj_ven_st_rt->next_record()){
		
		$obj_add_standard_rate->addStandardRatesVenue($_SESSION['venue_unique_id'],$obj_ven_st_rt->f('rate_name_en'),$obj_ven_st_rt->f('rate_name_sp'),$obj_ven_st_rt->f('description_en'),$obj_ven_st_rt->f('description_sp'),$obj_ven_st_rt->f('price_mx'),$obj_ven_st_rt->f('price_us'),$insert_venue_id);
		
	}
}

// Venue Types BY venue ID details
$obj_dup_event_type->eventTypeBYVenueId($venue_id);
if($obj_dup_event_type->num_rows()){
	while($obj_dup_event_type->next_record()){
		$allEventType[] = $obj_dup_event_type->f('event_master_type_id');
	}
	
	// Add venue type
	$obj_add_venue_type->addEventType($allEventType,$insert_venue_id);
}

// Venue Category details
$obj_dup_cat->categorylistByVenue($venue_id);
if($obj_dup_cat->num_rows()){
	while($obj_dup_cat->next_record()){
		$allEventCat[] = $obj_dup_cat->f('category_id');
	}
	
	// Add venue Category
	$obj_add_venue_cat->addCategoryByVenue($allEventCat,$insert_venue_id);
}

header("Location:".$obj_base_path->base_path()."/admin/edit-venue/".$insert_venue_id."");
exit;




?>
