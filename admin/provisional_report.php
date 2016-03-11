<?php
include('../include/admin_inc.php');

//create object

$objEventDetails = new admin;

$objEventDetails->transaction_event("  where event_end_date_time > NOW() ");
$num = $objEventDetails->num_rows();
//echo "num= ".$num;

if(isset($_POST['submit']))
{
	
	$report_check_arr = $_POST['report_check'];
	//print_r($report_check_arr);
	$report_check_event = rtrim(implode(',', $report_check_arr), ',');
	$encrypt_string = base64_encode($report_check_event);
	//echo $report_check_event;
	
	if($report_check_arr!="")  //check transaction
	 {
		header("location:".$obj_base_path->base_path()."/admin/report/".$encrypt_string);
		exit;
	 }
	else
	 {
		$msg = "No event has been selected for report.";
                $_SESSION['msg'] = $msg;
                header("location:".$obj_base_path->base_path()."/admin/event-provisional-report/");
		exit();
	 }

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Event Provisional Report</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>

<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
	.add_media{
		width: auto;
		height: 34px;
		background: #00f;
		margin: 0;
		display: inline-block;
	
	}
	.add_media a{
		font-size: 18px;
		line-height: 34px;
		font-weight:normal;
		color: #fff;
		text-align: center;
		padding:0 12px;
		margin: 0;
		display: block;
		text-decoration: none;
		cursor: pointer;
	}
</style>

<script language="javascript" type="text/javascript">
	
/*---------MULTIPLE CHECK BOX SECTION START -----------*/

function allReportCheck(source) {
		//alert("alj");
  checkboxes = document.getElementsByName('report_check[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

/*---------MULTIPLE CHECK BOX SECTION END -----------*/
</script>

<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>

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
				<div class="blue_box10"><p>Report</p></div>
				<div class="blue_boxr">
				<ul>
				<li><a href="<?php echo $obj_base_path->base_path()."/admin/event-final-report/"?>">Final Report</a></li>
				<li><a href="<?php echo $obj_base_path->base_path()."/admin/event-provisional-report/"?>" class="here">Provisional Report</a></li>
				</ul>
				</div>
			   </div>
			   
			   
			    
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
						
         <input type="hidden" name="listEvent" id="listEvent" value="1" /> 
        	
		 <div class="myevent_box">		 
	 	
			</div>		
          
	 <div class="clear"></div>		
	 <div class="myevent_box">
	  <div class="event_header" style="color:#FF0000"><strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<div style="float: right; margin-bottom: 5px;" font-size="14px;"><input type="submit" name="submit" value="Generate Report" /></div>
		<div class="clear"></div>
		        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
                        <td width="9%" class="top_txt"><input type="checkbox" name="all_report" id="check_all_report" onClick="allReportCheck(this)" value="all_report">Select All</td>
			<td width="26%" class="top_txt">Event Name</td>
                        <td width="20%" class="top_txt">Date & Time</td>
			<td width="20%" class="top_txt">Venue</td>
			<td width="14%" class="top_txt">City</td>
                       	</tr>
			
	                <?php
			if($num>0)
			{
			    while($row = $objEventDetails->next_record())
			     {
				
				list($event_date,$event_time) = explode(" ",$objEventDetails->f('event_start_date_time'));
				list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
				list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);
			        ?>
				
			
				<tr>
				<td width="9%" class="top_txt"><input type="checkbox" name="report_check[]" id="report_check" value="<?php echo $objEventDetails->f('e_id'); ?>"></td>
				<td><?php echo stripslashes($objEventDetails->f('event_name_en'));?></td>
				<td><?php 
				if($ev_hr>12){
				$hr = $ev_hr - 12;
				}
				else
				{
				$hr = $ev_hr;
				}
				
				echo $ev_day."/".$ev_mon."/".$ev_year." - ".$hr.":".$ev_min." ".$objEventDetails->f('event_start_ampm');?></td>
				<td><?php echo $objEventDetails->f('venue_name');?></td>
				<td style="padding: 5px 0;"><?php echo $objEventDetails->f('city_name');?></td>
				</tr>
				
		         <?php
			       }//while end
		         } //if  end
			 
			 else
			 {?>
			<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Ad Found</font></td></tr>	
				
			 <?php }
			 ?>
		
			</table>
	</form>
    	</div>	
		<div class="clear"></div>
	</div>
	</div>
	<div class="clear"></div>	
	</div>
    <div class="clear"></div>
					
</div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>