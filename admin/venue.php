<?php
// venue
include('../include/admin_inc.php');
//create object
$obj=new admin;
$obj_countries=new admin;
$obj_edit=new admin;
$obj_add=new admin;
$obj_thumb=new admin;
//session value
$organization_id=$_SESSION['ses_organization_id'];
$admin_id=$_SESSION['ses_user_id'];

//request value
$venue_id=$_REQUEST['venue_id'];

//submit
if(isset($_POST['Submit1'])){
	
	//echo "hi";die();
	//post value
	$venue_name=$_POST['venue_name'];
	$venue_country=$_POST['venue_country'];
	$venue_address=$_POST['venue_address'];
	$venue_city=$_POST['venue_city'];
	$venue_state=$_POST['venue_state'];	
	$venue_zip=$_POST['venue_zip'];
	$venue_timezone=$_POST['venue_timezone'];
	$venue_contact_name=$_POST['venue_contact_name'];
	$venue_description=$_POST['venue_description'];
	$venue_type=$_POST['venue_type'];
	$venue_capacity=$_POST['venue_capacity'];
	$venue_url=$_POST['venue_url'];
	$venue_phone=$_POST['venue_phone'];
	$venue_fax=$_POST['venue_fax'];
	$venue_email=$_POST['venue_email'];
	
	$err=array();
	if($venue_name=='')
	$err[1]="Venue Name is required";
	if($venue_country=='')
	$err[2]="Venue Country is required";
	if($venue_address=='')
	$err[3]="Venue Address is required";
	if($venue_city=='')
	$err[4]="Venue City is required";
	if($venue_state=='')
	$err[5]="Venue State is required";
	if($venue_zip=='')
	$err[6]="Venue Zip is required";
	if($venue_timezone=='')
	$err[7]="Venue Timezone is required";
	if($venue_contact_name=='')
	$err[8]="Venue Contact Name is required";
	if($venue_description=='')
	$err[9]="Venue Description is required";
	if($venue_type=='')
	$err[10]="Venue Type is required";
	if($venue_capacity=='')
	$err[11]="Venue Capacity is required";
	if($venue_url=='')
	$err[12]="Venue Url is required";
	if($venue_phone=='')
	$err[13]="Venue Phone is required";
	if($venue_fax=='')
	$err[14]="Venue Fax is required";
	if($venue_email=='')
	{
	$err[15]="Venue Email is required";	
	}elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $venue_email))
	{
	$err[15]="Venue Email is not valid";	
	}

	if(!(count($err)>0)){
	
	$tmp_image=$_FILES['venue_image']['tmp_name'];
	if(is_uploaded_file($tmp_image)){
		$venue_image=time()."_".$_FILES['venue_image']['name'];
		move_uploaded_file($tmp_image,"../files/venue/".$venue_image);
		$obj_thumb->create_thumbnail("../files/venue/".$venue_image,"../files/venue/thumb/".$venue_image,260,180);
	}
	$tmp_image1=$_FILES['venue_seat_chart']['tmp_name'];
	if(is_uploaded_file($tmp_image1)){
		$venue_seat_chart=time()."_".$_FILES['venue_seat_chart']['name'];
		move_uploaded_file($tmp_image1,"../files/venue/venue_seat_chart/".$venue_seat_chart);
		$obj_thumb->create_thumbnail("../files/venue/venue_seat_chart/".$venue_seat_chart,"../files/venue/venue_seat_chart/thumb/".$venue_seat_chart,260,180);
	}
	
	//add venue detail
	$obj_add->add_venue_detail($venue_name,$venue_country,$venue_address,$venue_city,$venue_state,$venue_zip,$venue_timezone,$venue_contact_name,$venue_description,$venue_type,$venue_capacity,$venue_url,$venue_phone,$venue_fax,$venue_email,$venue_image,$venue_seat_chart,$admin_id,$organization_id);
	
	//redirect to list page
	header("Location:".$obj_base_path->base_path()."/admin/venues");
	}
	
}
if(isset($_POST['Submit3'])){

	//post value
	$venue_name=$_POST['venue_name'];
	$venue_country=$_POST['venue_country'];
	$venue_address=$_POST['venue_address'];
	$venue_city=$_POST['venue_city'];
	$venue_state=$_POST['venue_state'];	
	$venue_zip=$_POST['venue_zip'];
	$venue_timezone=$_POST['venue_timezone'];
	$venue_contact_name=$_POST['venue_contact_name'];
	$venue_description=$_POST['venue_description'];
	$venue_type=$_POST['venue_type'];
	$venue_capacity=$_POST['venue_capacity'];
	$venue_url=$_POST['venue_url'];
	$venue_phone=$_POST['venue_phone'];
	$venue_fax=$_POST['venue_fax'];
	$venue_email=$_POST['venue_email'];
	
	$err=array();
	if($venue_name=='')
	$err[1]="Venue Name is required";
	if($venue_country=='')
	$err[2]="Venue Country is required";
	if($venue_address=='')
	$err[3]="Venue Address is required";
	if($venue_city=='')
	$err[4]="Venue City is required";
	if($venue_state=='')
	$err[5]="Venue State is required";
	if($venue_zip=='')
	$err[6]="Venue Zip is required";
	if($venue_timezone=='')
	$err[7]="Venue Timezone is required";
	if($venue_contact_name=='')
	$err[8]="Venue Contact Name is required";
	if($venue_description=='')
	$err[9]="Venue Description is required";
	if($venue_type=='')
	$err[10]="Venue Type is required";
	if($venue_capacity=='')
	$err[11]="Venue Capacity is required";
	if($venue_url=='')
	$err[12]="Venue Url is required";
	if($venue_phone=='')
	$err[13]="Venue Phone is required";
	if($venue_fax=='')
	$err[14]="Venue Fax is required";
	if($venue_email=='')
	{
	$err[15]="Venue Email is required";	
	}elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $venue_email))
	{
	$err[15]="Venue Email is not valid";	
	}
	if(!(count($err)>0)){
		
	$tmp_image=$_FILES['venue_image']['tmp_name'];
	if(is_uploaded_file($tmp_image)){
		//delete files
		@unlink("../files/venue/".$_POST['old_venue_image']);
		@unlink("../files/venue/thumb/".$_POST['old_venue_image']);
		$venue_image=time()."_".$_FILES['venue_image']['name'];
		move_uploaded_file($tmp_image,"../files/venue/".$venue_image);
		$obj_thumb->create_thumbnail("../files/venue/".$venue_image,"../files/venue/thumb/".$venue_image,260,180);
	}else{
		$venue_image=$_POST['old_venue_image'];
	}
	$tmp_image1=$_FILES['venue_seat_chart']['tmp_name'];
	if(is_uploaded_file($tmp_image1)){
		//delete files
		@unlink("../files/venue/venue_seat_chart/".$_POST['old_venue_seat_chart']);
		@unlink("../files/venue/venue_seat_chart/thumb/".$_POST['old_venue_seat_chart']);
		
		$venue_seat_chart=time()."_".$_FILES['venue_seat_chart']['name'];
		move_uploaded_file($tmp_image1,"../files/venue/venue_seat_chart/".$venue_seat_chart);
		$obj_thumb->create_thumbnail("../files/venue/venue_seat_chart/".$venue_seat_chart,"../files/venue/venue_seat_chart/thumb/".$venue_seat_chart,260,180);
	}else{
		$venue_seat_chart=$_POST['old_venue_seat_chart'];
	}
	
	//add venue detail
	$obj_edit->update_venue_detail($venue_name,$venue_country,$venue_address,$venue_city,$venue_state,$venue_zip,$venue_timezone,$venue_contact_name,$venue_description,$venue_type,$venue_capacity,$venue_url,$venue_phone,$venue_fax,$venue_email,$venue_image,$venue_seat_chart,$admin_id,$organization_id,$venue_id);
	
	//redirect to list page
	header("Location:".$obj_base_path->base_path()."/admin/venues");
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our site</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
	
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<!--jquery alert-->
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.alerts.js" type="text/javascript"></script>
<!--jquery alert-->
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#venue_name').tipsy({gravity: 'w'});
$('#select_venue').tipsy({gravity: 'w'});
$('#venue_address').tipsy({gravity: 'w'});
$('#venue_city').tipsy({gravity: 'w'});
$('#venue_state').tipsy({gravity: 'w'});
$('#venue_zip').tipsy({gravity: 'w'});
$('#venue_timezone').tipsy({gravity: 'w'});
$('#venue_contact_name').tipsy({gravity: 'w'});
$('#venue_description').tipsy({gravity: 'w'});
$('#venue_type').tipsy({gravity: 'w'});
$('#venue_capacity').tipsy({gravity: 'w'});
$('#venue_url').tipsy({gravity: 'w'});
$('#venue_phone').tipsy({gravity: 'w'});
$('#venue_fax').tipsy({gravity: 'w'});
$('#venue_email').tipsy({gravity: 'w'});
$('#venue_image').tipsy({gravity: 'w'});
$('#venue_seat_chart').tipsy({gravity: 'w'});

});
</script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$("#current_img").fancybox();
});
$(document).ready(function() {
	$("#current_img2").fancybox();
});
</script>
<!--jQuery lightBox plugin>-->
<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
</head>
<body>
<!--start maincontainer-->
	<div id="maincontainer">	
	  <!--start head-->
		<?php include("header.php");?>
		 <div class="clear"></div>		
		<!--start body-->
		<section id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <?php include("top_menu.php");?>                  
                
				<?php include("sidebar.php");  ?>                         	
              <div id="coupon_admin1" style="margin: 4px 8px;">			 
			  <div class="custom_box">
			  <div class="inner_box">
              	<div class="step">
				<div class="coupons">Add a Venue</div>
									
				</div>
                 <div class="clear"></div>
				 <?php if ($_REQUEST['venue_id']==''){   ?>
	  			<form enctype="multipart/form-data" method="post" action="">
	  			<input type="hidden" name="admin_id" value="<?php echo $_REQUEST['admin_id']; ?>" />
                <div class="inner_box2_1">
				
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
                        <?php for($i=1;$i<16; $i++) {
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
			
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Venue Name<span>*</span></div>
				<div class="event_box_right_new">
				<input name="venue_name" type="text" class="text_field2_1_new" value="<?php echo $_POST['venue_name']; ?>" id="venue_name" title="Please enter venue name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Country<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_country" id="select_venue" style="width:275px;padding-left:15px;float:left;" title="Please select country">
                    <option value="">Select Country</option>
					<?php 
					//list country
					$obj_countries->countries_list();
					while($obj_countries->next_record()){
					?>
					<option value="<?php echo $obj_countries->f('id'); ?>"><?php echo $obj_countries->f('printable_name'); ?></option>
					<?php }?>
                  </select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Address<span>*</span></div>
				<div class="event_box_right_new">
					<input size="6" id="venue_address"  name="venue_address" value="<?php echo $_POST['venue_address']; ?>" type="text" class="text_field2_1_new" title="Please enter Address" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">City<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_city" size="6" id="venue_city" value="<?php echo $_POST['venue_city']; ?>" type="text" class="text_field2_1_new" title="Please enter city name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">State<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_state" size="6" id="venue_state" value="<?php echo $_POST['venue_state']; ?>" type="text" class="text_field2_1_new" title="Please enter state name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Zip / Post Code<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_zip" size="6" id="venue_zip" value="<?php echo $_POST['venue_zip']; ?>" type="text" class="text_field2_1_new" title="Please enter zip code" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Timezone Name<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_timezone" id="venue_timezone" style="width:275px;padding-left:15px;float:left;" title="Please select time zone">
                    <option value="">---</option>
					<option value="America/New_York" <?php if ($_POST['venue_timezone']=="America/New_York") echo 'selected="selected"'; ?>  >Eastern Time</option>
					<option value="America/Chicago" <?php if ($_POST['venue_timezone']=="America/Chicago") echo 'selected="selected"'; ?>>Central Time</option>
					<option value="America/Denver" <?php if ($_POST['venue_timezone']=="America/Denver") echo 'selected="selected"'; ?>>Mountain Time</option>
					<option value="America/Phoenix" <?php if ($_POST['venue_timezone']=="America/Phoenix") echo 'selected="selected"'; ?>>Mountain Time (Arizona)</option>
					<option value="America/Los_Angeles" <?php if ($_POST['venue_timezone']=="America/Los_Angeles") echo 'selected="selected"'; ?>>Pacific Time</option>
					<option value="America/Juneau" <?php if ($_POST['venue_timezone']=="America/Juneau") echo 'selected="selected"'; ?>>Alaskan Time</option>
					<option value="Pacific/Honolulu" <?php if ($_POST['venue_timezone']=="Pacific/Honolulu") echo 'selected="selected"'; ?>>Hawaiian Time</option>
					<option value="Pacific/Samoa" <?php if ($_POST['venue_timezone']=="Pacific/Samoa") echo 'selected="selected"'; ?>>Samoa Standard Time</option>
              		</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Contact Name<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_contact_name" size="6" id="venue_contact_name" value="<?php echo $_POST['venue_contact_name']; ?>" type="text" class="text_field2_1_new" title="Please enter contact name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Description<span>*</span></div>
				<div class="event_box_right_new">
					<textarea cols="" rows="" class="text_area_descrip1_new" name="venue_description" id="venue_description" title="Please enter description" ><?php echo $_POST['venue_description']; ?></textarea>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Status<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_type" id="venue_type" style="width:275px;padding-left:15px;float:left;" title="Please select status">
                    <option value="">---</option>
					<option selected="selected" value="2">General Admission</option>
					<option value="3">Seated</option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Capacity<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_capacity" size="6"  id="venue_capacity" value="<?php echo $_POST['venue_capacity']; ?>" type="text" class="text_field2_1_new" title="Please enter capacity" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">URL<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_url" size="6" id="venue_url" value="<?php echo $_POST['venue_url']; ?>" type="text" class="text_field2_1_new" title="Please enter URL" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Phone<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_phone" size="6" id="venue_phone" value="<?php echo $_POST['venue_phone']; ?>" type="text" class="text_field2_1_new" title="Please enter phone no" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Fax<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_fax" size="6"  id="venue_fax" value="<?php echo $_POST['venue_fax']; ?>" type="text" class="text_field2_1_new" title="Please enter fax no" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Email<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_email" size="6" id="venue_email" value="<?php echo $_POST['venue_email']; ?>" type="text" class="text_field2_1_new" title="Please enter cmail id" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Image<span>*</span></div>
				<div class="event_box_right_new">
					<input type="file"   id="venue_image" name="venue_image" title="Please choose an image" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Seating Chart<span>*</span></div>
				<div class="event_box_right_new">
					<input type="file"  id="venue_seat_chart" name="venue_seat_chart" title="Please choose seating chart" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
                <div style="width: auto; height:32px; float:right; margin:10px 8px 0 0;">
                  <input type="submit" class="btn_save" name="Submit1" id="Submit1" value=""/>
                </div>
              </div>
              <div class="clear"></div>
			  
             </div>
               <div class="clear"></div> 
			    </form>
				<?php } else { 
	  			//venue detail
	  			$obj->getVenueById($venue_id,$organization_id);
	  			$obj->next_record();
	  
	 			 ?>	  
	  			<form enctype="multipart/form-data" method="post" action="">
	  			<input type="hidden" name="admin_id" value="<?php echo $_REQUEST['admin_id']; ?>" />
	  			<input type="hidden" name="venue_id" value="<?php echo $_REQUEST['venue_id']; ?>" />
				 <div class="inner_box2_1">
				
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
                        <?php for($i=1;$i<16; $i++) {
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
			
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Venue Name<span>*</span></div>
				<div class="event_box_right_new">
				<input name="venue_name" type="text" class="text_field2_1_new" value="<?php echo $obj->f('venue_name'); ?>" id="venue_name" title="Please enter venue name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Country<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_country" id="select_venue" style="width:275px;padding-left:15px;float:left;"  title="Please select country">
                    <option value="">Select Country</option>
					<?php 
					//list country
					$obj_countries->countries_list();
					while($obj_countries->next_record()){
					?>
					<option value="<?php echo $obj_countries->f('id'); ?>"  <?php if($obj->f('venue_country')==$obj_countries->f('id')) { echo 'selected'; }?>><?php echo $obj_countries->f('printable_name'); ?></option>
					<?php }?>
                  </select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Address<span>*</span></div>
				<div class="event_box_right_new">
					<input size="6" id="venue_address"  name="venue_address" value="<?php echo $obj->f('venue_address'); ?>" type="text" class="text_field2_1_new" title="Please enter Address" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">City<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_city" size="6" id="venue_city" value="<?php echo $obj->f('venue_city'); ?>" type="text" class="text_field2_1_new" title="Please enter city name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">State<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_state" size="6" id="venue_state" value="<?php echo $obj->f('venue_state'); ?>" type="text" class="text_field2_1_new" title="Please enter state name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Zip / Post Code<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_zip" size="6" id="venue_zip" value="<?php echo $obj->f('venue_zip'); ?>" type="text" class="text_field2_1_new" title="Please enter zip code" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Timezone Name<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_timezone" id="venue_timezone" style="width:275px;padding-left:15px;float:left;" title="Please select time zone">
                    <option value="">---</option>
					<option value="America/New_York" <?php if ($obj->f('venue_timezone')=="America/New_York") echo 'selected="selected"'; ?>  >Eastern Time</option>
					<option value="America/Chicago" <?php if ($obj->f('venue_timezone')=="America/Chicago") echo 'selected="selected"'; ?>>Central Time</option>
					<option value="America/Denver" <?php if ($obj->f('venue_timezone')=="America/Denver") echo 'selected="selected"'; ?>>Mountain Time</option>
					<option value="America/Phoenix" <?php if ($obj->f('venue_timezone')=="America/Phoenix") echo 'selected="selected"'; ?>>Mountain Time (Arizona)</option>
					<option value="America/Los_Angeles" <?php if ($obj->f('venue_timezone')=="America/Los_Angeles") echo 'selected="selected"'; ?>>Pacific Time</option>
					<option value="America/Juneau" <?php if ($obj->f('venue_timezone')=="America/Juneau") echo 'selected="selected"'; ?>>Alaskan Time</option>
					<option value="Pacific/Honolulu" <?php if ($obj->f('venue_timezone')=="Pacific/Honolulu") echo 'selected="selected"'; ?>>Hawaiian Time</option>
					<option value="Pacific/Samoa" <?php if ($obj->f('venue_timezone')=="Pacific/Samoa") echo 'selected="selected"'; ?>>Samoa Standard Time</option>
              		</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Contact Name<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_contact_name" size="6" id="venue_contact_name" value="<?php echo $obj->f('venue_contact_name'); ?>" type="text" class="text_field2_1_new" title="Please enter contact name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Description<span>*</span></div>
				<div class="event_box_right_new">
					<textarea cols="" rows="" class="text_area_descrip1" name="venue_description" id="venue_description" title="Please enter description" ><?php echo $obj->f('venue_description'); ?></textarea>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Status<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="venue_type" id="venue_type" style="width:275px;padding-left:15px;float:left;" title="Please select status">
                    <option value="">---</option>
					<option <?php if($obj->f('venue_type')==2){ ?> selected="selected" <?php }?> value="2">General Admission</option>
					<option <?php if($obj->f('venue_type')==3){ ?> selected="selected" <?php }?> value="3">Seated</option>
				   </select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Capacity<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_capacity" size="6"  id="venue_capacity" value="<?php echo $obj->f('venue_capacity'); ?>" type="text" class="text_field2_1_new" title="Please enter capacity" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">URL<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_url" size="6" id="venue_url" value="<?php echo $obj->f('venue_url'); ?>" type="text" class="text_field2_1_new" title="Please enter URL" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Phone<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_phone" size="6" id="venue_phone" value="<?php echo $obj->f('venue_phone'); ?>" type="text" class="text_field2_1_new" title="Please enter phone no" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Fax<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_fax" size="6"  id="venue_fax" value="<?php echo $obj->f('venue_fax'); ?>" type="text" class="text_field2_1_new" title="Please enter fax no" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Email<span>*</span></div>
				<div class="event_box_right_new">
					<input name="venue_email" size="6" id="venue_email" value="<?php echo $obj->f('venue_email'); ?>" type="text" class="text_field2_1_new" title="Please enter cmail id" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Image<span>*</span></div>
				<div class="event_box_right_new">
					<input type="file"   id="venue_image" name="venue_image" title="Please choose an image" />
					<input type="hidden" id="old_venue_image" name="old_venue_image" value="<?php echo $obj->f('venue_image'); ?>"/>&nbsp;&nbsp;<?php if($obj->f('venue_image')){?>
                  <a href="<?php echo $obj_base_path->base_path(); ?>/files/venue/<?=$obj->f('venue_image')?>" id="current_img">View Image</a>
                  <?php }?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Seating Chart<span>*</span></div>
				<div class="event_box_right_new">
					<input type="file"  id="venue_seat_chart" name="venue_seat_chart" />
					<input type="hidden" id="old_venue_seat_chart" name="old_venue_seat_chart" value="<?php echo $obj->f('venue_seat_chart'); ?>" title="Please choose seating chart"/>&nbsp;&nbsp;<?php if($obj->f('venue_seat_chart')){?>
                  <a href="<?php echo $obj_base_path->base_path(); ?>/files/venue/venue_seat_chart/<?=$obj->f('venue_seat_chart')?>" id="current_img2">View Image</a>
                  <?php }?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
                <div style="width: auto; height:32px; float:right; margin:10px 8px 0 0;">
                  <input type="submit" class="btn_save" name="Submit3" id="Submit1" value=""/>
                </div>
              </div>
              <div class="clear"></div>
			  
             </div>
               <div class="clear"></div> 
			   </form>
			   <?php }?>
			  </div> 
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