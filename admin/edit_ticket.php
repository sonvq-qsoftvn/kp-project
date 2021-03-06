<?php
// home page
session_start();
include('../include/admin_inc.php');

//create object
$objlist=new admin;
$objlist_ticketbyId=new admin;
$obj_edit=new admin;
$obj_event=new admin;
$obj_city=new admin;

$event_id = $_GET['event_id'];

$objlist_ticketbyId->ticketById($_GET['id']);
$objlist_ticketbyId->next_record();

// Event
$obj_event->eventVenue($_GET['event_id']);
$obj_event->next_record();

list($event_date,$event_time) = explode(" ",$obj_event->f('event_start_date_time'));
list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);

// get City Event
$obj_city->getCityByEventId($_GET['event_id']);
$obj_city->next_record();



if(isset($_POST['edit_ticket']) && $_POST['edit_ticket'] == '1')	
{
	$exit_ticket_id = $_POST['exit_ticket_id'];
	
	$ticket_name_en = addslashes($_POST['ticket_name_en']);
	$ticket_name_sp = addslashes($_POST['ticket_name_sp']);
	$description_en = addslashes($_POST['description_en']);
	$description_sp = addslashes($_POST['description_sp']);
	$price_mx = addslashes($_POST['price_mx']);
	$price_us = addslashes($_POST['price_us']);
	$ticket_num = addslashes($_POST['ticket_num']);
	$eairly_dis_percen = $_POST['eairly_dis_percen'];
	$eairly_days = $_POST['eairly_days'];
	$group_dis_per = $_POST['group_dis_per'];
	$group_dis_days = $_POST['group_dis_days'];
	$members_only = $_POST['members_only'];
	$photoname = $_POST['photoname'];
	$from_ticket = strtotime($_POST['from_ticket']);
	$to_ticket = strtotime($_POST['to_ticket']);
	
	//echo $to_ticket;exit;
	
	$obj_edit->edit_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$from_ticket,$to_ticket,$photoname,$exit_ticket_id);


	header("location: ".$obj_base_path->base_path()."/admin/list-tickets/".$_GET['event_id']);
	exit;
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Preview Ticket</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

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
$(document).ready(function(){
$('#image_popup').fancybox();
})


$(document).ready(function() {
	$('#from_ticket').datepicker({
		firstDay: 1,
		dateFormat: 'dd-mm-yy'
		});
	$('#to_ticket').datepicker({
		firstDay: 1,
		dateFormat: 'dd-mm-yy'
		});
})


$(function(){
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: 'upload_ticket.php',
			name: 'uploadfile',
			data: {"id":"<?php echo $_GET['id'];?>"}, 
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
				$('#photoname').val(response);
				//$('#imgid').html('<img id="imgid" src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/thumb/"'+response+' />')
				$('#me').html('');
				
				//On completion clear the status
				//files.html('');
				//Add uploaded file to list
//				if(response==="success"){
//					$('<li></li>').appendTo('#files').html('<img src="images/webinfopedia_'+file+'" alt="" height="120" width="130" /><br />').addClass('success');
//				} else{
//					$('<li></li>').appendTo('#files').text(file).addClass('error');
//				}
			}
		});
		
	});
	
	
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

function checkReg()
{
	$('#shw_num_avail').html("");
	$('#sp_name_err').html("");
	$('#en_name_err').html("");
	
	
	if($('#ticket_name_sp').val()=="" || $('#ticket_name_sp').val()=="Nombre")
	{
		$('#sp_name_err').html("Please Insert name of tickets in Spanish.");
		$('#ticket_name_sp').focus();
		return false;
	}
	else if($('#ticket_name_en').val()=="" || $('#ticket_name_en').val()=="Name")
	{
		$('#en_name_err').html("Please Insert name of tickets in English.");
		$('#ticket_name_en').focus();
		return false;
	}
	else if($('#ticket_num').val()=="" || $('#ticket_num').val()=="0")
	{
		$('#shw_num_avail').html("Please Insert number of tickets.");
		$('#ticket_num').focus();
		return false;
	}
}



