<?php
//include('../include/user_inc.php');
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

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
$sender_email=$obj_user->f('email');
//echo $sender_email;

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
            $body1 = str_replace("Hi,", "Hi, <br/>", $_POST['body']);
	    $body2 = str_replace($event_name, "<a href='$event_url'>$event_name</a>", $body1);
            $body = str_replace($user_name,"<br/>".$user_name."<br/>",$body2);
        }
    else
        {
            $body1 = str_replace("Hola,", "Hola, <br/>", $_POST['body']);
	    $body2 = str_replace($event_name, "<a href='$event_url'>$event_name</a>", $body1);
            $body = str_replace($user_name,"<br/>".$user_name."<br/>",$body2);
        }
        //echo "b= ".$body;
        //exit();
$message = htmlentities(stripslashes($_POST['message']));

/*----------------------------------------------this is for the additional message signature--------------------------------------*/
    if($_SESSION['langSessId']=='eng')
       {
	$static_msg="<br/>Click here for more details about <a href=".$event_url.">  $event_name </a> or copy this url ".$event_url." into your browser address bar.<br/><br/>For ".$user_name."<br/> The team at KPasapp.com <br/><a href=".$obj_base_path->base_path().">".$obj_base_path->base_path()."</a>";
       }
       else
       {
	$static_msg="<br/>Haga clic aquí para ver más detalles acerca de <a href=".$event_url.">   $event_name </a> o copiar esta url ".$event_url." en la barra de direcciones de su navegador.<br/><br/>Por ".$user_name."<br/> El equipo en KPasapp.com <br/><a href=".$obj_base_path->base_path().">".$obj_base_path->base_path()."</a>";
        
       }
/*----------------------------------------------this is for the additional message signature--------------------------------------*/

foreach($email_arr as $email)
{
   //echo "<br/>to_email= ".$email;
$recipient = $email;
//$subject = "Invitation For "." ".$event_name ;
$subject = "Invitation For $event_name" ;
$msg = $body."<br/>".$message.".$static_msg.";
$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.$formName . "\r\n";
	//$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	//@mail($recipient, $subject, $msg, $headers);
	@mail($recipient, $subject, $msg, $headers,'-f donotreply@kpasapp.com');

}

    if($_SESSION['langSessId']=='eng')
       {
	    echo "Your invitation sent..";
       }
    else
       {
	    echo "Su invitación enviada..";
       }
?>
