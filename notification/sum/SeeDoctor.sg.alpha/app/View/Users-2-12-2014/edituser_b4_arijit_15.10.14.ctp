<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script>
	$(document).ready(function(){
		//---------------------------------form validation for user-----------------------------------------//
		
		$('#user_register_btn').click(function(){	
			$("#user_reg_form").validate({
				rules: {
						username: "required",
						email: {
									required: true,
									email: true
								},
						password: {
									required: true,
									minlength: 8
								},
						user_re_password:{ required: true},
						date_of_birth:"required",
						user_captcha:"required",
						user_cond_checked: "required"
					},
					messages: {
						username: "Please enter your username",
						email: "Please enter your email id",
						password: {
							required: "Please provide a password",
							minlength: "Your password must be at least 8 characters long"
						},
						user_re_password: {
							required: "Please provide password again."
							//equalTo: "Both passwords must be same."
						},
						date_of_birth:"Please secect your birth date",
						user_captcha:"Please enter captcha",
						user_cond_checked: "Please accept our policy"
					},
					submitHandler: function(form) {
					form.submit();
				}
			});
		});  
 
		//---------------------------------END form validation for user-----------------------------------------
	});
</script>


	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Register</h2></div></div>
		<div class="container">
			<div class="inner-gapbox-1">
				<div class="heading-box">
					<div class="regi-heading">
						<span class="email2"><?php echo $this->Html->image('../frontend/images/email_ib.png',array('alt'=>'')); ?></span>
						Registration
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="rgeistration-wrapp">
					
					<div id="user_form">
						<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>user_update' method='post' enctype='multipart/form-data' >
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="username" placeholder="User name" value="<?php echo (isset($username))?$username:''; ?>" class="user-in"></div>
								<!--<div class="col-md-4"><input type="password" name="password" placeholder="Password (minimum 8 characters)" class="user-in"></div>
								<div class="col-md-4"><input type="password" name="user_re_password" placeholder="Re-Enter Password " class="user-in"></div>-->
							</div>
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="email" value="<?php echo (isset($email))?$email:''; ?>" placeholder="Email" class="user-in"></div>
								<div class="col-md-4"><input id="datepicker" type="text" name='date_of_birth' placeholder="Date of Birth " value="<?php echo (isset($date_of_birth))?date('d/m/Y', strtotime($date_of_birth)):''; ?>" class="user-in-date"></div>
								<div class="col-md-4">
									<div class="gen">Gender</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' value='M' <?php echo (isset($gender) && $gender=='M')?"checked='checked'":''; ?> class="rad"></span>Male</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' <?php echo (isset($gender) && $gender=='F')?"checked='checked'":''; ?>  value='F'> </span>Female</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-row">
								<div class="col-md-4">&nbsp;</div>
								<div class="col-md-4"></div>
							</div>
						 
							<div class="button-wrapp">
								<div class="butt-reg"><button class="regisyer-butt" id="user_register_btn"  >Update</button></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
	    </div>
	</section>
