<?php
include('include/user_inc.php');
$event_id = $_REQUEST['event_id'];
$sub_id = $_REQUEST['sub_id'];
//echo $event_id; exit;

//create object
$objEvent=new user;
$objmulti_event=new user;
$objmul_date=new user;
$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;
$objsub_event=new user;
$obj_venue_sub=new user;

$obj_sub_ticket=new user;
$obj_sub_ticket_img=new user;

$obj_chk=new user;
$obj_cur_eve_dt=new user;

$obj_cart=new user;
$obj_count=new user;

$obj_expire=new user;

if($sub_id != ''){
$obj_chk->check_access($_REQUEST['sub_id']);
$obj_chk->next_record();
$access = $obj_chk->f('all_access');
}

// Event Details
$objEvent->getOrgEvent($event_id);
$objEvent->next_record();

$allData[1]['city'] = $objEvent->f('city_name');
$allData[1]['venue_name'] = $objEvent->f('venue_name');
$allData[1]['venue_name_sp'] = $objEvent->f('venue_name_sp');
$allData[1]['event_start_date_time'] = $objEvent->f('event_start_date_time');
$allData[1]['event_end_date_time'] = $objEvent->f('event_end_date_time');

// Check for Multi Function Event
$objmulti_event->multi_event($event_id);
$objsub_event->sub_event($event_id);

$l=2;
if($objmulti_event->num_rows()){
	while($objmulti_event->next_record()){ 

		$allData[$l]['multi_id'] = $objmulti_event->f('multi_id');
		$allData[$l]['city'] = $objmulti_event->f('city_name');
		$allData[$l]['venue_name'] = $objmulti_event->f('venue_name');
		$allData[$l]['venue_name_sp'] = $objmulti_event->f('venue_name_sp');
		$allData[$l]['event_start_date_time'] = $objmulti_event->f('multi_start_time');
		$allData[$l]['event_end_date_time'] = $objmulti_event->f('multi_end_time');
		$l++;
	}
}

if($objsub_event->num_rows()){
	while($objsub_event->next_record()){ 

		$allDataS[$l]['event_id'] = $objsub_event->f('event_id');
		$allDataS[$l]['parent_id'] = $objsub_event->f('parent_id');
		$allDataS[$l]['event_name_en'] = $objsub_event->f('event_name_en');
		$allDataS[$l]['event_name_sp'] = $objsub_event->f('event_name_sp');
		//$allData[$l]['city'] = $objsub_event->f('event_venue_city');
		//$allData[$l]['venue_name'] = $objsub_event->f('venue_name');
		//$allData[$l]['venue_name_sp'] = $objsub_event->f('venue_name_sp');
		$allDataS[$l]['event_start_date_time'] = $objsub_event->f('event_start_date_time');
		$allDataS[$l]['event_end_date_time'] = $objsub_event->f('event_end_date_time');
		$l++;
	}
}

//print_r($allData);




// Venue Details
$obj_venue->venue_details_eventId($event_id);
$obj_venue->next_record();


if($sub_id != ''){
$obj_venue_sub->venue_details_subId($sub_id);
$obj_venue_sub->next_record();
}

// Event Date

if($sub_id == ''){
list($event_date,$event_time) = explode(" ",$objEvent->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$objEvent->f('event_end_date_time'));
}
else
{
list($event_date,$event_time) = explode(" ",$obj_chk->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$obj_chk->f('event_end_date_time'));

}
// Get tickets by Event ID
$obj_ticket->getTicketById($event_id); 

$obj_ticket_img->getTicketById($event_id); 

//print_r($_SESSION);
//					********************************* imp *********************

/*if($_SESSION['ses_admin_id'] != ''){
	$obj_count->getCartCount($_SESSION['ses_admin_id']);
	if($obj_count->num_rows()>0){
		header("location: ".$obj_base_path->base_path()."/payment");
	}
}*/     
            
//					********************************* imp *********************

$_SESSION['cid'] = '';