</script>
<style>
.event_popup1 td {
	padding: 5px;
	line-height: 22px;
}
.event_popup1 th {
	padding: 5px 15px;;
}
textarea.textareabg {
	margin: 0;
}
form table {
	padding: 0;
	margin: 0 auto;
}
input.createbtn {
	padding: 0 20px;
	margin: 10px 0 0 0;
}
p {
	margin: 0;
}
</style>
<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
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
           <div class="blue_boxh"><p>Edit Ticket</p></div>
           <div class="blue_boxr">
            <ul>
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-tickets/<?php echo $event_id;?>">Create</a></li>
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-tickets/<?php echo $event_id;?>" class="here">List/edit</a></li>
               <li><a href="#">Promote</a></li>	
               <li><a href="#">View bookings</a></li>
               <li><a href="#">Reports</a></li>						   
            </ul>
           </div>
           </div> 
         <div class="clear"></div>
        </div>	
       </div>
	  </div>

            
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;"><strong><?php echo $msg;?></strong></div>
    <div style="font-family:Arial, Helvetica, sans-serif;">
    	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="id_detail">
          <tr>
            <td width="31%"><?php echo $obj_event->f('event_name_en')?></td>
            <td width="17%"><?php echo $ev_day."-".$ev_mon."-".$ev_year." - ".$ev_hr.":".$ev_min." ".$objlist->f('event_start_ampm');?></td>
            <td width="37%"><?php echo $obj_event->f('venue_name')?></td>
            <td width="15%"><?php echo $obj_city->f('city_name'); ?></td>
          </tr>
        </table>
    </div>
			
    <div class="event_popup1" id="show_popup" style="width:650px;">	
      <div class="clear"></div>
        <form method="post" name="ticket_form" id="ticket_form" enctype="multipart/form-data" onsubmit="return checkReg()">
          <input type="hidden" name="edit_ticket" id="edit_ticket" value="1" />
          <input type="hidden" name="photoname" id="photoname" value="<?php echo $objlist_ticketbyId->f('ticket_icon')?>" />
          <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="<?php echo $_GET['id'];?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #bbb; margin: 15px auto;">
           <tr>
             <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><input type="text" name="ticket_name_sp" id="ticket_name_sp" value="<?php echo $objlist_ticketbyId->f('ticket_name_sp');?>" style="width: 360px;" class="inputbg ticket_common_class" />
                      <div style="color:red; margin:0 4px;" id="sp_name_err"></div>
			</td>
           </tr>
           <tr>
             <td>
             	<div style="width: 184px; float: left;"><span class="tit">EN</span></div><input type="text" name="ticket_name_en" id="ticket_name_en" value="<?php echo $objlist_ticketbyId->f('ticket_name_en');?>" style="width: 360px;" class="inputbg ticket_common_class" />
	         <div style="color:red; margin:0 4px;" id="en_name_err"></div>
                </td>
           </tr>
           <tr>
             <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><textarea name="description_sp" id="description_sp" class="textareabg ticket_common_class"><?php echo $objlist_ticketbyId->f('description_sp');?></textarea></td>
           </tr>
           <tr>
             <td><div style="width: 184px; float: left;"><span class="tit">EN</span></div><textarea name="description_en" id="description_en" class="textareabg ticket_common_class"><?php echo $objlist_ticketbyId->f('description_en');?></textarea></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <th style=" width: 149px;">Price MX pesos</th>
                 <td><input type="text" name="price_mx" id="price_mx" class="inputbg ticket_common_class" value="<?php echo $objlist_ticketbyId->f('price_mx');?>" onblur="checDecimal('price_mx','shw_price_mx')"  /><span style="color:red; margin:0 4px;" id="shw_price_mx">&nbsp;</span></td>
               </tr>
               <tr>
                 <th>Price US dollars</th>
                 <td><input type="text" name="price_us" id="price_us" class="inputbg ticket_common_class" value="<?php echo $objlist_ticketbyId->f('price_us');?>" onblur="checDecimal('price_us','shw_price_us')"  /><span style="color:red; margin:0 4px;" id="shw_price_us">&nbsp;</span></td>
               </tr>
               <tr>
                 <th>Number of Available tickets</th>
                 <td><input type="text" name="ticket_num" id="ticket_num" class="inputbg ticket_common_class" value="<?php echo $objlist_ticketbyId->f('ticket_num');?>" onblur="checkInt('ticket_num','shw_num_avail')" /><span style="color:red; margin:0 4px;" id="shw_num_avail">&nbsp;</span></td>
               </tr>
               <tr>
                 <th colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <th width="24%">From </th>
                     <td width="28%"><input type="text" name="from_ticket" id="from_ticket" class="inputbg1 ticket_common_class" value="<?php echo date("d-m-Y",$objlist_ticketbyId->f('from_ticket'));?>" /></td>
                     <th width="6%">To</th>
                     <td width="30%"><input type="text" name="to_ticket" id="to_ticket" class="inputbg1 ticket_common_class" value="<?php echo date("d-m-Y",$objlist_ticketbyId->f('to_ticket'));?>" /></td>
                   </tr>
                 </table></th>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25%"  style="text-align:right;padding: 5px 15px;"><strong>Early bird discount</strong></td>
                 <td width="12%"><input type="text" name="eairly_dis_percen" id="eairly_dis_percen" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticketbyId->f('eairly_dis_percen');?>" /></td>
                 <td width="10%"><strong>% up to</strong></td>
                 <td width="12%"><input type="text" name="eairly_days" id="eairly_days" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticketbyId->f('eairly_days');?>" /></td>
                 <td width="30%"><p><strong>Days before the event</strong></td>
               </tr>
               
             </table></td>
           </tr>
           
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25%" style="text-align:right;padding: 5px 15px;"><strong>Group Discount</strong></td>
                 <td width="12%"><input type="text" name="group_dis_per" id="group_dis_per" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticketbyId->f('group_dis_per');?>" /></td>
                 <td width="10%"><strong> % over</strong></td>
                 <td width="12%"><input type="text" name="group_dis_days" id="group_dis_days" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticketbyId->f('group_dis_days');?>" /></td>
                 <td width="30%"><p><strong>Tickets</strong></p></td>
               </tr>
               <tr>
                 <td colspan="5"><div style="float:left; margin:0 20px;width:135px;font-weight:bold; text-align:right;">Members only</div><input type="radio" name="members_only" id="members_only1" value="Y" <?php if($objlist_ticketbyId->f('members_only') == 'Y') { echo 'checked'; }?> /> Yes&nbsp;&nbsp;<input type="radio" name="members_only" id="members_only2" value="N" <?php if($objlist_ticketbyId->f('members_only') == 'N') { echo 'checked'; }?> /> No</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="27%" style="text-align:right;padding: 5px 15px;"><strong>Ticket Icon</strong></td>
                 <td>
					<?php if($objlist_ticketbyId->f('ticket_icon') != '') { ?>
                        <a href="#showimg" id="image_popup"><img id="imgid" src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/thumb/<?php echo $objlist_ticketbyId->f('ticket_icon')?>" /></a>
				       <div style="display:none;">
                        <div id="showimg" style="width:auto; height:auto;">
                            <?php if($objlist_ticketbyId->f('ticket_icon')!='') { ?><img src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/large/<?php echo $objlist_ticketbyId->f('ticket_icon')?>" border="0" /><?php } ?>
                        </div>	
                       </div>					
			            <?php }  ?>
                        <div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon</span></span></div><span id="mestatus" ></span>
                 </td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td colspan="2" style="text-align:center;"><input type="submit" name="Submit2" value="Save & Exit" class="createbtn" /></td>
               </tr>
             </table></td>
           </tr>       
         </table>
        </form>
	  </div>
	<div class="clear"></div>
    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
 </div>

<?php include("admin_footer.php"); ?>

</body>
</html>
