<?php
// seller
include('../include/admin_inc.php');
//create object
$obj=new admin;
$obj_edit=new admin;
$obj_countries=new admin;
//session value
$admin_id=$_SESSION['ses_user_id'];
$organization_id=$_SESSION['ses_organization_id'];
//submit
if(isset($_POST['Submit1'])){

	$org_fname=$_POST['org_fname'];
	$org_lname=$_POST['org_lname'];
	$organization=$_POST['organization'];
	$org_country=$_POST['org_country'];
	
	$org_address1=$_POST['org_address1'];
	$org_address2=$_POST['org_address2'];
	$org_city=$_POST['org_city'];
	$org_state=$_POST['org_state'];
	
	$org_zip=$_POST['org_zip'];
	$org_phone=$_POST['org_phone'];
	
	$org_fax=$_POST['org_fax'];
	$send_newsletter=$_POST['send_newsletter'];
	//update user detail
	$obj_edit->update_user_org_detail($org_fname,$org_lname,$organization,$org_country,$org_address1,$org_address2,$org_city,$org_state,$org_zip,$org_phone,$org_fax,$organization_id,$send_newsletter);

}

//admin detail
$obj->getOrgByorgId($organization_id);
$obj->next_record();


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
$('#org_fname').tipsy({gravity: 'w'});
$('#org_lname').tipsy({gravity: 'w'});
$('#organization').tipsy({gravity: 'w'});
$('#org_country').tipsy({gravity: 'w'});
$('#org_address1').tipsy({gravity: 'w'});
$('#org_address2').tipsy({gravity: 'w'});
$('#org_city').tipsy({gravity: 'w'});
$('#org_state').tipsy({gravity: 'w'});
$('#org_zip').tipsy({gravity: 'w'});
$('#org_phone').tipsy({gravity: 'w'});
$('#org_fax').tipsy({gravity: 'w'});
});
</script>
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
				<div class="coupons">Organization Settings</div>
									
				</div>
                 <div class="clear"></div>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="organization">
					  <tr>
						<td><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_img.png" border="0" alt="" style="padding:20px 20px 0px 10px;" ></td>
						<td class="guide_heading">Organization Settings</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td><p style="padding-left:0; padding-top: 0; margin-top: -5px;">hese are the details about your organization. We use this information as the primary contact for matters
dealing with events under this account. Only the creator of this account and privileged users can access
and update this information.<br />

If you are looking to change information about your user account (e.g. your name, email and password
you use to login), please visit the <a href="<?php echo $obj_base_path->base_path(); ?>/admin/user">My Account</a> page. </p></td>
					  </tr>
					</table>
				 
                <div class="inner_box2_1">
				<form enctype="multipart/form-data" method="post" action="">
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
                        <?php for($i=1;$i<6; $i++) {
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
				<div class="event_box_new" style="float: left;">First Name<span>*</span></div>
				<div class="event_box_right_new">
				<input type="text" class="text_field2_1_new" value="<?php echo $obj->f('org_fname'); ?>" id="org_fname" name="org_fname" title="Please enter your first name"/>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Last Name<span>*</span></div>
				<div class="event_box_right_new">
				<input type="text" class="text_field2_1_new" id="org_lname" value="<?php echo $obj->f('org_lname'); ?>" name="org_lname" title="Please enter your last name"/>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Organization<span>*</span></div>
				<div class="event_box_right_new">
					<input size="6"  id="organization"  name="organization" value="<?php echo $obj->f('organization_name'); ?>" type="text" class="text_field2_1_new" title="Please enter your organization name" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Country<span>*</span></div>
				<div class="styled_select4" style="width:250px; float:left;">
					<select name="org_country" id="org_country" style="width:275px;padding-left:15px;float:left;" title="Please select country of your organization">
                    <option value="">Select Country</option>
					<?php 
					//list country
					$obj_countries->countries_list();
					while($obj_countries->next_record()){
					?>
					<option value="<?php echo $obj_countries->f('id'); ?>" <?php if ($obj->f('org_country')==$obj_countries->f('id')) echo 'selected="selected"'; ?> ><?php echo $obj_countries->f('printable_name'); ?></option>
					<?php }?>
                  </select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Address 1<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_address1" value="<?php echo $obj->f('org_address1'); ?>" name="org_address1" type="text" class="text_field2_1_new" title="Please enter address of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Address 2</div>
				<div class="event_box_right_new">
					<input id="org_address2" value="<?php echo $obj->f('org_address2'); ?>" name="org_address2" type="text" class="text_field2_1_new" title="Please enter address of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">City<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_city" value="<?php echo $obj->f('org_city'); ?>" name="org_city" type="text" class="text_field2_1_new" title="Please enter city of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">State<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_state" value="<?php echo $obj->f('org_state'); ?>" name="org_state" type="text" class="text_field2_1_new" title="Please enter state of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Zip / Post Code<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_zip" value="<?php echo $obj->f('org_zip'); ?>" name="org_zip" type="text" class="text_field2_1_new" title="Please enter zip code of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Phone<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_phone" value="<?php echo $obj->f('org_phone'); ?>" name="org_phone" type="text" class="text_field2_1_new" title="Please enter phone no of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
				<div class="event_box_new" style="float: left;">Fax<span>*</span></div>
				<div class="event_box_right_new">
					<input id="org_fax" value="<?php echo $obj->f('org_fax'); ?>" name="org_fax" type="text" class="text_field2_1_new" title="Please enter fax no of your organization" />
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="box_in">
                <div style="width: auto; height:32px; float:right; margin:10px 8px 0 0;">
                  <input type="submit" class="btn_save" name="Submit1" id="Submit1" value=""/>
                </div>
              </div>
              <div class="clear"></div>
			    </form>
				</div>
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
