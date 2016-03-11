<?php 
// recover password page
include("../class/db_mysql.inc");
include("../class/admin_class.php");
include("../class/pagination.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;
$obj = new admin;
$obj_edit = new admin;
session_start();

if( isset($_POST['password']) )
{
	$recover_pass=$_POST["recover_pass"];
	$password=$_POST["password"];	
	// -- CHECK ADMIN email
//	$obj->getAdminByemail_pass($email,$recover_pass);
//	$Rcount=$obj->num_rows();
//	if ($Rcount > 0 ) 
//	{	
//		$obj->next_record();						
		//update pass
		$obj_edit->update_admin_pass($recover_pass,$password);
		$msg = 'Your password has been reset successfully.';
//	}
//	else
//	{
//		$err=2;
//		$msg="Invalid detail";
//	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Reset Password</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-1.4.2.js" ></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>

	<script language="JavaScript">
		function chk()
		{
			if (document.frm.password.value == "" ) 
			{	
				
				alert("Please enter password") ;
				document.frm.password.focus();
				return false ;
			}
			if (document.frm.password.value != document.frm.confirm_password.value ) 
			{					
				alert("Password and confirm password does not match") ;
				document.frm.password.focus();
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
                  <div class="logname">RESET PASSWORD</div>
				  <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;"><?php echo $msg;?></div>
					<form name="frm" method="post" action="" onSubmit="return chk();">
					<input type="hidden" name="submittype" value="false">
					<input type="hidden" name="recover_pass" value="<?php echo $_REQUEST['recover_pass']; ?>">
                    <div class="log">
                    <ul>
                        <li><span>Password</span><input type="Password" name="password" maxlength="20" class="textfield_name"  /> </li>
                    </ul>
                    <ul>
                        <li><span>Confirm Password</span><input type="Password" name="confirm_password" id="confirm_password" maxlength="20" class="textfield_name"  /></li>
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
