<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
<script>
$(document).ready(function () {
	$('#addanappointment').popup({
	  transition: 'all 0.3s',
	  scrolllock: true
	});
	$('#rescheduleappointment').popup({
		
	  transition: 'all 0.3s',
	  scrolllock: true
	});
		manager_captcha_reload();
		manager_captcha_reload_new();
		
	$( "#rs_datepicker" ).datepicker
	({
		changeYear: true,
		minDate: '0',
		beforeShow : function(){
		$( this ).datepicker('option','minDate', <?php echo date('d/m/Y') ?>  );
		}
	});
});

/*********/
function available_time(given_date,slot_gap)
{
	alert(given_date);
	
	var clinic_id = $("#clinicid").val();
	var slot_gap = slot_gap;
	var given_date = given_date;
	var url = '<?php echo BASE_URL.'appointments/get_timing'; ?>';
	$.ajax({
			type: 'POST',
			url: url,
			data: {clinic_id:clinic_id,given_date:given_date,slot_gap:slot_gap},
			success:function(result){
				alert(result);
				document.getElementById('all_timings').innerHTML+=result;
			}
		});
}
/********/
/*set the value in hidden field for for booking appointment start*/
function booking_appointment(rownum,booking_date,start_time,multiplier)
{
	//alert("HI! "+rownum+"hello "+booking_date);
	$("#rownum").val(rownum);
	$("#booking_date").val(booking_date);
	$("#start_time").val(start_time);
	$("#multiplier").val(multiplier);
	
}
/*set the value in hidden field for for booking appointment end*/

/****Funtion for block exception start****/

function blockException(rownum,exceptiondate,clinic_id)
{
	//alert("HI! "+rownum+"hello "+booking_date);
	////$("#rownum").val(rownum);
	////$("#booking_date").val(booking_date);
	var rowNum = rownum;
	var exceptionDate = exceptiondate;
	var clinicId =clinic_id;
	
	var url = '<?php echo BASE_URL.'appointments/blockException'; ?>';
	$.ajax({
			type: 'POST',
			url: url,
			data: {rownum:rowNum,exception_date:exceptionDate,clinic_id:clinicId},
			success:function(result){
				alert(result);
				if (result==1)
				{
					alert("Blocked Exceptions.");	
				}
			}
		});
	
}
/****Funtion for block exception end****/

/*----This function is  for booked appointment---*/
function toBookedAppointment(appo_id)
{
	var appoinment_id = appo_id;
	//alert(appoinment_id); 
	var url = '<?php echo BASE_URL.'appointments/bookedAppointment'; ?>';
			$.ajax({
					type: 'POST',
					url: url,
					data: {appoinment_id:appoinment_id},
					success:function(result){
						alert(result);
						if (result==1)
						{
							alert("Booked That Appointment.");	
						}
					}
				});
}

/*----This function is  for Cancel appointment [Delete from table]---*/
function toCancelAppointment(appo_id)
{
	var appoinment_id = appo_id;
	alert(appoinment_id); 
	var url = '<?php echo BASE_URL.'appointments/toCancelAppointment'; ?>';
			$.ajax({
					type: 'POST',
					url: url,
					data: {appoinment_id:appoinment_id},
					success:function(result){
						alert(result);
						if (result==1)
						{
							alert("Cancel an appointment.");	
						}
						
					}
				});	
}
/*==========For capcha ====================*/

function manager_captcha_reload()
		{
			$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
				$('#manager_captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
			});
		}
		
		//----------------captcha check for user_registration---------------------
		function captcha_check(sess_cap_val)
		{	
			var sub_catcha_val=document.getElementById('manager_captcha').value;
			if (sub_catcha_val != '' && sub_catcha_val != sess_cap_val)
			    $("#msg").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
			else
				$("#msg").html("");
		}
		
		function manager_captcha_reload_new()
		{
			$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
				$('#booking_captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
			});
		}
		
		//----------------captcha check for user_registration---------------------
		function captcha_check_new(sess_cap_val)
		{	
			var sub_catcha_val=document.getElementById('booking_captca').value;
			if (sub_catcha_val != '' && sub_catcha_val != sess_cap_val)
			    $("#msg_new").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
			else
				$("#msg_new").html("");
		}
		
		
/*=========== For  Captcha End ================*/

