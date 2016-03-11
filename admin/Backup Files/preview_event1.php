<?php
// home page
session_start();
include('../include/admin_inc.php');

//create object
$obj = new admin;
$objlist=new admin;
$obj_subcat=new admin;
$obj_venuestate=new admin;
$obj_venuecounty = new admin;
$obj_venuecity=new admin;
$obj_venue=new admin;
$obj_edit=new admin;
$obj_add_ticket=new admin;
$obj_edit_ticket=new admin;
$obj_delete=new admin;
$obj_add_category_by_event=new admin;
$obj_delete_category_by_event=new admin;
$objlist_most_used=new admin();
$obj_subcat_most_used=new admin();
$objlistMaincat=new admin;
$obj_thumb = new admin;


$objlist->category_list();
$objlistMaincat->categorylistByEvent($_GET['event_id']);
$objlist_most_used->most_used_category();


$obj->getEventById($_GET['event_id']);
$obj->next_record();

$explode_start_date_time_all = explode(" ",$obj->f('event_start_date_time'));
$explode_start_date = explode("-",$explode_start_date_time_all[0]);
$explode_start_time = explode(":",$explode_start_date_time_all[1]);
$start_yr = $explode_start_date[0];
$start_mon = $explode_start_date[1];
$start_day = $explode_start_date[2];
$start_hr = $explode_start_time[0];
$start_min = $explode_start_time[1];



$explode_end_date_time_all = explode(" ",$obj->f('event_end_date_time'));
$explode_end_date = explode("-",$explode_end_date_time_all[0]);
$explode_end_time = explode(":",$explode_end_date_time_all[1]);
$end_yr = $explode_end_date[0];
$end_mon = $explode_end_date[1];
$end_day = $explode_end_date[2];
$end_hr = $explode_end_time[0];
$end_min = $explode_end_time[1];


