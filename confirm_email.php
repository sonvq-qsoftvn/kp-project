<?php
include('include/user_inc.php');

$page_id=$_REQUEST['page_id'];
$objintro=new user;
$obj_del_altemail = new user;
$objintro->intro_page($page_id);
$objintro->num_rows();

if($objintro->num_rows() > 0)
$objintro->next_record();
//$_SESSION['count_try_mail'] = 0;


if($_SESSION['langSessId']=="spn"){
	$CONFIRM ="confirmar";
	$CHANGED = "cambio de";
}
else{
	$CONFIRM = "confirm";
	$CHANGED = "change";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirm Email</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />

<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
</head>
<script>
function check_valid(){
var pass = $('#password').val();
if(pass == ''){
$('#sh_password').html('Please Enter your Password');
return false;
}
else
{
return true;
}
}
</script>
<body>
<?php

/*unset($_SESSION['count_try_mail']);
unset($_SESSION['login_msg2']);
unset($_SESSION['login_msg']);*/
//$_SESSION['login_msg2'] = '2';
//echo $_SESSION['count_try_mail'];
//echo '<br>'.$_SESSION['login_msg2'];
if(isset($_POST['hid_sign']) )
{
	//print_r($_POST);exit;
	$loginid = $_SESSION['admin_email'];
	$pass = $_POST["password"];
	$faq = new User;

	$faq->login($loginid,$pass);

	if($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['admin_email'] = $faq->f('email');
		$_SESSION['name'] = $faq->f('fname')." ". $faq->f('lname');
		$_SESSION['ses_admin_id'] = $faq->f('admin_id');
		$_SESSION['login_mode'] = 'site';

		//redirect
		//header("Location:".$obj_base_path->base_path()."/index");
		$conf_type = base64_decode($_GET['id']);
		if($conf_type == 'confirm1'){
		$obj_del_altemail->conf_alt_email($_SESSION['ses_admin_id']);
		}
		else{
		$obj_del_altemail->getalternateEmailc($_SESSION['ses_admin_id']);
		$obj_del_altemail->num_rows();
		$obj_del_altemail->next_record();					
		$obj_del_altemail->makePrimary($obj_del_altemail->f('email_address'),$_SESSION['admin_email'],$_SESSION['ses_admin_id']);
		$_SESSION['admin_email'] = $obj_del_altemail->f('email_address');
		}
		$_SESSION['login_msg'] = '';
		$_SESSION['login_msg2'] = "1";
		header("Location:".$obj_base_path->base_path()."/userprofile");
		exit;
		//unset($_SESSION['login_msg']);
	}
	else
	{	
		if($_SESSION['count_try_mail']){
			$_SESSION['count_try_mail'] = $_SESSION['count_try_mail'] + 1;
		}
		else{
			$_SESSION['count_try_mail'] = 1;
		}
		if($_SESSION['count_try_mail'] == '3'){
			if(base64_decode($_GET['id']) == 'confirm1')
			{
				$obj_del_altemail->deleteAltEmail2($_SESSION['ses_admin_id']);
			}
			$_SESSION['login_msg2'] = "2";
			$_SESSION['count_try_mail'] = "0";
				
		}
		else{
			if($_SESSION['langSessId']=='eng')
			$_SESSION['login_msg'] = "Invalid login. Please try again.";
			else
			$_SESSION['login_msg'] = "login inválido. Por favor, inténtelo de nuevo.";
		}
		header("Location:".$obj_base_path->base_path()."/confirm_email?id=".$_GET['id']."&mode=".$_REQUEST['mode']);
		
	}
}
?>
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" >
            	<div class="cheese_box">
				<div class="blue_box1">
                   <div class="blue_boxh"><a href="<?php echo $obj_base_path->base_path(); ?>" style="text-decoration:none;"><p><?php
				   if($_SESSION['langSessId']=="spn")
				    echo 'Confirmar correo electrónico';
					else
					echo 'Confirm Email';?></p></a></div>
                   
			    </div>
                <div class="clear"></div>
                <div class="Tchai_box" style="width: auto; text-align:center;">
                   <div class="pass_box">
                        <?php
    					//echo base64_decode($_GET['id'])."ss";exit;
                        if(base64_decode($_GET['id']) == 'confirm1'){
                        
                            $obj_del_altemail->getalternateEmailc($_SESSION['ses_admin_id']);
                            $obj_del_altemail->num_rows();
                            
                            if($obj_del_altemail->num_rows() > 0)
                            {
                                echo 'Your email address has been confirmed.';
                                unset($_SESSION['login_msg2']);
                                ?>
                                    <script>
                                    var myVar=setInterval(function(){myTimer()},3000);
                                    
                                    function myTimer()
                                    {
                                    window.location = "/userprofile"
                                    }
                                    </script>
                                <?php
                            }
                            else
                            {
                        
                                if($_SESSION['login_msg2'] == '1')
                                {
                                    echo 'Your email address has been confirmed.';
                                    unset($_SESSION['login_msg2']); // = '';
                                ?>
                                    <script>
                                    var myVar=setInterval(function(){myTimer()},3000);
                                    
                                    function myTimer()
                                    {
                                    window.location = "/userprofile"
                                    }
                                    </script>
                                <?php
                                }
                                elseif($_SESSION['login_msg2'] == '2')
                                {
                                    echo 'Your alternate email address has been rejected.';
                                    unset($_SESSION['login_msg2']);
                                    ?>
                                                <script>
                                        var myVar=setInterval(function(){myTimer()},3000);
                                        
                                        function myTimer()
                                        {
                                        window.location = "/userprofile"
                                        }
                                        </script>
                                <?php
                                }
                                else
                                {
                                    $obj_del_altemail->getalternateEmail($_SESSION['ses_admin_id']);
                                    $obj_del_altemail->num_rows();
                                    
                                    if($obj_del_altemail->num_rows() > 0)
                                    {
                                            
                                    ?>
                                      <form action="" method="post" id="conf_mail" onsubmit="return check_valid();">
                                        <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                                        <table class="pass_box_tbl">
                                        <tr>
                                        <td>
                                        <span style="color:#c88039; font-size:16px; font-weight: bold;">Enter Password</span>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        Please enter your password to <?php if($_REQUEST['mode']==2){ echo $CONFIRM; } else { echo $CHANGED;} ?> your email address
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <input type="password" name="password" id="password" style="padding: 4px;width: 200px;"/>
                                        <div id="sh_password" style="color:red; margin-left:6px;"><?php echo $_SESSION['login_msg']; ?></div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <input type="submit" name="submit11" id="submit11" value="" class="event_signin" style="cursor:pointer; margin-left:0px;">
                                        </td>
                                        </tr>
                                        </table>
                                     </form>
                                    <?php
                                    }
                                }
                        
                            }
                        }
                        else
                        {
							//echo $_SESSION['login_msg2']."sss";exit;
                            if($_SESSION['login_msg2'] == '1'){
                            echo 'Your primary email address has been changed.';
                            unset($_SESSION['login_msg2']); // = '';
                            ?>
                                        <script>
                                        var myVar=setInterval(function(){myTimer()},3000);
                                        
                                        function myTimer()
                                        {
                                        window.location = "/userprofile"
                                        }
                                        </script>
                            <?php
                            }
                            elseif($_SESSION['login_msg2'] == '2'){
                            //
                            echo 'Your request has been rejected.';
                            //die($_SESSION['login_msg2']);
                            unset($_SESSION['login_msg2']);
                            ?>
                                        <script>
                                        var myVar=setInterval(function(){myTimer()},3000);
                                        
                                        function myTimer()
                                        {
                                        window.location = "/userprofile"
                                        }
                                        </script>
                            <?php
                            }else{
                        ?>
                        <form action="" method="post" id="conf_mail" onsubmit="return check_valid();">
                        <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                        <table class="pass_box_tbl">
                        <tr>
                        <td>
                        <span style="color:#c88039; font-size:16px; font-weight: bold;">Enter Password</span>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <?php
							if($_SESSION['langSessId']=="spn")
								echo 'Por favor, teclas su contraseña para confirmar su cambio de dirección de correo electrónico.';
							else
								echo 'Please enter your password to confirm your change of primary email address.';
						 
						?>
                        	
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <input type="password" name="password" id="password" style="padding: 4px;width: 200px;"/>
                        <div id="sh_password" style="color:red; margin-left:6px;"><?php echo $_SESSION['login_msg']; ?></div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <input type="submit" name="submit11" id="submit11" value="" class="event_signin" style="cursor:pointer; margin-left:0px;">
                        </td>
                        </tr>
                        </table>
                        </form>
                        <?php
                        }
                        }
                        ?>
                        </div>
                </div>
                </div>
               <div class="clear"></div>
                    
                </div>
            <?php include("include/frontend_rightsidebar.php");?>
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
