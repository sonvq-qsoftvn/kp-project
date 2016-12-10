<?php
include('../include/admin_inc.php');

//create object
$objlist = new admin;
$objlist_num = new admin;
$obj_delete = new admin;
$obj_change = new admin;
$obj_venuestate = new admin;
$obj_change = new admin;
$obj_change = new admin;
$obj_change = new admin;
$objgallery = new admin;

?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<?php
// Serach 
$items = 50;
$page = 1;
		
if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
{
	$limit = " LIMIT ".(($page-1)*$items).",$items";
	$i = $items*($page-1)+1;
}
else
{
	$limit = " LIMIT $items";
	$i = 1;
}

$venue_state = '';
if(isset($_REQUEST['venue_state']) && $_REQUEST['venue_state']!=""){
	$venue_state = $_REQUEST['venue_state'];
}
$venue_county = '';
if(isset($_REQUEST['venue_county']) && $_REQUEST['venue_county']!=""){
	$venue_county = $_REQUEST['venue_county'];
}
$venue_city = '';
if(isset($_REQUEST['venue_city']) && $_REQUEST['venue_city']!=""){
	$venue_city = $_REQUEST['venue_city'];
}
$venue = '';
if(isset($_REQUEST['venue']) && $_REQUEST['venue']!=""){
	$venue = $_REQUEST['venue'];
}

$blog_start_date = date("Y-m-d 00:00:00");

if(isset($_REQUEST['blog_start_date']) && $_REQUEST['blog_start_date']!=""){
	$blog_start_date = $_REQUEST['blog_start_date'];
}

$sunday   = strtotime("next sunday");
$nextSunday = $sunday + 60 * 60 * 24 * 7;

$blog_end_date = date('Y-m-d 00:00:00', $nextSunday);

if(isset($_REQUEST['blog_end_date']) && $_REQUEST['blog_end_date']!=""){
	$blog_end_date = $_REQUEST['blog_end_date'];
}

$target=$obj_base_path->base_path()."/admin/newsletter_blog_generation.php?venue_state=".$venue_state."&venue_county=".$venue_county."&venue_city=".$venue_city."&venue=".$venue."&show_pastevent=0&blog_start_date=".$blog_start_date."&blog_end_date=".$blog_end_date;	
if (isset($_SESSION['ses_user_id']) && ($_SESSION['ses_user_id']!="")) {
    $userType = -1;
    $account_type = new admin;
    $account_type->getAccountTypeByUserId($_SESSION['ses_user_id']);

    if($account_type->num_rows() > 0) {
        $account_type->next_record();
        $userType = $account_type->f('account_type');
    }

}
if((isset($_REQUEST['venue_state']) && $_REQUEST['venue_state']!="") || 
        (isset($_REQUEST['venue_county']) && $_REQUEST['venue_county']!="") || 
        (isset($_REQUEST['venue_city']) && $_REQUEST['venue_city']!="") || 
        (isset($_REQUEST['venue']) && $_REQUEST['venue']!="") || 
        (isset($_REQUEST['show_pastevent']) && $_REQUEST['show_pastevent']!="") ||
        (isset($_REQUEST['blog_start_date']) && $_REQUEST['blog_start_date']!="" && 
            isset($_REQUEST['blog_end_date']) && $_REQUEST['blog_end_date']!=""))
{
    
	$objlist->allEventListNewsletter($limit,$venue_state,$venue_county,$venue_city,$venue,0, $userType, $blog_start_date, $blog_end_date);
	$objlist_num->allEventListNewsletterCount($venue_state,$venue_county,$venue_city,$venue,0, $userType, $blog_start_date, $blog_end_date);

?>

<script type="text/javascript">
$(document).ready(function(){
	getCounty('<?php echo $venue_state;?>','<?php echo $venue_county;?>');
	getCity('<?php echo $venue_county;?>','<?php echo $venue_city;?>');
	getVenue('<?php echo $venue_city;?>','<?php echo $venue;?>');
});
</script>
<?php
}
else{
		
	//event list
	$objlist->allEventListNewsletter($limit,'','','','',0, $userType, $blog_start_date, $blog_end_date);
	$objlist_num->allEventListNewsletterCount('','','','',0, $userType, $blog_start_date, $blog_end_date);
}


