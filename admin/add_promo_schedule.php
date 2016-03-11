<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$objEventPromoInstruction = new admin;
$objEventPromoInstructionDelete = new admin;
$objPromoInstruction = new admin;
$objEventDetails = new admin;
$objPromoSchedule = new admin;
$objPromoSchedule_Insert = new admin;
$objPromoSchedule_Delete = new admin;
$objAllPromoSchedule = new admin;

$event_id=$_REQUEST['event_id'];
//echo $event_id;

$objPromoInstruction->getPromotionInstructionById($event_id);
$objPromoInstruction->next_record();
//$objPromoInstruction->f('dpost1');
//===============CODE FOR INSERT===================//
$objPromoSchedule->allSocialByEvent($event_id);
$num=$objPromoSchedule->num_rows();

//----event------//
$objEventDetails->event_details_byID($event_id);
$objEventDetails->next_record();		

/*<!-------------------------->*/
	
	//----get  event date----//
	$event_date_time = $objEventDetails->f('event_start_date_time');
	//echo "sumitra= ".$objEventDetails->f('event_start_date_time');
	$event_date_array = explode(" ",$event_date_time);
	$event_date = $event_date_array[0];
	//echo "e-date= ".$event_date."<br/>";
	
	//----get current date----//
	$cur_date = date("Y-m-d");
	//echo $cur_date;
	
	//----get tomorrow date----//
	$date = date_create($cur_date);
	//echo "d= ".$date;
	date_add($date, date_interval_create_from_date_string('1 days'));
	$tomorrow = date_format($date, 'Y-m-d');
	//echo "T= ".$tomorrow;
	
	//$diff=date_diff($event_date,$tomorrow);
	//echo $diff->format("%R%a days");
	
	 $daylen = 60*60*24;
         $remaining_days=round((strtotime($event_date)-strtotime($tomorrow))/$daylen);
	 
        if($remaining_days>0)
	{$remaining_days=$remaining_days;}
	else{$remaining_days=0;}

      //echo "remain=".$remaining_days;
	
/*<!---------------------------->*/

/*---------ONLY  SET THE  TIMING START------------*/
if(isset($_REQUEST['set_time']))
 {
	$e_id=$_POST['event_id'];
	$dpost1=$_POST['dpost1'];
	$dpost2=$_POST['dpost2'];
	$dpost3=$_POST['dpost3'];
	$dpost4=$_POST['dpost4'];
	$dpost5=$_POST['dpost5'];
	
	 // delete  from the   `kcp_event_promo_instruction` table
	 $objEventPromoInstructionDelete->deletePromoInstruction($e_id); 
	 //insert data into `kcp_event_promo_instruction` table
	 $objEventPromoInstruction->add_event_promo_instruction($e_id,$dpost1,$dpost2,$dpost3,$dpost4,$dpost5);
	 header("location:".$obj_base_path->base_path()."/admin/event-list");
	
 }
/*--------ONLY  SET THE  TIMING END--------------*/

/*--------SET THE  TIMING  &  SCHEDULING--------------*/
	
if(isset($_REQUEST['submit'])) /*save for media image*/
  {
	/*Checking if data in `kcp_event_promo_schedule` table or  not  with respect  to  event_id*/
	$objAllPromoSchedule->allPromoScheduleByEvent($event_id);
	$num=$objAllPromoSchedule->num_rows();
	
	$e_id=$_POST['event_id'];
	
	if($num<1) /*if data in table with respect  to  event_id*/
	{
		
		$dpost1=$_POST['dpost1'];
		$dpost2=$_POST['dpost2'];
		$dpost3=$_POST['dpost3'];
		$dpost4=$_POST['dpost4'];
		$dpost5=$_POST['dpost5'];
		
		$objPromoSchedule_Delete->deletePromoSchedule($event_id); //delete all data from `kcp_event_promo_schedule` table with respect to event_id;
		while($rows=$objPromoSchedule->next_record())
		{
			
			for($i=1;$i<=5;$i++)
			{
				
				$dpostvar='dpost'.$i;  //drop down days values..
				//echo "S=>".$$dpostvar;
				//echo "ED= ".$event_date."<br/>";
				/*----------random Time  Generator---------------*/
				$mt_rand=mt_rand(0,600);
				  //echo "ntr= ".$mt_rand;
				$minute = (int)$mt_rand % 60;
				//echo "mnt= ".$minute;
				$hour = round($mt_rand / 60);
				//echo "hr= ".$hour;
				$extra_time=7+$hour.":".$minute;
				//echo "ET= ".$extra_time;
				$posting_date = strtotime(date($event_date) . ' - '.$$dpostvar.' day');
				$publish_date = date('Y-m-d',$posting_date)." ".$extra_time.":00";
				 // echo "PD=".$publish_date."<br/>";
				//  exit();
				/*-----------random Time  Generator End----------------*/
				
			$social_id = $objPromoSchedule->f('social_id'); // social_id from kcp_social_event table
			$objPromoSchedule_Insert->add_promo_schdule($social_id,$event_id,$publish_date); //insert data in   `kcp_event_promo_schedule` table
		        }
		}
			// delete  from the   `kcp_event_promo_instruction` table
			$objEventPromoInstructionDelete->deletePromoInstruction($e_id);
			//insert data into `kcp_event_promo_instruction` table
			$objEventPromoInstruction->add_event_promo_instruction($e_id,$dpost1,$dpost2,$dpost3,$dpost4,$dpost5);
		
		header("location:".$obj_base_path->base_path()."/admin/event-list");
		exit();
        }//if end..
	else
	{
		$msg="Warning! The social posting schedule cannot be changes once it has been created.";
		$_SESSION['msg']=$msg;
		header("location:".$obj_base_path->base_path()."/admin/add-promo-schedule/event/".$e_id);
		exit();
	}
  } //if isset end..
	 
