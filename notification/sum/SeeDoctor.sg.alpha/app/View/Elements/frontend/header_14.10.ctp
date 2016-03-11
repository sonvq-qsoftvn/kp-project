<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $SITENAME; ?></title>
		<meta name="title" content="<?php echo $METATITLE; ?>">
		<meta name="description" content="<?php echo $METADATA; ?>">
		<?php echo $this->Element('frontend/link_styles_and_js'); ?>
	</head>
	
	<body>
		<header>
			<section class="topheader">
				<div class="container">
					<div class="row login-main">
						<div class="logg">
							<ul>
								<?php
									if($this->Session->read('reid_user_uid')>0)
									{
										echo '<li>'.$this->Html->link('My Account', array('controller' => 'users', 'action' => 'userprofile')).'</li>';
										echo '<li>'.$this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'last')).'</li>';
									}
									else
									{
										echo '<li><a href="javascript:void(0)" id="log">Login </a></li>';
										echo '<li>'.$this->Html->link('Register For Free', array('controller' => 'register'), array('class' => 'last')).'</li>';
									}
								?>
							</ul>
						</div>
						<div class="login">
							<div class="login_form_close"><img src="<?php echo BASE_URL;?>/frontend/images/close.png" alt="" title="Close"></div>
							<div class="loginform">
								<h2>Login</h2>
								<?php echo $this->Form->create('User', array('name'=>'login_form', 'id'=>'login_form', 'action' => 'logincheck')); ?>
									<div class="login_field">
										<?php
											echo $this->Session->flash('login_error'); //Showing the error/success message
										
											echo $this->Form->input('', array('name' => 'token', 'id' => 'token', 'value' => ($this->Session->read('user_login_token'))?$this->Session->read('user_login_token'):0, 'type' => 'hidden'));
											echo $this->Form->input('', array('name' => 'is_email', 'id' => 'is_email', 'value' => 0, 'type' => 'hidden'));
											echo $this->Form->input('', array('name' => 'username', 'id' => 'username', 'required' => 'true', 'type' => 'text', 'class' => 'user-in', 'placeholder' => 'Email / Username :', 'value' => (isset($reid_user_username))?$reid_user_username:'', 'onblur'=>"check_type(this.val);"));
											echo $this->Form->input('', array('name' => 'password', 'id' => 'password', 'required' => 'true', 'type' => 'password', 'class' => 'user-in', 'placeholder' => 'Password :' , 'value' => (isset($reid_user_password))?$reid_user_password:''));
										?>
									</div>
									<div class="login_link">
										<?php echo $this->Html->link('Forget Password', array('controller' => 'users', 'action' => 'forgotpassword')); ?>
										|
										<?php echo $this->Html->link('Signup Now!', array('controller' => 'register')); ?>
									</div>
									<div class="login_remember_me">
										<?php echo $this->Form->input('Remember Me', array('name' => 'remember_me', 'id' => 'remember_me', 'type' => 'checkbox', 'value' => (isset($remember_me) && $remember_me == 'on')?$remember_me:1, 'checked' => (isset($remember_me))?'true':'', 'div'=>array('class'=>'new_checkbox'))); ?>
									</div>
									<div class="login_button">
										<div class="butt-log"><button class="login-butt" id="user_login" onclick="check_valid();">Login</button></div>
										<div class="or">OR</div>
										<div id="fb-root"></div>
										<div class="fb-in">
											<a href="javascript:myfunc('fblogin');" class='zocial facebook'>
												<img src="<?php echo BASE_URL;?>/frontend/images/facebook-in.png" />
											</a>
											<!--<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>-->
											<script>
												window.fbAsyncInit = function() {
													FB.init({
															appId: '<?php echo $facebook_app_id ?>', 
															cookie: true,
															xfbml: true,
															oauth: true
														});
												};
												
												(function() {
													var e = document.createElement('script');
													e.async = true;
													e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
													document.getElementById('fb-root').appendChild(e);
												}());
												
												function myfunc(type)
												{
													FB.login(function(response) {
														window.location.href = '<?php echo BASE_URL ;?>facebook_login';
													}, {scope:'first_name, last_name, email, birthday, publish_stream, gender'});
												}
											</script>
											
										</div>
									</div>
								<?php  echo $this->Form->end();?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="clearfix"></div>