$num = $objlist_num->num_rows();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generate Newsletter/Blog</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
</style>

<script language="javascript">
function del(eID)
{
	if(confirm("Are you sure you want to delete this Event?"))
	{
		location.href="list_events.php?action=delete&id="+eID;
	}
	
}
</script>
<script language="javascript" type="text/javascript">
function getCounty(stateid,venue_county)
{
     var firstOptionCity = $("#venue_city option:first").html();
     var firstOptionVenue = $("#venue option:first").html();
     $('#div_city_display').html('<select name="venue_city" id="venue_city" class="selectbg12"><option value="">' + firstOptionCity + '</option></select>');
     $('#div_venue_display').html('<select name="venue" id="venue" class="selectbg12"><option value="">' + firstOptionVenue + '</option></select>');
	 data = "state_id="+stateid+"&venue_county="+venue_county;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_county_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid,venue_city)
{
    var firstOptionVenue = $("#venue option:first").html();
     $('#div_venue_display').html('<select name="venue" id="venue" class="selectbg12"><option value="">' + firstOptionVenue + '</option></select>');
	 data = "county_id="+countyid+"&venue_city_list="+venue_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_city_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}

function getVenue(cityid,ven)
{
     data = "city_id="+cityid+"&ven="+ven;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_venue_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_venue_display").html(data);
	   }
	 });
}


function submit_by_js(){    
    var blog_start_date = $('#blog_start_date').val() ? blog_start_date = $('#blog_start_date').val() : '';
    var blog_end_date = $('#blog_end_date').val() ? blog_end_date = $('#blog_end_date').val() : '';
    var array_blog_start_date = blog_start_date.split("-");
    var array_blog_end_date = blog_end_date.split("-");
    
    var blog_start_date_reordered = array_blog_start_date[2] + "-" + array_blog_start_date[1] + "-" + array_blog_start_date[0];
    var blog_end_date_reordered = array_blog_end_date[2] + "-" + array_blog_end_date[1] + "-" + array_blog_end_date[0];
    
    var date_start_object = Date.parse(blog_start_date_reordered);
    var date_end_object = Date.parse(blog_end_date_reordered);
    
    if (date_start_object > date_end_object) {
    	alert ("Date From cannot be bigger than Date To");
        return false;
    }
    
	var venue_state = $('#venue_state').val() ? venue_state = $('#venue_state').val() : '';
	var venue_county = $('#venue_county').val() ? venue_county = $('#venue_county').val() : '';
	var venue_city = $('#venue_city').val() ? venue_city = $('#venue_city').val() : '';
	var venue = $('#venue').val() ? venue = $('#venue').val() : '';
	//var show_pastevent = $('#show_pastevent').val() ? show_pastevent = $('#show_pastevent').val() : '';
	if($('#show_pastevent').is(":checked")==true)
	{
		var show_pastevent = 1;
	}
	else
	{
		var show_pastevent = 0;
	}

	window.location.href="<?php echo $obj_base_path->base_path(); ?>/admin/newsletter_blog_generation.php?venue_state="+venue_state+"&venue_county="+venue_county+"&venue_city="+venue_city+"&venue="+venue+"&show_pastevent="+show_pastevent+"&blog_start_date="+blog_start_date_reordered+"&blog_end_date="+blog_end_date_reordered;
}

</script>

<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>

