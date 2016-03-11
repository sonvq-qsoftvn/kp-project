<?php
// home page
session_start();
include('../include/admin_inc.php');

list($today_yr,$today_mon,$today_day) = explode("-",date("Y-m-d"));
//print_r($_REQUEST);exit;

//create object
$objlist=new admin;
$obj_subcat=new admin;
$obj_venuestate=new admin;
$obj_venuecounty=new admin;
$obj_venuecity=new admin;
$obj_venue=new admin;
$obj_add=new admin;
$obj_add_category_by_event=new admin;
$objlist_most_used=new admin;
$obj_thumb = new admin;
$obj_add_eventtype = new admin;
$obj_check_saved = new admin;
$obj_edit_saved = new admin;
$obj_del_saved_cat = new admin;
$obj_saved_category = new admin;
$obj_del_saved_types = new admin;
$obj_saved_per_type = new admin;
$obj_update_st_rt = new admin;
$obj_add_saved = new admin;
$obj_dup_event_master_type = new admin;

$obj_per = new admin;
$obj_dup_cat = new admin;
$obj_dup_event_type = new admin;
$obj_temp_tickets = new admin;


$objlist->category_list();
$obj_dup_event_master_type->getPerformerTypeMster();

// Get Performer details
$performer_id = $_REQUEST['performer_id']; 
$obj_per->get_performer_pid($performer_id);
$obj_per->next_record();
$publish_date = $obj_per->f('publish_date');
list($publish_dt,$publish_tm) = explode(" ",$publish_date);
list($publish_year,$publish_mon,$publish_day) = explode("-",$publish_dt);


// Performer Types BY Event ID details
$obj_dup_event_type->getPertypes($performer_id);
if($obj_dup_event_type->num_rows()){
	while($obj_dup_event_type->next_record()){
		$allEventType[] = $obj_dup_event_type->f('performer_master_type_id');
	}
}

// Performer Category details
$obj_dup_cat->getCatPerformer($performer_id);
if($obj_dup_cat->num_rows()){
	while($obj_dup_cat->next_record()){
		$allEventCat[] = $obj_dup_cat->f('category_id');
	}
}





if(isset($_POST['addevent']) && $_POST['addevent'] == '1')	
{
	//print_r($_POST);exit;

	$finalArray = $_POST['maincat'];
	$event_types = $_POST['event_types'];
	$publish_date = $_POST['multi_event_year1']."-".$_POST['multi_event_month1']."-".$_POST['multi_event_day1'];
		
	$performer_name_sp = addslashes($_POST['performer_name_sp']);
	$performer_name_en = addslashes($_POST['performer_name_en']);
	
	$performer_short_add_sp = addslashes($_POST['performer_short_add_sp']);
	$performer_short_add_en = addslashes($_POST['performer_short_add_en']);
	
	$performer_state = addslashes($_POST['performer_state']);
	$performer_county = addslashes($_POST['venue_county']);
	$performer_city = addslashes($_POST['venue_city']);
	$performer_zip = addslashes($_POST['performer_zip']);
	if($performer_zip=="Zipcode"){
		$performer_zip = '';
	}
	
	$performer_address = addslashes($_POST['performer_address']);
	if($performer_address=="*Address"){
		$performer_address = '';
	}
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
	$activate_status = $_POST['activate_status'];
	$file_name = $_POST['performer_photo'];
	
	// Code for sub-description
	if(($performer_short_add_sp=="Breve Descripción" || $performer_short_add_sp=="") && $performer_description_sp!=""){
		$performer_short_add_sp = strip_tags($performer_description_sp);
		$performer_short_add_sp = substr($performer_short_add_sp,0,160);
	}
	if(($performer_short_add_en=="Short Description" || $performer_short_add_en=="") && $performer_description_en!=""){
		$performer_short_add_en = strip_tags($performer_description_en);
		$performer_short_add_en = substr($performer_short_add_en,0,160);
	}

	// check for venue status
	if($obj_per->f('activate_status')==2)
		$activate_status = 2;

	// check for publish date
	if($publish_date=="--")
		$publish_date = $obj_per->f('publish_date');
	//echo $publish_date;exit;
		
	$obj_edit_saved->editSavedPerformer($performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$_SESSION['performer_unique_id'],$performer_id,$publish_date);
		
		
	// Update category Event
	if(count($finalArray)>0)
	{
		// Delete previous category..
		$obj_del_saved_cat->delPerCat($performer_id);
		
	   for($a=0;$a<count($finalArray);$a++)
	   {
			$obj_saved_category->addSavedCatByPerfrm($finalArray[$a],$performer_id);
		}
	}
	
	// Add category Event types
	if(count($event_types)>0)
	{
		// Delete previous Types..
		$obj_del_saved_types->delPertypes($performer_id);

		for($a=0;$a<count($event_types);$a++)
		{
			$obj_saved_per_type->addperformertype($event_types[$a],$performer_id);
		}
	}	
	if($_POST['per_pub']==1)
		$_SESSION['msg'] = "Performer Published successfully";
	else
		$_SESSION['msg'] = "Performer saved successfully";
	header("Location:".$obj_base_path->base_path()."/admin/edit-performer/".$performer_id);
	exit;
}
else{
	$_SESSION['performer_unique_id'] = time();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Post Performer</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<!-- Ajax File Upload -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
<!-- Ajax File Upload -->


<script type="text/javascript">
function del(eID)
{
	if(confirm("Are you sure you want to delete this Performer?"))
	{
		location.href="<?php echo $obj_base_path->base_path(); ?>/admin/del/"+eID+"/performer";
	}
	
}

//calendar
$(document).ready(function() {
	$('#multi_event_day1').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
		
		$('#multi_event_month1').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			onSelect: function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
			
		});
		
		$('#multi_event_year1').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
	
});
$(document).ready(function() {
	$('#multi_event_day2').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
		
		$('#multi_event_month2').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			onSelect: function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
			
		});
		
		$('#multi_event_year2').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
	
});


