<?php
	session_start();
	include("../../class/db_mysql.inc");
	include("../../class/admin_class.php");
	include("../../class/event_class.php");
	include("../../class/duplicate_event_class.php");
	
	$obj_base_path = new DB_Sql;
	include("../../include/session_admin.inc.php");
	
	//print_r($_POST);exit;

	$obj_add = new admin;
	$obj_check_saved = new admin;
	$obj_del_cat = new admin;
	$obj_add_category_by_event = new admin;
	$obj_add_eventtype = new admin;
	$obj_update_st_rt = new admin;

	$finalArray = $_POST['maincat'];
	$event_types = $_POST['event_types'];
	$publish_date = $_POST['year_1']."-".$_POST['month_1']."-".$_POST['day_1'];
	
	$venue_name_sp = addslashes($_POST['venue_name_sp']);
	$venue_short_add_sp = addslashes($_POST['venue_short_add_sp']);
	$venue_name = addslashes($_POST['venue_name']);
	$venue_short_add_en = addslashes($_POST['venue_short_add_en']);
	$venue_state = addslashes($_POST['venue_state']);
	$venue_county = addslashes($_POST['venue_county']);
	$venue_city = addslashes($_POST['venue_city']);
	$venue_zip = addslashes($_POST['venue_zip']);
	$venue_address = addslashes($_POST['venue_address']);
	$venue_contact_name=addslashes($_POST['venue_contact_name']);
	$venue_head_manager=addslashes($_POST['venue_head_manager']);
	$venue_phone=$_POST['venue_phone'];
	$venue_fax=$_POST['venue_fax'];
	$venue_cell=$_POST['venue_cell'];
	$venue_email=$_POST['venue_email'];
	$venue_url=$_POST['venue_url'];
	$venue_capacity = $_POST['venue_capacity'];
	$venue_map = $_POST['venue_map'];
	$venue_media_gallery = $_POST['venue_media_gallery'];
	$venue_authorize_manager = $_POST['venue_authorize_manager'];
	$allowed_commments = $_POST['allowed_commments'];
	$allowed_share = $_POST['allowed_share'];
	$show_FB_like = $_POST['show_FB_like'];
	$venue_description=addslashes($_POST['ven_des_en']);
	$venue_description_sp=addslashes($_POST['ven_des_sp']);
	$file_name = $_POST['venue_photo'];
	$tags = addslashes($_POST['tags']);
	$venue_stat = $_POST['venue_stat'];
	
	$venue_us_tell = $_POST['venue_us_tell'];
	$venue_nextel = $_POST['venue_nextel'];
	$venue_fb_page = $_POST['venue_fb_page'];
	$venue_twitter_account = $_POST['venue_twitter_account'];
	
	// Code for sub-description
	if(($venue_short_add_sp=="Breve Descripción" || $venue_short_add_sp=="") && $venue_description_sp!=""){
		$venue_short_add_sp = strip_tags($venue_description_sp);
		$venue_short_add_sp = substr($venue_short_add_sp,0,160);
	}
	if(($venue_short_add_en=="Short Description" || $venue_short_add_en=="") && $venue_description!=""){
		$venue_short_add_en = strip_tags($venue_description);
		$venue_short_add_en = substr($venue_short_add_en,0,160);
	}
		
	
	$privacy = $_POST['privacy_set'];
	if($privacy==0)	{
		$private_privacy = 1;
		$public_privacy = 0;
	}
	else{
		$private_privacy = 0;
		$public_privacy = 1;
	}


	// Check if the event is already save or not
	$obj_check_saved->checkSavedVenue($_SESSION['venue_unique_id']);
	if($obj_check_saved->num_rows())
	{
		$obj_check_saved->next_record();
	    $venue_id = $obj_check_saved->f('venue_id');
		
		// Edit Venue
		$obj_add->editVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$venue_stat,$venue_id,$venue_us_tell,$venue_nextel,$venue_fb_page,$venue_twitter_account,$_POST['st_rate']);
		
		// Delete old Category Event
		$obj_del_cat->delCatByVenueId($venue_id);
		// Add category Event
		$obj_add_category_by_event->addCategoryByVenue($finalArray,$venue_id);
		
		// Delete old Event types
		$obj_del_cat->delvenueTypeByVenueId($venue_id);
		// Add Event Type
		$obj_add_eventtype->addEventType($event_types,$venue_id);
		
		// Update Standard rates
		if($_POST['st_rate']==1)
		{
			$obj_update_st_rt->updateVenStanRt($_SESSION['venue_unique_id'],$venue_id);
		}
	}
	else 
	{
		// Add Event
		$last_venue_id = $obj_add->addVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$_SESSION['venue_unique_id'],$venue_stat,$venue_us_tell,$venue_nextel,$venue_fb_page,$venue_twitter_account,$_POST['st_rate']);
		// Add category Venue
		$obj_add_category_by_event->addCategoryByVenue($finalArray,$last_venue_id);
		
		// Add Type Venue 
		$obj_add_eventtype->addEventType($event_types,$last_venue_id);
		$venue_id = $last_venue_id;
		if($_POST['st_rate']==1)
		{
			$obj_update_st_rt->updateVenStanRt($_SESSION['venue_unique_id'],$venue_id);
		}
	}
	echo $venue_id;


?>
