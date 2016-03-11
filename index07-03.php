<?php
//index page
include('include/user_inc.php');

//create object
$objSettings=new user;
$objEvent=new user;
$objEventpic=new user;
$objEventpic1=new user;
$obj_venue=new user;
$obj_min_ticket_cost=new user;
$objEvent_num=new user;
$objEventcal=new user;
$objnum_ticket=new user;

$objEventCounty = new user;
$objEventtags = new user;
$objEventparentcategory = new user;
$objEventsubcategory = new user;
$objEventCity = new user;
$objEventVenue = new user;
$objmulti_event = new user;
$objmul_date = new user;
$objsub_eve = new user;
$obj_subeve_fst_tm = new user;
$obj_subeve_lst_tm = new user;
$objsubEventAll = new user;
$objsub_date = new user;
$objsubEventon = new user;
$checkSub = new user;
$obj_user_ck = new user;

$objSettings->adminSettings();
$objSettings->next_record();

if($_SESSION['remember'] == 'rem'){
	$expire=time()+60*60*24*30;
	setcookie('email',$_SESSION['email'],$expire);
	setcookie('pass',$_SESSION['pass'],$expire);
}
//echo "dfgfd".$_COOKIE['first_name1'];
//print_r($_COOKIE);
//echo "dfgfd".$_COOKIE['email'];
//echo "hiii".$_SESSION['site_lang'];

if($_REQUEST['start_date']){
	$start_date = $_REQUEST['start_date'];
	$start_format_date = explode("-",$_REQUEST['start_date']);
	$start_val_date = $start_format_date[2]."/".$start_format_date[1]."/".$start_format_date[0];
}
if($_REQUEST['end_date']){
	$end_date = $_REQUEST['end_date'];
	$end_format_date = explode("-",$_REQUEST['end_date']);
	$end_val_date = $end_format_date[2]."/".$end_format_date[1]."/".$end_format_date[0];
	
}


// Fetch All Image Pic
$objEventpic->allEventPicture();
$objEventpic1->allEventPicture();


// Change Language if user logged in
if($_SESSION['ses_admin_id']!="" && $_SESSION['lang_change']==1){
	$obj_user_ck->getAdminById($_SESSION['ses_admin_id']);
	$obj_user_ck->next_record();
	$_SESSION['lang_change'] = 0;
	//echo $obj_user_ck->f('language');
	?>
	<script>
	$(document).ready(function(){
		//alert('<?php echo $obj_user_ck->f('language');?>');
		<?php
		if($obj_user_ck->f('language') == 'English'){
		?>
		$('#languageId').val('eng');
		<?php
		}
		elseif($obj_user_ck->f('language') == 'Spanish')
		{
		?>
		$('#languageId').val('spn');
		<?php
		}
		?>
		$('#frmlanguage').submit();
	});
	</script>
	<?php

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>KPasapp</title>	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<!--<link href="<?php echo $obj_base_path->base_path(); ?>/css/datepicker.css" rel="stylesheet" type="text/css" />-->

<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery2-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!--[if lt IE 9]>
    <script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
    <script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
    
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.bxSlider.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
    var slider=$('#slider2').bxSlider({
						    controls: false,
							displaySlideQty:3,
							moveSlideQty:1,
							pager:false,
							auto:true,
							mode:'horizontal'
						   });
	
	  $('#go-next').click(function(){
		slider.goToPreviousSlide();
		return false;
	  });

  $('#go-prev').click(function(){
		slider.goToNextSlide();
		return false;
	  });
	  
	  var slider1=$('#slider1').bxSlider({
						   controls: false,
							displaySlideQty:3,
							moveSlideQty:1,
							pager:false,
							auto:true,
							mode:'horizontal'
						   });
	
	  $('#go-next1').click(function(){
		slider1.goToPreviousSlide();
		return false;
	  });

  	$('#go-prev1').click(function(){
		slider1.goToNextSlide();
		return false;
	  });
  
  });

