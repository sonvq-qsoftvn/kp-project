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
								<li><a href="javascript:void(0)" id="log">Login </a></li>
								<li><?php echo $this->Html->link('Register For Free', array('controller' => 'register'), array('class' => 'last')); ?></li>
							</ul>
						</div>
						<div class="login">
							<div class="login_form_close"><img src="<?php echo BASE_URL;?>/frontend/images/close.png" alt="" title="Close"></div>
							<div class="loginform">
								<h2>Login</h2>
								<?php echo $this->Form->create(array('name'=>'login', 'id'=>'login', 'enctype'=>'multipart/formdata', 'controller' => 'Users', 'action' => 'logincheck')); ?>
									<div class="login_field">
										<?php
											echo $this->Form->input('', array('name' => 'username', 'id' => 'username', 'required' => 'true', 'type' => 'text', 'class' => 'user-in', 'placeholder' => 'Email / Username :'));
											echo $this->Form->input('', array('name' => 'password', 'id' => 'password', 'required' => 'true', 'type' => 'password', 'class' => 'user-in', 'placeholder' => 'Email / Username :'));
										?>
									 </div>
									<div class="login_link">
										<?php echo $this->Html->link('Forget Password', array('controller' => 'register', 'action' => 'forgot_password')); ?>
										|
										<?php echo $this->Html->link('Signup Now!', array('controller' => 'register')); ?>
									</div>
									<div class="login_remember_me">
										<?php echo $this->Form->input('Remember Me', array('name' => 'remember_me', 'id' => 'remember_me', 'type' => 'checkbox', 'value' => 1, 'div'=>array('class'=>'new_checkbox'))); ?>
									</div>
									<div class="login_button">
										<div class="butt-log"><button class="login-butt" onclick="check_valid();">Login</button></div>
										<div class="or">OR</div>
										<div class="fb-in"><a href="#"><img src="<?php echo BASE_URL;?>/frontend/images/facebook-in.png" /></a></div>
									</div>
								<?php  echo $this->Form->end();?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="clearfix"></div>