function save_booking_appointment()
{
	var uid = $("#uid").val();
	var clinic_id =$("#clinic_id").val();
	var msg =$("#msg").val();
	var rownum = $("#rownum").val();
	var booking_date =$("#booking_date").val();
	var book_user_type = $("#book_user_type").val();
	var start_time = $("#start_time").val();
	var multiplier = $("#multiplier").val();
	
	var o_captcha_val = $('#ex_captcha').val();
	var s_captcha_val = $('#booking_captcha').val();
	var user_book = $('#uid').val();
	var e = 0;
	
	if (user_book.search(/\S/)==-1) {
		$('#user_sec-error').html('Please select an user');
		e++;
	}
	else{
		$('#user_sec-error').html('');
	}
	
	if (s_captcha_val.search(/\S/)==-1) {
		$('#msg_new').html('Please enter captcha');
		e++;
	}
	else{
		if (o_captcha_val != s_captcha_val) {
			$('#msg_new').html('Wrong Captcha');
			e++;
		}
		else{
			$('#msg_new').html('');
		}
	}
	
	if (e == 0)
	{
		//$("#complete_booking").submit();
		var url = '<?php echo BASE_URL.'appointments/saveBooking'; ?>';
		$.ajax({
			type: 'POST',
			url: url,
			data: {uid:uid,clinic_id:clinic_id,msg:msg,rownum:rownum,booking_date:booking_date,book_user_type:book_user_type,start_time:start_time,multiplier:multiplier},
			success:function(result)
			{
				//alert(result);
				window.location='<?php echo BASE_URL.'appointments/clinic_appointment_details/id:'?>'+clinic_id;
			}
			
			});
		
	}	
}
/*****************************************************************************************************************************************/
/******************************************************* Reschedule Appointments *********************************************************/
function reschdule_appointment(clinic_id,username,userid,res_rownum,select_date)
{
	alert(username);
	$("#r_username").html(username);
	$("#user_id").val(userid);
	$("#res_rownum").val(res_rownum);
	$("#select_date").val(select_date);
	//alert(r_username);
}

function save_reschdule_appointment()
{
	alert("hi!");
	var uid = $("#user_id").val();
	var clinic_id =$("#clinicid").val();
	var msg =$("#message").val();
	var rownum = $("#res_rownum").val(); /*used for delete the particular slot*/
	var book_user_type = $("#res_book_user_type").val();
	var booking_date= $("#rs_datepicker").val();
	var resrownum=$("#all_timings").val();
	var select_date = $("#select_date").val();
	alert(booking_date);
	alert(book_user_type);
	//var o_captcha_val = $('#ex_captcha').val();
	//var s_captcha_val = $('#booking_recaptcha').val();
	//var user_book = $('#uid').val();
	//var e = 0;
	//
	//if (user_book.search(/\S/)==-1) {
	//	$('#user_sec-error').html('Please select an user');
	//	e++;
	//}
	//else{
	//	$('#user_sec-error').html('');
	//}
	//
	//if (s_captcha_val.search(/\S/)==-1) {
	//	$('#msg_new').html('Please enter captcha');
	//	e++;
	//}
	//else{
	//	if (o_captcha_val != s_captcha_val) {
	//		$('#msg_new').html('Wrong Captcha');
	//		e++;
	//	}
	//	else{
	//		$('#msg_new').html('');
	//	}
	//}
	
	//if (e == 0)
	//{
		//$("#complete_booking").submit();
		var url = '<?php echo BASE_URL.'appointments/reshedule_appointment'; ?>';
		$.ajax({
			type: 'POST',
			url: url,
			data: {uid:uid,clinic_id:clinic_id,msg:msg,rownum:rownum,booking_date:booking_date,book_user_type:book_user_type,resrownum:resrownum,select_date:select_date},
			success:function(result)
			{
				alert(result);
				//window.location='<?php echo BASE_URL.'appointments/clinic_appointment_details/id:'?>'+clinic_id;
			}
			
			});
		
	//}	
}

/***************************************************************************************************************************************************/