if(isset($_POST['action']) && $_POST['action'] == 'cart')	
{
	//echo "success "; 
	/*echo $_POST['frm_event_id']."cvb ";
	echo $_POST['frm_multi_id']."cvbc ";
	echo $_POST['frm_count']."xxx ";*/
	$unique = time();
	for($i=1;$i<$_POST['frm_count'];$i++){
	/*echo $_POST['frm_ticket'.$i]." ";
	echo $_POST['frm_mx_price'.$i]." ";
	echo $_POST['frm_us_price'.$i]."<br>";*/
		if($_POST['frm_ticket'.$i] != ''){
			$cid[] = $obj_cart->add_to_cart($_POST['frm_event_id'],$_POST['frm_multi_id'],$_POST['frm_ticket'.$i],$_POST['frm_mx_price'.$i],$_POST['frm_us_price'.$i],$unique,$_POST['frm_us_tid'.$i],$_POST['frm_payment']);
		}
	}
	
	$_SESSION['unique'] = $unique;
	if($_SESSION['ses_admin_id'] == ''){
		$_SESSION['cid'] = $cid;
	}
	/*if($_SESSION['ses_admin_id'] == ''){
		$_SESSION['cid'] = $cid;
		$_SESSION['unique'] = $unique;
		$_SESSION['err'] = "Login to continue..";
		header("location: ".$obj_base_path->base_path()."/event/".$_POST['frm_event_id']."");
		exit;
	}
	else
	{*/
		//$_SESSION['cid'] = '';
		header("location: ".$obj_base_path->base_path()."/payment/".$_POST['frm_event_id']);
	//}
	/*print_r($cid);
	exit;*/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>
<script type="text/javascript">

$(document).ready(function() {
        
        //options( 1 - ON , 0 - OFF)
        var auto_slide = 0;
        var hover_pause = 1;
        var key_slide = 1;
        
        //speed of auto slide(
        var auto_slide_seconds = 500;
        /* IMPORTANT: i know the variable is called ...seconds but it's 
        in milliseconds ( multiplied with 1000) '*/
        
        /*move he last list item before the first item. The purpose of this is 
        if the user clicks to slide left he will be able to see the last item.*/
		
        //$('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        
        //check if auto sliding is enabled
        if(auto_slide == 1){
            /*set the interval (loop) to call function slide with option 'right' 
            and set the interval time to the variable we declared previously */
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            
            /*and change the value of our hidden field that hold info about
            the interval, setting it to the number of milliseconds we declared previously*/
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
  
        //check if hover pause is enabled
       /* if(hover_pause == 1){
            //when hovered over the list 
            $('#carousel_ul').hover(function(){
                //stop the interval
                clearInterval(timer)
            },function(){
                //and when mouseout start it again
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
  
        }*/
  
        //check if key sliding is enabled
        if(key_slide == 1){
            
            //binding keypress function
            $(document).bind('keypress', function(e) {
                //keyCode for left arrow is 37 and for right it's 39 '
                if(e.keyCode==37){
                        //initialize the slide to left function
                        slide('left');
                }else if(e.keyCode==39){
                        //initialize the slide to right function
                        slide('right');
                }
            });

        }
        
        
  });

//FUNCTIONS BELLOW

//slide function  
function slide(where){
    
            //get the item width
            var item_width = $('#carousel_ul li').outerWidth() + 500;
            
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/
            if(where == 'left'){
                //...calculating the new left indent of the unordered list (ul) for left sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
            }else{
                //...calculating the new left indent of the unordered list (ul) for right sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
            
            }
            
            
            //make the sliding effect using jQuery's animate function... '
            $('#carousel_ul:not(:animated)').animate({'left' : left_indent},0,function(){    
                
                /* when the animation finishes use the if statement again, and make an ilussion
                of infinity by changing place of last or first item*/
                if(where == 'left'){
                    //...and if it slided to left we put the last item before the first item
                    $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                }else{
                    //...and if it slided to right we put the first item after the last item
                    $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
                }
                
                //...and then just get back the default left indent
                $('#carousel_ul').css({'left' : '0px'});
            });
            
            
            
             
           
}
  
</script>

<script type="text/javascript">
function checkLoggedin(){
	<?php
		if($_SESSION['ses_admin_id']==""){
	?>
		$('html, body').animate({scrollTop: parseInt($("#text_email").offset().top) - 100}, 2000);
		$('#email_cell').focus();
	<?php
		} else{
	?>
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/checkSavedEvent.php",
		   cache: false,
		   type: "POST",
		   data: "event_id=<?php echo $event_id;?>",   
		   success: function(data){
			  // alert(data);
			   if(data==1){
				$('#alrdy_svd_evnt1').trigger('click');
			   }
			   else
			   {
		  	 	window.location = "<?php echo $obj_base_path->base_path(); ?>/add_saved_events.php?event_id=<?php echo $event_id;?>";
			   }
		   }
		 });
		
	<?php }?>
	
}

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#alrdy_svd_evnt1").fancybox({ 
			'hideOnOverlayClick':false,
			'hideOnContentClick':false,
			'onComplete': function(){
				setTimeout( function() {$.fancybox.close(); },2000); // 3000 = 3 secs
			  }
		});
	});
	
function setHover1(val,setDateTime,multi_id,event_id)
{
	//alert(multi_id);
	//alert(event_id);
	$("#frm_multi_id").val(multi_id);
	$("#frm_event_id").val(event_id);
	
	$('.abc').css({"color":"#FFFFFF","font-size":"12px","font-weight":"normal"});

	$('#tbl1'+val).css({"color":"red","font-size":"15px","font-weight":"bold"});
	$('.timetxt').html(setDateTime);
}

function addtocart(num,mx,us,tid,event_id)
{
	//alert(val)
	$("#frm_event_id").val(event_id);
	$("#frm_ticket"+num).val($("#ticket_num"+num).val());
	$("#frm_mx_price"+num).val(mx);
	$("#frm_us_price"+num).val(us);
	$("#frm_us_tid"+num).val(tid);
	$("#tick").val($("#ticket_num"+num).val());
	var a = $("#tick").val();
	var b = $("#tot").val();
	b=b+a;
	$("#tot").val(b);
}

function save(type){
	$("#frm_payment").val(type);
	//alert(type);
	//var aa = $("#frm_event_id").val();
	var aa = $("#frm_multi_id").val();
	var bb = $("#tick").val();
	//alert($("#is_multi").val());
	//alert(aa);
	//alert(bb);
	if($("#is_multi").val() == 1){
		if(aa == ''){
			alert("Select an event date and time!");
		}
		
		else if(bb == '' || bb == 0){
			alert("Select a ticket!");
		}
		else
		{
			$("#frm").submit();
		}
	}
	else
	{
		if(bb == ''){
			alert("Select a ticket!");
		}
		else
		{
			$("#frm").submit();
		}
	}
	
}
	
	
	</script>
<div style="display:none;">
    <div style="width:400px;height:auto; background:#FFF; padding:10px; font-size:19px;" id="alrdy_svd_evnt">
       You already saved this event.
    </div>
</div>
<a href="#alrdy_svd_evnt" id="alrdy_svd_evnt1"></a>

</head>
<body>
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg">
            
            <div style="text-align:center;"><?php if($_SESSION['err'] != ''){ echo $_SESSION['err']; unset($_SESSION['err']);}?></div>
            <div class="clear"></div>
            
            	<div class="cheese_box">
               	<div class="heading1"><?php 
				if($sub_id == ''){
				if($_SESSION['langSessId']=='eng') { echo substr(stripslashes($objEvent->f('event_name_en')),0,60); } else { echo substr(stripslashes($objEvent->f('event_name_sp')),0,60);}
				}
				else
				{
				if($_SESSION['langSessId']=='eng') { echo substr(stripslashes($obj_chk->f('event_name_en')),0,60); } else { echo substr(stripslashes($obj_chk->f('event_name_sp')),0,60);}
				}
				?>
