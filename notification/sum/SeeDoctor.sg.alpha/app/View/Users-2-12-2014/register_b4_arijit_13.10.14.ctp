<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script>
	$(document).ready(function(){
		
		$('#user_form').show();
		$('#clinic_manager_form').hide();
		
		$('#user_form_manager').click(function(){
			$('#clinic_manager_form').show();
			$('#user_form').hide();
		});
		
		$('#user_form_radio').click(function(){
			$('#user_form').show();
			$('#clinic_manager_form').hide();
		});
		
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

		//---------------------------------form validation for clinic manager-----------------------------------------	
		$('#manager_reg_btn').click(function(){	
			$("#clinic_mang_reg").validate({
				rules: {
					manager_fname:"required",
					manager_lname:"required",
					manager_name: "required",
					manager_email: {
							required: true,
							email: true
					},
					manager_password: {
							required: true,
							minlength: 8
					},
					manager_re_password:{required: true},
					phone_number:"required",
					manager_dob:"required",
					manager_captcha:"required",
					manager_cond_ck: "required"
				},
				messages: {
					manager_name: "Please enter your username",
					manager_fname:"Please enter your first name",
					manager_lname:"Please enter your last name",
					manager_email: "Please enter your email",
					manager_password: {
					    required: "Please provide a password",
					    minlength: "Your password must be at least 8 characters long"
					},
					manager_re_password: {
						required: "Please provide password again."
					},
					phone_number:"Please enter your phone number",		    
					manager_dob:"Please secect your birth date",
					manager_captcha:"Please enter captcha",
					manager_cond_ck: "Please accept our policy"
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});  
		//---------------------------------END form validation for clinic manager-----------------------------------------//
		
		captcha_reload();
		manager_captcha_reload();
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
					
					<div class="user-head">
						<div class="user-box">User Account Type:</div>
						<div class="user-box2"> <input type="radio" class="e-radio" name="user_type" id='user_form_radio' checked='checked' value="user"> General User</div>
						<div class="user-box2"> <input type="radio" class="e-radio" name="user_type" id='user_form_manager' value="manager"> Clinic Manager</div>
						<div class="clearfix"></div>
					</div>
					
					<div id="user_form">
						<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>register' method='post' enctype='multipart/form-data' >
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="username" placeholder="User name" class="user-in"></div>
								<div class="col-md-4"><input type="password" name="password" placeholder="Password (minimum 8 characters)" class="user-in"></div>
								<div class="col-md-4"><input type="password" name="user_re_password" placeholder="Re-Enter Password " class="user-in"></div>
							</div>
							<div class="form-row">
								<div class="col-md-4"><input type="text" name="email" placeholder="Email" class="user-in"></div>
								<div class="col-md-4"><input id="datepicker" type="text" name='date_of_birth' placeholder="Date of Birth " class="user-in-date"></div>
								<div class="col-md-4">
									<div class="gen">Gender</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' value='M'  checked='checked' class="rad"></span>Male</div>
									<div class="gen2"><span class="rad"><input type="radio" name='gender' value='F'> </span>Female</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-row">
								<div class="col-md-5">
									<div class="code-b">
										<?php echo $this->Html->image('../frontend/images/code.png',array('alt'=>'', 'id' => 'captca_img_val')); ?>
										<span class="re-mic" onclick="captcha_reload();" >
											<?php echo $this->Html->image('../frontend/images/ref.png',array('alt'=>'')); ?>
										</span>
									</div>
									<div class="code-in">
										<?php
											$cap_val=$_SESSION['captcha_val'];
											//echo $this->Form->input('user_captcha',array('label' => FALSE, 'div' => FALSE, 'type'=>'text', 'placeholder'=>'Enter captcha value','class' =>'user-in', 'id'=>'user_captcha','onblur'=>"captcha_check('$cap_val')"));
										?>
										<input name="user_captcha" placeholder="Enter captcha value" class="user-in" id="user_captcha" onblur="captcha_check('<?php echo $cap_val; ?>')" type="text">
									</div>
									<div id='msg'></div>
								</div>
								<div class="col-md-4">&nbsp;</div>
								<div class="col-md-4"></div>
							</div>
						 
							<div class="user-mnass">
								<span class="che-user">
									<input type="checkbox" class="ch-user" name='user_cond_checked' id='user_cond_checked' />
								</span>
								I agree and will abide to the 
								<?php echo $this->Html->link('medical disclaimer, terms of service & privacy policy for SeeDoctor.sg', array('controller' => 'contents', 'action' => 'showcontent', 'alias' => 'terms-of-use')); ?>
							</div>
							 
							<div class="button-wrapp">
								<div class="butt-reg"><button class="regisyer-butt" id="user_register_btn"  >Register</button></div>
								<div class="or">OR</div>
								<div class="fb-sign">
									<a href="javascript:myfunc('fblogin');" class='zocial facebook'>
										<?php echo $this->Html->image('../frontend/images/facebook-s.png',array('alt'=>'')); ?>
									</a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				
					<div id='clinic_manager_form'>
						<form action='<?php echo BASE_URL;?>registerclinicmanager' name='clinic_mang_reg' id='clinic_mang_reg' method='post' enctype='multipart/form-data'>
							<div class="form-row" id="clinic_mgr_form_fild">
								<div class="col-md-4"><input type="text" name='manager_fname' placeholder="First" class="user-in" id='fname'></div>
								<div class="col-md-4"><input type="text" name='manager_lname' placeholder="Last Name" class="user-in" id='lname'></div>
								<div class="col-md-4"><input type="text" name='manager_email' placeholder="Email " class="user-in"></div>
							</div>
						 
							<div class="form-row" id="user_form_fild">
								<div class="col-md-4"><input type="text" name='manager_name' id='manager_name' placeholder="User name" class="user-in"></div>
								<div class="col-md-4"><input type="password" name='manager_password' id='manager_password' placeholder="Password (minimum 8 characters)" class="user-in"></div>
								<div class="col-md-4"> <input type="password" id='manager_re_password' name='manager_re_password' placeholder="Re-Enter Password" class="user-in"></div>
							</div>
						
							<div class="form-row">
								<div class="col-md-4"><input type="text" name='phone_number' id='phone_number' placeholder="Phone Number" class="user-in"></div>
								<div class="col-md-4"><input id="datepicker2" name='manager_dob'  type="text" placeholder="Date of Birth " class="user-in-date"></div>
								<div class="col-md-4"><div class="gen">Gender</div>
								<div class="gen2"><span class="rad"><input type="radio" name='manager_gender'  value='M' checked='checked' class="rad"></span>Male</div>
								<div class="gen2"><span class="rad"><input type="radio" name='manager_gender' value='F' ></span>Female</div></div>
							</div>
						
							<div class="clearfix"></div>
					 
							<div class="form-row">
								<div class="col-md-5">
									<div class="code-b">
										<img src="<?php echo BASE_URL;?>app/webroot/code.png" id="manager_captca_img_val" />
										<span class="re-mic" onclick="manager_captcha_reload();" >
											<img src="<?php echo BASE_URL;?>/frontend/images/ref.png"/>
										</span>
									</div>
									<div class="code-in">
										<?php
											$manager_cap_val=$_SESSION['captcha_val'];
											//echo $this->Form->input('manager_captcha',array('label' => FALSE, 'div' => FALSE, 'type'=>'text', 'placeholder'=>'Enter captcha value','class' =>'user-in', 'id'=>'manager_captcha','onblur'=>"manager_captcha_check('$manager_cap_val')"));
										?>
										<input name="manager_captcha" placeholder="Enter captcha value" class="user-in" id="manager_captcha" onblur="captcha_check('<?php echo $manager_cap_val; ?>')" type="text" />
									</div>
									<div id='msg_captcha'></div>
								</div>
								<div class="col-md-4">&nbsp;</div>
								<div class="col-md-4"></div>
							</div>
						
							<div class="user-mnass"><span class="che-user">
								<input type="checkbox" name='manager_cond_ck' id='manager_cond_ck' class="ch-user">
								</span> I agree and will abide to the
								<?php echo $this->Html->link('medical disclaimer, terms of service & privacy policy for SeeDoctor.sg', array('controller' => 'contents', 'action' => 'showcontent', 'alias' => 'terms-of-use')); ?>
							</div>
							
							<div class="button-wrapp">
								<div class="butt-reg"> <button class="regisyer-butt" id="manager_reg_btn">Register</button></div>
								<div class="or">OR</div><div class="fb-sign"><a href="javascript:myfunc2('fblogin');" class='zocial facebook'><?php echo $this->Html->image('../frontend/images/facebook-s.png',array('alt'=>'')); ?></a></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
	    </div>
	</section>


<script type="text/javascript">
	//-------------------captcha reload function------------    
	function captcha_reload()
	{
		$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
			$('#captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
		});
	}
	
	function manager_captcha_reload()
	{
		$.get('<?php echo BASE_URL;?>registerclinicmanager', function() {
			$('#manager_captca_img_val').attr('src', '<?php echo BASE_URL.'app/webroot/next.php?text='.$this->Session->read('captcha_val');?>');
		});
	}
	//-------------------END captcha reload function-------------------------

	//----------------captcha check for user_registration---------------------
	function captcha_check(sess_cap_val)
	{	
		var sub_catcha_val=document.getElementById('user_captcha').value;
		if (sub_catcha_val != '' && sub_catcha_val != sess_cap_val)
		    $("#msg").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
		else
			$("#msg").html("");
	}

	//----------------END captcha check for user_registration---------------------

	//---------------- captcha check for clinic manager_registration---------------------
	function manager_captcha_check(captcha_val)
	{
		var sub_catcha_val=document.getElementById('manager_captcha').value;
		if (sub_catcha_val!=captcha_val)
		    $("#msg_captcha").html("<i style='color:red; border: 1px solid red;'>Wrong Captcha</i>");
		else
			$("#msg_captcha").html("");
	}
	//---------------- END captcha check for clinic manager_registration---------------------

	window.fbAsyncInit = function() {
		FB.init({
				appId: '<?php echo $facebook_app_id ?>', 
				cookie: true,
				xfbml: true,
				oauth: true
			});
	};
	
	function myfunc(type)
	{
		FB.login(function(response) {
			window.location.href = '<?php echo BASE_URL ;?>facebook_login?type=1';
		}, {scope:'first_name, last_name, email, birthday, publish_stream, gender'});
	}
	
	function myfunc2(type)
	{
		FB.login(function(response) {
			window.location.href = '<?php echo BASE_URL ;?>facebook_login?type=2';
		}, {scope:'first_name, last_name, email, birthday, publish_stream, gender'});
	}
</script>