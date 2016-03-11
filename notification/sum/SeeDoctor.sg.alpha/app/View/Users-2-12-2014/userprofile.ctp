

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
						date_of_birth:"required"
					},
					messages: {
						username: "Please enter your username",
						email: "Please enter your email id",
						date_of_birth:"Please secect your birth date"
					},
					submitHandler: function(form) {
					form.submit();
				}
			});
		});  
 
          $('#user_passw_btn').click(function(){	
               $("#user_pass_form").validate({
				rules: {
						password1: {
									required: true,
									minlength: 8
								},
						re_password:{ required: true}
					},
					messages: {
						password1: {
							required: "Please provide a password",
							minlength: "Your password must be at least 8 characters long"
						},
						re_password: {
							required: "Please provide password again."
							//equalTo: "Both passwords must be same."
						}
					},
					submitHandler: function(form) {
                              var pass=$('#password1').val();
                              var cpass= $('#re_password').val();
                              var error=0
                              //alert(pass+' '+cpass);
                              if (pass != cpass) {
                                   $('#re_password-error').html('Both password must be same');
                                   $('#re_password-error').show();
                                   error =1; 
                              }
                              else{
                                   error =0;
                              }
                              
                              if (error==0) {
                                   form.submit();
                              }
                         }
			});
          });
          
		//---------------------------------END form validation for user-----------------------------------------
	});
</script>


	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>User Profile</h2></div></div>
		<div class="container">
			<div class="inner-gapbox-1">
                    <?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
				<div class="heading-box">
					<div class="regi-heading">
						<span class="email2"><?php echo $this->Html->image('../frontend/images/my_account.png',array('alt'=>'')); ?></span>
						My Account
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="rgeistration-wrapp">
					<div id="user_form">
						<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>userupdate' method='post' enctype='multipart/form-data' >
                                   <input type="hidden" name="id" id="id" value="<?php echo (isset($id))?$id:''; ?>" />
                                   <input type="hidden" name="user_type" id="user_type" value="<?php echo (isset($user_type))?$user_type:''; ?>" />
                                   
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="username" placeholder="Username" value="<?php echo (isset($username))?$username:''; ?>" class="user-in"></div>
								<?php
                                             if(isset($user_type) && $user_type == 2)
                                             {
                                        ?>
                                                  <div class="col-md-4"><input type="text" name="first_name" placeholder="First Name" value="<?php echo (isset($first_name))?$first_name:''; ?>" class="user-in"></div>
                                                  <div class="col-md-4"><input type="text" name="last_name" placeholder="Last Name" value="<?php echo (isset($last_name))?$last_name:''; ?>" class="user-in"></div>
                                        <?php
                                             }
                                        ?>
							</div>
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="email" value="<?php echo (isset($email))?$email:''; ?>" placeholder="Email" class="user-in"></div>
								<div class="col-md-4"><input id="datepicker" type="text" name='date_of_birth' placeholder="Date of Birth " value="<?php echo (isset($date_of_birth))?date('m/d/Y', strtotime($date_of_birth)):''; ?>" class="user-in-date"></div>
                                        <?php
                                             if(isset($user_type) && $user_type == 2)
                                             {
                                        ?>
                                                  <div class="col-md-4"><input type="text" name="phone_number" value="<?php echo (isset($phone_number))?$phone_number:''; ?>" placeholder="Phone Number" class="user-in"></div>
                                        <?php
                                             }
                                        ?>
								<div class="col-md-4">
									<div class="gen">Gender</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' value='M' <?php echo (isset($gender) && $gender=='M')?"checked='checked'":''; ?> class="rad"></span>Male</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' <?php echo (isset($gender) && $gender=='F')?"checked='checked'":''; ?>  value='F'> </span>Female</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="button-wrapp">
								<div class="butt-reg"><button class="regisyer-butt" id="user_register_btn"  >Update</button></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
                    
                    <?php
                         if($facebook_id==0)
                         {
                    ?>
                              <div style="padding-top: 30px;"></div>
                              
                              <div class="heading-box">
                                   <div class="regi-heading">
                                        <span class="email2"><?php echo $this->Html->image('../frontend/images/password.png',array('alt'=>'')); ?></span>
                                        Change Password
                                   </div>
                                   <div class="clearfix"></div>
                              </div>
                              
                              <div class="rgeistration-wrapp">
                                   <div id="user_form">
                                        <form name='user_pass_form' id='user_pass_form' action='<?php echo BASE_URL;?>change_password' method='post' enctype='multipart/form-data' >
                                             <input type="hidden" name="id" id="id" value="<?php echo (isset($id))?$id:''; ?>" />
                                             <input type="hidden" name="user_type" id="user_type" value="<?php echo (isset($user_type))?$user_type:''; ?>" />
                                             <div class="form-row">
                                                  <div class="col-md-4"><input type="password" name="password" id="password1" placeholder="Password" value="" class="user-in"></div>
                                             </div>
                                             <div class="form-row">
                                                  <div class="col-md-4">
                                                       <input type="password" name="re_password" id="re_password" value="" placeholder="Re-Enter Password" class="user-in" />
                                                       <label id="re_password-error" class="error"></label>
                                                  </div>
                                             </div>
                                             <div class="clearfix"></div>
                                             <div class="button-wrapp">
                                                  <div class="butt-reg"><button class="regisyer-butt" id="user_passw_btn"  >Change Password</button></div>
                                                  <div class="clearfix"></div>
                                             </div>
                                             <div class="clearfix"></div>
                                        </form>
                                   </div>
                              </div>
               <?php     } ?>
			</div>
	    </div>
	</section>
