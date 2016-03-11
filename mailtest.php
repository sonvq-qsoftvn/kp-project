<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
//echo phpinfo();
/*$email = "mick.ocallaghan@valueadded.ie" ;
$subject = "Test subject Microlearning" ;
  $message = "This is dummy msg body.";
  mail("amit.unified@gmail.com", $subject, $message, "From:" . $email);
  
  echo "Thank you for using our mail form";*/
  
  
// The message
$message = "Line 1\r\nLine 2\r\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
mail('amit.unified@gmail.com', 'My Subject', $message);
  
?>

</body>
</html>
