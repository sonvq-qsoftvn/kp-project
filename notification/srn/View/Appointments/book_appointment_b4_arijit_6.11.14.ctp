	
	<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
	<script>
		$(document).ready(function () {
			$('#makeanappointment').popup({
			  transition: 'all 0.3s',
			  scrolllock: true
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
				$('#cal_navigation').attr('action', '<?php echo BASE_URL ?>appointments/book_appointment/cal:week');
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
							echo $calendar->show();
						}
						elseif($cal_type == 'week')
						{
							$weekly_calendar = $this->WeeklyCalendar;
							$weekly_calendar->EasyWeeklyCalClass($dia, $mes, $ano);
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
				
				<div class="month_title">
					<div class="month_is">September - 2014</div>
					<div class="monthly_appointment_page">
						<a href="#" class="left_arrow"><?php echo $this->Html->image('../frontend/images/monthly_left_arrow.png',array('alt'=>'Left arrow')); ?></a>
						<a href="#" class="right_arrow"><?php echo $this->Html->image('../frontend/images/monthly_right_arrow.png',array('alt'=>'Right arrow')); ?></a>
					</div>
				</div>
				<div class="monthly_appointment_table">
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
			<div class="reschedule_form">
				<input type="password" placeholder="Re-enter Password :" class="user-in">
				<input type="text" placeholder="Contact No :" class="user-in">
				<textarea rows="5" cols="5" placeholder="Comments (Optional) :"></textarea>
				<div class="code-b"><?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'manager_captca_img_val')); ?></div>
				<div class="code-in">
					<input type="text" placeholder="Enter The Code :" class="user-in">
				</div>
				<div class="text_1">First Consultation Fee : $500</div>
				<div class="text_2">There are no additional booking fees.</div>
				<button type="button" name="" class="btn_reschedule">Book Now</button>
			</div>
		</div>
	</div>
