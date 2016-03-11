<?php
// event
//include file
include('../include/admin_inc.php');
//create object
$objlist=new admin;
$obj=new admin;
$obj_thumb = new admin;
$obj_add_price = new admin;
$obj_edit_price = new admin;
$obj_list_price = new admin;
$obj_edit_step1 = new admin;
$obj_edit_step2 = new admin;
$obj_edit_step3 = new admin;
$obj_edit_step4 = new admin;
$obj_event_venue = new admin;
$obj_cat = new admin;
$obj_step = new admin;
$obj_venue = new admin;
$obj_url = new admin;
$obj_tmp = new admin;
$obj_coupon = new admin;
$obj_edit = new admin;
$obj_event = new admin;
$obj_add = new admin;
$obj_question = new admin;
$obj_adminOption = new admin;
$obj_adminOption2 = new admin;
$obj_add_ser_fee = new admin;
$obj_edit_ser_fee = new admin;

//session value
$admin_id=$_SESSION['ses_user_id'];
$organization_id=$_SESSION['ses_organization_id'];


if($_REQUEST['event_id']){
	$obj->getEvent($_REQUEST['event_id']);
	$obj->next_record();
	
	//venue detail
	$obj_venue->getVenueById($obj->f('venue'),$obj->f('organization_id'));
	$obj_venue->next_record();
	
	//Check Option # 2
	//$obj_adminOption2->service_fee_option_two($_REQUEST['event_id']);
	//$obj_adminOption2->next_record();
	
}	

// Check Ticket Seller who chooses option # 2...
//$obj_adminOption->getTPaymentType($admin_id);

if(isset($_POST['Submit1'])){
	//post values
	//$event_name=mysql_real_escape_string($_POST['event_name']);
	$event_name=$_POST['event_name'];
	
	
	if($_POST['event_type']==1)
	{	
		$event_am_pm=$_POST['event_am_pm'];
		$event_hr=$_POST['event_hr'];
		$event_min=$_POST['event_min'];
		$event_month=$_POST['event_month'];
		$event_day=$_POST['event_day'];
		$event_year=$_POST['event_year'];
		
		if($event_am_pm=="pm")
		{
			$event_hr=$event_hr + 12;
		}
		$event_date=$event_year."-".$event_month."-".$event_day." ".$event_hr.":".$event_min.":00";
	}
	
	$venue=$_POST['venue'];
	$description=addslashes($_POST['description']);
	
	$on_sale_am_pm=$_POST['on_sale_am_pm'];
	$on_sale_hr=$_POST['on_sale_hr'];
	$on_sale_min=$_POST['on_sale_min'];
	$on_sale_month=$_POST['on_sale_month'];
	$on_sale_day=$_POST['on_sale_day'];
	$on_sale_year=$_POST['on_sale_year'];
	
	if($on_sale_am_pm=="pm")
	{
	$on_sale_hr=$on_sale_hr + 12;
	}
	$on_sale_date=$on_sale_year."-".$on_sale_month."-".$on_sale_day." ".$on_sale_hr.":".$on_sale_min.":00";
	
	$sale_close_am_pm=$_POST['sale_close_am_pm'];
	$sale_close_hr=$_POST['sale_close_hr'];
	$sale_close_min=$_POST['sale_close_min'];
	$sale_close_month=$_POST['sale_close_month'];
	$sale_close_day=$_POST['sale_close_day'];
	$sale_close_year=$_POST['sale_close_year'];
	
	if($sale_close_am_pm=="pm")
	{
	$sale_close_hr=$sale_close_hr + 12;
	}
	$sale_close_date=$sale_close_year."-".$sale_close_month."-".$sale_close_day." ".$sale_close_hr.":".$sale_close_min.":00";
	$category_id=$_POST['category_id'];
	$age=$_POST['age'];
	//$event_web_site=mysql_real_escape_string($_POST['event_web_site']);
	$event_web_site=($_POST['event_web_site']);
	$send_newsletter=$_POST['send_newsletter'];
	
	//validation
	$err=array();
	if($event_name=='')
	$err[1]="Event Name is required";
	if($event_month<=0 || $event_day<=0 || $event_year<=0)
	$err[2]="Event date is required";
	if($venue=='')
	$err[3]="Venue is required";
	if($description=='')
	$err[4]="Description is required";
	if($on_sale_month<=0 || $on_sale_day<=0 || $on_sale_year<=0)
	$err[5]="On sale date is required";
	if($sale_close_month<=0 || $sale_close_day<=0 || $sale_close_year<=0)
	$err[6]="Sale close date is required";
	if($category_id=='')
	$err[7]="Category is required";
	if($age=='')
	$err[8]="Age is required";	
	
	if(!count($err)>0){
		
		if($_POST['event_id']==''){	
			
			$tmp_image=$_FILES['event_image']['tmp_name'];
			if(is_uploaded_file($tmp_image)){
				$event_image=time()."_".$_FILES['event_image']['name'];
				move_uploaded_file($tmp_image,"../files/event/".$event_image);
				$obj_thumb->create_thumbnail("../files/event/".$event_image,"../files/event/thumb/".$event_image,260,180);
				$obj_thumb->create_thumbnail("../files/event/".$event_image,"../files/event/thumb1/".$event_image,69,52);
			}
			
			$tmp_icon_image=$_FILES['icon_image']['tmp_name'];
			if(is_uploaded_file($tmp_icon_image)){
				$icon_image=time()."_".$_FILES['icon_image']['name'];
				move_uploaded_file($tmp_icon_image,"../files/ticket_icon/".$icon_image);
				$obj_thumb->create_thumbnail("../files/ticket_icon/".$icon_image,"../files/ticket_icon/thumb/".$icon_image,260,180);
				$obj_thumb->create_thumbnail("../files/ticket_icon/".$icon_image,"../files/ticket_icon/thumb1/".$icon_image,69,52);
			}
			
			//add event
			$last_event_id=$objlist->add_event($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$icon_image,$admin_id,$organization_id,$send_newsletter);
			//set step
			$obj_step->event_step_no($last_event_id,1);
			//set session value
			$_SESSION['ses_event_add_step']=1;
			//redirect
			header("Location:event1/".$last_event_id."/step/2");
			
		}
		else{
			
			$event_id=$_REQUEST['event_id'];
			//upload images
			
			if(is_uploaded_file($_FILES['event_image']['tmp_name'])){
				@unlink("../files/event/".$_POST['old_event_image']);
				@unlink("../files/event/thumb/".$_POST['old_event_image']);
				@unlink("../files/event/thumb1/".$_POST['old_event_image']);
				$event_image=time()."_".$_FILES['event_image']['name'];
				$tmp_image=$_FILES['event_image']['tmp_name'];
				move_uploaded_file($tmp_image,"../files/event/".$event_image);
				$obj_thumb->create_thumbnail("../files/event/".$event_image,"../files/event/thumb/".$event_image,260,180);
				$obj_thumb->create_thumbnail("../files/event/".$event_image,"../files/event/thumb1/".$event_image,69,52);
			}
			else
			$event_image=$_POST['old_event_image'];
			
			
			if(is_uploaded_file($_FILES['icon_image']['tmp_name'])){
				@unlink("../files/ticket_icon/".$_POST['old_icon_image']);
				@unlink("../files/ticket_icon/thumb/".$_POST['old_icon_image']);
				@unlink("../files/ticket_icon/thumb1/".$_POST['old_icon_image']);
				$icon_image=time()."_".$_FILES['icon_image']['name'];
				$tmp_icon_image=$_FILES['icon_image']['tmp_name'];
				move_uploaded_file($tmp_icon_image,"../files/ticket_icon/".$icon_image);
				$obj_thumb->create_thumbnail("../files/ticket_icon/".$icon_image,"../files/ticket_icon/thumb/".$icon_image,260,180);
				$obj_thumb->create_thumbnail("../files/ticket_icon/".$icon_image,"../files/ticket_icon/thumb1/".$icon_image,69,52);
			}
			else
			$icon_image=$_POST['old_icon_image'];
			
			//edit event
			$obj_edit_step1->edit_event_step_1($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$icon_image,$event_id,$send_newsletter);
			//set step
			$obj_step->event_step_no($event_id,1);
		}
	}
}
 /*?>
if(isset($_POST['submit2'])){
	//post value
	$step_id=$_REQUEST['step'];
	//$price_name=mysql_real_escape_string($_POST['price_name']);
	$price_name=($_POST['price_name']);
	$price_amount=$_POST['price_amount'];
	if($_POST['ticket_limit'])
	$ticket_limit=$_POST['ticket_limit'];
	else
	$ticket_limit=10;
	$price_status=$_POST['price_status'];
	//$price_description=mysql_real_escape_string($_POST['price_description']);
	$price_description=($_POST['price_description']);
	$event_id=$_POST['event_id'];
	$price_level_id=$_POST['price_level_id'];
	
	if($price_level_id=='')
	$obj_add_price->add_event_price($price_name,$price_amount,$ticket_limit,$price_status,$price_description,$event_id);
	else
	$obj_edit_price->edit_event_price($price_name,$price_amount,$ticket_limit,$price_status,$price_description,$event_id,$price_level_id);
	
	//set step
	$obj_step->event_step_no($event_id,2);
	
	header("location:".$obj_base_path->base_path()."/admin/event/".$event_id."/step/".$step_id);
	//exit;
	
}

if(isset($_POST['Submit3'])){
	
	//post value
	$print_at_home=$_POST['print_at_home'];
	$event_id=$_POST['event_id'];
	$print_date_enable=$_POST['print_date_enable'];
	$print_date_disable=$_POST['print_date_disable'];
	$will_call=$_POST['will_call'];
	$will_date_enable=$_POST['will_date_enable'];
	$will_date_disable=$_POST['will_date_disable'];
	$print_add_desc=$_POST['print_add_desc'];
	$will_add_desc=$_POST['will_add_desc'];
	$donation_enable=$_POST['donation_enable'];
	$donation_name=$_POST['donation_name'];
	$online_service_fee=$_POST['online_service_fee'];
	$ticket_note=$_POST['ticket_note'];
	$ticket_transaction_limit=$_POST['ticket_transaction_limit'];
	$checkout_time_limit=$_POST['checkout_time_limit'];
	$private_event=$_POST['private_event'];
	$url_short_name=$_POST['url_short_name'];
	$custom_fee=$_POST['custom_fee'];
	$custom_fee_name=$_POST['custom_fee_name'];
	$custom_fee_type=$_POST['custom_fee_type'];
	$custom_fee_amt=$_POST['custom_fee_amt'];
	$custom_apply_fee=$_POST['custom_apply_fee'];	
	
	$err=array();
	if($print_at_home=='')
	{
	$err[1]="Select atleast one option.";
	}elseif($print_at_home=='3')
	{
		if($print_date_enable=='' || $print_date_enable=='0000-00-00 00:00:00')
		{
		$err[2]="Select print enable date.";
		}
		if($print_date_disable=='' || $print_date_disable=='0000-00-00 00:00:00')
		{
		$err[3]="Select print disable date.";
		}
	}
	if($will_call=='')
	{
	$err[4]="Select atleast one option.";
	}elseif($will_call=='3')
	{
		if($will_date_enable=='' || $will_date_enable=='0000-00-00 00:00:00')
		{
		$err[5]="Select will call enable date.";
		}
		if($will_date_disable=='' || $will_date_disable=='0000-00-00 00:00:00')
		{
		$err[6]="Select will call disable date.";
		}
	}
	
	if (!count($err)>0)
	{
	if ($url_short_name!="") 
	{
	//url present check
	$obj_url->url_present_check($url_short_name,$event_id);
	}
	//echo $obj_url->num_rows();
	//exit;
	if(!$obj_url->num_rows()>0){
		
	// Check and Set service Fee For Option # 2
		if(($obj_adminOption->num_rows()>0) && $_POST['service_fee_val']!="")
		{
			if($obj_adminOption2->f('service_fee'))
			{
				// Edit Service Fee...
				$obj_edit_ser_fee->edit_service_fee_OptionTwo($event_id,$_POST['service_fee_val']);
			}
			else
			{
				// Add Service Fee...
				$obj_add_ser_fee->add_service_fee_OptionTwo($event_id,$admin_id,$_POST['service_fee_val']);
			}
		}
		
	//edit event 3
	$obj_edit_step3->edit_step3_event($print_at_home,$print_date_enable,$print_date_disable,$will_call,$will_date_enable,$will_date_disable,$print_add_desc,$will_add_desc,$donation_enable,$donation_name,$online_service_fee,$ticket_note,$ticket_transaction_limit,$checkout_time_limit,$private_event,$url_short_name,$custom_fee,$custom_fee_name,$custom_fee_type,$custom_fee_amt,$custom_apply_fee,$event_id);
	
	//set step
	$obj_step->event_step_no($event_id,3);
	//header("location:".$obj_base_path->base_path()."/admin/event/".$event_id."/step/".$step_id);
	header("location:".$obj_base_path->base_path()."/admin/event/".$event_id."/step/4");
	}
	else{
		$err['url_short_name']="Please enter different URL Short Name";
	}
	}
}
if(isset($_POST['Submit4'])){
	//post value
	$event_id=$_POST['event_id'];
	
	//edit event 4
	$obj_edit_step4->edit_step4_event($event_id);
	$err=array();
	$err[0]="Your Event has successfully been Launched!!";
	//set step
	$obj_step->event_step_no($event_id,4);
	//event_launch_mail
	
}


if(isset($_POST['submit5'])){
	
	//post value
	$event_id=$_POST['event_id'];
	$inventory_capacity=$_POST['inventory_capacity'];
	$obj_edit_step2->edit_inventory_capacity($inventory_capacity,$event_id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/event/".$event_id."/step/2");
}
if($_REQUEST['pause-sales']=='yes'){
	$event_id=$_REQUEST['event_id'];
	//event pause
	$obj_edit->event_pause_sales($event_id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/event/".$event_id);
}

if($_REQUEST['unpause-sales']=='yes'){
	$event_id=$_REQUEST['event_id'];
	//event unpause
	$obj_edit->event_unpause_sales($event_id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/event/".$event_id);
}
//delete
if($_REQUEST['delete']=='yes'){
	$event_id=$_REQUEST['event_id'];
	//event delete
	$obj_edit->delete_event_byid($event_id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/events");
}
//delete question
if($_REQUEST['question']=='yes'){
	$id=$_REQUEST['id'];
	//question delete
	$event_id=$obj_edit->delete_event_question_byid($id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/event/".$event_id);
}
//delete coupon
if($_REQUEST['coupon']=='yes'){
	$id=$_REQUEST['id'];
	//question delete
	$coupon_id=$obj_edit->delete_event_coupon_byid($id);
	//redirect
	header("Location:".$obj_base_path->base_path()."/admin/event/".$coupon_id);
}

//duplicate submit
if(isset($_POST['duplicate_submit'])){

	//post value
	$event_id=$_POST['event_id'];
	$event_name=$_POST['event_name'];
	$event_date=$_POST['event_date'];
	$venue=$_POST['venue'];
	$url_short_name=$_POST['url_short_name'];
		
	//event detail
	$obj_event->event_detail_by_id($event_id);
	$obj_event->next_record();
	
	$new_event_id=$obj_edit->copy_event($event_id,$event_name,$event_date,$venue,$url_short_name);
	
	//insert question
	$obj_edit->question_event_by_event_id($event_id);
	while($obj_edit->next_record()){
		
		$obj_add->add_question_to_event($new_event_id,$obj_edit->f('question_id'));
		
	}
	//event price
	$obj_edit->event_price_list_all($event_id);
	while($obj_edit->next_record()){
	
		$obj_add->copy_price_level($obj_edit->f('price_name'),$obj_edit->f('price_amount'),$obj_edit->f('ticket_limit'),$obj_edit->f('price_status'),$obj_edit->f('price_description'),$new_event_id,$obj_edit->f('price_level_status'));
	
	}
}

 
 <?php */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our site</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<!--jquery alert-->
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.alerts.js" type="text/javascript"></script>
<!--jquery alert-->
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->
<link rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" type="text/css" media="all">
<!-- <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-1.4.2.js" ></script>-->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#duplicate_event").fancybox();
});