</script>
<link rel='stylesheet' href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/theme.css' />
<link href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/jquery-ui-1.10.2.custom.min.js'></script>
<script src='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.js'></script>
<script>


	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		
		$('#calendar1').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			
			events: [
			
			<?php
			$event_county = '';
			$event_cities = '';
			$event_venues = '';
			
			$event_county_cal_rec = $_REQUEST['event_county_cal_rec'];
			$event_cities_cal_rec = $_REQUEST['event_cities_cal_rec'];
			$event_venues_cal_rec = $_REQUEST['event_venues_cal_rec'];
			$event_categories_cal_rec = $_REQUEST['event_categories_cal_rec'];
			
			$objEventcal_rec=new user;
			$objEventcal_rec->recur_evnt_dtls($event_county_cal_rec,$event_cities_cal_rec,$event_venues_cal_rec,$event_categories_cal_rec);
			if($objEventcal_rec->num_rows())
			{
				while($objEventcal_rec->next_record())
				{
				   list($startdate,$starttime) = explode(" ",$objEventcal_rec->f('event_start_date_time'));
				   list($enddate,$endTime) = explode(" ",$objEventcal_rec->f('event_end_date_time'));
				   
				   list($span_start_yr,$span_start_mon,$span_start_day) = explode("-",$objEventcal_rec->f('r_span_start'));
				   list($span_end_yr,$span_end_mon,$span_end_day) = explode("-",$objEventcal_rec->f('r_span_end'));
				   
				   if($_SESSION['langSessId']=='eng'){ 
				   		//$eve_name = str_replace("'","\'",substr($objEventcal_rec->f('event_name_en'),0,30)); 
						//$eve_venue =  str_replace("'","\'",substr($objEventcal_rec->f('ven_nam'),0,30));
						
						$eve_name = substr($objEventcal_rec->f('event_name_en'),0,30); 
						$eve_venue =  substr($objEventcal_rec->f('ven_nam'),0,30);
					} 
				   else{ 
				   		//$eve_name = str_replace("'","\'",substr($objEventcal_rec->f('event_name_sp'),0,30));
						//$eve_venue = str_replace("'","\'",substr($objEventcal_rec->f('ven_nam_sp'),0,30));
						
						$eve_name = substr($objEventcal_rec->f('event_name_sp'),0,30);
						$eve_venue = substr($objEventcal_rec->f('ven_nam_sp'),0,30);
					}
					//$city_name = str_replace("'","\'",substr($objEventcal_rec->f('city_name'),0,30));
					$city_name = substr($objEventcal_rec->f('city_name'),0,30);
					
					// For weekly
					
					if($objEventcal_rec->f('event_time') == "Weekly")
					{
						$cur_span_day = date("D",strtotime($objEventcal_rec->f('r_span_start')));
						$allDate = '';
						$start_mon_date = '';
						$start_tue_date = '';
						$start_wed_date = '';
						$start_thu_date = '';
						$start_fri_date = '';
						$start_sat_date = '';
						$start_sun_date = '';
					
						// For monday
						if($objEventcal_rec->f('mon')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							
						}
						if($start_mon_date!=""){
							
							while(strtotime($start_mon_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_mon_date;
							
								$date1 = str_replace('-', '/', $start_mon_date);
								$start_mon_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
							
						// For Tuesday
						if($objEventcal_rec->f('tue')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							
						}
						if($start_tue_date!=""){
							
							while(strtotime($start_tue_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_tue_date;
							
								$date1 = str_replace('-', '/', $start_tue_date);
								$start_tue_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
							
						// For Wednesday
						if($objEventcal_rec->f('wed')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							
						}
						if($start_wed_date!=""){
							while(strtotime($start_wed_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_wed_date;
							
								$date1 = str_replace('-', '/', $start_wed_date);
								$start_wed_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
						
						// For Thusday
						if($objEventcal_rec->f('thu')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							
						}
						if($start_thu_date!=""){
							while(strtotime($start_thu_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_thu_date;
							
								$date1 = str_replace('-', '/', $start_thu_date);
								$start_thu_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
						
						// For Friday
						if($objEventcal_rec->f('fri')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							
						}
						if($start_fri_date!=""){
							while(strtotime($start_fri_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_fri_date;
							
								$date1 = str_replace('-', '/', $start_fri_date);
								$start_fri_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
						
						// For Saturday
						if($objEventcal_rec->f('sat')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							
						}
						if($start_sat_date!=""){
							while(strtotime($start_sat_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_sat_date;
							
								$date1 = str_replace('-', '/', $start_sat_date);
								$start_sat_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
						
						// For Sunday
						if($objEventcal_rec->f('sun')){
							if($cur_span_day=="Mon"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+6 days"));
							}
							if($cur_span_day=="Tue"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+5 days"));
							}
							if($cur_span_day=="Wed"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+4 days"));
							}
							if($cur_span_day=="Thu"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+3 days"));
							}
							if($cur_span_day=="Fri"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+2 days"));
							}
							if($cur_span_day=="Sat"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+1 days"));
							}
							if($cur_span_day=="Sun"){
								$date1 = str_replace('-', '/', $objEventcal_rec->f('r_span_start'));
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+0 days"));
							}
							
						}
						if($start_sun_date!=""){
							while(strtotime($start_sun_date) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_sun_date;
							
								$date1 = str_replace('-', '/', $start_sun_date);
								$start_sun_date = date('Y-m-d',strtotime($date1 . "+7 days"));
							}
						}
						
						if($allDate!=""){
							foreach($allDate as $eachDate)
							{
								list($sty,$stm,$std) = explode("-",$eachDate);
							
							?>
							{
								title: '<?php echo $eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>, <?php echo $std?>),
								end: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>,<?php echo $std?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal_rec->f('evnt');?>'
							},	
	
							<?php		
							}
						}
						
					}

					// For Monthly
					
					/*else if($objEventcal_rec->f('event_time') == "Monthly")
					{
						$allDateMonthly = "";
						
						if($objEventcal_rec->f('r_month_day')=="Sunday" || $objEventcal_rec->f('r_month_day')=="Monday" || $objEventcal_rec->f('r_month_day')=="Tuesday" || $objEventcal_rec->f('r_month_day')=="Wednesday" || $objEventcal_rec->f('r_month_day')=="Thursday" || $objEventcal_rec->f('r_month_day')=="Friday" || $objEventcal_rec->f('r_month_day')=="Saturday"){
							
							$date2 =  $span_start_yr."-".$span_start_mon."-00";
							$store_date = date("Y-m-d",strtotime(strtolower($objEventcal_rec->f('r_month'))." ".strtolower($objEventcal_rec->f('r_month_day'))." ".$date2));
							$inc = 1;
							while(strtotime($date2) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								if(strtotime($store_date) >= strtotime($objEventcal_rec->f('r_span_start')) && strtotime($store_date) <= strtotime($objEventcal_rec->f('r_span_end'))){
									$allDateMonthly[] = $store_date;
								}
								// Calculate next month day
								$next_mon = $span_start_mon + $inc;
								if($next_mon > 12){
									$span_start_yr = $span_start_yr + 1;
									$next_mon = 1;
								}
								$cur_dt = $span_start_yr."-".$next_mon."-00";
								$store_date = date("Y-m-d",strtotime(strtolower($objEventcal_rec->f('r_month'))." ".strtolower($objEventcal_rec->f('r_month_day'))." ".$cur_dt));
		
								$date1 = str_replace('-', '/', $date2);
								$date2 = date('Y-m-d',strtotime($date1 . "+1 month"));
								$inc++;
							}
						}
						
						
						
						if($allDateMonthly!=""){
							foreach($allDateMonthly as $eachDate)
							{
								list($sty,$stm,$std) = explode("-",$eachDate);
							
							?>
							{
								title: '<?php echo $eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>, <?php echo $std?>),
								end: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>,<?php echo $std?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal_rec->f('evnt');?>'
							},	
	
							<?php		
							}
						}

						
						
					}

					// For Yearly
					else if($objEventcal_rec->f('event_time') == "Yearly")
					{
						
						$start_yr = $objEventcal_rec->f('r_span_start');
						if($start_yr!=""){
							while(strtotime($start_yr) <= strtotime($objEventcal_rec->f('r_span_end')))
							{
								$allDate[] = $start_yr;
							
								$date1 = str_replace('-', '/', $start_yr);
								$start_yr = date('Y-m-d',strtotime($date1 .'+ 1 year'));
							}
						}
						
						if($allDate!=""){
							foreach($allDate as $eachDate)
							{
								list($sty,$stm,$std) = explode("-",$eachDate);
							
							?>
							{
								title: '<?php echo $eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>, <?php echo $std?>),
								end: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>,<?php echo $std?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal_rec->f('evnt');?>'
							},	
	
							<?php		
							}
						}
						
						
					}
					else{
			?>
							{
								title: '<?php echo $eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $span_start_yr?>, <?php echo ($span_start_mon-1);?>, <?php echo $span_start_day?>),
								end: new Date(<?php echo $span_end_yr?>, <?php echo ($span_end_mon-1);?>,<?php echo $span_end_day?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal_rec->f('evnt');?>'
							},	
						
						
			<?php
					}*/
						
				}
			}
			 ?>
			]
		});
		
	});

</script>




<script>


	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		
		$('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			
			events: [
			
			<?php
			$event_county = '';
			$event_cities = '';
			$event_venues = '';
			$event_categories_cal = '';
			
			$event_county_cal = $_REQUEST['event_county_cal'];
			$event_cities_cal = $_REQUEST['event_cities_cal'];
			$event_venues_cal = $_REQUEST['event_venues_cal'];
			$event_categories_cal = $_REQUEST['event_categories_cal'];
			
			$objEventcal=new user;

			$objEventcal->eventDetails($event_county_cal,$event_cities_cal,$event_venues_cal,$event_categories_cal);
			if($objEventcal->num_rows())
			{
				while($objEventcal->next_record())
				{
				   list($startdate,$starttime) = explode(" ",$objEventcal->f('event_start_date_time'));
				   list($enddate,$endTime) = explode(" ",$objEventcal->f('event_end_date_time'));
				   
				   list($span_start_yr,$span_start_mon,$span_start_day) = explode("-",$objEventcal_rec->f('r_span_start'));

				   list($st_yr,$st_mn,$st_day) = explode("-",$startdate);
				   list($en_yr,$en_mn,$en_day) = explode("-",$enddate);
				   
				   /*if($_SESSION['langSessId']=='eng'){ $eve_name = str_replace("'","\'",substr($objEventcal->f('event_name_en'),0,30)); } else { $eve_name = str_replace("'","\'",substr($objEventcal->f('event_name_sp'),0,30));}
				   if($_SESSION['langSessId']=='eng'){ $eve_venue =  str_replace("'","\'",substr($objEventcal->f('ven_nam'),0,30)); } else { $eve_venue = str_replace("'","\'",substr($objEventcal->f('ven_nam_sp'),0,30)); };
					$city_name = str_replace("'","\'",substr($objEventcal->f('city_name'),0,30));*/
					
					if($_SESSION['langSessId']=='eng'){ $eve_name = substr($objEventcal->f('event_name_en'),0,30); } else { $eve_name = substr($objEventcal->f('event_name_sp'),0,30);}
				   if($_SESSION['langSessId']=='eng'){ $eve_venue =  substr($objEventcal->f('ven_nam'),0,30); } else { $eve_venue = substr($objEventcal->f('ven_nam_sp'),0,30); };
					$city_name = substr($objEventcal->f('city_name'),0,30);
					
					if($objEventcal->f('identical_function')==1){
						
						$allData_multi = '';
						$allData_multi[0]['city'] = $objEventcal->f('city_name');
						$allData_multi[0]['venue_name'] = $objEventcal->f('venue_name');
						$allData_multi[0]['venue_name_sp'] = $objEventcal->f('venue_name_sp');
						$allData_multi[0]['event_start_date_time'] = $objEventcal->f('event_start_date_time');
						$allData_multi[0]['event_end_date_time'] = $objEventcal->f('event_end_date_time');
						
						$objmulti_event_cal=new user;
						// Check for Multi Function Event
						$objmulti_event_cal->multi_event($objEventcal->f('evnt'));
						
						if($objmulti_event_cal->num_rows()){
							$l=1;
							while($objmulti_event_cal->next_record()){ 
							
							$allData_multi[$l]['multi_id'] = $objmulti_event_cal->f('multi_id');
							$allData_multi[$l]['city'] = $objmulti_event_cal->f('city_name');
							$allData_multi[$l]['venue_name'] = $objmulti_event_cal->f('venue_name');
							$allData_multi[$l]['venue_name_sp'] = $objmulti_event_cal->f('venue_name_sp');
							$allData_multi[$l]['event_start_date_time'] = $objmulti_event_cal->f('multi_start_time');
							$allData_multi[$l]['event_end_date_time'] = $objmulti_event_cal->f('multi_end_time');
							$l++;
							}
						}
						$ab=0;
						
						/*function sortFunction( $a, $b ) {
							return strtotime($a["event_start_date_time"]) - strtotime($b["event_start_date_time"]);
						}
						usort($allData_multi, "sortFunction");*/
						
						foreach($allData_multi as $eachData1)
						{
							$st_yr1 = 0;
							list($multi_event_date,$multi_event_time) = explode(" ",$eachData1['event_start_date_time']);
							list($st_yr1,$st_mn1,$st_day1) = explode("-",$multi_event_date);
							
							$row[$ab]['multi_event_date'] = $multi_event_date;

							$row[$ab]['city'] = $eachData1['city'];
							$row[$ab]['multi_id'] = $eachData1['multi_id'];
							$row[$ab]['venue_name'] =$eachData1['venue_name'];
							$row[$ab]['multi_start_time'] =$multi_event_time;
							
							
							if($row[$ab]['multi_event_date']!=$row[$ab-1]['multi_event_date'])
							{
								list($enddate,$endTime) = explode(" ",$eachData1['event_end_date_time']);
								list($en_yr1,$en_mn1,$en_day1) = explode("-",$enddate);
								
								$date2 = date('Y-m-d',strtotime($row[$ab]['multi_event_date']. "+1 day"));
								$objmul_date->multi_event_datewise($objEventcal->f('evnt'),$row[$ab]['multi_event_date'],$date2);
								
								$venueData = '';
								$cityData = '';
								if($ab==0){
									
									$venueData[] = $objEventcal->f('venue_name');
									$venue = $objEventcal->f('venue_name').'\n';
									
									$cityData[] = $objEventcal->f('city_name1');
									$city = $city_name.'\n';
									
									
									$time = date('g:i A',strtotime($starttime)).'\n';
								}
								else
								{
									$city = '';
									$venue = '';
									$time = '';
								}

								while($objmul_date->next_record()){
									list($new_date,$new_time) = explode(" ",$objmul_date->f('multi_start_time'));
									list($new_date_end,$new_time_end) = explode(" ",$objmul_date->f('multi_end_time'));
									
									//$city.=$objmul_date->f('city_name1').'\n';
									
									if(!in_array($objmul_date->f('city_name1'),$cityData)){
										$city.=$objmul_date->f('city_name1').'\n';
										$cityData[] = $objmul_date->f('city_name1');
									}
									
									if(!in_array($objmul_date->f('venue_name'),$venueData)){
										$venue.=$objmul_date->f('venue_name').'\n';
										$venueData[] = $objmul_date->f('venue_name');
									}
									
									$time.=date('g:i A',strtotime($new_time)).'\n';
								}
								/*if($startdate!=$enddate)
								{
									$showTimeCal = "See Program";
									$eveven = " ,".$eve_venue;
								}
								else*/{
									$showTimeCal = $time;
									//echo "ccc ".$showTimeCal; exit;
									$eveven = '\n'.$eve_venue;
								}

								?>
								<?php
									$objmul_ids=new user;
									$objmul_ids->multi_id_first($objEventcal->f('evnt'),$new_date);
									$objmul_ids->next_record();
									//echo "<pre>";
									//print_r($objmul_id);
								?>
								
								{
									title: '<?php echo $eve_name.' \n'.$city_name.$eveven.' \n'.$showTimeCal; ?>',
									start: new Date(<?php echo $st_yr1;?>, <?php echo ($st_mn1-1);?>, <?php echo $st_day1;?>),
									end: new Date(<?php echo $en_yr1;?>, <?php echo ($en_mn1-1);?>,<?php echo $en_day1?>),
									url: '<?php echo $obj_base_path->base_path(); ?>/eventPage/<?php echo $objEventcal->f('evnt');?>/<?php echo $objmul_ids->f('multi_id');?>'
								},
								<?php
							}
							$ab++;
						}
					}

					// For Monthly
					else if($objEventcal->f('event_time') == "Monthly")
					{
						$allDateMonthly = "";
						
						if($objEventcal->f('r_month_day')=="Sunday" || $objEventcal->f('r_month_day')=="Monday" || $objEventcal->f('r_month_day')=="Tuesday" || $objEventcal->f('r_month_day')=="Wednesday" || $objEventcal->f('r_month_day')=="Thursday" || $objEventcal->f('r_month_day')=="Friday" || $objEventcal->f('r_month_day')=="Saturday"){
							
							$date21 =  $span_start_yr."-".$span_start_mon."-00";
							$store_date = date("Y-m-d",strtotime(strtolower($objEventcal->f('r_month'))." ".strtolower($objEventcal->f('r_month_day'))." ".$date21));
							$inc = 1;
							while(strtotime($date21) <= strtotime($objEventcal->f('r_span_end')))
							{
								if(strtotime($store_date) >= strtotime($objEventcal->f('r_span_start')) && strtotime($store_date) <= strtotime($objEventcal->f('r_span_end'))){
									$allDateMonthly[] = $store_date;
								}
								// Calculate next month day
								$next_mon = $span_start_mon + $inc;
								if($next_mon > 12){
									$span_start_yr = $span_start_yr + 1;
									$next_mon = 1;
								}
								//$cur_dt = $span_start_yr."-".$next_mon."-00";
								$store_date = date("Y-m-d",strtotime(strtolower($objEventcal->f('r_month'))." ".strtolower($objEventcal->f('r_month_day'))." ".$date21));
		
								$date11 = str_replace('-', '/', $date21);
								$date21 = date('Y-m-d',strtotime($date11 . "+1 month"));
								$inc++;
							}
						}
						
						
						
						if($allDateMonthly!=""){
							foreach($allDateMonthly as $eachDate)
							{
								list($sty,$stm,$std) = explode("-",$eachDate);
							
							?>
							{
								title: '<?php echo $eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>, <?php echo $std?>),
								end: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>,<?php echo $std?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal->f('evnt');?>'
							},	
	
							<?php		
							}
						}
					}

					// For Yearly
					else if($objEventcal->f('event_time') == "Yearly")
					{
						
						$start_yr = $objEventcal->f('r_span_start');
						if($start_yr!=""){
							while(strtotime($start_yr) <= strtotime($objEventcal->f('r_span_end')))
							{
								$allDate_year[] = $start_yr;
							
								$date1 = str_replace('-', '/', $start_yr);
								$start_yr = date('Y-m-d',strtotime($date1 .'+ 1 year'));
							}
						}
						
						if($allDate_year!=""){
							foreach($allDate_year as $eachDate)
							{
								list($sty,$stm,$std) = explode("-",$eachDate);
							
							?>
							{
								title: '<?php echo "YEARLY EVENT".'\n\n'.$eve_name.'\n'.$city_name.'\n'.$eve_venue.' \n'.date('g:i A',strtotime($starttime)); ?>',
								start: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>, <?php echo $std?>),
								end: new Date(<?php echo $sty?>, <?php echo ($stm-1);?>,<?php echo $std?>),
								url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal->f('evnt');?>'
							},	
	
							<?php		
							}
						}
						
						
					}

					else
					{
						if($startdate!=$enddate)
						{
							$showTimeCal = "See Program";
							$eveven = " ,".$eve_venue;
						}
						else{
							$showTimeCal = date('g:i A',strtotime($starttime));
							$eveven = '\n'.$eve_venue;
						}
						
			?>
						{
							title: '<?php echo $eve_name.'\n'.$city_name.$eveven.' \n'.$showTimeCal; ?>',
							start: new Date(<?php echo $st_yr?>, <?php echo ($st_mn-1);?>, <?php echo $st_day?>),
							end: new Date(<?php echo $en_yr?>, <?php echo ($en_mn-1);?>,<?php echo $en_day?>),
							url: '<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objEventcal->f('evnt');?>'
						},
					
			<?php
					}
				}
			}
			 ?>
			]
		});
		
	});

</script>


<script type="text/javascript">
function eventBytags(tags_val){
	window.location.href="<?php echo $obj_base_path->base_path(); ?>/index.php?tags="+tags_val
}


function eventByDate()
{
	var start_d = '';
	var end_d = '';
	if($('#from_date').val()!="" && $('#to_date').val()!="")
	{
		var s_date_format = $('#from_date').val().split("/");
		var start_d = s_date_format[2]+"-"+s_date_format[1]+"-"+s_date_format[0]
		
		var e_date_format = $('#to_date').val().split("/");
		var end_d = e_date_format[2]+"-"+e_date_format[1]+"-"+e_date_format[0]
	}
	

	window.location.href="<?php echo $obj_base_path->base_path(); ?>/index.php?key_word="+$('#key_word').val()+"&start_date="+start_d+"&end_date="+end_d+"&county_val="+$('#event_county').val()+"&evn_venue="+$('#event_venues').val()+"&evn_city="+$('#event_cities').val()+"&event_categories="+$('#event_categories').val();
}

function showCal_rec()
{
	window.location.href="<?php echo $obj_base_path->base_path(); ?>/index.php?event_county_cal_rec="+$('#event_county_cal_rec').val()+"&event_cities_cal_rec="+$('#event_cities_cal_rec').val()+"&event_venues_cal_rec="+$('#event_venues_cal_rec').val()+"&event_categories_cal_rec="+$('#event_categories_cal_rec').val();
}

function showCal()
{
	window.location.href="<?php echo $obj_base_path->base_path(); ?>/index.php?event_county_cal="+$('#event_county_cal').val()+"&event_cities_cal="+$('#event_cities_cal').val()+"&event_venues_cal="+$('#event_venues_cal').val()+"&event_categories_cal="+$('#event_categories_cal').val();
}

$(document).ready(function() {
	$('#from_date').datepicker({
		firstDay: 1,
		dateFormat: 'dd/mm/yy',
		showButtonPanel: true
	});
	$('#to_date').datepicker({
		firstDay: 1,
		dateFormat: 'dd/mm/yy',
		showButtonPanel: true
	});
});



function getCityCal(countyid)
{
	if('<?php echo $_REQUEST['event_cities_cal'];?>'!="")
		var evnt_ct = '<?php echo $_REQUEST['event_cities_cal'];?>';
	else
		var evnt_ct = '';
	
	 data = "county_id="+countyid+"&evnt_ct="+evnt_ct;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_get_city_cal.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadCityDivCal").html(data);
	   }
	 });
}

function getCityCal_rec(countyid)
{
	if('<?php echo $_REQUEST['event_cities_cal_rec'];?>'!="")
		var evnt_ct = '<?php echo $_REQUEST['event_cities_cal_rec'];?>';
	else
		var evnt_ct = '';
	
	 data = "county_id="+countyid+"&evnt_ct="+evnt_ct;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_get_city_cal_rec.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadCityDivCal_rec").html(data);
	   }
	 });
}

function getVenueCal_rec(cityid)
{
	if('<?php echo $_REQUEST['event_venues_cal_rec'];?>'!="")
		var evnt_ven = '<?php echo $_REQUEST['event_venues_cal_rec'];?>';
	else
		var evnt_ven = '';
	
	 data = "city_id="+cityid+"&evnt_ven="+evnt_ven;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_get_venue_cal_rec.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadVenueDivCal_rec").html(data);
	   }
	 });
}

function getVenueCal(cityid)
{
	if('<?php echo $_REQUEST['event_venues_cal'];?>'!="")
		var evnt_ven = '<?php echo $_REQUEST['event_venues_cal'];?>';
	else
		var evnt_ven = '';
	
	 data = "city_id="+cityid+"&evnt_ven="+evnt_ven;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_get_venue_cal.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadVenueDivCal").html(data);
	   }
	 });
}