</script>



<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
     $('#div_city_display').html('<select name="venue_city" class="selectbg12"><option value="">City</option></select>');
    // $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "state_id="+stateid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_county.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid)
{
   //  $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "county_id="+countyid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_city.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}

function getVenue(cityid)
{
     data = "city_id="+cityid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_venue.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_venue_display").html(data);
	   }
	 });
}
</script>


<script type="text/javascript" >
	
$(function(){
		var btnUpload=$('#me1');
		var mestatus=$('#mestatus1');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadperformer.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				//On completion clear the status
				mestatus.text('Photo Uploaded Sucessfully!');
				$('#performer_photo').val(response);
				$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/performer/thumb/'+response+'" alt="" />');
				$('#me1').html('');
				
			}
		});
		
	});
</script>

<script type="text/javascript">


function saveAutoEvent()
{
	//  check something is written in event page..
	
	/*$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_performer.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: $("#perfomer_form").serialize(),   
	   success: function(data){ 
	     //alert(data);
	   }
	 });*/
}




function delStandardrates(performer_rates_id)
{
	$('#loader').show();	
	 data = "performer_rates_id="+performer_rates_id+"&performer_id="+<?php echo $performer_id;?>;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_del_rates.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
		$('#loader').hide();			 
	   }
	 });
}

</script>

<script type="text/javascript">
function complete(){
	document.getElementById("day_1").value = document.getElementById("multi_event_day1").value;
	document.getElementById("month_1").value = document.getElementById("multi_event_month1").value;
	document.getElementById("year_1").value = document.getElementById("multi_event_year1").value;
	<?php 
		if($_SESSION['ses_user_id']==1)
		{
	?>	
		$('#activate_status').val(2);
		$("#complete").html('Performer Published');
		setTimeout('document.getElementById("perfomer_form").submit()',1000);
	<?php 
		}
		else{
	?>
		if(checkReg())
		{			
			//alert(document.getElementById("day_1").value);
			$('#activate_status').val(2);
			$("#complete").html('Performer Published');
			setTimeout('document.getElementById("perfomer_form").submit()',1000);
		}
	<?php 
		}
	?>
	}

function complete1(){
		document.getElementById("day_1").value = document.getElementById("multi_event_day2").value;
		document.getElementById("month_1").value = document.getElementById("multi_event_month2").value;
		document.getElementById("year_1").value = document.getElementById("multi_event_year2").value;
	
	<?php 
		if($_SESSION['ses_user_id']==1)
		{
	?>	
			$('#activate_status').val(2);
			$('#per_pub').val(1);
			$("#complete1").html('Performer Published');
			setTimeout('document.getElementById("perfomer_form").submit()',1000);
	<?php 
		}
		else{
	?>
	if(checkReg())
	{	
		//alert(document.getElementById("day_2").value);
		
		$('#activate_status').val(2);
			$('#per_pub').val(1);
		$("#complete1").html('Performer Published');
		setTimeout('document.getElementById("perfomer_form").submit()',1000);
	}
	<?php 
		}
	?>
}

</script>
<script type="text/javascript">

function checkReg()
{
	$('#err_per_sp').html('');
	$('#err_per_en').html('');
	$('#err_city').html('');
	$('#err_add').html('');
	$('#err_contact_name').html('');
	$('#err_phone').html('');
	$('#err_cell').html('');
	$('#err_mail').html('');
	$('#err_manager_name').html('');
	$('#err_manager_cell').html('');
	$('#err_manager_email').html('');
	
	
	/*alert($("#venue_name").val());*/
	if($("#performer_name_en").val()=="" || $("#performer_name_en").val()=="Name")
	{
		$('#err_per_en').alert("Please Enter Performer name.");
		$("#performer_name_en").focus();
		return false;
	}
	if($("#performer_name_sp").val()=="" || $("#performer_name_sp").val()=="Nombre")
	{
		$('#err_per_sp').html("Please Enter Peformer name.");
		$("#performer_name_sp").focus();
		return false;
	}
	if($("#performer_city").val()=="")
	{
		$('#err_city').html("Please Enter City.");
		$("#performer_city").focus();
		return false;
	}
	if($("#performer_address").val()=="" || $("#performer_address").val()=="*Address")
	{
		$('#err_add').html("Please Add Address.");
		$("#performer_address").focus();
		return false;	
	}
	if($("#performer_contact_name").val()=="")
	{
		$('#err_contact_name').html("Please Enter Contact Name.");
		$("#performer_contact_name").focus();
		return false;
	}
	if($("#performer_phone").val()=="")
	{
		$('#err_phone').html("Please Enter Phone.");
		$("#performer_phone").focus();
		return false;
	}
	if($("#performer_cell").val()=="")
	{
		$('#err_cell').html("Please Enter Cell Number.");
		$("#performer_cell").focus();
		return false;
	}
	if($("#performer_email").val()=="")
	{
		$('#err_mail').html("Please Enter Email.");
		$("#performer_email").focus();
		return false;
	}
	if($("#performer_email").val()!="")	
	{
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

		if(!pattern.test($('#performer_email').val()))
		{
			$('#err_mail').html("Invalid e-mail address!");
			$('#performer_email').focus();
			return false;
		}
	}
	if($("#manager_phone").val()=="")
	{
		$('#err_manager_name').html("Please Enter Manager Phone.");
		$("#manager_phone").focus();
		return false;
	}


	if($("#manager_cell").val()=="")
	{
		$('#err_manager_cell').html("Please Enter Manager Cell Number.");
		$("#manager_cell").focus();
		return false;
	}
	if($("#manager_email").val()=="")
	{
		$('#err_manager_email').html("Please Enter Manager Email.");
		$("#manager_email").focus();
		return false;
	}
	if($("#manager_email").val()!="")	
	{
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

		if(!pattern.test($('#manager_email').val()))
		{
			$('#err_manager_email').html("Invalid e-mail address!");
			$('#manager_email').focus();
			return false;
		}
	}	
	
	return true;
}

