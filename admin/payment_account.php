<?php
include('../include/admin_inc.php');
print_r($_SESSION);

$obj=new user;
$obj1=new user;
$obj_sendmail=new user;
$faq = new User;
$edit_admin= new User;



//print_r($_SESSION);


/*if( isset($_POST['hid_edit']) )
{
	//print_r($_POST);exit;
	
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$province=$_POST["province"];
	$city=$_POST["city"];
	$account_type=$_POST["account_type"];
	if($account_type==1)
	{
		$account_type = $_POST['account_type_prof'];
	}
	
	
	
	$faq->checkEmailexists($email,$_SESSION['ses_admin_id']) ;

	if(!$faq->num_rows() > 0 ) 
	{	
		$edit_admin->edit_admin_details($fname,$lname,$email,$phone,$province,$city,$account_type,$_SESSION['ses_admin_id']);
		$_SESSION['login_msg'] = "Data Saved!";
		//redirect
		header("Location:".$obj_base_path->base_path()."/userprofile");
		exit;

	}
	else
	{
		$_SESSION['login_msg'] = "Email Id Already Exists!";
		header("Location:".$obj_base_path->base_path()."/userprofile");
		exit;
	}
}*/



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profile Setting</title>

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
function displayOther()
{

	if($('input:radio[name=account_type]:checked').val()==1)
	{
		$('#prof_types').show();
	}
	else
	{
		$('#prof_types').hide();
	}
}

<?php
	if($obj->f('account_type')!=0){
?>
$(document).ready(function(){

	document.getElementById('pincode2').checked = true;
	$('#prof_types').show();
})
<?php
	}
?>


</script>

<body class="body1">

<?php include("admin_header.php"); ?>


<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
        <div class="container">
			<?php include("admin_header_menu.php");?> 
            <div id="body">
        		<div class="body2"> 
		           <div class="blue_box1">
                   	<div class="blue_box10"><p>Payment Info</p></div>
                   </div> 
        		</div>	
      		</div>
        </div>
        <div class="container">
            <div class="left_panel bg" style="width:978px;">
                <div class="cheese_box">
                    
                    <div class="clear"></div>
                    <div style="width: 976px; float: none; margin: 0 auto;">	
                    <div class="Tchai_box1" style="">
                    
                    <?php if($_SESSION['login_msg']){?>
                    <div style="width: 494px; float: left; margin: 0 auto 0 23px;">
                        <h1 style="font: normal 22px/20px Arial, Helvetica, sans-serif; color: #0C9; padding: 0; margin: 0 0 10px;"><?php echo $_SESSION['login_msg']; $_SESSION['login_msg'] = '';?></h1>
                    </div>
                    <?php } ?>
                    
                    
                    <div class="clear"></div>
                    
                      <form method="post" action="" enctype="multipart/form-data" name="edit_pro" id="edit_pro" autocomplete = "off">
                      <input type="hidden" name="hid_edit" id="hid_edit" value="1" />
                        <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                          <tr>
                            <td width="25%" style="padding-left: 18px;">Payable To<span style="color:red;">*</span></td>
                            <td width="75%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="<?php echo $obj->f('fname')?>" style="width: 190px;"/><br/><span class="err" id="err_name"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">Paypal Id<span style="color:red;">*</span></td>
                            <td><input type="text" name="lname" id="lname" class="textbg_grey required" value="<?php echo $obj->f('lname');?>" style="width: 190px;"/> <br/><span class="err" id="err_lname"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">Address 1</td>
                            <td><input type="text" name="email" id="email" class="textbg_grey required email" style="width: 190px;" value="<?php echo $obj->f('email')?>" onclick="clean_err()" onblur="checkEmail()"/><br/><div class="clear"></div><span class="err" id="email_err"></span> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">Address 2</td>
                            <td><input type="text" name="phone" id="phone" class="textbg_grey" value="<?php echo $obj->f('phone')?>" style="width: 190px;"/></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">State/Province<span style="color:red;">*</span></td>
                            <td><input type="text" name="province" id="province" class="textbg_grey required" value="<?php echo $obj->f('province');?>" style="width: 190px;"/> </td>
                          </tr>
                           <tr>
                            <td style="padding-left: 18px;">City<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                           <tr>
                            <td style="padding-left: 18px;">Postal Code<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;" colspan="2"><div style="font-size:24px; line-height:60px;">Wire Transfer Information</div></td>
                          </tr>
                          
                          
                           <tr>
                            <td style="padding-left: 18px;">Bank Name<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                           </tr>
                          <tr>
                            <td style="padding-left: 18px;">Bank Address<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">Routing Number (ABA)<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;">Account Name (Company Name)<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;">Address<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;">Account Number<span style="color:red;">*</span></td>
                            <td><input type="text" name="city" id="city" class="textbg_grey required" value="<?php echo $obj->f('city');?>" style="width: 190px;"/> </td>
                          </tr>
                          
                          <tr>
                            <td colspan="2" style="text-align:left; padding-left: 15px;">
                            	<input type="submit" name="submit1" id="submit1" value="Update Account" style=" cursor:pointer;"  class="event_save"/></td>
                          </tr>
                          
                        </table>
                      </form>
                    </div>
    
                    </div>
                </div>
                <div class="clear"></div>
            </div>
           <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
	</div>
<div class="clear"></div>
<?php include("admin_footer.php"); ?>


</body>

</html>