</script>
	
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>All Appointments</h2></div></div>
		<div class="container">
			<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
			<div class="container_inner">
				<div class="manage_appointment_form">
					<form name="search_appointment" id="search_appointment" action="<?php echo BASE_URL;?>appointments/clinic_appointment_details/id:<?php echo $clinic_id ?>" method="post">
						<input type="hidden" name="clinic" id="clinic" value="<?php echo (isset($this->params->named['id']))?$this->params->named['id']:0 ?>" />
											
						<div class="clinic_name"><h2><span>Clinic Name:</span> <?php echo $clinic_details['Clinic']['name']; ?></h2></div>
						
						<div class="col-1"><input type="text" value="<?php echo $the_date; ?>" name="appointment_date" placeholder="Appointment Date" class="datepicker user-in-date" onchange="ajax_clinic_timing(this.value);" /></div>
						<div class="col-2">
							<div class="choose_slot">Choose slot<sup>*</sup> :</div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/green_icon.jpg',array('alt'=>'Available')); ?><a href="#">Available</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/yellow_icon.jpg',array('alt'=>'Pending')); ?><a href="#">Pending</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/red_icon.jpg',array('alt'=>'Booked')); ?><a href="#">All Booked</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/gray_icon.jpg',array('alt'=>'Unavailable')); ?><a href="#">Unavailable</a></div>
							<div class="upcoming_past">
								<button type="button">Monthly</button>
								<button type="button" class="active" >Weekly</button>
							</div>
						</div>    
					</form>
				</div>
				
				<?php
					//if($cal_type == 'month')
					//{
					//	$calendar = new ClinicCalendarHelper();
					//	echo $calendar->show($clinic_id);
					//}
					//elseif($cal_type == 'week')
					//{
					//	$weekly_calendar = $this->WeeklyCalendarClinic;
					//	$weekly_calendar->EasyWeeklyCalClass($dia, $mes, $ano, $clinic_id);
					//	//echo '<div class="manage_appointment_table">'.$weekly_calendar->showCalendar ().'</div>';
					//}
					//else
					//{
					//	$calendar = new CalendarHelper();
					//	echo $calendar->show();
					//}
				?>
				<div class="manage_appointment_table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="manage_appointment_info">
		<tr class="manage_appointment_info_title">
                    <td class="coll">Appointment Slot</td>
		    <?php
		    $days_arr=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		    for($i=0;$i<=6;$i++)
		    {
			?>
			     <td class="coll <?php if($the_date==$all_dates[$i]){?>y_back<?php }?>" ><?php echo $days_arr[$i];?> <?php echo $all_dates[$i];?></td>
			<?php
		    }
		    ?>
                    
		    <!---- This is for arrow to change the calender date for 7 days before  as well as 7 days after start---->
                    <div class="manage_appointment_page">
			<a href="<?php echo BASE_URL;?>appointments/clinic_appointment_details/id:<?php echo $clinic_id;?>/date:<?php $datetime = new DateTime($the_date);
			$datetime->modify('-7 day');
			echo $datetime->format('Y-m-d');?>" class="left_arrow"><?php echo "<img src='".BASE_URL."frontend/images/manage_left_arrow.png'>";?></a>
			
			<a href="<?php echo BASE_URL;?>appointments/clinic_appointment_details/id:<?php echo $clinic_id;?>/date:<?php $datetime = new DateTime($the_date);
			$datetime->modify('+7 day');
			echo $datetime->format('Y-m-d');?>" class="right_arrow"><?php echo "<img src='".BASE_URL."frontend/images/manage_right_arrow.png'>";?></a>
                    </div>
		    <!---- This is for arrow to change the calender date for 7 days before  as well as 7 days after end---->
                </tr>

					<?php
					//pr($opening_hours);
					
					$new_opening_hours=array();
					foreach($opening_hours as $k=>$v)
					{
						$new_opening_hours[$v['Openinghour']['day']][]=$v['Openinghour']['fromhour'].':'.$v['Openinghour']['fromminutes'].'-'.$v['Openinghour']['tohour'].':'.$v['Openinghour']['tominutes'];
					}
					//pr($new_opening_hours);
					function create_hr_min($i)
					{
						$interval=$i*5;
						$h=sprintf('%02d',floor($interval/60));
						$m=sprintf('%02d',($interval%60));
						return $h.':'.$m;
					}
					$dc=array();
					$count=0;
					//$each_row_start_time = array();
					for($i=0;$i<288;$i++)
					{
						?>
						 <tr class="manage_appointment_info_cont">
							<td class="coll col-1"><span>From</span>: <?php echo $start=create_hr_min($i);?><br><span>To</span>: <?php echo $end=create_hr_min($i+1);?></td>
						<?php
						//$each_row_start_time[$i] = $start;
						for($j=0;$j<=6;$j++)
						{
							$time_slot=$time_arr[$j];
							$slot_no=$time_slot/5;
							$status=0;
							if(isset($new_opening_hours[$j+1]))
							{
								
							$all_times=$new_opening_hours[$j+1];
							foreach($all_times as $t)
							{
								$t_arr=explode('-',$t);
								
								if($t_arr[0]<=$start&&$t_arr[1]>$start)
								{
									$status=1;
									break;
								}
								
							}
							}
							if($status==0)
							{
						
							?>
							<td class="coll g_back"><?php echo $i.'-----'.$j;echo"<br/>";echo$count;?></td>
							<?php
							}
							else
							{
							
							if(isset($dc[$j]))
							{
								$dc[$j]--;
								if($dc[$j]==1)
								{
									unset($dc[$j]);
								}
								continue;
							}
							$expected_end_of_slot=$i+$slot_no;
							$expected_end_of_slot_time=create_hr_min($expected_end_of_slot);
							$status2=0;
							if(isset($new_opening_hours[$j+1]))
							{
								
							$all_times2=$new_opening_hours[$j+1];
							foreach($all_times2 as $t2)
							{
								$t_arr2=explode('-',$t2);
								
								if($t_arr2[0]<=$expected_end_of_slot_time&&$t_arr2[1]>=$expected_end_of_slot_time)
								{
									$status2=1;
									break;
								}
								
							}
							}
							if($status2==0)
							{
								?>
								<td class="coll" style='background-color:black;'><?php echo $i.'-----'.$j;echo"<br/>";echo $count;?></td>
								<?php
								continue;
							}
							$dc[$j]=$slot_no;
							?>
							<?php
							if(!isset($appointments[$i][$j]))
							{
								?>
							<td class="coll" rowspan="<?php echo $dc[$j];?>"><a href="javascript:void(0)" class="initialism addanappointment_open icon1" onclick="booking_appointment('<?php echo $i;?>','<?php echo $all_dates[$j];?>','<?php echo $start;?>','<?php echo $dc[$j];?>')" ><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon1.png'>";?></a><a href="javascript:void(0)" class="icon2"  onclick="blockException('<?php echo $i;?>','<?php echo $all_dates[$j];?>','<?php echo $clinic_id ?>')" ><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon2.png'>";?></a></td>
						
								<?php
							}
							else if($appointments[$i][$j]['status']==0)
							{
								?>
							<td class="coll y_back" rowspan="<?php echo $dc[$j];?>"><a href="javascript:void(0)" class="icon1" onclick="toBookedAppointment('<?php echo $appointments[$i][$j]['id'];?>')" ><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon5.png'>";?></a><a href="javascript:void(0)" class="icon2"  onclick="toCancelAppointment('<?php echo $appointments[$i][$j]['id'];?>')" ><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon6.png'>";?></a><p><?php echo $appointments[$i][$j]['user_details']['username'];?></p></td>
						
								<?php
							}
							else if($appointments[$i][$j]['status']==1)
							{
							?>
							<td class="coll y_back" rowspan="<?php echo $dc[$j];?>"><a href="javascript:void(0)" style='margin-right: 25%;' class="icon2" onclick="toCancelAppointment('<?php echo $appointments[$i][$j]['id'];?>')"><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon6.png'>";?></a><p><?php echo $appointments[$i][$j]['user_details']['username'];?></p></td>
						
								<?php	
							}
							else if($appointments[$i][$j]['status']==2)
							{
								
								?>
							<td class="coll r_back" rowspan="<?php echo $dc[$j];?>"><a href="javascript:void(0)" class="initialism rescheduleappointment_open icon1"   onclick="reschdule_appointment('<?php echo $clinic_id ?>','<?php echo $appointments[$i][$j]['user_details']['username'];?>','<?php echo $appointments[$i][$j]['user_details']['id'];?>','<?php echo $i;?>','<?php echo $all_dates[$j];?>')"><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon3.png'>";?></a><a href="javascript:void(0)" class="icon2" onclick="toCancelAppointment('<?php echo $appointments[$i][$j]['id'];?>')"><?php echo "<img src='".BASE_URL."frontend/images/manageinfo_icon4.png' >";?></a><p><?php echo $appointments[$i][$j]['user_details']['username'];?></p></td>
						
								<?php
							}
							?>
							<?php	
							}
							$count++;
						}
						?>
						</tr>
						<?php
					}
					?>
					
				</table>
					
				
					
				
		</div>
	</section>
    
    <div class="scrolltop"></div>   