<!--                	<span style="float: right; margin: 0 auto; padding: 0; width: 160px;">
                    <img onclick="checkLoggedin()" src='<?php echo $obj_base_path->base_path(); ?>/images/save_btn.gif' width="160" height="36" border="0" style="cursor:pointer"/>
                    </span>-->
					
					<div class="savebtn_<?php echo $_SESSION['langSessId'];?>"><a href="javascript:void()" onclick="checkLoggedin();"><?php echo SAVE_THIS_EVENT;?></a></div>
                 </div> 
				 <div class="clear"></div>
                 
				 
			<?php
				 //echo $objEvent->f('sub_events');
			if($sub_id == ''){
				 if($objEvent->f('sub_events') == 1){
				 //echo $objsub_event->num_rows();
					if($objsub_event->num_rows()){
						//echo "Hiii";
				 ?>
                 		
                 <div class="multi_functionbg">
                    <div class="multi_box">
                    <?php
						$i=0;
						/*echo "<pre>";
						print_r($allData);
						echo "</pre>";*/
						
                        foreach($allDataS as $eachData){
							//print_r($eachData);echo "<br/><br/>";
							/*echo "<pre>";
							print_r($eachData);
							echo "</pre>";*/
                        	
							// Multi Event Date
                        	
							list($multi_event_date,$multi_event_time) = explode(" ",$eachData['event_start_date_time']);
							list($multi_event_end_date,$multi_event_end_time) = explode(" ",$eachData['event_end_date_time']);
							
							$row[$i]['parent_id'] = $eachData['parent_id'];
							$row[$i]['multi_event_date'] = $multi_event_date;
							$row[$i]['city'] = $eachData['city'];
							$row[$i]['venue_name'] =$eachData['venue_name'];
							$row[$i]['multi_start_time'] =$multi_event_time;
							
							if($row[$i]['multi_event_date'] !=$row[$i-1]['multi_event_date']  && $row[$i]['multi_event_date']!=0){
								$date2 = date('Y-m-d',strtotime($row[$i]['multi_event_date']. "+1 day"));
								$objmul_date->sub_event_datewise($row[$i]['parent_id'],$row[$i]['multi_event_date'],$date2);
					?>
						<div class="multi_function">					 
                           <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbl<?php echo $i;?>" class="multi_function1" onclick="setHover('<?php echo $i;?>')">                      
                            <tr>
                              <th><?php echo date("D",strtotime($multi_event_date))." ".date("M",strtotime($multi_event_date))." ".date("d",strtotime($multi_event_date));?></th>
                            </tr>
                     <?php 
					 //echo $objmul_date->num_rows();
					 while($objmul_date->next_record()){
					 		list($date,$time) = explode(" ",$objmul_date->f('event_start_date_time'));
							list($date,$end_time) = explode(" ",$objmul_date->f('event_end_date_time'));
					 ?>       
							<tr>
                            <td style="height: auto;">
							  	<a href="<?php echo $obj_base_path->base_path(); ?>/events/<?php echo $objmul_date->f('parent_id');?>/sub_id/<?php echo $objmul_date->f('event_id');?>" class="link" data-fancybox-type="iframe">
								<?php if($_SESSION['langSessId']=='eng') echo $objmul_date->f('event_name_en'); else echo $objmul_date->f('event_name_sp');?> <br/><?php echo date('g:i A',strtotime($time))." - ".date('g:i A',strtotime($end_time)); ?>
								</a>
								<script type="text/javascript">
									$(document).ready(function() {
										$(".link").fancybox({ 
										type: 'iframe',
										'width': 1100,
               							'height': 500,
										'transitionIn'		: 'elastic',
										'transitionOut'		: 'elastic',
										autoSize: true
										});
									});
								  </script>
                                <?php 
									/*if($objmul_date->num_rows()){
										$s=0;
										$cityData = '';
										$venueData = '';
										while($objmul_date->next_record()){
											if($objmul_date->f('multi_id')==$Data['multi_id']){
												continue;
											}
											else{
												list($new_date,$new_time) = explode(" ",$objmul_date->f('multi_start_time'));
												//echo "<br>".$i."<br>".$row[$i]['multi_start_time']."<br>".$new_time."<br>";
												if($row[$i]['city']!=$objmul_date->f('city_name') && !in_array($objmul_date->f('city_name'),$cityData))
													echo '<br/><br/>'.$objmul_date->f('city_name');
												if($row[$i]['venue_name']!=$objmul_date->f('venue_name') && !in_array($objmul_date->f('venue_name'),$venueData))
													echo '<br/>'.$objmul_date->f('venue_name');
												if($row[$i]['multi_start_time']!=$new_time)
													echo '<br/>'.date('g:i A',strtotime($new_time));

												$cityData[] = $objmul_date->f('city_name');
												$venueData[] = $objmul_date->f('venue_name');

											}
											$s++;
										}
									}*/
								?>
                              </td>
                            </tr>
						<?php } ?>
                          </table>
						</div>
                      <?php
							}
							$i++;
						}
					  	?>
						</div>
				 	 </div>
                 <?php
					}
				}
			}
			?>
				 
				 
				 
				<div class="clear"></div>                
                <div class="map_ticket">
                  <div class="leftpart" style="width: 338px;">					
					  <div class="clear"></div>
                        <div class="time_reviews_box">                        
						<div class="heading_tabbox">
							<?php //echo $objEvent->f('identical_function');
							if($objEvent->f('identical_function') == 1){
							?>
							<div class="heading_top"><h1>Select your function</h1></div>
							<?php 
							}
							?>
					  	</div> 
                       <?php
						if($objmulti_event->num_rows()){
						?>
                        <div id='carousel_container'>
                       <!-- <div id='left_scroll'>
                       	<a href='javascript:slide("left");'><img src='<?php echo $obj_base_path->base_path(); ?>/images/left_arrow5.png' width="28" height="27" border="0" /></a>
                        </div>-->
                        <div id='carousel_inner'>
                            <ul id='carousel_ul'>
                             <?php
								$i=0;
								$kk = 0;
								$cntr = 0;
								foreach($allData as $eachData){
									//print_r($eachData);echo "<br/><br/>";
									
									// Multi Event Date
									list($multi_event_date,$multi_event_time) = explode(" ",$eachData['event_start_date_time']);
									list($multi_event_end_date,$multi_event_end_time) = explode(" ",$eachData['event_end_date_time']);
									$row[$i]['multi_event_date'] = $multi_event_date;

									$row[$i]['city'] = $eachData['city'];
									$row[$i]['venue_name'] =$eachData['venue_name'];
									$row[$i]['multi_start_time'] =$multi_event_time;
									
									
									/*echo "1 -".$row[$i]['multi_event_date']."<br>";
									echo "2 -".$row[$i-1]['multi_event_date']."<br>";*/
									
									// Check if current date is greater than event-multi event dt
									if($row[$i]['multi_event_date']< date("Y-m-d"))
										continue;
									
									
									if($row[$i]['multi_event_date'] !=$row[$i-1]['multi_event_date']  && $row[$i]['multi_event_date']!=0){
										$date2 = date('Y-m-d',strtotime($row[$i]['multi_event_date']. "+1 day"));
										$objmul_date->multi_event_datewise($event_id,$row[$i]['multi_event_date'],$date2);
							?>
								<!--class="multi_function1"-->
                                <li><table width="100%" border="0" cellspacing="0" cellpadding="0" class="heading_left">
                                    <tr>
                                      <th><?php echo date("D",strtotime($multi_event_date))." ".date("M",strtotime($multi_event_date))." ".date("d",strtotime($multi_event_date));?></th>
                                    </tr>
                                    <tr>
                                      <td>
                                      		<?php 
											$objmul_date->next_record(); 
											 /*?><p><?php echo $eachData['city'];?></p> 
											<?php if($_SESSION['langSessId']=='eng') echo $eachData['venue_name']; else echo $eachData['venue_name_sp'];?> <?php */?>
                                            <p style="cursor:pointer;" class="abc" id="tbl1<?php echo $kk;?>" onclick="setHover1(<?php echo $kk;?>,'<?php echo date("D",strtotime($multi_event_date))." ".date("M",strtotime($multi_event_date))." ".date("d",strtotime($multi_event_date)).", ".date("Y",strtotime($multi_event_date))." - ".date('g:i A',strtotime($multi_event_time))." to ".date('g:i A',strtotime($multi_event_end_time));?>','<?php echo $objmul_date->f('multi_id');?>','<?php echo $event_id;?>')">
												<?php echo date('g:i A',strtotime($multi_event_time)); ?>
                                            </p>
                                <?php 
									if($objmul_date->num_rows()){
										$s=0;
										$cityData = '';
										$venueData = '';
										while($objmul_date->next_record()){
										$kk++;
										//echo $objmul_date->f('multi_id');
											if($objmul_date->f('multi_id')==$eachData['multi_id']){
												continue;
											}
											else{
												list($new_date,$new_time) = explode(" ",$objmul_date->f('multi_start_time'));
												list($new_end_date,$new_end_time) = explode(" ",$objmul_date->f('multi_end_time'));
												//echo "<br>".$i."<br>".$row[$i]['multi_start_time']."<br>".$new_time."<br>";
												//if($row[$i]['city']!=$objmul_date->f('city_name') && !in_array($objmul_date->f('city_name'),$cityData))
													//echo '<p>'.$objmul_date->f('city_name').'</p>';
												//if($row[$i]['venue_name']!=$objmul_date->f('venue_name') && !in_array($objmul_date->f('venue_name'),$venueData))
													//echo '<p>'.$objmul_date->f('venue_name').'</p>';
												//if($row[$i]['multi_start_time']!=$new_time)
								?>
                                        	
                                            <p style="cursor:pointer;" class="abc" id="tbl1<?php echo $kk;?>" onclick="setHover1(<?php echo $kk;?>,'<?php echo date("D",strtotime($multi_event_date))." ".date("M",strtotime($multi_event_date))." ".date("d",strtotime($multi_event_date)).", ".date("Y",strtotime($multi_event_date))." - ".date('g:i A',strtotime($new_time))." to ".date('g:i A',strtotime($new_end_time));?>','<?php echo $objmul_date->f('multi_id');?>','<?php echo $event_id;?>')">
												<?php echo date('g:i A',strtotime($new_time)); ?>
                                            </p>
                                <?php				

												$cityData[] = $objmul_date->f('city_name');
												$venueData[] = $objmul_date->f('venue_name');

											}
											$s++;
											
										}
									}
								?>
                                	</td>
                                    </tr>
                                </table></li>
                                 <?php
								 		$cntr++;
										}
										$i++;
										$kk++;
									}
							?>
                            </ul>
                        </div>
                        
                        
                        
                        <?php
						if($cntr>3){
						?>
                        <div id='right_scroll'>
                        <a href='javascript:slide("right");'><img src='<?php echo $obj_base_path->base_path(); ?>/images/right_arrow5 .png' width="28" height="27" border="0"/></a>
                        </div>
                        <input type='hidden' id='hidden_auto_slide_seconds' value=0 />
                        <?php } ?>
                      </div>
                      <div class="clear" style="height:20px;"></div>
                      <?php
						}
						//echo $event_date."/".$event_date_end;
						if($objmulti_event->num_rows()){
							if($event_date<date("Y-m-d"))
							{
								$obj_cur_eve_dt->getCurrMultiEve($event_id);
								$obj_cur_eve_dt->next_record();
								
								if( $obj_cur_eve_dt->f('multi_start_time')){
						
					 ?>                      
                       <div class="timetxt">
                        <?php echo date("D",strtotime($obj_cur_eve_dt->f('multi_start_time')))." ".date("M",strtotime($obj_cur_eve_dt->f('multi_start_time')))." ".date("d",strtotime($obj_cur_eve_dt->f('multi_start_time'))).", ".date("Y",strtotime($obj_cur_eve_dt->f('multi_start_time')));?> - <?php echo date('g:i A',strtotime($obj_cur_eve_dt->f('multi_start_time'))); ?> to <?php echo date('g:i A',strtotime($obj_cur_eve_dt->f('multi_end_time'))); ?>
                       </div>
                       <?php
								}
							}
							else{
						?>
                       <div class="timetxt">
                        <?php echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));?> - <?php echo date('g:i A',strtotime($event_time)); ?> to <?php echo date('g:i A',strtotime($event_time_end)); ?>
                       </div>
                        <?php
							}
						}
						
						else{
                       ?>
                       <div class="timetxt">
                        <?php echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));?> - <?php echo date('g:i A',strtotime($event_time));
						
						if($event_date != $event_date_end) 
						{ 
							echo " <br /> To ";
							echo date("D",strtotime($event_date_end))." ".date("M",strtotime($event_date_end))." ".date("d",strtotime($event_date_end)).", ".date("Y",strtotime($event_date_end))." - ";?> <?php echo date('g:i A',strtotime($event_time_end)); 
						} 
						else 
						{ 
						?>
                         	to <?php echo date('g:i A',strtotime($event_time_end)); ?>
                            <?php } ?>
                       </div>
                       <?php
						}
					   ?>
                       <div class="reviews_box">
                        <div class="left_option"><?=REVIEWS?> (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                        <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                       </div>
                        </div>
                        <div class="clear"></div>
                        <?php 
						if($sub_id != ''){
							if($_SESSION['langSessId']=='eng') echo $obj_chk->f('event_short_desc_en'); else echo $obj_chk->f('event_short_desc_sp');
						}
						else{
							if($_SESSION['langSessId']=='eng') echo $objEvent->f('event_short_desc_en'); else echo $objEvent->f('event_short_desc_sp');
						}
						?>
						<div class="clear"></div>
						<?php //if($_SESSION['langSessId']=='eng') echo $obj_chk->f('event_details_en'); else echo $obj_chk->f('event_details_sp');?>
						<div class="clear"></div>
                        <?php 
						//echo $objEvent->f('event_short_desc_en');
						if($sub_id == ''){
							?>
						<div style="margin:10px 0 20px; font-weight:bold;">
                        	<p><?php echo $obj_venue->f('venue_name');?></p>
                        	<p><?php echo $obj_venue->f('venue_address');?></p>
                         	<p><?php echo $obj_venue->f('city').', '.$obj_venue->f('st_name');?></p>
                        </div>
						
						<?php
						}
						else
						{
						
							if($obj_venue->f('venue_name')!=$obj_venue_sub->f('venue_name')){?>
								<div style="margin:10px 0 20px; font-weight:bold;">
									<p><?php echo $obj_venue_sub->f('venue_name');?></p>
									<p><?php echo $obj_venue_sub->f('venue_address');?></p>
									<p><?php echo $obj_venue_sub->f('city').', '.$obj_venue_sub->f('st_name');?></p>
								</div>
						<?php
							}
						}
						?>
						
						<?php if($obj_venue->f('venue_name')!=$obj_venue_sub->f('venue_name')){?>
                        <div class="map_box" style="height:325px;">
                            <script type="text/javascript">
								 	var map = null;
									var geocoder = null;
								
									function initialize(add) {
										if (GBrowserIsCompatible()) {
											map = new GMap2(document.getElementById("map"));
											map.setCenter(new GLatLng(37.4419, -122.1419), 15);
											geocoder = new GClientGeocoder();
											var addressof=add;
											showAddress(addressof);
										}
									}
								
									function showAddress(address) {
									  if (geocoder) {
											geocoder.getLatLng(
												address,
												function(point) {
													if (!point) {
														alert(address + " not found");
													} else {
														map.setCenter(point, 15);
														var marker = new GMarker(point);
														map.addOverlay(marker);
														marker.openInfoWindowHtml(address + '<br /><div align="left" width="100%" style="margin:5px 0px 0px 10px;"><a style="color:#6a6a6a;" href="http://maps.google.com/maps?f=d&hl=en&geocode=&saddr=&daddr=' + address + '&ie=UTF8" target="_blank">Get directions</a></div>');
													}
												}
											);
										}
									}
									
							</script>
                          <div id="map" style="width:323px; height:325px; font-family: arial; font-size: 12px; color: #313E61; text-align: center; background-color:#FFFFFF;"></div>    
                        </div>
						
						<?php } ?>
						
                        <div class="clear"></div>
                      </div>
                      <div class="rightpart" style="width: 344px;">
                        
						<form name="frm" id="frm" method="post">
                        	<input type="hidden" name="action" value="cart" />
                            <input type="hidden" name="frm_event_id" id="frm_event_id" value="" />
                            <input type="hidden" name="frm_multi_id" id="frm_multi_id" value="" />
                           <input type="hidden" name="frm_payment" id="frm_payment" value="" />
                           <input type="hidden" name="tick" id="tick" value="" />
                           <input type="hidden" name="tot" id="tot" value="" />
							<input type="hidden" name="is_multi" id="is_multi" value="<?php echo $objEvent->f('identical_function');?>" />
						<?php 
						if($_REQUEST['sub_id'] == ''){?>
                          <div class="select_box1">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="select_table1">
                              <tr>
                                <td colspan="4"><div class="heading"><?php if($obj_ticket->num_rows()) { echo SELECT_TICKETS; } else { echo NO_TICKETS_AVAILABLE; }?></div></td>
                              </tr>
                              <?php 
                              $obj_expire->getTicketByExp($event_id); 
							  if($obj_expire->num_rows()){  
								
								if($obj_ticket->num_rows()){
									$count=1;
                                    while($obj_ticket->next_record()){
                              ?>
                              <tr>
                                <td width="10%">
                                <?php 
								
									$tt = time();
									if($tt<=$obj_ticket->f('to_ticket')){
										if($obj_ticket->f('ticket_num') > 0){
									?>
                                    
                                    <div class="dropdown25"><select name="ticket_num" id="ticket_num<?php echo $count;?>" onchange="addtocart(<?php echo $count;?>,<?php echo $obj_ticket->f('price_mx');?>,<?php echo $obj_ticket->f('price_us');?>,<?php echo $obj_ticket->f('ticket_id');?>,<?php echo $event_id;?>);">
                                    <?php for($i=0;$i<=$obj_ticket->f('ticket_num');$i++) {?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } ?>
                                    </select></div>
                                    
                                    <input type="hidden" name="frm_ticket<?php echo $count;?>" class="tick" id="frm_ticket<?php echo $count;?>" value="" />
                                    <input type="hidden" name="frm_mx_price<?php echo $count;?>" id="frm_mx_price<?php echo $count;?>" value="" />
                                    <input type="hidden" name="frm_us_price<?php echo $count;?>" id="frm_us_price<?php echo $count;?>" value="" />
                                    <input type="hidden" name="frm_us_tid<?php echo $count;?>" id="frm_us_tid<?php echo $count;?>" value="" />
                                    
                                    <?php
                                    	}
										else
										{
											echo "Sold Out ";
										}
									}
									else
									{
										echo "Not available ";
									}
									?>
                                    
                                </td>
                                <td width="66%" style="padding-left: 6px;"><?php if($_SESSION['langSessId']=='eng') { echo $obj_ticket->f('ticket_name_en'); } else { echo $obj_ticket->f('ticket_name_sp');}?></td>
                                <td width="3%" style="padding-right: 4px;"><a href="#showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>" id="ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/select_table_img1.png" border="0" /></a></td>
                                <td width="21%">
                                    <div class="amount_btn">
                                    <?php  
                                        if($obj_ticket->f('price_us')!="0.00" && $obj_ticket->f('price_us')!="" && $obj_ticket->f('price_mx')!="0.00" && $obj_ticket->f('price_mx')!=""){
                                      ?>										
                                      <span class="block_box">US $<?php echo number_format($obj_ticket->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_ticket->f('price_mx'),2); ?></span>
                                      <?php 
                                        } else if($obj_ticket->f('price_us')!="0.00" && $obj_ticket->f('price_us')!=""){
                                      ?>
                                    <span class="block_box">US $<?php echo number_format($obj_ticket->f('price_us'),2); ?> </span><?php } else if($obj_ticket->f('price_mx')!="0.00" && $obj_ticket->f('price_mx')!="") { ?><span style="width:">MXP <?php echo number_format($obj_ticket->f('price_mx'),2); ?></span><?php } ?>
                                    
                                <?php /*?><?php if($_SESSION['langSessId']=='eng') { ?>$<?php echo $obj_ticket->f('price_us'); } else { echo $obj_ticket->f('price_mx');}?><?php */?></div></td>
                              </tr>
                              <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>").fancybox({ 
                                    'hideOnOverlayClick':false,
                                    'hideOnContentClick':false
                                    });
                                });
                              </script>
                              <div style="display:none;">
                                <div style="width:500px; height:auto; background:#FFF; padding:10px;" id="showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    <?php if($_SESSION['langSessId']=='eng') { echo $obj_ticket->f('description_en'); } else { echo $obj_ticket->f('description_sp');}?>
                                </div>
                              </div>
                              <?php
                                    $count++;
									}
									?>
									<input type="hidden" name="frm_count" id="frm_count" value="<?php echo $count;?>" />
									<?php
                                }
                                else{
                              ?>
                              <?php /*?> <tr>
                                <td colspan="4" style="margin:0 0 0 10px;"><?=NO_TICKETS_AVAILABLE?></td>
                              </tr><?php */?>
                              <?php } 
							  	}
								else
								{
									if($_SESSION['langSessId']=='eng') {
										echo '<tr><td width="10%">Reservation for this event has expired</td></tr>';
									}
									elseif($_SESSION['langSessId']=='spn') {
										echo '<tr><td width="10%">Reservación para este evento ha vencido</td></tr>';
									}
								}

							  ?>
                                  
                          </table>
                          </div>
                          <?php  
						  	if($obj_ticket->num_rows()){?>
                              <div class="select_box2">
                             <?php if($_SESSION['langSessId']=='eng') {?>
                                <div><a href="javascript:void(0);" onclick="save();"><img src="<?php echo $obj_base_path->base_path(); ?>/images/reserv_btn.gif" /></a></div>
                             <?php } else {?>   
                                <div><a href="javascript:void(0);" onclick="save();"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spainreser_btn.gif" /></a></div>
                             <?php } ?>  
                                <!--<div class="icon_link">
                                    <ul>
                                        <li><input type="radio" name="same" value="standard" onclick="save('standard');" /><a href="javascript:void(0);"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon1.gif" border="0" /></a></li>
                                        <li><input type="radio" name="same" value="pro" onclick="save('pro');" /><a href="javascript:void(0);"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon2.gif" border="0" /></a></li>
                                        <li><input type="radio" name="same" value="transfer" onclick="save('transfer');" /><a href="javascript:void(0);"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon4.gif" border="0" /></a></li>
                                        <li><input type="radio" name="same" value="oxxo" onclick="save('oxxo');" /><a href="javascript:void(0);"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon5.gif" border="0" /></a></li>
                                    </ul>
                                </div>-->
                             </div>
						  <?php 
						  	} 
						} 
						elseif($_REQUEST['sub_id'] != '' && $access!= 2)
						{
							
							$obj_sub_ticket->subgetTicketById($_REQUEST['sub_id'],$objsub_event->f('parent_id')); 
							$obj_sub_ticket_img->subgetTicketById($_REQUEST['sub_id'],$objsub_event->f('parent_id')); 
							
						?>
                         <div class="select_box1">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="select_table1">
                              <tr>
                                <td colspan="4"><div class="heading"><?php if($obj_sub_ticket->num_rows()) { echo SELECT_TICKETS; } else { echo NO_TICKETS_AVAILABLE; }?></div></td>
                              </tr>
                              <?php 
                                if($obj_sub_ticket->num_rows()){
                                    while($obj_sub_ticket->next_record()){
                              ?>
                              <tr>
                                <td width="10%">
                                    <div class="dropdown25"><select name="">
                                    <?php for($i=1;$i<=$obj_sub_ticket->f('ticket_num');$i++) {?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } ?>
                                    </select></div>
                                </td>
                                <td width="66%" style="padding-left: 6px;"><?php if($_SESSION['langSessId']=='eng') { echo $obj_sub_ticket->f('ticket_name_en'); } else { echo $obj_sub_ticket->f('ticket_name_sp');}?></td>
                                <td width="3%" style="padding-right: 4px;"><a href="#showticketdes<?php echo $obj_sub_ticket->f('ticket_id'); ?>" id="ticket_des<?php echo $obj_sub_ticket->f('ticket_id'); ?>">
                                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/select_table_img1.png" border="0" /></a></td>
                                <td width="21%">
                                    <div class="amount_btn">
                                    <?php  
                                        if($obj_sub_ticket->f('price_us')!="0.00" && $obj_sub_ticket->f('price_us')!="" && $obj_sub_ticket->f('price_mx')!="0.00" && $obj_sub_ticket->f('price_mx')!=""){
                                      ?>										
                                      <span class="block_box">US $<?php echo number_format($obj_sub_ticket->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_sub_ticket->f('price_mx'),2); ?></span>
                                      <?php 
                                        } else if($obj_sub_ticket->f('price_us')!="0.00" && $obj_sub_ticket->f('price_us')!=""){
                                      ?>
                                    <span class="block_box">US $<?php echo number_format($obj_sub_ticket->f('price_us'),2); ?> </span><?php } else if($obj_sub_ticket->f('price_mx')!="0.00" && $obj_sub_ticket->f('price_mx')!="") { ?><span style="width:">MXP <?php echo number_format($obj_sub_ticket->f('price_mx'),2); ?></span><?php } ?>
                                    
                                <?php /*?><?php if($_SESSION['langSessId']=='eng') { ?>$<?php echo $obj_ticket->f('price_us'); } else { echo $obj_ticket->f('price_mx');}?><?php */?></div></td>
                              </tr>
                              <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#ticket_des<?php echo $obj_sub_ticket->f('ticket_id'); ?>").fancybox({ 
                                    'hideOnOverlayClick':false,
                                    'hideOnContentClick':false
                                    });
                                });
                              </script>
                              <div style="display:none;">
                                <div style="width:500px; height:auto; background:#FFF; padding:10px;" id="showticketdes<?php echo $obj_sub_ticket->f('ticket_id'); ?>">
                                    <?php if($_SESSION['langSessId']=='eng') { echo $obj_sub_ticket->f('description_en'); } else { echo $obj_sub_ticket->f('description_sp');}?>
                                </div>
                              </div>
                              <?php
                                    }
                                }
                                else{
                              ?>
                              <?php /*?> <tr>
                                <td colspan="4" style="margin:0 0 0 10px;"><?=NO_TICKETS_AVAILABLE?></td>
                              </tr><?php */?>
                              <?php } ?>
                                  
                          </table>
						 </div>	
                         <?php  if($obj_sub_ticket->num_rows()){?><div class="select_box2">
                            <div class="buy_btn27"><a href="#"><?=BUY?></a></div>
                            <div class="icon_link">
                                <ul>
                                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon1.gif" border="0" /></a></li>
                                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon2.gif" border="0" /></a></li>
                                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon3.gif" border="0" /></a></li>
                                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon4.gif" border="0" /></a></li>
                                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon5.gif" border="0" /></a></li>
                                </ul>
                            </div>
                         </div><?php } ?>				
						<?php }
						elseif($_REQUEST['sub_id'] != '' && $access == 2)
						{
						?>
						
							<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="select_table1">
                              <tr>
                                <td colspan="4"><div class="heading"><?php if($obj_ticket->num_rows()) { echo SELECT_TICKETS; } else { echo NO_TICKETS_AVAILABLE; }?></div></td>
                              </tr>
                              <?php 
                                if($obj_ticket->num_rows()){
                                    while($obj_ticket->next_record()){
                              ?>
                              <tr>
                                <td width="10%">
                                    <div class="dropdown25"><select name="">
                                    <?php for($i=1;$i<=$obj_ticket->f('ticket_num');$i++) {?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } ?>
                                    </select></div>
                                </td>
                                <td width="66%" style="padding-left: 6px;"><?php if($_SESSION['langSessId']=='eng') { echo $obj_ticket->f('ticket_name_en'); } else { echo $obj_ticket->f('ticket_name_sp');}?></td>
                                <td width="3%" style="padding-right: 4px;"><a href="#showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>" id="ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/select_table_img1.png" border="0" /></a></td>
                                <td width="21%">
                                    <div class="amount_btn">
                                    <?php  
                                        if($obj_ticket->f('price_us')!="0.00" && $obj_ticket->f('price_us')!="" && $obj_ticket->f('price_mx')!="0.00" && $obj_ticket->f('price_mx')!=""){
                                      ?>										
                                      <span class="block_box">US $<?php echo number_format($obj_ticket->f('price_us'),2); ?> </span><span>MXP <?php echo number_format($obj_ticket->f('price_mx'),2); ?></span>
                                      <?php 
                                        } else if($obj_ticket->f('price_us')!="0.00" && $obj_ticket->f('price_us')!=""){
                                      ?>
                                    <span class="block_box">US $<?php echo number_format($obj_ticket->f('price_us'),2); ?> </span><?php } else if($obj_ticket->f('price_mx')!="0.00" && $obj_ticket->f('price_mx')!="") { ?><span style="width:">MXP <?php echo number_format($obj_ticket->f('price_mx'),2); ?></span><?php } ?>
                                	</div>
                                </td>
                              </tr>
                              <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>").fancybox({ 
                                    'hideOnOverlayClick':false,
                                    'hideOnContentClick':false
                                    });
                                });
                              </script>
                              <div style="display:none;">
                                <div style="width:500px; height:auto; background:#FFF; padding:10px;" id="showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    <?php if($_SESSION['langSessId']=='eng') { echo $obj_ticket->f('description_en'); } else { echo $obj_ticket->f('description_sp');}?>
                                </div>
                              </div>
                              <?php
                                    }
                                }
                              ?>
                                  
                          </table><?php */?>
							
						<?php
						}
						?>
                       </form>
                        
						<div class="clear"></div>
						<div class="icon_box2"><p>Invite your friends <a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon9.gif" border="0" align="absmiddle"/></a> <a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon8.gif" border="0" align="absmiddle"/></a></p></div>
						<div class="clear"></div>
                        <div class="like_box" style=" margin: 0 0 10px 0;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                              <tr>
                                <td style="padding: 0;"><div class="like_textbox bg1"><input name="" type="text" value="104" /></div></td>
                                <td><div class="like_textbox bg2"><input name="" type="text" value="75" /></div></td>
                                <td><div class="like_textbox bg3"><input name="" type="text" value="4" /></div></td>
                                <td><div class="like_textbox bg4"><input name="" type="text" value="2" /></div></td>
                                <td><div class="like_textbox bg5"><input name="" type="text" value="2054" /></div></td>
                              </tr>
                              <tr>
                                <td style="padding: 0;"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img1.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img2.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img3.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img4.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img5.gif" border="0" /></a></td>
                              </tr>
                          </table>	
						</div>
						<div class="clear"></div>		
                        <div class="offer_box" style="float: left; margin: 0; width:100%;">                       
                       	 <div class="preview_imgbox" style="float: left; width: 100%;">
                         <div class="imgbox" style="width:100%; height: auto;">
                            <ul>
                           <!-- <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_img1.gif" border="0" /></li>-->
                         	  
                            <?php if($objEvent->f('event_photo')){  

							?>
                            	<li style="margin: 0; display: block;">
                                <a href="#feature_image" id="feature"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/medium/<?php echo $objEvent->f('event_photo');?>"  border="0"  /></a>
                                </li>
                                 <script type="text/javascript">
									$(document).ready(function() {
										$("#feature").fancybox({ 
										'hideOnOverlayClick':false,
										'hideOnContentClick':false
										});
									});
								  </script>
                                  <div style="display:none;">
                                  	<div style="width:auto;height:auto; background:#FFF; padding:10px;" id="feature_image">
                                    	<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objEvent->f('event_photo');?>"  border="0"  />
                                    </div>
                                  </div>
                            <?php } 
								
							  ?>
                            </ul>
                         </div>
                        </div>
					  </div>				
					  <div class="clear"></div>		
                      </div>
                    </div>
                    <div class="clear"></div>
                    <div class="show_box"> 
					                    
                      <div class="leftbox">
                       	<p style="min-height: 0; height: auto;">
						<?php //if($_SESSION['langSessId']=='eng') { echo $objEvent->f('event_details_en'); } else { echo $objEvent->f('event_details_sp');}?>
						<?php 
						if($sub_id == ''){
						if($_SESSION['langSessId']=='eng') { echo stripslashes($objEvent->f('event_details_en')); } else { echo stripslashes($objEvent->f('event_details_sp'));}
						}
						else
						{
						if($_SESSION['langSessId']=='eng') { echo stripslashes($obj_chk->f('event_details_en')); } else { echo stripslashes($obj_chk->f('event_details_sp'));}
						}
						?>
						</p>
                      </div>
                    </div>
                </div>
                <div class="clear"></div>
				
                <div class="view_box">
                	<div class="heading"><?=SECTION1_TEXT;?></div>
                	<div class="hot_events">
                    
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="view_box" style="margin: 0;">
                	<div class="heading"><?=SECTION2_TEXT;?></div>
                    <div class="photo_count"><?=FAN_PHOTOS?> (39)</div>
                	<div class="hot_events2">
                    
                    </div>
                    <div class="clear"></div>
                    <div class="time_reviews_box" style="width: 652px; margin: 10px auto; float: none; overflow: hidden;">
                        <div class="reviews_box" style="margin: 5px 0 10px 0;">
                            <div class="left_option"><?=REVIEWS?> (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                            <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                        </div>
                        <div class="right_btn"><a href="#"><?=WRITE_REVIEW?></a></div>
                        <div class="clear"></div>        
                       <div class="dropdown3"><select name=""><option><?=CHOOSE_SORT_ORDER?> </option></select></div>         
                  </div>
                  <div class="clear"></div>
                  <div class="Tchai_box">
                  	<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div>
<!--                    <div class="headtxt">Tchaikovsky was Great</div>
                  	<p>Hollywood Bowl - Hollywood, CA - Fri, Sep 7 2012</p>
                    <p>Posted 09/18/2012 by <strong>EKHO1</strong> <a href="#">this Fan's Reviews</a></p>-->
                    <div class="feature_btn"><a href="#"><?=FEATURED_REVIEW?></a></div>
                    <div class="clear"></div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,</p>
                    <!--<p><strong>Favorite moment: </strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br />Aenean commodo ligula eget dolor. </p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <span><a href="#">Yes</a> | <a href="#">No</a> </span> <span style="margin: 0 10px;"><a href="#">(Report as inappropriate)</a></span></p>-->
                    <div class="share_this">
                    	<ul>
                        	<li style="margin: 0 10px 0 0;"><?=SHARE_REVIEW?>:</li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon1.gif" border="0" /></a></li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon2.gif" border="0" /></a></li>
                        </ul>
                    </div>
                  </div>
<!--    <div class="Tchai_box">
                  	<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div>
                    <div class="headtxt">Tchaikovsky was Great</div>
                  	<p>Hollywood Bowl - Hollywood, CA - Fri, Sep 7 2012</p>
                    <p>Posted 09/18/2012 by <strong>EKHO1</strong> <a href="#">this Fan's Reviews</a></p>
                    <div class="feature_btn"><a href="#">Featured Review</a></div>
                    <div class="clear"></div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,</p>
                    <p><strong>Favorite moment: </strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br />Aenean commodo ligula eget dolor. </p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <span><a href="#">Yes</a> | <a href="#">No</a> </span> <span style="margin: 0 10px;"><a href="#">(Report as inappropriate)</a></span></p>
                    <div class="share_this">
                    	<ul>
                        	<li style="margin: 0 10px 0 0;">Share this review:</li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon1.gif" border="0" /></a></li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon2.gif" border="0" /></a></li>
                        </ul>
                    </div>
                  </div>
                  <div class="page_box2">
               	 	<div class="pagination2">
                    	<ul>
                        	<li><a href="#" class="active">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">300</a></li>
                            <li><a href="#">Next</a></li>
                            <li><a href="#" style="color: #929292;"> >> </a></li>
                        </ul>
                    </div>
                </div>-->
                </div>
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

<?php if($obj_venue->f('venue_name')!=$obj_venue_sub->f('venue_name')){?>
<script type="text/javascript">
$(document).ready(function(){
	initialize('<?php echo $obj_venue->f('city'); ?>+<?php echo $obj_venue->f('st_name'); ?>+<?php echo $obj_venue->f('venue_zip'); ?>');
})
</script>
<?php } ?>

</body>
</html>
