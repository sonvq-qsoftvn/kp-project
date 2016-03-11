<!-- 
 	Project: Simple Math Captcha	
	Author: Laith Sinawi
	Author website: Website: http://www.SinawiWebDesign.com
	Purpose: HTML form for Simple Match Captcha
-->

<!DOCTYPE html>
<html>
<head>
<title>Laith Sinawi Simple Captcha Demo</title>
<link href="css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="js/contact.js"></script>
</head>
<body>
	
	<div id="container">
	<form id="contact" name="contact" method="POST" action="process.php">
	
	<input type="text" id="firstName" name="firstName" placeholder="First Name" class="required" />
	
	<input type="text" id="lastName" name="lastName" placeholder="Last Name" class="required" />
	
	<input type="text" id="email" name="email" placeholder="Email" class="required email" />
	
	<textarea id="message" name="message" cols="40" rows="5" placeholder="Message" class="required" minlength="10" ></textarea>
	
	<input id="num1" name="num1" readonly="readonly" class="sum" value="<?php echo rand(1,4) ?>" /> + 
	<input id="num2" name="num2" readonly="readonly" class="sum" value="<?php echo rand(5,9) ?>" /> =
	<input type="text" name="captcha" id="captcha" class="captcha" maxlength="2" />
	<span id="spambot">(Are you human, or spambot?)</span>
	
	<input id="submit" name="submit" type="submit" value="Send It" />
	
	</form>
	
	<div id="response"></div>
	<div id="loading"><img src="images/preloader.png" /></div>
	</div>
	
</body>
</html>	
