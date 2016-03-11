<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registration</title>
<link href="<?php echo BASE_URL;?>/frontend/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo BASE_URL;?>/frontend/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo BASE_URL;?>/frontend/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>/frontend/css/jquery.bxslider.css" type="text/css" />
<link rel="stylesheet" href="<?php echo BASE_URL;?>/frontend/css/style.css" type="text/css" />
<link href="<?php echo BASE_URL;?>/frontend/css/mediaqueries.css" rel="stylesheet">
<script src="<?php echo BASE_URL;?>/frontend/js/jquery-1.10.2.js"></script>
<script src="<?php echo BASE_URL;?>/frontend/js/jquery-ui.js"></script>
<script src="<?php echo BASE_URL;?>/frontend/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL;?>/frontend/js/jquery.bxslider.js"></script>


<script src="<?php echo BASE_URL;?>/frontend/js/jquery.validationEngine.js"></script>
<script src="<?php echo BASE_URL;?>/frontend/css/jquery.validationEngine.css"></script>
<script type="text/javascript">
  $(document).ready(function(){
	$( "#datepicker" ).datepicker();
	$('.bxslider').bxSlider({
	  minSlides: 1,
	  maxSlides: 1,
	  slideWidth:980,
	  slideMargin: 10
	});
  });
</script>
<script src="<?php echo BASE_URL;?>/frontend/js/ui-scroll.js"></script>

</head>
<body>
<header>
      <section class="topheader">
    <div class="container">
          <div class="row login-main">
        <div class="logg">
              <ul>
            <li><a href="#" id="log">Login </a></li>
            <li><a class="last" href="<?php echo BASE_URL;?>register">Register For Free </a></li>
          </ul>
            </div>
            <div class="login">
            	<div class="login_form_close"><img src="<?php echo BASE_URL;?>/frontend/images/close.png" alt="" title="Close"></div>
           	  <div class="loginform">
              	<h2>Login</h2>
                <div class="login_field">
                	<input type="text" name="" class="user-in" placeholder="Email / Username :">
                    <input type="text" name="" class="user-in" placeholder="Password (minimum 8 characters) :">
                </div>
                <div class="login_link"><a href="#">Forget Password</a> | <a href="#">Signup Now!</a></div>
                <div class="login_remember_me"><input type="checkbox" name=""> Remember Me</div>
                <div class="login_button">
                	<div class="butt-log"><button class="login-butt">Login</button></div>
                    <div class="or">OR</div>
                    <div class="fb-in"><a href="#"><img src="<?php echo BASE_URL;?>/frontend/images/facebook-in.png" /></a></div>
                </div>
              </div>
            </div>
      </div>
        </div>
  </section>
      <div class="clearfix"></div>
      
  
