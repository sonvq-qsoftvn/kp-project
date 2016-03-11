<?php
/* 
 *	Project: Simple Math Captcha
 *	Author: Laith Sinawi
 *	Author website: Website: http://www.SinawiWebDesign.com
 *  	Purpose: Server-side form validation for Simple Math Captcha
 */
 
require_once('classes/Validation.class.php');

sleep(2);
define('TO', 'me@domain.com');
define('FROM', 'info@laithsinawi.com');
define('SUBJECT', 'Laith Sinawi Contact Form with Custom Captcha');

if ( count($_GET) ) {
   $_POST = $_GET;
   //echo var_dump($_POST);
} 

$isValid = true;
$return = array("error" => "false");

// If request method is post, then user has JS disable - do server-side validation
if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) ) {
//if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        
        // Do server-side validation
        $fname = isset($_POST['firstName']) ? $_POST['firstName'] : "";
        $lname = isset($_POST['lastName']) ? $_POST['lastName'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $message = isset($_POST['message']) ? $_POST['message'] : "";
		
		$num1 = isset($_POST['num1']) ? $_POST['num1'] : "";
		$num2 = isset($_POST['num2']) ? $_POST['num2'] : "";
		$total = isset($_POST['captcha']) ? $_POST['captcha'] : "";
		
        $form = new Validation('post');
		
	$fname_error = $form->name_validation($fname, 'First name');
	$lname_error = $form->name_validation($lname, 'Last name');
	$email_error = $form->email_validation($email, 'E-mail');
	$message_error = $form->message_validation($message, 'Message');
	$captcha_error = $form->captcha_validation($num1, $num2, $total);

	$error = $fname_error.$lname_error.$email_error.$message_error.$captcha_error;
	if($error == null) {
		$result = sendEmail();
		
		if( $result['error'] == 'false' ) {
                    echo "Message sent successfully!";
                }
                else {
                    echo "Problem sending mail!";
                }
                
	}
	else {
		$isValid = false;
		echo $error;
	}
}

// Otherwise, JS has already validated form
// If script comes to this line, then JS is enabled and form was validated first
if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    global $return;
    if ( sendEmail() ) {
        //return "Message sent successfully!";
        echo json_encode($return);
    }
    else {
        echo json_encode($return);
    }
}

    function sendEmail() {
        global $return;
        $body = "";
        $body .= "From: ".$_POST['email']."\nSubject: " . SUBJECT;
        $body .= "\nFirst Name: ".$_POST['firstName'];
        $body .= "\nLast Name: " .$_POST['lastName'];
        $body .= "\nMessage: " .$_POST['message'];

        if ( @mail( TO, SUBJECT, $body ) ) {
        //if(true) {
            $return['error'] = 'false';
        }
        else {
                $return['error'] = 'true';
        }
        return $return;
    }
