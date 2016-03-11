	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Register</h2></div></div>
		<div class="container">
			<div class="inner-gapbox-1">
				<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
				<div class="heading-box">
					<div class="regi-heading">
						<span class="email2"><?php echo $this->Html->image('../frontend/images/email_ib.png',array('alt'=>'')); ?></span>
						Registration
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="rgeistration-wrapp">
					<div id="user_form">
						<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>register' method='post' enctype='multipart/form-data' >
							<input type="hidden" name="facebook_id" id="facebook_id" value="<?php echo $this->request->data('facebook_id'); ?>" />
							<input type="hidden" name="username" value="<?php echo $this->request->data('username'); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="first_name" value="<?php echo $this->request->data('first_name'); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="last_name" value="<?php echo $this->request->data('last_name'); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="email" value="<?php echo $this->request->data('email'); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="gender" value="<?php echo substr($this->request->data('gender'), 0, 1); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="date_of_birth" value="<?php echo $this->request->data('date_of_birth'); ?>" placeholder="User name" class="user-in" />
							<input type="hidden" name="phone_number" value="<?php echo $this->request->data('phone_number'); ?>" placeholder="User name" class="user-in" />
							
							<div class="user-head">
								<div class="user-box">User Account Type:</div>
								<div class="user-box2"> <input type="radio" class="e-radio" name="user_type" id='user_form_radio' checked='checked' value="1"> General User</div>
								<div class="user-box2"> <input type="radio" class="e-radio" name="user_type" id='user_form_manager' value="2"> Clinic Manager</div>
								<div class="clearfix"></div>
							</div>
							<div class="button-wrapp">
								<div class="butt-reg"><button class="regisyer-butt" id="user_register_btn" >Continue</button></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
	    </div>
	</section>