/*--------SET THE  TIMING  &  SCHEDULING--------------*/
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Add Social</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->

<script>
function clickwarning()
{
 confirm("Warning! The social posting schedule cannot be changes once it has been created.");
}
</script>
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
           <div class="blue_box10"><p>Promotion</p></div>
           <div class="blue_boxr">
		<ul>
		<li><a href="<?php echo $obj_base_path->base_path()."/admin/add-promo-schedule/event/".$event_id?>" class="here">Set Promotion time/Schedule</a></li>
		<li><a href="<?php echo $obj_base_path->base_path()."/admin/add-promotion/event/".$event_id?>">List/Select Social Pages</a></li>
		</ul>
		</div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
                  <!--------Event Details Start------------->
			<div>
			<?php
			//event_name   Event_Start_DateTime   Event_Venue   Event_City
			echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
			?>
			</div>
		  <!--------Event Details End------------->
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><span id="savemsg"><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></span></strong></div>
		
		
    <div class="myevent_box"> 
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
                <div class="guide_box2">
                   <!-- <form action="" method="post" onsubmit="return validation();">-->
		   
		    <!--1st All Select  Form start-->
		  
		    <div>
		   
			<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">
                    <fieldset>
                    <!--[if !IE]>start table_wrapper<![endif]-->
                    <div class="table_wrapper">
                      <div class="table_wrapper_inner">														
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sptable">
			<tr>
			<td colspan="3"><font color="#FF0000"><?php //echo $msg;?></font></td>
			</tr>
			<tr>
				
			<td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 4px; font-weight:900">dpost1 ::</td>
			<td>
			<select name="dpost1">
			<?php 
                              for($i=0; $i<=$remaining_days; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>"  <?php if($objPromoInstruction->f('dpost1')==$i){?>selected <?php } ?>><?php echo $i; ?></option>
                        <?php }?>
			</select> &nbsp days before the event
			</td>
			</tr>
                     
			<tr>
			<td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 4px; font-weight:900">dpost2 ::</td>
			<td>
			<select name="dpost2">
			<?php 
                           for($i=0; $i<=$remaining_days; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>" <?php if($objPromoInstruction->f('dpost2')==$i){?>selected <?php } ?>><?php echo $i; ?></option>
                        <?php }?>
			</select> &nbsp days before the event
			</td>
			</tr>
			
			<tr>
			<td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 4px; font-weight:900">dpost3 ::</td>
			<td>
			<select name="dpost3">
			<?php 
                             for($i=0; $i<=$remaining_days; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>"  <?php if($objPromoInstruction->f('dpost3')==$i){?>selected <?php } ?>><?php echo $i; ?></option>
                        <?php }?>
			</select> &nbsp days before the event
			</td>
			</tr>
			
			<tr>
			<td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 4px; font-weight:900">dpost4 ::</td>
			<td>
			<select name="dpost4">
			<?php 
                             for($i=0; $i<=$remaining_days; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>"  <?php if($objPromoInstruction->f('dpost4')==$i){?>selected <?php } ?>><?php echo $i; ?></option>
                        <?php }?>
			</select> &nbsp days before the event
			</td>
			</tr>
			
			<tr>
			<td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 4px; font-weight:900">dpost5 ::</td>
			<td>
			<select name="dpost5">
			<?php 
                              for($i=0; $i<=$remaining_days; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>"  <?php if($objPromoInstruction->f('dpost5')==$i){?>selected <?php } ?>><?php echo $i; ?></option>
                        <?php }?>
			</select> &nbsp days before the event
			</td>
			</tr>
			
                        <tr>
			<td>&nbsp<input type="submit" name="set_time" value="Save & Exit" class="createbtn" style="cursor:pointer;"/></td>	
			<td>
			<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="event_id"/>
			<input type="submit" name="submit" id="submit" value="Create Social Posting Schedule" class="createbtn" style="cursor:pointer;" onclick="clickwarning()"/>
			</td>
			</td>
                        </tr>
                        </table>
                      </div>
                    </div>											
                    </fieldset>
                    </form>
		    </div>
		<!---------2nd form END---------------->
		<div class="clear"></div>
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


</body>
</html>
