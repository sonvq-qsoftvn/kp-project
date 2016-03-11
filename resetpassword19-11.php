<?php
include('include/user_inc.php');
//print_r($_SESSION);
//$obj=new user;
if( isset($_POST['hid_reset_password']) )
{
	$user = $_REQUEST['user'];
	$reset = new User;
	$reset->checkpass($user);
	
	if ($reset->num_rows() > 0 ) 
	{	
		$password = $_REQUEST['password']; 
		$reset->changepass($user,$password);
		header("Location:".$obj_base_path->base_path()."/successfulreset.php");
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset Password</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>

<script type="text/javascript">
	function resetPassword()
	{
		if($('#password').val() == "")
		{
			$('#result').html("Please enter your New Password!");
			$('#password').focus();
			return false;
		}
		if($('#password').val().length <= 4)
		{
			$('#result').html("Password must contain at least 5 characters");
			$('#password').focus();
			return false;
		}
		if($('#re_newpass').val() == "")
		{
			$('#err_re_newpass').html("Please retype your New Password!");
			$('#re_newpass').focus();
			return false;
		}
		if($('#password').val() != $('#re_newpass').val())
		{
			$('#err_re_newpass').html("Retype password will be similar to the new Password");
			$('#re_newpass').focus();
			return false;
		}
		return true;
	}
</script>
<style type="text/css">
	.error{
		color:red;
		margin:0 10px;
		font: normal 11px/16px Arial, Helvetica, sans-serif;	
	}
	.short{
		color:red;
		margin:0 10px;
		font: normal 11px/16px Arial, Helvetica, sans-serif;	
	}
	.weak{
		color:red;
		margin:0 10px;
		font: normal 11px/16px Arial, Helvetica, sans-serif;	
	}
</style>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
            	<div class="cheese_box">
                    <div class="blue_box1" style="width: 976px;">
                    <div class="blue_boxh"><p><?php echo "Password Reset";?></p></div>

                    </div>
                	<div class="clear"></div>
					<div style="font:normal 12px/17px Verdana, Arial, Helvetica,sans-serif;font-weight:bold;padding: 12px 0 0 20px;">
                    <?php if($_SESSION['langSessId']=='eng') {?>
                    We have successfully verified your identity.
                    <?php
                    }else{
					?>
                    Hemos verificado con éxito su identidad
                    <?php }?>
                    </div>
					<div style="font: normal 12px/17px Verdana, Arial, Helvetica, sans-serif; padding: 12px 0 0 20px;">
                    <?php if($_SESSION['langSessId']=='eng') {?>
                    Enter a New Password for your KPasapp account
                    <?php
                    }else{
					?>
                    Introduzca una nueva contraseña para su cuenta KPasapp.
                    <?php }?>
                    </div>
                	<div class="clear"></div>
                    <div style="width: 976px; float: none; margin: 0 auto;">	
				  	<div class="Tchai_box1" style="width: 570px; margin: 18px auto; border-left: 0x solid #CCCCCC; float: left;">
                    
                    <?php if($_SESSION['login_msg']){?>
					<div style="width: 494px; float: left; margin: 0 auto 0 23px;">
                    	<h1 style="font: normal 22px/20px Arial, Helvetica, sans-serif; color: #0C9; padding: 0; margin: 0 0 10px;"><?php echo $_SESSION['login_msg']; $_SESSION['login_msg'] = '';?></h1>
                    </div>
                    <?php } ?>
					
					
					<div class="clear"></div>
                    
                      <form method="post" action="" enctype="multipart/form-data" name="reset_pwd" id="reset_pwd" autocomplete = "off" onsubmit="return resetPassword();">
                        <input type="hidden" name="hid_reset_password" id="hid_reset_password" value="1" />
						<input type="hidden" name="user" id="user" value="<?php echo $_REQUEST['user']; ?>" />
                        <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                          <tr>
                            <td width="36%" style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng') {?>New Password <?php }else{?>Nueva contraseña: <?php } ?><span style="color:red;">*</span></td>
                            <td width="64%"><input type="password" name="password" id="password" class="textbg_grey required" style="width: 190px;"/><br/><!--<span class="error" id="err_newpass"></span>--><span class="error" id="result"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng') {?>Retype the New Password <?php }else{?>Reescribe la nueva contraseña: <?php } ?><span style="color:red;">*</span></td>
                         	<td><input type="password" name="re_newpass" id="re_newpass" class="textbg_grey required" style="width: 190px;"/> <br/><span class="error" id="err_re_newpass"></span></td>
                          </tr>
                          <tr>
						    <td colspan="2" style="text-align:left; padding-left: 15px;"><input type="submit" name="submit1" id="submit1" value="Reset Password" class="event_save" style="cursor:pointer;"/></td>
                          </tr>						  
                        </table>
                      </form>
                    </div>

					</div>
                </div>
                <div class="clear"></div>
            </div>
           <?php //include("include/frontend_rightsidebar.php");?>
           <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");
		
?>
</div>


</body>

</html>