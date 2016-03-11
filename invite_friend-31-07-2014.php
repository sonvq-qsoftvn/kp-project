<?php
session_start();
//ajax event price level
include('include/user_inc.php');
//$obj_base_path = new DB_Sql;

$event_name=$_POST['eventName'];
$event_id=$_POST['eventId'];
$event_multi_id=$_POST['multiEventId'];

//echo $event_name." ".$event_id." ".$event_multi_id;
//exit();
//------user details------//
$obj_user=new user;
//echo "admin_id= ".$_SESSION['ses_admin_id'];
$obj_user->user_details($_SESSION['ses_admin_id']);
$obj_user->next_record();
$f_name=$obj_user->f('fname');
$l_name=$obj_user->f('lname');
$user_name=$f_name." ".$l_name;

$formName = $user_name;
//------user details------//

    if($event_multi_id>0)
    {
        $event_url=$obj_base_path->base_path()."/eventPage/".$event_id; 
    }
    else 
    {
       $event_url=$obj_base_path->base_path()."/event/".$event_id; 
    }
    //else if($event_multi_id!="" || $event_multi_id!=null)
    //{
    //   $event_url=$obj_base_path->base_path()."/event/".$event_id; 
    //}

//echo $event_url;

$allEmail = $_POST['email'];
$email_arr=explode(',',$allEmail);
    if($_SESSION['langSessId']=='eng')
        {
            $body = str_replace("Hi,", "Hi, <br/>", $_POST['body']);
            $body = str_replace($user_name,"<br/>".$user_name."<br/>", $body);
        }
    else
        {
            $body = str_replace("Hola,", "Hola, <br/>", $_POST['body']);
            $body = str_replace($user_name,"<br/>".$user_name."<br/>", $body);
        }
        //echo "b= ".$body;
        //exit();
$message = $_POST['message'];

foreach($email_arr as $email)
{
   //echo "<br/>to_email= ".$email;
$recipient = $email;
//$subject = "Invitation For "." ".$event_name ;
$subject = "Invitation For $event_name" ;
$msg = $body."<br/>".$message."<a href=".$event_url."> Click here for more details about $event_name.</a> or copy this url ".$event_url." into your browser address bar.";
$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$formName . "\r\n";
	//$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	@mail($recipient, $subject, $msg, $headers);
	//@mail('kpasapp@gmail.com', $subject, $message, $headers);
	//@mail('unified.subhrajyoti@gmail.com', $subject, $message, $headers);

}
echo "Your invitation sent..";
?>