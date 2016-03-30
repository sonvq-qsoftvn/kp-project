<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$objClient = new admin;

/*--------SET THE  TIMING  &  SCHEDULING--------------*/
	
if(isset($_REQUEST['submit'])) /*save for media image*/
  {
	
		$business_name=$_POST['business_name'];
		$cont_f_name=$_POST['cont_f_name'];
		$cont_l_name=$_POST['cont_l_name'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$zip=$_POST['zip'];
        $email=$_POST['email'];
        

                
        $objectClientPdo = new pdoDatabase();
        $result = $objectClientPdo->insertAdsClient($business_name); 
        if ($result) {		
            header("location:".$obj_base_path->base_path()."/admin/list-client");
            $msg="Client Successfully Added.";
            $_SESSION['msg']=$msg;
            exit();
        } else {
            header("location:".$obj_base_path->base_path()."/admin/add-client");
            $msg="An error occurs, please try again later!";
            $_SESSION['msg']=$msg;
            exit();
        }
       
  } //if isset end..
	 
/*--------SET THE  TIMING  &  SCHEDULING--------------*/
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Client Management</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->


</head>

<body class="body1">
<?php include("admin_header.php"); ?>
  <div id="maindiv">
    <div class="clear"></div>
    <div class="body_bg">
    <div class="clear"></div>
    <div class="container">
    <?php include("admin_header_menu.php");?>
     <div class="clear"></div>		
    <!--start body-->
      <div id="body">
        <div class="body2"> 
          <div class="clear"></div>
           <div class="blue_box1">
                <div class="blue_box1">
                    <div class="blue_box10"><p>Client Management</p></div>
                    <?php include("admin_menu/client_menu.php");?>
                </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
                
	<div style="color:green; margin-top:10px; font-size: 18px; margin-left: 12px;">
        <strong><span id="savemsg"><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></span></strong></div>
		
		
    <div class="myevent_box"> 
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
                <div class="guide_box2">
                   <!-- <form action="" method="post" onsubmit="return validation();">-->
		   
		    <!--1st All Select  Form start-->
		  
                    <div>

                                            </tr>
                                            <tr>
                                                <td width="16%" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; padding-left: 10px;">Contact Lirst Name ::</td>
                                                <td width="84%">
                                                    <input type="text" name="cont_l_name" id="cont_l_name" />
                                                </td>
                                            </tr>
                                            <tr>

                                                <td width="16%" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; padding-left: 10px;">Cell ::</td>
                                                <td width="84%">
                                                    <input type="text" name="cell" id="cell" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp<input type="submit" name="submit" value="Add Client" class="createbtn" style="cursor:pointer;"/></td>	
                                                <td></td>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>			
                      <tr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="16%" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; padding-left: 10px;">Cell ::</td>
                                                <td width="84%">
                                                    <input type="text" name="cell" id="cell" />
                                                </td>
                                            </tr>
                                            <tr>
                            </fieldset>
                        </form>
                    </div>
		<!---------2nd form END---------------->
		<div class="clear"></div>
                </div>
	      
            </div>
        </div>
    <div class="clear"></div>
    </div>
    
    
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>


</body>
</html>