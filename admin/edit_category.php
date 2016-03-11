<?php
// home page
session_start();

// List of page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	$obj_category = new merchant_admin;
    $obj_edit = new merchant_admin;
	$obj = new merchant_admin;

                                                        	
	//===============CODE FOR UPDATE===================//
	if(isset($_POST['editcat']) && $_POST['editcat'] == '1')	
	{
		$parent_id = $_POST['pcat'];
		$category_name = addslashes($_POST['catname']);
		$category_name_sp = addslashes($_POST['category_name_sp']);
		$category_rank = addslashes($_POST['rank']);
		
		$category_id = $_POST['category_id'];
		
		$obj_edit->editEventCategory($parent_id,$category_name,$category_name_sp,$category_id,$category_rank);
		$_SESSION['cat1_edit'] = "Category updated successfully";
		header("Location:".$obj_base_path->base_path()."/admin/list_category");
	}
	
	$obj->getCategoryById($_GET['id']);
	$obj->next_record();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Page Management</title>
	
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

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->




<script type="text/javascript">

function del(cid)
{
	if(confirm("Are you sure you want to delete this category?"))
	{
		location.href="list_category.php?action=delete&catid="+cid;
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

<script type="text/javascript">

$(document).ready(function() {
	$("#openPop").fancybox({ 
	 "onComplete": function () {
	 var a = $('#event_date_st').val();
	 var b = $('#event_month_st').val();
	 var c = $('#event_year_st').val();
	 var ticket_end_date = a+"/"+b+"/"+c;
	 if(ticket_end_date == '0/0/0')
	 {
	   var ticket_end_date_display = '';
	 }
	 else
	 {
	   var ticket_end_date_display = ticket_end_date;
	 }
	 $("#to_ticket").val(ticket_end_date_display)
	 },
	'hideOnOverlayClick':false,
    'hideOnContentClick':false
	});
});


</script>


<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
     $('#div_city_display').html('<select name="venue_city" class="selectbg12"><option value="">City</option></select>');
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
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
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
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
				saveAutoEvent();
				
			}
		});
		
	});
</script>

<script type="text/javascript">


function saveAutoEvent()
{
	//  check something is written in event page..
	
	$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_performer.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: $("#perfomer_form").serialize(),   
	   success: function(data){ 
	     //alert(data);
	   }
	 });
}




function delStandardrates(performer_rates_id)
{
	 data = "performer_rates_id="+performer_rates_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_del_rates.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
	   }
	 });
}

</script>

<script type="text/javascript">
	function complete(){

		if(checkReg())
		{			
			var dd = document.getElementById("multi_event_day1").value;
			var mm = document.getElementById("multi_event_month1").value;
			var yy = document.getElementById("multi_event_year1").value;
			if(dd == 0 || mm == 0 || yy == 0){
				$("#complete").html('Incorrect Publish Date');
				document.getElementById("multi_event_day1").value = '0';
				document.getElementById("multi_event_month1").value = '0';
				document.getElementById("multi_event_year1").value = '0';
			}
			else
			{
				document.getElementById("day_1").value = document.getElementById("multi_event_day1").value;
				document.getElementById("month_1").value = document.getElementById("multi_event_month1").value;
				document.getElementById("year_1").value = document.getElementById("multi_event_year1").value;
				//alert(document.getElementById("day_1").value);
				$("#complete").html('Event Published');
			}
		}
	}

function complete1(){
	
	if(checkReg())
	{	
		var dd = document.getElementById("multi_event_day2").value;
		var mm = document.getElementById("multi_event_month2").value;
		var yy = document.getElementById("multi_event_year2").value;
		if(dd == 0 || mm == 0 || yy == 0 || dd == 00 || mm == 00 || yy == 0000){
			$("#complete1").html('Incorrect Publish Date');
			document.getElementById("multi_event_day2").value = '0';
			document.getElementById("multi_event_month2").value = '0';
			document.getElementById("multi_event_year2").value = '0';
		}
		else
		{
			document.getElementById("day_1").value = document.getElementById("multi_event_day2").value;
			document.getElementById("month_1").value = document.getElementById("multi_event_month2").value;
			document.getElementById("year_1").value = document.getElementById("multi_event_year2").value;
			//alert(document.getElementById("day_2").value);
			$('#venue_stat').val(2);
			$("#complete1").html('Event Published');
			setTimeout('document.getElementById("perfomer_form").submit()',1000);
		}
	}
}

</script>
<script type="text/javascript">

