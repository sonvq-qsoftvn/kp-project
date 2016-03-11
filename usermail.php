<?php
include('include/user_inc.php');
$obj=new user;
$faq=new user;
$edit_admin=new user;
$obj_sendmail=new user;
$obj_getDtls=new user;
$obj_all_mail=new user;

//print_r($_SESSION);exit;

if($_SESSION['ses_admin_id']=="")
	header("Location:".$obj_base_path->base_path()."/index");
	
$obj_all_mail->getAllEmailId($_SESSION['ses_admin_id'])	;
	
if( isset($_POST['todo']) )
{
	//print_r($_POST);exit;
	
	$email_address=$_POST["email_address"];
	
	$faq->checkEmail($email_address) ;

	if(!$faq->num_rows() > 0 ) 
	{	
		
		$obj_getDtls->checkpass($_SESSION['ses_admin_id']);
		$obj_getDtls->next_record();

		// Send Email
		$obj_sendmail->send_confrimation($email_address,$obj_getDtls->f('fname'));
		
		$edit_admin->add_more_emailid_user($email_address);
		$_SESSION['duplicate_email'] = "You have added a new email address to your account. A confirmation email has been sent to that address. Please confirm this new email address by clicking on the link in the email.!";
		
		//redirect
		header("Location:".$obj_base_path->base_path()."/usermail");
		exit;

	}
	else
	{
		$_SESSION['duplicate_email'] = "Email Id Already Exists!";
		header("Location:".$obj_base_path->base_path()."/usermail");
		exit;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Email</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    <div class="clear"></div>
    <div class="container">
        <div class="left_panel bg" style="width:978px;">
        <div class="clear"></div>
        <div><span style="font: bold 16px/20px Arial, Helvetica, sans-serif; color: #c77822;">Email</span> 
       	  <span style="margin-left:50px; font: normal 12px/20px Arial, Helvetica, sans-serif; color: #000;"> 
        		<?php if($_SESSION['duplicate_email']!=""){ echo $_SESSION['duplicate_email']; $_SESSION['duplicate_email'] = ''; } else { ?>You currently have 1 email address added to your account. You can add <strong>1</strong> more <?php } ?> 
            <?php echo $_SESSION['duplicate_email']."sssss";?></span>
			<span style="float: right; font: bold 16px/20px Arial, Helvetica, sans-serif;"><a href="#" style="color:#1c819a;  text-decoration: underline;">Back to My </a><a href="#" style="color:#000; text-decoration: underline;">KPasapp</a></span>
			</div>
         
          <form method="post" name="email_management" id="email_management" enctype="multipart/form-data" action="">
        	<input type="hidden" name="todo" id="todo" value="1" />
            <?php /*?><table width="100%" border="0" cellpadding="4" cellspacing="4" style="margin: 20px auto;">
              <tr>
                <td width="18%">Select</td>
                <td colspan="3">Email Address</td>
                <td width="34%">Status</td>
              </tr>
              <?php
			  while($obj_all_mail->next_record()){
			  ?>
               <tr>
                <td><input type="radio" name="email_primary" value="<?php echo $obj_all_mail->f('email')?>" <?php if($obj_all_mail->f('status')==1){?> checked="checked" <?php } ?> /></td>
                <td colspan="3"><?php echo $obj_all_mail->f('email')?></td>
                <td><?php if($obj_all_mail->f('status')==1){?> Primary <?php } ?></td>
              </tr>
              <?php
			  }
			  
			  if($obj_all_mail->num_rows()<2){
			  ?>
              <tr>
                <td colspan="5"><input type="text" name="email_address" id="email_address" placeholder="Email Address" /></td>
              </tr>
              <?php } ?>
              <tr>
                <td>
                	<div style="float:left;"><input type="button" onclick="makeEmailConfirmation()" name="make_primary" id="make_primary" value="Make Primary" class="event_save" /></div>
                	<div style="float:left;"><input type="button" name="confirm" id="confirm" value="Confirm" class="event_save" /></div>
                	<div style="float:left;"><input type="button" name="remove" id="remove" value="Remove" class="event_save" /></div>
                	<div style="float:right;"><input type="submit" name="add" id="add" value="Add" class="event_save" /></div>
                    <?php if($obj_all_mail->num_rows()<2){ ?>
                		<div style="float:right;"><input type="button" name="cancel" id="cancel" value="Cancel" class="event_save" /></div>
                    <?php } ?>
                </td>
              </tr>
            </table><?php */?>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 5px auto;">
                <tr>
                  <td>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                <td width="18%" style="background: #e8f1fa; padding:8px;">Select</td>
                <td colspan="3" style="background: #e8f1fa; padding:8px;">Email Address</td>
                <td width="34%" style="background: #e8f1fa; padding:8px;">Status</td>
                 </tr>
                  </table></td>
                </tr>
                 <?php
				  while($obj_all_mail->next_record()){
				  ?>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                    <td width="18%" style="padding:8px;"><input name="email_primary" type="radio" value="<?php echo $obj_all_mail->f('email')?>" <?php if($obj_all_mail->f('status')==1){?> checked="checked" <?php } ?>/></td>
                    <td colspan="3" style="padding:8px;"><?php echo $obj_all_mail->f('email')?></td>
                    <td width="34%" style="padding:8px; color: #444444;"><strong><?php if($obj_all_mail->f('status')==1){?> Primary <?php } ?></strong></td>
                 </tr>
                 </table></td>
                </tr>
                <?php
			  		}
					if($obj_all_mail->num_rows()<2){
				  ?> 
              	<tr>
                   <td colspan="5" style="padding-left:187px;"><input type="text" class="textbg_grey2" name="email_address" id="email_address" placeholder="Email Address" /></td>
                   </tr>
                  
              <?php } ?>
                <tr>
                  <td>
                	<div style="float:left;"><input type="button" onclick="makeEmailConfirmation()" name="make_primary" id="make_primary" value="Make Primary" class="event_save" /></div>
                	<div style="float:left;"><input type="button" name="confirm" id="confirm" value="Confirm" class="event_save" /></div>
                	<div style="float:left;"><input type="button" name="remove" id="remove" value="Remove" class="event_save" /></div>
                	<div style="float:right;"><input type="submit" name="add" id="add" value="Add" class="event_save" /></div>
                     <?php if($obj_all_mail->num_rows()<2){ ?>
                		<div style="float:right;"><input type="button" name="cancel" id="cancel" value="Cancel" class="event_save" /></div>
                     <?php } ?>
                    </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>			
          </form>
           <div class="clear"></div>
        </div>
       <div class="clear"></div>
    </div>

    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
<?php include("include/frontend_footer.php");?>
</div>


</body>
</html>