//alert
$(document).ready(function() {
	$("#confirm_delete").click(function(){
		jConfirm("Are you certain you want to delete this?", "Delete?", function(response) {
                     if (!response)
					 return false;	
					 else
                     window.location = '<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/delete';
		});
		
	});
	
});
function confirm_delete_question(id){
	
		jConfirm("Are you certain you want to delete this?", "Delete?", function(response) {
                     if (!response)
					 return false;	
					 else
                     window.location = '<?php echo $obj_base_path->base_path(); ?>/admin/event/'+id+'/question';
		});
		
	
	}
	
function confirm_delete_coupon(id){
	
		jConfirm("Are you certain you want to delete this?", "Delete?", function(response) {
                     if (!response)
					 return false;	
					 else
                     window.location = '<?php echo $obj_base_path->base_path(); ?>/admin/event/'+id+'/coupon';
		});
		
	
	}	
	
	

</script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript">
//calendar
 $(function() {
	/* $('#on_sale_date').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});
	*/
	/*$('#sale_close_date').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});*/
	
	$('#event_month').datepicker({
		showButtonPanel: true,
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month']").val(n[0]);
		$("input[name='event_day']").val(n[1]);
		$("input[name='event_year']").val(n[2]);
		}
	});
	
	$('#event_date').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month']").val(n[0]);
		$("input[name='event_day']").val(n[1]);
		$("input[name='event_year']").val(n[2]);
		}
	});
	
	$('#event_year').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month']").val(n[0]);
		$("input[name='event_day']").val(n[1]);
		$("input[name='event_year']").val(n[2]);
		}
	});
	
	$('#on_sale_month').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='on_sale_month']").val(n[0]);
		$("input[name='on_sale_day']").val(n[1]);
		$("input[name='on_sale_year']").val(n[2]);
		}
	});
	
	$('#on_sale_day').datepicker({
    onClose:function(theDate) {
	var n=theDate.split("/");
		$("input[name='on_sale_month']").val(n[0]);
		$("input[name='on_sale_day']").val(n[1]);
		$("input[name='on_sale_year']").val(n[2]);
		}
	});
	
	$('#on_sale_year').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='on_sale_month']").val(n[0]);
		$("input[name='on_sale_day']").val(n[1]);
		$("input[name='on_sale_year']").val(n[2]);
		}
	});
	
	$('#sale_close_month').datepicker({
	//minDate: +5, 
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='sale_close_month']").val(n[0]);
		$("input[name='sale_close_day']").val(n[1]);
		$("input[name='sale_close_year']").val(n[2]);
		}
	});
	
	$('#sale_close_day').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='sale_close_month']").val(n[0]);
		$("input[name='sale_close_day']").val(n[1]);
		$("input[name='sale_close_year']").val(n[2]);
		}
	});
	
	$('#sale_close_year').datepicker({
    onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='sale_close_month']").val(n[0]);
		$("input[name='sale_close_day']").val(n[1]);
		$("input[name='sale_close_year']").val(n[2]);
		}
	});
 
	/*$('#event_date').datetimepicker({
		showSecond: false,
		showMinute: false,
		showHour: false,
		dateFormat: 'yy:mm:dd'
	});*/
	
	$('#print_date_enable').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});
	
	$('#print_date_disable').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});
	$('#will_date_enable').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});
	
	$('#will_date_disable').datetimepicker({
		showSecond: true,
		dateFormat: 'yy:mm:dd',
		timeFormat: 'hh:mm:ss',
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 10
	});	
	
});
//add description
$(document).ready(function() {
	 $('#event_name').tipsy({gravity: 'w'});
	$('#event_date_div').tipsy({gravity: 'w'});
	//$('#event_am_pm').tipsy({gravity: 'w'});
//	$('#event_hr').tipsy({gravity: 'w'});
//	$('#event_min').tipsy({gravity: 'w'});
	$('#select_venue').tipsy({gravity: 'w'});
	$('#description').tipsy({gravity: 'w'});
	$('#on_sale_date').tipsy({gravity: 'w'});
	$('#sale_close_date').tipsy({gravity: 'w'});
	
	$('#category_id').tipsy({gravity: 'w'});
	$('#age').tipsy({gravity: 'w'});
	$('#event_web_site').tipsy({gravity: 'w'});
	$('#event_image').tipsy({gravity: 'w'});
	$('#icon_image').tipsy({gravity: 'w'});
	$('#print_at_home').tipsy({gravity: 'w'});
	$('#will_call').tipsy({gravity: 'w'});
	$('#donation').tipsy({gravity: 'w'});
	$('#custom_fee').tipsy({gravity: 'w'});
	$('#online_service_fee').tipsy({gravity: 'w'});
	$('#ticket_note').tipsy({gravity: 'w'});
	$('#ticket_transaction_limit').tipsy({gravity: 'w'});
	$('#checkout_time_limit').tipsy({gravity: 'w'});
	$('#private_event').tipsy({gravity: 'w'});
	$('#url_short_name').tipsy({gravity: 'w'});
	
	
	
	$('#print_add_desc_link').click(function(){
		$('#print_add_desc_tr').toggle();	
	});	
	$('#print_at_home1').click(function(){
		$('#print_set_date_tr').hide();	
	});
	$('#print_at_home2').click(function(){
		$('#print_set_date_tr').hide();	
	});
	$('#print_at_home3').click(function(){
		$('#print_set_date_tr').show();	
	});	
	$('#will_add_desc_link').click(function(){
		$('#will_add_desc_tr').toggle();	
	});	
	$('#will_call1').click(function(){
		$('#will_set_date_tr').hide();	
	});
	$('#will_call2').click(function(){
		$('#will_set_date_tr').hide();	
	});
	$('#will_call3').click(function(){
		$('#will_set_date_tr').show();	
	});
	$('#donation_enable1').click(function(){
		$('#donation_enable_table').show('slow');	
	});
	$('#donation_enable2').click(function(){
		$('#donation_enable_table').hide('slow');	
	});
	
	$('#custom_fee1').click(function(){
		$('#custom_fee_table').show('slow');	
	});
	$('#custom_fee2').click(function(){
		$('#custom_fee_table').hide('slow');	
	});
	//alert box
	$('#event_type2').click(function(){
		jAlert('To create an event series, add the details of the first event in the series below. After setting up the first event, you will create the schedule for the rest of the series.', 'Event Series');
	});
	//This page is asking you to confirm that you want to leave - data you have entered may not be saved. alert
	//event_name
	$("#event_name").keypress(function() {
		$("#change_data").val(1);
	});
	//alert if you change any thing
	$('#step_link1').click(function(){
		var textchange_val=$("#change_data").val();
		if(textchange_val){
			var answer = confirm("This page is asking you to confirm that you want to leave - data you have entered may not be saved.");
			if (answer)
			return true;
			else
			return false;
		}		
	});	
	//alert if you change any thing
	$('#step_link2').click(function(){
		var textchange_val=$("#change_data").val();
		if(textchange_val){
			var answer = confirm("This page is asking you to confirm that you want to leave - data you have entered may not be saved.");
			if (answer)
			return true;
			else
			return false;
		}		
	});	
	//alert if you change any thing
	$('#step_link3').click(function(){
		var textchange_val=$("#change_data").val();
		if(textchange_val){
			var answer = confirm("This page is asking you to confirm that you want to leave - data you have entered may not be saved.");
			if (answer)
			return true;
			else
			return false;
		}		
	});		
});

