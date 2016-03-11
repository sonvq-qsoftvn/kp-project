<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$objupdate_meta = new admin;
$objGetMeta_en = new admin;
$objGetMeta_es = new admin;
$objupdate_meta_es = new admin;
/*--------SET THE  TIMING  &  SCHEDULING--------------*/

	    $page_id = $_REQUEST['id']; 
	    
	    $objGetMeta_en->getAllmetaById_en($page_id);
	    $objGetMeta_en->next_record();
	    /*------------ES META DATA----------------*/
	    $objGetMeta_es->getAllmetaById_es($page_id);
	    $objGetMeta_es->next_record();
         

if(isset($_REQUEST['submit'])) /*save for media image*/
  {
    
        $page_id = $_REQUEST['edit_id']; 
	
		$page_name=$_POST['page_name'];
		$meta_title=$_POST['meta_title'];
		$meta_tag=$_POST['meta_tag'];		
		$meta_description=$_POST['meta_description'];
		$meta_title_es=$_POST['meta_title_es'];
	        $meta_tag_es=$_POST['meta_tag_es'];
	        $meta_description_es=$_POST['meta_description_es'];
		
                
		$objupdate_meta->edit_add_meta($page_name,$meta_title,$meta_tag,$meta_description,$page_id); //update  data into kcp_meta_table
		$objupdate_meta_es->edit_add_meta_es($page_name,$meta_title_es,$meta_tag_es,$meta_description_es,$page_id); //update  data into kcp_meta_table
		//exit();
		header("location:".$obj_base_path->base_path()."/admin/meta-list");
                $msg="Meta Successfully edited.";
                $_SESSION['msg']=$msg;
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
           <div class="blue_box10"><p>Edit Meta</p></div>
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
			      <option value="home" <?php if($objGetMeta_en->f('page_name')=='home') echo 'selected=selected' ?>>Home</option>
			      <!--<option value="userprofile"  <?php //if($objGetMeta_en->f('page_name')=='userprofile') echo 'selected=selected' ?>> Professional Profile</option>
			      <option value="professional_preference"  <?php //if($objGetMeta_en->f('page_name')=='professional_preference') echo 'selected=selected' ?>> Professional preference</option>                           
			      <option value="professional_payment"  <?php //if($objGetMeta_en->f('page_name')=='professional_payment') echo 'selected=selected' ?>>Professional Payment</option>-->
			      <!--<option value="event" <?php //if($objGetMeta_en->f('page_name')=='event') echo 'selected=selected' ?>>event</option>-->
			      <option value="blog" <?php if($objGetMeta_en->f('page_name')=='blog') echo 'selected=selected' ?>>blog</option>
			      <option value="my_booking" <?php if($objGetMeta_en->f('page_name')=='my_booking') echo 'selected=selected' ?>>My Booking</option>
			      <option value="registration" <?php if($objGetMeta_en->f('page_name')=='registration') echo 'selected=selected' ?>>Registration</option>
			      <!--<option value="sub_event" <?php //if($objGetMeta_en->f('page_name')=='sub_event') echo 'selected=selected' ?> >Sub event</option>-->
			      <!--<option value="payment" <?php //if($objGetMeta_en->f('page_name')=='payment') echo 'selected=selected' ?> >payment</option>
			      <option value="sub_payment"  <?php //if($objGetMeta_en->f('page_name')=='sub_payment') echo 'selected=selected' ?> >Sub Payment</option>-->
			      <!--<option value="savedevents"  <?php //if($objGetMeta_en->f('page_name')=='savedevents') echo 'selected=selected' ?>>Saved Events</option> -->                  
			      <option value="about"  <?php if($objGetMeta_en->f('page_name')=='about') echo 'selected=selected' ?>>About kpasapp </option>                    			<!------------>
			      
			      <option value="feature"  <?php if($objGetMeta_en->f('page_name')=='feature') echo 'selected=selected' ?>>&nbsp;&nbsp;-Features</option>
				    <option value="plan&pricing"  <?php if($objGetMeta_en->f('page_name')=='plan&pricing') echo 'selected=selected' ?>>&nbsp;&nbsp;-Plans & Pricing</option>
				    <option value="event_goers"  <?php if($objGetMeta_en->f('page_name')=='event_goers') echo 'selected=selected' ?>>&nbsp;&nbsp;-Event-goers</option>
				    <option value="event_proffessional"  <?php if($objGetMeta_en->f('page_name')=='event_proffessional') echo 'selected=selected' ?>>&nbsp;&nbsp;-Event Professionals</option> 
					<option value="event_managers"  <?php if($objGetMeta_en->f('page_name')=='event_managers') echo 'selected=selected' ?>>&nbsp;&nbsp;&nbsp;&nbsp;--Event managers</option>
					<option value="venue_managers"  <?php if($objGetMeta_en->f('page_name')=='venue_managers') echo 'selected=selected' ?>>&nbsp;&nbsp;&nbsp;&nbsp;--Venues managers</option>
					<option value="performers"  <?php if($objGetMeta_en->f('page_name')=='performers') echo 'selected=selected' ?>>&nbsp;&nbsp;&nbsp;&nbsp;--Performers</option>
					<option value="event_service_provider"  <?php if($objGetMeta_en->f('page_name')=='event_service_provider') echo 'selected=selected' ?>>&nbsp;&nbsp;&nbsp;&nbsp;--Event service providers</option>
					<option value="sponsors"  <?php if($objGetMeta_en->f('page_name')=='sponsors') echo 'selected=selected' ?>>&nbsp;&nbsp;&nbsp;&nbsp;--Sponsors</option>
			      <option value="about_baja_sur"  <?php if($objGetMeta_en->f('page_name')=='about_baja_sur') echo 'selected=selected' ?>>About Baja Sur</option>
			      <option value="whats_up"  <?php if($objGetMeta_en->f('page_name')=='whats_up') echo 'selected=selected' ?>>What's Up</option>
			      <option value="resources"  <?php if($objGetMeta_en->f('page_name')=='resources') echo 'selected=selected' ?>>Resources</option>
			      
			              <!------------>
			      </select>    
                              
                            </td>
                            </tr>
			    <tr><td style="padding: 0 5px"><strong>English ::</strong></td></tr>
			      <tr>
				    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Title ::</td>
				    <td width="87%">
				    <textarea name="meta_title" id="meta_title" cols="50" rows="3"><?php echo $objGetMeta_en->f('meta_title') ?></textarea> 
				    </td>
			      </tr>
			      <tr>
				    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Tag::</td>
				    <td width="87%">
				    <textarea name="meta_tag" id="meta_tag" cols="50" rows="10"><?php echo $objGetMeta_en->f('meta_tag') ?></textarea> 
				    </td>
			      </tr>
			      <tr>
				    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Description::</td>
				    <td width="87%">
				    <textarea name="meta_description" id="meta_description" cols="50" rows="10"><?php echo $objGetMeta_en->f('meta_description') ?></textarea> 
				    </td>
			      </tr>
			<!--------------FOR ES START-------------------------------->
			    <tr><td style="padding: 0 5px"><strong>Espanol ::</strong></td></tr>
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Title ::</td>
			    <td width="87%">
			    <textarea name="meta_title_es" id="meta_title_es" cols="50" rows="3"><?php echo $objGetMeta_es->f('meta_title') ?></textarea> 
			     </td>
			    </tr>
			    
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Tag::</td>
			    <td width="87%">
			     <textarea name="meta_tag_es" id="meta_tag_es" cols="50" rows="10"><?php echo $objGetMeta_es->f('meta_tag') ?></textarea> 
			    </td>
			    </tr>
			    <tr>
			    <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 10px;font-size: 10px;">Meta Description::</td>
			    <td width="87%">
			       <textarea name="meta_description_es" id="meta_description_es" cols="50" rows="10"><?php echo $objGetMeta_es->f('meta_description') ?></textarea> 
			    </td>
			    </tr>
			<!-----------------------FOR ES END-------------------------------->
			      <input type="hidden" name="edit_id" value="<?php echo $page_id?>"/>
			      <tr>
			      <td>&nbsp<input type="submit" name="submit" value="Update Meta" class="createbtn" style="cursor:pointer;"/></td>	
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
