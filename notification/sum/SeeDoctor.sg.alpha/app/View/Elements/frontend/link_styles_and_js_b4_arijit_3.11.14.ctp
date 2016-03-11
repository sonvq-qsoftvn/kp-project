<?php
	echo $this->Html->css('../frontend/css/bootstrap.min.css');
	echo $this->Html->css('../frontend/css/fonts.css');
	echo $this->Html->css('../frontend/css/jquery-ui.css');
	echo $this->Html->css('../frontend/css/jquery.bxslider.css');
	echo $this->Html->css('../frontend/css/style.css');
	echo $this->Html->css('../frontend/css/mediaqueries.css');
	
	echo $this->Html->script('../frontend/js/jquery-1.10.2.js');
	echo $this->Html->script('../frontend/js/jquery-ui.js');
	echo $this->Html->script('../frontend/js/bootstrap.min.js');
	echo $this->Html->script('../frontend/js/jquery.bxslider.js');
	
	echo $this->Html->script('../frontend/js/jquery.validationEngine.js');
	echo $this->Html->css('../frontend/css/jquery.validationEngine.css');
	echo $this->Html->script('../frontend/js/ui-scroll.js');
	
?>
	<script type="text/javascript">
		var is_pop_open = <?php echo ($this->Session->check('Message.login_error'))?1:0; ?>
		
		$(document).ready(function(){
			$( "#datepicker" ).datepicker({
				changeYear: true,
				maxDate: '0', 
				beforeShow : function(){
					$( this ).datepicker('option','maxDate', <?php echo date('d/m/Y') ?> );
				}
			});
			$( "#datepicker2" ).datepicker({
				changeYear: true,
				maxDate: '0', 
				beforeShow : function(){
					$( this ).datepicker('option','maxDate', <?php echo date('d/m/Y') ?> );
				}
			});
			
			//$('.bxslider').bxSlider({
			//	minSlides: 1,
			//	maxSlides: 1,
			//	slideWidth:980,
			//	slideMargin: 10
			//});
			
			//---------------------------------form validation for user-----------------------------------------//
		
			$('#user_login').click(function(){
				check_type();
				$("#login_form").validate({
					rules: {
							username: "required",
							password: { required: true }
						},
						messages: {
							username: "Please enter your username",
							password: { required: "Please enter your password" }
						},
						submitHandler: function(form) {
						form.submit();
					}
				});
			});  
	 
			//---------------------------------END form validation for user-----------------------------------------
			
			if (is_pop_open) {
				$('#log').click();
			}
			
		});
		
		function check_type(val)
		{
			var username = $('#username').val();
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(re.test(username))
				$('#is_email').val(1);
			else
				$('#is_email').val(0);
		}
	</script>
