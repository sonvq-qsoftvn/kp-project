<?php
//payment success page
include('include/user_inc.php');

//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();


   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up</title>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />


</head>
<body>

<!--header-->
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<!--header-->

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
                  <div class="blue_box1" style="width: 976px;"><div class="blue_boxh"><p>Success</p></div></div>
                  <div class="clear"></div>
                          <div class="clear"></div>
                            <form action="" method="post" enctype="multipart/form-data">
                              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="padding: 24px 0;">
                                
                                <tr>
                                  <td>
                                  <div style="text-align:center; color:#06F; font-size:18px;font-weight:bold;margin-top:100px; margin-bottom:100px;">
                                  Thank you for submitting payment.</div></td>
                                </tr>
                               
                                <tr>
                                  <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
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


<script>
setInterval('location.href="<?php echo $obj_base_path->base_path(); ?>"', 4000);
</script>
<!--footer-->
<?php include("include/frontend_footer.php");?>
<!--footer-->


</body>
</html>





