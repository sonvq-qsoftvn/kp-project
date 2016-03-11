	
	<script>
		$(document).ready(function(){
			//---------------------------------form validation for user-----------------------------------------//
			$('#form_save').click(function(){	
				$("#user_reg_form").validate({
					rules: {
							clinic_name: 	 "required",
							license_number: "required",
							phone_number:   {
										required: true,
										minlength: 10,
										maxlength: 10,
										number: true
									},
							clinic_url: {
										required: true,
										url: true
									},
							address: "required"
						},
						messages: {
							clinic_name: "Please enter your clinic name",
							license_number: "Please enter your license number",
							phone_number: {
										required : "Please enter your phone number",
										minlength: "Phone number should be 10 digit",
										maxlength: "Phone number should be 10 digit",
										number : "Phone number must be numaric"
								},
							clinic_url: {
								required: "Please enter your clinic url",
								url: "Please enter your valid url"
							},
							address: "Please enter address"
						},
						submitHandler: function(form) {
						form.submit();
					}
				});
			});  
		});
	</script>

		
		<section class="emai-registration">
			<div class="topheading-box"><div class="container"><h2>Add Clinic</h2></div></div>
			<div class="container">
				<div class="inner-gapbox-1">
					<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
					<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>users/addclinicfont' method='post' enctype='multipart/form-data' >
						<input type="hidden" name="clinicmanagersid" id="clinicmanagersid" value="<?php echo $this->Session->read('reid_user_uid'); ?>" />
						<div class="add_clinic">
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3">Clinic Name<sup>*</sup> :</label>
									<div class="col-xs-12 col-md-9"><input type="text" value="<?php echo $this->request->data('clinic_name'); ?>" name="clinic_name" placeholder="Enter clinic name" class="user-in"></div>
								</div>
							</div>
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3">License Number<sup>*</sup> :</label>
									<div class="col-xs-12 col-md-9"><input type="text" value="<?php echo $this->request->data('license_number'); ?>" name="license_number" placeholder="Enter license number" class="user-in"></div>
								</div>
							</div>
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3">Hand Phone Number<sup>*</sup> :</label>
									<div class="col-xs-12 col-md-9"><input type="text" value="<?php echo $this->request->data('phone_number'); ?>" name="phone_number" placeholder="Enter phone number" class="user-in"></div>
								</div>
							</div>
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3">Clinic url<sup>*</sup> :</label>
									<div class="col-xs-12 col-md-9"><input type="text" value="<?php echo $this->request->data('clinic_url'); ?>" name="clinic_url" placeholder="Enter clinic url" class="user-in"></div>
								</div>
							</div>
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3">Address<sup>*</sup> :</label>
									<div class="col-xs-12 col-md-9"><textarea rows="5" cols="5" name="address" placeholder="Enter address" class="user-in-area"><?php echo $this->request->data('address'); ?></textarea></div>
								</div>
							</div>
							<div class="form-row">
								<div class="row">
									<label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
									<div class="col-xs-12 col-md-9">
									    <button class="save" id="form_save">Save</button>
									    <?php echo $this->Html->link('Cancel', array('controller' => 'clinics', 'action' => 'clintlist'), array('class' => 'cancel')); ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
				</div>
			</div>
		</section>
