<?php
include('include/user_inc.php');
$obj=new user;
$obj_sendmail=new user;
//echo $_SESSION['langSessId'];


if($_SESSION['ses_admin_id']!="")
	header("Location:".$obj_base_path->base_path()."/index");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thank You</title>
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
            	<div class="cheese_box">
                  <div class="blue_box1" style="width: 976px;"><div class="blue_boxh"><p>Sign Up</p></div></div>
                  <div class="clear"></div>
                    <div style="width: 976px; float: none; margin: 0 auto;">
						<div class="Tchai_box1" style="margin: 10px auto; float: left;">
                          <div class="clear"></div>
                            <table width="100%" align="center" border="1" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                              <tr>
                                <td colspan="2">
                                    <div style="width:745px; float: left; margin: 0 auto 0 23px;">
                                        <?php echo $_SESSION['user_msg']; $_SESSION['user_msg'] = '';?>
                                    </div>
                                </td>
                              </tr>
                            </table>
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


</body>
</html>
