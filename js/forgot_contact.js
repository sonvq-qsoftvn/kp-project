/* 
 *	Project: Simple Math Captcha 
 *	Author: Laith Sinawi
 *	Author website: Website: http://www.SinawiWebDesign.com
 *  	Purpose: Client-side form validation including custom Captcha
 */

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
			//setTimeout("window.location=window.location.protocol+'//'+window.location.host+'/'+'forgotpassmessage.php'",1000)
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
		/*success: function(response) {
		}*/
		success: function(html){
            $('#showresponse').html(html); 
			setTimeout("window.location=window.location.protocol+'//'+window.location.host+'/'+'forgotpassmessage.php'",1000)
        }
	});
	return true;
}
