<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$objMetaEn = new admin;
$objMetaEs = new admin;
$objMeta = new admin;

/*--------SET THE  TIMING  &  SCHEDULING--------------*/
	
if(isset($_REQUEST['submit'])) /*save for media image*/
  {
	
	      $page_name=$_POST['page_name'];
	      $meta_title=$_POST['meta_title'];
	      $meta_tag=$_POST['meta_tag'];		
	      $meta_description=$_POST['meta_description'];
	      $meta_title_es=$_POST['meta_title_es'];
	      $meta_tag_es=$_POST['meta_tag_es'];
	      $meta_description_es=$_POST['meta_description_es'];
	      
	      
	      $objMeta->getLastMetaId();
	      $objMeta->next_record();
	      $max_id =$objMeta->f('max_id');
	      echo $max_id;
	      if($max_id<1)
	       {
			    $page_id=1;
			    $objMetaEn->insert_add_meta($page_id,$page_name,$meta_title,$meta_tag,$meta_description); //insert  data into kcp_meta_table
			    $objMetaEs->insert_add_meta_es($page_id,$page_name,$meta_title_es,$meta_tag_es,$meta_description_es); //insert  data into kcp_meta_table
	       }
	       else if($max_id >= 1)
	       {
			    $page_id=$max_id+1;
			    $objMetaEn->insert_add_meta($page_id,$page_name,$meta_title,$meta_tag,$meta_description); //insert  data into kcp_meta_table
			    $objMetaEs->insert_add_meta_es($page_id,$page_name,$meta_title_es,$meta_tag_es,$meta_description_es); //insert  data into kcp_meta_table	    
	       }
	      
	      
	      header("location:".$obj_base_path->base_path()."/admin/meta-list/");
	      //$msg="Meta Successfully Added.";
	      //$_SESSION['msg']=$msg;
	      exit();
       
  } //if isset end..
	 
/*--------SET THE  TIMING  &  SCHEDULING--------------*/
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Add Client</title>
	
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
            <?php include("admin_menu/createmata_menu.php");?>   
               
           <div class="blue_box10"><p>Add Meta</p></div>
           <div class="blue_boxr">
		
		</div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
                
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
                        <div class="table_wrapper">
                        <div class="table_wrapper_inner">														
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sptable">
                            <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Page Name ::</td>
                            <td width="87%">
                                
                                
                                  <select name="page_name"  id="page_name">
                                    
					  <option value="home">Home</option>
					  <!--<option value="userprofile"> Professional Profile</option>  
					  <option value="professional_preference">Professional Preference</option> -->
					  <!--<option value="professional_payment">Professional Payment</option>-->   
					  <!--<option value="event">Event</option>-->
					  <option value="my_booking">My Booking</option>
					  <option value="blog">Blog</option>
					  <!--<option value="registration">Registration</option>-->
					 <!-- <option value="sub_event">Sub Event</option>-->
					  <!--<option value="payment">payment</option>
					  <option value="sub_payment">Sub Payment</option>-->
					  <!--<option value="savedevents">Saved Events</option>-->
					  <option value="about">About kpasapp </option>
							<option value="feature">&nbsp;&nbsp;-Features</option>
							<option value="plan&pricing">&nbsp;&nbsp;-Plans & Pricing</option>
							<option value="event_goers">&nbsp;&nbsp;-Event-goers</option>
							<option value="event_proffessional">&nbsp;&nbsp;-Event Professionals</option> 
								      <option value="event_managers">&nbsp;&nbsp;&nbsp;&nbsp;--Event managers</option>
								      <option value="venue_managers">&nbsp;&nbsp;&nbsp;&nbsp;--Venues managers</option>
								      <option value="performers">&nbsp;&nbsp;&nbsp;&nbsp;--Performers</option>
								      <option value="event_service_provider">&nbsp;&nbsp;&nbsp;&nbsp;--Event service providers</option>
								      <option value="sponsors">&nbsp;&nbsp;&nbsp;&nbsp;--Sponsors</option>
					  <option value="about_baja_sur">About Baja Sur</option>
					  <option value="whats_up">What's Up</option>
					  <option value="resources">Resources</option>
                                </select>    
                               
                            
                            </td>
                            </tr>
			    <tr><td style="padding: 0 5px"><strong>English::</strong></td></tr>
                            <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Title ::</td>
                            <td width="87%">
                            <textarea name="meta_title" id="meta_title" cols="50" rows="3"></textarea> 
                             </td>
                            </tr>
                            <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Tag::</td>
                            <td width="87%">
                             <textarea name="meta_tag" id="meta_tag" cols="50" rows="10"></textarea> 
                            </td>
                            </tr>
                            <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Description::</td>
                            <td width="87%">
                               <textarea name="meta_description" id="meta_description" cols="50" rows="10"></textarea> 
                            </td>
                            </tr>
	      <!--------------FOR ES START-------------------------------->
			    <tr><td style="padding: 0 5px"><strong>Espanol::</strong></td></tr>
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Title ::</td>
			    <td width="87%">
			    <textarea name="meta_title_es" id="meta_title_es" cols="50" rows="3"></textarea> 
			     </td>
			    </tr>
			    
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Tag::</td>
			    <td width="87%">
			     <textarea name="meta_tag_es" id="meta_tag_es" cols="50" rows="10"></textarea> 
			    </td>
			    </tr>
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Description::</td>
			    <td width="87%">
			       <textarea name="meta_description_es" id="meta_description_es" cols="50" rows="10"></textarea> 
			    </td>
			    </tr>
	       <!-----------------------FOR ES END-------------------------------->
                            <tr>
                            <td>&nbsp<input type="submit" name="submit" value="Add Meta" class="createbtn" style="cursor:pointer;"/></td>	
                            <td></td>
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
