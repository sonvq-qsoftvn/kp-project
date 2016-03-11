<?php
session_start();

include('../include/admin_inc.php');

//print_r($_POST);exit;

$obj_add = new admin;
$obj_check_saved = new admin;
$obj_saved_category = new admin;
$obj_saved_per_type = new admin;
$obj_add_saved = new admin;
$obj_del_saved_types = new admin;
$obj_edit_saved = new admin;
$obj_del_saved_cat = new admin;

$finalArray = $_POST['maincat'];
$event_types = $_POST['event_types'];
	
$performer_name_sp = addslashes($_POST['performer_name_sp']);
$performer_name_en = addslashes($_POST['performer_name_en']);

$performer_short_add_sp = addslashes($_POST['performer_short_add_sp']);
$performer_short_add_en = addslashes($_POST['performer_short_add_en']);

$performer_state = addslashes($_POST['performer_state']);
$performer_county = addslashes($_POST['venue_county']);
$performer_city = addslashes($_POST['venue_city']);
$performer_zip = addslashes($_POST['performer_zip']);

$performer_address = addslashes($_POST['performer_address']);
$performer_contact_name = addslashes($_POST['performer_contact_name']);
$performer_phone = $_POST['performer_phone'];
$performer_fax=$_POST['performer_fax'];
$performer_cell=$_POST['performer_cell'];
$performer_email=$_POST['performer_email'];
$performer_url=$_POST['performer_url'];
$avail_performanace=$_POST['avail_performanace'];
$manager_name=$_POST['manager_name'];
$manager_phone = addslashes($_POST['manager_phone']);
$manager_fax = addslashes($_POST['manager_fax']);
$manager_cell = addslashes($_POST['manager_cell']);
$manager_email = $_POST['manager_email'];
$manager_url = $_POST['manager_url'];
$performer_description_sp = addslashes($_POST['performer_description_sp']);
$performer_description_en = addslashes($_POST['performer_description_en']);
$performer_tags = addslashes($_POST['performer_tags']);
$privacy = $_POST['privacy'];
$st_rate = $_POST['st_rate'];
$activate_status = 0;
$file_name = $_POST['performer_photo'];



	// Check if the event is already save or not
	$obj_check_saved->checkSavedPerformer($_SESSION['unique_id']);

	if($obj_check_saved->num_rows())
	{
		$obj_check_saved->next_record();
		$obj_edit_saved->editSavedPerformer($performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$_SESSION['unique_id']);
		
		
		// Update category Event
		if(count($finalArray)>0)
   		{
			// Delete previous category..
			$obj_del_saved_cat->delPerCat($obj_check_saved->f('performer_id'));
			
		   for($a=0;$a<count($finalArray);$a++)
		   {
				$obj_saved_category->addSavedCatByPerfrm($finalArray[$a],$obj_check_saved->f('performer_id'));
			}
		}
		
		// Add category Event types
		if(count($event_types)>0)
   		{
			// Delete previous Types..
			$obj_del_saved_types->delPertypes($obj_check_saved->f('performer_id'));

		   for($a=0;$a<count($event_types);$a++)
		   {
				$obj_saved_per_type->addperformertype($event_types[$a],$obj_check_saved->f('performer_id'));
			}
		}
		
	}
	else 
	{
		// Add Performer
		$last_performer_id = $obj_add_saved->addSavedPerformer($_SESSION['ses_user_id'],$performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$_SESSION['unique_id']);
		
		// Add category Performer
		if(count($finalArray)>0)
   		{
			
		   for($a=0;$a<count($finalArray);$a++)
		   {
				$obj_saved_category->addSavedCatByPerfrm($finalArray[$a],$last_performer_id);
			}
		}	
			
		// Add category Event types
		if(count($event_types)>0)
   		{
		   for($a=0;$a<count($event_types);$a++)
		   {
				$obj_saved_per_type->addperformertype($event_types[$a],$last_performer_id);
			}
		}		
	
	}


 ?>
