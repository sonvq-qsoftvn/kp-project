	<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
	<script>
		$(document).ready(function () {
			$('#rescheduleapp').popup({
			  transition: 'all 0.3s',
			  scrolllock: true
			});
			manager_captcha_reload();
		});
		
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
	
        

</script>        
        
        
        
        
        
	
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>My Appointments</h2></div></div>
		<div class="container">
			<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
			<div class="container_inner">
				
				<form name="search_appointment" id="search_appointment" action="<?php echo BASE_URL;?>appointments/appointments" method="post">
					<input type="hidden" name="clinic" id="clinic" value="<?php echo (isset($this->params->named['clinic']))?$this->params->named['clinic']:0 ?>" />
					<input type="hidden" name="show_type" id="show_type" value="<?php echo $show_type; ?>" />
					
					<div class="appointment_form">
						<div class="col-1"><input type="text" value="<?php echo $this->request->data('appointment_date'); ?>" name="appointment_date" placeholder="Appointment Date" class="datepicker user-in-date" /></div>
						<div class="col-2"><input type="text" name="clinic_id" placeholder="Clinic Name" class="user-in" /></div> 
                                                
                                                      <div id="result">sdfsd</div>                                              
                                                
						<div class="col-3"><button type="button" class="appointment_search" onclick="change_show('<?php echo $show_type; ?>')">Appointment Search</button></div>             
					</div>
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
								<td class="col-4">Clinic Name</td>
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
										$start_time = date('H:i', strtotime($starthour.':'.$startminutes));
										
							?>
										<tr class="appointment_info_cont">
											<td class="col-1"><?php echo $i; ?></td>
											<td class="col-2"><?php echo date('m/d/Y', strtotime($appointment['Appointment']['date'])); ?></td>
											<td class="col-3"><?php echo $app_time; ?></td>
											<td class="col-4"><?php echo $this->Html->link($appointment['Clinic']['name'], array('controller' => 'clinics', 'action' => 'clincwall/'.$appointment['Clinic']['id']), array('class' => 'cancel', 'target' => '_blank')); ?></td>
											<td class="col-5">Lorem ipsum</td>
											<td class="col-6"><?php echo $status; ?></td>
											<td class="col-7">
												<?php
													if($this->Session->read('reid_user_type') == 2)
													{
														if($appointment['Appointment']['status']==0){
															if($appointment['Appointment']['date'] > date('Y-m-d')){
																echo '<span><a href="'.BASE_URL.'appointments/confirm_appointment/clinic:'.$appointment['Appointment']['clinic_id'].'/id:'.$appointment['Appointment']['id'].'">'.$this->Html->image('../frontend/images/icon1.png',array('alt'=>'Approve appointment')).'</a></span>';
															}
														}
													}
													elseif($this->Session->read('reid_user_type') == 1)
													{
														if($appointment['Appointment']['status']==1){
															if($appointment['Appointment']['date'] > date('Y-m-d')){
																echo '<span><a href="'.BASE_URL.'appointments/confirm_appointment/clinic:'.$appointment['Appointment']['clinic_id'].'/id:'.$appointment['Appointment']['id'].'">'.$this->Html->image('../frontend/images/icon1.png',array('alt'=>'Approve appointment')).'</a></span>';
															}
														}
													}
													
													echo '<span><a href="'.BASE_URL.'appointments/delete_appointment/id:'.$appointment['Appointment']['id'].'">'.$this->Html->image('../frontend/images/icon2.png',array('alt'=>'Delete appointment')).'</a></span>';
													
													if($appointment['Appointment']['date'] > date('Y-m-d')){
														echo '<span><a href="javascript:void(0)" onclick="reshedule_appointment_fnc(\''.$appointment['Appointment']['clinic_id'].'\', \''.$start_time.'\', \''.$appointment['Appointment']['id'].'\')" class="initialism rescheduleapp_open">'.$this->Html->image('../frontend/images/icon3.png',array('alt'=>'Reshedule appointment')).'</a></span>';
													}
													
													if($appointment['Appointment']['status'] < 2 && $appointment['Appointment']['date'] < date('Y-m-d')){
														echo '<span><a href="javascript:void(0)" onclick="reshedule_appointment_fnc(\''.$appointment['Appointment']['clinic_id'].'\', \''.$start_time.'\', \''.$appointment['Appointment']['id'].'\')" class="initialism rescheduleapp_open">'.$this->Html->image('../frontend/images/icon3.png',array('alt'=>'Reshedule appointment')).'</a></span>';
													}
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
				</form>
			</div>
		</div>
	</section>
    
	<div class="scrolltop"></div>
	
	<div id="rescheduleapp" class="well">
		<div class="fade_cont">
			<div class="rescheduleapp_close btnclose">X</div>
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