function getCity(countyid)
{
	if('<?php echo $_REQUEST['evn_city'];?>'!="")
		var evnt_city = '<?php echo $_REQUEST['evn_city'];?>';
	else
		var evnt_city = '';
	
	 data = "county_id="+countyid+"&evnt_city="+evnt_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_get_city.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadCityDiv").html(data);
	   }
	 });
}

function getVenue(cityid)
{
	if('<?php echo $_REQUEST['evn_venue'];?>'!="")
		var event_venue = '<?php echo $_REQUEST['evn_venue'];?>';
	else
		var event_venue = '';
	
	 data = "city_id="+cityid+"&event_venue="+event_venue;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_get_venue.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){
	   $("#loadVenueDiv").html(data);
	   }
	 });
}


function checkRecurring()
{
	if(document.getElementById('weekly_recurring_events').checked == true)
	{
	   document.getElementById('divRecurrent').innerHTML = '<?php if($objSettings->f('show_weekly_recurring_events')=='1') { ?><a href="recurring_events.php"><?php } ?><?=show_weekly_recurring_events;?><?php if($objSettings->f('show_weekly_recurring_events')=='1') { ?></a><?php } ?>';  
	}
	else
	{
	   document.getElementById('divRecurrent').innerHTML = '<?=show_weekly_recurring_events;?>';  
	}
}

