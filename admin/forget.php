<?php 
// foeget password page
include("../class/db_mysql.inc");
include("../class/admin_class.php");
include("../class/pagination.php");
include("../class/class.phpmailer.php");
include('../class/user_class.php');
$obj_base_path = new DB_Sql;
$obj = new admin;
$obj_edit = new admin;
$obj_cat=new user;
session_start();

if( isset($_POST['email']) )
{
	$email=$_POST["email"];	
	
	// -- CHECK ADMIN email
	$obj->getAdminByemail($email);
	$Rcount=$obj->num_rows();
	if ($Rcount > 0 ) 
	{	
		$obj->next_record();						
		//update pass
		$email = $obj_edit->update_admin_pass_detail($obj->f('admin_id'),$obj->f('email'));
		$msg = "<font color='#006600'>Password reset link has been sent to your inbox.</font>";
		//redirect
		//header("Location:".$obj_base_path->base_path()."/admin/index");
	}
	else
	{
		//header("Location:".$obj_base_path->base_path()."/admin/forget/msg/Invalid email information");
		$msg = "<font color='#FF0000'>Email or cell# not found in database.</font>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Kcpasa - Admin Forgot Password</title>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/custom-form-elements.js"></script>
	<script language="JavaScript">
		function chk()
		{
		
			if (document.frm.email.value == "" ) 
			{	
				
				alert("Please enter email or cell no.") ;
				document.frm.email.focus();
				return false ;
			}
			
			
		document.frm.submittype.value=true;
		}
	</script>
	<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
</head>

<body>
<?php include("admin_header.php"); ?>
<div id="maindiv">
	<div class="body_bg">
    	<div class="container">
<!---------------------put your div--here-------------------------------------------------- --> 
            <div class="box1">
                  <div class="logname">FORGOT PASSWORD</div>
				  <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px;"><?php echo $msg;?></div>

					  <div class="log">
					  <form name="frm" method="post" action="" onSubmit="return chk();">
					  <input type="hidden" name="submittype" value="false">
						<ul>
                            <li style="width:800px; padding-bottom:11px;"><span>Please enter your email address or cell number(digits only, no spaces) to receive instructions on resetting your password.</span></li>
                        </ul>
                        <ul>
                            <li><span>Email or Cell#</span><input type="text" name="email" class="textfield_name"  /></li>
                        </ul>
                        <ul>
                            <li><input name="submit1" type="submit" value="SUBMIT" class="login_btn" /></li>
                        </ul>
                    </div>
					</form>
             <div class="clear"></div>
            </div>
<!------------------------------------------------------------------------- -->      	
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
 </div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>