<div id="addanappointment" class="well">
	<div class="fade_cont">
        <div class="addanappointment_close btnclose">X</div>
        <h2>Add An Appointment</h2>
        <div class="reschedule_form">
	<!--<form name="complete_booking" id="complete_booking" action="<?php echo BASE_URL.'appointments/saveBooking' ?>" method="post">-->
	<form name="complete_booking" id="complete_booking" action="" method="post">
	<select name="uid" id="uid"><!--class="custom-select"-->
	<option value="">Select an user</option>
	<?php echo $user_array; ?>
	</select>
	<label id="user_sec-error" class="error"></label>
	<input type="password" placeholder="Re-Enter Password :" class="user-in">
	<textarea rows="5" cols="5" placeholder="Comments (Optional) :" id="msg"></textarea>
	
	<input type="hidden" name="rownum" id="rownum" value=""/>
	<input type="hidden" name="booking_date" id="booking_date" value=""/>
	<input type="hidden" name="clinic_id" id="clinic_id" value="<?php echo $clinic_id;?>"/>
	<input type="hidden" name="ex_captcha" id="ex_captcha" value="<?php echo $_SESSION['captcha_val'] ?>" />
	<input type="hidden" name="book_user_type" id="book_user_type" value="<?php echo $this->Session->read('reid_user_type'); ?>" />
	<input type="hidden" name="start_time" id="start_time" value="" />
	<input type="hidden" name="multiplier" id="multiplier" value="" />
	
	<div class="code-b">
	<?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'booking_captca_img_val')); ?>
	</div>
	<?php $manager_cap_val=$_SESSION['captcha_val']; ?>
	<div class="code-in"><input name="booking_captcha" placeholder="Enter captcha value" class="user-in" id="booking_captcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" /><span id="msg_new" class="error"></span></div>
	<div class="text_1">First Consultation Fee : $500</div>
	<div class="text_2">There are no additional booking fees.</div>
	<button type="button" name="" class="btn_reschedule" onclick="save_booking_appointment()">Book Now</button>
	</form>
        </div>
    </div>
