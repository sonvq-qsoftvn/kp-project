	
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>All Appointments</h2></div></div>
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
					
					<div class="appointment_table">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appointment_info">
							<tr class="appointment_info_title">
								<td class="col-1">SL No</td>
								<td class="col-4">Clinic Name</td>
								<td class="col-5">Speciality</td>
								<td class="col-6">Appointments</td>
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
									foreach($all_appointments as $k=>$appointment)
									{
										$clinic_details	 = $appointment[0];
										$clinic_appointments = $appointment[1];
										$speciality_info 	 = $appointment[2];
							?>
										<tr class="<?php echo ($k%2==0)?'client_info_cont_g_bar':'client_info_cont_y_bar'; ?>">
											<td class="col-1"><?php echo $i; ?></td>
											<td class="col-4"><?php echo $this->Html->link($clinic_details['Clinic']['name'], array('controller' => 'clinics', 'action' => 'clincwall/'.$clinic_details['Clinic']['id']), array('class' => 'cancel', 'target' => '_blank')); ?></td>
											<td class="col-5"><?php echo (isset($speciality_info['Specialitie']['specialities_name']))?$speciality_info['Specialitie']['specialities_name']:'No speciality'; ?></td>
											<td class="col-6">
												<?php
													$app = $pend = $can = 0;
													if(!empty($clinic_appointments))
													{
														foreach($clinic_appointments as $clinic_appointment)
														{
															if($clinic_appointment['Appointment']['status']==2) $app++;
															
															if($clinic_appointment['Appointment']['status']==1 || $clinic_appointment['Appointment']['status']==0) $pend++;
															
															if($clinic_appointment['Appointment']['status']==3) $can++;
														}
														
														echo ($app)? '<p><span class="label label-success">'.$app.' Approved appointments</span></p>':'';
														echo ($pend)? '<p><span class="label label-warning">'.$pend.' Pending appointments</span></p>':'';
														echo ($can)? '<p><span class="label label-danger">'.$app.' Approved appointments</span></p>':'';
													}
													else
													{
														echo '<p><span class="label label-default">No appointment booked yet</span></p>';
													}
												?>
											</td>
											<td class="col-7">
												<?php
													echo '<span><a href="'.BASE_URL.'appointments/clinic_appointment_details/id:'.$clinic_details['Clinic']['id'].'">'.$this->Html->image('../admin/img/icons/gear.png',array('alt'=>'All appointments')).'</a></span>';
												?>
											</td>
										</tr>
							<?php
										$i++;
									}
								}
								else
								{
									echo '<tr class="appointment_info_cont">
											<td class="col-1"></td>
											<td class="col-2"></td>
											<td class="col-3"></td>
											<td class="col-4">No appointments found</td>
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