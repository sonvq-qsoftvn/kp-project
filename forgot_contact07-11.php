<?php
session_start();


?>
<script>
$(document).ready( function() {
	$('input[placeholder], textarea[placeholder]').placeholder();
	$('#submit').removeAttr('disabled');
	
	$.validator.addMethod('captcha',
							function(value) {
								$result = ( parseInt($('#num1').val()) + parseInt($('#num2').val()) == parseInt($('#captcha').val()) ) ;
								$('#spambot').fadeOut('fast');
								return $result;
								//alert("Result is " + $result );
							},
							'Incorrect value, please try again.'
	);
	
	$('#forgot_pass').validate({
		debug: true,
		//submitHandler: ajaxSubmit
                rules: {
                    
					captcha: {
						required: true,
						captcha: true
					},
					email_cell: {
                        required: true,
                       
                    }
                },
                messages: {
                    email_cell: "Please insert your email address or cell number.",
					chkCaptcha: {
						required: "* Required"
					}
                    
                }
                
	});
	
	$('#submit11').click( function() {
		if( $('#forgot_pass').valid() ) {
				ajaxSubmit();
			//alert(window.location.protocol+'//'+window.location.host+'/'+'kcpasa/registration');
		}
		else {
			$('label.error').hide().fadeIn('slow');
		}
	});
	
});

function ajaxSubmit() {
	var email_cell = $('#email_cell').val();
	var data = 'email_cell=' +email_cell;
	
	//alert(data);	
	$.ajax({
		url: window.location.protocol+'//'+window.location.host+'/'+'kcpasa/forgotpass_process.php',
		type: 'POST',
		dataType: 'html',
		data: data,
		cache: false,
		success: function(html){
			//alert(html.charAt(html.length -22));
			
			if(html.charAt(html.length -22)==0)
			{
				//alert('<?php echo $_SESSION['langSessId'];?>');
				if('<?php echo $_SESSION['langSessId'];?>'=="eng"){
					$('#showresponse').html('<p style="color:red;">Email address or cell number are not found.</p>');
				}
				else{
					$('#showresponse').html('<p style="color:red;">Dirección de correo electrónico o número de celular no se encuentran.</p>');
				}
			}
			else{
				setTimeout("window.location=window.location.protocol+'//'+window.location.host+'/'+'kcpasa/forgotpassmessage.php'",1000)
			}
        }
	});
	return true;
}
</script>