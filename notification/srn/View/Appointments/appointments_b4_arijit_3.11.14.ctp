	<?php echo $this->Html->script('../frontend/js/jquery.popupoverlay.js'); ?>
	<script>
		$(document).ready(function () {
			$('#rescheduleapp').popup({
			  transition: 'all 0.3s',
			  scrolllock: true
			});
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
					url : url,
					success:function(result){
						alert(result);
						//$("#div1").html(result);
					}
				});
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
										$app_time = $appointment['Oh']['fromhour'].'.'.$appointment['Oh']['fromminutes'];
										
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
				</form>
			</div>
		</div>
	</section>
    
	<div class="scrolltop"></div>
	
	<div id="rescheduleapp" class="well">
		<div class="fade_cont">
			<div class="rescheduleapp_close btnclose">X</div>
			<h2>Reschedule Appointment</h2>
			<div class="reschedule_form">
				<input type="text" placeholder="Date of Birth" class="datepicker user-in-date">
				<select name="" class="custom-select">
					<option value="">Select Time :</option>
					<option value="">test 1</option>
					<option value="">test 2</option>
				</select>
				<div class="code-b"><?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'Captcha')); ?></div>
				<div class="code-in"><input type="text" placeholder="Enter The Code" class="user-in" /></div>
				<button type="button" name="" class="btn_reschedule">Reschedule Now</button>
			</div>
		</div>
	</div>
	