function showmoreSubevent(num){
	//$('.more_subevent'+num).slideToggle();
}

</script>

</head>

<body> 
<style>

#calendar {
	width: 100%;
	margin: 0 auto;
	height:400px;
	overflow:scroll;
	overflow-x:hidden;
}
#calendar1 {
	width: 100%;
	margin: 0 auto;
	height:400px;
	overflow:scroll;
	overflow-x:hidden;
}
.bx-wrapper {
	width: 580px!important;
	position: absolute;
	padding: 0;
	margin: 0;
	top: 0;
	left: 50px;
}
.bx-window {
	width: 580px!important;
}
.pager {
	width: 190px!important;
	/*border: 1px solid #fc00ff;*/
	padding: 0!important;
	margin: 0!important;
}
#slider2, #slider1 {
	height: 140px!important;
	margin: 2px 0!important;
}
#slider2 li, #slider1 li {
	width: 193px !important;
	float: left!important;
	overflow: hidden!important;
	padding: 0!important;
	margin: 0!important;
	display: inline-block!important;
	
}
#slider2 li img, #slider1 li img {
	width: 170px !important;
	display: block!important;
	margin: 4px;
}
</style>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
 
    
<div id="maindiv">
	
<div class="clear"></div>
 <div class="body_bg">
 <div class="clear"></div>
  <div class="container">
     <div class="left_panel bg">
        <div class="spotlight_box">
            <div class="heading"><?=SECTION1?></div>
            <div class="spotlight" style=" position: relative;">
              <div id="go-prev" style="margin: 0 0 0 5px; top: 54px; left: 0; position: absolute;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/arrow_left.png" /></div>          <div id="go-next" style="margin: 0 5px 0 0; top: 54px;right: 0; position:absolute;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/arrow_right.png" /></div>           <ul id="slider2" style="padding-left:2px; padding: 0; width: 680px; height: 140px;">
                <?php
                    if($objEventpic->num_rows()){
                        while($objEventpic->next_record()){
                            if($objEventpic->f('event_photo')!=""){
                ?>
                        <li style="border: 1px solid #CCCCCC; margin: 0 4px; width: 170px;"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objEventpic->f('event_photo');?>" width="160" height="126"/></li>
                <?php 
                            }
                        }
                    }
                    else{
                ?>
                        <li style="border: 1px solid #CCCCCC;width:170px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic2.jpg" width="160" height="126"/></li> 
                        <li style="border: 1px solid #CCCCCC;width:170px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic3.jpg" width="160" height="126"/></li>
                        <li style="border: 1px solid #CCCCCC;width:170px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic3.jpg" width="160" height="126"/></li>
                <?php 
                    }
                ?>
               </ul>    
            </div>
        </div>
        <div class="clear"></div>
        <div class="event_table_box" id="tblbox">
            <div class="headbox"></div>
            <div class="clear"></div>
            <div class="event_tag_table" style="height:auto !important;">
            <div class="drop_box_<?php echo $_SESSION['langSessId']?>" style="overflow: hidden;border:1px solid #e4e4e4;border-radius:5px;padding:1px 5px 0 5px;margin: 0 0 10px 0;">
             <div class="styled_select" style="height:32px;">
              <select name="event_categories_cal" id="event_categories_cal" style="width: 180px;">
                <option value=""><?=DROPDOWN_ALL_EVENT_CATEGORIES?></option>
                <?php
                $objEventparentcategory->allEventParentCategoryList();
                while($row = $objEventparentcategory->next_record())
                {
                ?>
                <option value="<?php echo $objEventparentcategory->f('category_id');?>" <?php if($_REQUEST['event_categories_cal']==$objEventparentcategory->f('category_id')) {?> selected="selected"<?php } ?>><?php echo stripslashes($objEventparentcategory->f('category_name'));?>
               
                </option>
                <?php
                }
                ?>
            </select>
             </div>

			<div class="styled_select" style="height: 32px;">
            <select name="event_county_cal" id="event_county_cal"  style="width: 180px;" onChange="getCityCal(this.value);">
            <option value=""><?=DROPDOWN_ALL_EVENT_COUNTY?></option>
            <?php
            $objEventCounty->allEventCountyList();
            while($row = $objEventCounty->next_record())
            {
            ?>
            <option value="<?php echo $objEventCounty->f('id');?>" <?php if($event_county_cal==$objEventCounty->f('id')){?> selected="selected"<?php } ?>><?php echo stripslashes($objEventCounty->f('county_name'));?></option>
            <?php
            }
            ?>
            </select></div>
            
            <div id="loadCityDivCal">
			<div class="styled_select" style="height: 32px;">
             <select name="event_cities_cal" id="event_cities_cal" style="width: 180px;" onChange="getVenueCal(this.value);" >
            <option value=""><?=DROPDOWN_ALL_EVENT_CITIES?></option>
            <?php
            $objEventCity->allCityList();
            while($row = $objEventCity->next_record())
            {
            ?>
            <option value="<?php echo $objEventCity->f('id');?>" <?php if($_REQUEST['event_cities_cal']==$objEventCity->f('id')){ ?> selected="selected"<?php } ?>><?php echo stripslashes($objEventCity->f('city_name'))?></option>
            <?php
            }
            ?>
            </select></div></div>
			
            <div id="loadVenueDivCal">
			<div class="styled_select" style="height: 32px;">
             <select name="event_venues_cal" id="event_venues_cal" style="width: 180px;">
            <option value=""><?=DROPDOWN_ALL_EVENT_VENUES?></option>
            <?php
            $objEventVenue->allVenueList();
            while($row = $objEventVenue->next_record())
            {
            ?>
            <option value="<?php echo stripslashes($objEventVenue->f('venue_id'));?>" <?php if($event_venues_cal==$objEventVenue->f('venue_id')){ ?> selected="selected"<?php } ?>><?php echo stripslashes($objEventVenue->f('venue_name'));?></option>
            <?php
            }
            ?>
            </select></div>
			</div>

			
            <div class="input_box" style="margin: 4px 0 5px 0; float: right;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png" border="0" onClick="showCal()" style="vertical-align: top;" /></div>
            </div>                
            <div class="clear"></div>
             <div>
                <div id='calendar'></div>
             </div>   
            <div class="clear"></div>
            <div id="rec_id"><?=RECURRING_EVENTS?></div>
            
            <div class="drop_box_<?php echo $_SESSION['langSessId']?>" style="overflow: hidden;border: 1px solid #e4e4e4;border-radius: 5px;padding: 5px 5px 0 5px; margin:20px 0 10px 0;">
             <div class="styled_select" style="height: 32px;">
              <select name="event_categories_cal_rec" id="event_categories_cal_rec" style="width: 180px;">
                <option value=""><?=DROPDOWN_ALL_EVENT_CATEGORIES?></option>
                <?php
                $objEventparentcategory->allEventParentCategoryList();
                while($row = $objEventparentcategory->next_record())
                {
                ?>
                <option value="<?php echo $objEventparentcategory->f('category_id');?>" <?php if($_REQUEST['event_categories_cal_rec']==$objEventparentcategory->f('category_id')) {?> selected="selected" <?php } ?>><?php echo stripslashes($objEventparentcategory->f('category_name'));?>
              
                </option>
                <?php
                }
                ?>
                </select></div>

			<div class="styled_select" style="height: 32px;">
            <select name="event_county_cal_rec" id="event_county_cal_rec"  style="width: 180px;" onChange="getCityCal_rec(this.value);">
            <option value=""><?=DROPDOWN_ALL_EVENT_COUNTY?></option>
            <?php
            $objEventCounty->allEventCountyList();
            while($row = $objEventCounty->next_record())
            {
            ?>
            <option value="<?php echo $objEventCounty->f('id');?>" <?php if($event_county_cal_rec==$objEventCounty->f('id')){?> selected="selected"<?php } ?>><?php echo stripslashes($objEventCounty->f('county_name'));?></option>
            <?php
            }
            ?>
            </select></div>
            
            <div id="loadCityDivCal_rec">
			<div class="styled_select" style="height: 32px;">
             <select name="event_cities_cal_rec" id="event_cities_cal_rec" style="width: 180px;" onChange="getVenueCal_rec(this.value)">
            <option value=""><?=DROPDOWN_ALL_EVENT_CITIES?></option>
            <?php
            $objEventCity->allCityList();
            while($row = $objEventCity->next_record())
            {
            ?>
            <option value="<?php echo $objEventCity->f('id');?>" <?php if($_REQUEST['event_cities_cal_rec']==$objEventCity->f('id')){ ?> selected="selected"<?php } ?>><?php echo stripslashes($objEventCity->f('city_name'));?></option>
            <?php
            }
            ?>
            </select></div></div>
			
            <div id="loadVenueDivCal_rec">
			<div class="styled_select" style="height: 32px;">
             <select name="event_venues_cal_rec" id="event_venues_cal_rec" style="width: 180px;">
            <option value=""><?=DROPDOWN_ALL_EVENT_VENUES?></option>
            <?php
            $objEventVenue->allVenueList();
            while($row = $objEventVenue->next_record())
            {
            ?>
            <option value="<?php echo stripslashes($objEventVenue->f('venue_id'));?>" <?php if($event_venues_cal_rec==$objEventVenue->f('venue_id')){ ?> selected="selected"<?php } ?>><?php echo stripslashes($objEventVenue->f('venue_name'));?></option>
            <?php
            }
            ?>
            </select></div>
			</div>

			
            <div class="input_box" style="margin: 4px 0 5px 0; float: right;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png" border="0" onClick="showCal_rec()" style="vertical-align: top;" /></div>
            </div>
            <div class="clear"></div>
             <div>
                <div id='calendar1'></div>
             </div>   
            </div>
        </div>
        <div class="clear"></div>
        <div class="hotevent_box">
           <div class="heading"><?=SECTION2?></div>
           <div class="hot_events" style="position: relative;">
               <div id="go-prev1" style=" margin: 0; top: 54px; left: 0; position: absolute;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/arrow_left.png" /></div> 
               <div id="go-next1" style=" margin: 0; top: 54px; right: 0; position: absolute;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/arrow_right.png" /></div> 
                <ul id="slider1" style="padding-left:2px; padding: 0; width: 580px; height: 140px; overflow: hidden;">
                <?php
				if($objEventpic1->num_rows()){
					while($objEventpic1->next_record()){
						if($objEventpic1->f('event_photo')!=""){
            ?>
                    <li style="border: 1px solid #CCCCCC; margin: 0 4px; width: 170px;"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objEventpic1->f('event_photo');?>" width="160" height="126" /></li>
            <?php 
						}
					}
				}
				else{
			?>
                  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic1.jpg" width="190" height="143" /></li>
                  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic2.jpg" width="190" height="143"/></li> 
                  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic3.jpg" width="190" height="143"/></li>
                  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/wpic.jpg" width="190" height="143"/></li>
            <?php 
				}
			?>
               </ul>    
            </div>
            <div class="clear"></div>
            <div class="show_box">
              <?php /*?><div class="show_txt">
                <p id="divRecurrent"><?php if($objSettings->f('show_weekly_recurring_events')=='1') { ?><a href="recurring_events.php"><?php } ?><?=show_weekly_recurring_events;?><?php if($objSettings->f('show_weekly_recurring_events')=='1') { ?></a><?php } ?></p>
                <p><input name="weekly_recurring_events" id="weekly_recurring_events" type="checkbox" value="1" <?php if($objSettings->f('show_weekly_recurring_events')=='1') { echo 'checked'; } ?> onclick="checkRecurring();" /><?=Show_all_events_checkbox?></p></div><?php */?>
              <div class="like_box" style=" margin: 0 ;">
               <table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                  <tr>
                    <td><div class="like_textbox bg1"><input name="" type="text" value="104" /></div></td>
                    <td><div class="like_textbox bg2">
                      <input name="Input" type="text" value="75" />
                    </div></td>
                    <td><div class="like_textbox bg3"><input name="" type="text" value="4" /></div></td>
                    <td><div class="like_textbox bg4"><input name="" type="text" value="2" /></div></td>
                    <td><div class="like_textbox bg5"><input name="" type="text" value="2054" /></div></td>
                  </tr>
                  <tr>
                    <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img1.gif" border="0" /></a></td>
                    <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img2.gif" border="0" /></a></td>
                    <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img3.gif" border="0" /></a></td>
                    <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img4.gif" border="0" /></a></td>
                    <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img5.gif" border="0" /></a></td>
                  </tr>
                </table>	
              </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="search_bar">
            <div class="input_box_<?php echo $_SESSION['langSessId']?>"><?=KEYWORDS?>: <input name="key_word" id="key_word" value="<?php echo $_REQUEST['key_word'];?>" type="text" style="width: 200px;" />
                <div id="key_word_err" style="color:#F00;"></div>
            </div>
            <div style=" float: right; margin: 0 47px 0 0;">
            <div class="input_box_<?php echo $_SESSION['langSessId']?>"><?=BETWEEN?>: <input name="from_date" id="from_date" value="<?php echo $start_val_date;?>" type="text" />
                <div id="from_err" style="color:#F00;"></div>
            </div>
            <div class="input_box_<?php echo $_SESSION['langSessId']?>"><?=S_AND?> <input name="to_date" id="to_date" value="<?php echo $end_val_date;?>" type="text" />
                <div id="to_err" style="color:#F00;"></div>
            </div>
            </div>
            <!--<div class="input_box" style="margin: -5px 0 0 6px;">
                <img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon.png" border="0" onclick="eventByDate()" /></div>-->
        </div>
        <div class="clear"></div>
        <div class="party_base_box">
            <div class="drop_box">
                <div class="styled_select" style="height: 32px;">
                <select name="event_categories" id="event_categories" style="width: 180px;">
                <option value=""><?=DROPDOWN_ALL_EVENT_CATEGORIES?></option>
                <?php
                $objEventparentcategory->allEventParentCategoryList();
                while($row = $objEventparentcategory->next_record())
                {
                ?>
                <option value="<?php echo $objEventparentcategory->f('category_id');?>" <?php if($_REQUEST['event_categories']==$objEventparentcategory->f('category_id')) {?> selected="selected" <?php } ?>><?php echo stripslashes($objEventparentcategory->f('category_name'));?>
               
                </option>
                <?php
                }
                ?>
                </select></div>
                
                <div class="styled_select" style="height: 32px;">
                <select name="event_county" id="event_county"  style="width: 180px;" onChange="getCity(this.value);">
                <option value=""><?=DROPDOWN_ALL_EVENT_COUNTY?></option>
                <?php
                $objEventCounty->allEventCountyList();
                while($row = $objEventCounty->next_record())
                {
                ?>
                <option value="<?php echo $objEventCounty->f('id');?>" <?php if($_REQUEST['county_val']==$objEventCounty->f('id')) {?> selected="selected" <?php } ?>><?php echo stripslashes($objEventCounty->f('county_name'));?></option>
                <?php
                }
                ?>
                </select></div>
                
                <div id="loadCityDiv">
                <div class="styled_select" style="height: 32px; z-index:0">
                <select name="event_cities" id="event_cities" style="width: 180px;">
                <option value=""><?=DROPDOWN_ALL_EVENT_CITIES?></option>
                <?php
                $objEventCity->allCityList();
                while($row = $objEventCity->next_record())
                {
                ?>
                <option value="<?php echo stripslashes($objEventCity->f('id'));?>" <?php if($_REQUEST['evn_city']==$objEventCity->f('id')){ ?> selected="selected" <?php } ?>><?php echo stripslashes($objEventCity->f('city_name'));?></option>
                <?php
                }
                ?>
                </select></div>
                </div>
                
                <div id="loadVenueDiv">
                <div class="styled_select" style="height: 32px; z-index:0">
                <select name="event_venues" id="event_venues" style="width: 180px;">
                <option value=""><?=DROPDOWN_ALL_EVENT_VENUES?></option>
                <?php
                $objEventVenue->allVenueList();
                while($row = $objEventVenue->next_record())
                {
                ?>
                <option value="<?php echo stripslashes($objEventVenue->f('venue_id'));?>" <?php if($_REQUEST['evn_venue']==$objEventVenue->f('venue_id')){ ?> selected="selected" <?php } ?>><?php echo stripslashes($objEventVenue->f('venue_name'));?></option>
                <?php
                }
                ?>
                </select></div>
                </div>
                <div class="input_box" style="margin: 0px 0 0 6px;">
                <img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon.png" border="0" onClick="eventByDate()" /></div>
            </div>
            <div class="clear"></div>
            <div class="party_viewbox" id="comment">
            <?php           
				// Null val
				$tags = '';
				$category = '';
				$evn_city = '';
				$evn_venue = '';
				$start_date = '';
				$end_date = '';
				$county_val = '';
				$event_categories = '';
				
				$items = $objSettings->f('event_show_number');
				//$items = 5;
				$page = 1;
						
				if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1){
					$limit = " LIMIT ".(($page-1)*$items).",$items";
					$i = $items*($page-1)+1;
				}
				else{
					$limit = " LIMIT $items";
					$i = 1;
				}
				
				if($_REQUEST['tags']){
					$tags = $_REQUEST['tags'];
				}
				
				if($_REQUEST['category']){
					$category = $_REQUEST['category'];
				}
				
				if($_REQUEST['evn_city']){
					$evn_city = $_REQUEST['evn_city'];
				}
				
				if($_REQUEST['evn_venue']){
					$evn_venue = $_REQUEST['evn_venue'];
				}
				if($_REQUEST['start_date']){
					$start_date = $_REQUEST['start_date'];
				}
				if($_REQUEST['end_date']){
					$end_date = $_REQUEST['end_date'];
				}
				if($_REQUEST['key_word']){
					$key_word = $_REQUEST['key_word'];
				}
				
				if($_REQUEST['county_val']){
					$county_val = $_REQUEST['county_val'];
				}
				if($_REQUEST['event_categories']){
					$event_categories = $_REQUEST['event_categories'];
				}
				
				$arr = array();
				$arr1 = array();
				$arr2 = array();
				
				//echo $_REQUEST['evn_city'];
				$objEvent->EventAll($limit,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories);
				$objEvent_num->EventAll_num($tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories);
				$num = $objEvent_num->num_rows();
				$num = 10;
				while($objEvent->next_record()){
					
					$arr[] = array('id'=>$objEvent->f('id'),'event_name_en'=>$objEvent->f('event_name_en'),'event_name_sp'=>$objEvent->f('event_name_sp'),'event_photo'=>$objEvent->f('event_photo'),'multi_start'=>$objEvent->f('event_start_date_time'),'multi_end'=>$objEvent->f('event_end_date_time'),'event_details_sp'=>$objEvent->f('event_details_sp'),'event_details_en'=>$objEvent->f('event_details_en'),'multi_id'=>'','identical_function'=>$objEvent->f('identical_function'),'event_short_desc_en'=>$objEvent->f('event_short_desc_en'),'event_short_desc_sp'=>$objEvent->f('event_short_desc_sp'),'sub_events'=>'','sub_events_types'=>$objEvent->f('sub_events'));
				}
				
				$objmulti_event->MultiEventAll($limit,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories);
					
				while($objmulti_event->next_record()){
				
					$arr1[] = array('id'=>$objmulti_event->f('id'),'event_name_en'=>$objmulti_event->f('event_name_en'),'event_name_sp'=>$objmulti_event->f('event_name_sp'),'event_photo'=>$objmulti_event->f('event_photo'),'multi_start'=>$objmulti_event->f('event_start_date_time'),'multi_end'=>$objmulti_event->f('multi_end'),'event_details_sp'=>$objmulti_event->f('event_details_sp'),'event_details_en'=>$objmulti_event->f('event_details_en'),'multi_id'=>$objmulti_event->f('multi_id'),'identical_function'=>'','event_short_desc_en'=>$objmulti_event->f('event_short_desc_en'),'event_short_desc_sp'=>$objmulti_event->f('event_short_desc_sp'),'sub_events'=>'','sub_events_types'=>'');
				}	
				
				$objsubEventAll->SubEventAll('',$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories);
					
				while($objsubEventAll->next_record()){
				
					$arr2[] = array('id'=>$objsubEventAll->f('id'),'event_name_en'=>$objsubEventAll->f('eve_name_en'),'event_name_sp'=>$objsubEventAll->f('eve_name_sp'),'event_photo'=>$objsubEventAll->f('event_photo'),'multi_start'=>$objsubEventAll->f('event_start_date_time'),'multi_end'=>$objsubEventAll->f('multi_end'),'event_details_sp'=>$objmulti_event->f('event_details_sp'),'event_details_en'=>$objsubEventAll->f('event_details_en'),'multi_id'=>$objsubEventAll->f('multi_id'),'identical_function'=>'','event_short_desc_en'=>$objsubEventAll->f('event_short_desc_en'),'event_short_desc_sp'=>$objsubEventAll->f('event_short_desc_sp'),'sub_events'=>$objsubEventAll->f('sub_event_id'),'sub_events_types'=>'');
				}	
				
				$allData = array_merge($arr,$arr1,$arr2);
				
				
				function sortFunction( $a, $b ) {
					return strtotime($a["multi_start"]) - strtotime($b["multi_start"]);
				}
				usort($allData, "sortFunction");
				
				
				//echo "<pre>";print_r($arr2);exit;
				//echo "<pre>";print_r($allData);//exit;
				
				$target=$obj_base_path->base_path()."/index.php";
				if($num>0)
				{
					$p = new pagination;
					$p->Items($num);
					$p->limit($items);
					$p->target($target);
					$p->currentPage($page);
					$p->calculate();
					$p->changeClass("pagination");
					$i=0;
					$j=0;
					$k_sub = $k=0;
					
					//echo "<pre>";
					//print_r($arr2);
					
					foreach($allData as $eachVal)
					{
						
						//print_r($eachVal['event_details_en']);
						list($event_date,$event_time) = explode(" ",$eachVal['multi_start']);
						list($event_date_end,$event_time_end) = explode(" ",$eachVal['multi_end']);
				
						//print_r($eachVal['multi_start']);//exit;
						
						$row[$i] = $event_date;
						
						// Ticket Info
						$obj_min_ticket_cost->min_ticket_cost_perEvent($eachVal['id']);
						$obj_min_ticket_cost->next_record();
						
						//if($eachVal['multi_id']=="")
						{
						   // Venue City Details
							$obj_venue->venue_details_eventId($eachVal['id']);
							$obj_venue->next_record();
						}
						/*else
						{
						   // Venue City Details
							$obj_venue->venue_details_multi_eventId($eachVal['multi_id']);
							$obj_venue->next_record();
						}*/
						
						// Check Number of Tickets
						$objnum_ticket->count_num_ticket($eachVal['id']);
						
					
					if($eachVal['multi_id']!="" || $eachVal['identical_function']==1)
					{
						//echo "<pre>";
						//print_r($row1);
						
						$row1[$k]['multi_event_date'] = $event_date;
						$row1[$k]['city'] = $obj_venue->f('city');
						$row1[$k]['venue_name'] = $obj_venue->f('venue_name');
						$row1[$k]['id'] = $eachVal['id'];
						//echo $k."===".$row1[$k]['multi_event_date']."----".$row1[$k-1]['multi_event_date']."== id =".$row1[$k]['id']."-----".$row1[$k-1]['id']."<br>";
				
						if(($row1[$k]['multi_event_date']!=$row1[$k-1]['multi_event_date']) || ($row1[$k]['id']!=$row1[$k-1]['id'])){
						
							$date2 = date('Y-m-d',strtotime($row1[$k]['multi_event_date']. "+1 day"));
							$objmul_date->multi_event_datewise_index($eachVal['id'],$row1[$k]['multi_event_date'],$date2);
					
						
				?>
				<div class="party_box" style="width: 678px;">
					<?php
							 if($i!=0)
							 {
								if($row[$i]!=$row[$i-1])
								{	
								echo ' <div class="date">'	;			
						
								echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
								echo ' </div>';
								}
							}
							else
							{
								echo ' <div class="date">'	;
								echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
								echo ' </div>';
							}
					?>
						<div class="party_details_box">
							<div class="box1" style="height: auto;">
								<p><?php echo $obj_venue->f('city');?></p>
								<p class="sub" style="font:10px/12px !important;"><a style="color:#056A86" href="<?php echo $obj_base_path->base_path(); ?>/venue/<?php echo $obj_venue->f('venue_id');?>"><strong><?php if($_SESSION['langSessId']=='eng') { echo substr($obj_venue->f('venue_name'),0,40); } else { echo substr($obj_venue->f('venue_name_sp'),0,40); };?></strong></a></p>
								<!--<p><?php //echo "aa ".date('g:i A',strtotime($event_time)); ?> - <?php //echo date('g:i A',strtotime($event_time_end)); ?></p>-->
				
								
								<?php
								
								
								if($objmul_date->num_rows()){
									$s=0;
									$cityData = '';
									$venueData = '';
									while($objmul_date->next_record()){
										
										//echo $objmul_date->f('multi_id')."==".$eachVal['multi_id']."<br>";
										//if($objmul_date->f('multi_id')==$eachVal['multi_id']){
										//	continue;
										//}
										//else{
										//echo $objmul_date->f('multi_start_time');
											list($new_date,$new_time) = explode(" ",$objmul_date->f('multi_start_time'));
											list($new_date_end,$new_time_end) = explode(" ",$objmul_date->f('multi_end_time'));
											
											//echo $row1[$k]['city']."==".$objmul_date->f('city_name')."<br>";
											
											if($row1[$k]['city']!=$objmul_date->f('city_name') && !in_array($objmul_date->f('city_name'),$cityData))
												echo '<p>'.$objmul_date->f('city_name').'</p>';
											if($row1[$k]['venue_name']!=$objmul_date->f('venue_name') && !in_array($objmul_date->f('venue_name'),$venueData))
												echo '<p>'.$objmul_date->f('venue_name').'</p>';
				
												echo '<p>'.date('g:i A',strtotime($new_time))." - ".date('g:i A',strtotime($new_time_end)).'</p>';
				
											$cityData[] = $objmul_date->f('city_name');
											$venueData[] = $objmul_date->f('venue_name');
				
											}
											$s++;
										//}
									}
									?>
								
								
								
								
							</div>
							
							<?php
							$objmul_id=new user;
							$objmul_id->multi_id_first($eachVal['id'],$event_date);
							$objmul_id->next_record();
							//echo "<pre>";
							//print_r($objmul_id);
							?>
							
							<div class="box2">
							<div class="heading" style="padding-right: 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/eventPage/<?php echo $eachVal['id'];?>/<?php echo $objmul_id->f('multi_id');?>" ><?php if($_SESSION['langSessId']=='eng') { if(strlen($eachVal['event_name_en'])>45) echo substr(stripslashes($eachVal['event_name_en']),0,45)."..."; else echo stripslashes($eachVal['event_name_en']); } else { if(strlen($eachVal['event_name_sp'])>45) echo substr(stripslashes($eachVal['event_name_sp']),0,45)."..."; else echo stripslashes($eachVal['event_name_sp']);}?></a></div>

							<div class="clear"></div>
							<p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" >
								<?php 
									if($_SESSION['langSessId']=='eng') 
									{ 
										if($eachVal['event_short_desc_en']!="")
											echo strip_tags($eachVal['event_short_desc_en']); 
										else
											echo substr(strip_tags($eachVal['event_details_en']),0,160)."..."; 
											
									} 
									else 
									{ 
										if($eachVal['event_short_desc_sp']!="")
											echo strip_tags($eachVal['event_short_desc_sp']);
										else
											echo substr(strip_tags($eachVal['event_details_sp']),0,160)."..."; 
									}
								?>
                                                        </a></p>
							</div>

							<?php  
							if($obj_min_ticket_cost->f('price_us')!="" || $obj_min_ticket_cost->f('price_mx')!=""){
						?>
					  <div class="box3">
						<?php /*?><div class="imgbox">
							<?php if($eachVal['event_photo']==""){ ?>
							<a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_img.gif" border="0" width="71" height="78" /></a>
							<?php } else { ?>
							<a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $eachVal['event_photo'];?>" border="0" width="71" height="78" /></a>
							<?php } ?>
						</div><?php */?>
						<div class="txtbox">
						<?php if($objnum_ticket->num_rows() > 1) { echo FROM; }?>
						
						  <?php  
							if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!="" && $obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!=""){
						  ?>
<!--						  <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></span></a></p>  -->
						  <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?><br>US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p>  
						  <?php 
							} else if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!=""){
						  ?>
						<p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p>
                                              <?php } else if($obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!="") { ?><p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;"><br>MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></a></p><?php } ?>
						 
						</div>
					  </div>
					  <?php 
							}
							?>
						</div>
					
				</div>
				
				<?php
						}
						$k++;
					}
					else if($eachVal['sub_events']!="")
					{
						$row2[$k_sub]['multi_event_date'] = $event_date;
						$row2[$k_sub]['city'] = $obj_venue->f('city');
						$row2[$k_sub]['venue_name'] = $obj_venue->f('venue_name');
						$row2[$k_sub]['id'] = $eachVal['id'];
						
						//echo "<br>###########".$k_sub."###".$row2[$k_sub]['id']."#######<br>";
						//echo "<br>###########".($k_sub-1)."###".$row2[$k_sub-1]['id']."#######<br>";

						$objsub_eve->sub_event($eachVal['id']);
						if($objsub_eve->num_rows()){
							$obj_subeve_fst_tm->get_first_sub_eve_tm($eachVal['id']);
							$obj_subeve_fst_tm->next_record();
							list($first_eve_date,$first_eve_time) = explode(" ",$obj_subeve_fst_tm->f('event_start_date_time'));
							
							$obj_subeve_lst_tm->get_last_sub_eve_tm($eachVal['id']);
							$obj_subeve_lst_tm->next_record();
							list($last_eve_date,$last_eve_time) = explode(" ",$obj_subeve_lst_tm->f('event_end_date_time'));
						}

						//echo $k_sub."===".$row2[$k_sub]['multi_event_date']."----".$row2[$k_sub-1]['multi_event_date']."== id =".$row2[$k_sub]['id']."-----" .$row2[$k_sub-1]['id']."<br>";
				
						if(($row2[$k_sub]['multi_event_date']!=$row2[$k_sub-1]['multi_event_date']) || ($row2[$k_sub]['id']!=$row2[$k_sub-1]['id']))
						{
						
							$date_sub = date('Y-m-d',strtotime($row2[$k_sub]['multi_event_date']. "+1 day"));
							$objsub_date->subevent_datewise($eachVal['id'],$row2[$k_sub]['multi_event_date'],$date_sub);
							$sub_new = new user;
							$sub_new->subevent_datewise($eachVal['id'],$row2[$k_sub]['multi_event_date'],$date_sub);
							$sub_new2 = new user;
							$sub_new2->subevent_datewise2($eachVal['id'],$row2[$k_sub]['multi_event_date'],$date_sub);
						
				?>
					<div class="party_box" style="width: 678px;">
					<?php
						 if($i!=0)
						 {
							if($row[$i]!=$row[$i-1])
							{	
							echo ' <div class="date">'	;			
					
							echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
							echo ' </div>';
							}
						}
						else
						{
							echo ' <div class="date">'	;
							echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
							echo ' </div>';
						}
					?>
						<div class="party_details_box">
							<div class="box1">
								
								<p><?php echo $obj_venue->f('city');?></p>
								
								<p class="sub" style="font:10px/12px !important;"><a style="color:#056A86" href="<?php echo $obj_base_path->base_path(); ?>/venue/<?php echo $obj_venue->f('venue_id');?>"><strong><?php if($_SESSION['langSessId']=='eng') { echo substr($obj_venue->f('venue_name'),0,40); } else { echo substr($obj_venue->f('venue_name_sp'),0,40); };?></strong></a></p>
								<?php $sub_new->next_record();
								      $sub_new2->next_record();
								      //echo $objsub_date->f('event_start_date_time');
								      list($sub_event_date,$sub_event_time) = explode(" ",$sub_new->f('event_start_date_time'));
								      list($sub_event_end_date,$sub_event_end_time) = explode(" ",$sub_new2->f('event_end_date_time'));?>
								      
								<p><?php echo date('g:i A',strtotime($sub_event_time)); ?> - <?php echo date('g:i A',strtotime($sub_event_end_time)); ?></p>
							</div>
							<div class="box2">
							
							<div class="heading09_head"><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" >
							<?php if($_SESSION['langSessId']=='eng') { if(strlen($eachVal['event_name_en'])>45) echo substr(stripslashes($eachVal['event_name_en']),0,45)."..."; else echo stripslashes($eachVal['event_name_en']); } else { if(strlen($eachVal['event_name_sp'])>45) echo substr(stripslashes($eachVal['event_name_sp']),0,45)."..."; else echo stripslashes($eachVal['event_name_sp']);}?></a></div>
                            
                            <?php 
							if($objsub_date->num_rows()){
								$cnt = 0;
								while($objsub_date->next_record()){
									list($sub_event_date,$sub_event_time) = explode(" ",$objsub_date->f('event_start_date_time'));
							?>
							<div class="heading09">
                                <span style="margin:0px;"><?php echo date('g:i A',strtotime($sub_event_time));?></span>
                            	<a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" ><?php if($_SESSION['langSessId']=='eng') { if(strlen($objsub_date->f('sub_eve_en'))>45) echo substr(stripslashes($objsub_date->f('sub_eve_en')),0,45)."..."; else echo stripslashes($objsub_date->f('sub_eve_en')); } else { if(strlen($objsub_date->f('sub_eve_sp'))>45) echo substr(stripslashes($objsub_date->f('sub_eve_sp')),0,45)."..."; else echo stripslashes($objsub_date->f('sub_eve_sp'));}?></a>
                            
							<div class="clear"></div>
							<?php if($cnt==14){?><p>more</p><?php } ?></div>
                            <?php
									$cnt++;
								}
							}
							?>
                            
							</div>
							<?php  
							if($obj_min_ticket_cost->f('price_us')!="" || $obj_min_ticket_cost->f('price_mx')!=""){
						?>
					  <div class="box3">
						<?php /*?><div class="imgbox">
							<?php if($eachVal['event_photo']==""){ ?>
							<a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_img.gif" border="0" width="71" height="78" /></a>
							<?php } else { ?>
							<a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $eachVal['event_photo'];?>" border="0" width="71" height="78" /></a>
							<?php } ?>
						</div><?php */?>
						<div class="txtbox">
						<?php if($objnum_ticket->num_rows() > 1) { echo FROM; }?>
						
						  <?php  
							if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!="" && $obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!=""){
						  ?>
<!--						  <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></span></a></p> -->
						  <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?><br>US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p>  

						  <?php 
							} else if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!=""){
						  ?>
						<p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p><?php } else if($obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!="") { ?><p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></a></p><?php } ?>
						 
						</div>
					  </div>
					  <?php 
							}
							?>
						</div>
					
				</div>
				
				<?php
						}
						$k_sub++;
					}	// End of sub-events
					else{
						
						// check if the event has program or not
						if($eachVal['sub_events_types']==1)
						{
							$checkSub->sub_event($eachVal['id']);
							if($checkSub->num_rows())
								continue;
						}
						//echo "non-sub".$event_date."-----".$eachVal['id']."-----<br>";
				?>
				
				<div class="party_box" style="width: 678px;">
					<?php 
						 if($i!=0)
						 {
							if($row[$i]!=$row[$i-1])
							{	
							echo ' <div class="date">'	;			
					
							echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
							echo ' </div>';
							}
						}
						else
						{
							echo ' <div class="date">'	;
							echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));
							echo ' </div>';
						}
					?>
						<div class="party_details_box">
							<div class="box1">
								<p><?php echo $obj_venue->f('city');?></p>
								<p class="sub" style="font:10px/12px !important;"><a style="color:#056A86;" href="<?php echo $obj_base_path->base_path(); ?>/venue/<?php echo $obj_venue->f('venue_id');?>"><?php if($_SESSION['langSessId']=='eng') { echo substr($obj_venue->f('venue_name'),0,40); } else { echo substr($obj_venue->f('venue_name_sp'),0,40); };?></a></p>
								<p><?php echo date('g:i A',strtotime($event_time)); ?> - <?php echo date('g:i A',strtotime($event_time_end)); ?></p>
								<?php /*?><p><?php echo $obj_venue->f('venue_address');?></p><?php */?>
							</div>
                            
                            <div class="box2">
							<div class="heading" style="padding-right: 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" >
							<?php if($_SESSION['langSessId']=='eng') { if(strlen($eachVal['event_name_en'])>45) echo substr(stripslashes($eachVal['event_name_en']),0,45)."..."; else echo stripslashes($eachVal['event_name_en']); } else { if(strlen($eachVal['event_name_sp'])>45) echo substr(stripslashes($eachVal['event_name_sp']),0,45)."..."; else echo stripslashes($eachVal['event_name_sp']);}?></a></div>
							<div class="clear"></div>
							<p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>">
								<?php 
									if($_SESSION['langSessId']=='eng') 
									{ 
										if($eachVal['event_short_desc_en']!="")
											echo strip_tags($eachVal['event_short_desc_en']); 
										else
											echo substr(strip_tags($eachVal['event_details_en']),0,160)."..."; 
											
									} 
									else 
									{ 
										if($eachVal['event_short_desc_sp']!="")
											echo strip_tags($eachVal['event_short_desc_sp']);
										else
											echo substr(strip_tags($eachVal['event_details_sp']),0,160)."..."; 
									}
								?>
                             </a></p>
                            
							</div>
                            
							<?php  
							if($obj_min_ticket_cost->f('price_us')!="" || $obj_min_ticket_cost->f('price_mx')!=""){
						?>
                          <div class="box3">
                           <?php /*?> <div class="imgbox">
                                <?php if($eachVal['event_photo']==""){ ?>
                                <a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_img.gif" border="0" width="71" height="78" /></a>
                                <?php } else { ?>
                                <a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $eachVal['event_photo'];?>" border="0" width="71" height="78" /></a>
                                <?php } ?>
                            </div><?php */?>
                            <div class="txtbox">
                            <?php if($objnum_ticket->num_rows() > 1) { echo FROM; }?>
                            
                              <?php  
                                if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!="" && $obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!=""){
                              ?>
<!--                              <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></span></a></p> -->
			          <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?><br>US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p>  
                              <?php 
                                } else if($obj_min_ticket_cost->f('price_us')!="0.00" && $obj_min_ticket_cost->f('price_us')!=""){
                              ?>
                            <p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'),2); ?> </a></p><?php } else if($obj_min_ticket_cost->f('price_mx')!="0.00" && $obj_min_ticket_cost->f('price_mx')!="") { ?><p><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $eachVal['id'];?>" style="color:#FFFFFF;">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'),2); ?></a></p><?php } ?>
                             
                            </div>
                          </div>
					  <?php 
							}
							?>
						</div>
					
				 </div>
				<?php
					}
					$i++;
					}
				?>
				<div class="party_box">
					<?php $p->show();?>
				</div> 
				<?php
				}
				?>
                
            <div class="clear"></div>
            <div class="page_box">
                <div class="like_box">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                      <tr>
                        <td><div class="like_textbox bg1"><input name="" type="text" value="104" /></div></td>
                        <td><div class="like_textbox bg2"><input name="" type="text" value="75" /></div></td>
                        <td><div class="like_textbox bg3"><input name="" type="text" value="4" /></div></td>
                        <td><div class="like_textbox bg4"><input name="" type="text" value="2" /></div></td>
                        <td><div class="like_textbox bg5"><input name="" type="text" value="2054" /></div></td>
                      </tr>
                      <tr>
                        <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img1.gif" border="0" /></a></td>
                        <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img2.gif" border="0" /></a></td>
                        <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img3.gif" border="0" /></a></td>
                        <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img4.gif" border="0" /></a></td>
                        <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img5.gif" border="0" /></a></td>
                      </tr>
                    </table>	
                </div>
            </div>
            <div class="clear"></div>
            <div class="comment_box">
                <h3><?=COMMENTS?></h3>
                <textarea name="" cols="" rows="" class="comment_field"><?=ENTER_YOUR_COMMENT?></textarea>
            </div>
            </div>
        </div>
        <div class="clear"></div>
     </div>
     <?php include("include/frontend_rightsidebar.php");?>
     
    <div class="left_panel addbox">
        <div class="add1"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add1.gif" border="0" /></a></div>
    </div>
  </div>
  <div class="clear"></div>
 </div>
 <div class="clear"></div>
    