</div>
<div id="rescheduleappointment" class="well">
	<div class="fade_cont">
        <div class="rescheduleappointment_close btnclose">X</div>
        <h2>Reschedule Appointment</h2>
        <div class="reschedule_form">
		<label>User Name:</label>
		<span id="r_username"></span>
            
	    <?php $slot_gap =15; ?> <!--Individual slot gap for timing--->
		<input type="text" placeholder="Date of Birth" class="user-in-date" id="rs_datepicker" onchange="available_time(this.value,'<?php echo $slot_gap?>')" value="">
		
            <select name="" class="custom-select" id='all_timings'>
                <option value="">Select Time :</option>
                
            </select>
	    <input type="hidden" name="clinicid" id="clinicid" value="<?php echo $clinic_id;?>"/>
	    <input type="hidden" name="user_id" id="user_id" value=""/>
	    <input type="hidden" name="res_rownum" id="res_rownum" value=""/>
	    <input type="hidden" name="select_date" id="select_date" value=""/>
	    <input type="hidden" name="res_book_user_type" id="res_book_user_type" value="<?php echo $this->Session->read('reid_user_type'); ?>" />
	    <textarea rows="5" cols="5" placeholder="Comments (Optional) :" id="message"></textarea>
	    
		<div class="code-b">
		<?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'booking_recaptca_img_val')); ?>
		</div>
		<?php $manager_cap_val=$_SESSION['captcha_val']; ?>
		<div class="code-in"><input name="booking_captcha" placeholder="Enter captcha value" class="user-in" id="booking_recaptcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" /><span id="msg_new" class="error"></span></div>
          
            <button type="button" name="" class="btn_reschedule" onclick="save_reschdule_appointment()">Book Now</button>
        </div>
    </div>
</div>

	