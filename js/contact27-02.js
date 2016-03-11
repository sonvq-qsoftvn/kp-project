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
	
	$('#contact').validate({
		debug: true,
		//submitHandler: ajaxSubmit
                rules: {
                    
					captcha: {
						required: true,
						captcha: true
					},
					password: {
                        required: true,
                        minlength: 5
                       
                    }
                },
                messages: {
                    fname: "First name field required.",
                    lname: "Last name field required.",
                    email: {
                        required: "Email address required",
                        email: "Email address must be in the format name@domain.com."                        
                    },
					password: {
						minlength: "Password must contain at least 5 characters.",
					},
					con_password: {
						minlength: "Confirm Password must contain at least 5 characters.",
						equalTo: "Confirm password should match with password"
					},
					chkCaptcha: {
						required: "* Required"
					}
                    
                }
                
	});
	
	$('#submit1').click( function() {
		if( $('#contact').valid() ) {
				ajaxSubmit();
			//alert(window.location.protocol+'//'+window.location.host+'/'+'kcpasa/registration');
			setTimeout("window.location=window.location.protocol+'//'+window.location.host+'/'+'thankyou'",1000)
		}
		else {
			$('label.error').hide().fadeIn('slow');
		}
	});
	
});

function ajaxSubmit() {

	var fname = $('#fname').val();
	var lname = $('#lname').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var country_id = $('#country_id').val();
	var password = $('#password').val();
	var country_code = $('#country_code').val();
	var account_type =$('input:radio[name=account_type]:checked').val();
	var language = $('#language').val();
	
	//alert($('input:radio[name=account_type]:checked').val());
	/*alert( "Form's about to be submitted! \n" 
		+ firstName + "\n" 
		+ lastName + "\n" 
		+ email + "\n" 
		+ message + "\n" );*/
	
	var data = 'fname=' +fname+ '&lname=' +lname+ '&email=' +email+ '&phone=' +phone+ '&country_id=' +country_id+ '&country_code=' +country_code+ '&password=' +password+ '&account_type=' +account_type+ '&country_id=' +country_id+ '&country_code=' +country_code+ '&language=' +language;
		
	$.ajax({
		url: window.location.protocol+'//'+window.location.host+'/'+'registration_process.php',
		type: 'POST',
		dataType: 'json',
		data: data,
		cache: false,
		success: function(response) {
		}
	});
	return true;
}