</script>
<script type="text/javascript">
	function privacy_policy(){
		if($('input:radio[name=privacy]:checked').val()==1)
		{
			$('#public_content').show();
			$('#private_content').hide();
			$('#privacy_set').val($('input:radio[name=privacy]:checked').val());
		}
		else
		{
			$('#private_content').show();
			$('#public_content').hide();
			$('#privacy_set').val($('input:radio[name=privacy]:checked').val());
		}
	}
	
	function standard_rates(){
		if($('input:radio[name=st_rate]:checked').val()==1)
		{
			$('#performance_rate').show();
		}
		else
		{
			$('#performance_rate').hide();
		}
	}
	$(document).ready(function(){
		<?php if($obj_per->f('private_privacy')==0){?> 
			privacy_policy();
		<?php }?>
	})
	$(document).ready(function(){
		<?php if($obj_per->f('st_rate')==1){?> 
			$('input:radio[name=st_rate]:checked').val(1);
			standard_rates();
		<?php }?>
	})
	
</script>



<script type="text/javascript">
function showSubCat(category_id)
{
	$('#sub_cat'+category_id).show();
	$('#shwsubcatview'+category_id).hide();
	$('#hdsubcatview'+category_id).show();
}
function hideSubCat(category_id)
{
	$('#sub_cat'+category_id).hide();
	$('#hdsubcatview'+category_id).hide();
	$('#shwsubcatview'+category_id).show();
}
function checkCat(category_id)
{
	$('#maincat'+category_id).attr("checked",true);
}
function check_box(){
	

	var per_des_en = CKEDITOR.instances['performer_description_en'].getData();
	var per_des_sp = CKEDITOR.instances['performer_description_sp'].getData();

	var fields = $("input[class='category_1']").serializeArray(); 
	
	<?php 
		if($_SESSION['ses_user_id']==1)
		{
	?>
		document.getElementById("perfomer_form").submit();

	<?php	
	}
	?>
	
	
    if (fields.length == 0) 
    { 
        alert('No Categories Selected!'); 
        return false;
    } 
	else
	{
		document.getElementById("perfomer_form").submit();
	}

}
</script>

<script>
function edit_rates(performer_rates_id)
{
	$('#loader').show();
	 data = "performer_rates_id="+performer_rates_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_edit_standard_rates.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   dataType: 'json',
	   data: data,   
	   success: function(data){ 
	   
		// Fill the Text field
	   $('#rate_name_en').val(data['rate_name_en']);
	   $('#rate_name_sp').val(data['rate_name_sp']);
	   $('#description_en').val(data['description_en']);
	   $('#description_sp').val(data['description_sp']);
	   $('#price_mx').val(data['price_mx']);
	   $('#price_us').val(data['price_us']);

	   
	   $('#edit_rate').val(1);
	   $('#exit_rate_id').val(performer_rates_id);

		$('#loader').hide();			 
	   }
	 });
}


function closePopUp()
{
	var checkValue = save_new_popup();
}
function save_new_popup()
{
	if(!checkticketReg())
	{
		return 0;
	}
	else{
		$('#loader').show();
		 var ticketVal = $("#perfomer_form").serialize()+"&performer_id="+<?php echo $performer_id;?>;
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_edit_standard_rates.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: ticketVal,   
		   success: function(data){ 

			 $("#imgid").val('');

			 $('#edit_rate').val(0);
			 $("#save_create_ticket_display").html(data);
			 
			 // Place the placeholder
			 $("#rate_name_sp").val("Nombre");
			 $("#rate_name_en").val("Name");
			 $("#description_sp").val("");
			 $("#description_en").val("");
			 $("#price_mx").val("0");
			 $("#price_us").val("0");
			
			$('#loader').hide();			 
			$('html, body').animate({scrollTop: $("#save_create_ticket_display").offset().top}, 2000);
		   }
		 });
		 return 1;
	}
}

function checkticketReg()
{
	$('#price_mx').css("border", "1px solid #CCCCCC");
	$('#rate_name_en').css("border", "1px solid #CCCCCC");
	$('#rate_name_sp').css("border", "1px solid #CCCCCC");
	$('#price_us').css("border", "1px solid #CCCCCC");


	 if($('#rate_name_sp').val()=="" || $('#rate_name_sp').val()=="Nombre")
	{
		$('#rate_name_sp').css("border", "1px solid #FF0000");
		$('#rate_name_sp').focus();
		return false;
	}
	else if($('#rate_name_en').val()=="" || $('#rate_name_en').val()=="Name")
	{
		$('#rate_name_en').css("border", "1px solid #FF0000");
		$('#rate_name_en').focus();
		return false;
	}
	
	else if($('#price_mx').val()=="")
	{
		$('#price_mx').css("border", "1px solid #FF0000");
		$('#price_mx').focus();
		return false;
	}
	else if($('#price_us').val()=="")
	{
		$('#price_us').css("border", "1px solid #FF0000");
		$('#price_us').focus();
		return false;
	}
	
	return true;
}

	
function checkInt(var_name,show_err)
{
	var regexp = /^\d+$/;
	
	if(!regexp.test($('#'+var_name).val()))
	{
		$('#'+var_name).val(0);
		$('#'+var_name).focus();
		$('#'+show_err).html("Please Insert Numeric Value");
	}
	else
	{
		$('#'+show_err).html("");
	}
	
}
function checDecimal(var_name,show_err)
{
	var regexp = /^\d+(?:\.\d+)?$/;
	var num = 0.00;

	if(!regexp.test($('#'+var_name).val()))
	{
		$('#'+var_name).val(num.toFixed(2));
		$('#'+var_name).focus();
		$('#'+show_err).html("Please Insert Numeric Value");
	}
	else
	{
		$('#'+show_err).html("");
	}
	
}