function delete_price_level(price_level_id,event_id){
	//var re_value=jConfirm('Are you certain you want to delete this?', 'Delete price level');
	var answer = confirm("Are you certain you want to delete this?")
	if (answer){
		
		$.post("<?php echo $obj_base_path->base_path(); ?>/admin/ajax_price_level", {price_level_id: ""+price_level_id+"",event_id: ""+event_id+"" }, function(data){
			if(data.length >0) {
				//alert(data);
				$("#price_level_div").html(data);
			}
		});	
		
	}	else{
		return false;
		//alert("Thanks for sticking around!")
	}
	
}
</script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$("#add_price_level").fancybox();
	$("#event_venue").fancybox();	
	$("#current_img").fancybox();
	$("#current_icon_img").fancybox();
	$("#facebook_post").fancybox();
	$("#twitter_post").fancybox();
	
});
</script>
<!--jQuery lightBox plugin>-->

<script type="text/javascript">
function setCurDTTMOnsale()
{
	var today = new Date();
	var curYear = today.getFullYear();
	var curDate = today.getDate();
	var curMon = today.getMonth();
	var curhours = today.getHours();
	var curMin = today.getMinutes();
	if(curhours > 12)
		var HourValue = curhours - 12;
	else
		var HourValue = curhours;
		
	if(curMon < 10)	
		curMon = "0"+curMon;
		
	if(curDate < 10)	
		curDate = "0"+curDate;
		
	$('#on_sale_month').val(curMon);
	$('#on_sale_day').val(curDate);
	$('#on_sale_year').val(curYear);
	$('#on_sale_hr').val(HourValue);
	$('#on_sale_min').val(curMin);
		
	if(curhours > 12)
	{
		$('#on_sale_am_pm').val("pm");
	}
	else if(curhours <= 12)
	{
		$('#on_sale_am_pm').val("am");
	}
}
</script>

<script type="text/javascript">
function show_event_type()
{
	$('#multi_event_fun').hide();
	
	if($('#event_type').val()==2)
		$('#multi_event_fun').show();
}

function showTimeMore()
{
	$('#addtime').append($('#dateTime').html());
}
</script>



</head>
<body>
<!--start maincontainer-->
<div id="maincontainer">
  <!--start head-->
  <?php include("header.php")?>
  <!--start body-->
  <section id="body">
  <div class="body2">
    <div class="clear"></div>
    <?php include("top_menu.php");?>
	<?php include("sidebar.php");  ?>
