	
	<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
	<script>
		$(document).ready(function () {
			$('#makeanappointment').popup({
			  transition: 'all 0.3s',
			  scrolllock: true
			});
			manager_captcha_reload();
			
			//clinic_name clinic_id booking_date booking_time booking_start_time booking_end_time
			
			$('#confirm_booking').click(function(){
				
				var o_captcha_val = $('#ex_captcha').val();
				var s_captcha_val = $('#booking_captcha').val();
				var e = 0;
				if (s_captcha_val.search(/\S/)==-1) {
					$('#msg').html('<i style="color:red; border: 1px solid red;">Please enter captcha</i>');
					e++;
				}
				else{
					if (o_captcha_val != s_captcha_val) {
						$('#msg').html('<i style="color:red; border: 1px solid red;">Wrong Captcha</i>');
						e++;
					}
				}
				
				if (e == 0) {
					$("#complete_booking").submit();
				}
			});
		});
	</script>
	<script>
		function change_cal_month(month, year, date)
		{
			$('#cal_month').val(month);
			$('#cal_year').val(year);
			$('#cal_date').val(date);
			
			$('#cal_navigation').submit();
		}
		
		function change_cal_month_n(month, year, date, type)
		{
			if (type=='week')
			{
				$('#cal_navigation').attr('action', '<?php echo BASE_URL ?>appointments/book_appointment/clinic:<?php echo $sec_clinic; ?>/cal:week');
			}
			
			$('#cal_month').val(month);
			$('#cal_year').val(year);
			$('#cal_date').val(date);
			
			$('#cal_navigation').submit();
		}
		
		function ajax_clinic_timing(app_date)
		{
			var date = app_date.split('/');
			var month = date[0];
			var day = date[1];
			var year = date[2];
			
			$('#cal_month').val(month);
			$('#cal_year').val(year);
			$('#cal_date').val(day);
			$('#req_type').val('2');
			$('#req_date').val(app_date);
			
			$('#cal_navigation').submit();
		}
		
		function booking_appointment(clinic_id, booking_date, booking_start_time, booking_end_time, open_slot_id, slot_multiplier)
		{
			//alert(open_slot_id+' '+slot_multiplier);
			
			var url = '<?php echo BASE_URL.'appointments/start_booking'; ?>';
			$.ajax({
					type: 'post',
					url: url,
					data: { clinic_id: clinic_id, booking_date: booking_date, booking_start_time: booking_start_time, booking_end_time: booking_end_time, open_slot_id: open_slot_id, slot_multiplier: slot_multiplier },
					beforeSend: function(xhr) {
					    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					},
					success:function(result){
						//alert(result);
						var get_result=result.split('|@|');
						
						if (get_result[0]==1) {
							$('#clinic_name').val(get_result[1]);
							$('#clinic_id').val(clinic_id);
							$('#booking_date').val(get_result[2]);
							$('#booking_time').val(get_result[3]);
							$('#booking_start_time').val(get_result[4]);
							$('#booking_end_time').val(get_result[5]);
							
							$('#booking_slot_id').val(get_result[6]);
							$('#booking_slot_multiplier').val(get_result[7]);
						}
						else
						{
							$('#pop_up_cont').html('<div id="update_errorMessage" class="page_top_error">'+get_result[1]+'</div>');
						}
						//clinic_name clinic_id booking_date booking_time booking_start_time booking_end_time
					}
			});
		}
		
		function manager_captcha_reload()
		{
			$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
				$('#booking_captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
			});
		}
		
		//----------------captcha check for user_registration---------------------
		function captcha_check(sess_cap_val)
		{	
			var sub_catcha_val=document.getElementById('booking_captcha').value;
			if (sub_catcha_val != '' && sub_catcha_val != sess_cap_val)
			    $("#msg").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
			else
				$("#msg").html("");
		}
	</script>
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Book An Appointment</h2></div></div>
		<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
		<div class="container">
			<div class="container_inner">
				<div class="manage_appointment_form">
					<form name="book_appointment" id="book_appointment" action="" method="post">
						<input type="hidden" name="" id="" value="" />
						<div class="clinic_name">
							<h2><span>Clinic Name:</span> <?php echo $clinic_details['Clinic']['name']; ?></h2>
							<div class="col-1">
								<input type="text" placeholder="Appointment Date" value="<?php echo ($req_date)?$req_date:date('m/d/Y'); ?>" id="clinic_cal" class="datepicker user-in-date" onchange="ajax_clinic_timing(this.value);" />
								<label id="date_msg" style="font-weight: normal;"><?php echo $clinic_open_status_msg; ?></label>
							</div>
							<div class="col-2">
								<div class="choose_slot">Choose slot<sup>*</sup> :</div>
								<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/green_icon.jpg',array('alt'=>'Available')); ?><a href="#">Available</a></div>
								<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/yellow_icon.jpg',array('alt'=>'Pending')); ?><a href="#">Pending</a></div>
								<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/red_icon.jpg',array('alt'=>'Booked')); ?><a href="#">All Booked</a></div>
								<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/gray_icon.jpg',array('alt'=>'Unavailable')); ?><a href="#">Unavailable</a></div>
								<div class="upcoming_past">
									<button type="button" <?php if($cal_type == 'month')echo 'class="active"'; ?>  onclick="window.location='<?php echo BASE_URL.'appointments/book_appointment/clinic:'.$sec_clinic.'/cal:month' ?>'">Monthly</button>
									<button type="button" <?php if($cal_type == 'week')echo 'class="active"'; ?> onclick="window.location='<?php echo BASE_URL.'appointments/book_appointment/clinic:'.$sec_clinic.'/cal:week' ?>'">Weekly</button>
								</div>
							</div>    
						</div>	
					</form>
				</div>
				
				<?php
					$concat = 'this date';
				
					if($clinic_open_status == 1)
					{
						if($cal_type == 'month')
						{
							$calendar = new CalendarHelper();
							echo $calendar->show($sec_clinic);
						}
						elseif($cal_type == 'week')
						{
							$weekly_calendar = $this->WeeklyCalendar;
							$weekly_calendar->EasyWeeklyCalClass($dia, $mes, $ano, $sec_clinic);
							echo '<div class="manage_appointment_table">'.$weekly_calendar->showCalendar ().'</div>';
						}
						else
						{
							$calendar = new CalendarHelper();
							echo $calendar->show();
						}
					}
					else
					{
						if($req_date) $concat = 'this date';
						else $concat = 'today';
						
						echo '<div class="clinic_name"><div class="page_top_error">Sorry, clinic will remain closed on '.$concat.' or appointment booking is not avilable yet</div></div>';
					}
				?>
				
				<div class="month_title" style="display: none;">
					<div class="month_is">September - 2014</div>
					<div class="monthly_appointment_page">
						<a href="#" class="left_arrow"><?php echo $this->Html->image('../frontend/images/monthly_left_arrow.png',array('alt'=>'Left arrow')); ?></a>
						<a href="#" class="right_arrow"><?php echo $this->Html->image('../frontend/images/monthly_right_arrow.png',array('alt'=>'Right arrow')); ?></a>
					</div>
				</div>
				<div class="monthly_appointment_table" style="display: none;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="monthly_appointment_info">
						<tr class="monthly_appointment_info_title">
							<td class="coll">Monday</td>
							<td class="coll">Tuesday</td>
							<td class="coll">Wednesday</td>
							<td class="coll">Thursday</td>
							<td class="coll">Friday</td>
							<td class="coll">Saturday</td>
							<td class="coll">Sunday</td>
						</tr>
						<tr class="monthly_appointment_info_cont">
							<td class="coll g_back">31</td>
							<td class="coll">1<span>25 Appointment Slots Available</span></td>
							<td class="coll">2<span>40 Appointment Slots Available</span></td>
							<td class="coll gg_back">3</td>
							<td class="coll">4<span>25 Appointment Slots Available</span></td>
							<td class="coll">5<span>3 Appointment Slots Available</span></td>
							<td class="coll gg_back">6</td>
						</tr>
						<tr class="monthly_appointment_info_cont">
							<td class="coll">7<span>12 Appointment Slots Available</span></td>
							<td class="coll">8<span>35 Appointment Slots Available</span></td>
							<td class="coll">9<span>55 Appointment Slots Available</span></td>
							<td class="coll gg_back">10</td>
							<td class="coll">11<span>5 Appointment Slots Available</span></td>
							<td class="coll">12<span>60 Appointment Slots Available</span></td>
							<td class="coll gg_back">13</td>
						</tr>
						<tr class="monthly_appointment_info_cont">
							<td class="coll r_back">14<span>Already Full</span></td>
							<td class="coll">15<span>25 Appointment Slots Available</span></td>
							<td class="coll">16<span>10 Appointment Slots Available</span></td>
							<td class="coll gg_back">17</td>
							<td class="coll">18<span>1 Booked Appoientment</span></td>
							<td class="coll">19<span>5 Appointment Slots Available</span></td>
							<td class="coll gg_back">20</td>
						</tr>
						<tr class="monthly_appointment_info_cont">
							<td class="coll">21<span>25 Appointment Slots Available</span></td>
							<td class="coll">22<span>9 Appointment Slots Available</span></td>
							<td class="coll">23<span>45 Appointment Slots Available</span></td>
							<td class="coll gg_back">24</td>
							<td class="coll">25<span>20 Appointment Slots Available</span></td>
							<td class="coll">26<span>25 Appointment Slots Available</span></td>
							<td class="coll gg_back">27</td>
						</tr>
						<tr class="monthly_appointment_info_cont">
							<td class="coll">28<span>1 Booked Appoientment</span></td>
							<td class="coll">29<span>25 Appointment Slots Available</span></td>
							<td class="coll r_back">30<span>Already Full</span></td>
							<td class="coll g_back">1</td>
							<td class="coll g_back">2</td>
							<td class="coll g_back">3</td>
							<td class="coll g_back">4</td>
						</tr>
					</table>
			   </div>
		   </div>
		</div>
	</section>
	
	<div class="scrolltop"></div>
	
	<div id="makeanappointment" class="well">
		<div class="fade_cont">
			<div class="makeanappointment_close btnclose">X</div>
			<h2>Make An Appointment</h2>
			<div id="pop_up_cont">
				<div class="reschedule_form">
					<form name="complete_booking" id="complete_booking" action="<?php echo BASE_URL.'appointments/complete_booking' ?>" method="post">
						<input type="text" placeholder="clinic name" name="clinic_name" id="clinic_name" readonly="true" value="" class="user-in" />
						<input type="hidden" name="clinic_id" id="clinic_id" readonly="true" value="" />
						<input type="text" placeholder="Booking date :" name="booking_date" id="booking_date" readonly="true" value="" class="user-in" />
						<input type="text" placeholder="Booking time :" name="booking_time" id="booking_time" readonly="true" value="" class="user-in" />
						<input type="hidden" name="booking_start_time" id="booking_start_time" readonly="true" value="" />
						<input type="hidden" name="book_user_type" id="book_user_type" readonly="true" value="1" />
						<input type="hidden" name="booking_end_time" id="booking_end_time" readonly="true" value="" />
						<input type="hidden" name="ex_captcha" id="ex_captcha" value="<?php echo $_SESSION['captcha_val'] ?>" />
						
						<input type="hidden" name="booking_slot_id" id="booking_slot_id" value="" />
						<input type="hidden" name="booking_slot_multiplier" id="booking_slot_multiplier" value="" />
						
						<textarea rows="5" cols="5" id="booking_reason" name="booking_reason" placeholder="Reason for booking (Optional) :"></textarea>
						<div class="code-b">
							<?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'booking_captca_img_val')); ?>
						</div>
						<?php $manager_cap_val=$_SESSION['captcha_val']; ?>
						<div class="code-in"><input name="booking_captcha" placeholder="Enter captcha value" class="user-in" id="booking_captcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" /><span id="msg"></span></div>
						<div class="text_1">First Consultation Fee : $500</div>
						<div class="text_2">There are no additional booking fees.</div>
						<button type="button" id="confirm_booking" name="book" class="btn_reschedule">Book Now</button>
					</form>
				</div>
			</div>
		</div>
	</div>
