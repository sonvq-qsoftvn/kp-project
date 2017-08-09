<?php
include('include/user_inc.php');
$obj=new user;
$obj_sendmail=new user;
//echo $_SESSION['langSessId'];


if($_SESSION['ses_admin_id']!="")
	header("Location:".$obj_base_path->base_path()."/index");

if( isset($_POST['hid_sign']) )
{
	$faq = new User;

	/*$loginid=$_POST["email_cell"];

	if($loginid==""){
		$_SESSION['login_msg1'] = "Please insert your email address!";
		header("Location:".$obj_base_path->base_path()."/forgot_password.php");	
        exit;
	}
			

 	$faq->checkAdminUser($loginid) ;
	if($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$rem_password = $faq->f('rem_password');
		$email = $faq->f('email');
		
		//send password email
		$obj_sendmail->forgot_pass($rem_password,$email);			

		
		//redirect
		if($_SESSION['langSessId']=='eng')
		$_SESSION['login_msg1'] = "Your Password is sent to your email address!";
		header("Location:".$obj_base_path->base_path()."/forgot_password.php");
		exit;

	}
	else{
		
		//$_SESSION['login_msg1'] = "Email address not found. Please enter a correct email or phone number.";
		if($_SESSION['langSessId']=='eng')
		$_SESSION['login_msg1'] = "Email address or cell number are not found.<br> Please enter your email address or cell number including country code (digits only no space) to receive instructions on resetting your password.";
		else
		$_SESSION['login_msg1'] = "DirecciÃ³n de correo electrÃ³nico o nÃºmero de celular no se encuentran.<br>Introduzca su direcciÃ³n de correo electrÃ³nico o nÃºmero de celular con prefijo del paÃ­s (sÃ³lo dÃ­gitos sin espacios) para recibir instrucciones sobre cÃ³mo restablecer su contraseÃ±a.
";
		header("Location:".$obj_base_path->base_path()."/forgot_password.php");
		exit;
	}*/
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forgot Password</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.placeholder.min.js"></script>
<?php /*?><script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/forgot_contact.js"></script><?php */?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.error{
		color:red;
		margin:0 10px;
		font: normal 11px/16px Arial, Helvetica, sans-serif;	
	}
</style>


</head>

<body>

<?php include("include/secondary_header.php");?>
<?php 
	include("include/menu_header.php");
	include('forgot_contact.php');
?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
            	<div class="cheese_box">
                    <div class="blue_box1" style="width: 976px;">
                    <div class="blue_boxh">
                    <?php if($_SESSION['langSessId']=='eng') {?>
                    <p>Forgot Password</p>
                    <?php
                    }else{
					?>
                    <p>OlvidÃ³ contraseÃ±a</p>
                    <?php }?>
                    </div>
                    </div>
                	<div class="clear"></div>
                    	<div style="width: 976px; float: none; margin: 0 auto;">
						  <div class="Tchai_box1" style="margin: 10px auto; float: left;">
                            <div style="color:red;font: normal 14px/20px Arial, Helvetica, sans-serif;" id="showresponse">
                                <?php echo $_SESSION['login_msg1'];  $_SESSION['login_msg1'] = '';?>
                            </div>
                          <div class="clear"></div>
                          <form method="post" action="" enctype="multipart/form-data" name="forgot_pass" id="forgot_pass" autocomplete="off">
                            <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                            <table width="100%" align="center" border="1" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                              <tr>
                                <td colspan="2">
                                <?php if($_SESSION['langSessId']=='eng') {?>
                                Please enter your email address or cell number including country code (digits only no space) to receive instructions on resetting your password.
                                <?php } else {?>
                                Introduzca su direcciÃ³n de correo electrÃ³nico o n Âº de mÃ³vil con prefijo del paÃ­s (sÃ³lo nÃºmeros, sin espacios) para recibir instrucciones sobre cÃ³mo reinicializar su contraseÃ±a.
                                <?php }?>
                                
                                </td>
                              </tr>
                              <tr>
                                <td width="30%" style="text-align: left;">
								<?php if($_SESSION['langSessId']=='eng') {?>
                                Email or Cell# With country code
                                <?php } else {?>
                                E-mail o mÃ³vil # con cÃ³digo de paÃ­s
                                <?php }?>
                                </td>
                                <td width="70%"><input type="text" name="email_cell" id="email_cell" class="textbg_grey" value="" style="width:190px;"/><div id="email_err" style="color:red;"></div></td>
                              </tr>
                              <tr>

                                <td>
                                  
                                </td>
                                <td>
                                  <div style="margin: 3px 0 0 6px;" class="g-recaptcha" data-sitekey="6Le4MAsUAAAAAPwZhwVvMIXcQVIieF3ltoMXHa2H"></div>
                                  <label class="captcha_error error" style="display: none;">Please verify that you are human</label>
                                </td>
                                  
                              </tr>
                              <tr>
                                <td><input type="submit" name="submit11" id="submit11" value="<?php if($_SESSION['langSessId']=='eng') {?>Submit<?php } else {?>Enviar<?php }?>" class="event_save"  style="text-align: left; margin-left:0; cursor:pointer;"/></td>
                                <td style="padding-top: 13px;">&nbsp; </td>
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
    <?php include("include/frontend_footer.php");
		
?>
</div>

<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
<script>
//    $('#submit11').click(function (e) {
//        e.preventDefault();
//        var g_recaptcha_response = $('#g-recaptcha-response').val();
//
//        if(g_recaptcha_response == '') {
//            $('.captcha_error').css('display', 'inline');
//            return false;    
//        } else {
//            $('.captcha_error').css('display', 'none');
//            $('#forgot_pass').submit();
//        }
//    });
</script>
</body>
</html>