<div id="coupon_admin1" style="margin: 4px 8px;">
  <div class="custom_box">
    <?php 
  if (($_REQUEST['step']=='' && $_REQUEST['event_id']=='') || $_REQUEST['step']==1){ ?>
    <div class="inner_box">
      <div>
        <h5><?php echo $obj->f('event_name'); ?></h5>
      </div>
      <div class="step">
        <ul>
          <li ><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event1/<?php echo $_REQUEST['event_id']; ?>/step/1" id="step_link1" <?php if($_REQUEST['step']==1) echo 'class="here"'; else echo 'class="link"'; ?>>Step 1</a></li>
          <li >
            <?php if($obj->f('event_step')>=1){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event1/<?php echo $_REQUEST['event_id']; ?>/step/2"  id="step_link2" <?php if($_REQUEST['step']==2) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 2
            <?php if($obj->f('event_step')>=1){ ?>
            </a>
            <?php }?>
          </li>
          <li >
            <?php if($obj->f('event_step')>=2){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/3/" id="step_link3" <?php if($_REQUEST['step']==3) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 3
            <?php if($obj->f('event_step')>=2){ ?>
            </a>
            <?php }?>
          </li>
          <?php if ($obj->f('event_launch')!=1) {?>
          <li >
            <?php if($obj->f('event_step')>=3){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/4/" id="step_link4" <?php if($_REQUEST['step']==4) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 4 Launch
            <?php if($obj->f('event_step')>=3){ ?>
            </a>
            <?php }?>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="clear"></div>
      <div class="inner_box2_1">
        <form action="" method="post" enctype="multipart/form-data">
          <input type="text" name="event_id" value="<?=$obj->f('event_id')?>" />
          <input type="hidden" name="change_data" id="change_data" value="" />
          <div width="600" border="0" cellspacing="2" cellpadding="6">
            <?php 
				if(count($err)>0){		
			?>
            <div>
              <div colspan="3">
                <div style="border:1px solid #ccc;">
                  <div>
                    <div>
                      <div>
                        <div class="alertmsg" style="width:300px;" >
                          <div style="font: normal 12px/16px Arial, Helvetica, sans-serif; color:#000000;margin-left:50px;">This form has errors. </div>
                        </div>
                        <?php for($i=1;$i<8; $i++) {
					  if($err[$i]!=''){		  
					  ?>
                        <div>
                          <div style="font: normal 12px/16px Arial, Helvetica, sans-serif; color:#000000;margin-left:50px;padding:10px;"><?php print($err[$i]); ?></div>
                        </div>
                        <?php 
						}
					  }
					  ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php }?>
            <!--------------------------------------------------------------------------------------------------------------->
            <div class="box_in">
              <div class="event_box">type of Event </div>
              <div class="event_box_right">
                <ul>
                  <li>
                  	<select name="event_type" id="event_type" onchange="show_event_type()" style="width:180px;">
                    	<option value="1">Single Event</option>
                    	<option value="2">Event With Multiple Function</option>
                    	<option value="3">Recurring Event</option>
                    	<option value="4">Event with Programs</option>
                    </select>
                  
                    <!--<input type="radio" name="event_type" id="radio" value="1" checked="checked">-->
                  </li>
                </ul>
              </div>
            </div>
            <div class="clear"></div>
            <!-------------------------------------------------------------------------------------------------------------->
            <!----------------------------------------------------------------------------->
            <div class="box_in">
              <div class="event_box" style="float: left;">event name<span>*</span></div>
              <div class="event_box_right">
                <input type="text" class="text_field2_1" name="event_name" id="event_name" value="<?php if($_POST['event_name']) echo $_POST['event_name']; else echo $obj->f('event_name'); ?>" title="Please enter an event name"/>
              </div>
            </div>
            <div class="clear"></div>
            <?php if ($err['event_name']){ ?>
            <div>
              <div>&nbsp;</div>
              <div>
                <?=$err['event_name']?>
              </div>
            </div>
            <?php }?>
            <?php 
				 $eventdate=$obj->f('event_date');
				 $hourSelectedEvent = date("H",strtotime($eventdate));
			?>
            <div class="box_in">
              <div class="event_box">event date<span>*</span></div>
              <div class="event_box_right">
                <div class="event_left_inner" title="Please select valid event date" id="event_date_div">
				 <ul>
                   <li>
                      <input name="event_month" id="event_month" type="text" value="<?php if($_POST['event_month']) 
						echo $_POST['event_month']; 
						elseif(!empty($eventdate))
						echo date("m",strtotime($eventdate));
						else
						echo "00";
						?>"  class="text_field_mo">
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="event_day" id="event_date" type="text" value="<?php if($_POST['event_day']) echo $_POST['event_day']; elseif(!empty($eventdate)) echo date("d",strtotime($eventdate)); else echo "00";?>" class="text_field_mo">
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="event_year" id="event_year" type="text" value="<?php if($_POST['event_year']) echo $_POST['event_year']; elseif(!empty($eventdate)) echo date("Y",strtotime($eventdate)); else echo "0000";?>" class="text_field_yr">
                    </li>
                    <li>Month/Day/Year</li>
				 </ul>
				 <ul style="float:left; padding-top:5px;" id="dateTime">
					<li>
						<select name="event_hr" class="selectbg" id="event_hr" title="Please select event hour" style="width:40px;float:left;">
						  <?php 
						  for($i=0; $i<13; $i++) {
						  ?>
						  <option value="<?php echo $i; ?>" <?PHP if($i==$_POST['event_hr'] || $i==date("h",strtotime($eventdate))) {echo 'selected="selected"';}?>><?php if($i<=9) {echo "0".$i; }else{ echo $i; }?></option>
						  <?php }?>
                    	</select>
                    </li>
                    <li><b>/</b></li>
                    <li>
						<select name="event_min" class="selectbg" id="event_min" title="Please select event miniute" style="width:40px;float:left;">
						  <?php 
						  for($j=0; $j<60; $j++) {
						  ?>
						  <option value="<?php echo $j; ?>" <?PHP if($j==$_POST['event_min'] || $j==date("i",strtotime($eventdate))) {echo 'selected="selected"';}?>><?php if($j<=9) {echo "0".$j; }else{ echo $j; }?></option>
						  <?php }?>
						  
                    </select>
                    </li>
                    <li><b>/</b></li>
                    <li>
                        <select name="event_am_pm" class="selectbg" id="event_am_pm" title="Please select AM or PM" style="width:42px;float:left;">
                              <option value="am" <?php if($hourSelectedEvent <= 12) {  ?> selected=selected <?php } ?> >AM</option>
                              <option value="pm" <?php if($hourSelectedEvent > 12) {  ?> selected=selected <?php } ?>>PM</option>
                        </select>
                    </li>
                    <li>Hour/Min</li>
                 </ul>
                 
                 <div style="clear:both;"></div>
                 <div id="addtime" style="width:500px;">aa</div>
                <div style="clear:both;"></div>
                <ul style="float:left; padding-top:5px; width:400px; display:none;" id="multi_event_fun">
                  <li>
                  	<a onclick="showTimeMore()">Add Time / </a>
                  </li>
                  <li>
                  	<a href="#">Add Date / </a>
                  </li>
                  <li>
                  	<a href="#">Add Date Time And Venue</a>
                  </li>
                </ul>
                
                
                </div>
                <?php if ($err['event_date']){ ?>
                <div>
                  <div>&nbsp;</div>
                  <div>
                    <?=$err['event_date']?>
                  </div>
                </div>
                <?php }?>
                <div class="event_right_inner">
                  <div style="width:59px; float:left;">venue<span>*</span></div>
                  <div class="styled_select4" style="width:250px; float:left;" id="id_venue">
                    <select name="venue" class="selectbg" id="select_venue" title="Please select venue name" style="width:275px;padding-left:15px;float:left;">
                      <option value="1">---</option>
                      <?php 
					//live venue
					$obj_event_venue->list_venue($organization_id);
					if($obj_event_venue->num_rows()>0){
					while($obj_event_venue->next_record()){
					?>
                      <option value="<?php echo $obj_event_venue->f('venue_id'); ?>" <?php if($obj_event_venue->f('venue_id')==$obj->f('venue')) echo 'selected="selected"';  ?> ><?php echo $obj_event_venue->f('venue_name')." in ".$obj_event_venue->f('venue_city').", ".$obj_event_venue->f('venue_state'); ?></option>
                      <?php 
					}					
				}
				?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div>
              <div>&nbsp;</div>
              <div style="text-align:right !important; margin-right:13px;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event_venue?event_id=<?=$_REQUEST['event_id']?>" id="event_venue">Add New Venue</a></div>
            </div>
            <div class="box_in">
              <div class="event_box">description<span>*</span></div>
              <div class="event_box_right">
                <textarea name="description" value="" class="text_area_descrip1" title="Please enter your event description" id="description"><? if($_POST['description']) echo $_POST['description']; else echo stripslashes($obj->f('description'))?>
</textarea>
              </div>
            </div>
            <div class="clear"></div>
            <div class="sale_box" style="width:670px;">
              <div class="sale">SALE TIMES</div>
              <div class="event_box">on-sale date<span>*</span></div>
              <div class="event_box_right" style="width:auto; float:left; margin:0 10px 0 0;">
                <div class="event_left_inner2" title="Please enter on sale date" id="on_sale_date">
                  <?php 
				  	 $onsaledate=$obj->f('on_sale_date');
					 $hourSelected = date("H",strtotime($onsaledate));
					?>
                  <ul>
                    <li>
                      <input name="on_sale_month" id="on_sale_month" type="text" value="<?php if($_POST['on_sale_month']) 
						echo $_POST['on_sale_month']; 
						elseif(!empty($onsaledate))
						echo date("m",strtotime($onsaledate));
						else
						echo "00";
						?>"  class="text_field_mo">
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="on_sale_day" id="on_sale_day" type="text" value="<?php if($_POST['on_sale_day']) echo $_POST['on_sale_day']; elseif(!empty($onsaledate)) echo date("d",strtotime($onsaledate)); else echo "00";?>" class="text_field_mo"><input name="sale_start" id="sale_start" type="hidden" />
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="on_sale_year" id="on_sale_year" type="text" value="<?php if($_POST['on_sale_year']) echo $_POST['on_sale_year']; elseif(!empty($onsaledate)) echo date("Y",strtotime($onsaledate)); else echo "0000";?>" class="text_field_yr">
                    </li>
                    <li>Mo/Day/Year</li>
                  </ul>
				  <ul style="float:left; padding-top:5px;">
					<li>
					<select name="on_sale_hr" class="selectbg" id="on_sale_hr" style="width:40px;float:left;">
						  <?php 
						  for($i=0; $i<13; $i++) {
						  ?>
						  <option value="<?php echo $i; ?>" <?PHP if($i==$_POST['on_sale_hr'] || $i==date("h",strtotime($onsaledate))) {echo 'selected="selected"';}?>><?php if($i<=9) {echo "0".$i; }else{ echo $i; }?></option>
						  <?php }?>
                    </select>
                    </li>
                    <li><b>/</b></li>
                    <li>
						<select name="on_sale_min" class="selectbg" id="on_sale_min" style="width:40px;float:left;">
						  <?php 
						  for($j=0; $j<60; $j++) {
						  ?>
						  <option value="<?php echo $j; ?>" <?PHP if($j==$_POST['on_sale_min'] || $j==date("i",strtotime($onsaledate))) {echo 'selected="selected"';}?>><?php if($j<=9) {echo "0".$j; }else{ echo $j; }?></option>
						  <?php }?>
						  
                    </select>
                    </li>
                    <li><b>/</b></li>
                    <li>
					<select name="on_sale_am_pm" class="selectbg" id="on_sale_am_pm" style="width:42px;float:left;">
						  <option value="am" <?php if($hourSelected <= 12) {  ?> selected=selected <?php } ?> >AM</option>
						  <option value="pm" <?php if($hourSelected > 12) { ?> selected=selected <?php } ?> >PM</option>
                    </select>
                    </li>
                    <li>Hour/Min</li>
                  </ul>
                  <ul>
                  	<li><div onclick="setCurDTTMOnsale()"><input name="" type="button" value="Start Sales Now" class="time_btn" /></div> </li>
                  </ul>
                  <!--<input type="text" name="on_sale_date"  value="<?php if($_POST['on_sale_date']) echo $_POST['on_sale_date']; else echo $obj->f('on_sale_date')?>" class="textbg1" />-->
                  <!---->
                  <div style="display:none;">
                    <div>&nbsp;</div>
                    <div>
                      <input type="checkbox" name="immediately_sale_date" id="immediately_sale_date" />
                      Immediately</div>
                  </div>
                  <!---->
                </div>
              </div>
              <div class="event_box" style="width:auto;">sale closing date<span>*</span></div>
              <div class="event_box_right" style="width:auto; float:left;">
                <div class="event_left_inner2"  id="sale_close_date" title="Please enter sale close date">
                  <!--<input type="text" name="sale_close_date" id="sale_close_date" title="Please enter sale close date"  value="<? if($_POST['sale_close_date']) echo $_POST['sale_close_date']; else echo $obj->f('sale_close_date')?>" class="textbg1" />-->
                  <?php 
	   				 $saleclosedate=$obj->f('sale_close_date');
					 $hourSelectedClose = date("H",strtotime($saleclosedate));
					?>
                  <ul>
                    <li>
                      <input name="sale_close_month" id="sale_close_month" type="text" value="<?php if($_POST['sale_close_month']) 
						echo $_POST['sale_close_month']; 
						elseif(!empty($saleclosedate))
						echo date("m",strtotime($saleclosedate));
						else
						echo "00";
						?>"  class="text_field_mo">
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="sale_close_day" id="sale_close_day" type="text" value="<?php if($_POST['sale_close_day']) echo $_POST['sale_close_day']; elseif(!empty($saleclosedate)) echo date("d",strtotime($saleclosedate)); else echo "00";?>" class="text_field_mo">
                    </li>
                    <li><b>/</b></li>
                    <li>
                      <input name="sale_close_year" id="sale_close_year" type="text" value="<?php if($_POST['sale_close_year']) echo $_POST['sale_close_year']; elseif(!empty($saleclosedate)) echo date("Y",strtotime($saleclosedate)); else echo "0000";?>" class="text_field_yr">
                    </li>
                    <li>Mo/Day/Year</li>
                  </ul>
				  <ul style="float:left; padding-top:5px;">
					<li>
					<select name="sale_close_hr" class="selectbg" id="sale_close_hr" title="Please select sale close hour" style="width:40px;float:left;">
						  <?php 
						  for($i=0; $i<13; $i++) {
						  ?>
						  <option value="<?php echo $i; ?>" <?PHP if($i==$_POST['sale_close_hr'] || $i==date("h",strtotime($saleclosedate))) {echo 'selected="selected"';}?>><?php if($i<=9) {echo "0".$i; }else{ echo $i; }?></option>
						  <?php }?>
                    </select>
                    </li>
                    <li><b>/</b></li>
                    <li>
						<select name="sale_close_min" class="selectbg" id="sale_close_min" title="Please select sale close miniute" style="width:40px;float:left;">
						  <?php 
						  for($j=0; $j<60; $j++) {
						  ?>
						  <option value="<?php echo $j; ?>" <?PHP if($j==$_POST['sale_close_min'] || $j==date("i",strtotime($saleclosedate))) {echo 'selected="selected"';}?>><?php if($j<=9) {echo "0".$j; }else{ echo $j; }?></option>
						  <?php }?>
						  
                    </select>
                    </li>
                    <li><b>/</b></li>
                    <li>
					<select name="sale_close_am_pm" class="selectbg" id="sale_close_am_pm" title="Please select AM or PM" style="width:42px;float:left;">
						  <option value="am" <?php if($hourSelectedClose <= 12) {  ?> selected=selected <?php } ?> >AM</option>
						  <option value="pm" <?php if($hourSelectedClose > 12) {  ?> selected=selected <?php } ?> >PM</option>
                    </select>
                    </li>
                    <li>Hour/Min</li>
                  </ul>
                </div>
              </div>
              <div> </div>
              <div class="clear"></div>
            </div>
            <div class="sale_box">
              <div class="sale">Settings</div>
              <div class="box_in">
                <div class="event_right_inner" style="margin:0 26px 0 0;">
                  <div style="width:70px; float:left;">Category<span>*</span></div>
                  <div class="styled_select4" style="width:240px; float:left;">
                    <!---->
                    <select name="category_id" class="selectbg" id="category_id" style="width:275px;padding-left:15px;float:left;" title="Please select a category name">
                      <option value="">---</option>
                      <?php 
			//category list
			$obj_cat->category_list();
			if($obj_cat->num_rows()>0){
			while($obj_cat->next_record())
			{
			?>
                      <option value="<?php echo $obj_cat->f('category_id'); ?>"  <?php if($obj_cat->f('category_id')==$obj->f('category_id')) echo 'selected="selected"'; ?> ><?php echo $obj_cat->f('category_name'); ?></option>
                      <?php } 
			}
			?>
                    </select>
                  </div>
                </div>
                <div class="event_right_inner">
                  <div style="width:40px; float:left;">ages<span>*</span></div>
                  <div class="styled_select4" style="width:240px; float:left;">
                    <select name="age" class="selectbg#" id="age" style="width:275px;padding-left:15px;float:left;" title="Please select age range">
                      <option selected="selected" value="0" <?php if(0==$obj->f('age')) echo 'selected="selected"'; ?>>All Ages</option>
                      <option value="18" <?php if(18==$obj->f('age')) echo 'selected="selected"'; ?>>18 and over</option>
                      <option value="19" <?php if(19==$obj->f('age')) echo 'selected="selected"'; ?>>19 and over</option>
                      <option value="21" <?php if(21==$obj->f('age')) echo 'selected="selected"'; ?>>21 and over</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
              <div class="box_in">
                <div class="event_box" style="float: left;">event website</div>
                <div class="event_box_right">
                  <input type="text" class="text_field2_1" id="event_web_site" title="Please enter event web site name" name="event_web_site" value="<? if($_POST['event_web_site']) echo $_POST['event_web_site']; else echo $obj->f('event_web_site')?>"/>
                </div>
              </div>
              <div class="box_in">
                <div class="event_box" style="float: left;">event flyer</div>
                <div class="event_box_right">
                  <!--<input name="" type="button" value="Choose File" class="choose_btn"> <div class="no_file">No file chosen</div>-->
                  <input type="file" name="event_image" id="event_image" title="Please select a image" />
                  <?php if($obj->f('event_image')){?>
                  <a href="<?php echo $obj_base_path->base_path(); ?>/files/event/<?=$obj->f('event_image')?>" id="current_img">View Current</a>
                  <?php }?>
                  <input type="hidden" name="old_event_image" value="<?=$obj->f('event_image')?>" />
                  <div style="float: right; width: 240px;"><span style="text-align:left;">For optimum size Upload(800 x 600)</span></div>
                </div>
              </div>
			   <div class="clear"></div>
			  <div class="box_in">
                <div class="event_box" style="float: left;">Ticket Icon</div>
                <div class="event_box_right">
                  <!--<input name="" type="button" value="Choose File" class="choose_btn"> <div class="no_file">No file chosen</div>-->
                  <input type="file" name="icon_image" id="icon_image" title="Please select a image" />
                  <?php if($obj->f('icon_image')){?>
                  <a href="<?php echo $obj_base_path->base_path(); ?>/files/ticket_icon/<?=$obj->f('icon_image')?>" id="current_icon_img">View Current</a>
                  <?php }?>
                  <input type="hidden" name="old_icon_image" value="<?=$obj->f('icon_image')?>" />
                  <div style="float: right; width: 240px;"><span style="text-align:left;">For optimum size Upload(200-300 x 100-200)</span></div>
                </div>
              </div>
			   <div class="clear"></div>
              <div class="box_in">
                <div style="width: auto; height:32px; float:right; margin:10px 8px 0 0;">
                  <input type="submit" class="btn_save" name="Submit1" value=""/>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="clear"></div>
    </div>
    <?php } elseif ($_REQUEST['step']==2){?>
    <div class="inner_box">
      <div>
        <h5><?php echo $obj->f('event_name'); ?></h5>
      </div>
      <div class="step">
        <ul>
          <li ><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event1/<?php echo $_REQUEST['event_id']; ?>/step/1/" id="step_link1" <?php if($_REQUEST['step']==1) echo 'class="here"'; else echo 'class="link"'; ?>>Step 1</a></li>
          <li >
            <?php if($obj->f('event_step')>=1){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/2/"  id="step_link2" <?php if($_REQUEST['step']==2) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 2
            <?php if($obj->f('event_step')>=1){ ?>
            </a>
            <?php }?>
          </li>
          <li >
            <?php if($obj->f('event_step')>=2){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/3/" id="step_link3" <?php if($_REQUEST['step']==3) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 3
            <?php if($obj->f('event_step')>=2){ ?>
            </a>
            <?php }?>
          </li>
          <?php if ($obj->f('event_launch')!=1) {?>
          <li >
            <?php if($obj->f('event_step')>=3){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/4/" id="step_link4" <?php if($_REQUEST['step']==4) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 4 Launch
            <?php if($obj->f('event_step')>=3){ ?>
            </a>
            <?php }?>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="clear"></div>
      <div class="inner_box2_1">
        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="event_id" value="<?=$obj->f('event_id')?>" />
		  <input type="hidden" name="step_id" value="<?php echo $_REQUEST['step']; ?>" />
		  <?php 
			  $obj_list_price->event_price_list($_REQUEST['event_id']);
		  ?>
          <table width="600" border="0" cellspacing="2" cellpadding="6">
            <tr>
              <td width="12%">&nbsp;</td>
              <td width="88%" align="center"><?php if($obj_list_price->num_rows()<=0){?>You haven't added any price levels yet. <?php }?><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_price_level?event_id=<?=$_REQUEST['event_id']?>" id="add_price_level">Add a price level to get started</a>.</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </form>
      </div>
      <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="20" /></div>
      <br />
      <?php 
		if($obj_list_price->num_rows()>0){?>
		<div id="price_level_div">
      <table align="center" width="700" border="0" cellspacing="0" cellpadding="0" class="upcoming_bg" style="width:720px;">
        <tr>
          <th width="7%" style="padding: 0 10px;">ID</th>
          <th width="21%">Name</th>
          <th width="29%">Price</th>
          <th width="12%">Limit</th>
          <th width="21%">Manage</th>
          <th width="10%" colspan="2">&nbsp;</th>
        </tr>
        <?php 
		while($obj_list_price->next_record())
		{		
		?>
        <script type="text/javascript">
		$(document).ready(function() {
			$("#edit_price_level<?php echo $obj_list_price->f('price_level_id'); ?>").fancybox();			
		});
		</script>
        <tr>
          <td width="7%" style="padding: 0 10px;"><?php echo $obj_list_price->f('price_level_id'); ?></td>
          <td width="21%"><strong><?php echo $obj_list_price->f('price_name'); ?></strong></td>
          <td width="29%"> $<?php echo number_format($obj_list_price->f('price_amount'),2); ?></td>
          <td width="12%">Limit <?php echo $obj_list_price->f('ticket_limit'); ?></td>
          <td width="9%"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /> <a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_price_level?event_id=<?=$_REQUEST['event_id']?>&price_level_id=<?php echo $obj_list_price->f('price_level_id'); ?>" id="edit_price_level<?php echo $obj_list_price->f('price_level_id'); ?>">Edit</a></td>
          <td width="9%"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /><a href="javascript:void(0);" id="delete_price_level" onclick="delete_price_level('<?php echo $obj_list_price->f('price_level_id'); ?>','<?php echo $_REQUEST['event_id']; ?>');" >Delete</a></td>
          <td width="13%">&nbsp;</td>
        </tr>
        <?php 
		}
		?>
      </table>
	  </div>
      <div class="dot_bot"><img src="images/spacer.gif" alt="" width="1" height="10" /></div>
      <form name="frm5" method="post" action="">
        <input type="hidden" name="event_id" value="<?=$obj->f('event_id')?>" />
        <table width="730" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="23%">Maximum Inventory/Capacity</td>
            <td width="20%"><input type="text" name="inventory_capacity" value="<?=$obj->f('inventory_capacity')?>" class="textbg1_new" /></td>
            <td width="4%"><input type="submit" name="submit5" value="Save" /></td>
            <td width="52%">The maximum number of tickets that can be sold for an event.</td>
          </tr>
        </table>
      </form>
      <?php } ?>
      <div class="clear"></div>
    </div>
    <?php
	} elseif($_REQUEST['step']==3){
		?>
    <div class="inner_box">
      <div>
        <h5><?php echo $obj->f('event_name'); ?></h5>
      </div>
      <div class="step">
        <ul>
          <li ><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/1/" id="step_link1" <?php if($_REQUEST['step']==1) echo 'class="here"'; else echo 'class="link"'; ?>>Step 1</a></li>
          <li >
            <?php if($obj->f('event_step')>=1){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/2/"  id="step_link2" <?php if($_REQUEST['step']==2) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 2
            <?php if($obj->f('event_step')>=1){ ?>
            </a>
            <?php }?>
          </li>
          <li >
            <?php if($obj->f('event_step')>=2){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/3/" id="step_link3" <?php if($_REQUEST['step']==3) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 3
            <?php if($obj->f('event_step')>=2){ ?>
            </a>
            <?php }?>
          </li>
          <?php if ($obj->f('event_launch')!=1) {?>
          <li >
            <?php if($obj->f('event_step')>=3){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/4/" id="step_link4" <?php if($_REQUEST['step']==4) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 4 Launch
            <?php if($obj->f('event_step')>=3){ ?>
            </a>
            <?php }?>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="clear"></div>
      <div class="inner_box2_1">
        <div>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contact_box1">
            
            <tr>
              <td style="padding: 10px 0 0 16px;"><?php 
                  if($_REQUEST['event_id']){
                    $obj->getEvent($_REQUEST['event_id']);
                    $obj->next_record();
                  }
                  
                  ?>
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="event_id" value="<?=$obj->f('event_id')?>" />
                  <table width="600" border="0" cellspacing="2" cellpadding="6">
                  <?php
				  	if($obj_adminOption->num_rows()>0)
					{
				  ?>
                    <tr>
                      <td colspan="2" style="border-bottom: 1px solid #cccccc;">
                      	<table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2"><h5>Set Service Fee</h5></td>
                          </tr>
                          <tr>
                            <td valign="top">Service Fee %</td>
                            <td><input type="text" name="service_fee_val" id="service_fee_val" class="text_field2_2" value="<?php echo $obj_adminOption2->f('service_fee');?>"  /></td>
                          </tr>
                        </table>

                      </td>
                    </tr>
                  <?php
					}
				  ?>
                    <tr>
                      <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Delivery Methods</h5>(Mandatory)</td>
                    </tr>
                    <tr>
                      <td width="91">Print At Home </td>
                      <td width="479"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr id="print_at_home" title="Print at home">
                            <td width="4%"><input name="print_at_home" type="radio" value="1"  id="print_at_home1" <?php if ($obj->f('print_at_home')==1) echo "checked"; ?>/></td>
                            <td width="18%">Always Available</td>
                            <td width="4%"><input name="print_at_home" type="radio" value="2"  id="print_at_home2" <?php if ($obj->f('print_at_home')==2) echo "checked"; ?>/></td>
                            <td width="19%">Never Available</td>
                            <td width="4%"><input name="print_at_home" type="radio" value="3"  id="print_at_home3" <?php if ($obj->f('print_at_home')==3) echo "checked"; ?>/></td>
                            <td width="37%">Set Dates </td>
                          </tr>
                          <tr>
                            <td colspan="6" style="text-align:right; padding:5px 150px 5px 0; "><a href="javascript:void(0);" id="print_add_desc_link" >Add a description</a></td>
                          </tr>
						  <?php 
						  if($err[1] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[1]; ?></td>
                          </tr>
						  <?php } ?>
                          <tr id="print_set_date_tr"  <?php if ($obj->f('print_at_home')!=3) { ?>style="display:none;" <?php }?>>
                            <td colspan="6"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                                <tr>
                                  <td>Enable On </td>
                                  <td><input type="text" name="print_date_enable" id="print_date_enable" value="<?=$obj->f('print_date_enable')?>" class="text_field2_2" /></td>
                                </tr>
                                <tr>
                                  <td>Disable On</td>
                                  <td><input type="text" name="print_date_disable" id="print_date_disable" value="<?=$obj->f('print_date_disable')?>" class="text_field2_2" /></td>
                                </tr>
                              </table></td>
                          </tr>
						  <?php 
						  if($err[2] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[2]; ?></td>
                          </tr>
						  <?php } ?>
						  <?php 
						  if($err[3] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[3]; ?></td>
                          </tr>
						  <?php } ?>
                          <tr id="print_add_desc_tr" style="display:none;">
                            <td colspan="6"><textarea name="print_add_desc" class="text_area"><?=$obj->f('print_add_desc')?>
</textarea></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>Will Call </td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr id="will_call" title="When will call">
                            <td width="4%"><input name="will_call" type="radio" value="1"  id="will_call1" <?php if ($obj->f('will_call')==1) echo "checked"; ?>/></td>
                            <td width="18%">Always Available</td>
                            <td width="4%"><input name="will_call" type="radio" value="2" id="will_call2" <?php if ($obj->f('will_call')==2) echo "checked"; ?>/></td>
                            <td width="19%">Never Available</td>
                            <td width="4%"><input name="will_call" type="radio" value="3" id="will_call3" <?php if ($obj->f('will_call')==3) echo "checked"; ?>/></td>
                            <td width="37%">Set Dates</td>
                          </tr>
                          <tr>
                            <td colspan="6" style="text-align:right; padding:5px 150px 5px 0; "><a href="javascript:void(0);" id="will_add_desc_link" >Add a description</a></td>
                          </tr>
						   <?php 
						  if($err[4] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[4]; ?></td>
                          </tr>
						  <?php } ?>
                          <tr id="will_set_date_tr" <?php if ($obj->f('will_call')!=3){ ?> style="display:none;" <?php }?>>
                            <td colspan="6"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                                <tr>
                                  <td>Enable On </td>
                                  <td><input type="text" name="will_date_enable" id="will_date_enable" value="<?=$obj->f('will_date_enable')?>" class="text_field2_2" /></td>
                                </tr>
                                <tr>
                                  <td>Disable On</td>
                                  <td><input type="text" name="will_date_disable" id="will_date_disable" value="<?=$obj->f('will_date_disable')?>" class="text_field2_2" /></td>
                                </tr>
                              </table></td>
                          </tr>
						   <?php 
						  if($err[5] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[5]; ?></td>
                          </tr>
						  <?php } ?>
						  <?php 
						  if($err[6] != "")
						  {
						  ?>
						  <tr>
                            <td colspan="6" style="text-align:left; color:#FF0000; padding:5px 150px 5px 0; "><?php echo $err[6]; ?></td>
                          </tr>
						  <?php } ?>
                          <tr id="will_add_desc_tr" style="display:none;">
                            <td colspan="6"><textarea name="will_add_desc" class="text_area"><?=$obj->f('will_add_desc')?>
</textarea></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Additional Settings</h5>(Optional)</td>
                    </tr>
                    <tr>
                    <tr>
                      <td>Ticket Note</td>
                      <td><input type="text" name="ticket_note" id="ticket_note" title="Please enter ticket notation details" value="<?=$obj->f('ticket_note')?>" class="text_field2_2" /></td>
                    </tr>
                    <!--<tr>
                      <td>Ticket Transaction Limit</td>
                      <td ><input type="text" name="ticket_transaction_limit" title="Please enter ticket transaction limit"  id="ticket_transaction_limit" value="<?=$obj->f('ticket_transaction_limit')?>" class="text_field2_2" /></td>
                    </tr>-->
                    <tr>
                      <td>Checkout Time Limit</td>
                      <td ><div class="styled_select4" style="width:250px; float:left;">
                          <select  name="checkout_time_limit" style="width:275px;padding-left:15px;float:left;" id="checkout_time_limit" title="Please choose select transaction time limit">
                            <?php for($i=5;$i<=20 ;$i++){?>
                            <option value="<?php echo $i; ?>" <?php if ($obj->f('checkout_time_limit')==$i) echo 'selected="selected"'; ?> ><?php echo $i; ?> minutes</option>
                            <?php }?>
                          </select>
                        </div>
                        <!--<select name="checkout_time_limit" class="selectbg" id="checkout_time_limit" title="Please choose select transaction time limit">
                        <?php for($i=5;$i<=20 ;$i++){?>
                        <option value="<?php echo $i; ?>" <?php if ($obj->f('checkout_time_limit')==$i) echo 'selected="selected"'; ?> ><?php echo $i; ?> minutes</option>
                        <?php }?>
                      </select>--></td>
                    </tr>
                    <tr>
                      <td>Private Event</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr id="private_event" title="Please choose if it is private event">
                            <td width="5%"><input name="private_event" type="radio" value="1" <?php if ($obj->f('private_event')==1) echo "checked"; ?>/></td>
                            <td width="26%">Yes</td>
                            <td width="5%"><input name="private_event" type="radio" value="2" <?php if ($obj->f('private_event')==2) echo "checked"; ?>/></td>
                            <td width="64%">No</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>Show Seating Chart</td>
                      <td>There is no seating chart assigned to this event's venue</td>
                    </tr>
                    <tr>
                      <td>URL Short Name</td>
                      <td><?php echo $obj_base_path->base_path(); ?>/event/
                        <input type="text" name="url_short_name" title="Please enter valid short url" id="url_short_name" value="<?=$obj->f('url_short_name')?>" class="text_field2_2" /></td>
                    </tr>
                    <?php if ($err['url_short_name']){ ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="texterr"><?=$err['url_short_name']?></td>
                    </tr>
                    <?php }?>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input type="submit" class="btn_save" name="Submit3" value=""/></td>
                    </tr>
                  </table>
                </form></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="20" /></div>
      <div class="clear"></div>
    </div>
    <?php } elseif($_REQUEST['step']==4){
	?>
    <div class="inner_box">
      <div>
        <h5><?php echo $obj->f('event_name'); ?></h5>
      </div>
      <div class="step">
        <ul>
          <li ><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/1/" id="step_link1" <?php if($_REQUEST['step']==1) echo 'class="here"'; else echo 'class="link"'; ?>>Step 1</a></li>
          <li >
            <?php if($obj->f('event_step')>=1){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/2/"  id="step_link2" <?php if($_REQUEST['step']==2) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 2
            <?php if($obj->f('event_step')>=1){ ?>
            </a>
            <?php }?>
          </li>
          <li >
            <?php if($obj->f('event_step')>=2){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/3/" id="step_link3" <?php if($_REQUEST['step']==3) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 3
            <?php if($obj->f('event_step')>=2){ ?>
            </a>
            <?php }?>
          </li>
          <?php if ($obj->f('event_launch')!=1) {?>
          <li >
            <?php if($obj->f('event_step')>=3){ ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/step/4/" id="step_link4" <?php if($_REQUEST['step']==4) echo 'class="here"'; else echo 'class="link"'; ?>>
            <?php }?>
            Step 4 Launch
            <?php if($obj->f('event_step')>=3){ ?>
            </a>
            <?php }?>
          </li>
          <?php }?>
        </ul>
      </div>
      <div class="clear"></div>
      <div class="inner_box2_1">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contact_box1">
          <tr>
            <td style="padding: 0 0 0 16px;"><?php 
                            if(count($err)>0){		
                            ?>
              <table width="90%" align="left" border="0" cellspacing="1" cellpadding="1" style="padding:6px 4px;">
                <tr>
                  <td style="padding:4px 4px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/thick_icon.png"  border="0"/><strong><?php print($err[0]); ?></strong></td>
                </tr>
              </table>
              <table width="50%" align="left" border="0" cellspacing="1" cellpadding="1" style="padding:6px 4px;">
                <tr>
                  <td><img src="<?php echo $obj_base_path->base_path(); ?>/images/list.gif" alt="" width="21" height="17"/> <a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $obj->f('event_id');?>" target="_blank">View Your Listing</a></td>
                  <td><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit1.gif" alt="" width="21" height="17"/> <a href="<?php echo $obj_base_path->base_path(); ?>/admin/scheme/">Customize your Event Page</a></td>
                </tr>
              </table>
              <?php }?></td>
          </tr>
          <tr>
            <td style="padding: 10px 0 0 16px;"> Please confirm your Event information below.  You will be able to edit the information at any time after the event is Launched. </td>
          </tr>
          <tr>
            <td style="padding: 10px 0 0 16px;"><form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="event_id" value="<?=$obj->f('event_id')?>" />
                <table width="600" border="0" cellspacing="2" cellpadding="6">
                  <tr>
                    <td width="10%"><input type="submit" class="submited_btn" name="Submit4" value="Event Launch" style="margin:8px 0px 4px 0px; cursor:pointer;"/></td>
                    <td width="90%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Event Details</h5></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj->f('event_name'); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo date("D M j, Y at g:i a ",strtotime($obj->f('event_date'))); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php 
                                $obj_event_venue->event_list_venue_selected($_REQUEST['event_id']);
                                $obj_event_venue->next_record();
                                
                                echo $obj_event_venue->f('venue_name')." in ".$obj_event_venue->f('venue_city').", ".$obj_event_venue->f('venue_state'); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj_base_path->base_path()."/event/".$obj->f('url_short_name');?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Pricing</h5></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Options</h5></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Delivery Options</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Print At Home :</strong>
                      <?php if($obj->f('print_at_home')=='1'){echo "Always Available";}elseif($obj->f('print_at_home')=='2'){ echo "Never Available";}elseif($obj->f('print_at_home')=='3'){echo " As Set Date";}?>
                      <strong>Will Call :</strong>
                      <?php if($obj->f('will_call')=='1'){echo "Always Available";}elseif($obj->f('will_call')=='2'){ echo "Never Available";}elseif($obj->f('will_call')=='3'){echo " As Set Date";}?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Service Fees</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj->f('online_service_fee');?>%</td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Donations</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php if($obj->f('donation_enable')=='1'){echo "Yes ". $obj->f('donation_name');}else{echo "No";}?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Custom Fees</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php if($obj->f('custom_fee')=='2'){echo "No";}elseif($obj->f('custom_fee')=='1'){
                                    echo "Yes: <br />";
                                    echo "Name: ".$obj->f('custom_fee_name')."<br />";
                                    echo "Type: ";
                                    if($obj->f('custom_fee_type')=='1'){echo "Fixed Amount <br />";}elseif($obj->f('custom_fee_type')=='2'){echo "Percentage <br />";};
                                    echo "Amount: $".$obj->f('custom_fee_amt')."<br />";
                                    echo "Apply Fee: " ;
                                    if($obj->f('custom_apply_fee')=="1"){echo "Before Discount ";}elseif($obj->f('custom_apply_fee')=="2"){echo "After discount";}
                                    
                                    }?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Ticket Note </strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj->f('ticket_note');?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Checkout Time Limit</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj->f('checkout_time_limit');?> minutes</td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Ticket Purchase Limit</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $obj->f('ticket_transaction_limit');?> minutes</td>
                  </tr>
                </table>
              </form>
              <br /></td>
          </tr>
        </table>
      </div>
      <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="20" /></div>
      <div class="clear"></div>
    </div>
    <?php
	
    	
  
	}elseif(($_REQUEST['step']=='' && $_REQUEST['event_id']!='')){
	
	?>
    <div class="inner_box">
      <div class="step">
        <div class="coupons"><?php echo $obj->f('event_name'); ?></div>
      </div>
      <div class="clear"></div>
      <div class="custom_box2">
        <div class="event_heading">
          <ul>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $_REQUEST['event_id']; ?>" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_icon.png" alt="" width="26" height="15" border="0" style="margin: 0 5px 0 0;">view event page</a></li>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $obj->f('event_id');?>/step/1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit_icon.png" alt="" width="12" height="17" border="0" style="margin: 0 5px 0 0;">edit</a></li>
            <li><a href="javascript:void(0);" id="confirm_delete"><img src="<?php echo $obj_base_path->base_path(); ?>/images/delete_icon.png" alt="" width="13" height="12" border="0" style="margin: 3px 5px 0 0;">delete</a></li>
            <?php if($obj->f('pause_sale')==1) { ?>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/unpause-sales">Unpause Sales</a></li>
            <?php }else{?>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/pause-sales"><img src="<?php echo $obj_base_path->base_path(); ?>/images/pause_icon.png" alt="" width="9" height="11" border="0" style="margin: 3px 5px 0 0;">pause</a></li>
            <?php }?>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/duplicate_event/<?php echo $_REQUEST['event_id']; ?>" id="duplicate_event"><img src="<?php echo $obj_base_path->base_path(); ?>/images/duplicate_icon.png" alt="" width="21" height="16" border="0" style="margin: 0 5px 0 0;">duplicate</a></li>
          </ul>
        </div>
        <div class="clear" style="border-bottom:1px solid #CCCCCC;"></div>
        <div class="nightclub">
          <div class="clear"></div>
          <div style="float:left; width:536px;"><span><?php echo date('D M j, Y \a\t g:i a',strtotime($obj->f('event_date'))); ?> at <?php echo $obj_venue->f('venue_name'); ?> in <?php echo $obj_venue->f('venue_city'); ?>, <?php echo $obj_venue->f('venue_state'); ?></span>
            <div>Ticket sales are currently live. Pause Sales</div>
          </div>
          <div style="float:right; width:129px; padding:10px 0;">
            <div class="print_call_btn">
              <?php if($obj->f('pause_sale')==1) { ?>
              <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/unpause-sales">Unpause Sales</a>
              <?php }else{?>
              <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $_REQUEST['event_id']; ?>/pause-sales">Pause Sales</a>
              <?php }?>
            </div>
          </div>
        </div>
        <!--<div>Sales will close on <?php echo date('D M j, Y \a\t g:i a',strtotime($obj->f('sale_close_date'))); ?>.</div>  -->
        <div class="clear"></div>
        <div class="level_box_base">
          <div class="level_box">
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="level_left">
            <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="level_left1_1">
                  <tr>
                    <td width="90">Level</td>
                    <td width="116">Inventory</td>
                    <td width="80">Issued </td>
                    <td width="50">held</td>
                    <td> Remaining</td>
                  </tr>
                </table>
            	</td>
              </tr>
            <tr>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="level_left2">
            <?php
            //list price
            $obj_list_price->event_price_list_all($_REQUEST['event_id']);
            if($obj_list_price->num_rows()>0){ 
            while($obj_list_price->next_record())
            {		
            ?>
                <tr>
              <td width="90" ><?php echo $obj_list_price->f('price_name'); ?><br/>
                <span style="color:#F00">
                <a href="#" style="color:#ff2600; font: bold 11px/16px Arial, Helvetica, sans-serif; text-transform:none;"><?php if ($obj_list_price->f('price_level_status')==1) echo "(Deleted)"; ?></a>
                </span></td>
              <td width="116" ><?php echo $obj_list_price->f('ticket_limit'); ?></td>
              <td width="80" ><span style="color:#31a63f;"><?php echo $obj_list_price->f('ticket_sold'); ?></span></td>
              <td width="50">0</td>
              <td ><span><?php echo $obj_list_price->f('ticket_limit')-$obj_list_price->f('ticket_sold'); ?></span></td>
            </tr>
            <?php } }?>
            </table>
            </td>
          </tr>
          </table>

            
         
        <div class="level_right">
          <?php 
			$obj_event_ticketsummary=new admin;
			$obj_event_ticketsummary->event_price_total($_REQUEST['event_id']);
			$obj_event_ticketsummary->next_record();
		  ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="event_inventory_1">
            <tr style="background:#ebebeb;">
              <td width="182">Event Inventory</td>
              <td width="49"><?php echo $obj_event_ticketsummary->f('ticket_limit_sum');?></td>
            </tr>
            <tr>
              <td width="189">Tickets Issued</td>
              <td><span style="color:#31a63f;"><?php echo $obj_event_ticketsummary->f('ticket_sold_sum');?></span></td>
            </tr>
            <tr style="background:#ebebeb;">
              <td width="189">Remaining Tickets</td>
              <td><?php echo $obj_event_ticketsummary->f('remain_sum');?></td>
            </tr>
            <tr>
              <td width="189">Event Views</td>
              <td><?php echo $obj->f('event_views'); ?></td>
            </tr>
            <tr style="background:#ebebeb;">
              <td width="189">Voided Tickets</td>
              <td><?php 
                 $obj_ticket_voided=new admin;
                 $obj_ticket_voided->event_order_voided($_REQUEST['event_id']);
                 
                 
                 echo $obj_ticket_voided->num_rows();?>
                </strong></td>
            </tr>
          </table>
        
         
         
          <div class="clear"></div>
        </div>
     
      <div class="clear"></div>
      <div class="customizations"><img src="<?php echo $obj_base_path->base_path(); ?>/images/customizations_img.png" alt="" width="34" height="33" border="0" style="margin:0 12px 0 0;">customizations </div>
      <div class="Template_base">
        <div class="Template_left" style="margin:0 10px 0 0;">
          <ul>
            <?php 
			  		//event assign template
				  $obj_tmp->event_template_detail_byid($_REQUEST['event_id']);
				  $obj_tmp->next_record();
			  ?>
            <li style="border-bottom:1px solid #cccecf;">
              <div class="templates_blue">Templates </div>
              <div class="assign_templates_btn"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/schemes">assign a template ></a></div>
            </li>
            <li>
              <div class="using">You are currently using the template: <span>
                <?php if ($obj_tmp->num_rows()>0) {?>
                <a href="<?php echo $obj_base_path->base_path(); ?>/admin/scheme/<?php echo $obj_tmp->f('template_id'); ?>">
                <?php  echo $obj_tmp->f('template_name'); ?>
                </a>
                <?php } else { echo "Default template";} ?>
                </span></div>
            </li>
          </ul>
        </div>
        <div class="Template_left">
          <ul>
            <li style="border-bottom:1px solid #cccecf;">
              <div class="templates_blue">Questions </div>
              <div class="assign_templates_btn"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/questions">assign a questions ></a></div>
            </li>
            <?php
			  //list of question for the event 
			  $obj_question->question_list_by_event_id($_REQUEST['event_id']);
			  if($obj_question->num_rows()>0){
			  while($obj_question->next_record()){
			  ?>
            <li>
              <div class="using2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="white_text">
                  <tr>
                    <td width="39"><img src="<?php echo $obj_base_path->base_path(); ?>/images/talk.png" alt="" width="28" height="20"/></td>
                    <th width="112"><?php echo $obj_question->f('question'); ?>Test question</th>
                    <td width="29"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit1.png" alt="" width="21" height="17"/></td>
                    <th width="41"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/question/<?php echo $obj_question->f('question_id'); ?>">Edit</a></th>
                    <td width="29"><img src="<?php echo $obj_base_path->base_path(); ?>/images/delete.png" alt="" width="21" height="17"/></td>
                    <th width="66"><a href="javascript:void(0);" onclick="confirm_delete_question('<?php echo $obj_question->f('id'); ?>');" id="confirm_delete_question">Unassign</a></th>
                  </tr>
                </table>
              </div>
            </li>
            <?php }   
      }else {   
      ?>
            <li>
              <div class="using2">
                <input name="" type="text" value="No questions assigned " class="text_field4">
              </div>
            </li>
            <?php }?>
          </ul>

          <div class="clear"></div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="10" /></div>
      <div class="up_event">
       
      </div>
      <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="10" /></div>
      <div class="customizations"><img src="<?php echo $obj_base_path->base_path(); ?>/images/coupon_img.png" alt="" width="32" height="32" border="0" style="margin:0 12px 0 0;">Coupons </div>
      <div class="coupons_detail_base">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="coupons_detail_top">
          <tr>
            <td width="14%" style="padding-left: 11px;">Name</td>
            <td width="10%">Code</td>
            <td width="10%">Type</td>
            <td width="8%">Uses</td>
            <td width="17%">Start</td>
            <td width="20%">End</td>
            <td width="9%">Social</td>
            <td width="12%">Manage</td>
          </tr>
        </table>
      
        <?php 
                  //event assign coupon
                  $obj_coupon->event_coupon_detail_byid($_REQUEST['event_id']);
                  if($obj_coupon->num_rows()>0){
                  while($obj_coupon->next_record()){
                  ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="coupons_detail_bot">
          <tr style="border-bottom: 1px solid #cccecf;">
            <td width="13%" align="left" valign="top"><strong><?php echo $obj_coupon->f('coupon_name'); ?></strong></td>
            <td width="11%" align="left" valign="top"><?php echo $obj_coupon->f('code'); ?></td>
            <td width="10%" align="left" valign="top"><?php echo $obj_coupon->f('coupon_type'); ?></td>
            <td width="7%" align="left" valign="top"><?php echo $obj_coupon->f('user_limit'); ?></td>
            <td width="17%" align="left" valign="top"><?php echo date("m/d/Y g:i a",strtotime($obj_coupon->f('start_date'))); ?></td>
            <td width="21%" align="left" valign="top"><?php echo date("m/d/Y g:i a",strtotime($obj_coupon->f('end_date'))); ?></td>
            <td width="9%" align="left" valign="top"><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter1.gif" alt="" width="20" height="20" /></td>
            <td width="12%" align="left" valign="top"><table width="50" border="0" align="left" cellpadding="2" cellspacing="2">
                <tr>
                  <td style="padding:0; margin: 0;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/unassign.png" alt="" /></td>
                  <td style="padding:0; margin: 0;"><a href="javascript:void(0);" onclick="confirm_delete_coupon('<?php echo $obj_coupon->f('id'); ?>');">Unassign</a></td>
                </tr>
                <tr>
                  <td style="padding:0; margin: 0;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit_img.png" alt="" /></td>
                  <td align="center" valign="middle" style="padding:0; margin: 0;"><a href="#">Edit</a></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <?php
                }
                 } else {?>
        <table>
          <tr>
            <td>No coupon assign</td>
          </tr>
        </table>
        <?php } ?>
        <!--   </div>-->
        <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="20" /></div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="20" /></div>
  <div class="clear"></div>
</div>
<?php }?>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</section>
<!--end body-->
<div class="clear"></div>
</div>
<!--end maincontainer-->
<?php include("footer.php"); ?>
</body>
</html>