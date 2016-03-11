<?php
// home page
session_start();

// List of page
// -------- include file -------------
include('../include/admin_inc.php');

//creation of objects
$obj_category = new merchant_admin;
$obj_add = new merchant_admin;
$obj_country = new merchant_admin;
$obj_gt_dtls = new merchant_admin;
$obj_state = new merchant_admin;
$obj_county = new merchant_admin;


//===============CODE FOR INSERT===================//
if(isset($_POST['addcat']) && $_POST['addcat'] == '1')	
{
	//print_r($_POST);exit;
	$county_id = $_POST['county_id'];
	$city_name = addslashes($_POST['city_name']);
	$city_name_sp = addslashes($_POST['city_name_sp']);
	$obj_add->addCity($county_id,$city_name,$city_name_sp);
	$_SESSION['msg'] = "City added successfully.";
	header("Location:".$obj_base_path->base_path()."/admin/add_city");
	exit;
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - City</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>



<script type="text/javascript">

function del(cid)
{
	if(confirm("Are you sure you want to delete this category?"))
	{
		location.href="list_category.php?action=delete&catid="+cid;
	}
	
}

function getState(country_id)
{
     $('#div_state_display').html('<select name="state" class="selectbg20"><option value="">State</option></select>');
     $('#div_county_display').html('<select name="county_id" class="selectbg20"><option value="">County</option></select>');
	 data = "country_id="+country_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_get_state.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_state_display").html(data);
	   }
	 });
}

function getCounty(stateid)
{
	 data = "state_id="+stateid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_get_county.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function validation()
{
	$('#state_err').html("");
	$('#county_err').html("");
	$('#country_err').html("");
	
	if($('#country').val()=="")
	{
		$('#country_err').html("Please select Country.")
		return false;
	}
	if($('#state').val()=="")
	{
		$('#state_err').html("Please select state.")
		return false;
	}
	if($('#county_id').val()=="")
	{
		$('#county_err').html("Please select County.")
		return false;
	}
	return true;
}

</script>

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
           <div class="blue_box10"><p>City</p></div>
           <?php
				$path_parts = pathinfo(__FILE__);
			?>
				<div class="blue_boxr">
				  <ul>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_city" class="here">Create/Edit City</a></li>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_city">List City</a></li>
			
				 </ul>
			   </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
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
                        <th colspan="2">Country<br/>
                            <span class="event_fieldbg20"><select name="country" id="country" class="selectbg20" onchange="getState(this.value)">
                            <option value="">Select</option>
                            <?php 
                            $obj_country->countries_list();
                            while($obj_country->next_record()){
                            ?>
                            <option value="<?php echo $obj_country->f('id'); ?>"><?php echo stripslashes($obj_country->f('nicename')); ?></option>
                            <?php } ?>
                              </select></span>
                               <div class="cls_err" id="country_err"></div>
                        </th>
                      </tr>
                     <tr>
                        <th colspan="2">State<br/>
                            <span class="event_fieldbg20" id="div_state_display"><select name="state" id="state" class="selectbg20" onchange="getCounty(this.value)">
                            <option value="">Select</option>
                           
                            </select></span>
                            <div class="cls_err" id="state_err"></div>
                        </th>
                      </tr>
                     <tr>
                        <th colspan="2">County<br/>
                            <span class="event_fieldbg20" id="div_county_display"><select name="county_id" id="county_id" class="selectbg20">
                            <option value="">Select</option>
                            
                             </select></span>
                             <div class="cls_err" id="county_err"></div>
                        </th>
                      </tr>
                      <tr>
						<th width="16%">
                        	<span class="state_en">EN</span><br/>
                        	<span class="event_fieldbg20"><input type="text" name="city_name" id="city_name" placeholder="City Name" class="event_field" style="height: 25px; margin: 5px 0; width: 290px;"/></span>
                       </th>
                      </tr>
                      <tr>                                                      
                        <th>
                        <span class="state_sp">SP</span><br/>
                        <span class="event_fieldbg20"><input type="text" name="city_name_sp" id="city_name_sp" placeholder="City Name" class="event_field" style="height: 25px; margin: 5px 0; width: 290px;"/></span>
                      	</th>
                      </tr>
                      
                      <tr>                                                        
                        <th colspan="2"><input type="hidden" name="addcat" value="1" /><input type="submit" name="submit" id="submit" value="Add" class="createbtn"/></th>
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

<script type="text/javascript">
<!--
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