$arrMaincat = array();
if($objlistMaincat->num_rows())
{
   while($objlistMaincat->next_record())
   {
	   $arrMaincat[] = $objlistMaincat->f('category_id');
   }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Preview Event</title>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!--jquery alert-->
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.alerts.js" type="text/javascript"></script>
<!--jquery alert-->

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js" ></script>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels1.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
$(document).ready(function(){
$('#image_popup').fancybox();
})
</script>


</head>
<body class="body1"><?php include("admin_header.php");?>
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
			   <div class="blue_boxh"><p>Preview Event</p></div>
			   <div class="blue_boxr">
			   	<ul>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events">Create</a></li>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list">List/edit</a></li>
                   <li><a href="#">Promote</a></li>	
                   <li><a href="#">View bookings</a></li>
                   <li><a href="#">Reports</a></li>						   
			   	</ul>
			   </div>
			   </div> 
			 <div class="clear"></div>
            </div>	
		   </div>
		 </div>
		<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000"><strong><?php echo $msg;?></strong></div>
		<form method="post" name="event_form" id="event_form" enctype="multipart/form-data" action="">
            <input type="hidden" name="editevent" id="editevent" value="1" />
            <input type="hidden" name="event_id" id="event_id" value="<?php echo $obj->f('event_id')?>" />
            <input type="hidden" name="hid_photo" id="hid_photo" value="<?php echo $obj->f('event_photo')?>" />
			<div class="myevent_box">
            <div class="myevent_left">
       		 <div class="event_name">
                <div style="float: left; margin: 0 auto;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe.jpg" alt="" width="56" height="58" border="0"/></div>
                <div style="float: right; margin: 0 auto;">
                    <span class="event_fieldbg"><span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding: 4px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">SP</span><input type="text" readonly="readonly" name="event_name_sp" style="width: 550px; margin:10px 0;" class="event_field" value="<?php echo stripslashes($obj->f('event_name_sp'));?>" /></span><br/>
                    <span class="event_fieldbg"><span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding: 4px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">EN</span><input type="text" readonly="readonly" name="event_name_en" class="event_field" value="<?php echo stripslashes($obj->f('event_name_en'));?>" style="width: 546px; margin:10px 0;" /></span>
                  </div>
                </div>
        	<div class="clear"></div>
        	<div class="event_date">
         	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	<tr>
                  <td><h1 style="padding: 35px 0 0 10px;">Date</h1></td>
                  <td><h1 style="padding: 35px 0 0 10px;">Starts</h1></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
                        <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
                        <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>YY</strong></td>
                    </tr>
                    <tr>
                      <td><input type="text" readonly="readonly" name="event_day_st" id="event_date_st"  class="textbg_grey" value="<?php echo $start_day;?>" style="width: 30px;"/></td>
                      <td>/</td>
                      <td><input type="text" readonly="readonly" name="event_month_st" id="event_month_st" class="textbg_grey" value="<?php echo $start_mon;?>" style="width: 30px;"/></td>
                      <td>/</td>
                      <td><input type="text" readonly="readonly" name="event_year_st" id="event_year_st"  class="textbg_grey" value="<?php echo $start_yr;?>" style="width: 40px;"/></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td style="padding: 9px 0;"><select disabled name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onchange="changeTime(this.value);">
                        <?php 
                              for($i=0; $i<13; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>" <?PHP if($i==$start_hr) {echo 'selected="selected"';}?>><?php echo $i;?></option>
                        <?php }?>
                      </select></td>
                      <td style="padding: 9px 0;">&nbsp;</td>
                      <td style="padding: 9px 0;"><select disabled name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;">
                              <?php 
                              for($j=00; $j<60; $j++) {
                              ?>
                              <option value="<?php echo $j; ?>" <?PHP if($j==$start_min) {echo 'selected="selected"';}?>><?php echo $j;?></option>
                              <?php }?>
                                  
                            </select></td>
                      <td style="padding: 9px 0;">&nbsp;</td>
                      <td style="padding: 9px 0;"><select disabled name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                                  <option value="AM" <?php if($obj->f('event_start_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
                                  <option value="PM" <?php if($obj->f('event_start_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
                            </select></td>
                      <td style="padding: 9px 0;"></td>
                    </tr>
                  </table></td>
                  <td><h1 style="padding: 35px 0 0 10px;">Ends</h1></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 20px 0 0 0;">
                    <tr>
                      <td><input type="text" readonly="readonly" name="event_day_end" id="event_date_end" value="<?php echo $end_day;?>" class="textbg_grey" style="width: 30px;"/></td>
                      <td>/</td>
                      <td><input type="text" readonly="readonly" name="event_month_end" id="event_month_end" value="<?php echo $end_mon;?>" class="textbg_grey" style="width: 30px;"/></td>
                      <td>/</td>
                      <td><input type="text" readonly="readonly" name="event_year_end" id="event_year_end" value="<?php echo $end_yr;?>" class="textbg_grey" style="width: 40px;"/></td>
                    </tr>
                    <tr>
                      <td style="padding: 9px 0;"><select disabled name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                              <?php 
                              for($i=0; $i<13; $i++) {
                              ?>
                              <option value="<?php echo $i; ?>" <?PHP if($i==$end_hr) {echo 'selected="selected"';}?>><?php echo $i;?></option>
                              <?php }?>
                            </select></td>
                      <td style="padding: 9px 0;">/</td>
                     <td style="padding: 9px 0;"><select disabled name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                              <?php 
                              for($j=0; $j<60; $j++) {
                              ?>
                              <option value="<?php echo $j; ?>" <?PHP if($j==$end_min) {echo 'selected="selected"';}?>><?php echo $j;?></option>
                              <?php }?>
                            </select></td>
                      <td style="padding: 9px 0;">/</td>
                     <td style="padding: 9px 0;"><select disabled name="event_end_ampm" class="selectbg" id="event_end_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                                  <option value="AM" <?php if($obj->f('event_end_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
                                  <option value="PM" <?php if($obj->f('event_end_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
                            </select></td>
                </tr>
              </table></td>
            </tr>
          	 </table>
        	</div>
        	<div class="clear"></div>
        <div class="event_date">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%"><h1>Venue</h1></td>
              <td width="20%">
              <select disabled name="venue_state" id="venue_state" class="selectbg1" onchange="getCounty(this.value);">
                  <option value="">State</option>
                  <?php
                  $obj_venuestate->getVenueState($obj->f('event_venue_state'));
                  while($row = $obj_venuestate->next_record())
                  {
                  ?>
                  <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('event_venue_state') == $obj_venuestate->f('id')) { echo 'selected'; }?>><?php echo $obj_venuestate->f('state_name');?></option>
                  <?php
                  }
                  ?>
              </select></td>
              <td width="20%"><div id="div_county_display">
              <select disabled name="venue_county" class="selectbg1" style="width:140px;" onchange="getCity(this.value);">
              <option value="">County</option>
              <?php
              $obj_venuecounty->getVenueCounty($obj->f('event_venue_state'));
              while($row = $obj_venuecounty->next_record())
              {
              ?>
              <option value="<?php echo $obj_venuecounty->f('id');?>" <?php if($obj->f('event_venue_county') == $obj_venuecounty->f('id')) { echo 'selected'; }?>><?php echo $obj_venuecounty->f('county_name');?></option>
              <?php
              }
              ?>
              </select></div></td>
              <td width="20%"><div id="div_city_display">
              <select disabled name="venue_city" class="selectbg1" style="width:140px;" onchange="getVenue(this.value);">
              <option value="">City</option>
              <?php
              $obj_venuecity->getVenueCity($obj->f('event_venue_county'));
              while($row = $obj_venuecity->next_record())
              {
              ?>
              <option value="<?php echo $obj_venuecity->f('id');?>" <?php if($obj->f('event_venue_city') == $obj_venuecity->f('id')) { echo 'selected'; }?>><?php echo $obj_venuecity->f('city_name');?></option>
              <?php
              }
              ?>
              </select></div></td>
              <td width="20%"><div id="div_venue_display">
              <select disabled name="venue" class="selectbg1" style="width:140px;">
              <option value="">Venue</option>
              <?php
              $obj_venue->getVenueName($obj->f('event_venue_city'));
              while($row = $obj_venue->next_record())
              {
              ?>
              <option value="<?php echo $obj_venue->f('venue_id');?>" <?php if($obj->f('event_venue') == $obj_venue->f('venue_id')) { echo 'selected'; }?>><?php echo $obj_venue->f('venue_name');?></option>
              <?php
              }
              ?>
              </select></div></td>
            </tr>
          </table>
        </div>	
        <div class="clear"></div>
       
        <div class="event_date">
          <div id="TabbedPanels2" class="TabbedPanels2">
        	 <ul class="TabbedPanelsTabGroup2">
                <li class="TabbedPanelsTab2" tabindex="1">English</li>  
                <li class="TabbedPanelsTab2" tabindex="0">Espanol</li> 
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0" style="float: right; margin: 0 10px 0 0;"/>	 
             </ul>
        	 <div class="TabbedPanelsContentGroup2">
        		<div class="TabbedPanelsContent2">
                    <textarea name="page_content_en" cols="35" rows="10"><?php echo stripslashes($obj->f('event_details_en'));?></textarea>
                </div>
        		<div class="TabbedPanelsContent2">
                	<textarea name="page_content_sp" cols="35" rows="10"><?php echo stripslashes($obj->f('event_details_sp'));?></textarea>
					 <?php
                      $ckeditor2 = new CKEditor2();
                      $ckeditor2->basePath = '../../ckeditor/';
                      $ckfinder2 = new CKFinder();
                      $ckfinder2->BasePath = '../../ckfinder/'; // Note: BasePath property in CKFinder class starts with capital letter
                      $ckfinder2->SetupCKEditorObject($ckeditor2);
                      $ckeditor2->replaceAll();
                     ?>
                </div> 
        	</div>
          </div>
        </div>	
        <div class="clear"></div>
        
        <div class="event_date">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="35%"><h1>Photo</h1></td>
              <td width="65%"><?php if($obj->f('event_photo')!='') { ?>
              	<a href="#showimg" id="image_popup"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $obj->f('event_photo')?>" height="100" width="90" /></a><br /><span style="color:red; font-weight:normal;">Click on Image to show full Image</span>
				<?php } else { ?><font color="#FF0000">No photo uploaded</font><?php } ?></td>
            </tr>
          </table>
          <div style="display:none;">
          	<div id="showimg" style="width:800px; height:600px; border:2px solid #666;">
            	<?php if($obj->f('event_photo')!='') { ?><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $obj->f('event_photo')?>" border="0" /><?php } ?>
            </div>
          </div>
        </div>
        <div class="clear"></div>
        
    </div>
            <div class="myevent_right">
       
        <div class="inevent_right">
        	<ul>
            <li><h1>Event Tags</h1></li>
            <li style="padding: 4px 0 4px 14px;"><input name="event_tag" id="event_tag" type="text" class="textfield_add" value="<?php echo stripslashes($obj->f('event_tag'));?>" />
        	</ul>
        </div>
        <div class="clear"></div>
        <div style="width: 280px; float: none; margin: 0 auto;">
        <div class="inevent_right">
        <ul>
        <li><h1>Event Categories</h1></li>	
        </ul>
        </div>
        <div class="clear"></div>
       	 <div id="TabbedPanels1" class="TabbedPanels">
            <ul class="TabbedPanelsTabGroup">
                <li class="TabbedPanelsTab" tabindex="0">All Event Categories</li> 
            </ul>
    		<div class="TabbedPanelsContentGroup">
        	  <div class="TabbedPanelsContent">
                <ul>
                <?php
                if($objlist->num_rows()){
                    while($objlist->next_record()){
                ?>
                <li style="color:#000;"><input disabled="disabled" type="checkbox" name="maincat[]" id="maincat" value="<?php echo $objlist->f('category_id');?>" <?php if(in_array($objlist->f('category_id'),$arrMaincat)) { echo 'checked'; }?> /><?php echo $objlist->f('category_name');?>
                
                    <?php
                        $obj_subcat->category_sub_list($objlist->f('category_id'));
                        if($obj_subcat->num_rows()){
                            while($obj_subcat->next_record()){
                     ?>
                    <ul>
                        <li style="margin: 0 0 0 10px; color:#000;"><input disabled="disabled" type="checkbox" id="subcat" name="subcat[]" value="<?php echo $obj_subcat->f('category_id');?>" <?php if(in_array($obj_subcat->f('category_id'),$arrMaincat)) { echo 'checked'; }?> /><?php echo $obj_subcat->f('category_name');?></li>
                    </ul>
                    <?php
                            }
                        }
                    ?>
                </li>
                <?php
                    }
                }
                ?>
                </ul>
              </div>
            </div>
         </div>
        </div>
        </div>
            <div class="clear"></div>
		</div>
		</form>
		
        <div class="clear"></div>
			
<!------------------------------------------------------------------------- -->      	
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
 </div>
 <!------------------------end maindiv----------------------------------------------- -->
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
<script type="text/javascript">
<!--
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
//-->
</script>
<div class="clear"></div>
    <?php include("admin_footer.php");?>

</body>
</html>
