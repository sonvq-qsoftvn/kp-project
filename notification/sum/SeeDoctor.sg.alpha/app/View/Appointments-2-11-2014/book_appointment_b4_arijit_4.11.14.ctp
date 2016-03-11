	
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Book An Appointment</h2></div></div>
		<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
		<div class="container">
			<div class="container_inner">
				<div class="manage_appointment_form">
					<div class="clinic_name"><h2><span>Clinic Name:</span> Tan's Surgery</h2></div>
					<div class="col-1"><input type="text" placeholder="Appointment Date" id="datepicker" class="user-in-date"></div>
					<div class="col-2">
						<div class="choose_slot">Choose slot<sup>*</sup> :</div>
						<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/green_icon.jpg',array('alt'=>'Available')); ?><a href="#">Available</a></div>
						<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/yellow_icon.jpg',array('alt'=>'Pending')); ?><a href="#">Pending</a></div>
						<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/red_icon.jpg',array('alt'=>'Booked')); ?><a href="#">Booked</a></div>
						<div class="choose_slot_list"><?php echo $this->Html->image('../frontend/images/gray_icon.jpg',array('alt'=>'Unavailable')); ?><a href="#">Unavailable</a></div>
						<div class="upcoming_past">
							<button type="button" class="active">Monthly</button>
							<button type="button">Weekly</button>
						</div>
					</div>             
				</div>
				<?php
					echo $this->Html->css('../frontend/css/normalize.css');
					echo $this->Html->css('../frontend/css/datepicker.css');
					
					echo $this->Html->script('../frontend/js/jquery-1.7.1.min.js');
					echo $this->Html->script('../frontend/js/jquery-ui-1.8.18.custom.min.js');
				?>
				<script type="text/javascript">
					$(window).load(function () {
						$('#datepicker_new').datepicker({
							inline: true,
							//nextText: '&rarr;',
							//prevText: '&larr;',
							showOtherMonths: true,
							//dateFormat: 'dd MM yy',
							dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
							//showOn: "button",
							//buttonImage: "img/calendar-blue.png",
							//buttonImageOnly: true,
						});
					});
				</script>
				<div id="datepicker_new"></div>
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