var count = "160";   //Example: var count = "175";
function limiter(){

	var tex = document.perfomer_form.performer_short_add_sp.value;
	var len = tex.length;
	if(len > count){
			tex = tex.substring(0,count);
			document.perfomer_form.performer_short_add_sp.value =tex;
			return false;
	}
	document.perfomer_form.limit.value = count-len;
}

var count1 = "160";   //Example: var count = "175";
function limiter1(){
	var tex = document.perfomer_form.performer_short_add_en.value;
	var len = tex.length;
	if(len > count1){
			tex = tex.substring(0,count1);
			document.perfomer_form.performer_short_add_en.value =tex;
			return false;
	}
	document.perfomer_form.limit1.value = count1-len;
}


</script>
<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1">
<?php include("admin_header.php"); ?>
  <div id="maindiv">
    <div class="clear"></div>
    <div class="body_bg">
    <div class="clear"></div>
    <div class="container">
    <?php include("admin_header_menu.php");?>
     <div class="clear"></div>		
    <!--start body-->
      <div id="body">
        <div class="body2"> 
          <div class="clear"></div>
           <div class="blue_box1">
           <div class="blue_box10"><p>My Performers</p></div>
           	<?php include("admin_menu/performer_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; margin-top:10px; color:#006600;" id="showupdate">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
	<?php if($msg!=""){?>
		<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;"><strong><?php echo $msg;?>	</strong></div>	
	<?php } ?>	
		
    <form action="" method="post" name="perfomer_form" id="perfomer_form" enctype="multipart/form-data">
    <input type="hidden" name="addevent" id="addevent" value="1" />
    <input type="hidden" name="per_pub" id="per_pub" value="0" />
    <input type="hidden" name="activate_status" id="activate_status" value="<?php echo $obj_per->f('activate_status')?>" />
    
    <div class="myevent_box">
    <div class="myevent_left">
		<div class="event_name8">
            <div style="float:left; position: absolute; margin: 0 0 0 303px;">
                <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/>
            </div>
            <div style="float: left; margin: 0 auto;">
                <span class="show_spanish">SP</span><br/>
                <span class="event_fieldbg8">
                    <input type="text" name="performer_name_sp" id="performer_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="<?php echo $obj_per->f('performer_name_sp');?>" /><div id="err_per_sp" style="color:red;"></div>
                </span>	
                <br/>
                <?php
					$biodata_length1 = strlen($obj_per->f('performer_short_add_sp'));
					$biodata_character_remaining1 = 160-$biodata_length1;
				?>
                <span class="event_fieldbg8">
                	<textarea name="performer_short_add_sp" id="performer_short_add_sp" class="event_field" style="width: 290px; margin: 5px 0; padding:3px 5px; height: 60px;"  onkeyup="limiter()"><?php echo $obj_per->f('performer_short_add_sp');?></textarea>
				 <script type="text/javascript">
                      <?php if($biodata_length1>0) { ?>
                        document.write("<input type=text name=limit size=4 readonly value=<?php echo $biodata_character_remaining1;?>>");
                      <?php } else { ?>
                        document.write("<input type=text name=limit size=4 readonly value="+count+">");
                      <?php } ?>
                </script>
               
                </span>
            </div>
            <div style="float: right; margin: 0 auto;">	
                <span class="show_english">EN</span><br/>
                <span class="event_fieldbg8">
                    <input type="text" name="performer_name_en" id="performer_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"  value="<?php echo $obj_per->f('performer_name_en');?>" /><div id="err_per_en" style="color:red;"></div>
                </span>	
                <br/>
                 <?php
					$biodata_length = strlen($obj_per->f('performer_short_add_en'));
					$biodata_character_remaining = 160-$biodata_length;
				?>
                <span class="event_fieldbg8">
                    <textarea name="performer_short_add_en" id="performer_short_add_en" class="event_field" style="width: 290px; margin: 5px 0; padding:3px 5px; height: 60px;"  onkeyup="limiter1()"><?php echo $obj_per->f('performer_short_add_en');?></textarea>
				 <script type="text/javascript">
                  <?php if($biodata_length>0) { ?>
                    document.write("<input type=text name=limit1 size=4 readonly value=<?php echo $biodata_character_remaining;?>>");
                  <?php } else { ?>
                    document.write("<input type=text name=limit1 size=4 readonly value="+count1+">");
                  <?php } ?>
           	 	</script>
                
                </span>
            </div>
    	</div>
        <div class="clear"></div>
        <div class="event_date">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>      
          <td width="22%" style="padding-left: 12px;">
          <select name="performer_state" id="performer_state" class="selectbg12" onChange="getCounty(this.value);">
            <option value="">State</option>
            <?php
          $obj_venuestate->getVenueState();
          while($row = $obj_venuestate->next_record())
          {
          ?>
            <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj_per->f('performer_state')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
            <?php echo $obj_venuestate->f('state_name');?></option>
            <?php
          }
          ?>
          </select></td>
          <td width="22%">
              <div id="div_county_display">
              <select name="venue_county" id="venue_county" class="selectbg12" onchange="getCity(this.value)">
              <option value="">County</option>
              <?php
				$obj_getcounty = new admin;
				$obj_getcounty->getCountyNameByState($obj_per->f('performer_state'));
				while($obj_getcounty->next_record())
				{
				?>
				<option value=<?php echo $obj_getcounty->f("id")?> <?php if($obj_per->f('performer_county')==$obj_getcounty->f('id')){?> selected="selected"<?php }?> >
				<?php echo $obj_getcounty->f('county_name')?></option>
				<?php
				}
              ?>
              </select>
              </div>	  </td>          
          <td width="22%">
              <div id="div_city_display">
              <select name="venue_city" id="venue_city" class="selectbg12" >
              <option value="">City</option>
               <?php
				$obj_getcity = new admin;
				$obj_getcity->getCityNameByCounty($obj_per->f('performer_county'));
				while($obj_getcity->next_record())
				{
				?>
				<option value=<?php echo $obj_getcity->f("id")?> <?php if($obj_per->f('performer_city')==$obj_getcity->f('id')){?> selected="selected"<?php }?>>
				<?php echo $obj_getcity->f('city_name')?></option>
				<?php
				}
              ?>
              </select>
              </div><div id="err_city" style="color:red;"></div>
              </td>
              <td><input type="text" name="performer_zip" id="performer_zip" value="<?php echo $obj_per->f('performer_zip');?>" class="textbg_grey" style="width: 190px;"  /></td>
          </tr>
        </table>	  
        </div>	
        <div class="clear"></div>
        <div style="margin: 8px 0 0 19px;">
            <span class="event_fieldbg8">
                <textarea name="performer_address" id="performer_address" class="event_field" style="width: 290px;margin: 5px 0; padding:3px 5px;height:60px;"><?php echo $obj_per->f('performer_address');?></textarea>
            </span><div id="err_add" style="color:red;">&nbsp;</div>
        </div>
        <div class="clear"></div>
        <div style="margin: 8px 0 0 19px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="padding: 4px;"><strong>Contact name*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_contact_name" id="performer_contact_name" class="textbg_grey" value="<?php echo $obj_per->f('performer_contact_name');?>" style="width: 130px;"/>
                  <div id="err_contact_name" style="color:red;"></div></td>
                </tr>
                
                <tr>
                  <td style="padding: 4px;"><strong>Phone*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_phone" id="performer_phone" value="<?php echo $obj_per->f('performer_phone');?>" class="textbg_grey" style="width: 130px;"/><div id="err_phone" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Fax</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_fax" id="performer_fax" value="<?php echo $obj_per->f('performer_fax');?>" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Cell*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_cell" id="performer_cell" value="<?php echo $obj_per->f('performer_cell');?>" class="textbg_grey" style="width: 130px;"/><div id="err_cell" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>email*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_email" id="performer_email" value="<?php echo $obj_per->f('performer_email');?>" class="textbg_grey" style="width: 130px;"/><div id="err_mail" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>URL</strong></td>
                  <td style="padding: 4px;"><input type="text" name="performer_url" id="performer_url" value="<?php echo $obj_per->f('performer_url');?>" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Available for performances</strong></td>
                  <td style="padding: 4px;">
                    <select name="avail_performanace" id="avail_performanace" style="width:150px;" >
                        <option value="Locally" <?php if($obj_per->f('avail_performanace')=="Locally"){?> selected="selected"<?php } ?>>Locally</option>
                        <option value="Statewide" <?php if($obj_per->f('avail_performanace')=="Statewide"){?> selected="selected"<?php } ?>>Statewide</option>
                        <option value="Nationalwide" <?php if($obj_per->f('avail_performanace')=="Nationalwide"){?> selected="selected"<?php } ?>>Nationalwide</option>
                        <option value="Internationally" <?php if($obj_per->f('avail_performanace')=="Internationally"){?> selected="selected"<?php } ?>>Internationally</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 4px;">&nbsp;</td>
                  <td style="padding: 4px;">&nbsp;</td>
                </tr>
              </table></td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="padding: 4px;"><strong>Manager</strong></td>
                  <td style="padding: 4px;"><input type="text" name="manager_name" id="manager_name" value="<?php echo $obj_per->f('manager_name');?>" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Phone*</strong></td>
                 <td style="padding: 4px;"><input type="text" name="manager_phone" id="manager_phone" value="<?php echo $obj_per->f('manager_phone');?>" class="textbg_grey" style="width: 130px;"/><div id="err_manager_name" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Fax</strong></td>
                  <td style="padding: 4px;"><input type="text" name="manager_fax" id="manager_fax" value="<?php echo $obj_per->f('manager_fax');?>" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Cell*</strong></td>
                 <td style="padding: 4px;"><input type="text" name="manager_cell" id="manager_cell" value="<?php echo $obj_per->f('manager_cell');?>" class="textbg_grey" style="width: 130px;"/><div id="err_manager_cell" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Email*</strong></td>
                 <td style="padding: 4px;"><input type="text" name="manager_email" id="manager_email" value="<?php echo $obj_per->f('manager_email');?>" class="textbg_grey" style="width: 130px;"/><div id="err_manager_email" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>URL</strong></td>
                 <td style="padding: 4px;"><input type="text" name="manager_url" id="manager_url" value="<?php echo $obj_per->f('manager_url');?>" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;">&nbsp;</td>
                  <td style="padding: 4px;">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
        </div>
        <div class="clear"></div>    
        <div class="event_date">
            <div id="TabbedPanels2" class="TabbedPanels2">
                <ul class="TabbedPanelsTabGroup2">
                    <li class="TabbedPanelsTab2" tabindex="1">Espanol</li>  
                    <li class="TabbedPanelsTab2" tabindex="0">English</li> 
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0" style="float: right; margin: 0 10px 0 0;"/>	 
                </ul>
                <div class="TabbedPanelsContentGroup2">
                    <div class="TabbedPanelsContent2">
                        <?php
						  include($obj_base_path->base_path()."/ckeditor/ckeditor.php");
							$CKeditor = new CKeditor();
							$CKeditor->BasePath = 'ckeditor/';
							$CKeditor->editor('performer_description_sp',stripslashes($obj_per->f('performer_description_sp')));
						?>
                    </div>
                    <div class="TabbedPanelsContent2" style="">
                        <!--<textarea name="venue_description" id="venue_description" cols="35" rows="10"></textarea>-->
                         <?php
							$CKeditor = new CKeditor();
							$CKeditor->BasePath = 'ckeditor/';
							$CKeditor->editor('performer_description_en',$obj_per->f('performer_description_en'));
                         ?>
                    </div> 
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="event_ticket">
            <h1>Set feature image <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>
            <ul style="margin-left: 10px;">
                <li><div id="me1" class="styleall" style="cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Upload Files</span></span></div><span id="mestatus1"></span><div class="clear"></div></li>
                 
                
                <li>|</li>
                <li><a href="#">Media library</a></li>
            </ul>
           <div class="clear"></div>
           <div id="imgshow"><?php if($obj_per->f('performer_photo')){?>
                <img src="<?php echo $obj_base_path->base_path(); ?>/files/performer/thumb/<?php echo $obj_per->f('performer_photo'); ?>" alt="" />
                <?php } ?>
           </div>
           <input type="hidden" name="performer_photo" id="performer_photo" value="<?php if($obj_per->f('performer_photo')){ echo $obj_per->f('performer_photo'); }?>" />
        </div>		
        <div class="clear"></div>

        <div class="event_ticket" style="background:none;">
            <h1>Set Privacy <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>	
            <span style="float: left;">
                <p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="1" <?php if($obj_per->f('privacy')==1){?> checked="checked" <?php }?> onclick="privacy_policy(); " /> Public</p>	
                <p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="0" <?php if($obj_per->f('privacy')==0){?> checked="checked" <?php }?> onclick="privacy_policy(); " /> Private</p>
             </span>
            <span id="public_content">This performer is public and will be listed in our performer directory and submited to search engines</span>
            <span id="private_content">This performer is private and will not be listed in our performer directory and submited to search engines</span>
        </div>
        
        <div class="event_ticket" style="background:none;">
            <h2><input type="radio" name="st_rate" id="st_rate1" value="1" <?php if($obj_per->f('st_rate')==1){?> checked="checked" <?php }?> onclick="standard_rates()" />Performer has standard rates (?) </h2>	
            <h2><input type="radio" name="st_rate" id="st_rate2" value="0" <?php if($obj_per->f('st_rate')==0){?> checked="checked" <?php }?> onclick="standard_rates(); " />Performer has no standard rates (?) </h2>	
        </div>
        
        <div id="performance_rate" style="display:none;">
       		<div class="event_ticket2">
               <div><h2>Set standard performance rates <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" width="31" height="28" border="0"/></h2></div>
                <div class="clear"></div>
                <div id="save_create_ticket_display" class="event_ticketbox" style="border:0px solid red;">
                <?php
                	echo ' <div style=" max-height:95px; over flow:auto;">';
                     //Fetch records from temp table
                    $obj_temp_tickets->getStandardRate($performer_id);
                    if($obj_temp_tickets->num_rows()){
                        while($obj_temp_tickets->next_record()){
                    ?>
                    <div class="event_ticketbox" style="border-bottom:1px dashed #CCC;">
                        <ul>
                            <li><?php echo $obj_temp_tickets->f('rate_name_en');?></li>
                            <li><?php echo $obj_temp_tickets->f('rate_name_sp');?></li>
                            <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_mx'),2);?> MXP </li>
                            <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_us'),2);?> USD </li>
                            <li style="margin-right: 0;">
                                <span class="tic_edit">
                                    <span style="cursor:pointer;" onclick="edit_rates(<?php echo $obj_temp_tickets->f('performer_rates_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit </span>
                                    <span style="cursor:pointer;" onclick="delStandardrates(<?php echo $obj_temp_tickets->f('performer_rates_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                        
                     <?php
                        }
                    }
                    echo '</div>';
					?>
                </div>
        	</div>
       		<div class="clear"></div>

              <input type="hidden" name="edit_rate" id="edit_rate" value="0" />
              <input type="hidden" name="exit_rate_id" id="exit_rate_id" value="0" />
           <div class="event_name8">
            <div style="float: left; position: absolute; margin: 0 0 0 303px;">
            	<img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/>
            	<img id="loader" src="<?php echo $obj_base_path->base_path(); ?>/images/loader.gif" alt="" width="67" height="75" border="0" style="display:none;"/>
            </div>
            <div style="float: left; margin: 0 auto;">
                <span class="show_spanish">SP</span><br/>
                <span class="event_fieldbg8">
                <input type="text" name="rate_name_sp" id="rate_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="Nombre" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if(this.value=='') this.value=this.defaultValue"/>
                </span>	
            <br/>
                <span class="event_fieldbg8">
                    <textarea name="description_sp" id="description_sp" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Breve descripción</textarea>
                </span>
            </div>
            <div style="float: right; margin: 0 auto;">	
                <span class="show_english">EN</span><br/>
                <span class="event_fieldbg8"><input type="text" name="rate_name_en" id="rate_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
                </span>	<br/>
                <span class="event_fieldbg8"><textarea name="description_en" id="description_en" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Short description</textarea></span>
            </div>
            </div>
           <div class="clear"></div>
           <div class="event_date8">
    
            <div class="event_date9">
                Precio MX pesos <input type="text" name="price_mx" id="price_mx" onblur="checDecimal('price_mx','shw_price_mx')"  /> 
                Price Dollars <input type="text" name="price_us" id="price_us" onblur="checDecimal('price_us','shw_price_us')"  />
            </div>	
            <div style="float: right; width: 367px; margin: 0 auto;">
                <input type="button" name="Submit2" value="Save & Create a new ticket" class="event_save" onclick="save_new_popup()" style="cursor:pointer;" />
                <input type="button" name="Submit2" value="Save & Exit" class="event_save" onClick="closePopUp()" style="cursor:pointer;" /></div>
            </div>
    	</div>
    
        <div class="event_ticket" style="background: none; width: 702px; border: 0; margin: 0 auto 0 10px;">    
            <div class="event_ticketr" style="float: right; margin-right: 24px;">
               <h1>
                <a  href="javascript:void(0);" onClick="del('<?php echo $performer_id;?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0"/></a>
            <?php
				if($obj_per->f('activate_status')==2 && date("Y-m-d") < $obj_per->f('publish_date') || $obj_per->f('activate_status')==1 || $obj_per->f('activate_status')==0){
			?>
				<img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save Venue" style="cursor:pointer;" onclick="return check_box();" />
				<?php } else echo '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>' ?>
                 <a  href="#" ><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" title="Preview Venue" /></a>
              </h1>
			<?php
				if($obj_per->f('activate_status')==2 && date("Y-m-d") < $obj_per->f('publish_date') || $obj_per->f('activate_status')==1 || $obj_per->f('activate_status')==0){

				if($publish_day=="00" || $publish_day=="0")
					$publish_day = date("d");
				if($publish_mon=="00" || $publish_mon=="0")
					$publish_mon = date("m");
				if($publish_year=="0000" || $publish_year=="0")
					$publish_year = date("Y");
					
            ?>
                <div style="margin:2px 0 2px 40px; font-weight:bold;">Save your work regularly</div>
                <div style="margin:2px 0 2px 30px;font-weight:bold;">Publish when you are done</div>
                <div class="clear"></div>
                <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
                    <input type="button" name="publish" value="Publish" onclick="complete();" class="pub" />
			 		<table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
                        <tr>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_day1" id="multi_event_day1" value="<?php echo $publish_day;?>"  class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="day_1" id="day_1" value="<?php echo $publish_day;?>" />
                          </td>
                          <td style="text-align: center;">/</td>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_month1" id="multi_event_month1" value="<?php echo $publish_mon;?>" class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="month_1" id="month_1" value="<?php echo $publish_mon;?>" />
                          </td>
                          <td style="text-align: center;">/</td>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_year1" id="multi_event_year1"  value="<?php echo $publish_year;?>" class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="year_1" id="year_1" value="<?php echo $publish_year;?>" />
                          </td>
                        </tr>
                        <tr>
                            <td colspan="5"><div id="complete" style="color:#920125;"></div></td>
                        </tr>
                    </table>
                </div>
                 <?php
                }
                else{
                    list($pub_date,$pub_time) = explode(" ",$obj_per->f('publish_date'));
                    list($pub_yr,$pub_mon,$pub_day) = explode("-",$pub_date);
            ?>
                <div style="margin:5px 0 10px 30px; font-weight:bold;">Published on <?php echo $pub_day."/".$pub_mon."/".$pub_yr;?></div>
                <div style="margin:5px 0 10px 30px;font-weight:bold;">Save your work regularly</div>
                <div style="margin:10px 0 2px 85px;"><input type="button" name="save" value="Update" class="update_btn" onclick="return check_box();" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>

            <?php
            }
            ?>
            </div>
        	<div class="clear"></div>
        </div>
        <div class="clear"></div>	
    </div>
    <div class="myevent_right">
        <div class="event_ticketr" style="width: 276px; margin: 8px auto; float: none;">
             <h1>
                <a  href="javascript:void(0);" onClick="del('<?php echo $performer_id;?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0"/></a>
            <?php
				if($obj_per->f('activate_status')==2 && date("Y-m-d") < $obj_per->f('publish_date') || $obj_per->f('activate_status')==1 || $obj_per->f('activate_status')==0){
			?>
				<img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save Venue" style="cursor:pointer;" onclick="return check_box();" />
				<?php } else echo '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>' ?>
                 <a  href="#" ><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" title="Preview Venue" /></a>
            </h1>
			<?php
				if($obj_per->f('activate_status')==2 && date("Y-m-d") < $obj_per->f('publish_date') || $obj_per->f('activate_status')==1 || $obj_per->f('activate_status')==0){

				if($publish_day=="00" || $publish_day=="0")
					$publish_day = date("d");
				if($publish_mon=="00" || $publish_mon=="0")
					$publish_mon = date("m");
				if($publish_year=="0000" || $publish_year=="0")
					$publish_year = date("Y");
					
            ?>

           <div style="margin:2px 0 2px 40px; font-weight:bold;">Save your work regularly</div>
           <div style="margin:2px 0 2px 30px;font-weight:bold;">Publish when you are done</div>
	       <div class="clear"></div>
        	<div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
            <input type="button" name="publish" value="Publish" onclick="complete1();"  class="pub" />
            <table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
                <tr>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_day2" id="multi_event_day2" value="<?php echo $publish_day;?>"  class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="day_2" id="day_2" value="<?php echo $publish_day;?>" />
                  </td>
                  <td style="text-align: center;">/</td>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_month2" id="multi_event_month2" value="<?php echo $publish_mon;?>" class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="month_2" id="month_2" value="<?php echo $publish_mon;?>" />
                  </td>
                  <td style="text-align: center;">/</td>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_year2" id="multi_event_year2"  value="<?php echo $publish_year;?>" class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="year_2" id="year_2" value="<?php echo $publish_year;?>" />
                  </td>
                </tr>
                <tr>
                    <td colspan="5"><div id="complete1" style="color:#920125;"></div></td>
                </tr>
            </table>
        </div>
			 <?php
                }
                else{
                    list($pub_date,$pub_time) = explode(" ",$obj_per->f('publish_date'));
                    list($pub_yr,$pub_mon,$pub_day) = explode("-",$pub_date);
            ?>
                <div style="margin:5px 0 10px 30px; font-weight:bold;">Published on <?php echo $pub_day."/".$pub_mon."/".$pub_yr;?></div>
                <div style="margin:5px 0 10px 30px;font-weight:bold;">Save your work regularly</div>
                <div style="margin:10px 0 2px 85px;"><input type="button" name="save" value="Update" class="update_btn" onclick="return check_box();" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>

            <?php
            }
            ?>
        
	</div>
     <div class="clear"></div>
     <div style="width: 280px; float: none; margin: 0 auto;">
       <div class="inevent_right">
            <ul>
                <li><h1>Performer type:</h1></li>	
            </ul>
            <ul>
                <li style="padding-left: 8px;"><strong>Select all that apply (optional)</strong></li>
                <?php
                    if($obj_dup_event_master_type->num_rows()){
                        while($obj_dup_event_master_type->next_record()){
                ?>
                <li style="padding-left: 8px;"><input type="checkbox" name="event_types[]" id="event_types<?php echo $obj_dup_event_master_type->f('performer_master_type_id');?>" value="<?php echo $obj_dup_event_master_type->f('performer_master_type_id');?>" <?php if(in_array($obj_dup_event_master_type->f('performer_master_type_id'),$allEventType)){?> checked="checked" <?php } ?> /> <?php echo $obj_dup_event_master_type->f('performer_types_en');?></li>
                
                <?php
                        }
                    }
                ?>
            </ul>	
        </div>
       <div class="clear"></div>
       <div class="inevent_right">
        <ul>
            <li><h1>Categories and sub-categories</h1></li>	
        </ul>
        <ul>
            <li style="padding-left: 10px;"><strong>Select all event categories suitable for this performer</strong></li>
            <li style="padding-left: 10px;"><strong>You must select at least 1 category</strong></li>	
        </ul>	
        <div>
          <ul>
			 <?php
                if($objlist->num_rows()){
                    while($objlist->next_record()){
                    $obj_subcat->category_sub_list($objlist->f('category_id'));
                ?>
                <li style="padding-left: 8px;">
                    <input type="checkbox" name="maincat[]" id="maincat<?php echo $objlist->f('category_id');?>" value="<?php echo $objlist->f('category_id');?>" <?php if(in_array($objlist->f('category_id'),$allEventCat)){?> checked="checked" <?php } ?> class="category_1"/><?php echo $objlist->f('category_name'); if($obj_subcat->num_rows()){?> 			  
                    <span id="shwsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;" onclick="showSubCat(<?php echo $objlist->f('category_id');?>)">( + )</span> 
                    <span id="hdsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;display:none;" onclick="hideSubCat(<?php echo $objlist->f('category_id');?>)">( - )</span> <?php } ?>
              
                    <ul style="margin-left:30px;display:none;" id="sub_cat<?php echo $objlist->f('category_id');?>">
                <?php
                    if($obj_subcat->num_rows()){
                        while($obj_subcat->next_record()){
                            if(in_array($obj_subcat->f('category_id'),$allEventCat)){
                            ?>
                            <script>
                                    $(document).ready(function(){
                                    showSubCat(<?php echo $objlist->f('category_id');?>)
                                })
                            </script>
                            <?php	}          	
                 ?>
                    
                        <li style="padding-left:8px;"><input onclick="checkCat(<?php echo $objlist->f('category_id');?>)" type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" <?php if(in_array($obj_subcat->f('category_id'),$allEventCat)){?> checked="checked" <?php } ?>/><?php echo $obj_subcat->f('category_name');?></li>
                     <?php
                            }
                        }
                    ?></ul>	
                </li>
                 <?php
                    }
                }
                ?>
         </ul>
        </div>	
       </div>	
        <div class="clear"></div>	
        </div>
     <div class="clear"></div>
     <div class="eventag_box">
       <div><h1>Performer Tags</h1></div>
       <div class="clear"></div>
        <div><input type="text" name="performer_tags" id="performer_tags" value="<?php echo $obj_per->f('performer_tags');?>" class="textbg_add"/> <!--<input type="submit" name="save" value="Add" class="btn_add" />--></div>
        <div class="clear"></div>
       <div><span>Separate tags with commas</span></div>
       <div class="clear"></div>
     </div>
    </div>	
	<div class="clear"></div>
    </div>
    
    
    </form>	
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

<script type="text/javascript">
<!--
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