<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">
     <div class="clear"></div>
     <div class="container">
                <?php include("admin_header_menu.php"); ?> 
                <div id="body">
                    <div class="body2"> 
                        <div class="blue_box1">
                            <div class="blue_box11"><p>Newsletter / Blog Generation</p></div>
                        </div> 
                    </div>	
                </div>
            </div>
         <!--<form method="post" action="" enctype="multipart/form-data" name="listing" id="listing">-->
         <input type="hidden" name="listEvent" id="listEvent" value="1" /> 
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
            <tr>
                <td width="24%" style="border-bottom: none">
                    <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value,'');">
                        <option value=""><?= AD_STATE ?></option>
                        <?php
                      $obj_venuestate->getVenueState();
                      while($row = $obj_venuestate->next_record())
                      {
                      ?>
                        <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($venue_state==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                        <?php echo $obj_venuestate->f('state_name');?></option>
                        <?php
                      }
                      ?>
                    </select>
      			</td>
                <td width="24%" style="border-bottom: none">
                    <div id="div_county_display">
                      <select name="venue_county" id="venue_county" class="selectbg12">
                        <option value=""><?= AD_COUNTY ?></option>
                      </select>
                    </div>
                </td>
                <td width="23%" style="border-bottom: none">
                    <div id="div_city_display">
                        <select name="venue_city" id="venue_city" class="selectbg12">
                            <option value=""><?= AD_CITY ?></option>
                        </select>
                    </div>
                </td>
                <td width="29%" style="border-bottom: none">
                    <div id="div_venue_display">
                        <select name="venue" id="venue" class="selectbg12">
                            <option value=""><?= AD_VENUE ?></option>
                        </select>
                    </div>
                </td>
                <td width="24%" style="border-bottom: none">
                    <div class="input_box" style="margin: 0px 0 2px 0; float: right;">
                        <input type="image" onclick=submit_by_js() src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png"  style="border:0px;"  />                	
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <strong style="margin-left: 7px;">From</strong> 
                    <input readonly style="font: normal 12px/23px Arial, Helvetica, sans-serif; color: #6c7079; border: 1px solid #e1e1e1; width: 91px; padding: 2px 0 0 4px; height: 20px;" id="blog_start_date" type="text" name="blog_start_date" placeholder="Start Date" />
                </td>
                <td>
                    <strong style="margin-left: 7px;">To</strong> 
                    <input readonly style="font: normal 12px/23px Arial, Helvetica, sans-serif; color: #6c7079; border: 1px solid #e1e1e1; width: 109px; padding: 2px 0 0 4px; height: 20px;" id="blog_end_date" type="text" name="blog_end_date" placeholder="End Date" />                
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
         </table>
         <div class="clear"></div>	
         <div class="myevent_box">
            <div class="select-event-list-single" style="display: inline-block; border-right: 2px solid black; padding-right: 15px;">
               <input type="radio" name="choose_list_or_single" value="listing" checked="checked" /> <strong>Events listing</strong>
               <input type="radio" name="choose_list_or_single" value="single" /> <strong>Single events</strong>
            </div>            
            <div class="select-event-list-single" style="border-right: 2px solid black; display: inline-block; padding-left: 15px; padding-right: 15px;">
                <input type="checkbox" name="choose_language[]" value="spanish" checked="checked" /> <strong>Spanish</strong>
                <input type="checkbox" name="choose_language[]" value="english" checked="checked" /> <strong>English</strong>
            </div>
             <div class="select-event-list-single" style="display: inline-block; padding-left: 15px;">
                 <button style="cursor: pointer; background: #006684; color: white; border: 2px solid #006684; padding: 5px 10px; border-radius: 5px;" id="submit_generate_newsletter" name="submit_generate_newsletter">Generate</button>
            </div>
         </div>
         <div class="clear"></div>
         <div class="myevent_box" id="message-result" style="display: none;">
             <div style="color: green; font-weight: bold;">Newsletter generated successfully!!!</div>
         </div>
         <div class="clear"></div>	
		 <div class="myevent_box" style="display: none;">		 
			<?php
		 if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");		
		?>	
			<div style="width: auto; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
			<?php
			}
		 ?>
			</div>	         
       <!--  </form> -->
	 <div class="clear"></div>		
	 <div class="myevent_box">
	   <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
