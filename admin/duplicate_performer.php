<?php	
session_start();
include('../include/admin_inc.php');

//create object
$obj_performer=new admin;
$obj_insrt_dup_ven=new admin;
$obj_edit_venue=new admin;
$obj_add_standard_rate=new admin;
$obj_ven_st_rt=new admin;
$obj_dup_event_type=new admin;
$obj_dup_cat=new admin;
$obj_add_venue_type=new admin;
$obj_add_venue_cat=new admin;
$obj_add_saved=new admin;

$_SESSION['performer_unique_id'] = time();

// add duplicate Performer 
$performer_id = $_REQUEST['performer_id'];
$obj_performer->get_performer_pid($performer_id);
$obj_performer->next_record();

// =====================================================

$performer_name_sp = addslashes($obj_performer->f('performer_name_sp'));
$performer_name_en = addslashes($obj_performer->f('performer_name_en'));

$performer_short_add_sp = addslashes($obj_performer->f('performer_short_add_sp'));
$performer_short_add_en = addslashes($obj_performer->f('performer_short_add_en'));

$performer_state = addslashes($obj_performer->f('performer_state'));
$performer_county = addslashes($obj_performer->f('performer_county'));
$performer_city = addslashes($obj_performer->f('performer_city'));
$performer_zip = addslashes($obj_performer->f('performer_zip'));
if($performer_zip=="Zipcode"){
	$performer_zip = '';
}

$performer_address = addslashes($obj_performer->f('performer_address'));
if($performer_address=="*Address"){
	$performer_address = '';
}
$performer_contact_name = addslashes($obj_performer->f('performer_contact_name'));
$performer_phone = $obj_performer->f('performer_phone');
$performer_fax=$obj_performer->f('performer_fax');
$performer_cell=$obj_performer->f('performer_cell');
$performer_email=$obj_performer->f('performer_email');
$performer_url=$obj_performer->f('performer_url');
$avail_performanace=$obj_performer->f('avail_performanace');
$manager_name=$obj_performer->f('manager_name');
$manager_phone = addslashes($obj_performer->f('manager_phone'));
$manager_fax = addslashes($obj_performer->f('manager_fax'));
$manager_cell = addslashes($obj_performer->f('manager_cell'));
$manager_email = $obj_performer->f('manager_email');
$manager_url = $obj_performer->f('manager_url');
$performer_description_sp = addslashes($obj_performer->f('performer_description_sp'));
$performer_description_en = addslashes($obj_performer->f('performer_description_en'));
$performer_tags = addslashes($obj_performer->f('performer_tags'));
$privacy = $obj_performer->f('privacy');
$st_rate = $obj_performer->f('st_rate');
$activate_status = 1;
$file_name = $obj_performer->f('performer_photo');

// Add Performer
$last_performer_id = $obj_add_saved->addSavedPerformer($_SESSION['ses_user_id'],$performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$_SESSION['performer_unique_id']);

// Add Performer rate
$obj_ven_st_rt->getStandardRate($performer_id);
if($obj_ven_st_rt->num_rows()){
	while($obj_ven_st_rt->next_record()){
		
		$obj_add_standard_rate->addStandardRatesEDIT($_SESSION['performer_unique_id'],$obj_ven_st_rt->f('rate_name_en'),$obj_ven_st_rt->f('rate_name_sp'),$obj_ven_st_rt->f('description_en'),$obj_ven_st_rt->f('description_sp'),$obj_ven_st_rt->f('price_mx'),$obj_ven_st_rt->f('price_us'),$last_performer_id);
		
	}
}

// Performer Types BY Performer ID details
$obj_dup_event_type->getPertypes($performer_id);
if($obj_dup_event_type->num_rows()){
	while($obj_dup_event_type->next_record()){
		// Add Performer type
		$obj_add_venue_type->addperformertype($obj_dup_event_type->f('performer_master_type_id'),$last_performer_id);
	}
	
}

// Performer Category details
$obj_dup_cat->getCatPerformer($performer_id);
if($obj_dup_cat->num_rows()){
	while($obj_dup_cat->next_record()){
		// Add Performer Category
		$obj_add_venue_cat->addSavedCatByPerfrm($obj_dup_cat->f('category_id'),$last_performer_id);
	}
	
}

header("Location:".$obj_base_path->base_path()."/admin/edit-performer/".$last_performer_id."");
exit;




?>
