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
		url: window.location.protocol+'//'+window.location.host+'/'+'forgotpass_process.php',
		type: 'POST',
		dataType: 'html',
		data: data,
		cache: false,
		success: function(html){

			str = html.replace(/[^0-9]/g,'');
			//alert(str);
			
			if(str==0)
			{
				//alert('<?php echo $_SESSION['for_pass_msg'];?>');
				if('<?php echo $_SESSION['langSessId'];?>'=="eng"){
					<?php if(isset($_SESSION['for_pass_msg'])){?>
					$('#showresponse').html(<?php echo $_SESSION['for_pass_msg']; unset($_SESSION['for_pass_msg']);?>);
					<?php
					}else{
					?>
					$('#showresponse').html('<p style="color:red;">Email address or cell number are not found.</p>');
					<?php } ?>
				}
				else{
					$('#showresponse').html('<p style="color:red;">Dirección de correo electrónico o número de móvil no encontrado.</p>');
				}
			}
			else{
				setTimeout("window.location=window.location.protocol+'//'+window.location.host+'/'+'forgotpassmessage.php'",1000)
			}
        }
	});
	return true;
}
</script>