function checkReg()
{
	$('#err_venue_sp').html('');
	$('#err_city').html('');
	$('#err_add').html('');
	$('#err_contact_name').html('');
	$('#err_phone').html('');
	$('#err_cell').html('');
	$('#err_mail').html('');
	
	
	/*alert($("#venue_name").val());
	if($("#venue_name").val()=="" || $("#venue_name").val()=="Name")
	{
		$('#err_venue_name').alert("Please Enter Venue name.");
		$("#venue_name").focus();
		return false;
	}*/
	if($("#venue_name_sp").val()=="" || $("#venue_name_sp").val()=="Nombre")
	{
		$('#err_venue_sp').html("Please Enter Venue name.");
		$("#venue_name_sp").focus();
		return false;
	}
	if($("#venue_city").val()=="")
	{
		$('#err_city').html("Please Enter City.");
		$("#venue_city").focus();
		return false;
	}
	if($("#venue_address").val()=="" || $("#venue_address").val()=="*Address")
	{
		$('#err_add').html("Please Add Address.");
		$("#venue_address").focus();
		return false;	
	}
	if($("#venue_contact_name").val()=="")
	{
		$('#err_contact_name').html("Please Enter Contact Name.");
		$("#venue_contact_name").focus();
		return false;
	}
	if($("#venue_phone").val()=="")
	{
		$('#err_phone').html("Please Enter Phone.");
		$("#venue_phone").focus();
		return false;
	}
	if($("#venue_cell").val()=="")
	{
		$('#err_cell').html("Please Enter Cell Number.");
		$("#venue_cell").focus();
		return false;
	}
	if($("#venue_email").val()=="")
	{
		$('#err_mail').html("Please Enter Email.");
		$("#venue_email").focus();
		return false;
	}
	if($("#venue_email").val()!="")
	{
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

		if(!pattern.test($('#venue_email').val()))
		{
			$('#err_mail').html("Invalid e-mail address!");
			$('#venue_email').focus();
			return false;
		}
	}
	 return true;
}

</script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/menujs/ddaccordion.js"></script>
<script type="text/javascript">
    ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='<?php echo $obj_base_path->base_path(); ?>/menujs/plus.gif' class='statusicon' />", "<img src='<?php echo $obj_base_path->base_path(); ?>/menujs/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
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
	//alert("hii"); return false;
	
	var fields = $("input[class='category_1']").serializeArray(); 
    if (fields.length == 0) 
    { 
        alert('No Categories Selected!'); 
        // cancel submit
        return false;
    } 
	else
	{
		$('#venue_stat').val(1);
		document.getElementById("perfomer_form").submit();
	}
}
</script>

<script>
function edit_rates(performer_rates_id)
{
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
		
		 var ticketVal = $("#perfomer_form").serialize();
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_standard_rates.php",
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
			 $("#description_sp").val("Descripción");
			 $("#description_en").val("Description");
			 $("#price_mx").val("0");
			 $("#price_us").val("0");
			 
			//$('html, body').animate({scrollTop: $("#show_popup").offset().top}, 2000);
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


function validation()
{
	if(document.getElementById('catname').value.search(/\S/) == "-1")
	{
		alert("Please Enter Category Name");
		document.getElementById('catname').focus();
		return false;
	}
	if(document.getElementById('category_name_sp').value.search(/\S/) == "-1")
	{
		alert("Please Enter Category Name");
		document.getElementById('category_name_sp').focus();
		return false;
	}
	return true;
}
</script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
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
           <div class="blue_box10"><p>Edit Category</p></div>
           	<?php include("admin_menu/list_category_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
        <strong><?php echo $msg;?>		
		</strong></div>	
	<?php
	}?>	
	   
    <div class="myevent_box"> 
    
    <div class="title_wrapper">
     <span style="float:right;"><h2><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_subcategory" >List Sub-category </a></h2></span>
                        <span class="title_wrapper_left"></span>
                        <span class="title_wrapper_right"></span>
                    </div>
    <div class="table_wrapper">
    <div class="myevent_left" style="width: 1000px;">
	<div class="guide_box2">
   <form action="" method="post" onsubmit="return validation();">
												<input type="hidden" name="category_id" value="<?php echo $_REQUEST['id']; ?>" />
												<fieldset>
												<!--[if !IE]>start table_wrapper<![endif]-->
												<div class="table_wrapper">
												  <div class="table_wrapper_inner">														
													<table width="100%" border="0" cellpadding="2" cellspacing="2">
													<tr>
													  <td colspan="2"><font color="#FF0000"><?php echo $msg;?></font></td>
													 </tr>
                                                      <tr>
                                                        <td><span style="background: #FFFFFF; float: left; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 10px 0 0; padding:2px; font: bold 20px/20px Arial, Helvetica, sans-serif; display: inline-block;">SP</span>Category Name <font color="#FF0000">*</font></td>
                                                        <td><input type="text" name="category_name_sp" id="category_name_sp" value="<?php echo stripslashes($obj->f('category_name_sp'));?>"  /></td>
                                                      </tr>
                                                      <tr>
                                                        <td><span style="background: #FFFFFF; float: left; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 10px 0 0; padding:2px; font: bold 20px/20px Arial, Helvetica, sans-serif; display: inline-block;">EN</span>Category Name <font color="#FF0000">*</font></td>
                                                        <td><input type="text" name="catname" id="catname" value="<?php echo stripslashes($obj->f('category_name'));?>"  /></td>
                                                      </tr>
                                                      <tr>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rank</td>
                                                        <td><input type="text" name="rank" id="rank" value="<?php echo stripslashes($obj->f('category_rank'));?>"  /></td>
                                                      </tr>
                                                      <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="hidden" name="editcat" value="1" /><input type="submit" name="submit" id="submit" value="Edit"  /></td>
                                                      </tr>
                                                    </table>
												  </div>
												</div>											
												</fieldset>
												</form>
                                                </div>
                                                </div>
                                                </div>



    <div class="clear"></div>
    </div>
    
    
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
