	<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
	<script>
		$(document).ready(function () {
			$('#rescheduleappointment').popup({
			  transition: 'all 0.3s',
			  scrolllock: true
			});
			
			$('#makeanappointment').popup({
				transition: 'all 0.3s',
				scrolllock: true
			});
			
			manager_captcha_reload();
			manager_captcha_reload_new();
			
			//clinic_name clinic_id booking_date booking_time booking_start_time booking_end_time
			
		});
		
		function check_booking_details()
		{
			var o_captcha_val = $('#ex_captcha').val();
			var s_captcha_val = $('#booking_captcha').val();
			var user_book = $('#user_sec').val();
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
			
			if (e == 0) {
				$("#complete_booking").submit();
			}
		}
		
		function check_reshedule_main()
		{
			var o_captcha_val = $('#ex_captcha_res').val();
			var s_captcha_val = $('#manager_captcha').val();
			var booking_time_re = $('#booking_time_re').val();
			var e = 0;
			
			if (booking_time_re.search(/\S/)==-1) {
				$('#booking_time_re-error').html('Please select an appointment time');
				e++;
			}
			else{
				$('#booking_time_re-error').html('');
			}
			
			if (s_captcha_val.search(/\S/)==-1) {
				$('#msg_new_res').html('Please enter captcha');
				e++;
			}
			else{
				if (o_captcha_val != s_captcha_val) {
					$('#msg_new_res').html('Wrong Captcha');
					e++;
				}
				else{
					$('#msg_new_res').html('');
				}
			}
			
			if (e == 0) {
				$("#reshedule_appointment").submit();
			}
		}
		
		function change_show(type)
		{
			$('#show_type').val(type);
			$('#search_appointment').submit();
		}
		
		function change_time_shedule(id)
		{
			var url = '<?php echo BASE_URL.'appointments/appointments_details/id:'; ?>'+id;
			$.ajax({
					type: 'get',
					url: url,
					beforeSend: function(xhr) {
					    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					},
					success:function(result){
						//alert(result);
						//$("#div1").html(result);
						var get_result=result.split('|@|');
						//alert(get_result[2]);
						$('#pop_date').val(get_result[0]);
						$('#pop_slots').html(get_result[2]);
						$('#booking_id').val(id);
						
						$("#pop_slots").each(function(){
							$(this).wrap( "<span class='select-wrapper'></span>" );
							$(this).after("<span class='holder'></span>");
						});
						
						$("#pop_slots").change(function(){
							var selectedOption = $(this).find(":selected").text();
							$(this).next(".holder").text(selectedOption);
						}).trigger('change');
						
						$("#pop_slots").change(function(){
							$(this).next(".holder").attr('style', 'z-index:0');
						}).trigger('change');
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
			var sub_catcha_val=document.getElementById('manager_captcha').value;
			if (sub_catcha_val != '' && sub_catcha_val != sess_cap_val)
			    $("#msg").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
			else
				$("#msg").html("");
		}
		
		function manager_captcha_reload_new()
		{
			$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
				$('#manager_captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
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
				$('#cal_navigation').attr('action', '<?php echo BASE_URL ?>appointments/clinic_appointment_details/id:<?php echo $clinic_id; ?>/cal:week');
			}
			
			$('#cal_month').val(month);
			$('#cal_year').val(year);
			$('#cal_date').val(date);
			
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
							
							$('.select-wrapper').css('margin-bottom', 0);
							$('.select-wrapper').find('span').css('z-index', 0);
						}
						else
						{
							$('#pop_up_cont').html('<div id="update_errorMessage" class="page_top_error">'+get_result[1]+'</div>');
						}
						//clinic_name clinic_id booking_date booking_time booking_start_time booking_end_time
					}
			});
		}
		
		function reshedule_appointment_fnc(clinic_id, start_time, appointment_id)
		{
			var url = '<?php echo BASE_URL.'appointments/edit_booking'; ?>';
			
			$.ajax({
					type: 'post',
					url: url,
					data: { clinic_id: clinic_id, start_time: start_time, appointment_id: appointment_id },
					beforeSend: function(xhr) {
					    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					},
					success:function(result){
						//alert(result);
						var get_result=result.split('|@|');
						
						if (get_result[0]==1) {
							$('#clinic_id_re').val(clinic_id);
							$('#user_name').val(get_result[1]);
							$('#booking_id_re').val(appointment_id);
							$('#booking_date_re').val(get_result[2]);
							$('#booking_time_re').html(get_result[3]);
							
							$('.select-wrapper').css('margin-bottom', 0);
							$('.select-wrapper').find('span').css('z-index', 0);
						}
						else
						{
							$('#pop_up_cont').html('<div id="update_errorMessage" class="page_top_error">'+get_result[1]+'</div>');
						}
					}
			});
		}
		
		function confirm_appointment(url)
		{
			var answer = confirm("Confirm this appointment?");
			if (answer){
			    window.location = url;
			}
			else{
				return false;
			}
		}
		
		function confirm_delete(url)
		{
			var answer = confirm("Delete this appointment?");
			if (answer){
			    window.location = url;
			}
			else{
				return false;
			}
		}
		
		function confirm_remove_exp(url)
		{
			var answer = confirm("Open this appointment slot?");
			if (answer){
			    window.location = url;
			}
			else{
				return false;
			}
		}
		
		function confirm_block(url)
		{
			var answer = confirm("Block this appointment slot?");
			if (answer){
			    window.location = url;
			}
			else{
				return false;
			}
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
		
		function appointment_search(val)
		{
			$('#show_type').val(val);
			$('#search_appointment').submit();
		}
		
	</script>
	
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>All Appointments</h2></div></div>
		<div class="container">
			<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
			<div class="container_inner">
				<div class="manage_appointment_form">
					<form name="search_appointment" id="search_appointment" action="<?php echo BASE_URL;?>appointments/clinic_appointment_details/id:<?php echo $clinic_id ?>" method="post">
						<input type="hidden" name="clinic" id="clinic" value="<?php echo (isset($this->params->named['id']))?$this->params->named['id']:0 ?>" />
						<input type="hidden" name="show_type" id="show_type" value="<?php echo $show_type; ?>" />
						
						<div class="clinic_name"><h2><span>Clinic Name:</span> <?php echo $clinic_details['Clinic']['name']; ?></h2></div>
						
						<div class="col-1"><input type="text" value="<?php echo $req_date; ?>" name="appointment_date" placeholder="Appointment Date" class="datepicker user-in-date" onchange="ajax_clinic_timing(this.value);" /></div>
						<div class="col-2">
							<div class="choose_slot">Choose slot<sup>*</sup> :</div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/green_icon.jpg',array('alt'=>'Available')); ?><a href="#">Available</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/yellow_icon.jpg',array('alt'=>'Pending')); ?><a href="#">Pending</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/red_icon.jpg',array('alt'=>'Booked')); ?><a href="#">All Booked</a></div>
							<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/gray_icon.jpg',array('alt'=>'Unavailable')); ?><a href="#">Unavailable</a></div>
							<div class="upcoming_past">
								<button type="button" <?php if($cal_type == 'month')echo 'class="active"'; ?> onclick = "appointment_search('month')" >Monthly</button>
								<button type="button" <?php if($cal_type == 'week')echo 'class="active"'; ?> onclick = "appointment_search('week')">Weekly</button>
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
                    <td class="coll">Monday 15.09.2014</td>
                    <td class="coll">Tuesday 16.09.2014</td>
                    <td class="coll">Wednesday 17.09.2014</td>
                    <td class="coll y_back">Thursday 18.09.2014</td>
                    <td class="coll">Friday 19.09.2014</td>
                    <td class="coll">Saturday 20.09.2014</td>
                    <td class="coll">Sunday 21.09.2014</td>
                    <div class="manage_appointment_page">
                    	<a href="#" class="left_arrow"><img src="images/manage_left_arrow.png" /></a>
                        <a href="#" class="right_arrow"><img src="images/manage_right_arrow.png" /></a>
                    </div>
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
					for($i=0;$i<288;$i++)
					{
						?>
						 <tr class="manage_appointment_info_cont">
							<td class="coll col-1"><span>From</span>: <?php echo $start=create_hr_min($i);?><br><span>To</span>: <?php echo $end=create_hr_min($i+1);?></td>
						<?php
						
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
							<td class="coll" rowspan="<?php echo $dc[$j];?>"><?php echo $i.'-----'.$j;echo'<br/>';echo $dc[$j];echo"<br/>";echo$count;?></td>
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
					
				<div class="upcoming_past">
					<button type="button" onclick="change_show('2');" <?php echo ($show_type==2)?'class="active"':''; ?>>Past Appointments</button>
					<button type="button" onclick="change_show('1');" <?php echo ($show_type==1)?'class="active"':''; ?>>Upcoming Appointments</button>
				</div>
					
				<div class="appointment_table">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appointment_info">
						<tr class="appointment_info_title">
							<td class="col-1">SL No</td>
							<td class="col-2">Date</td>
							<td class="col-3">Time</td>
							<td class="col-4">User Name</td>
							<td class="col-5">Speciality</td>
							<td class="col-6">Status</td>
							<td class="col-7">Action</td>
						</tr>
						<?php
							if(isset($this->params->named['page']) && $this->params->named['page'] > 2)
								$i = ($page_limit * ($this->params->named['page']-1))+1;
							elseif(isset($this->params->named['page']) && $this->params->named['page'] == 2)
								$i = $page_limit + 1;
							else
								$i = 1;
								
							if(!empty($all_appointments))
							{
								foreach($all_appointments as $appointment)
								{
									//$app_time = $appointment['Oh']['fromhour'].'.'.$appointment['Oh']['fromminutes'];
									
									$status = '<span class="label label-danger">Pending for approval</span>';
									
									if($appointment['Appointment']['status'] == 0){
										$status = '<span class="label label-danger">Pending for approval</span>'; $class = '';
									}
									//elseif($appointment['Appointment']['status'] == 1){
									//	$status = '<span class="label label-warning">Pending for admin approval</span>';
									//}
									elseif($appointment['Appointment']['status'] == 2){
										$status = '<span class="label label-success">Approved</span>'; 
									}
									
									//time calculation starts

									//picking up the appointment breakup time in minutes
									$breakup=15;
									
									//picking up the basic slot first 
									$fh=$appointment['Oh']['fromhour'];
									$fm=$appointment['Oh']['fromminutes'];
															
									$th=$appointment['Oh']['tohour'];
									$tm=$appointment['Oh']['tominutes'];
									
									//picking up the multiplier
									$multiplier=$appointment['Appointment']['multiplier'];
									
									$endhour=$fh;
									$endminutes=$fm+($breakup*$multiplier);
									if($endminutes>=60)
									{
										$endhour=$endhour+($endminutes/60);
										$endminutes=($endminutes%60);
									}
									$starthour=$endhour;
									$startminutes=$endminutes-$breakup;
									if($startminutes<0)
									{
										
										$arr=$this->Appointment->calculate_starthour_and_minutes(array($starthour,$startminutes));
										$starthour=$arr[0];
										$startminutes=$arr[1];
									}
									
									$app_time = sprintf('%02d',$starthour)." : ".sprintf('%02d',$startminutes).' - '.sprintf('%02d',$endhour)." : ".sprintf('%02d',$endminutes);
						?>
									<tr class="appointment_info_cont">
										<td class="col-1"><?php echo $i; ?></td>
										<td class="col-2"><?php echo date('m/d/Y', strtotime($appointment['Appointment']['date'])); ?></td>
										<td class="col-3"><?php echo $app_time; ?></td>
										<td class="col-4"><?php echo $appointment['User']['first_name'].' '.$appointment['User']['last_name']; ?></td>
										<td class="col-5">Lorem ipsum</td>
										<td class="col-6"><?php echo $status; ?></td>
										<td class="col-7">
											<?php
												if($this->Session->read('reid_user_type') == 2)
												{
													if($appointment['Appointment']['status']==0)
														echo '<span><a href="'.BASE_URL.'appointments/approve_appointment/id:'.$appointment['Appointment']['id'].'">'.$this->Html->image('../frontend/images/icon1.png',array('alt'=>'Approve appointment')).'</a></span>';
												}
											
												echo '<span><a href="'.BASE_URL.'appointments/delete_appointment/id:'.$appointment['Appointment']['id'].'">'.$this->Html->image('../frontend/images/icon2.png',array('alt'=>'Delete appointment')).'</a></span>';
												
												echo '<span><a href="javascript:void(0)" onclick="change_time_shedule(\''.$appointment['Appointment']['id'].'\')" class="initialism rescheduleapp_open">'.$this->Html->image('../frontend/images/icon3.png',array('alt'=>'Reshedule appointment')).'</a></span>';
											?>
											<!--<span><a href="#"><img src="images/icon1.png" /></a></span> -->
										</td>
									</tr>
						<?php
									$i++;
								}
							}
							else
							{
								$p = ($show_type==2)?'past':'';
								echo '<tr class="appointment_info_cont">
										<td class="col-1"></td>
										<td class="col-2"></td>
										<td class="col-3"></td>
										<td class="col-4">No '.$p.' appointments found</td>
										<td class="col-5"></td>
										<td class="col-6"></td>
										<td class="col-7"></td>
									</tr>';
							}
						?>
					</table>
					
					<div class="row-fluid">
						<div class="span6">
							<div class="msg_table_pagination pagination">
								<ul>
									<?php
										// Shows the next and previous links
										echo $this->Paginator->prev(
											' ←',
											$options=array('tag'=>'li','class'=>'prev','disabledTag'=>'a'),
											null,
											array('tag'=>'li','disabledTag'=>'a','class'=>'prev disabled')
										);
										
										// Shows the page numbers
										echo $this->Paginator->numbers($options=array('tag'=>'li','separator'=>'','currentTag'=>'a','currentClass'=>'page_active','class'=>'page'));
										// Shows the next and previous links
										echo $this->Paginator->next(
											'→ ',
											$options=array('tag'=>'li','class'=>'next','disabledTag'=>'a'),
											null,
											array('tag'=>'li','disabledTag'=>'a','class'=>'next disabled')
										);
									?>
								</ul>
							</div>
						</div>
					</div>
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
						<input type="hidden" name="book_user_type" id="book_user_type" readonly="true" value="2" />
						<select name="user_sec" class="custom-select" id="user_sec">
							<option value="">Select an user</option>
							<?php echo $user_array; ?>
						</select>
						<label id="user_sec-error" class="error"></label>
						<input type="text" placeholder="Booking date :" name="booking_date" id="booking_date" readonly="true" value="" class="user-in" />
						<input type="text" placeholder="Booking time :" name="booking_time" id="booking_time" readonly="true" value="" class="user-in" />
						<input type="hidden" name="booking_start_time" id="booking_start_time" readonly="true" value="" />
						<input type="hidden" name="booking_end_time" id="booking_end_time" readonly="true" value="" />
						<input type="hidden" name="ex_captcha" id="ex_captcha" value="<?php echo $_SESSION['captcha_val'] ?>" />
						
						<input type="hidden" name="booking_slot_id" id="booking_slot_id" value="" />
						<input type="hidden" name="booking_slot_multiplier" id="booking_slot_multiplier" value="" />
						
						<textarea rows="5" cols="5" id="booking_reason" name="booking_reason" placeholder="Reason for booking (Optional) :"></textarea>
						<div class="code-b">
							<?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'booking_captca_img_val')); ?>
						</div>
						<?php $manager_cap_val=$_SESSION['captcha_val']; ?>
						<div class="code-in"><input name="booking_captcha" placeholder="Enter captcha value" class="user-in" id="booking_captcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" /><span id="msg_new" class="error"></span></div>
						<div class="text_1">First Consultation Fee : $500</div>
						<div class="text_2">There are no additional booking fees.</div>
						<button type="button" id="confirm_booking" onclick="check_booking_details()" name="book" class="btn_reschedule">Book Now</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div id="rescheduleappointment" class="well">
		<div class="fade_cont">
			<div class="rescheduleappointment_close btnclose">X</div>
			<h2>Reschedule Appointment</h2>
			
			<form name="reshedule_appointment" id="reshedule_appointment" action="<?php echo BASE_URL.'appointments/reshedule_appointment'; ?>" method="post">
				<div class="reschedule_form">
					<input type="hidden" name="clinic_id" id="clinic_id_re" value="" />
					<input type="hidden" name="booking_id_re" id="booking_id_re" value="" />
					<input type="text" name="user_name" placeholder="User Name" class="user-in" id="user_name" value="" readonly="true" />
					<input type="text" name="booking_date" placeholder="Appointment Date" class="user-in-date" id="booking_date_re" readonly="true" />
					<input type="hidden" name="ex_captcha_res" id="ex_captcha_res" value="<?php echo $_SESSION['captcha_val'] ?>" />
					<select name="booking_time_re" id="booking_time_re" class="custom-select">
						<option value="">Select time</option>
					</select>
					<label id="booking_time_re-error" class="error"></label>
					<div id="pop_slots"></div>
					<div class="code-b"><?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha', 'id' => 'manager_captca_img_val')); ?></div>
					<?php $manager_cap_val=$_SESSION['captcha_val']; ?>
					<div class="code-in"><input name="manager_captcha" placeholder="Enter captcha value" class="user-in" id="manager_captcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" /><span id="msg_new_res" class="error"></span></div>
					<button type="button" name="" onclick="check_reshedule_main()" class="btn_reschedule_main">Reschedule Now</button>
				</div>
			</form>
		</div>
	</div>
	
	