<?php /*?><?php
		 if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");		
		?>
         <tr>
		 <td colspan="7" align="left"></td>
		 </tr>
         <?php
			}
		 ?>
<?php */?> <tr>
                <td width="8%" class="top_txt">
                    <input type="checkbox" id="select_all_events" name="select_all_events" /> Select
                </td>
                <td width="8%" class="top_txt"><?= Showcase ?></td>                
                <td width="16%" class="top_txt"><?= AD_EVENT ?></td>
                <td width="13%" class="top_txt"><?= AD_DATE_AND_TIME ?></td>
                <td width="13%" class="top_txt">End Datetime</td>
                <td width="13%" class="top_txt"><?= AD_VENUE ?></td>
                <td width="9%" class="top_txt"><?= AD_CITY ?></td>
                <td width="7%" class="top_txt"><?= AD_COUNTY ?></td>
            </tr>
	        <?php

			if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");			
				while($row = $objlist->next_record())
				{
					
					list($event_date,$event_time) = explode(" ",$objlist->f('event_start_date_time'));
					list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
					list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);
                    
                    list($event_date_end,$event_time_end) = explode(" ",$objlist->f('event_end_date_time'));
					list($ev_year_end,$ev_mon_end,$ev_day_end) = explode("-",$event_date_end);
					list($ev_hr_end,$ev_min_end,$ev_sec_end) = explode(":",$event_time_end);
		?>
      <tr>
        <td>
            <input type="checkbox" value="<?php echo $objlist->f('event_id');?>" id="select_single_event_<?php echo $objlist->f('event_id');?>" class="select_single_event" name="select_single_event[]" />
        </td>
        <td>
            <input type="checkbox" value="<?php echo $objlist->f('event_id');?>" id="select_showcase_event_<?php echo $objlist->f('event_id');?>" class="select_showcase_event" name="select_showcase_event[]" />
        </td>
        <td><?php echo stripslashes($objlist->f('event_name_'.$_SESSION['langAdminSelected']));?></td>
        <td>
            <?php 
                if($ev_hr > 12){
                    $hr = $ev_hr - 12;
                }
                else
                {
                    $hr = $ev_hr;
                }
                echo $ev_day . "/" . $ev_mon . "/" . $ev_year . " - " . 
                        $hr . ":" . $ev_min . " " . $objlist->f('event_start_ampm');
            ?>
		</td>
        <td>
            <?php 
                if($ev_hr_end > 12){
                    $hr_end = $ev_hr_end - 12;
                }
                else
                {
                    $hr_end = $ev_hr_end;
                }
                echo $ev_day_end . "/" . $ev_mon_end . "/" . $ev_year_end . 
                        " - " . $hr_end . ":" . $ev_min_end . " " . $objlist->f('event_end_ampm');
            ?>
		</td>
        <td><?php echo $objlist->f('venue_name');?></td>
        <td style="padding: 5px 0;"><?php echo $objlist->f('city_name');?></td>
        <td><?php echo $objlist->f('county_name');?></td>           
      </tr>
  <?php } ?>
         <tr>
		<td>&nbsp</td>
        <td colspan="7" align="left"><div style="width: 150px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="8" align="center" style="padding-top:10px;"><font color="#FF0000">No Event Found</font></td></tr>
		<?php
			}
		?>
        </table>
    	</div>	
		<div class="clear"></div>
	</div>
	</div>
	<div class="clear"></div>	
	</div>
    <div class="clear"></div>
