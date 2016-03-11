<?php 
// index page
include("../class/db_mysql.inc");
include("../class/admin_class.php");
include("../class/user_class.php");
include("../class/pagination.php");
include("../class/class.phpmailer.php");

$obj_base_path = new DB_Sql;
$obj_cat=new admin;
$obj_add_newsletter=new user;
session_start();

if($_SESSION['ses_user_id']=="") {

if( isset($_POST['username']) )
{
	$loginid=$_POST["username"];
	$pass=$_POST["password"];
	$faq = new admin;
	// -- CHECK ADMIN USERNAME AND PASSWORD --
	$Rcount=$faq->check_admin_user($loginid,$pass) ;
	
	if ($Rcount > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['usernm'] = $loginid;
		$_SESSION['ses_user_id'] = $faq->f('admin_id');
		$_SESSION['ses_organization_id'] = $faq->f('organization_id');
		$_SESSION['ses_admin_seller_type'] = $faq->f('seller_type');
		//if($faq->f('seller_type')==2)
		//redirect
		//header("Location:".$obj_base_path->base_path()."/admin/scan");
		//else
		//echo "<br />".$obj_base_path->base_path()."/admin/dashboard/";		//exit;
		
		//redirect
		//header("Location:".$obj_base_path->base_path()."/admin/dashboard");
		header("Location:".$obj_base_path->base_path()."/admin/event-list");
		//echo 1;
	}
	else
	{
		//header("Location:".$obj_base_path->base_path()."/admin/index/msg/Invalid Login information");
		$msg = "Invalid login credentials. Please try again!";
	}
}

if(isset($_POST['Submit2'])){
$email = $_POST['email'];
if($email!="" || $email != "Enter your email address"){
if($obj_add_newsletter->add_contact($email))
{
$msg = "Thank you for join us.";
}else{
$msg = "An error occured. Try again letter.";
}
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Login</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
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
	if(alltrim(document.frm.username.value) == "" ) 
	{	
		
		alert("Please enter user name") ;
		document.frm.username.focus();
		return false ;
	}
	if(alltrim(document.frm.password.value) == "" ) 
	{
		alert("Please enter password") ;
		document.frm.password.focus();
		return false ;
	}
	return false ;
//document.frm.submittype.value=true;
}
</script>

</head>

<body>
<?php include("admin_header.php"); ?>
<div id="maindiv">
	<div class="body_bg">
    	<div class="container">
<!---------------------put your div--here-------------------------------------------------- --> 
            <div class="box1">
                  <div class="logname">ADMINISTRATOR LOGIN</div>
				  <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000"><?php echo $msg;?></div>
                  <form name="frm" method="post" action="index.php" onSubmit="return chk();">
                  <input type="hidden" name="submittype" value="false">
                    <div class="log">
                    <ul>
                        <li><span>Username</span><input type="text" name="username" id="username" class="textfield_name"  /> </li>
                    </ul>
                    <ul>
                        <li><span>Password</span> <input type="Password" name="password" id="password" maxlength="20" class="textfield_name"/></li>
                    </ul>
                    <ul>
                        <li><input name="submit1" type="submit" value="LOGIN" class="login_btn" /> <a href="<?php echo $obj_base_path->base_path(); ?>/admin/forget">Forgot Your Password?</a></li>
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
<?php } else { ?>
<?php header("Location:".$obj_base_path->base_path()."/admin/events"); ?>
<?php } ?>