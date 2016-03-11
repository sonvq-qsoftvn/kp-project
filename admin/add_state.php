<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$obj_category = new merchant_admin;
$obj_add = new merchant_admin;
$obj_edit_state = new merchant_admin;



//===============CODE FOR INSERT===================//
if(isset($_POST['addcat']) && $_POST['addcat'] == '1')	
{
	$country_id = $_POST['country_id'];
	$state_name_sp = addslashes($_POST['state_name_sp']);
	$state_name = addslashes($_POST['state_name']);

	$obj_add->addState($country_id,$state_name_sp,$state_name,$id);
	header("Location:".$obj_base_path->base_path()."/admin/list_state");
	$msg = "State add successfully";
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Add State</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>




<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
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
           <div class="blue_box10"><p>State</p></div>
           <?php
				$path_parts = pathinfo(__FILE__);
			?>
				<div class="blue_boxr">
				  <ul>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_page" class="here">Create/Edit State</a></li>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_state">List State</a></li>
			
				 </ul>
			   </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#090;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#090;">
        <strong><?php echo $msg;?>		
		</strong></div>	
	<?php
	}?>	
	   
    <div class="myevent_box"> 
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
                <div class="guide_box2">
                    <form action="" method="post" onsubmit="return validation();">
                    <fieldset>
                    <!--[if !IE]>start table_wrapper<![endif]-->
                    <div class="table_wrapper">
                      <div class="table_wrapper_inner">														
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sptable">
                         <tr>
                          <td colspan="2"><font color="#FF0000"><?php //echo $msg;?></font></td>
                         </tr>
                         <tr>
                            <th colspan="2">Countries<br/>
                            <span class="event_fieldbg20"><select name="country_id" id="country_id" class="selectbg20">
                            <option value="">Select</option>
                            <?php 
                            $obj_category->countries_list();
                            while($obj_category->next_record()){
                            ?>
                            <option value="<?php echo $obj_category->f('id'); ?>"><?php echo stripslashes($obj_category->f('nicename')); ?></option>
                            <?php } ?>
                              </select></span>
                            </th>
                          </tr>
                          <tr>
            				<th width="16%">
                            	<span class="state_sp">SP</span><br/>
                                <span class="event_fieldbg20"><input type="text" placeholder="State Name" name="state_name_sp" id="state_name_sp"  class="event_field" style="height: 25px; margin: 5px 0; width: 290px;"/></span>
                            </th>
                          </tr>
                          <tr>                                                      
                            <th>
                            <span class="state_en">EN</span><br/>
                            <span class="event_fieldbg20"><input type="text" placeholder="State Name" name="state_name" id="state_name" class="event_field"  style="height: 25px; margin: 5px 0; width: 290px;"/></span></th>
                          </tr>
                          
                          <tr>                                                        
                            <th colspan="2"><input type="hidden" name="addcat" value="1" /><input type="submit" name="submit" id="submit" value="Add" class="createbtn" style="cursor:pointer;"/></th>
                          </tr>
                        </table>
                      </div>
                    </div>											
                    </fieldset>
                    </form>
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