<?php include("include/frontend_footer.php");?>

</div>
<script>
<?php
if($_REQUEST['event_county_cal_rec']!="" || $_REQUEST['event_cities_cal_rec']!="" || $_REQUEST['event_venues_cal_rec']!="" || $_REQUEST['event_categories_cal_rec']!=""){
?>
$('html, body').animate({scrollTop: $("#rec_id").offset().top - 10}, 2000);

if('<?php echo $_REQUEST['event_cities_cal_rec'];?>'!="")
	getVenueCal_rec('<?php echo $_REQUEST['event_cities_cal_rec'];?>');
if('<?php echo $_REQUEST['event_county_cal_rec'];?>'!="")
	getCityCal_rec('<?php echo $_REQUEST['event_county_cal_rec'];?>');

<?php } ?>

<?php
if($_REQUEST['event_county_cal']!="" || $_REQUEST['event_cities_cal']!="" || $_REQUEST['event_venues_cal']!="" || $_REQUEST['event_categories_cal']!=""){
?>
$('html, body').animate({scrollTop: $("#tblbox").offset().top}, 2000);

if('<?php echo $_REQUEST['event_cities_cal'];?>'!="")
	getVenueCal('<?php echo $_REQUEST['event_cities_cal'];?>');
if('<?php echo $_REQUEST['event_county_cal'];?>'!="")
	getCityCal('<?php echo $_REQUEST['event_county_cal'];?>');

<?php } ?>

<?php
if( $_REQUEST['evn_city']!="" || $_REQUEST['evn_venue']!="" || $_REQUEST['start_date']!="" || $_REQUEST['end_date']!="" || $_REQUEST['key_word']!="" || $_REQUEST['county_val']!=""|| $_REQUEST['event_categories']!=""){
?>
$('html, body').animate({scrollTop: parseInt($("#comment").offset().top) + 350}, 2000);

getCity('<?php echo $_REQUEST['county_val'];?>');
getVenue('<?php echo $_REQUEST['evn_city'];?>');

<?php } ?>

</script>

</body>
</html>