</div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
<script>
    $('#select_all_events').change(function(){
        var checkedStatus = (this.checked);  
        
        // change all other checkboxs
        $('.select_single_event').attr("checked", checkedStatus);        
    });
    
    $(document).ready(function() {
        var today = new Date();
        var jumbDay = (7 - today.getDay()) + 7;        
        var selectedStartDate = '<?php echo $_REQUEST['blog_start_date']; ?>';
        var selectedEndDate = '<?php echo $_REQUEST['blog_end_date']; ?>';       
        
        $('#blog_start_date').datepicker({            
            dateFormat: 'dd-mm-yy',
            defaultDate: today
        });        
        
        $('#blog_end_date').datepicker({            
            dateFormat: 'dd-mm-yy',
            defaultDate: new Date(today.getFullYear(),today.getMonth(),today.getDate() + jumbDay)
        });

        if (selectedStartDate.length > 0 && selectedEndDate.length > 0) {
            $("#blog_start_date").datepicker().datepicker("setDate", new Date(selectedStartDate));
            $("#blog_end_date").datepicker().datepicker("setDate", new Date(selectedEndDate));        
        } else {
            $("#blog_start_date").datepicker().datepicker("setDate", new Date());
            $("#blog_end_date").datepicker().datepicker("setDate", new Date(today.getFullYear(),today.getMonth(),today.getDate() + jumbDay));        
        }
        
        $('#submit_generate_newsletter').click(function() {
            // Check type of newsletter is Events listing or Single events
            var newsletterType = $('input[name=choose_list_or_single]:checked').val();
            var selectedEventID = [];
            $('input[name=select_single_event[]]:checked').each(function() {
                selectedEventID.push($(this).val());
            });
            if (selectedEventID.length == 0) {
                alert('You have to select at least one event to generate in newsletter!');
                return false;
            }
            
            var selectedShowcaseEventID = [];
            $('input[name=select_showcase_event[]]:checked').each(function() {
                selectedShowcaseEventID.push($(this).val());
            });
            
            var index = 0;
            if (selectedShowcaseEventID.length > 0) {
                for (index = 0; index < selectedShowcaseEventID.length; ++index) {
                    if (selectedEventID.indexOf(selectedShowcaseEventID[index]) == -1) {
                        alert("Showcase event should be in the selected newsletter events");
                        return false;
                    }
                }
            }
            
            var blog_start_date = $('#blog_start_date').val() ? blog_start_date = $('#blog_start_date').val() : '';
            var blog_end_date = $('#blog_end_date').val() ? blog_end_date = $('#blog_end_date').val() : '';
            var array_blog_start_date = blog_start_date.split("-");
            var array_blog_end_date = blog_end_date.split("-");

            var blog_start_date_reordered = array_blog_start_date[2] + "-" + array_blog_start_date[1] + "-" + array_blog_start_date[0];
            var blog_end_date_reordered = array_blog_end_date[2] + "-" + array_blog_end_date[1] + "-" + array_blog_end_date[0];

            var date_start_int = Date.parse(blog_start_date_reordered);
            var date_end_int = Date.parse(blog_end_date_reordered);
            
            var blog_start_date_object = new Date(blog_start_date_reordered);
            var blog_end_date_object = new Date(blog_end_date_reordered);
            var options = { weekday: 'short', month: 'short', day: 'numeric' };
            var from_date_sp = blog_start_date_object.toLocaleString('es-ES', options);
            var from_date_en = blog_start_date_object.toLocaleString('en-US', options);
            var to_date_sp = blog_end_date_object.toLocaleString('es-ES', options);
            var to_date_en = blog_end_date_object.toLocaleString('en-US', options);
            
            if (date_start_int > date_end_int) {
                alert ("Date From cannot be bigger than Date To");
                return false;
            }
            
            var titleEN = 'Baja Sur Events ' + from_date_en + ' - ' + to_date_en;
            var titleSP = 'Eventos Baja Sur ' + from_date_sp + ' - ' + to_date_sp;  
            console.log(titleEN);
            console.log(titleSP);
            console.log(selectedEventID);
            console.log(selectedShowcaseEventID);
            console.log(newsletterType);
            
            data = "title_en=" + titleEN + 
                    "&title_sp=" + titleSP +
                    "&selected_event_id=" + selectedEventID +
                    "&selected_showcase_id=" + selectedShowcaseEventID +
                    "&newsletter_type=" + newsletterType;
            
            $.ajax({ 
                url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_generate_newsletter_blog.php",
                cache: false,
                type: "POST",
                data: data,   
                success: function(data){ 
                    $("#message-result").css('display', 'block');
                    
                    (function(data){ 
                        setTimeout(function() { 
                            $("#message-result").css('display', 'none');
                            //window.location.href = "http://kpasapp.com/admin/edit_page/" + data;
                        }, 3000);
                    })(data);
                }
            });
        });
    });
</script>
</body>
</html>