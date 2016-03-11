<?php
include('include/user_inc.php');

$obj=new user;
if($_SESSION['ses_admin_id']!="")
	header("Location:".$obj_base_path->base_path()."/index");

if( isset($_POST['hid_sign']) )
{
	//print_r($_POST);exit;
	$loginid=$_POST["email_cell"];
	$pass=$_POST["pass_signin"];
	$faq = new User;

	 $faq->login($loginid,$pass) ;

	if ($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['admin_email'] = $faq->f('email');
		$_SESSION['name'] = $faq->f('fname')." ". $faq->f('lname');
		$_SESSION['ses_admin_id'] = $faq->f('admin_id');
		$_SESSION['login_mode'] = 'site';
	?>
    	<script>
			window.location ="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
		</script>
    <?php	
		//redirect
		//header("Location:".$obj_base_path->base_path()."/index");
	}
	else
	{
		if($_SESSION['langSessId']=='eng')
		$_SESSION['login_msg'] = "Invalid login. Please try again.";
		else
		$_SESSION['login_msg'] = "login inválido. Por favor, inténtelo de nuevo.";
		header("Location:".$obj_base_path->base_path()."/successfulreset.php");
		exit;
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
                    <?php if($_SESSION['login_msg']){?>
                    <div style="color:red;font: normal 12px/20px Arial, Helvetica, sans-serif; margin-left:22px;">
                        <?php echo $_SESSION['login_msg'];unset($_SESSION['login_msg']);?>
                    </div>
                    <?php } ?>
                	<div class="clear"></div>
					<div style="font: normal 12px/17px Verdana, Arial, Helvetica, sans-serif; padding: 12px 0 0 20px;">
                    	<?php if($_SESSION['langSessId']=='eng') {?>
                        Congratulations! You have successfully reset your password.
                        <?php
						}else{
						?>
                        ¡Su contraseña fue reinicializada exitosamente!
                        <?php }?>
                        </div>
                	<div class="clear"></div>

                    <div>
	                  <form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete = "off">
	                    <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                    	<table width="100%" border="1">
                          <tr>
                            <td width="44%" style="text-align:center;"><input type="text" name="email_cell"  id="email_cell" class="textbg_grey" placeholder="Email address or Cell#" style="width: 190px;"/></td>
                            <td width="27%"><input type="password" name="pass_signin" placeholder="Password" id="pass_signin" style="width: 190px;"/></td>
                            <td width="29%" style="text-align:left;"><input type="submit" name="submit11" id="submit11" value="" class="event_signin" style="cursor:pointer;" /></td>
                          </tr>
                        </table>
					 </form>
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